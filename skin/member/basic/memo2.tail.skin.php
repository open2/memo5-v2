        <ul>
        <?
        // �ϴܺο� �������� �⺻ ��������
        if ($kind == 'write' && $config[cf_memo_send_point]) { // ���������� + ����Ʈ ������ ���� ���� �޽����� ��� �մϴ�.
            echo "<li><span class=style10>���� ������ ȸ���� ".number_format($config[cf_memo_send_point])."���� ����Ʈ�� �����մϴ�.</span>";
        }
        
        if ($kind == "write") { // ���� �϶��� �޽����� ��� �մϴ�.
            echo "<li><span class=style10>�������� ���� �߼۽� �ĸ�(,)�� ���� �մϴ�.</span>";
            if ($config[cf_memo_use_file] && $config[cf_memo_file_size]) {
                echo "<li><span class=style10>÷�ΰ����� ������ �ִ� �뷮�� " .$config[cf_memo_file_size] . "M(�ް�) �Դϴ�.</span>";
            }
        }
        
        if ($kind == "send") { // ���������� �϶��� �޽����� ��� �մϴ�.
            echo "<li><span class=style10><font color='red'>���� ���� ������ �����ϸ�, �߽��� ���(������ �����Կ��� ����) �˴ϴ�.</font></span>";
        }
        
        if ($kind == "send" || $kind == "recv") { // ���������� �϶��� �޽����� ��� �մϴ�.
            echo "<li><span class=style10>�������� ���� ������ " . $config[cf_memo_del] . "�� �� �����ǹǷ� �߿��� ������ �����Ͻñ� �ٶ��ϴ�.</span>";
        }
        ?>
        </ul>
    
    </td>

    <td width=10></td> <!-- ������ ���� �����ϱ� -->
</tr>
</table>

<script type="text/javascript">
// ȸ��ID ã��  
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
        alert(str + "�� ������ �ϳ� �̻� �����ϼ���.");
        return false;
    }
    return true;
}

// ������ �Խù� ����
function select_delete() {
    var f = document.fboardlist;

    str = "����";
    if (!check_confirm(str))
        return;

    if (!confirm("������ ������ ���� "+str+" �Ͻðڽ��ϱ�?\n\n�ѹ� "+str+"�� �ڷ�� ������ �� �����ϴ�"))
        return;

    f.action = "./memo2_form_delete.php";
    f.submit();
}

// ��� �Խù� ����
function all_delete_trash() {
    var f = document.fboardlist;

    str = "����";

    if (!confirm("��� ������ ���� "+str+" �Ͻðڽ��ϱ�?\n\n�ѹ� "+str+"�� �ڷ�� ������ �� �����ϴ�"))
        return;

    f.action = "./memo2_form_delete_all_trash.php";
    f.submit();
}

// ������ ũ�⸦ ������ �ݴϴ� - �׽�Ʈ�Ҷ��� ����
//window.resizeTo( <?=$config['memo_width']?> , <?=$config['memo_height']?> );
</script>