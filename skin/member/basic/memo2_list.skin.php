<form name=fsearch method=get style="margin:0px;">
<input type='hidden' name='kind' value='<?=$kind?>'>

<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="14">&nbsp;</td>
    <td>
        <span class="style5"><?=$memo_title?> ( <span class="style6"><? if ($kind == "recv") echo "<a href='$memo_url?kind=recv&unread=only'>$total_count_recv_unread</a> / "?><a href='<?=$memo_url?>?kind=$kind'><?=number_format($total_count)?></a></span> )</span>&nbsp<a href="<?=$memo_url?>?kind=<?=$kind?>&sfl=me_file&stx=me_file"><img src="<?=$memo_skin_path?>/img/icon_file.gif" align=absmiddle></a>
    </td>

    <!-- �˻��ϱ� -->
    <td width="115" align="right"><span style="margin:0px;">
      <select name='sfl' id='sfl' class='small'>
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
    </span>&nbsp;</td>
    <td width="105"><span style="margin:0px;">
        <input name="stx" type="text" class="ed" value='<?=$stx?>' maxlength=15 size="15" itemname="�˻���" required />
    </span></td>
    <td width="50">
        <input type=image src="<?=$memo_skin_path?>/img/search.gif" border=0 align=absmiddle>
    </td>
  </tr>
</table>
</form>

<form name="fboardlist" method="post" style="margin:0px;">
<table class="tbl_type" border="1" cellspacing="0">
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
        <? if ($kind != 'notice') { ?>
        <input name="chk_me_id_all" type="checkbox" onclick="if (this.checked) all_checked(true); else all_checked(false);" />
        <? } ?>
        </th>
        <th></th>
        <th><?=$list_title ?></th>
        <th>�� ��</th>
        <th>�����ð�</th>
        <th><? if ($kind == 'notice') {  if ($is_admin=='super' || $member[mb_id]==$view[me_send_mb_id]) { ?>���ŷ���<? } } else { ?>�����ð�<?}?></b></th>
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
        <? if ($list[$i][read_datetime] == '���� ����' or $list[$i][read_datetime] == '���� ����') { ?>
            <td align="center"><img src="<?=$memo_skin_path?>/img/check.gif" width="13" height="12" /></td>
            <td align="center"><?=$list[$i][name]?></td>
            <td align="left">&nbsp;<? if ($list[$i][me_file]) { ?><img src="<?=$memo_skin_path?>/img/icon_file.gif" align=absmiddle>&nbsp;<? } ?><a href='<?=$list[$i][view_href]?>&page=<?=$page?>&sfl=<?=$sfl?>&stx=<?=$stx?>&unread=<?=$unread?>'><?=cut_str($list[$i][subject],27)?></a></td>
            <td align="center"><?=$list[$i][send_datetime]?></td>
            <? if ($kind == 'notice') { if ($is_admin=='super' || $member[mb_id]==$view[me_send_mb_id]) $list[$i][read_datetime] = $list[$i][me_recv_mb_id]; else $list[$i][read_datetime] = ""; } ?>
           <td align="center"><?=$list[$i][read_datetime]?></td>
       <? } else { ?>
            <td align="center"><img src="<?=$memo_skin_path?>/img/nocheck.gif" width="12" height="10" /></td>
            <td align="center"><?=$list[$i][name]?></td>
            <td align="left">&nbsp;<? if ($list[$i][me_file]) { ?><img src="<?=$memo_skin_path?>/img/icon_file.gif" align=absmiddle>&nbsp;<? } ?><a href='<?=$list[$i][view_href]?>&page=<?=$page?>&sfl=<?=$sfl?>&stx=<?=$stx?>&unread=<?=$unread?>'><?=cut_str(strip_tags($list[$i][subject]),27)?></a></td>
            <td align="center"><?=$list[$i][send_datetime]?></td>
            <td align="center"><?=$list[$i][read_datetime]?></td>
        <? } ?>
    </tr>
    <? } ?>
    <? if ($i==0) { ?>
    <tr colspan=5>
        <td align=center height=100>�ڷᰡ �����ϴ�.</td>
    </tr>
    <? } ?>
    <tfoot hegiht=50>
        <td colspan=6 align=left>
          &nbsp;&nbsp;
          <? if ($i > 0 and $kind !='notice') { ?>
          <a href="javascript:select_delete();"><img src="<?=$memo_skin_path?>/img/bt02.gif" align=absmiddle/></a>
          <? } ?>
          <? if ($i > 0 and $kind == "trash") { ?>
          <a href="javascript:all_delete_trash();"><img src="<?=$memo_skin_path?>/img/all_del.gif" align=absmiddle/></a>
          <? } ?>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <? 
        $page = get_paging($config[cf_write_pages], $page, $total_page, "?&kind=$kind&sfl=$sfl&stx=$stx&unread=$unread&page="); 
        echo "$page";
        ?>
        </td>
    </tfoot>
</table>
</form>



<script type="text/javascript">
if ('<?=$stx?>') {
    document.fsearch.sfl.value = '<?=$sfl?>';
}
</script>