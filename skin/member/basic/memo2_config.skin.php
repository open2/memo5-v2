<form name='fmemoform' method='post' enctype='multipart/form-data' onsubmit="return fmemoconfig_submit(document.fmemoform);">

      <table  width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="100%" height="2" align="center" valign="top" bgcolor="#FFFFFF">
            <table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="14">&nbsp;</td>
                <td width="20"><img src="<?=$memo_skin_path?>/img/btn_c_ok.gif" /></td>
                <td align=left><span class="style5">�����ϱ�</span></td>
              </tr>
            </table>
        </tr>
      </table>

			<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="5" height="5" background="<?=$memo_skin_path?>/img/memo_box2_tl.gif"></td>
          <td background="<?=$memo_skin_path?>/img/memo_line2_top.gif"></td>
          <td width="5" background="<?=$memo_skin_path?>/img/memo_box2_tr.gif"></td>
        </tr>
        <? if ($config[cf_memo_user_config]) { ?>
        <tr>
          <td background="<?=$memo_skin_path?>/img/memo_line2_left.gif">&nbsp;</td>
          <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
            <? if ($config[cf_memo_realtime]) { ?>
            <tr>
              <td width="14" height="25"></td>
              <td width="150">�ǽð� ����</td>
              <td><input type=checkbox name=mb_realmemo value='1' <?=($member[mb_realmemo])?'checked':'';?>>�ǽð����� ���</td>
            </tr>
            <tr>
              <td width="14" height="25"></td>
              <td width="150">���� �˸�</td>
              <td><input type=checkbox name=mb_realmemo_sound value='1' <?=($member[mb_realmemo_sound])?'checked':'';?>>�����˸����(�ǽð����� ���ÿ��� ������)</td>
            </tr>
            <? } ?>
            <? 
            if ($config['cf_memo_no_reply']) { 

            $time_diff = ($g4[server_time] - (86400 * $config['cf_memo_no_reply'])) - strtotime($member[mb_memo_no_reply_datetime]);
            if ($time_diff > 0) {
            ?>
            <input type=hidden name=mb_memo_no_reply_org value="<?=$member[mb_memo_no_reply]?>">
            <tr>
              <td width="14" height="25"></td>
              <td width="150">�����߼���</td>
              <td><input type=checkbox name=mb_memo_no_reply value='1' <?=($member[mb_memo_no_reply])?'checked':'';?>>���ŵ� ������ �ڵ����� ������ ������ �����ϴ�.<BR>
              </td>
            </tr>
            <tr>
              <td width="14" height="25"></td>
              <td width="150"></td>
              <td>
              <b>�����߼��� ������ �����ϸ� <font color="red"><?=$config['cf_memo_no_reply']?> ��</font> �Ŀ� ������ ����</b>
              </td>
            </tr>
            <tr>
              <?
              if (!$member['mb_memo_no_reply_text'])
                  $member['mb_memo_no_reply_text'] = "������ �������� �������� ������ �Դϴ�. �����ֽ� ������ ������ ������ ������ Ȯ���� ���� �帮�ڽ��ϴ�";
              ?>
              <td width="14" height="25"></td>
              <td width="150">�����߾˸��޸�</td>
              <td><textarea class=ed name='mb_memo_no_reply_text' rows=5 style='width:98%;'><?=stripslashes($member[mb_memo_no_reply_text])?></textarea>
            </tr>
            <? } ?>
            <? } ?>
            <tr><td>&nbsp;</td></tr>
          </table></td>
          <td background="<?=$memo_skin_path?>/img/memo_line2_right.gif">&nbsp;</td>
        </tr>
        <? } else { ?>
        <tr>
          <td background="<?=$memo_skin_path?>/img/memo_line2_left.gif">&nbsp;</td>
          <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height=40 align=center>������ �׸��� �����ϴ�.</td>
            </tr>
            </tr>
          </table></td>
          <td background="<?=$memo_skin_path?>/img/memo_line2_right.gif">&nbsp;</td>
        </tr>
        <? } ?>
        <tr>
          <td height="5" background="<?=$memo_skin_path?>/img/memo_box2_dl.gif"></td>
          <td background="<?=$memo_skin_path?>/img/memo_line2_down.gif"></td>
          <td background="<?=$memo_skin_path?>/img/memo_box2_dr.gif"></td>
        </tr>
      </table>

      <? if ($is_admin == 'super') { ?>

      <? include_once("$g4[admin_path]/admin.lib.php")?>
      <? // �⺻�� ����

      // ���� �������� 1���� ������ ������
      if ($config[cf_memo_del] < 1)
         $config[cf_memo_del] = 180;

      // ������ ���� �������� 1���� �۰ų� ���������Ϻ��� ������ ������
      if ($config[cf_memo_del_unread] < 1 or $config[cf_memo_del_unread] < $config[cf_memo_del])
          $config[cf_memo_del_unread] = $config[cf_memo_del];

      if (!$config[cf_memo_page_rows])    $config[cf_memo_page_rows] = 12;
      if (!$config[cf_memo_del_unread])   $config[cf_memo_del_unread] = $config[cf_memo_del];
      if (!$config[cf_memo_del_trash])    $config[cf_memo_del_trash] = $config[cf_memo_del];
      if (!$config[cf_memo_no_reply])     $config[cf_memo_no_reply] = 0;

      // �ִ� ���ε� ���� ������ (m�� �����Ǿ��� ��)
      if (!$config[cf_memo_file_size]) {
          $max_upload_size = intval(substr(ini_get("upload_max_filesize"), 0, -1));
          if ($max_upload_size > 4)
              $config[cf_memo_file_size] = "4";
          else
              $config[cf_memo_file_size] = intval(substr(ini_get("upload_max_filesize"), 0, -1));
      }

      if (!$config[cf_max_memo_file_size]) {
          $config[cf_max_memo_file_size] = 0;
      }
      ?>
      
      <BR>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="5" height=��"5" background="<?=$memo_skin_path?>/img/memo_box2_tl.gif"></td>
          <td background="<?=$memo_skin_path?>/img/memo_line2_top.gif"></td>
          <td width="5" background="<?=$memo_skin_path?>/img/memo_box2_tr.gif"></td>
        </tr>
        <tr>
          <td background="<?=$memo_skin_path?>/img/memo_line2_left.gif">&nbsp;</td>
          <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="14" height="25"></td>
              <td width="150">�������� ��ϼ�</td>
              <td><input type=text required class=ed name='cf_memo_page_rows' size='5' required itemname='�������� ���' value='<?=$config[cf_memo_page_rows]?>'>
              </td>
            </tr>
            <tr>
              <td width="14" height="25"></td>
              <td width="150">���������� ���� ����Ʈ</td>
              <td><input type=text required class=ed name='cf_memo_send_point' size='5' required itemname='�������۽� ���� ����Ʈ' value='<?=$config[cf_memo_send_point]?>'> ��
              <!-- <BR>(����� �Է��Ͻʽÿ�. 0���� �Է��Ͻø� ���������� ����Ʈ�� �������� �ʽ��ϴ�.) -->
              </td>
            </tr>
            <tr>
              <td width="14" height="25"></td>
              <td width="150">���� ����</td>
              <td><input type=text class=ed name='cf_memo_del' value='<?=$config[cf_memo_del]?>' size=5 required > �� (�������� ���� ���� �ڵ� ����)
              </td>
            </tr>
            <tr>
              <td width="14" height="25"></td>
              <td width="150">������ ���� ����</td>
              <td><input type=text class=ed name='cf_memo_del_unread' value='<?=$config[cf_memo_del_unread]?>' size=5 required > �� (���� �����Ϻ��� ũ�ų� ����)
              </td>
            </tr>
            <tr>
              <td width="14" height="25"></td>
              <td width="150">������ �����ϼ�</td>
              <td><input type=text class=ed name='cf_memo_del_trash' value='<?=$config[cf_memo_del_trash]?>' size=5 required > �� (�������� ���� ������ �����뿡�� ����)
              </td>
            </tr>
            <tr>
              <td width="14" height="25"></td>
              <td width="150">dhtml ������</td>
              <td><input type=checkbox name=cf_memo_user_dhtml value='1' <?=($config[cf_memo_user_dhtml])?'checked':'';?>>dhtml ������ ���
              </td>
            </tr>
            <tr>
              <td width="14" height="25"></td>
              <td width="150">��������Ʈ</td>
              <td><input type=checkbox name=cf_memo_print value='1' <?=($config[cf_memo_print])?'checked':'';?>> ���
              </td>
            </tr>
            <tr>
              <td width="14" height="25"></td>
              <td width="150">����/���� ��������</td>
              <td><input type=checkbox name=cf_memo_before_after value='1' <?=($config[cf_memo_before_after])?'checked':'';?>> ���
              </td>
            </tr>
            <tr>
              <td width="14" height="25"></td>
              <td width="150">÷������</td>
              <td><input type=checkbox name=cf_memo_use_file value='1' <?=($config[cf_memo_use_file])?'checked':'';?>>÷������ ��ɻ��
              </td>
            </tr>
            <tr>
              <td width="14" height="25"></td>
              <td width="150">�ִ�÷�����Ͽ뷮</td>
              <td><input type=text class=ed name='cf_memo_file_size' value='<?=$config[cf_memo_file_size]?>' size=5 required > M(�ް�) (�����ִ�뷮 : <?=ini_get("upload_max_filesize")?>, �Է¿�: 2, 4, 8)
              </td>
            </tr>
            <tr>
              <td width="14" height="25"></td>
              <td width="150">���κ�÷������ �ִ��ѵ�</td>
              <td><input type=text class=ed name='cf_max_memo_file_size' value='<?=$config[cf_max_memo_file_size]?>' size=5 required > M(�ް�) (�Է¿�, 0:���Ѿ���, 50, 100 )
              </td>
            </tr>
            <!--
            <tr>
              <td width="14" height="25"></td>
              <td width="150">���������� ÷�����ϻ���</td>
              <td><input type=checkbox name=cf_memo_del_file value='1' <?=($config[cf_memo_del_file])?'checked':'';?>>÷�������� �������� �����ϴ� ��ɻ��
              </td>
            </tr>
            -->
      			<tr>
              <td width="14" height="25"></td>
              <td width="150">�ǽð�����</td>
              <td>
              <input type=checkbox name=cf_memo_realtime value='1' <?=($config[cf_memo_realtime])?'checked':'';?>> �ǽð����� ����� ���
              </td>
            </tr>
            <tr>
              <td width="14" height="25"></td>
              <td width="150">ģ������</td>
              <td><input type=checkbox name=cf_friend_management value='1' <?=($config[cf_friend_management])?'checked':'';?>>ģ������ ��ɻ��
              </td>
            </tr>
            <tr>
              <td width="14" height="25"></td>
              <td width="150">�����߼��� ��������</td>
              <td><?=get_member_level_select(cf_memo_no_reply, 0, 7, $config[cf_memo_no_reply])?> �� (0 ���� �����ϸ� �����߼����� ������� ����)
              </td>
            </tr>
            <tr>
              <td width="14" height="25"></td>
              <td width="150">�����޸�</td>
              <td><textarea class=ed name='cf_memo_notice_memo' rows=3 style='width:98%;'><?=$config[cf_memo_notice_memo]?></textarea>
              </td>
            </tr>
      			<tr>
              <td width="14" height="25"></td>
              <td width="150">�Ҵ�resize/�Ҵ��</td>
              <td>
              <input type=checkbox name=cf_memo_b4_resize value='1' <?=($config[cf_memo_b4_resize])?'checked':'';?>> �Ҵ�resize/�Ҵ�� ����� ���
              </td>
            </tr>
      			<tr>
              <td width="14" height="25"></td>
              <td width="150">�̸��� �⺻���� ���</td>
              <td>
              <input type=checkbox name=cf_memo_mb_name value='1' <?=($config[cf_memo_mb_name])?'checked':'';?>> ��ϵ�� �̸��� �⺻���� ���
              </td>
            </tr>
      			<tr>
              <td width="14" height="25"></td>
              <td width="150">DB�� ���� ÷������ ����</td>
              <td>
				          <a href="#" onclick="tmpFileChk();">�����ϱ�</a>
              </td>
            </tr>
<!--
            <tr>
              <td width="14" height="25"></td>
              <td width="150">�����Խ���</td>
              <td><input type=text class=ed name='cf_memo_notice_board' size='16' itemname='���� �����Խ���' value='<?=$config[cf_memo_notice_board]?>'> (bo_table ���� �Է����ּ���)</td>
              </td>
            </tr>
-->
          </table></td>
          <td background="<?=$memo_skin_path?>/img/memo_line2_right.gif">&nbsp;</td>
        </tr>
        <tr>
          <td height="5" background="<?=$memo_skin_path?>/img/memo_box2_dl.gif"></td>
          <td background="<?=$memo_skin_path?>/img/memo_line2_down.gif"></td>
          <td background="<?=$memo_skin_path?>/img/memo_box2_dr.gif"></td>
        </tr>
      </table>
      
      <? } ?>
      
      <BR>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr align="center">
              <td align="center" class="style5">
                  <input id=btn_submit type=image src="<?=$memo_skin_path?>/img/send2.gif" border=0 alt="������" align='absmiddle'>
              </td>
          </tr>
      </table>
      
</form>
      
<script language="javascript">
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