<?
include_once ("./_common.php"); 

if (!defined("_GNUBOARD_")) exit; // ���� ������ ���� �Ұ�

$g4[title] = "����2 �ּҷ�";

$memo_skin_path = "$g4[path]/skin/member/$config[cf_member_skin]";

if (! $is_member) alert("ȸ���� ������ �� �ִ� ������ �Դϴ�");

// ����2 ���α׷��� location�� ����
$memo_url = $g4[bbs_path] . "/memo.php";

$tot_cnt = count($list);

$cols = 7;
?>

<!-- ����2 �ּҷ� ���� -->
<table width="<?=$content_width?>" height="30" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="14">&nbsp;</td>
        <td width="25"><img src="<?=$memo_skin_path?>/img/memo_icon06.gif"/></td>
        <td ><span class="style5">����2 �ּҷ�</span> (<?=$tot_cnt?>)</td>
    </tr>
</table>

<table width="<?=$content_width?>" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5" height="5" background="<?=$memo_skin_path?>/img/memo_box2_tl.gif"></td>
    <td width="" background="<?=$memo_skin_path?>/img/memo_line2_top.gif"></td>
    <td width="5" background="<?=$memo_skin_path?>/img/memo_box2_tr.gif"></td>
  </tr>
  <tr>
    <td width="5" background="<?=$memo_skin_path?>/img/memo_line2_left.gif">&nbsp;</td>
    <td align="center">
      <table width="98%" border="0" cellpadding="0" cellspacing="0">
        <colgroup width="30"></colgroup>
        <colgroup width=""></colgroup>
        <colgroup width="80"></colgroup>
        <colgroup width="80"></colgroup>
        <colgroup width="80"></colgroup>
        <colgroup width="80"></colgroup>
        <tr>
          <td colspan="<?=$cols?>" height="2"></td>
        </tr>
        <tr>
          <td height="20" align="center">no.</td>
          <td align="center"><strong>member</strong></td>
          <td align="center"><strong>������</strong></td>
          <td align="center"><strong>�߽���</strong></td>
          <td align="center"><strong>������(����)</strong></td>
          <td align="center"><strong>������(�߽�)</strong></td>
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
          <tr>
          <?//���
          if(is_array($list)) {
          $i=0;
          foreach ($list as $val) { 
          ?>
            <td align="center">
              <? $i++; echo $i?>
            </td>
            <td align="center"><span class="style7">
              <?=$val['name']?>
            </span></td>
            <td align="center"><span class="style10">
              <? if ($val['recv']) { ?><a href="<?=$memo_url?>?kind=recv&sfl=me_send_mb_id&stx=<?=$val[mb_id]?>"><?echo $val['recv'];?></a><? } else echo '-'; ?>
            </td>
            <td align="center"><span class="style10">
              <? if ($val['send']) { ?><a href="<?=$memo_url?>?kind=send&sfl=me_recv_mb_id&stx=<?=$val[mb_id]?>"><?echo $val['send'];?></a><? } else echo '-'; ?>
            </td>
            <td align="center"><span class="style10">
              <? if ($val['save_recv']) { ?><a href="<?=$memo_url?>?kind=save&sfl=me_send_mb_id&stx=<?=$val[mb_id]?>"><?echo $val['save_recv'];?></a><? } else echo '-'; ?>
            </td>
            <td align="center"><span class="style10">
              <? if ($val['save_send']) { ?><a href="<?=$memo_url?>?kind=save&sfl=me_recv_mb_id&stx=<?=$val[mb_id]?>"><?echo $val['save_send'];?></a><? } else echo '-'; ?>
            </td>
          </tr>
          <tr>
            <td height="3"></td>
          </tr>
          <? } } ?>
      </table></td>
    <td width="5" background="<?=$memo_skin_path?>/img/memo_line2_right.gif">&nbsp;</td>
  </tr>
  <tr>
    <td height="5" background="<?=$memo_skin_path?>/img/memo_box2_dl.gif"></td>
    <td background="<?=$memo_skin_path?>/img/memo_line2_down.gif"></td>
    <td background="<?=$memo_skin_path?>/img/memo_box2_dr.gif"></td>
  </tr>
</table>