<?php
require_once("config.inc.php");
require_once(INCLUDE_PATH . "db.inc.php");
require_once(INCLUDE_PATH . "user.inc.php");
if(!$_GET['User']) {
	echo "�û�������Ϊ��";
	exit;
}
$User = new User();
if($User->CheckUserNameExist($_GET['User']))
{
	echo "���û����Ѵ���";
}else{
	echo "���û�������ʹ��";
}
?>
