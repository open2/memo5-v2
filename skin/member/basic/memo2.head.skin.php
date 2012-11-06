<?
if (!defined("_GNUBOARD_")) exit; // ���� ������ ���� �Ұ� 

// ���� - �⺻���� â�� ũ�⸦ ����
$config['memo_width'] = 717; // ���� âũ�� 730���� 13px �۰��ؾ� ������ ��ĥ�� ���� scroll bar�� �Ȼ����
$config['memo_height'] = 600;

// ���� ���̺��� �⺻�� ����
$table_width           = $config['memo_width'];   // 10(��������)+$left_menu_width(�����޴�)+ 10(������ϰ� �޴����� ����) + ���� + 10(��������)
$left_menu_width       = 164;                                   // ���� �޴��� ��
$content_width         = $table_width - $left_menu_width - 30 - 10;  // ���� ����â�� ��, -10�� �׵θ� ������ ����� ����... ��Ȯ�� ���ڴ� üũ�� �ʿ��� ����
$content_inner_width   = $content_width - 1;                    // ���� ����â ������ �ִ� ��
$max_img_width         = $content_width - 50;                   // �̹����� ��

// resize�� ���� ���̸� ����
$board['resize_img_width'] = $max_img_width;
?>

<link rel="stylesheet" href="<?=$memo_skin_path?>/memo2.css?v22" type="text/css">

<!-- sideview�� ���ؼ� -->
<script type='text/javascript' src='<?=$g4[path]?>/js/sideview.js'></script>

<!-- ��ܺ� ���� �����ϱ� -->
<table border="0" cellspacing="0" cellpadding="0"><tr><td height="10"></td></tr></table>

<!-- �޴����� -->
<table width=<?=$table_width?> border="0" cellspacing="0" cellpadding="0"> 
<tr valign=top>
    <td width=10></td> <!-- ������ ���� �����ϱ� -->

    <td width=<?=$left_menu_width?>> <!-- ���� �޴� -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="7" height="7" background="<?=$memo_skin_path?>/img/memo_box_tl.gif"></td>
            <td height="7" background="<?=$memo_skin_path?>/img/memo_line_top.gif"></td>
            <td width="7" height="7" background="<?=$memo_skin_path?>/img/memo_box_tr.gif"></td>
          </tr>
          <tr>
            <td width="7" background="<?=$memo_skin_path?>/img/memo_line_left.gif">&nbsp;</td>
            <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="25" align="center"><img src="<?=$memo_skin_path?>/img/memo_icon01.gif" width="13" height="12" /></td>
                <td width="125" height="25"><strong><a href='<?=$memo_url?>?kind=recv'>����������</a></strong> <? if ($total_count_recv_unread > 0) {?><a href='<?=$memo_url?>?kind=recv&unread=only'>(<font color=red><b><?=$total_count_recv_unread?></b></font>)</a><? } ?></td>
              </tr>
              <tr><td height="1" colspan="2" bgcolor="e1e1e1"></td></tr>
              <tr>
                <td align="center"><img src="<?=$memo_skin_path?>/img/memo_icon03.gif" width="16" height="14" /></td>
                <td height="25"><strong><a href='<?=$memo_url?>?kind=send'>����������</a></strong></td>
              </tr>
              <tr><td height="1" colspan="2" bgcolor="e1e1e1"></td></tr>
              <tr>
                <td align="center"><img src="<?=$memo_skin_path?>/img/memo_icon02.gif" width="13" height="13" /></td>
                <td height="25"><strong><a href='<?=$memo_url?>?kind=write'>����������</a></strong></td>
              </tr>
              <? if ($is_admin) { ?>
              <tr><td height="1" colspan="2" bgcolor="e1e1e1"></td></tr>
              <tr>
                <td align="center"><img src="<?=$memo_skin_path?>/img/memo_icon02.gif" width="13" height="13" /></td>
                <td height="25"><strong><a href='<?=$memo_url?>?kind=notice'><a href='<?=$memo_url?>?kind=write&option=notice'>�������� ������</a></strong>
                </tr>
              <? } ?>
              <tr><td height="1" colspan="2" bgcolor="e1e1e1"></td></tr>
              <tr>
                <td align="center"><img src="<?=$memo_skin_path?>/img/memo_icon04.gif" width="3" height="3" /></td>
                <td height="25"><strong><a href='<?=$memo_url?>?kind=save'>������������</a></strong></td>
              </tr>
              <tr><td height="1" colspan="2" bgcolor="e1e1e1"></td></tr>
              <tr>
                <td align="center"><img src="<?=$memo_skin_path?>/img/memo_icon04.gif" width="3" height="3" /></td>
                <td height="25"><strong><a href='<?=$memo_url?>?kind=notice'>����������</a>
                </tr>
              <tr>
                <td height="1" colspan="2" bgcolor="e1e1e1"></td>
              </tr>
              <tr>
                <td align="center"><img src="<?=$memo_skin_path?>/img/co_btn_delete.gif" width="3" height="3" /></td>
                <td height="25"><strong><a href='<?=$memo_url?>?kind=trash'>������������</a></strong></td>
              </tr>
              <tr><td height="1" colspan="2" bgcolor="e1e1e1"></td></tr>
              <tr>
                <td align="center"><img src="<?=$memo_skin_path?>/img/memo_icon04.gif" width="3" height="3" /></td>
                <td height="25"><strong><a href='<?=$memo_url?>?kind=spam'>����������</a></strong></td>
              </tr>
              <tr><td height="1" colspan="2" bgcolor="ffffff"></td></tr>
            </table></td>
            <td width="7" background="<?=$memo_skin_path?>/img/memo_line_right.gif">&nbsp;</td>
          </tr>
          <tr>
            <td width="7" height="7" background="<?=$memo_skin_path?>/img/memo_box_dl.gif"></td>
            <td height="7" background="<?=$memo_skin_path?>/img/memo_line_down.gif"></td>
            <td width="7" height="7" background="<?=$memo_skin_path?>/img/memo_box_dr.gif"></td>
          </tr>
        </table>

        <? if ($config['cf_memo_notice_memo']) { ?>
        <br>
        <table width="100%" border="0" cellpadding="10" cellspacing="0" style='border-width:1; border-color:#DDDDDD; border-style:solid;'>
        <tr><td width=100%>
        <?=nl2br($config['cf_memo_notice_memo'])?>
        </td></tr></table>
        <? } ?>

        <!-- ���� �޴� ������ ���� -->
        <table width="100%"><tr><td height="5" colspan="3"></td></tr></table>
        
        <!-- ���� �ι�° �޴� -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="7" height="7" background="<?=$memo_skin_path?>/img/memo_box3_tl.gif"></td>
            <td height="7" background="<?=$memo_skin_path?>/img/memo_line3_top.gif"></td>
            <td width="7" height="7" background="<?=$memo_skin_path?>/img/memo_box3_tr.gif"></td>
          </tr>

          <tr>
            <td width="7" background="<?=$memo_skin_path?>/img/memo_line3_left.gif">&nbsp;</td>
            <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <? if ($config[cf_friend_management]) { ?>
                <tr>
                  <td width="25" align="center"><img src="<?=$memo_skin_path?>/img/memo_icon05.gif" width="19" height="19" /></td>
                  <td width="125" height="25"><strong><a href='<?=$memo_url?>?kind=online'>ģ������</a></strong></td>
                </tr>
                <tr><td height="1" colspan="2" bgcolor="e1e1e1"></td></tr>
                <? } ?>
                <tr>
                  <td align="center"><img src="<?=$memo_skin_path?>/img/friend_online.jpg" width="12" height="11" /></td>
                  <td height="25"><strong>
                  <a href='<?=$memo_url?>?kind=online&fr_type=online'>����������</a>
                  </strong>
                  </td>
                </tr>
                <tr><td height="1" colspan="2" bgcolor="e1e1e1"></td></tr>
                <tr>
                  <td align="center"><img src="<?=$memo_skin_path?>/img/memo_icon06.gif" width="12" height="11" /></td>
                  <td height="25"><strong>
                  <a href='<?=$memo_url?>?kind=memo_group_admin'>�׷����</a>
                  </strong>
                  </td>
                </tr>
                <tr><td height="1" colspan="2" bgcolor="e1e1e1"></td></tr>
                <tr>
                  <td align="center"><img src="<?=$memo_skin_path?>/img/memo_icon06.gif" width="12" height="11" /></td>
                  <td height="25"><strong>
                  <a href='<?=$memo_url?>?kind=memo_address_book'>�ּҷ�</a>
                  </strong>
                  </td>
                </tr>
                <tr><td height="1" colspan="2" bgcolor="e1e1e1"></td></tr>
                <? if ($config[cf_memo_user_config] || $is_admin == "super") { ?>
                <tr>
                  <td align="center"><img src="<?=$memo_skin_path?>/img/btn_c_ok.gif" width="12" height="11" /></td>
                  <td height="25"><strong>
                  <a href='<?=$memo_url?>?kind=memo_config'>���� ����</a>
                  </strong>
                  </td>
                </tr>
                <tr><td height="1" colspan="2" bgcolor="e1e1e1"></td></tr>
                <? } ?>
            </table></td>
            <td width="7" background="<?=$memo_skin_path?>/img/memo_line3_right.gif">&nbsp;</td>
          </tr>

          <tr>
            <td width="7" height="7" background="<?=$memo_skin_path?>/img/memo_box3_dl.gif"></td>
            <td height="7" background="<?=$memo_skin_path?>/img/memo_line3_down.gif"></td>
            <td width="7" height="7" background="<?=$memo_skin_path?>/img/memo_box3_dr.gif"></td>
          </tr>
        </table>

    </td>
    
    <td width=10></td> <!-- ������ϰ� ��������� ���鼳���ϱ� -->

    <td width=<?=$content_width?>> <!-- ���� ����κ� -->
