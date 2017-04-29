<?php
require_once("config.inc.php");										//���������ļ�
require_once(INCLUDE_PATH . "db.inc.php");							//�������ݿ�����������ļ�
require_once(INCLUDE_PATH . "blog.inc.php");						//����Blog��
require_once(INCLUDE_PATH . "user.inc.php");
require_once(INCLUDE_PATH . "function.inc.php");
ob_start();
session_start();
if(!isset($_GET['BlogId']))											//�ж��Ƿ���ID����
{
	$msg = "<a href='Register.php'>��ע����һ������</a>";
	echo $msg;
	exit();
}
$blogid = $_GET['BlogId'];
$action = (!isset($_GET['Action'])) ? "List" : $_GET['Action'];				//��ȡAction������Ĭ��Ϊlist
$blog = new Blog();
$user = new User();
$blog_info = $blog->GetBlogInfo($blogid);					//��ȡ��ID�Ĳ�����Ϣ
$blog_user = $blog->getInfo($blogid,"EE_BLOG_USER");					//��ȡ��ID�ı�5.3�ļ�¼
$user_info = $user->getInfo($blog_user['F_ID_USER_INFO'],'EM_USER_INFO'); //��ȡ�����û���Ϣ
if(!$blog->CheckBlogExist($blogid))									//�жϸ�ID�Ĳ����Ƿ����
{
	$msg = "�޴˲��ʹ���";
	include(ERRFILE);											//������������������ļ�
	exit();	
}
$flag = $blog->CheckBlogIsLocked($blogid);							//�����Ƿ����������÷�������
switch ($flag) {
	case 1:													//flagΪ1�����������˷�������
		if(!isset($_SESSION['Confirm']))							//�ж��Ƿ�����������
		{
			require (TEMPLATE_PATH . "Password.php");				//�����������빦��
			exit();
		}
		if($action == 'Check')										//������������Ƿ���ȷ
		{
			require(TEMPLATE_PATH . "$action" . ".php");
			exit;
		}
		break;
	case 2:													//flagΪ2������������
		if($_SESSION['User']['F_ID'] != $blog_user[F_ID_USER_INFO])	//�жϵ�½�û��Ƿ��ǲ�������
		{
			$msg = "�ò���������";
			include(ERRFILE);									//�����������ļ�
			exit();
		}
		break;
}
//�жϸù����ļ��Ƿ���ڣ������������
if(file_exists(TEMPLATE_PATH . $blog_info['F_BLOG_DEFAULT_SKINS'] . "/$action" . ".php"))
{
	require_once(TEMPLATE_PATH . $blog_info['F_BLOG_DEFAULT_SKINS'] . "/$action" . ".php");
}else{
	$msg = "��������";
	include(ERRFILE);											//����ļ�����������ʾ��������
}
?>
