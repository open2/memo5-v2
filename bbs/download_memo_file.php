<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!defined("_GNUBOARD_")) exit; // ���� ������ ���� �Ұ� 

if (!$kind or !$me_id)
    alert("�ٿ�ε忡 �ʿ��� ������ �����ϴ�.");

switch ($kind) {
  case 'send'   : $sql = " select * from $g4[memo_send_table] where me_id = $me_id "; break;
  case 'recv'   : $sql = " select * from $g4[memo_recv_table] where me_id = $me_id "; break;
  case 'spam'   : $sql = " select * from $g4[memo_spam_table] where me_id = $me_id "; break;
  case 'save'   : $sql = " select * from $g4[memo_save_table] where me_id = $me_id "; break;
  case 'notice' : $sql = " select * from $g4[memo_notice_table] where me_id = $me_id "; break;
  default     : alert("�߸��� kind �� �Դϴ�");
}
$result = sql_fetch($sql);

if ($member[mb_id] != $result[memo_owner])
    alert("�ٸ� ����� �޸𿡼� ÷�������� �ٿ�ε� �� �� �����ϴ�");

$file_server = $result[me_file_server];
$file_local = $result[me_file_local];

$filepath="$g4[path]/data/memo2/$file_server";

//$original="$file_local"; -- UTF-8 ���ϸ�, NaviGator��
if (preg_match("/^utf/i", $g4[charset])) 
    $original = urlencode($file_local); 
else 
    $original = $file_local; 

if (file_exists($filepath)) {
    if(eregi("msie", $_SERVER[HTTP_USER_AGENT]) && eregi("5\.5", $_SERVER[HTTP_USER_AGENT])) {
        header("content-type: doesn/matter");
        header("content-length: ".filesize("$filepath"));
        header("content-disposition: attachment; filename=\"$original\"");
        header("content-transfer-encoding: binary");
    } else {
        header("content-type: file/unknown");
        header("content-length: ".filesize("$filepath"));
        header("content-disposition: attachment; filename=\"$original\"");
        header("content-description: php generated data");
    }
    header("pragma: no-cache");
    header("expires: 0");
    flush();

    if (is_file("$filepath")) {
        $fp = fopen("$filepath", "rb");

        // 4.00 ��ü
        // �������ϸ� ���̷��� print �� echo �Ǵ� while ���� �̿��� ������ٴ� �̹����...
        //if (!fpassthru($fp)) {
        //    fclose($fp);
        //}

        while(!feof($fp)) { 
            echo fread($fp, 100*1024); 
            flush(); 
        } 
        fclose ($fp); 
        flush();
    } else {
        alert("�ش� �����̳� ��ΰ� �������� �ʽ��ϴ�.");
    }

} else {
    alert("������ ã�� �� �����ϴ�.");
}
?>