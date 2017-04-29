<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'dict.inc.php');
$dict = new Dict();
if($dict->delData("F_ID=" . $_GET['id']))
{
	echo "操作成功<br>";
}else{
	echo "操作失败<br>";
}
echo "<a href='DictList.php'>点击返回</a>";
?>
