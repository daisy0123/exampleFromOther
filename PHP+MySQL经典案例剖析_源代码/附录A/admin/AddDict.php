<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'dict.inc.php');
$dict = new Dict();
$data = array();
$data['F_CODE'] = $_POST['Code'];
if($dict->insertData($data))
{
	echo "�����ɹ�<br>";
}else{
	echo "����ʧ��<br>";
}
echo "<a href='DictList.php'>�������</a>";
?>
