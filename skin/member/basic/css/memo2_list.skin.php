    <input type="hidden" name="kind"  value="<?=$kind?>" />

    <div class="top"><span class="view">
        <span class="right">
            <form name="fsearch" method="get">
            <select name="sfl" id="sfl" class="small">
              <? if ($kind == "recv" or $kind == "spam" or $kind == "notice") { ?>
                <option value="me_subject_memo">����+����</option>
                <option value="me_subject">����</option>
                <option value="me_memo">����</option>
                <option value="me_send_mb_nick">����(�̸�)</option>
                <option value="me_send_mb_id">����(���̵�)</option>
              <? } else if ($kind == "send") { ?>
                <option value="me_subject_memo">����+����</option>
                <option value="me_subject">����</option>
                <option value="me_memo">����</option>
                <option value="me_recv_mb_nick">����(�̸�)</option>
                <option value="me_recv_mb_id">����(���̵�)</option>
              <? } else if ($kind == "save" or $kind == "trash") { ?>
                <option value="me_subject_memo">����+����</option>
                <option value="me_subject">����</option>
                <option value="me_memo">����</option>
                <option value="me_recv_mb_nick">����(�̸�)</option>
                <option value="me_recv_mb_id">����(���̵�)</option>
                <option value="me_send_mb_nick">����(�̸�)</option>
                <option value="me_send_mb_id">����(���̵�)</option>
              <? } else if ($kind == "temp") { ?>
                <option value="me_subject_memo">����+����</option>
                <option value="me_subject">����</option>
                <option value="me_memo">����</option>
              <? } ?></select>
                <input name="stx" type="text" class="ed stx" value="<?=$stx?>" itemname="�˻���" required />
                <input type="image" src="<?=$member_skin_path?>/img/search.gif" align="absmiddle" />
            </form>
        </span>
        <?=$memo_title?> (<? if ($kind == "recv") echo "$total_count_recv_unread/"?><?=number_format($total_count)?>��)
        <a href="<?=$memo_url?>?kind=<?=$kind?>&sfl=me_file&stx=me_file"><img src="<?=$member_skin_path?>/img/icon_file.gif" align="absmiddle" /></a>
    </span></div>

    <div class="inner inner_list">
        <div class="title">
            <span class="checkbox"><input name="chk_me_id_all" type="checkbox" onclick="if (this.checked) all_checked(true); else all_checked(false);" /></span>
            <span class="checkicon">&nbsp;</span>
            <span class="name"><?=$list_title?></span>
            <span class="subject">����</span>
            <span class="readtime"><? if ($kind == 'notice') {} else { echo "�����ð�"; } ?></span>
            <span class="sendtime">�����ð�</span>
        </div>
        <form name="fboardlist" method="post">
        <input type="hidden" name="kind" value="<?=$kind?>" />
        <ul>
            <? for ($i=0; $i<count($list); $i++) { // ����� ��� �մϴ�. ?>
            <li>
                <span class="checkbox"><input name="chk_me_id[]" type="checkbox" value="<?=$list[$i][me_id]?>" /></span>
              <? if ($list[$i][read_datetime] == '���� ����' or $list[$i][read_datetime] == '���� ����') { ?>
                <span class="checkicon"><img src="<?=$member_skin_path?>/img/check.gif" /></span>
                <span class="name"><?=$list[$i][name]?></span>
                <span class="subject">
                    <? if ($list[$i][me_file]) { ?><img src="<?=$member_skin_path?>/img/icon_file.gif" align="absmiddle" /><? } ?>
                    <a href="<?=$list[$i][view_href]?>&page=<?=$page?>&sfl=<?=$sfl?>&stx=<?=$stx?>&unread=<?=$unread?>"><?=cut_str($list[$i][subject],27)?></a>
                </span>
                <span class="readtime"><? if ($kind == 'notice') $list[$i][read_datetime] = ''; ?><?=$list[$i][read_datetime]?></span>
                <span class="sendtime"><?=$list[$i][send_datetime]?></span>
              <? } else { ?>
                <span class="checkicon"><img src="<?=$member_skin_path?>/img/nocheck.gif" /></span>
                <span class="name"><?=$list[$i][name]?></span>
                <span class="subject">
                    <? if ($list[$i][me_file]) { ?><img src="<?=$member_skin_path?>/img/icon_file.gif" align="absmiddle" /><? } ?>
                    <a href="<?=$list[$i][view_href]?>&page=<?=$page?>&sfl=<?=$sfl?>&stx=<?=$stx?>&unread=<?=$unread?>"><?=cut_str(strip_tags($list[$i][subject]),27)?></a>
                </span>
                <span class="readtime"><?=$list[$i][read_datetime]?></span>
                <span class="sendtime"><?=$list[$i][send_datetime]?></span>
            </li><? } // if end ?>
            <? } // for end ?>
            <? if ($i==0) { echo "<div class='none'>�ڷᰡ �����ϴ�.</div>"; } ?>
        </ul>
        <div class="btn">
            <? if ($i > 0 and $kind !='notice') { ?><a href="javascript:select_delete();"><img src="<?=$member_skin_path?>/img/bt02.gif" /></a><? } ?>
            <? if ($i > 0 and $kind == "trash") { ?><a href="javascript:all_delete_trash();"><img src="<?=$member_skin_path?>/img/btn_all_del.gif" /></a><? } ?>
        </div>
        <div class="pages">
            <? $page = get_paging($config[cf_write_pages], $page, $total_page, "?&kind=$kind&sfl=$sfl&stx=$stx&unread=$unread&page="); echo "&nbsp;$page"; ?>
        </div>
    </div>
    </form>
<script language="JavaScript">
if ('<?=$stx?>') {
    document.fsearch.sfl.value = '<?=$sfl?>';
}
</script>

