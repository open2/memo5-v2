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
</tr>
</table>