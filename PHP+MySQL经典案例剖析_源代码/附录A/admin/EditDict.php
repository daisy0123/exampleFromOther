<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'dict.inc.php');
$dict = new Dict();
$data = array();
$data['F_CODE'] = $_POST['Code'];
if($dict->updateData($data,"F_ID = " . $_POST['id']))
{
	echo "�����ɹ�<br>";
}else{
	echo "����ʧ��<br>";
}
echo "<a href='DictList.php'>�������</a>";
?>
