<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'lang.inc.php');
$lang = new Lang();
if($lang->delData($_GET['id']))
{
	echo "操作成功<br>";
}else{
	echo "操作失败<br>";
}
echo "<a href='LangList.php'>点击返回</a>";
?>
