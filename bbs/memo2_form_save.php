<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!$member[mb_id])
    alert("ȸ���� �̿��Ͻ� �� �ֽ��ϴ�.");

$mb_id = $member['mb_id'];

switch ($kind) {
  case 'recv' : $sql = " select me_recv_mb_id from $g4[memo_recv_table] where me_id='$me_id' and memo_owner='$mb_id' ";
                $result = sql_fetch($sql);
                if ($result[me_recv_mb_id] == $mb_id) {} else alert("�ٸ��� ���� ����Դϴ�");

                // ������/�߽��ڰ� ��� save�� �Ϸ��� �ϸ� me_id �ߺ����� save�� ���� �ʽ��ϴ�.
                // me_id+memo_owner�� primary key�� ���� 
                // ALTER TABLE `g4_memo_save` DROP PRIMARY KEY , ADD PRIMARY KEY ( `me_id` , `memo_type` ) 
                $sql = " select count(*) as cnt from $g4[memo_save_table] where me_id = '$me_id' and memo_type = 'recv' and memo_owner='$mb_id' ";
                $result = sql_fetch($sql);
                if ($result[cnt] > 0) alert("�̹� ����� ���� �Դϴ�. ��ڿ��� �����Ͻñ� �ٶ��ϴ�.");
                
                $sql = " insert into $g4[memo_save_table] select * from $g4[memo_recv_table] where me_id = '$me_id' and memo_owner='$mb_id' ";
                sql_query($sql);

                $sql = " delete from $g4[memo_recv_table] where me_id = '$me_id' and memo_owner='$mb_id' ";
                sql_query($sql);
                break;
  case 'send' : $sql = " select me_send_mb_id from $g4[memo_send_table] where me_id = '$me_id' and memo_owner='$mb_id' ";
                $result = sql_fetch($sql);
                if ($result[me_send_mb_id] == $mb_id) {} else alert("�ٸ��� ���� ����Դϴ�");

                $sql = " select count(*) as cnt from $g4[memo_save_table] where me_id = '$me_id' and memo_type = 'recv' and memo_owner='$mb_id' ";
                $result = sql_fetch($sql);
                if ($result[cnt] > 0) alert("�̹� ����� ���� �Դϴ�. ��ڿ��� �����Ͻñ� �ٶ��ϴ�.");
                
                $sql = " insert into $g4[memo_save_table] select * from $g4[memo_send_table] where me_id = '$me_id' and memo_owner='$mb_id' ";
                sql_query($sql);

                $sql = " delete from $g4[memo_send_table] where me_id = '$me_id' and memo_owner='$mb_id' ";
                sql_query($sql);
                break;
  default : 
    alert("����/�߽����� ������ ������ ���� �մϴ�.");
}

alert("������ �����Ͽ����ϴ�.", "./memo.php?kind=save");
?>