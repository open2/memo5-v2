<?
if (!defined("_GNUBOARD_")) exit; // ���� ������ ���� �Ұ� 
?>

<form name=fmemoform method=post enctype='multipart/form-data' onsubmit="return fmemoform_submit(this);" style="margin:0px;">
<input type=hidden name=me_send_mb_id value="<?=$member[mb_id]?>">
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
      <td width="100%" height="2" align="center" valign="top" bgcolor="#FFFFFF">
          <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="14">&nbsp;</td>
              <td width="20"><img src="<?=$memo_skin_path?>/img/memo_icon02.gif" /></td>
              <td><span class="style5">���������� <?=$write_header_msg?></span></td>
            </tr>
          </table>
          
          <table width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr>
              <td width="5" height="5" background="<?=$memo_skin_path?>/img/memo_box2_tl.gif"></td>
              <td background="<?=$memo_skin_path?>/img/memo_line2_top.gif"></td>
              <td width="5" background="<?=$memo_skin_path?>/img/memo_box2_tr.gif"></td>
            </tr>

            <tr>
              <td width="5" background="<?=$memo_skin_path?>/img/memo_line2_left.gif">&nbsp;</td>
              <td align="center">

              <? $ss_id = 'me_recv_mb_id' ?>
                        
<? if ($option == 'notice') { // ���������� ��� ?>

              <? include_once("$g4[admin_path]/admin.lib.php")?>
              <input type="hidden" name="<?=$ss_id?>" id="<?=$ss_id?>" required="required" itemname="�޴� ȸ�����̵�" value="<?=$me_recv_mb_id?>" style="width:200px;" />
              <table width="98%" border="0" cellpadding="0" cellspacing="0">
              <tr align="center">
                  <td width="65" height="26" align="left" class="style5" style="padding-left:5px;">ȸ������</td>
                  <td align="left" >
                  <?=get_member_level_select('notice_level_1', 2, 10, 2) ?> - <?=get_member_level_select('notice_level_2', 2, 10, 10) ?>
                  </td>
              </tr>
              </table>

<? } else { // ���� ������ �ƴѰ�� ?>

                <table width="98%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="center">
                    <td width="65" height="26" align="left" class="style5" style="padding-left:5px;">�޴»��</td>
                    <td align="left" >
                        <input type="text" name="<?=$ss_id?>" id="<?=$ss_id?>" required="required" itemname="�޴� ȸ�����̵�" value="<?=$me_recv_mb_id?>" style="width:200px;" />
                    </td>
                    <td align="center" >
<?
if (count($my_friend) > 0) {
?>
<select class=quick_move onchange="friend_add(this.value)" >
<option value="">���� ģ����</option>
<option value="">-------------------------</option>
<? for ($i=0; $i<count($my_friend); $i++) {?>
<option value="<?=$my_friend[$i][fr_id]?>"><?=$my_friend[$i][fr_id]?>-<?=cut_str($my_friend[$i][mb_nick],10)?></option>
<? } ?>
</select>

<? } ?>

                    </td>
                    <td align="right" width=30>
                        <a href="javascript:popup_id('fmemoform','<?=$ss_id?>',200,500);">
                        ȸ���˻�
                        </a>
                    </td>
                  </tr>
                </table>
                
<? } // ���������� �ƴѰ�� ?>
                
                <table width="98%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="center">
                    <td width="65" height="26" align="left" class="style5" style="padding-left:5px;">��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��</td>
                    <td align="left" ><input type="text" name="me_subject" id="me_subject" required="required" style="width:100%; text-align:left;" / value='<?=$subject?>' ></td>
                  </tr>
                </table>
                <table width="98%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="2"></td>
                  </tr>                      
                  <tr align="center">
                    <td width="65" height="26" align="left" class="style5" style="padding-left:5px;">��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��</td>
                    <td height="200" align="center" valign="middle" bgcolor="#F6F6F6">

                    <? if ($is_dhtml_editor) { ?>
                        <input type=hidden value="html1" name="html">
                    <?
                        // cheditor�� ���� ���� ����
                        include_once("$g4[path]/lib/cheditor4.lib.php");
                        echo "<script type='text/javascript' src='$g4[cheditor4_path]/cheditor.js'></script>";
                        echo cheditor1('me_memo', '100%', '210');
                        // cheditor ������ �޴��� �Ϻθ� disable
                    ?>
                        <script type='text/javascript'>
                        ed_me_memo.config.usePreview = false;
                        ed_me_memo.config.NewDocument = false;
                        ed_me_memo.config.usePasteFromWord = false;
                        ed_me_memo.config.useOrderedList = false;
                        ed_me_memo.config.useUnOrderedList = false;
                        ed_me_memo.config.useOrderedList = false;
                        ed_me_memo.config.useUnOrderedList = false;
                        ed_me_memo.config.useOutdent = false;
                        ed_me_memo.config.useIndent = false;
                        ed_me_memo.config.useJustifyRight = false;
                        ed_me_memo.config.useJustifyFull = false;

                        ed_me_memo.config.useLink = false;
                        ed_me_memo.config.useUnLink = false;
                        ed_me_memo.config.useFlash = false;
                        ed_me_memo.config.useMedia = false;
                        ed_me_memo.config.useImageUrl = false;
                        </script>
                    <?
                        echo cheditor2('me_memo', $content);
                    } else { ?>
                   <textarea name='me_memo' id='me_memo' rows=15 style='width:100%;' required itemname='����' tabindex=1><?=$content?></textarea>
                   <? } ?>
                  </td></tr>
                </table>
                
                <!-- ����÷���ϱ� -->
                <? if ($config[cf_memo_use_file]) { ?>
                <table width="98%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="center">
                    <td width="65" height="26" align="left" class="style5" style="padding-left:5px;">����÷��</td>
                    <? if ($memo_dir_msg) { ?>
                    <td align="left" >
                        <?=$memo_dir_msg ?>
                    <td>
                    <? } else { ?>
                    <td align="left" >
                    <style> 
                    #file_box { 
                        position:relative ; 
                        display:inline-block ; 
                        width:73px ; height:22px 
                    } 
                    #file_box2 { 
                        position:absolute ; 
                        bottom:0 ; right:0 ; 
                        display:inline-block ; 
                        width:73px ; height:22px ; 
                        overflow:hidden 
                    } 
                    #file { 
                        position:absolute ; 
                        bottom:0 ; right:0 ; 
                        height:53px ; 
                        //font-size:224px ; 
                        opacity:0 ; filter:alpha(opacity=0) 
                    } 
                    </style> 

                    <script language="JavaScript"> 
                    function file_change(file) { 
                        document.getElementById("file_name").value = file; 
                    }
                    </script> 

                    <input type="text" id="file_name" name="memo_file_show" style="width:280;direction:rtl;" /> 

                    <span id="file_box"> 
                        <img align="absmiddle" src="<?=$memo_skin_path?>/img/file.gif" alt="Browse..." border="0" style="margin-bottom:3;" /> 
                        <span id="file_box2"> 
                            <input type="file" id="file" name='memo_file' onchange="file_change(this.value)" /> 
                        </span> 
                    </span> 
                    </td>
                    <? } ?>
                    <td align="right" ><span class="style8"></span></td>
                  </tr>
                </table>
                <? } ?>
                
                <table width="98%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="12"></td>
                  </tr>
                </table>
                <table width="98%" height="25" border="0" cellpadding="0" cellspacing="0">
                  
                  <tr align="center">
                    <td align="center" class="style5">
                        <input id=btn_submit type=image src="<?=$memo_skin_path?>/img/send.gif" border=0 alt="������" align='absmiddle' >
                        <a href='<?=$memo_url?>?kind=recv'><img align="absmiddle" src="<?=$memo_skin_path?>/img/list.gif" /></a>
                    </td>
                  </tr>
                  <tr align="center">
                    <td height="5" align="center"></td>
                  </tr>
                </table></td>
                
              <td width="5" background="<?=$memo_skin_path?>/img/memo_line2_right.gif">&nbsp;</td>
            </tr>
            
            <tr>
              <td height="5" background="<?=$memo_skin_path?>/img/memo_box2_dl.gif"></td>
              <td background="<?=$memo_skin_path?>/img/memo_line2_down.gif"></td>
              <td width="5" background="<?=$memo_skin_path?>/img/memo_box2_dr.gif"></td>
            </tr>
      </table>
      </td>
  </tr>
</table>
</form>

<script type="text/javascript">

<? if ($option != 'notice') { ?>

with (document.fmemoform) {
    if (me_recv_mb_id.value == "")
        me_recv_mb_id.focus();
    else
        me_subject.focus();
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

    document.getElementById('btn_submit').disabled = true;
    
    <? if ($option == 'notice') {?>
        f.action = "./memo2_form_notice_update.php";
    <? } else { ?>
        f.action = "./memo2_form_update.php";
    <? } ?>

    return true;
}

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