<?php
require_once("config.inc.php");										//包含配置文件
require_once(INCLUDE_PATH . "db.inc.php");							//包含数据库基础操作类文件
require_once(INCLUDE_PATH . "blog.inc.php");						//包含Blog类
require_once(INCLUDE_PATH . "user.inc.php");
require_once(INCLUDE_PATH . "function.inc.php");
ob_start();
session_start();
if(!isset($_GET['BlogId']))											//判断是否有ID参数
{
	$msg = "<a href='Register.php'>请注册点击一个博客</a>";
	echo $msg;
	exit();
}
$blogid = $_GET['BlogId'];
$action = (!isset($_GET['Action'])) ? "List" : $_GET['Action'];				//提取Action参数，默认为list
$blog = new Blog();
$user = new User();
$blog_info = $blog->GetBlogInfo($blogid);					//提取该ID的博客信息
$blog_user = $blog->getInfo($blogid,"EE_BLOG_USER");					//提取该ID的表5.3的记录
$user_info = $user->getInfo($blog_user['F_ID_USER_INFO'],'EM_USER_INFO'); //提取博客用户信息
if(!$blog->CheckBlogExist($blogid))									//判断该ID的博客是否存在
{
	$msg = "无此博客存在";
	include(ERRFILE);											//不存在则包含错误处理文件
	exit();	
}
$flag = $blog->CheckBlogIsLocked($blogid);							//检验是否锁定或设置访问密码
switch ($flag) {
	case 1:													//flag为1，博客设置了访问密码
		if(!isset($_SESSION['Confirm']))							//判断是否已输入密码
		{
			require (TEMPLATE_PATH . "Password.php");				//包含输入密码功能
			exit();
		}
		if($action == 'Check')										//检查输入密码是否正确
		{
			require(TEMPLATE_PATH . "$action" . ".php");
			exit;
		}
		break;
	case 2:													//flag为2，博客已锁定
		if($_SESSION['User']['F_ID'] != $blog_user[F_ID_USER_INFO])	//判断登陆用户是否是博客主人
		{
			$msg = "该博客已锁定";
			include(ERRFILE);									//包含错误处理文件
			exit();
		}
		break;
}
//判断该功能文件是否存在，存在则包含它
if(file_exists(TEMPLATE_PATH . $blog_info['F_BLOG_DEFAULT_SKINS'] . "/$action" . ".php"))
{
	require_once(TEMPLATE_PATH . $blog_info['F_BLOG_DEFAULT_SKINS'] . "/$action" . ".php");
}else{
	$msg = "参数错误";
	include(ERRFILE);											//如果文件不存在则显示参数错误
}
?>
