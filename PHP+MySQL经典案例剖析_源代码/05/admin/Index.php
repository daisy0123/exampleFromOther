<?php
require_once("../config.inc.php");
require_once(INCLUDE_PATH . "db.inc.php");
require_once(INCLUDE_PATH . "blog.inc.php");
require_once(INCLUDE_PATH . "user.inc.php");
require_once(INCLUDE_PATH . "function.inc.php");
ob_start();
session_start();
if(!isset($_SESSION['User']['F_ID']))								//�жϷ������Ƿ��ѵ�½
{
	echo "<script>alert('�Բ�����δ��½�����ȵ�½');";				//δ��½����ʾ��½��ת����½����
	echo "window.location='/Login.php';</script>";
	exit();
}
$blog = new Blog();
$user = new User();
$blogid = $user->GetBlogId($_SESSION['User']['F_ID']);
$action = $_GET['Action'];
if(!$action)												//�ж��Ƿ���Action,����Ĭ��ΪPost
	$action = "Post";
require_once("header.php");
if(file_exists("$action" . ".php"))							//�жϸ��ļ��Ƿ����
{
	require("$action" . ".php");
}else{
	echo "��������";
}
require_once("footer.php");
?>
