<?
if ($gr_id) { // �׷�߼��� ��� ...
    $sql = " select * from $g4[memo_group_table] where gr_id = '$gr_id' ";
    $result = sql_fetch($sql);

    $sql2 = " select count(*) as cnt from $g4[memo_group_member_table] where gr_id = '$gr_id' ";
    $result2 = sql_fetch($sql2);
    $gr_member_count = $result2[cnt];
    
    if ($gr_member_count > 0) {} else alert("�׷� �������� �ƹ��� �����ϴ�.");
    
    $sql3 = " select * from $g4[memo_group_member_table] where gr_id = '$gr_id' ";
    $result3 = sql_query($sql3);
    
    $me_recv_mb_id = "";
    for ($i=0; $row = sql_fetch_array($result3); $i++)
    {
        if ($i+1 < $gr_member_count)
          $me_recv_mb_id .= $row[gr_mb_id] . ",";
        else 
          $me_recv_mb_id .= $row[gr_mb_id];
    }

    $write_header_msg = "( �׷����� :: " . cut_str($result[gr_name], 30) . " :: $gr_member_count ��)";
    
}

if ($option == 'notice') {
    if ($is_admin)
        $write_header_msg = "( <font color='red'><b>���������� ����� �� �����ϴ�. �����ϰ� �ۼ��� �ּ���</b></font> )";
    else {
        $me_recv_mb_id = 'notice';
        alert("���������� �����ڸ� �߼��� �� �ֽ��ϴ�");
    }
}
?>

    <form name="fmemoform" method="post" enctype="multipart/form-data" onsubmit="return fmemoform_submit(this);">
    <input type="hidden" name="me_send_mb_id" value="<?=$member[mb_id]?>" />

    <div class="top"><span class="write">���������� <?=$write_header_msg?></span></div>

    <div class="inner inner_write">
        <ul>
          <? $ss_id = "me_recv_mb_id"; if ($option == 'notice') { // ���������� ��� ?>
            <input type="hidden" name="<?=$ss_id?>" id="<?=$ss_id?>" required="required" itemname="�޴� ȸ�����̵�" value="<?=$me_recv_mb_id?>" />
          <? } else { // ���� ������ �ƴѰ�� ?>
            <li>
                <label>�޴»��</label><a href="javascript:popup_id('fmemoform','<?=$ss_id?>',200,500);" class="find">ȸ���˻�</a>
                <div>
                <input type="text" name="<?=$ss_id?>" id="<?=$ss_id?>" required="required" itemname="�޴� ȸ�����̵�" value="<?=$me_recv_mb_id?>" />
<?
$my_friend = array();
$sql = "select a.fr_id, b.mb_nick
                  from $g4[friend_table] a left join $g4[member_table] b on a.fr_id = b.mb_id 
                  where a.mb_id = '$member[mb_id]'";
$qry = sql_query($sql);
while ($row = sql_fetch_array($qry))
{
    $my_friend[] = $row;
}

if ($config[cf_friend_management] == true and count($my_friend) > 0) {
?>
<select class=quick_move onchange="friend_add(this.value)" >
<option value="">���� ģ����</option>
<option value="">-------------------------</option>
<? for ($i=0; $i<count($my_friend); $i++) {?><option value="<?=$my_friend[$i][fr_id]?>"><?=$my_friend[$i][fr_id]?> - <?=cut_str($my_friend[$i][mb_nick],16)?></option><? } ?>
</select><? } ?>
<script language="JavaScript">
function friend_add(fr_id)
{
  if (fr_id == "") // fr_id ���� ������ return
    return;
    
  if (document.fmemoform.<?=$ss_id?>.value.length > 0) {
    document.fmemoform.<?=$ss_id?>.value = document.fmemoform.<?=$ss_id?>.value + "," + fr_id;
  } else {
    document.fmemoform.<?=$ss_id?>.value = fr_id;
  }
}
</script>
                </div>
            </li>
<? // ���ϴ� ������ ��� ������ ���� ������ ... 
                        if ($me_id) {
                        switch ($me_box) {
                            case 'recv' : $from_table = $g4[memo_recv_table]; break;
                            case 'save' : $from_table = $g4[memo_save_table]; break;
                            default     : alert("me_box ���� �Դϴ�");
                        }
                        $sql = " select me_memo, me_subject, me_send_mb_id from $from_table where me_id = '$me_id' ";
                        $view = sql_fetch($sql);
                        $subject = "Re) " . $view[me_subject];
                        $content = "<br><br>"
                                 . "<br>>  "
                                 . "<br>>  " . preg_replace("/<BR>/", "<BR>>  ", stripslashes($view[me_memo])) 
                                 . "<br>>  "
                                 . "<br>>  ";
/*
                        $content = "\n\n\n>"
                                 . "\n>"
                                 . "\n> " . preg_replace("/\n/", "\n> ", get_text($view[me_memo], 0)) 
                                 . "\n>"
                                 . "\n";
*/
                      } ?>
<? } // ���������� �ƴѰ�� ?>
            <li>
                <label>��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��</label>
                <div><input type="text" name="me_subject" id="me_subject" required="required" value="<?=$subject?>" /></div>
            </li>
            <li>
                <label>��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��</label>
                <div>
                  <? if ($is_dhtml_editor) { ?>
                    <input type="hidden" value="html1" name="html">
                    <? include_once("$g4[path]/lib/cheditor4.lib.php");
                       echo "<script type='text/javascript' src='$g4[cheditor4_path]/comment.js'></script>";
                       echo cheditor1('me_memo', '100%', '300px');
                       echo cheditor2('me_memo', $content); 
                  } else { ?>
                    <textarea name="me_memo" id="me_memo" rows="15" required="required" itemname="����" tabindex="1"><?=$content?></textarea>
                  <? } ?>
                </div>
            </li>
          <? if ($config[cf_memo_use_file]) { ?>
            <li>
                <label>����÷��</label>
                <div>
                <script language="JavaScript"> 
                    function file_change(file) { 
                        document.getElementById("file_name").value = file; } 
                </script>
                    <span id="file_box">
                        <input type="file" id="file" name='memo_file' onchange="file_change(this.value)">
                    </span>
                    <input type="text" id="file_name" name="memo_file_show" id="file_name" disabled="disabled" />
                </div>
            </li><? } ?>
        </ul>
        <div class="btn">
            <input id=btn_submit type=image src="<?=$member_skin_path?>/img/send.gif" alt="������" align="absmiddle" />
            <a href="<?=$memo_url?>?kind=recv"><img src="<?=$member_skin_path?>/img/list.gif" align="absmiddle" /></a>
        </div>
    </div>
    </form>

      <script language="JavaScript">
      <? if ($option != 'notice') { ?>

      with (document.fmemoform) {
          if (me_recv_mb_id.value == "")
              me_recv_mb_id.focus();
      }
      <? } ?>
      
      function fmemoform_submit(f) {
          var s = "";
     
          <?
          if ($is_dhtml_editor) {
              echo cheditor3('me_memo');
              echo "if (!document.getElementById('tx_me_memo').value) { alert('������ �Է��Ͻʽÿ�.'); return; } ";
          }
          ?>
/*
          if (s = word_filter_check(document.getElementById('me_subject').value)) {
              alert("���� �����ܾ�('"+s+"')�� ���ԵǾ��ֽ��ϴ�");
              return;
          }

          if (s = word_filter_check(document.getElementById('me_memo').value)) {
              alert("���뿡 �����ܾ�('"+s+"')�� ���ԵǾ��ֽ��ϴ�");
              return;
          }
*/
          document.getElementById('btn_submit').disabled = true;
          
          <? if ($option == 'notice') {?>
              f.action = "./memo2_form_notice_update.php";
          <? } else { ?>
              f.action = "./memo2_form_update.php";
          <? } ?>

          return true;
      }
      </script>
