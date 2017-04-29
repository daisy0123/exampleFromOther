<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'vote.inc.php');
$vote = new Vote();
if($vote->delData($_GET['id']))
{
	echo "操作成功<br>";
	echo "<a href='VoteList.php'>返回</a>";
	exit();
}else{
	echo "操作失败<br>";
	echo "<a href='VoteList.php'>返回</a>";
	exit();
}
?>
