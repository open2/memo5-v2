<?
$sub_menu = "100600";
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

check_demo();

if ($is_admin != "super")
    alert("�ְ�����ڸ� ���� �����մϴ�.", $g4[path]);

$g4[title] = "���׷��̵�";
include_once("./admin.head.php");


sql_query("ALTER TABLE `$g4[member_table]` ADD `mb_memo_unread_datetime` DATETIME NOT NULL ", FALSE);

echo "UPGRADE �Ϸ�.";

include_once("./admin.tail.php");
?>