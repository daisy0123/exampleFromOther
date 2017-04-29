<?php
require_once("config.inc.php");
require_once(INCLUDE_PATH . "db.inc.php");
require_once(INCLUDE_PATH . "user.inc.php");
if(!$_GET['User']) {
	echo "用户名不能为空";
	exit;
}
$User = new User();
if($User->CheckUserNameExist($_GET['User']))
{
	echo "该用户名已存在";
}else{
	echo "该用户名可以使用";
}
?>
