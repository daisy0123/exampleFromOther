<?php
require_once("../config.inc.php");
require_once(INCLUDE_PATH . "db.inc.php");
require_once(INCLUDE_PATH . "blog.inc.php");
require_once(INCLUDE_PATH . "user.inc.php");
require_once(INCLUDE_PATH . "function.inc.php");
ob_start();
session_start();
if(!isset($_SESSION['User']['F_ID']))								//判断访问者是否已登陆
{
	echo "<script>alert('对不起，您未登陆！请先登陆');";				//未登陆的提示登陆并转到登陆界面
	echo "window.location='/Login.php';</script>";
	exit();
}
$blog = new Blog();
$user = new User();
$blogid = $user->GetBlogId($_SESSION['User']['F_ID']);
$action = $_GET['Action'];
if(!$action)												//判断是否有Action,无则默认为Post
	$action = "Post";
require_once("header.php");
if(file_exists("$action" . ".php"))							//判断该文件是否存在
{
	require("$action" . ".php");
}else{
	echo "参数错误";
}
require_once("footer.php");
?>
