<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'dict.inc.php');
$dict = new Dict();
if($dict->delData("F_ID=" . $_GET['id']))
{
	echo "�����ɹ�<br>";
}else{
	echo "����ʧ��<br>";
}
echo "<a href='DictList.php'>�������</a>";
?>
