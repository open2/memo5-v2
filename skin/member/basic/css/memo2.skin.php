<?
if (!defined("_GNUBOARD_")) exit; // ���� ������ ���� �Ұ� 

// ���� - �⺻���� ���� ����
$table_width      = 680;              // 100%�� ������ �ϸ� ������ ������ �� ũ�� ������ �����Ͻô� ���� �־��.
$left_menu_width  = 164;              // ���� �޴��� ��
$content_width    = 458;              // ���� ����â�� ��
$max_img_width = $content_width - 40; // �̹����� ��
                   
// ����2 ���α׷��� location�� ����, $_SERVER[PHP_SELF]�� �Ⱦ��� ���ؼ�
$memo_url = $g4[bbs_path] . "/memo.php";
?>

<script type="text/javascript"> 
<!-- // ȸ��ID ã��  
function popup_id(frm_name, ss_id, top, left) 
{ 
    url = './write_id.php?frm_name='+frm_name+'&ss_id='+ss_id; 
    opt = 'scrollbars=yes,width=320,height=470,top='+top+',left='+left; 
    window.open(url, "write_id", opt); 
} 
//--> 
</script>
<link rel="stylesheet" href="<?=$member_skin_path?>/memo4_style.css" type="text/css">

<div class="memo">
<!-- Left Menu Start -->
    <div class="lbox">
        <div class="lbox1">
            <div class="inner">
                <ul>
                    <li class="icon01">
                        <a href='<?=$memo_url?>?kind=recv'>����������</a>
                      <? if ($total_count_recv_unread > 0) {?>
                        <a href='<?=$memo_url?>?kind=recv&unread=only'>(<span class="red"><?=$total_count_recv_unread?></span>)</a><? } ?>
                    </li>
                    <li class="icon03">
                        <a href='<?=$memo_url?>?kind=send'>����������</a>
                      <? if ($total_count_recv_unread > 0) {?>
                        <a href='<?=$memo_url?>?kind=recv&unread=only'>(<span class="red"><?=$total_count_recv_unread?></span>)</a><? } ?>
                    </li>
                    <li class="icon02"><a href='<?=$memo_url?>?kind=write'>����������</a></li>
                    <? if ($is_admin) { ?><li class="icon02"><a href='<?=$memo_url?>?kind=write&option=notice'>�������� ������</a></li><? } ?>
                    <li class="icon04"><a href='<?=$memo_url?>?kind=save'>������������</a></li>
                    <li class="icon04"><a href='<?=$memo_url?>?kind=notice'>����������</a></li>
                    <!-- <li class="icon02"><a href='<?=$memo_url?>?kind=temp'>�ۼ�����������</a></li> -->
                    <li class="co_btn_delete"><a href='<?=$memo_url?>?kind=trash'>������������</a></li>
                    <!-- <li class="icon04"><a href='<?=$memo_url?>?kind=cafe'>ī��������</a></li> -->
                    <li class="icon04"><a href='<?=$memo_url?>?kind=spam'>����������</a></li>
                </ul>
            </div>
        </div>
        <div class="lbox2">
            <div class="inner">
                <ul>
                    <? if ($config[cf_friend_management]) { ?><li class="icon05"><a href='<?=$memo_url?>?kind=online'>ģ������</a></li><? } ?>
                    <li class="friend_online"><a href='<?=$memo_url?>?kind=online&fr_type=online'>����������</a></li>
                    <li class="icon06"><a href='<?=$memo_url?>?kind=memo_group_admin'>�׷����</a></li>
                    <li class="icon06"><a href='<?=$memo_url?>?kind=memo_address_book'>�ּҷ�</a></li>
                    <li class="btn_c_ok"><a href='<?=$memo_url?>?kind=memo_config'>���� ����</a></li>
                </ul>
            </div>
        </div>
        <? if ($config['cf_memo_notice_memo']) { ?><div class="notice"><?=$config['cf_memo_notice_memo']?></div><? } ?>
    </div>
<!-- Left Menu End -->
    <div class="rbox">
    <!-- Right Box Start -->
      <? 
      if ($class == "view") { // ���� ����
          include_once("$member_skin_path/memo2_view.skin.php");
          
      } else { // ���� ���Ⱑ �ƴѰ��
        
      switch ($kind) {
        case 'write' : 
              include_once("$member_skin_path/memo2_write.skin.php"); 
              break;
        case 'online' :
              include_once("$member_skin_path/memo2_online.skin.php"); 
              break;        
        case 'memo_group' :
              include_once("$member_skin_path/memo2_group_member.skin.php"); 
              break;
        case 'memo_group_admin' :
              include_once("$member_skin_path/memo2_group_admin.skin.php"); 
              break;
        case 'memo_address_book' :
              include_once("$member_skin_path/memo2_memo_address_book.skin.php"); 
              break;
        case 'memo_config' :
              include_once("$member_skin_path/memo2_config.skin.php"); 
              break;
        default :
              include_once("$member_skin_path/memo2_list.skin.php"); 
      }

      } ?>
    <!-- Right Box End -->
    </div>
</div>

<!-- �ϴܺ� �������� ���� -->
<? include_once("$member_skin_path/memo2_bottom.skin.php"); ?>

<script language="JavaScript">
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_me_id[]")
            f.elements[i].checked = sw;
    }
}

function check_confirm(str) {
    var f = document.fboardlist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_me_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(str + "�� ������ �ϳ� �̻� �����ϼ���.");
        return false;
    }
    return true;
}

// ������ �Խù� ����
function select_delete() {
    var f = document.fboardlist;

    str = "����";
    if (!check_confirm(str))
        return;

    if (!confirm("������ ������ ���� "+str+" �Ͻðڽ��ϱ�?\n\n�ѹ� "+str+"�� �ڷ�� ������ �� �����ϴ�"))
        return;

    f.action = "./memo2_form_delete.php";
    f.submit();
}

// ��� �Խù� ����
function all_delete_trash() {
    var f = document.fboardlist;

    str = "����";

    if (!confirm("��� ������ ���� "+str+" �Ͻðڽ��ϱ�?\n\n�ѹ� "+str+"�� �ڷ�� ������ �� �����ϴ�"))
        return;

    f.action = "./memo2_form_delete_all_trash.php";
    f.submit();
}
</script>