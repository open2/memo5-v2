<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!$member[mb_id])
    alert("ȸ���� �̿��Ͻ� �� �ֽ��ϴ�.");

switch ($kind) {
  case 'recv' : // spam �Ű�
                $sql = " select * from $g4[memo_recv_table] where me_id = '$me_id' ";
                $result = sql_fetch($sql);
                if ($result[me_recv_mb_id] == $member[mb_id]) {} else alert("�ٸ��� ���� ����Դϴ�");

                $sql = " insert into $g4[memo_spam_table] select * from $g4[memo_recv_table] where me_id = '$me_id' and me_recv_mb_id = '$member[mb_id]' ";
                sql_query($sql);

                $sql = " delete from $g4[memo_recv_table] where me_id = '$me_id' ";
                sql_query($sql);
                
                // �Ű����̺� ����ϱ�
                if ($g4['singo_table']) {
                    $bo_table = "@memo";
                    $wr_id = $wr_parent = $me_id;             // �޸� id
                    $write[mb_id] = $result[me_send_mb_id];   // �۾��� = �޸� �߽���
                    $sg_reason = "�������� �߼�";
                    
                    include("./singo_popin_update.php");
                }
                
                alert("������ spam �Ű� �Ͽ����ϴ�.", "./memo.php?kind=spam");
                break;
  case 'spam' : // spam ���
                $sql = " select * from $g4[memo_spam_table] where me_id = '$me_id' ";
                $result = sql_fetch($sql);
                // ������ �Ǵ� ������ �Ű��� ����� ��Ұ� ����
                if ($is_admin || $result[me_recv_mb_id] == $member[mb_id]) {} else alert("�ٸ��� ���� ����Դϴ�");
                
                $sql = " insert into $g4[memo_recv_table] select * from $g4[memo_spam_table] where me_id = '$me_id' and me_recv_mb_id = '$member[mb_id]' ";
                sql_query($sql);

                $sql = " delete from $g4[memo_spam_table] where me_id = '$me_id' ";
                sql_query($sql);

                // �Ű����̺��� �����ϱ�
                if ($g4['singo_table']) {
                    $result = sql_fetch(" select sg_id from $g4[singo_table] where bo_table = '@memo' and wr_id = '$me_id' ");
                    $sql = " delete from $g4[singo_table] where sg_id = '$result[sg_id]' ";
                    sql_query($sql);
                }

                alert("������ spam ��� �Ͽ����ϴ�.", "./memo.php?kind=recv");
                break;                
  default : 
    alert("�������� ������ spam �Ű� �� �� �ֽ��ϴ�.");
}
?>