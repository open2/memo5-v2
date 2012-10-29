<?php
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if($is_admin == 'super'){
  	$dir="$g4[path]/data/memo2/";
	  $dp=@opendir($dir);
  	$i=0;
  	while($subdir=readdir($dp))	//�������� �˻�
	  {
		    if($subdir!="." and $subdir!="..")
    		{
		      	if(is_dir($dir.$subdir))
        				$type="folder";
      			else
        				$type="document";

      			if($type=="folder")//�����ϰ�쿡 ���� ���ϵ� �˻�
      			{
        				$sdp=@opendir($dir.$subdir.'/');
        				while($file=readdir($sdp))	//���� ���� �˻�
        				{
          					if($file!="." and $file!="..")
          					{
            						if(is_dir($dir.$subdir.'/'.$file))
              							$stype="folder";
            						else
              							$stype="document";

        						    if($stype!=="folder")//�����ϰ�� DB �˻��� ��� ������ ����
    				        		{
              							if(chkDel($subdir.'/'.$file))
				    	        			$i++;
        		    				}
					          }
				        }
			      }
		    }
	  }
	  closedir($dp);
	  alert($i.' ���� �����͸� �����Ͽ����ϴ�.',"./memo.php?kind=memo_config");
}
else
	  alert('�߸��� ���� �Ǵ� ������ �����ϴ�.',"./memo.php?kind=memo_config");

// ÷������ ���� �� ����(by Lusia) - �Ʒ��κ��� bbs/memo2_form_delete.php, memo2_form_delete_all_trash.php, memo2_chkunlinkfile.php�� �����Դϴ�
function chkDel($chkFile){
  	global $g4;

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
	     	$filepath="$g4[path]/data/memo2/" . $member[mb_id] . "/" . $chkFile;
    		$file_deleted_dir = "$g4[path]/data/memo2_deleted/" . $member[mb_id] . "/";
    		$file_deleted_path = $file_deleted_dir . $chkFile;
        // ȸ������ ���丮�� ����
  			if(!is_dir($file_deleted_dir)){
    				@mkdir($file_deleted_dir, 0707);
		    		@chmod($file_deleted_dir, 0707);
    		}
		    @copy($filepath, $file_deleted_path);  //�ӽ������� ����
    	  @unlink($filepath);
    		return true;
    }
	  else
		    return false;
}
?>