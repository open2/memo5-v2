<?
if (!defined("_GNUBOARD_")) exit; // ���� ������ ���� �Ұ�

$g4[title] = "�޸�׷� �������";

if (! $is_member) alert("ȸ���� ������ �� �ִ� ������ �Դϴ�");

// ����2 ���α׷��� location�� ����
$memo_url = $g4[bbs_path] . "/memo.php";

if ($gr_id =="") // gr_id�� ������ �׷� ������ �̵�...
        alert("�޸�׷��� �������� �ʾҽ��ϴ�.", "$g4[bbs_path]/memo.php?kind=memo_group_admin");
    
$sql = " select * from $g4[memo_group_table] where gr_id = '$gr_id' and mb_id = '$member[mb_id]' ";
$result = sql_fetch($sql);

if ($result[gr_name] == '')
    alert("�޸�׷��� �������� �ʾҽ��ϴ�.", "$g4[bbs_path]/memo.php?kind=memo_group_admin");
else
    $gr_name = $result[gr_name];
    
$sql = " select count(*) as cnt from $g4[memo_group_member_table] where gr_id = '$gr_id' ";
$result = sql_fetch($sql);
$total_count = $result[cnt];

$one_rows = 10; // ���������� ���μ�
$total_page = ceil($total_count / $one_rows);  // ��ü ������ ��� 
if ($page == "") { $page = 1; } // �������� ������ ù ������ (1 ������) 
$from_record = ($page - 1) * $one_rows; // ���� ���� ����
$to_record = $from_record + $one_rows ;

$sql = " select * from $g4[memo_group_member_table] where gr_id = '$gr_id' order by gr_mb_id desc limit $from_record, $one_rows";
$result = sql_query($sql);

echo "<script language='javascript' src='$g4[path]/js/sideview.js'></script>"; // ���̵�䰡 ���̵���
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
$fr_width = 490; // ���̺��� ��
$ss_id = 'gr_mb_id'; // ���� ���̵� �����ϴϱ� ������ ���ܼ� ��¿ �� ����... ��..��
?>

<table width="<?=$fr_width?>" height="30" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="14">&nbsp;</td>
        <td width="25"><img src="img/memo_icon05.gif" width="19" height="19" /></td>
        <td ><span class="style5"><a href="<?=$memo_url?>?kind=memo_group_admin">�׷����</a></span> :: �׷��̸� :: <?=$gr_name?></td>
    </tr>
</table>


<table width="<?=$fr_width?>" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="5" background="img/memo_box2_tl.gif"></td>
    <td width="" background="img/memo_line2_top.gif"></td>
    <td width="5" background="img/memo_box2_tr.gif"></td>
  </tr>
  <tr>
    <td width="5" background="img/memo_line2_left.gif">&nbsp;</td>
    <td align="center">
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="50">
                <font style="font-size:9pt;">
                �׷� ����� <b><?=$total_count?>��</b> �Դϴ�.      
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
        <colgroup width="80">
        </colgroup>
        <colgroup width="">
        </colgroup>
        <colgroup width="80">
        </colgroup>
        <colgroup width="80">
        </colgroup>
        <tr>
          <td colspan="<?=$cols?>" height="2"></td>
        </tr>
        <form method="post" name="friendlist" id="friendlist">
        <input type="hidden" class="ed" name="gr_id" value="<?=$gr_id?>" />
          <tr>
            <td height="20"></td>
            <td align="center"><strong>no.</strong></td>
            <td align="center"><strong>���̵�</strong></td>
            <td align="center"><strong>�� ��</strong></td>
            <td align="center"><strong>����</strong></td>
            <td align="center"><strong>�����</strong></td>
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
              $mb = get_member($row[gr_mb_id]); 
          ?>
          <tr>
            <td height="20">
                <input type="checkbox" name="chk_fr_no[]" value="<?=$row[gr_mb_no]?>" />
            </td>
            <td align="center"><span class="style7">
            <?=$i+1?>
            </span></td>
            <td align="center"><span class="style7">
              <?=$mb[mb_id]?>
            </span></td>
            <td align="center"><?=get_sideview($mb[mb_id], $mb[mb_nick], $mb[mb_email], $mb[mb_homepage]); ?>
            </td>
            <td align="center">
                <?
                $sql2 = " select count(*) as cnt 
                             from $g4[login_table] a left join $g4[member_table] b on (a.mb_id = b.mb_id)
                             where a.mb_id = '$row[gr_mb_id]' ";
                $result2 = sql_fetch($sql2);
                $sql3 = " select mb_today_login from $g4[member_table]
                           where mb_id = '$row[gr_mb_id]' and mb_open = 1 ";
                $result3 = sql_fetch($sql3);
                if ($result3[mb_today_login] =='') $last_datetime = "���� �����"; else $last_datetime = $result3[mb_today_login];
                if ($result2[cnt] > 0 or $fr_type =='online') 
                    echo "<img src='$memo_skin_path/img/friend_on.gif' align='absmiddle' alt='$last_datetime'>";
                else {
                    echo "<img src='$memo_skin_path/img/friend_off.gif' align='absmiddle' alt='$last_datetime'>";
                }
                ?>
            </td>
            <td align="center"><span class="style7">
              <?=cut_str($row[gr_mb_datetime],10,'')?>
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
            $page = get_paging($config[cf_write_pages], $page, $total_page, "?kind=memo_group&gr_id=$gr_id&page="); 
            echo "$page";
         ?>
          </td>
        </tr>
        <tr>
          <td height="10" colspan="<?=$cols?>"></td>
        </tr>
        <? } ?> 
        
        <tr>
          <td height="25" colspan="<?=$cols?>"><a href="javascript:select_delete_gr_member();">�������</a> </td>
        </tr>
      </table></td>
    <td width="5" background="img/memo_line2_right.gif">&nbsp;</td>
  </tr>
  <tr>
    <td height="5" background="img/memo_box2_dl.gif"></td>
    <td background="img/memo_line2_down.gif"></td>
    <td background="img/memo_box2_dr.gif"></td>
  </tr>
</table>

<table width="<?=$fr_width?>" border="0" cellpadding="0" cellspacing="0" bgcolor="ededed">
  <tr>
    <td height="10" colspan="3" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td width="5" height="5" background="img/memo_box4_tl.gif"></td>
    <td width=""></td>
    <td width="5" background="img/memo_box4_tr.gif"></td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center">
      <table width="98%" border="0" cellpadding="0" cellspacing="0">
      <colgroup width="180"></colgroup>
      <colgroup width="50"></colgroup>
      <colgroup width=""></colgroup>
      <tr>
        <td height="20" colspan="4" class="style5" style="padding-left:5px;">          ���ο� ��� ����ϱ�</td>
      </tr>
      <tr>
        <td colspan="3" height="1" bgcolor="#dcdcdc"></td>
      </tr>
      <tr>
        <td height="10"></td>
      </tr>
      <form name="fr_register" action="javascript:gr_register_submit(document.fr_register);" method="post" enctype="multipart/form-data" autocomplete="off" >
        <input type="hidden" class="ed" name="mb_id" value="<?=$member[mb_id]?>" />
        <input type="hidden" class="ed" name="gr_id" value="<?=$gr_id?>" />

        <tr class='ht center'>
          <td>���̵� : 
            <input name='<?=$ss_id?>' type="text" class="ed" size="10" required="required" itemname='ģ�����̵�' />
            &nbsp;<a href="javascript:popup_id('fr_register','<?=$ss_id?>',300,500);"><img src='<?=$memo_skin_path?>/img/friend_search.gif' border="0" align="absmiddle" /></a> </td>
          <td >&nbsp;<input type="submit" class="btn1" value='������' /></td>
        </tr>
      </form>
    </table></td>
    <td width="5">&nbsp;</td>
  </tr>
  <tr>
    <td height="5" background="img/memo_box4_dl.gif"></td>
    <td></td>
    <td background="img/memo_box4_dr.gif"></td>
  </tr>
</table>

<script language="JavaScript">
function gr_register_submit(f)
{
    f.action = "<?=$memo_skin_path?>/memo2_group_member_update.php";
    f.submit();
}

var save_before = '';
function check_confirm_gr_member(str) {
    var f = document.friendlist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_fr_no[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(str + "�� ����� �Ѹ� �̻� �����ϼ���.");
        return false;
    }
    return true;
}

// ������ ��� ����
function select_delete_gr_member() {
    var f = document.friendlist;

    str = "����";
    if (!check_confirm_gr_member(str))
        return;

    if (!confirm("������ ����� ���� "+str+" �Ͻðڽ��ϱ�?\n\n"))
        return;

    f.action = "<?=$memo_skin_path?>/memo2_group_member_delete.php";
    f.submit();
}

</script>

<form method="post" name="fboardlist" id="fboardlist">
</form>