<?
include_once("./_common.php");

$g4['title'] = "����5";

include_once("$g4[path]/head.sub.php");
include_once("$g4[path]/memo.config.php");

if (!$member['mb_id']) 
    alert_close("ȸ���� �̿��Ͻ� �� �ֽ��ϴ�.\\n\\nȸ���̽ö�� �α��� �� �̿��� ���ʽÿ�.");

// �ڵ��������� �����Ǿ� �ִ� ��쿡�� ������ ����� �� �����ϴ�.
if (!$is_admin && $member['mb_memo_no_reply'] && $kind != "memo_config")
    alert("������ ������ �����ؾ� ������ ����� �� �ֽ��ϴ�", "./memo.php?kind=memo_config");

// ���� �������� ���� ���� ������ ī���͸� ���ϱ�� �ý��ۿ� ��û�� �δ��� ���Ƿ� ���������� �մϴ�.
// �űԷ� ������ ������ ���� ��, ������ ���� ������ ���մϴ�.
// �̿ܿ��� ������ ������ ��, ������ ���� ī���͸� ���� ��, ������ ���� ������ ���ϱ���.
if ($g4['mb_memo_call_datetime'] == "0000-00-00 00:00:00" || $member['mb_memo_unread'] < 0) {
    $sql = " select count(*) as cnt from $g4[memo_recv_table] 
              where me_recv_mb_id = '$member[mb_id]' and me_read_datetime = '0000-00-00 00:00:00' ";
    $row = sql_fetch($sql);
    $total_count_recv_unread = $row['cnt'];
    
    // �׸��� ������ ���� ������ g4_member db�� ������Ʈ
    $sql = " update $g4[member_table] 
                set mb_memo_unread = '$total_count_recv_unread', mb_memo_call_datetime='0000-00-00 00:00:00' 
              where mb_id = '$member[mb_id]' ";
    sql_query($sql);
} else {
    $total_count_recv_unread = $member['mb_memo_unread'];
}

// ���� title �����ϱ�
switch ($kind) 
{ 
    case 'friend' : // ģ������
                  $memo_title = "ģ������";
                  break;
    case 'online' : // ����������
                  $memo_title = "����������";
                  break;
    case 'memo_group' : // �޸�׷�
                  $memo_title = "�޸�׷�";
                  break;
    case 'memo_group_admin' : // �޸�׷� ����
                  $memo_title = "�޸�׷����";
                  break;        
    case 'memo_config' : // ���� ����
                  $memo_title = "��������";
                  break;
    case 'memo_address_book' : // �ּҷ� ����
                  $memo_title = "�ּҷϰ���";
                  break;
    case 'write' : // ����������
                  $memo_title = "����������";
                  break;                  
    case 'send' : // �߽���
                  $memo_title = "����������";
                  break;
    case 'save' : // ������ (����/�߽� ��� ���� ������ ����)
                  $memo_title = "������������";
                  break;
    case 'trash': // ������ 
                  $memo_title = "������������";
                  break;
    case 'notice' : // ����������
                  $memo_title = "����������";
                  break; 
    case 'spam' : // ������ (������ �͸� ����������)
                  $memo_title = "����������";
                  break;
    case 'recv' : // ������
                  $memo_title = "����������";
                  break;
    default     : // �ƹ��� ������ ���� ���� ���������� ����
                  $memo_title = "����������";
                  $kind=recv;
                  break;
}

// �۾��� �Ҷ�
if ($kind == "write") {

    // ģ������ ����� ����Ϸ���
    if ($config['cf_friend_management'] == true) {

        // join�� ���� �ʰ�, loop�� ������. �װ� ���� ������.
        $sql = " select fr_id from $g4[friend_table] where mb_id = '$member[mb_id]' ";
        $qry = sql_query($sql);

        $my_friend = array();
        $i = 0;

        while ($row = sql_fetch_array($qry))
        {
            $mb = get_member($row['fr_id'], "mb_nick");
            $my_friend[$i]['mb_nick'] = $mb['mb_nick'];
            $my_friend[$i]['fr_id'] = $row['fr_id'];
            $i++;
       }
    }

    // ���иӸ� ���� ��ġ�� �մϴ�
    $delay = $_SESSION['sm_datetime2'] - $g4['server_time'] + $g4['memo_delay_sec'];
    if ($delay > 0 && !$is_admin) 
        alert("�ʹ� ���� �ð����� ������ �����ؼ� ���� �� �����ϴ�.");
    set_session("sm_datetime2", $g4['server_time']);

    // �ϳ��� ���̵�� ������ �ٸ��� �ϴ� �ѵ��� ���ؼ� ��Ű�� ���� ���ϴ�.
    if (get_cookie("cm_datetime2") >= ($g4['server_time'] - $g4['memo_delay_sec']) && !$is_admin) 
        alert("�ʹ� ���� �ð����� ������ �����ؼ� ���� �� �����ϴ�.");
    @set_cookie("cm_datetime2", "$g4[server_time]", 86400) ;
}

// kind�� ���� action~!!!
switch ($kind) {

    case 'memo_config'      : // ���� ����

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
        break;

    case 'friend'           : // ģ������
    case 'online'           : // ����������
    case 'memo_group'       : // �޸�׷�
    case 'memo_group_admin' : // �޸�׷� ����
        break;
        
    case 'memo_address_book' : // �ּҷ� ����

        // mysql 4.0.x���� union all�� �������� �ʾƼ� �����ϰ� query�� 4�� ���� �մϴ�. ����~
        $addr = array();
        $sql = " select 'recv' as type, a.me_send_mb_id as mb_id, count(*) as cnt, b.mb_name, b.mb_nick, b.mb_email, b.mb_homepage from $g4[memo_recv_table] a left join $g4[member_table] b on a.me_send_mb_id = b.mb_id where a.me_recv_mb_id = '$member[mb_id]' group by a.me_send_mb_id ";
        $res1 = sql_query($sql);
        if ($res1) {
            for ($i=0; $row=sql_fetch_array($res1); $i++) {
                $addr[] = $row;
            }
        }
        
        $sql = " select 'send' as type, a.me_recv_mb_id as mb_id, count(*) as cnt, b.mb_name, b.mb_nick, b.mb_email, b.mb_homepage from $g4[memo_send_table] a left join $g4[member_table] b on a.me_recv_mb_id = b.mb_id where a.me_send_mb_id = '$member[mb_id]' group by a.me_recv_mb_id ";
        $res1 = sql_query($sql);
        if ($res1) {
            for ($i=0; $row=sql_fetch_array($res1); $i++) {
                $addr[] = $row;
            }
        }

        $sql = " select 'save_send' as type, a.me_recv_mb_id as mb_id, count(*) as cnt, b.mb_name, b.mb_nick, b.mb_email, b.mb_homepage from $g4[memo_save_table] a left join $g4[member_table] b on a.me_recv_mb_id = b.mb_id where a.memo_owner = '$member[mb_id]' and memo_type='send' group by a.me_recv_mb_id ";
        $res1 = sql_query($sql);
        if ($res1) {
            for ($i=0; $row=sql_fetch_array($res1); $i++) {
                $addr[] = $row;
            }
        }

        $sql = " select 'save_recv' as type, a.me_send_mb_id as mb_id, count(*) as cnt, b.mb_name, b.mb_nick, b.mb_email, b.mb_homepage from $g4[memo_save_table] a left join $g4[member_table] b on a.me_send_mb_id = b.mb_id where a.memo_owner = '$member[mb_id]' and memo_type='recv' group by a.me_send_mb_id ";
        $res1 = sql_query($sql);
        if ($res1) {
            for ($i=0; $row=sql_fetch_array($res1); $i++) {
                $addr[] = $row;
            }
        }
        
        foreach ($addr as $row) {
            $list[$row['mb_id']][$row['type']] = $row['cnt'];
            $list[$row['mb_id']]['mb_id'] = $row['mb_id'];
            if ($config['cf_memo_mb_name']) $row['mb_nick'] = $row['mb_name'];
            $list[$row['mb_id']]['mb_nick'] = $row['mb_nick'];
        
            if ($row['mb_nick'])
                if ($config['cf_memo_mb_name'])
                    $mb_nick = $row['mb_name'];
                else
                    $mb_nick = $row['mb_nick'];
            else
                $mb_nick = "<font color=silver>��������</font>";
            $name = get_sideview($row['mb_id'], $row['mb_nick'], $row['mb_email'], $row['mb_homepage']);

            $list[$row['mb_id']]['name'] = $name;
        }

        // �ּҷ� ��ü ����
        $tot_cnt = count($list);

        break;
        
    case 'write'  : // ����������

        // �Ҵ��� ������� ���, mobile device������ dhtml�� �� ���� ����
        if (!$g4['b4_version']) {
            // mobile device���� üũ - http://detectmobilebrowsers.com/
            $g4['g4_mobile_device'] = false;
            $useragent=$_SERVER['HTTP_USER_AGENT'];
            if(preg_match('/android.+mobile|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
                $g4['g4_mobile_device'] = true;
        }
        if ($g4['g4_mobile_device'])
            $is_dhtml_editor = false;

        // �׷�߼��� ��� ...
        if ($gr_id) { 
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

        // ÷������ �������� ���
        if ($config[cf_memo_use_file]) {
            // ����ں� �Ҵ� ������ disk �뷮 ������ ���� ���, �̰��� �ý��ۿ��� exec ����� �����ؾ� ����
            if ($config[cf_max_memo_file_size]) {
                $memo_dir_size = get_dir_size($memo_file_path);
                // exec ������ �ִ� ��쿡��, �ִ� �޸� ÷�� ���� �뷮�� 20��� ����
                if ($memo_dir_size == "error")
                    $memo_dir_msg = "�ý��ۿ��� ���丮 ��뷮 ������ ������� �ʽ��ϴ�.<BR>�������� ������������ ���κ�÷������ �ִ��ѵ��� 0���� �����ϱ� �ٶ��ϴ�.";
                else {
                     $memo_dir = (int) $memo_dir_size / 1000;
                     if ($memo_dir > $config[cf_max_memo_file_size])
                        $memo_dir_msg = "��ü÷������ �뷮 <?=$config[cf_max_memo_file_size]?> M(�ް�)�� �ʰ��ؼ� ������ ÷���� �� �����ϴ�.<BR>÷�������� �ִ� �߽������� �����Ͻñ� �ٶ��ϴ�.";
                }
            }
        }

        // �������� �������� ���
        if ($option == 'notice') {
            if ($is_admin)
                $write_header_msg = "( <font color='red'><b>���������� ����� �� �����ϴ�. �����ϰ� �ۼ��� �ּ���</b></font> )";
            else {
                $me_recv_mb_id = 'notice';
                alert("���������� �����ڸ� �߼��� �� �ֽ��ϴ�");
            }
        }

        // ���ϴ� ������ ��� ������ ���� ������ ... 
          if ($me_id) {
          switch ($me_box) {
              case 'recv' : $from_table = $g4[memo_recv_table]; break;
              case 'save' : $from_table = $g4[memo_save_table]; break;
              default     : alert("me_box ���� �Դϴ�");
          }
          $sql = " select me_memo, me_subject, me_send_mb_id, me_option from $from_table where me_id = '$me_id' ";
          $view = sql_fetch($sql);
          
          $subject = "Re) " . $view[me_subject];
          $view[me_memo] = stripslashes($view[me_memo]);
          
          if ($is_dhtml_editor) {

          $html = 1;
          $view[memo] = conv_content($view[me_memo], $html);

          $view[memo] = $view[me_memo];
          $content = "<br><br>"
                   . "<br>>  "
                   . "<br>>  " . preg_replace("/<BR>/", "<BR>>  ", $view[memo]) 
                   . "<br>>  "
                   . "<br>>  ";

          } else {

          $tags = array("<BR>");
          $view[memo] = strip_tags($view[me_memo], $tags);
          $content = "\n\n\n>"
                   . "\n>"
                   . "\n> " . preg_replace("/\n/", "\n> ", $view[memo]) 
                   . "\n>"
                   . "\n";
          
          }
        }

break;

    case 'recv'   : // ������
    case 'send'   : // �߽���
    case 'save'   : // ������ (����/�߽� ��� ���� ������ ����)
    case 'trash'  : // ������
    case 'notice' : // ����������
    case 'spam'   : // ������ (������ �͸� ����������)

    if ($class == 'view') { // ���� �б�

        // $me_id�� ���� ���
        if (!$me_id)
            alert("���� ������ �����ϴ�.");

        // Ʃ���� ���ؼ� select�� �ʵ带 ����
        $memo_select = " me_id, me_recv_mb_id, me_send_mb_id, me_send_datetime, me_read_datetime, me_memo, me_file_local, me_file_server, me_subject, memo_type, memo_owner, me_option";

        switch ($kind) { // �����б�
        case 'send' : 
            $sql = " select $memo_select from $g4[memo_send_table] where me_send_mb_id = '$member[mb_id]' and me_id = '$me_id' "; 
            if ($config[cf_memo_before_after]) {
                $sql_before = " select max(me_id) as before_id from $g4[memo_send_table] where me_send_mb_id = '$member[mb_id]' and me_id < '$me_id' "; 
                $sql_after  = " select min(me_id) as after_id from $g4[memo_send_table] where me_send_mb_id = '$member[mb_id]' and me_id > '$me_id' "; 
            }
            break;
        case 'save' : 
            $sql = " select $memo_select from $g4[memo_save_table] where memo_owner = '$member[mb_id]' and me_id = '$me_id' "; 
            if ($config[cf_memo_before_after]) {
                $sql_before = " select max(me_id) as before_id from $g4[memo_save_table] where memo_owner = '$member[mb_id]' and me_id < '$me_id' "; 
                $sql_after = " select min(me_id) as after_id from $g4[memo_save_table] where memo_owner = '$member[mb_id]' and me_id > '$me_id' "; 
            }
            break;
        case 'trash' : 
            $sql = " select $memo_select, me_from_kind from $g4[memo_trash_table] where me_id = '$me_id' "; 
            if ($config[cf_memo_before_after]) {
                $sql_before = " select max(me_id) as before_id from $g4[memo_notice_table] where me_id < '$me_id' "; 
                $sql_after = " select min(me_id) as after_id from $g4[memo_notice_table] where me_id > '$me_id' "; 
            }
            break;
        case 'notice' : 
            $sql = " select $memo_select from $g4[memo_notice_table] where me_id = '$me_id' "; 
            if ($config[cf_memo_before_after]) {
                $sql_before = " select max(me_id) as before_id from $g4[memo_notice_table] where me_id < '$me_id' "; 
                $sql_after = " select min(me_id) as after_id from $g4[memo_notice_table] where me_id > '$me_id' "; 
            }
            break;
        case 'spam' : 
            if ($is_admin) 
               $sql = " select $memo_select from $g4[memo_spam_table] where me_id = '$me_id' ";
            else
               $sql = " select $memo_select from $g4[memo_spam_table] where me_recv_mb_id = '$member[mb_id]' and me_id = '$me_id' "; 
            if ($config[cf_memo_before_after]) {
                if ($is_admin) 
                {
                   $sql_before = " select max(me_id) as before_id from $g4[memo_spam_table] where me_id < '$me_id' "; 
                   $sql_after = " select min(me_id) as after_id from $g4[memo_spam_table] where me_id > '$me_id' "; 
                }
                else
                {
                   $sql_before = " select max(me_id) as before_id  from $g4[memo_spam_table] where me_recv_mb_id = '$member[mb_id]' and me_id < '$me_id' "; 
                   $sql_after = " select min(me_id) as after_id  from $g4[memo_spam_table] where me_recv_mb_id = '$member[mb_id]' and me_id > '$me_id' "; 
                }
            }
            break;
        case 'recv' : 
            $sql = " select $memo_select from $g4[memo_recv_table] where me_recv_mb_id = '$member[mb_id]' and me_id = '$me_id' "; 
            if ($config[cf_memo_before_after]) {
                $sql_before = " select max(me_id) as before_id from $g4[memo_recv_table] where me_recv_mb_id = '$member[mb_id]' and me_id < '$me_id' "; 
                $sql_after = " select min(me_id) as after_id from $g4[memo_recv_table] where me_recv_mb_id = '$member[mb_id]' and me_id > '$me_id' "; 
            }
            break;
        }
        $view = sql_fetch($sql);

        // sql �˻������ 0 �϶� - ������ ���ų� ������ ���� ������ ���
        if (count($view) == 1) 
            alert("�ٸ��� ���� �����̰ų� ���� ������ �����ϴ�.");

        $before_id = "";
        if ($sql_before) {
            $result_before = sql_fetch($sql_before);
            $before_id = $result_before['before_id'];
        }

        $after_id = "";
        if ($sql_after) {
            $result_after = sql_fetch($sql_after);
            $after_id = $result_after['after_id'];
        }

        // html �ɼ�
        $html = 2; // �⺻���� \n�� <br>�� �ٲ��ݴϴ�. ����5������ $html = 0�� ������� �ʽ��ϴ�. $html�� ���� ������ ������ $html=2�� �ν� �մϴ�.
        if (strstr($view[me_option], "html1"))
            $html = 1;
        $view[me_memo] = stripslashes($view[me_memo]);
        $view[memo] = conv_content($view[me_memo], $html);

        // �̹��� resize�� ���ؼ� (bbs/view.php���� �ڵ� ����)
        $view[memo] = preg_replace("/(\<img )([^\>]*)(\>)/i", "\\1 name='target_resize_image[]' onclick='image_window(this)' style='cursor:pointer;' \\2 \\3", $view[memo]);

        // �߽��� sideview
        $mb_send = get_member($view[me_send_mb_id], "mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_signature");
        if ($config[cf_memo_mb_name]) $mb_send[mb_nick] = $mb_send[mb_name];
        $view[me_send_mb_id_nick] = get_sideview($mb_send[mb_id], $mb_send[mb_nick], $mb_send[mb_email], $mb_send[mb_homepage]);

        // ������ sideview
        $mb_recv = get_member($view[me_recv_mb_id], "mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_today_login");
        if ($config[cf_memo_mb_name]) $mb_recv[mb_nick] = $mb_recv[mb_name];
        $view[me_recv_mb_id_nick] = get_sideview($mb_recv[mb_id], $mb_recv[mb_nick], $mb_recv[mb_email], $mb_recv[mb_homepage]);

         // ������ ���� ��¥�� update
        if (substr($view[me_read_datetime],0,1) == '0') { // ������ ���� �ʾ��� ��

            if ($kind == "recv") { // �������� ���� ���� ������ ���� ��¥�� ������Ʈ
              $sql = " update $g4[memo_recv_table] set me_read_datetime = '$g4[time_ymdhis]' where me_id = '$me_id' "; 
              sql_query($sql);
              $sql = " update $g4[memo_send_table] set me_read_datetime = '$g4[time_ymdhis]' where me_id = '$me_id' "; 
              sql_query($sql);
              $sql = " update $g4[memo_save_table] set me_read_datetime = '$g4[time_ymdhis]' where me_id = '$me_id' "; 
              sql_query($sql);
              $view[me_read_datetime] = $g4[time_ymdhis];
              
              // ������ ���� ������ ������Ʈ (ó�� ����5�� �� ��, ������ ������ ������Ʈ ������, ������ �ϸ� �˴ϴ�.
              sql_query(" update $g4[member_table] set mb_memo_unread = mb_memo_unread - 1 where mb_id = '$member[mb_id]' ");
              
              // ���� ���α׷����� �������� ���� ���� ���� count�� ������Ʈ
              $total_count_recv_unread = $member['mb_memo_unread'] - 1;

            } else {
              $time_diff = strtotime($mb_recv['mb_today_login']) - strtotime($view['me_send_datetime']);
              if ($kind=='send' && $time_diff <= 0)
                  $view[me_read_datetime] = '���� ����';       
              else
                  $view[me_read_datetime] = '���� ����';
            }

        }

        // ÷�������� image ���θ� Ȯ��
        $view[imagesize] = @getimagesize("{$g4[data_path]}/memo2/{$view[me_file_server]}");
        $img_type = $view[imagesize][2];
        if ($img_type >= 1 && $img_type <= 18)
            $view[valid_image] = 1;
        else
            $view[valid_image] = 0;

        // href 
        $view[save_href] = "./memo2_form_save.php?me_id=$me_id&kind=$kind";
        
        // ����, �����ڲ��� �Ű��� �� ���� �ϱ�
        if ($view[me_send_mb_id] == $member[mb_id] || is_admin($view[me_send_mb_id]))
        {
            $view[spam_href] = "";
        } else {
            $view[spam_href] = "./memo2_form_spam.php?me_id=$me_id&kind=$kind";
        }
        $view[del_href] = "./memo2_form_delete.php?me_id=$me_id&kind=$kind";
        $view[cancel_href] = "./memo2_form_cancel.php?me_id=$me_id&kind=$kind";
        
        if ($kind == "trash")
            $view[recover_href] = "./memo2_form_recover.php?me_id=$me_id&me_from_kind=$view[me_from_kind]";
            
        if ($before_id) 
          $view[before_href] = "./memo.php?me_id=$before_id&kind=$kind&class=view";
        else
          $view[before_href] = "";
      
        if ($after_id)
          $view[after_href] = "./memo.php?me_id=$after_id&kind=$kind&class=view";
        else
          $view[after_href] = "";
    
        break;

    } else { // view�� �ƴ� ���? �׷��� ��Ϻ���¡. ����

        $sql_search = "";
    
        // �� ���� ������ ��󺸴°� ������
        if ($kind == "recv" && $unread == "only")
            $sql_search_unread = " and me_read_datetime = '0000-00-00 00:00:00' ";
        else
            $sql_search_unread = "";
    
        if ($stx && $sfl) { // �˻��� �ϴ� ���
          switch ($sfl) {
            case 'me_send_mb_nick'  : 
                if ($config['cf_memo_mb_name'])
                    $resm = sql_fetch(" select mb_id from $g4[member_table] where mb_name = '$stx' ");
                else
                    $resm = sql_fetch(" select mb_id from $g4[member_table] where mb_nick = '$stx' ");
                if (!$resm)
                    alert("�Է��Ͻ� mb_nick/mb_name�� �����ϴ�.");
                else
                    $sql_search = " and me_send_mb_id = '$resm[mb_id]' ";
                break;
            case 'me_send_mb_id'    : 
                $sql_search = " and me_send_mb_id = '$stx' ";
                break;
            case 'me_recv_mb_nick'  : 
                if ($config['cf_memo_mb_name'])
                    $resm = sql_fetch(" select mb_id from $g4[member_table] where mb_name = '$stx' ");
                else
                    $resm = sql_fetch(" select mb_id from $g4[member_table] where mb_nick = '$stx' ");
                if (!$resm)
                    alert("�Է��Ͻ� mb_nick/mb_name�� �����ϴ�.");
                else
                    $sql_search = " and me_recv_mb_id = '$resm[mb_id]' ";
                break;
            case 'me_recv_mb_id'    : 
                $sql_search = " and me_recv_mb_id = '$stx' ";
                break;
            case 'me_subject'       : 
                $sql_search = " and me_subject like '%$stx%' ";
                break;
            case 'me_memo'          : 
                $sql_search = " and me_memo like '%$stx%' ";
                break;
            case 'me_subject_memo':
                $sql_search = " and ( me_subject like '%$stx%' or me_memo like '%$stx%' )";
                break;
            case 'me_file'          : 
                $sql_search = " and me_file_local != '' ";
                break;
            default :
          }
        }
    
        switch ($kind) {
        case 'send' : // �߽���
                      $sql = " select count(*) as cnt 
                                  from  $g4[memo_send_table]
                                  where me_send_mb_id = '$member[mb_id]' $sql_search ";
    
                      break;
        case 'save' : // ������ (����/�߽� ��� ���� ������ ����)
                      $sql = " select count(*) as cnt 
                                  from $g4[memo_save_table]
                                  where memo_owner = '$member[mb_id]' $sql_search  ";
                      break;
        case 'trash': // ������
                      $sql = " select count(*) as cnt 
                                  from $g4[memo_trash_table]
                                  where memo_owner = '$member[mb_id]' $sql_search ";
                      break;
        case 'notice' : // ��ü������
                      $sql = " select count(*) as cnt 
                                  from $g4[memo_notice_table] 
                            where memo_owner = '$member[mb_id]' ";
                      break;
        case 'spam' : // ������ (������ �͸� ����������)
                      if ($is_admin)
                          $sql = " select count(*) as cnt 
                                      from $g4[memo_spam_table]
                                   where 1 $sql_search ";
                      else 
                          $sql = " select count(*) as cnt 
                                      from $g4[memo_spam_table]
                                      where me_recv_mb_id = '$member[mb_id]' $sql_search ";
                      break;
        case 'recv' : // ������
                      $sql = " select count(*) as cnt 
                                  from $g4[memo_recv_table]
                                  where me_recv_mb_id = '$member[mb_id]' $sql_search $sql_search_unread ";
                      break;
        }
    
        // ������ ���Ϲڽ��� ��ü ���� ����
        $row = sql_fetch($sql);
        $total_count = $row['cnt'];
    
        // ������ ������ ��쿡�� ��ü ���� ������ ������Ʈ - ���� ���ص� �ɰ� ������, �ִ� �����ϱ� �Ẹ�°ž�.
        if ($kind == "recv" && $unread == "only") {
            sql_query(" update $g4[member_table] set mb_memo_unread = '$row[cnt]' where mb_id = '$member[mb_id]' ");
        }
    
        // ����¡
        if (!$config['cf_memo_page_rows'] || $config['cf_memo_page_rows'] < 0)
            $one_rows = 20;
        else
            $one_rows = $config['cf_memo_page_rows'];
        $total_page  = ceil($total_count / $one_rows);  // ��ü ������ ��� 
        if ($page == "") { $page = 1; } // �������� ������ ù ������ (1 ������) 
        $from_record = ($page - 1) * $one_rows; // ���� ���� ���� 
    
        // ���ϸ�� ��������
        $order_by = " order by me_id desc ";
        $select_sql = " me_recv_mb_id, me_send_mb_id, me_read_datetime, me_send_datetime, me_subject, me_id, me_file_local ";
    
        // �������� ��쿡�� ��ó������ ���� �о���� ��
        if ($kind == "trash")
            $select_sql = $select_sql . ", me_from_kind";
    
        // ���� ������� �����;���?
        switch ($kind) {
        case 'send' : // �߽���
                      $sql = " select $select_sql 
                                 from $g4[memo_send_table]
                                 where me_send_mb_id = '$member[mb_id]' $sql_search 
                                 $order_by 
                                 limit $from_record, $one_rows";
                      break;
        case 'save' : // ������ (����/�߽� ��� ���� ������ ����)
                      $sql = " select $select_sql, memo_type
                                 from $g4[memo_save_table]
                                 where memo_owner = '$member[mb_id]' $sql_search
                                 $order_by 
                                 limit $from_record, $one_rows";
                      break;
        case 'trash': // ������
                      $sql = " select $select_sql, memo_type
                                 from $g4[memo_trash_table]
                                 where memo_owner = '$member[mb_id]' $sql_search 
                                 $order_by 
                                 limit $from_record, $one_rows";
                      break;
        case 'notice' : // ��ü������
                      $sql = " select $select_sql
                                 from $g4[memo_notice_table] a left join $g4[member_table] b on ( a.me_send_mb_id = b.mb_id )
                                where memo_owner = '$member[mb_id]'
                                 $sql_search 
                                 order by me_id desc 
                                 limit $from_record, $one_rows";
                      break;
        case 'spam' : // ������ (������ �͸� ����������
                      if ($is_admin)
                      $sql = " select $select_sql
                                 from $g4[memo_spam_table]
                                 where 1 $sql_search
                                 $order_by 
                                 limit $from_record, $one_rows";
                      else
                      $sql = " select $select_sql
                                 from $g4[memo_spam_table]
                                 where me_recv_mb_id = '$member[mb_id]' $sql_search 
                                 $order_by 
                                 limit $from_record, $one_rows";                  
                      break;
        case 'recv' : // ������
                      $sql = " select $select_sql 
                                 from $g4[memo_recv_table]
                                 where me_recv_mb_id = '$member[mb_id]' $sql_search $sql_search_unread 
                                 order by me_id desc 
                                 limit $from_record, $one_rows";
                      break;
        }
        $result = sql_query($sql);
    
        // ��������� $list�� �����ϱ�
        $list = array();
    
        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            $list[$i] = $row;
        
            switch ($kind) { // ���� ��Ͽ� ���̴� ���̵� ����
                case 'send' : // �߽���
                              $kind_mb_id = get_member($row['me_recv_mb_id'], "mb_id, mb_name, mb_nick, mb_email, mb_homepage");
                              $list_title = "�޴»��";
                              break;
                default : 
                              $kind_mb_id = get_member($row['me_send_mb_id'], "mb_id, mb_name, mb_nick, mb_email, mb_homepage");
                              $list_title = "�������";
            }
        
             if ($config['cf_memo_mb_name']) $kind_mb_id['mb_nick'] = $kind_mb_id['mb_name'];
             $row['mb_nick'] = $kind_mb_id['mb_nick'];
             $row['mb_id'] = $kind_mb_id['mb_id'];
             $row['mb_email'] = $kind_mb_id['mb_email'];
             $row['mb_homepage'] = $kind_mb_id['mb_homepage'];
            
            $name = get_sideview($row['mb_id'], $row['mb_nick'], $row['mb_email'], $row['mb_homepage']);
        
            // ������ ��� �ð����� ǥ���� (�����ð�)
            if (substr($row['me_read_datetime'],0,1) == '0') {
                // �߽����� ������ ���� ��� ���ž���(������ �α��� ��� �ִ��� ����)�� ���� ȸ�� ���� �� �����;���
                if ($kind == "send") {
                    $mb = get_member($row[me_recv_mb_id], "mb_today_login");
                    $time_diff = strtotime($mb['mb_today_login']) - strtotime($row['me_send_datetime']);
                    if ($time_diff <= 0)
                        $read_datetime = '���� ����';       
                    else
                        $read_datetime = '���� ����';
                } else {
                    $read_datetime = '���� ����';
                }
                
                $mb = get_member($row[mb_recv_mb_id], "mb_today_login");
    
            } else {
                if (substr($row[me_read_datetime],0,10) == $g4['time_ymd'])
                    $read_datetime = substr($row[me_read_datetime],11,5);
                else
                    $read_datetime = substr($row[me_read_datetime],5,5);
            }
        
            // ������ ��� �ð����� ǥ���� (�����ð�)
            if (substr($row[me_send_datetime],0,10) == $g4['time_ymd'])
                $send_datetime = substr($row[me_send_datetime],11,5);
            else
                $send_datetime = substr($row[me_send_datetime],5,5);
        
            $list[$i][name] = $name;
            if (strlen($row[me_subject]) ==0) // ������� ��쿡 ����������� ǥ��
                $list[$i][subject] = "������ �����ϴ�";
            else
                $list[$i][subject] = strip_tags($row[me_subject]);
            
            // �������� ��쿡�� �Խñ��� ��ó�� ǥ��
            if ($kind == "trash")
                $list[$i][subject] = "[" . $row[me_from_kind] . "] " . $list[$i][subject];
    
            $list[$i][read_datetime] = $read_datetime;
            $list[$i][send_datetime] = $send_datetime;

            $list[$i][view_href] = "./memo.php?me_id=$row[me_id]&kind=$kind&class=view";
            // �������� ��쿡�� �Խñ��� ��ó�� ǥ��
            if ($kind == "trash")
                $list[$i][view_href] = $list[$i][view_href] . "&me_from_kind=$row[me_from_kind]";

            $list[$i][me_file] = $row[me_file_local];
        } // end of for loop
    
    } // end of if ($class)
} // end of switch($kind)

// ����5 ��Ų�� �о���Դϴ�.
include_once("$memo_skin_path/memo2.skin.php");

include_once("$g4[path]/tail.sub.php");
?>