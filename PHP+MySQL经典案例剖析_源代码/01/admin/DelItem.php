<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'vote.inc.php');
$vote = new Vote();
if($vote->delItemData($_GET['id']))					//判断是否操作成功
{
	echo "操作成功<br>";
	echo "<a href='ItemList.php?id={$_GET['voteid']}'>返回</a>";
	exit();
}else{
	echo "操作失败<br>";
	echo "<a href='ItemList.php?id={$_GET['voteid']}'>返回</a>";
	exit();
}
?>
