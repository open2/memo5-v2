<?
$sub_menu = "100910";
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("�ְ�����ڸ� ���� �����մϴ�.", $g4[path]);

$g4[title] = "����4 ��ġ";
include_once ("$g4[admin_path]/admin.head.php");
?>

<form name=finstall method=post action='memo4_install_update.php' onsubmit="return finstall_check(this)" enctype="multipart/form-data" style="margin:0px;">

<p>
<table width=100% cellpadding=0 cellspacing=0>
<tr>
	<td width=50%><?=subtitle("����4 ��ġ")?></td>
	<td width=50% align=right></td>
</tr>
</table>

<table cellpadding=0 cellspacing=0 width=100%>
<colgroup width=15%></colgroup>
<colgroup width=85% bgcolor=#FFFFFF></colgroup>
<tr><td colspan=4 height=2 bgcolor=#0E87F9></td></tr>
<tr class=ht>
	<td>�ְ������ �н�����</td>
	<td colspan=3>
        <input type=password name=mb_password class=ed required itemname='�ְ������ �н�����'>
	</td>
</tr>
<tr class=ht>
	<td>&nbsp;</td>
	<td colspan=3 class=lh>
        <?
        $result = sql_fetch(" select * from $g4[memo_config_table] ", false);
        if ($result)
        {
            echo "�̹� ��ġ�Ǿ� �ֽ��ϴ�.<br>�缳ġ �Ͻ÷��� �ְ������ �н����带 �Է��� �ֽʽÿ�<br><b>�缳ġ �Ͻô� ��� ����4�� ���õ� ������ �ڷᰡ ������ �� �����Ƿ� �����Ͻñ� �ٶ��ϴ�.</b>";
        }
        else
        {
            echo "��ġ�Ǿ� ���� �ʽ��ϴ�.<br>��ġ�Ͻ÷��� ������ �н����带 �Է��� �ֽʽÿ�.";
        }
        ?>
	</td>
</tr>
<tr><td colspan=4 height=1 bgcolor=#CCCCCC></td></tr>
</table>

<p align=center>
	<input type=submit class=btn1 accesskey='s' value='  Ȯ  ��  '>
</form>

<script>
function finstall_check(f) {
    return true;
}
</script>

<?
include_once ("$g4[admin_path]/admin.tail.php");
?>
