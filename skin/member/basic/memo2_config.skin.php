<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td align=left>&nbsp;<img src="<?=$memo_skin_path?>/img/btn_c_ok.gif" align=absmiddle />
  &nbsp;<b><?=$memo_title?> - ��������</b></td>
</tr>
</table>

<form name='fmemoform' method='post' enctype='multipart/form-data' onsubmit="return fmemoconfig_submit(document.fmemoform);">

<div class="section">
    <h2 class="hx">���μ���</h2>
    <div class="tx">
    <? if ($config[cf_memo_user_config]) { ?>
  			<table width="100%" border="0" cellspacing="0" cellpadding="2">
        <colgroup> 
        <col width="150">
        <col width="">
        </colgroup> 
        <? if ($config[cf_memo_realtime]) { ?>
        <tr>
          <td>�ǽð� ����</td>
          <td><input type=checkbox name=mb_realmemo value='1' <?=($member[mb_realmemo])?'checked':'';?>>�ǽð����� ���</td>
        </tr>
        <tr>
          <td>���� �˸�</td>
          <td><input type=checkbox name=mb_realmemo_sound value='1' <?=($member[mb_realmemo_sound])?'checked':'';?>>�����˸����(�ǽð����� ���ÿ��� ������)</td>
        </tr>
        <? } ?>

        <?
        $time_diff = ($g4[server_time] - (86400 * $config['cf_memo_no_reply'])) - strtotime($member[mb_memo_no_reply_datetime]);
        if ($config['cf_memo_no_reply'] && $time_diff > 0) {
        ?>
        <input type=hidden name=mb_memo_no_reply_org value="<?=$member[mb_memo_no_reply]?>">
        <tr>
            <td>�����߼���</td>
            <td><input type=checkbox name=mb_memo_no_reply value='1' <?=($member[mb_memo_no_reply])?'checked':'';?>>���ŵ� ������ �ڵ����� ������ ������ �����ϴ�.<BR>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
            <b>�����߼��� ������ �����ϸ� <font color="red"><?=$config['cf_memo_no_reply']?> ��</font> �Ŀ� ������ ����</b>
            </td>
        </tr>
        <tr>
            <?
            if (!$member['mb_memo_no_reply_text'])
                $member['mb_memo_no_reply_text'] = "������ �������� �������� ������ �Դϴ�. �����ֽ� ������ ������ ������ ������ Ȯ���� ���� �帮�ڽ��ϴ�";
            ?>
            <td>�����߾˸��޸�</td>
            <td><textarea class=ed name='mb_memo_no_reply_text' rows=5 style='width:98%;'><?=stripslashes($member[mb_memo_no_reply_text])?></textarea>
        </tr>
        <? } ?>

        </table>
    <? } else { ?>
        ������ �׸��� �����ϴ�.
    <? } ?>
    </div>
</div>

<? if ($is_admin == 'super') { ?>
<? include_once("$g4[admin_path]/admin.lib.php")?>
<div class="section" style="margin-top:5px">
    <h2 class="hx">�ý��ۼ���</h2>
    <div class="tx">
  			<table width="100%" border="0" cellspacing="0" cellpadding="2">
        <colgroup> 
        <col width="150">
        <col width="">
        </colgroup> 
        <tr>
            <td>�������� ��ϼ�</td>
            <td><input type=text required class=ed name='cf_memo_page_rows' size='5' required itemname='�������� ���' value='<?=$config[cf_memo_page_rows]?>'>
            </td>
        </tr>
        <tr>
            <td>���������� ���� ����Ʈ</td>
            <td><input type=text required class=ed name='cf_memo_send_point' size='5' required itemname='�������۽� ���� ����Ʈ' value='<?=$config[cf_memo_send_point]?>'> ��
            <!-- <BR>(����� �Է��Ͻʽÿ�. 0���� �Է��Ͻø� ���������� ����Ʈ�� �������� �ʽ��ϴ�.) -->
            </td>
        </tr>
        <tr>
            <td>���� ����</td>
            <td><input type=text class=ed name='cf_memo_del' value='<?=$config[cf_memo_del]?>' size=5 required > �� (�������� ���� ���� �ڵ� ����)
            </td>
        </tr>
        <tr>
            <td>������ ���� ����</td>
            <td><input type=text class=ed name='cf_memo_del_unread' value='<?=$config[cf_memo_del_unread]?>' size=5 required > �� (���� �����Ϻ��� ũ�ų� ����)
            </td>
        </tr>
        <tr>
            <td>������ �����ϼ�</td>
            <td><input type=text class=ed name='cf_memo_del_trash' value='<?=$config[cf_memo_del_trash]?>' size=5 required > �� (�������� ���� ������ �����뿡�� ����)
            </td>
        </tr>
        <tr>
            <td>dhtml ������</td>
            <td><input type=checkbox name=cf_memo_user_dhtml value='1' <?=($config[cf_memo_user_dhtml])?'checked':'';?>>dhtml ������ ���
            </td>
        </tr>
        <tr>
            <td width="150">��������Ʈ</td>
            <td><input type=checkbox name=cf_memo_print value='1' <?=($config[cf_memo_print])?'checked':'';?>> ���
            </td>
        </tr>
        <tr>
            <td>����/���� ��������</td>
            <td><input type=checkbox name=cf_memo_before_after value='1' <?=($config[cf_memo_before_after])?'checked':'';?>> ���
            </td>
        </tr>
        <tr>
            <td>÷������</td>
            <td><input type=checkbox name=cf_memo_use_file value='1' <?=($config[cf_memo_use_file])?'checked':'';?>>÷������ ��ɻ��
            </td>
        </tr>
        <tr>
            <td>�ִ�÷�����Ͽ뷮</td>
            <td><input type=text class=ed name='cf_memo_file_size' value='<?=$config[cf_memo_file_size]?>' size=5 required > M(�ް�) (�����ִ�뷮 : <?=ini_get("upload_max_filesize")?>, �Է¿�: 2, 4, 8)
            </td>
        </tr>
        <tr>
            <td>���κ�÷������ �ִ��ѵ�</td>
            <td><input type=text class=ed name='cf_max_memo_file_size' value='<?=$config[cf_max_memo_file_size]?>' size=5 required > M(�ް�) (�Է¿�, 0:���Ѿ���, 50, 100 )
            </td>
        </tr>
        <!--
        <tr>
            <td>���������� ÷�����ϻ���</td>
            <td><input type=checkbox name=cf_memo_del_file value='1' <?=($config[cf_memo_del_file])?'checked':'';?>>÷�������� �������� �����ϴ� ��ɻ��
            </td>
        </tr>
        -->
  			<tr>
            <td>�ǽð�����</td>
            <td>
            <input type=checkbox name=cf_memo_realtime value='1' <?=($config[cf_memo_realtime])?'checked':'';?>> �ǽð����� ����� ���
            </td>
        </tr>
        <tr>
            <td>ģ������</td>
            <td><input type=checkbox name=cf_friend_management value='1' <?=($config[cf_friend_management])?'checked':'';?>>ģ������ ��ɻ��
            </td>
        </tr>
        <tr>
            <td>�����߼��� ��������</td>
            <td><?=get_member_level_select(cf_memo_no_reply, 0, 7, $config[cf_memo_no_reply])?> �� (0 ���� �����ϸ� �����߼����� ������� ����)
            </td>
        </tr>
        <tr>
            <td>�����޸�</td>
            <td><textarea class=ed name='cf_memo_notice_memo' rows=3 style='width:98%;'><?=$config[cf_memo_notice_memo]?></textarea>
            </td>
        </tr>
  			<tr>
            <td>�Ҵ�resize/�Ҵ��</td>
            <td>
            <input type=checkbox name=cf_memo_b4_resize value='1' <?=($config[cf_memo_b4_resize])?'checked':'';?>> �Ҵ�resize/�Ҵ�� ����� ���
            </td>
        </tr>
   			<tr>
            <td>�̸��� �⺻���� ���</td>
            <td>
            <input type=checkbox name=cf_memo_mb_name value='1' <?=($config[cf_memo_mb_name])?'checked':'';?>> ��ϵ�� �̸��� �⺻���� ���
            </td>
        </tr>
  			<tr>
            <td>DB�� ���� ÷������ ����</td>
            <td>
	          <a href="#" onclick="tmpFileChk();">�����ϱ�</a>
            </td>
        </tr>
    </div>
</div>
<? } ?>

<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td align="center">
    <input id=btn_submit type=image src="<?=$memo_skin_path?>/img/send2.gif" border=0 alt="������" align='absmiddle'>
    </td>
</tr>
</table>

</form>
      
<script type="text/javascript">
function fmemoconfig_submit(f) {
    f.action = "./memo2_config_update.php";
    return true;
}

function tmpFileChk(){
	if(confirm('���� DB�� ���� ÷�������� �����մϱ�?')){
		location.href="./memo2_chkunlinkfile.php";
	}
}
</script>