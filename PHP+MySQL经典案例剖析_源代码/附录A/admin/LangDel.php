<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'lang.inc.php');
$lang = new Lang();
if($lang->delData($_GET['id']))
{
	echo "�����ɹ�<br>";
}else{
	echo "����ʧ��<br>";
}
echo "<a href='LangList.php'>�������</a>";
?>
