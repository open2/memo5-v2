    <div class="bottom">
    <? if ($kind == 'write' && $config[cf_memo_send_point]) { // ���������� + ����Ʈ ������ ���� ���� �޽����� ��� �մϴ�.
       echo "* ���� ������ ȸ���� ".number_format($config[cf_memo_send_point])."���� ����Ʈ�� �����մϴ�.<br />"; } ?>
    <? if ($kind == "write") { // ���� �϶��� �޽����� ��� �մϴ�.
       echo "* �������� ���� �߼۽� �ĸ�(,)�� ���� �մϴ�.<br />"; ?>
       <? if ($config[cf_memo_use_file]) { echo "* ÷�ΰ����� ������ �ִ� �뷮�� ".ini_get('upload_max_filesize')." �Դϴ�.<br />";  } ?><? } ?>
    <? if ($kind == "send") { // ���������� �϶��� �޽����� ��� �մϴ�.
       echo "* <span class='red'>���� ���� ������ �����ϸ�, �߽��� ���(������ �����Կ��� ����) �˴ϴ�.</span><br />"; }

       if ($kind == "send" || $kind == "recv") { // ���������� �϶��� �޽����� ��� �մϴ�.
       echo "* �������� ���� ������ {$config[cf_memo_del]}�� �� �����ǹǷ� �߿��� ������ �����Ͻñ� �ٶ��ϴ�."; } ?>
    </div>
