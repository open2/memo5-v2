<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!$member[mb_id])
    alert("ȸ���� �̿��Ͻ� �� �ֽ��ϴ�.");

$me_send_mb_id    = $_POST[me_send_mb_id];
$me_subject       = $_POST[me_subject];

$notice_level_1   = $_POST[notice_level_1];
$notice_level_2   = $_POST[notice_level_2];

if ($memo_level_1 > $memo_level_2)
    alert("memo_update - ȸ�������� �ٸ��� ������ �ּ���");
    
$me_send_mb_id = trim($me_send_mb_id);
if ($me_send_mb_id == $member[mb_id]) {} else
    alert("memo_update - �ٸ��� ���� ����Դϴ�.");

if (!$is_admin)
    alert("�����ڸ� ����� �� �ֽ��ϴ�.");

if ($me_subject == '')
    alert("���� ������ �Էµ��� �ʾҽ��ϴ�.");

$sql = " select mb_id 
           from $g4[member_table] 
          where mb_leave_date = '' and mb_intercept_date = '' and mb_level >= '$notice_level_1' and mb_level <= '$notice_level_2' ";
$notice_list = sql_query($sql);

// ���ϸ� �ʱ�ȭ
$file_name0 = '';
$file_name3 = '';

// ���� INSERT (���� ������)
$sql = " insert into $g4[memo_notice_table]
                ( me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo, me_subject, memo_type, memo_owner, me_file_local, me_file_server, me_option )
         values ( '$notice_level_1-$notice_level_2', '$member[mb_id]', '$g4[time_ymdhis]', '$me_memo', '$me_subject', 'send', '$member[mb_id]', '$file_name0', '$file_name3', '$html,$secret,$mail' ) ";
sql_query($sql);
$me_id = mysql_insert_id();

if ($_FILES[memo_file][name]) {
    // ȸ������ ���丮�� ����
    $dir_name = $g4[path] . "/data/memo2/" . $member[mb_id];
    if(!is_dir($dir_name)){
        @mkdir("$dir_name", 0707);
        @chmod("$dir_name", 0707);
    }
    
    // �Ʒ��� ���ڿ��� �� ������ -x �� �ٿ��� ����θ� �˴��� ������ ���� ���ϵ��� ��
    $file_name0 = $_FILES[memo_file][name];
    $file_name1 = intval($me_id) . "_" . preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $file_name0);
    $file_name2 = str_replace('%', '', urlencode($file_name1));

   	@move_uploaded_file($_FILES[memo_file][tmp_name], "$dir_name/$file_name2");
  	@chmod("$dir_name/$file_name2", 0606);

    $file_name3 = $member[mb_id] . "/" . $file_name2;
    $sql = " update $g4[memo_notice_table]
                set me_file_local = '$file_name0', me_file_server = '$file_name3' 
                where me_id = $me_id ";
    sql_query("$sql");
}

for ($i=0; $mb_recv = sql_fetch_array($notice_list); $i++) {
    $mb_list = $mb_recv[mb_id];
    
    if (trim($mb_list)) {
                  
        // ���� INSERT (������ - me_id�� �߽����� me_id�� �����ϰ� ����)
        $sql = " insert into $g4[memo_recv_table]
                        ( me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo, me_subject, memo_type, memo_owner, me_file_local, me_file_server, me_option )
                 values ( '$mb_list', '$member[mb_id]', '$g4[time_ymdhis]', '$me_memo', '$me_subject', 'recv', '$mb_list', '$file_name0', '$file_name3', '$html,$secret,$mail' ) ";
        sql_query($sql);

        // �ǽð� ���� �˸� ���
        $sql = " update $g4[member_table]
                    set mb_memo_call = '$member[mb_id]'
                  where mb_id = '$mb_list' ";
        sql_query($sql);
    }
} // for - loop�� ���κ�

alert("\'$i\' ���� ��ü ������ �����Ͽ����ϴ�.", "./memo.php?kind=notice");
?>