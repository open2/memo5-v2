<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!defined("_GNUBOARD_")) exit; // ���� ������ ���� �Ұ�

if (!$member[mb_id])
    alert("ȸ���� �̿��Ͻ� �� �ֽ��ϴ�.");

// �ش� �Խñ��� �����ϴ��� ���θ� Ȯ��
$sql = " select * from $g4[memo_trash_table] where me_id = '$me_id' and me_from_kind = '$me_from_kind' ";
$result = sql_fetch($sql);

if ($result['me_id']) {
    // ������ ���������� ����
    $sql_select = " me_id, me_recv_mb_id, me_send_mb_id,me_send_datetime,me_read_datetime, me_memo, me_file_local, me_file_server, me_subject, memo_type, memo_owner, me_option ";
    $sql_table = "memo_{$me_from_kind}_table";
    $sql = " insert into $g4[$sql_table] select $sql_select from $g4[memo_trash_table] where me_id = '$me_id' and me_from_kind = '$me_from_kind' ";
    sql_query($sql);

    // ������ �������� ������...
    $sql = " delete from $g4[memo_trash_table] where me_id = '$me_id' and me_from_kind = '$me_from_kind'  ";
    sql_query($sql);
    
    if ($me_from_kind == "recv" && $result[me_read_datetime] == '0000-00-00 00:00:00') {
        // ������ ���� ������ ������Ʈ
        $sql1 = " select count(*) as cnt from $g4[memo_recv_table] 
                   where me_recv_mb_id = '$member[mb_id]' and me_read_datetime = '0000-00-00 00:00:00' ";
        $row1 = sql_fetch($sql1);
        sql_query(" update $g4[member_table] set mb_memo_unread = '$row1[cnt]' where mb_id = '$member[mb_id]' ");
    }

} else {
    alert("������ ������Ҹ� �� �� �����ϴ�.", "./memo.php?kind=trash");
}

alert("������ ������� �Ͽ����ϴ�.", "./memo.php?kind=trash");
?>