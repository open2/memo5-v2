<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!defined("_GNUBOARD_")) exit; // ���� ������ ���� �Ұ�

if ($is_admin != "super")
    alert("�ְ�����ڸ� �̿��Ͻ� �� �ֽ��ϴ�.");

$kind   = $_POST[kind];
$me_id  = $_POST[me_id];

if ($kind != "spam")
    alert("������ҿ��� - �ְ�����ڿ��� �����Ͻñ� �ٶ��ϴ�");

$sql = " select * from $g4[memo_spam_table] where me_id = '$me_id' ";
$result = sql_fetch($sql);

// �߽���, ����, ������ ������, �߽��Ϸ� ���� +/- 10�� �̳��� ��� ������ �������� ����
$sql_where = " me_send_mb_id = '$result[me_send_mb_id]' and me_subject = '$result[me_subject]' and me_memo = '" . addslashes($result[me_memo]) . "' and me_send_datetime > '" . date("Y-m-d H:i:s", strtotime($result[me_send_datetime]) - 60*10 ) . "' and me_send_datetime < '" . date("Y-m-d H:i:s", strtotime($result[me_send_datetime]) + 60*10 ) . "' ";
$sql = " delete from $g4[memo_recv_table] where $where_datetime $sql_where";
sql_query($sql);

$result_count = mysql_affected_rows();

alert("{$result_count} ���� ������ ����ȸ�� �Ͽ����ϴ�.", "./memo.php?kind=$kind");
?>