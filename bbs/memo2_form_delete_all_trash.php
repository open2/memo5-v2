<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!$member[mb_id])
    alert("ȸ���� �̿��Ͻ� �� �ֽ��ϴ�.");

if ($config['cf_memo_del_file']) {
    // ÷������ ���� �� ����(by Lusia)
    $sql = " select distinct me_file_server from $g4[memo_trash_table] where memo_owner = '$member[mb_id]' ";
    $filelist=sql_query($sql);
}

// ������ ����
$sql = " delete from $g4[memo_trash_table] where memo_owner = '$member[mb_id]' ";
sql_query($sql);

// ÷������ ���� �� ����(by Lusia) - �Ʒ��κ��� bbs/memo2_form_delete.php, memo2_form_delete_all_trash.php, memo2_chkunlinkfile.php�� �����Դϴ�
if ($filelist) {
while($result=mysql_fetch_assoc($filelist)){
    $file_name = $result[me_file_server];
    
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
                        $cnt_sum += $row[cnt];

   	//DB�� �ش� ÷������ ���� ������� ���� (÷�������� ���� ����� ���丮���� ����˴ϴ�)
 	  if ($cnt_sum) {
       	$filepath="$g4[path]/data/memo2/$file_name";
     		$file_deleted_dir = "$g4[path]/data/memo2_deleted/" . $member[mb_id] . "/";
     		$file_deleted_path = "$g4[path]/data/memo2_deleted/$file_name";
        // ȸ������ ���丮�� ����
   			if(!is_dir($file_deleted_dir)){
     				@mkdir($file_deleted_dir, 0707);
 		    		@chmod($file_deleted_dir, 0707);
     		}
 		    @copy($filepath, $file_deleted_path);  //�ӽ������� ����
     	  @unlink($filepath);
    }
}
}

alert("������ �����Ͽ����ϴ�.", "./memo.php?kind=trash");
?>