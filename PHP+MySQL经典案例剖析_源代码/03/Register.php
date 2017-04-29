<?php
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'db.inc.php');
$db = new DBSQL();
$data = array();
$data['F_USER_NAME'] = $_POST['UserID'];
$data['F_USER_PASSWORD'] = md5($_POST['password']);
$data['F_USER_NICKNAME'] = $_POST['NickName'];
$data['F_USER_IS_ADMIN'] = 0;
if($db->insertData('EM_USER_INFO',$data))
{
	echo "×¢²á³É¹¦--<a href='login.php'>µã»÷µÇÂ½</a>";
	exit();
}
?>
