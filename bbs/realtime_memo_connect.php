<?php
include_once("./_common.php");

// �⺻����
$call = 0;
$nick = "-";
$total = 0;
$new = 0;

// ȸ���϶��� ���α׷��� ����
if ($member[mb_id]){

$sql = " select mb_memo_call 
          from $g4[member_table] 
          where mb_id = '$member[mb_id]'";
$result = sql_fetch($sql);
if ($result[mb_memo_call]) {
    $call = $result[mb_memo_call]; // ������ ������ ������ ������ ��

    // ���� ���ڿ��� explode
    $call_list = explode(" ", $call);
    $nick = "";

    // �������� nick name
    foreach ($call_list as $call_id) {
        if (trim($call_id)) {
            $sql2 = " select mb_nick from $g4[member_table] where mb_id = '$call_id' ";
            $result2 = sql_fetch($sql2);
            $nick .= $result2[mb_nick] . "/";
        }
    }

    // ����ڰ� ���� ���� ���� �մϴ�. SQL Ƚ���� �Ʋ�����
    $sql = " select count(*) as cnt 
               from {$g4['memo_table']}
               where me_recv_mb_id = '{$member['mb_id']}'
               and me_read_datetime like '0000%' ";
    $result = sql_query($sql);
    $row = mysql_fetch_array($result);

    $total = $row[0];
    $new = $row['cnt'];
}
}

Header("Content-type: text/xml; charset=$g4[charset]"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache");   

echo "<?xml version=\"1.0\" encoding=\"$g4[charset]\"?>"; // �̰� �� ������ ��ü���� ���ɴϴ�. ��..��
echo "<memo>\n";
echo "<total>{$total}</total>\n";
echo "<new>{$new}</new>\n";
echo "<call>{$call}</call>\n";
echo "<nick><![CDATA[{$nick}]]></nick>\n"; 
echo "</memo>\n";
?>