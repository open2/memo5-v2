<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

$mb_id = $member['mb_id'];

$tmp_array = array();
if ($me_id) { // �Ǻ� ����
    $tmp_array[0] = $me_id;
} else { // ��ü����
    $tmp_array = $_POST['chk_me_id'];
}

if ($g4['memo_delete']) {
    $memo_delete = " and memo_owner='$member[mb_id]' ";
}

for ($i=count($tmp_array)-1; $i>=0; $i--) // �����ſ��� �����ŷ�. ��? sir ������ �׷��� �Ǿ� �����ϱ� ��..��
{
  switch ($kind) {
  case 'recv' : $sql = " select * from $g4[memo_recv_table] where me_id = '$tmp_array[$i]' ";
                $result = sql_fetch($sql);
                if ($result['me_recv_mb_id'] == $member['mb_id']) {} else alert("�ٸ��� ���� ����Դϴ�");

                // trash�� ������ �־�α�
                $me = sql_fetch("select * from $g4[memo_send_table] where me_id = '$tmp_array[$i]' and me_recv_mb_id='$member[mb_id]' $memo_delete ");
                $sql = " insert into $g4[memo_trash_table]
                            set 
                                me_id = '$me[mb_id]',
                                me_recv_mb_id = '$me[me_recv_mb_id]',
                                me_send_mb_id = '$me[me_send_mb_id]',
                                me_send_datetime = '$me[me_send_datetime]',
                                me_read_datetime = '$me[me_read_datetime]',
                                me_memo = '$me[me_memo]',
                                me_file_local = '$me[me_file_local]',
                                me_file_server = '$me[me_file_server]',
                                me_subject = '$me[me_subject]',
                                memo_type = '$me[memo_type]',
                                memo_owner = '$member[mb_id]',
                                me_option = '$me[me_option]',
                                me_from_kind = 'recv' 
                          where me_id = '$tmp_array[$i]' and me_recv_mb_id='$member[mb_id]' $memo_delete ";
                sql_query($sql, FALSE);

                $sql = " delete from $g4[memo_recv_table] where me_id = '$tmp_array[$i]' and me_recv_mb_id='$member[mb_id]' $memo_delete ";
                sql_query($sql);
                break;
  case 'send' : 
                memo4_cancel($tmp_array[$i]);
                break;
  case 'save' : $sql = " select memo_owner, memo_type from $g4[memo_save_table] where me_id = '$tmp_array[$i]' and memo_owner='$mb_id' limit 1";
                $result = sql_fetch($sql);
                if ($result['memo_owner'] == $member['mb_id']) {} else alert("�ٸ��� ���� ����Դϴ�");

                // trash�� ������ �־�α�
                $me = sql_fetch("select * from $g4[memo_save_table] where me_id = '$tmp_array[$i]' and memo_type = '$result[memo_type]' $memo_delete ");
                $sql = " insert into $g4[memo_trash_table]
                            set 
                                me_id = '$me[mb_id]',
                                me_recv_mb_id = '$me[me_recv_mb_id]',
                                me_send_mb_id = '$me[me_send_mb_id]',
                                me_send_datetime = '$me[me_send_datetime]',
                                me_read_datetime = '$me[me_read_datetime]',
                                me_memo = '$me[me_memo]',
                                me_file_local = '$me[me_file_local]',
                                me_file_server = '$me[me_file_server]',
                                me_subject = '$me[me_subject]',
                                memo_type = '$me[memo_type]',
                                memo_owner = '$member[mb_id]',
                                me_option = '$me[me_option]',
                                me_from_kind = 'recv' 
                          where me_id = '$tmp_array[$i]' and me_recv_mb_id='$member[mb_id]' $memo_delete ";
                sql_query($sql, FALSE);

                $sql = " delete from $g4[memo_save_table] where me_id = '$tmp_array[$i]' and memo_type = '$result[memo_type]' $memo_delete  ";
                sql_query($sql);
                break;
  case 'spam' : $sql = " select * from $g4[memo_spam_table] where me_id = '$tmp_array[$i]' ";
                $result = sql_fetch($sql);
                
                // ������ ��쿡�� trash�� ��ġ�� �ʰ� �ٷ� ����
                if ($result['memo_owner'] == $member['mb_id'])
                    $sql = " delete from $g4[memo_spam_table] where me_id = '$tmp_array[$i]' and me_recv_mb_id='$member[mb_id]' ";
                else if ($is_admin)
                    $sql = " delete from $g4[memo_spam_table] where me_id = '$tmp_array[$i]' and me_recv_mb_id='$result[memo_owner]' ";
                else 
                    alert("�ٸ��� ���� ����Դϴ�");
                sql_query($sql);
                break;
  case 'trash' :$sql = " select * from $g4[memo_trash_table] where me_id = '$tmp_array[$i]' ";
                $result = sql_fetch($sql);
                
                // �������� ��쿡�� �ٷ� ����
                if ($result['memo_owner'] == $member['mb_id'])
                    $sql = " delete from $g4[memo_trash_table] where me_id = '$tmp_array[$i]' and memo_owner='$member[mb_id]' ";
                else if ($is_admin)
                    $sql = " delete from $g4[memo_trash_table] where me_id = '$tmp_array[$i]' ";
                else 
                    alert("�ٸ��� ���� ����Դϴ�");
                sql_query($sql);

                // ÷�������� �ִ� ��쿡�� ���� ������ ����
        				// ÷������ ���� �� ����(by Lusia) - �Ʒ��κ��� bbs/memo2_form_delete.php, memo2_form_delete_all_trash.php, memo2_chkunlinkfile.php�� �����Դϴ�
                $file_name = $result['me_file_server'];
                if ($file_name) {

                    $sql = "  select count(*) as cnt from $g4[memo_recv_table] where me_file_server='$file_name'
                              union all 
                              select count(*) as cnt from $g4[memo_save_table] where me_file_server='$file_name'
                              union all
                              select count(*) as cnt from $g4[memo_send_table] where me_file_server='$file_name'
                              union all
                              select count(*) as cnt from $g4[memo_spam_table] where me_file_server='$file_name'
                              union all
                              select count(*) as cnt from $g4[memo_temp_table] where me_file_server='$file_name'
                              union all
                              select count(*) as cnt from $g4[memo_trash_table] where me_file_server='$file_name'
                              union all
                              select count(*) as cnt from $g4[memo_notice_table] where me_file_server='$file_name'
                            ";
                    $result_set = sql_query($sql);
                    $cnt_sum = 0;
                    while($row = sql_fetch_array($result_set))
                        $cnt_sum += $row['cnt'];

                  	//DB�� �ش� ÷������ ���� ������� ���� (÷�������� ���� ����� ���丮���� ����˴ϴ�)
                	  if ($cnt_sum) {
            	         	$filepath="$g4[data_path]/memo2/$file_name";
                    		$file_deleted_dir = "$g4[data_path]/memo2_deleted/" . $member['mb_id'] . "/";
                    		$file_deleted_path = "$g4[data_path]/memo2_deleted/$file_name";
                        // ȸ������ ���丮�� ����
                  			if(!is_dir($file_deleted_dir)){
                    				@mkdir($file_deleted_dir, 0707);
            		        		@chmod($file_deleted_dir, 0707);
                    		}
                		    @copy($filepath, $file_deleted_path);  //�ӽ������� ����
                    	  @unlink($filepath);
                    }
                }
                break;
  case 'notice': $sql = " select * from $g4[memo_notice_table] where me_id = '$tmp_array[$i]' ";
                $result = sql_fetch($sql);
                if ($result['memo_owner'] == $member['mb_id'] or $is_admin) {} else alert("�ٸ��� ���� ����Դϴ�");

                // ������ ��� �������� �۾��̹Ƿ� trash�� ��ġ�� �ʰ� �ٷ� ����
                $sql = " delete from $g4[memo_notice_table] where me_id = '$tmp_array[$i]' ";
                sql_query($sql);
                break;
  default : 
    alert("������ ������ �� �����ϴ�. �����ڿ��� �����Ͻñ� �ٶ��ϴ�.");
    
  } // end of switch
} // end of for loop

if ($kind == "recv") {

    // ������ ���� ������ ������Ʈ
    $sql1 = " select count(*) as cnt from $g4[memo_recv_table] 
               where me_recv_mb_id = '$member[mb_id]' and me_read_datetime = '0000-00-00 00:00:00' ";
    $row1 = sql_fetch($sql1);
    sql_query(" update $g4[member_table] set mb_memo_unread = '$row1[cnt]' where mb_id = '$member[mb_id]' ");
}

alert("������ �����Ͽ����ϴ�.", "./memo.php?kind=$kind");
?>