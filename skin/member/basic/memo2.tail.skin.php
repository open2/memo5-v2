        <ul>
        <?
        // 하단부에 내보내는 기본 정보사항
        if ($kind == 'write' && $config[cf_memo_send_point]) { // 쪽지보내기 + 포인트 차감이 있을 때만 메시지를 출력 합니다.
            echo "<li><span class=style10>쪽지 보낼때 회원당 ".number_format($config[cf_memo_send_point])."점의 포인트를 차감합니다.</span>";
        }
        
        if ($kind == "write") { // 쓰기 일때만 메시지를 출력 합니다.
            echo "<li><span class=style10>여러명에게 쪽지 발송시 컴마(,)로 구분 합니다.</span>";
            if ($config[cf_memo_use_file] && $config[cf_memo_file_size]) {
                echo "<li><span class=style10>첨부가능한 파일의 최대 용량은 " .$config[cf_memo_file_size] . "M(메가) 입니다.</span>";
            }
        }
        
        if ($kind == "send") { // 보낸쪽지함 일때만 메시지를 출력 합니다.
            echo "<li><span class=style10><font color='red'>읽지 않은 쪽지를 삭제하면, 발신이 취소(수신자 쪽지함에서 삭제) 됩니다.</font></span>";
        }
        
        if ($kind == "send" || $kind == "recv") { // 보낸쪽지함 일때만 메시지를 출력 합니다.
            echo "<li><span class=style10>보관하지 않은 쪽지는 " . $config[cf_memo_del] . "일 후 삭제되므로 중요한 쪽지는 보관하시기 바랍니다.</span>";
        }
        ?>
        </ul>
    
    </td>

    <td width=10></td> <!-- 우측의 여백 설정하기 -->
</tr>
</table>

<script type="text/javascript">
// 회원ID 찾기  
function popup_id(frm_name, ss_id, top, left) 
{ 
    url = './write_id.php?frm_name='+frm_name+'&ss_id='+ss_id; 
    opt = 'scrollbars=yes,width=320,height=470,top='+top+',left='+left; 
    window.open(url, "write_id", opt); 
} 

function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_me_id[]")
            f.elements[i].checked = sw;
    }
}

function check_confirm(str) {
    var f = document.fboardlist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_me_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(str + "할 쪽지를 하나 이상 선택하세요.");
        return false;
    }
    return true;
}

// 선택한 게시물 삭제
function select_delete() {
    var f = document.fboardlist;

    str = "삭제";
    if (!check_confirm(str))
        return;

    if (!confirm("선택한 쪽지를 정말 "+str+" 하시겠습니까?\n\n한번 "+str+"한 자료는 복구할 수 없습니다"))
        return;

    f.action = "./memo2_form_delete.php";
    f.submit();
}

// 모든 게시물 삭제
function all_delete_trash() {
    var f = document.fboardlist;

    str = "삭제";

    if (!confirm("모든 쪽지를 정말 "+str+" 하시겠습니까?\n\n한번 "+str+"한 자료는 복구할 수 없습니다"))
        return;

    f.action = "./memo2_form_delete_all_trash.php";
    f.submit();
}

// 윈도우 크기를 조정해 줍니다 - 테스트할때만 오픈
//window.resizeTo( <?=$config['memo_width']?> , <?=$config['memo_height']?> );
</script>