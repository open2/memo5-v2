<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!$is_member) 
    alert_close("ȸ���� ���Ӱ����� ȭ�� �Դϴ�");

$sname = preg_replace('/\%/', '', strip_tags($sname));

if ($sname) {

    // ȸ���˻��� �߿��� ����̹Ƿ� stamp�� ���ܵӴϴ�.
    $tmp_point = ($member[mb_point] > 0) ? $member[mb_point] : 0;
    if ($tmp_point + $config[cf_memo_send_point] < 0 && !$is_admin)
        alert("�����Ͻ� ����Ʈ(".number_format($member[mb_point]).")�� ���ų� ���ڶ� ȸ���˻�(".number_format($config[cf_memo_send_point]).")�� �Ұ��մϴ�.\\n\\n����Ʈ�� �����Ͻ� �� �ٽ� �� �ֽʽÿ�.");
    insert_point($member[mb_id], $config[cf_memo_send_point], "����5 ģ��ã�� - $sname", 'ģ��ã��', $g4[time_ymdhis], '����5');
  
    switch ($sfl) {
      case "mb_nick" : $search_sql = " mb_nick like '%$sname%' "; 
                       $order_sql = " order by mb_nick"; break;
      case "mb_name" : $search_sql = " mb_name like '%$sname%' "; 
                       $order_sql = " order by mb_name"; break;
      case "mb_id"   : $search_sql = " mb_id like '%$sname%' "; 
                       $order_sql = " order by mb_id"; break;
      case "mb_all"  : 
      default        :
                       $search_sql = " mb_nick like '%$sname%' or mb_id like '%$sname%' or mb_name like '%$sname%' "; 
                       $order_sql = " order by mb_id"; break;
    }

    $sql = " select count(*) as cnt from $g4[member_table] where ( mb_leave_date = '' and mb_nick != '[������]' ) and ( $search_sql ) ";
    $result = sql_fetch($sql);
    $total_count = $result['cnt'];

    // guess work�� ���� ���ؼ� �ִ� ����� ������ - ȸ���� ���� ����Ʈ������ ���� ������ �ʼ�
    if ($total_count > $g4['memo_max_friend'] && $is_admin !== "super")
        $total_count = $g4['memo_max_friend'];

    $one_rows = 10; // ���������� ���μ�
    $total_page  = ceil($total_count / $one_rows);  // ��ü ������ ��� 
    if ($page == "") { $page = 1; } // �������� ������ ù ������ (1 ������) 
    $from_record = ($page - 1) * $one_rows; // ���� ���� ����
    $to_record = $from_record + $one_rows ;

    $sql = " select * from $g4[member_table] where ( mb_leave_date = '' and mb_nick != '[������]' )and ( $search_sql ) $order_sql limit $from_record, $one_rows";
    $result = sql_query($sql);
    $search_count = mysql_num_rows($result);
    if ($search_count > 0) {
        for ($i=0; $row=mysql_fetch_array($result); $i++) {
            $list[$i]->id = "$row[mb_id]";
            $list[$i]->name = $row['mb_name'];
            $list[$i]->nick = $row['mb_nick'];
            $list[$i]->mb_open = $row['mb_open'];
        }
    } else {
        alert("ã���ô� ȸ�������� �����ϴ�.");
    }
    mysql_free_result($result);
}

// �����ڴ� �ּ� 1���ں��� �˻� �����ϰ�
if ($is_admin == "super")
    $minlength=1;
else
    $minlength=3;

$g4[title] = "�����ID �˻�";
include_once("$g4[path]/head.sub.php");
?>

<table width=100% border=0 cellspacing=0 cellpadding=0>
<form name=frmid method=get autocomplete=off>
<input type=hidden name=frm_name value='<?=$frm_name?>'>
<input type=hidden name=ss_id value='<?=$ss_id?>'>
<tr>
  <td width=14 bgcolor="eeeeee"></td>
  <td height=30 colspan=2 valign=bottom bgcolor="eeeeee"><table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="25"><img src="<?=$g4[bbs_img_path]?>/memo_icon07.gif" width="19" height="19" /></td>
      <td><span style="color: #333333;font-weight: bold;">ģ��ã��</span>&nbsp;&nbsp;&nbsp;(<?=number_format($config[cf_memo_send_point])?> ����Ʈ�� �����մϴ�)</td>
    </tr>
  </table></td>
</tr>
<tr>
  <td height="2" colspan="3" bgcolor="#d9d9d9"></td>
</tr>
<tr>
  <td height="3" colspan="3"></td>
  </tr>
<tr>
    <td></td>
    <td height=20 colspan=2 valign=bottom>ȸ�������� �Է��ϼ��� <? if ($is_admin !== "super") { ?>(3�� �̻�)<? } ?></td>
</tr>

<tr>
  <td height="5" colspan="3"></td>
  </tr>
<tr>
    <td></td>
    <td width=1></td>
    <td>
    <select name=sfl>
      <option value='mb_all'>��+�̸�+���̵�</option>
      <option value='mb_nick'>�г���</option>
      <option value='mb_name'>�̸�</option>
      <option value='mb_id'>���̵�</option>
    </select>
    <input type=text name=sname value='<?=$sname?>' required <?=$min_length?> itemname='ȸ���̸�' size=14> <input type=image src='<?=$g4[bbs_img_path]?>/search.gif' border=0 align=absmiddle></td>
</tr>
<tr>
  <td height=10 colspan=3></td>
</tr>
</table>

<!-- �˻���� ���⼭���� -->
<script type="text/javascript">
    document.frmid.sname.focus();
</script>

<? if ($search_count > 0) { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td width="20"></td>
    <td>
        <table width=100% cellpadding=0 cellspacing=0>
        <tr>
            <td height=23 valign=top colspan=2><b>�� <?=$total_count?>��</b> (���̵�/�г����� ������ ���õ˴ϴ�)</td>
        </tr>
        </table>
        <table width=100% cellpadding=0 cellspacing=0>
        <colgroup width="100">
        </colgroup>
        <colgroup width="">
        </colgroup>
        <colgroup width="50">
        </colgroup>
        <tr>
          <td height=2 align="center" bgcolor="d9d9d9"  colspan=3></td>
        </tr>
        <tr>
            <td height=23 >���̵�</td><td>�г���</td><td>��������</td>
        </tr>        
        <tr>
          <td height=2 align="center" bgcolor="d9d9d9"  colspan=3></td>
        </tr>
        <?
        for ($i=0; $i<count($list); $i++)
        {
            echo "
            <tr>
            <td height=25>
            <a href=javascript:setid('{$list[$i]->name}','{$list[$i]->id}')>{$list[$i]->id}</a>
            </td>
            <td>
            <a href=javascript:setid('{$list[$i]->name}','{$list[$i]->id}')>{$list[$i]->nick}</a>
            </td>";
            if ($list[$i]->mb_open == 1 || $is_admin == "super") 
                $msg = "<a href=\"javascript:;\" onclick=\"win_profile('" . $list[$i]->id . "')\">��������</a>";
            else 
                $msg = "�����";
            echo "
            <td>{$msg}</td>";
            echo "
            </tr>
            <tr><td height=1 bgcolor=b4c9dd  colspan=3></td></tr>\n";
        }
        ?>
        <tr>

        </table>

        <table width=100% cellpadding=0 cellspacing=0>        
        <tr>
          <td height=10 align="center"></td>
        </tr>
        <tr>
          <td>
          <? 
            $page = get_paging($config[cf_write_pages], $page, $total_page, "?frm_name=$frm_name&ss_id=$ss_id&sname=$sname&sfl=$sfl&page=");
            echo "$page";
          ?> 
          </td>
        </tr>
        <tr>
          <td height=10 align="center"></td>
        </tr>
        <tr>
            <td height=23 align="center">
            <a href="javascript:window.close();"><img src="<?=$g4[bbs_img_path]?>/close.gif" border="0" /></a>
            </td>
        </tr>
        </table>
    <td width="20">    
</tr></form>
</table>
<? } ?>

<script type="text/javascript">

    if ('<?=$sfl?>') document.frmid.sfl.value = '<?=$sfl?>'; 

    function setid(sname, sid)
    {
        var ov = top.opener.document.<?=$frm_name?>.<?=$ss_id?>.value;
        var of = top.opener.document.<?=$frm_name?>.<?=$ss_id?>;

		if(ov.length>0) {
			of.value = ov + "," + sid;
		}else{
        	of.value  = sid;
		}

		top.opener.focus();
        top.close();
        return false;
    }
</script>

<?
include_once("$g4[path]/tail.sub.php");
?>