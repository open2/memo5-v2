<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

switch ($kind) {
  case 'send' : 
                memo4_cancel($me_id);
                break;
  default : 
    alert("�߽����� ������ �߽���Ҹ� �� �� �ֽ��ϴ�.");
}

alert("������ �߽���� �Ͽ����ϴ�.", "./memo.php?kind=$kind");
?>