<? 
if (!defined("_GNUBOARD_")) exit; // ���� ������ ���� �Ұ�

$g4[title] = "ģ������";

if (! $is_member) alert("ȸ���� ������ �� �ִ� ������ �Դϴ�");

// ����2 ���α׷��� location�� ����
$memo_url = $g4[bbs_path] . "/memo.php";

$sql_from = " $g4[friend_table] ";
$mb_sql_common = " from $sql_from where mb_id = '$member[mb_id]' and fr_type = '' ";
$mb_connect_sql_common = " from $g4[login_table] a left join  $g4[friend_table] b on (a.mb_id = b.fr_id) where a.mb_id != '' and b.mb_id = '$member[mb_id]' ";

$fr_sql_common = " from $sql_from where fr_id = '$member[mb_id]' ";
$black_sql_common = " from $sql_from where mb_id = '$member[mb_id]' and fr_type = 'black_id' ";

$mb_sql = " select count(*) as cnt $mb_sql_common";
$mb_count = sql_fetch($mb_sql);

$mb_connect_sql = " select count(*) as cnt $mb_connect_sql_common";
$mb_connect_count = sql_fetch($mb_connect_sql);

$fr_sql = " select count(*) as cnt $fr_sql_common";
$fr_count = sql_fetch($fr_sql);

$black_sql = " select count(*) as cnt $black_sql_common";
$black_count = sql_fetch($black_sql);

$online_sql = " select count(*) as cnt from $g4[login_table] a left join $g4[member_table] b on (a.mb_id = b.mb_id) where b.mb_id <> '$config[cf_admin]' ";
$online_count = sql_fetch($online_sql);

switch ($fr_type) {
  case 'fr_id'    : $total_count = $fr_count[cnt]; break;
  case 'black_id' : $total_count = $black_count[cnt]; break;
  case 'online'   : $total_count = $online_count[cnt]; break;
  case 'mb_connect' : $total_count = $mb_connect_count[cnt]; break;
  case 'mb_id'    : 
  default         : $total_count = $mb_count[cnt];
}

$one_rows = 10; // ���������� ���μ�
$total_page = ceil($total_count / $one_rows);  // ��ü ������ ��� 
if ($page == "") { $page = 1; } // �������� ������ ù ������ (1 ������) 
$from_record = ($page - 1) * $one_rows; // ���� ���� ����
$to_record = $from_record + $one_rows ;

switch ($fr_type) {
  case 'fr_id'    : $sql = " select * $fr_sql_common order by fr_datetime desc limit $from_record, $one_rows"; $subj = "���� ģ���� ����� ���"; break;
  case 'black_id' : $sql = " select * $black_sql_common order by fr_datetime desc limit $from_record, $one_rows"; $subj = "���� ������Ʈ�� ��ϵ� �����"; break;
  case 'online'   : $sql = " select a.mb_id, b.mb_nick, b.mb_name, b.mb_email, b.mb_homepage, b.mb_open, b.mb_point, b.mb_today_login from $g4[login_table] a left join $g4[member_table] b on (a.mb_id = b.mb_id) where b.mb_id <> '$config[cf_admin]' order by mb_id desc limit $from_record, $one_rows "; $subj = "�������� ȸ����"; break;
  case 'mb_connect' : $sql = " select * $mb_connect_sql_common order by fr_datetime desc limit $from_record, $one_rows"; $subj = "�������� ���� ģ����"; break;
  case 'mb_id'    : 
  default         : $sql = " select * $mb_sql_common order by fr_datetime desc limit $from_record, $one_rows"; $subj = "���� ģ����";
}

$result = sql_query($sql);

echo "<script language='javascript' src='$g4[path]/js/sideview.js'></script>"; // ����Ʈ�䰡 ���̵���
?>

<script type="text/javascript">
<!-- // ȸ��ID ã��  
function popup_id(frm_name, ss_id, top, left)
{
    url = '<?=$g4[bbs_path]?>/write_id.php?frm_name='+frm_name+'&ss_id='+ss_id;
    opt = 'scrollbars=yes,width=320,height=470,top='+top+',left='+left;
    window.open(url, "write_id", opt);
}
//-->
</script>

<? 
$cols = 7; 
$fr_width = '100%'; // ģ�������� ��
$ss_id = 'fr_id'; // ���� ���̵� �����ϴϱ� ������ ���ܼ� ��¿ �� ����... ��..��
?>

<style type="text/css">
<!--
.style5 {
	color: #333333;
	font-weight: bold;
}
.style6 {color: #f36823}
.style7 {color: #0c4473}
.style8 {
	font-size: 11px;
	color: #444444;
}
.style9 {color: #0a4fa3}
.style10 {color: #666666;font-weight: bold}
-->
</style>

<!-- ģ������ ���� -->
<table width="<?=$fr_width?>" height="30" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="14">&nbsp;</td>
        <td width="25"><img src="<?=$memo_skin_path?>/img/memo_icon05.gif" width="19" height="19" /></td>
        <td ><span class="style5">ģ������</span> :: <?=$subj?> ::</td>
    </tr>
</table>

<table width="<?=$fr_width?>" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="5" background="<?=$memo_skin_path?>/img/memo_box2_tl.gif"></td>
    <td width="" background="<?=$memo_skin_path?>/img/memo_line2_top.gif"></td>
    <td width="5" background="<?=$memo_skin_path?>/img/memo_box2_tr.gif"></td>
  </tr>
  <tr>
    <td width="5" background="<?=$memo_skin_path?>/img/memo_line2_left.gif">&nbsp;</td>
    <td align="center">
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="50">
                <font style="font-size:9pt;">
                �� ģ�� <b><a href='<?=$memo_url?>?kind=online&fr_type=mb_id'>
                <?=$mb_count[cnt]?>��</a></b> (������<b> <a href='<?=$_SERVER[PHP_SELF]?>?kind=online&fr_type=mb_connect'><?=$mb_connect_count[cnt]?>��</a/></b>), 
                ���� �� <b><a href='<?=$memo_url?>?kind=online&fr_type=fr_id'>
                <?=$fr_count[cnt]?>��</a></b>, 
                ������Ʈ <b><a href='<?=$memo_url?>?kind=online&fr_type=black_id'>
                <?=$black_count[cnt]?>��</a></b>,
                ���������� <b><a href='<?=$memo_url?>?kind=online&fr_type=online'>
                <?=$online_count[cnt]?>��</a></b>                
                </font></td>
      </tr>
      <tr>
          <td height="1"  bgcolor="#d9d9d9"></td>
      </tr>   
      </table>
      <table width="98%" border="0" cellpadding="0" cellspacing="0">
        <colgroup width="30">
        </colgroup>
        <colgroup width="50">
        </colgroup>
        <colgroup width="100">
        </colgroup>
        <colgroup width=''>
        </colgroup>
        <colgroup width="40">
        </colgroup>
        <colgroup width="80">
        </colgroup>
        <tr>
          <td colspan="<?=$cols?>" height="2"></td>
        </tr>
        <form name='friendlist' id="friendlist" method='post' onsubmit="return friendlist_submit(this);">
          <input type="hidden" class="ed" name="fr_edit" value="<?=$fr_edit?>" />
          <tr>
            <td height="20"></td>
            <td width="75" align="center"><strong>���̵�</strong></td>
            <td width="120" align="center"><strong>�� ��</strong></td>
            <td align="center"><strong>�� �� </strong></td>
            <td width="60" align="center"><strong>����</strong></td>
            <td width="60" align="center"><strong>�����</strong></td>
          </tr>
          <tr>
            <td height="3"></td>
          </tr>
          <tr>
            <td colspan="<?=$cols?>"  height="1" bgcolor="#d9d9d9"></td>
          </tr>
          <tr>
            <td height="7"></td>
          </tr>
          <?//���
  for ($i=0; $row = sql_fetch_array($result); $i++) { // Join �Ǵ� �˻����� ���� �ʰ� ������ member ������ fetch �ϴ� ���� ȿ�� ����
    switch ($fr_type) {
        case 'online'   : 
        case 'fr_id'    : $mb = get_member($row[mb_id]); 
                          break;
        case 'black_id' :
        case 'mb_id'    :
        default         : $mb = get_member($row[fr_id]);
    }
?>
          <tr>
            <td height="20">
              <? if ($fr_type == 'online') { ?>
                <input type="checkbox" name="chk_fr_no[]" value="<?=$row[mb_id]?>" />
              <? } else { ?>
                <input type="checkbox" name="chk_fr_no[]" value="<?=$row[fr_no]?>" />
                <? } ?>
            </td>
            <td width="75" align="center"><span class="style7">
              <?=$mb[mb_id]?>
            </span></td>
            <td width="120" align="center"><?=get_sideview($mb[mb_id], $mb[mb_nick], $mb[mb_email], $mb[mb_homepage]); ?>
                <? 
          if ($fr_type == 'fr_id') {
              //$sql1 = " select count(*) as cnt from (select * from $sql_from where fr_type != 'black_id') a 
              //    where (mb_id = '$member[mb_id]' and fr_id = '$row[mb_id]') or (mb_id = '$row[mb_id]' and fr_id = '$member[mb_id]') ";  
              $sql1 = " select count(*) as cnt from $sql_from 
                  where fr_type != 'black_id' and (mb_id = '$member[mb_id]' and fr_id = '$row[mb_id]') or (mb_id = '$row[mb_id]' and fr_id = '$member[mb_id]') ";  
          }
          else if ($fr_type == 'black_id') {} 
          else {
              //$sql1 = " select count(*) as cnt from (select * from $sql_from where fr_type != 'black_id') a 
              //    where (mb_id = '$member[mb_id]' and fr_id = '$row[fr_id]') or (mb_id = '$row[fr_id]' and fr_id = '$member[mb_id]') ";
              $sql1 = " select count(*) as cnt from $sql_from
                  where fr_type != 'black_id' and (mb_id = '$member[mb_id]' and fr_id = '$row[fr_id]') or (mb_id = '$row[fr_id]' and fr_id = '$member[mb_id]') ";
          }
          if ($sql1 ) $result1 = sql_fetch($sql1);
          if ($result1[cnt] == 2) echo " <img src='$memo_skin_path/img/icon_friends.gif' align='absmiddle'> ";
    ?>            </td>
            <td align="center"><span class="style10">
              <? if ($fr_type == 'fr_id' or $fr_type== 'online') {} else echo get_text(stripslashes($row[fr_memo])); // ģ������ ���� �߰��ϸ鼭 �ۼ��� �޸�� �� �� ����?>
              </span>
              <? 
                if ($fr_type == 'fr_id' or $fr_type == 'online') {}
                else {
                    echo "&nbsp;&nbsp;<a href=\"javascript:memo_box('{$row[fr_no]}')\"><img src='$memo_skin_path/img/btn_c_modify.gif' border='0' align='absmiddle'></a>";
                }
              ?>
              <span id='memo_<?=$row[fr_no]?>' style='display:none;'>
              <input type="type" class="ed" name="fr_edit_<?=$row[fr_no]?>" size="25" value="<?=preg_replace("/\"/", "&#034;", stripslashes(get_text($row[fr_memo],0)))?>" />
              <a href='javascript:memo_update(<?=$row[fr_no]?>)'><img src='<?=$memo_skin_path?>/img/btn_c_ok.gif' border='0'/></a> </span> </td>
            <td width="60" align="center">
                <?
                  if ($fr_type == 'fr_id') {
                      $sql2 = " select count(*) as cnt 
                                 from $g4[login_table] a left join $g4[member_table] b on (a.mb_id = b.mb_id)
                                 where a.mb_id = '$row[mb_id]' ";
                      $result2 = sql_fetch($sql2);
                      $sql3 = " select mb_today_login from $g4[member_table]
                                 where mb_id = '$row[mb_id]' and mb_open = 1 ";
                      $result3 = sql_fetch($sql3);
                      if ($result3[mb_today_login] =='') $last_datetime = "���� �����"; else $last_datetime = $result3[mb_today_login];
                  }
                  else {
                      $sql2 = " select count(*) as cnt 
                                 from $g4[login_table] a left join $g4[member_table] b on (a.mb_id = b.mb_id)
                                 where a.mb_id = '$row[fr_id]' ";
                      $result2 = sql_fetch($sql2);
                      $sql3 = " select mb_today_login from $g4[member_table]
                                 where mb_id = '$row[fr_id]' and mb_open = 1 ";
                      $result3 = sql_fetch($sql3);
                      if ($result3[mb_today_login] =='') $last_datetime = "���� �����"; else $last_datetime = $result3[mb_today_login];
                  }
                  if ($result2[cnt] > 0 or $fr_type =='online') 
                      echo "<img src='$memo_skin_path/img/friend_on.gif' align='absmiddle' alt='$last_datetime'>";
                  else {
                      echo "<img src='$memo_skin_path/img/friend_off.gif' align='absmiddle' alt='$last_datetime'>";
                  }
                ?>
            </td>
            <td width="60" align="center"><span class="style8">
              <?=cut_str($row[fr_datetime],10,'')?>
            </span></td>
          </tr>
          <tr>
            <td height="3"></td>
          </tr>
          <? } ?>
        </form>
        <tr>
          <td height="1" colspan="<?=$cols?>" bgcolor="#d9d9d9"></td>
        </tr>
        <tr>
          <td height="10" colspan="<?=$cols?>"></td>
        </tr>
        <? if ($total_page > 0) { ?>
        <tr>
          <td colspan="<?=$cols?>" >
          <?
            $page = get_paging($config[cf_write_pages], $page, $total_page, "?fr_type=$fr_type&page="); 
            echo "$page";
         ?>
          </td>
        </tr>
        <tr>
          <td height="10" colspan="<?=$cols?>"></td>
        </tr>
        <? } ?> 
        <? if ($fr_type == 'fr_id') { ?>
        <tr>
          <td height="25" colspan="<?=$cols?>"><a href="javascript:select_update();">ģ�����</a>&nbsp;&nbsp; 
          <a href="javascript:select_black();">������Ʈ ���</a> 
          </td>
        </tr>
        <? } else if ($fr_type == 'online') { ?>
        <tr>
          <td height="25" colspan="<?=$cols?>"><a href="javascript:select_update();">ģ�����</a>&nbsp;&nbsp; 
          </td>
        </tr>
        <? } else if ($fr_type == 'black_id') { ?>
        <tr>
          <td height="25" colspan="<?=$cols?>"><a href="javascript:select_delete();">������Ʈ ����</a> </td>
        </tr>
        <? } else { ?>
        <tr>
          <td height="25" colspan="<?=$cols?>"><a href="javascript:select_delete();">ģ������</a> </td>
        </tr>
        <? } ?>
      </table></td>
    <td width="5" background="<?=$memo_skin_path?>/img/memo_line2_right.gif">&nbsp;</td>
  </tr>
  <tr>
    <td height="5" background="<?=$memo_skin_path?>/img/memo_box2_dl.gif"></td>
    <td background="<?=$memo_skin_path?>/img/memo_line2_down.gif"></td>
    <td background="<?=$memo_skin_path?>/img/memo_box2_dr.gif"></td>
  </tr>
</table>

<table width="<?=$fr_width?>" border="0" cellpadding="0" cellspacing="0" bgcolor="ededed">
  <tr>
    <td height="10" colspan="3" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td width="5" height="5" background="<?=$memo_skin_path?>/img/memo_box4_tl.gif"></td>
    <td width=""></td>
    <td width="5" background="<?=$memo_skin_path?>/img/memo_box4_tr.gif"></td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center">
      <table width="98%" border="0" cellpadding="0" cellspacing="0">
      <colgroup width="180"></colgroup>
      <colgroup width="50"></colgroup>
      <colgroup width=""></colgroup>
      <colgroup width=""></colgroup>
      <? if ($fr_type == 'black_id') { ?>
      <tr>
        <td height="20" colspan="4" class="style5" style="padding-left:5px;">          ������Ʈ ����ϱ�</td>
      </tr>
      <? } else { ?>
      <tr>
        <td height="20" colspan="4" class="style5" style="padding-left:5px;">          ���ο� ģ�� ����ϱ�</td>
      </tr>
      <? } ?>
      <tr>
        <td colspan="4" height="1" bgcolor="#dcdcdc"></td>
      </tr>
      <tr>
        <td height="10"></td>
      </tr>
      <form name='fr_register' id="fr_register" method='post' onsubmit="return fr_register_submit(this);" enctype="multipart/form-data" autocomplete="off" >
        <input type="hidden" class="ed" name="mb_id" value="<?=$member[mb_id]?>" />
        <input type="hidden" class="ed" name="fr_type" value="<?=$fr_type?>" />

        <tr class='ht center'>
          <td>���̵� : 
            <input name='<?=$ss_id?>' type="text" class="ed" size="10" required="required" itemname='ģ�����̵�' />
            &nbsp;<a href="javascript:popup_id('fr_register','<?=$ss_id?>',300,500);"><img src='<?=$memo_skin_path?>/img/friend_search.gif' border="0" align="absmiddle" /></a> </td>
          <td align="right">�޸� : </td>
          <td align=left >&nbsp;<input name="fr_memo" type="text" class="ed" itemname='�޸�' size="24" /></td>
          <? if ($fr_type == 'black_id') { ?>
          <td >&nbsp;<input type="submit" class="btn1" value='������Ʈ' /></td>
          <? } else { ?>
          <td >&nbsp;<input type="submit" class="btn1" value='ģ�����' /></td>
          <? } ?>
        </tr>
      </form>
    </table></td>
    <td width="5">&nbsp;</td>
  </tr>
  <tr>
    <td height="5" background="<?=$memo_skin_path?>/img/memo_box4_dl.gif"></td>
    <td></td>
    <td background="<?=$memo_skin_path?>/img/memo_box4_dr.gif"></td>
  </tr>
</table>

<script language="JavaScript">
function fr_register_submit(f)
{
    f.action = "<?=$memo_skin_path?>/friend_update.php";
    return true;
}

var save_before = '';
function check_confirm(str) {
    var f = document.friendlist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_fr_no[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(str + "�� ģ���� �Ѹ� �̻� �����ϼ���.");
        return false;
    }
    return true;
}

// ������ ģ�� ����
function select_delete() {
    var f = document.friendlist;

    str = "����";
    if (!check_confirm(str))
        return false;

    if (!confirm("������ ģ���� ���� "+str+" �Ͻðڽ��ϱ�?\n\n"))
        return false;

    f.action = "<?=$memo_skin_path?>/friend_delete.php";
    return true;
}

// ������ ģ�� �߰�
function select_update() {
    var f = document.friendlist;

    str = "�߰�";
    if (!check_confirm(str))
        return false;

    if (!confirm("������ ģ���� ���� "+str+" �Ͻðڽ��ϱ�?\n\n"))
        return false;

    f.action = "<?=$memo_skin_path?>/friend_update.php?fr_type=<?=$fr_type?>";
    return true;
}

// ������ ģ�� �� ����Ʈ�� �߰�
function select_black() {
    var f = document.friendlist;

    str = "������Ʈ�� �߰�";
    if (!check_confirm(str))
        return false;

    if (!confirm("������ ģ���� ���� "+str+" �Ͻðڽ��ϱ�?\n\n"))
        return false;

    f.action = "<?=$memo_skin_path?>/friend_update.php?fr_type=black_id";
    return true;
}

function memo_box(memo_id)
{
    var el_id;

    el_id = 'memo_' + memo_id;

    if (save_before != el_id) {
      
        if (save_before)
        {
            document.getElementById(save_before).style.display = 'none';
        }

        document.getElementById(el_id).style.display = 'block';
        save_before = el_id;
    }
}

// ������ �޸� ������Ʈ
function memo_update(fr_no) {
    var f = document.friendlist;
    var el_id;

    el_id = 'fr_edit_' + fr_no;
    document.getElementById('fr_edit').value = document.getElementById(el_id).value;
    f.action = "<?=$memo_skin_path?>/friend_memo_update.php?fr_no=" + fr_no + "&fr_type=<?=$fr_type?>";
    return true;
}
</script>

