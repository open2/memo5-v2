<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!defined("_GNUBOARD_")) exit; // ���� ������ ���� �Ұ�

if (!$member[mb_id])
    alert("ȸ���� �̿��Ͻ� �� �ֽ��ϴ�.");

switch ($kind) {
  case 'send' : 
                memo4_cancel($me_id);
                break;
  default : 
    alert("�߽����� ������ �߽���Ҹ� �� �� �ֽ��ϴ�.");
}

alert("������ �߽���� �Ͽ����ϴ�.", "./memo.php?kind=$kind");
?>
