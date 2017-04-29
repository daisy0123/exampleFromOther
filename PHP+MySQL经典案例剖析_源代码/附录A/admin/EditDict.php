<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'dict.inc.php');
$dict = new Dict();
$data = array();
$data['F_CODE'] = $_POST['Code'];
if($dict->updateData($data,"F_ID = " . $_POST['id']))
{
	echo "操作成功<br>";
}else{
	echo "操作失败<br>";
}
echo "<a href='DictList.php'>点击返回</a>";
?>
