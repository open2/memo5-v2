<form name=fsearch method=get style="margin:0px;">
<input type='hidden' name='kind' value='<?=$kind?>'>
<table width="100%" height="30" border="0" cellspacing="0">
    <tr>
    <td>
        <b><?=$memo_title?> 
        ( <? if ($kind == "recv") echo "<a href='$memo_url?kind=recv&unread=only' title='����������'><font color=red>$total_count_recv_unread</font></a> / "?><a href='<?=$memo_url?>?kind=$kind'><?=number_format($total_count)?></a></span> )</b>
        &nbsp<a href="<?=$memo_url?>?kind=<?=$kind?>&sfl=me_file&stx=me_file"><img src="<?=$memo_skin_path?>/img/icon_file.gif" align=absmiddle></a>
    </td>
    <!-- �˻��ϱ� -->
    <td align="right">
        <select name='sfl' id='sfl'>
            <option value="me_subject_memo">����+����</option>
            <option value="me_subject">����</option>
            <option value="me_memo">����</option>
        <? if ($kind == "recv" or $kind == "spam" or $kind == "notice") { ?>
            <option value="me_send_mb_nick">����<? if ($config['cf_memo_mb_name']) echo "(�̸�)"; else echo "(����)"; ?></option>
            <option value="me_send_mb_id">����(���̵�)</option>
        <? } else if ($kind == "send") { ?>
            <option value="me_recv_mb_nick">����<? if ($config['cf_memo_mb_name']) echo "(�̸�)"; else echo "(����)"; ?></option>
            <option value="me_recv_mb_id">����(���̵�)</option>
        <? } else if ($kind == "save" or $kind == "trash") { ?>
            <option value="me_send_mb_nick">����<? if ($config['cf_memo_mb_name']) echo "(�̸�)"; else echo "(����)"; ?></option>
            <option value="me_recv_mb_id">����(���̵�)</option>
            <option value="me_send_mb_nick">����<? if ($config['cf_memo_mb_name']) echo "(�̸�)"; else echo "(����)"; ?></option>
            <option value="me_send_mb_id">����(���̵�)</option>
        <? } ?>
        </select>
        <input name="stx" type="text" class="ed" style=" height:17px;" value='<?=$stx?>' maxlength=15 size="15" itemname="�˻���" required />
        <input type=image src="<?=$memo_skin_path?>/img/search.gif" border=0 align=absmiddle>
    </td>
    </tr>
</table>
</form>

<form name="fboardlist" method="post" style="margin:0px;">
<input type=hidden name=kind value="<?=$kind?>">

<table class="tbl_type" width="100%" border="1" cellspacing="0">
    <colgroup> 
      <col width="35">
      <col width="20">
      <col width="110">
      <col width="">
      <col width="60">
      <col width="60">
    </colgroup> 
    <thead>
    <tr>
        <th>
        <!-- ������������ ���� ������ ����... -->
        <input name="chk_me_id_all" type="checkbox" onclick="if (this.checked) all_checked(true); else all_checked(false);" />
        </th>
        <th></th>
        <th><?=$list_title ?></th>
        <th>�� ��</th>
        <th>�����ð�</th>
        <th>
        <? if ($kind == 'notice') {
            if ($is_admin=='super' || $member['mb_id']==$view['me_send_mb_id']) { ?>  
                ���ŷ���
            <? } ?>
        <? } else { ?>
            �����ð�
        <? } ?>
        </th>
    </tr>
    </thead>

    <? for ($i=0; $i<count($list); $i++) { // ����� ��� �մϴ�. ?>
    <tr>
        <td>
            <!-- ������������ ���� ������ ����... -->
            <? if ($kind != 'notice') { ?>
            <input name="chk_me_id[]" type="checkbox" value="<?=$list[$i][me_id]?>" />
            <? } ?>
        </td>
        <?
          if ($list[$i]['read_datetime'] == '���� ����' or $list[$i]['read_datetime'] == '���� ����') {
              $style = "style='font-weight:bold;'";
        ?>
        <td><img src="<?=$memo_skin_path?>/img/check.gif" width="13" height="12" /></td>
        <?
        } else {
            $style = "";
        ?>
        <td><img src="<?=$memo_skin_path?>/img/nocheck.gif" width="12" height="10" /></td>
        <? } ?>
        <td><?=$list[$i]['name']?></td>
        <td align="left" <?=$style?> >&nbsp;<? if ($list[$i]['me_file']) { ?><img src="<?=$memo_skin_path?>/img/icon_file.gif" align=absmiddle>&nbsp;<? } ?><a href='<?=$list[$i]['view_href']?>&page=<?=$page?>&sfl=<?=$sfl?>&stx=<?=$stx?>&unread=<?=$unread?>' title='<?=$list[$i]['subject']?>'><?=cut_str($list[$i]['subject'],27)?></a></td>
        <td <?=$style?> ><?=$list[$i]['send_datetime']?></td>
        <?
        // ���������� ���� ��¥��???
        if ($kind == 'notice') { 
            if ($is_admin=='super' || $member[mb_id]==$view[me_send_mb_id])
                $list[$i]['read_datetime'] = $list[$i]['me_recv_mb_id'];
            else 
                $list[$i]['read_datetime'] = "";
        }
        ?>
        <td <?=$style?> ><?=$list[$i]['read_datetime']?></td>
    </tr>
    <? } ?>
    <? if ($i==0) { ?>
    <tr>
        <td align=center height=100 colspan=6>�ڷᰡ �����ϴ�.</td>
    </tr>
    <? } ?>
    <tfoot>
    <tr>
        <td colspan=6 align=left style="padding:2px 0 2px;">
          &nbsp;&nbsp;
          <? if ($i > 0 and $kind !='notice') { ?>
          <a href="javascript:select_delete();"><img src="<?=$memo_skin_path?>/img/bt02.gif" /></a>
          <? } ?>
          <? if ($i > 0 and $kind == "trash") { ?>
          <a href="javascript:all_delete_trash();"><img src="<?=$memo_skin_path?>/img/all_del.gif" align=absmiddle/></a>
          <? } ?>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <? 
        $page = get_paging($config['cf_write_pages'], $page, $total_page, "?&kind=$kind&sfl=$sfl&stx=$stx&unread=$unread&page="); 
        echo "$page";
        ?>
        </td>
    </tr>
    <?
    // �ϴܺο� �������� �⺻ ��������
    $msg = "";
    if ($kind == "write") { // ���� �϶��� �޽����� ��� �մϴ�.
        $msg .= "<li>�������� ���� �߼۽� �ĸ�(,)�� ���� �մϴ�.";
        if ($config['cf_memo_use_file'] && $config['cf_memo_file_size']) {
            $msg .= "<li>÷�ΰ����� ������ �ִ� �뷮�� " .$config['cf_memo_file_size'] . "M(�ް�) �Դϴ�.";
        }
        if ($config['cf_memo_send_point']) 
            $msg .= "<li>���� ������ ȸ���� ".number_format($config['cf_memo_send_point'])."���� ����Ʈ�� �����մϴ�.";
    }
    if ($kind == "send") { // ���������� �϶��� �޽����� ��� �մϴ�.
        $msg .= "<li>���� ���� ������ �����ϸ�, �߽��� ���(������ �����Կ��� ����) �˴ϴ�.";
    }
    if ($kind == "send" || $kind == "recv") { // ���������� �϶��� �޽����� ��� �մϴ�.
        $msg .= "<li>�����ȵ� ������ " . $config['cf_memo_del'] . "�� �� �����ǹǷ� �߿��� ������ �����Ͻñ� �ٶ��ϴ�.";
    }
    if ($msg !== "")
        echo "<tr><td colspan=6 align=left><ul>$msg</ul><td></tr>";
    ?>
    </tfoot>
</table>
</form>

<?
// ���� ���� include
$ad_file = "$memo_skin_path/memo2_adsense.php";
if (file_exists($ad_file)) {
    include_once($ad_file);
}
?>

<script type="text/javascript">
if ('<?=$stx?>') {
    document.fsearch.sfl.value = '<?=$sfl?>';
}
</script>