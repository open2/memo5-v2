<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!$member[mb_id])
    alert("ȸ���� �̿��Ͻ� �� �ֽ��ϴ�.");

$mb_id = $member['mb_id'];
$me_id = $me_id;

if (!$me_id || !$mb_id || $is_admin != 'super')
    alert("�������� ����Դϴ�");

// ���������� �߼��ϰ� 1�ð� �̳����� ��� ���� �մϴ�.
$sql = " select * from $g4[memo_notice_table] where me_id = '$me_id' ";
$memo = sql_fetch($sql);

$time_diff = strtotime("-1 hour") - strtotime($memo['me_send_datetime']);

if ($time_diff > 0)
    alert("���������� �߼��ϰ� 1�ð� �̳����� ��� ���� �մϴ�.");

// ��������
$sql_where = " where me_send_mb_id = '$memo[me_send_mb_id]' and 
                     me_subject = '$memo[me_subject]' and 
                     me_send_datetime = '$memo[me_send_datetime]' 
              ";
// ������������ �������� ����
$sql = " delete from $g4[memo_recv_table] " . $sql_where;
sql_query($sql);

// ������������ �������� ����
$sql = " delete from $g4[memo_send_table] " . $sql_where;
sql_query($sql);

// �������������� �������� ����
$sql = " delete from $g4[memo_save_table] " . $sql_where;
sql_query($sql);

// �������� ����
$sql = " delete from $g4[memo_notice_table] " . $sql_where;
sql_query($sql);

alert("���������� �����ϰ�, �߼۵� ������ ��� ȸ���Ͽ����ϴ�.", "./memo.php?kind=$kind");
?>