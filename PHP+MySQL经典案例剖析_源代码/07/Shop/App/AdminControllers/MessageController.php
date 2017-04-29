<?php
class MessageController extends Core_Controller_Action 
{
	/**
	 * 功能：初始化构造函数
	 */
	public function __construct()
	{
		if(!$_SESSION['admin'])
		{
			$this->_redirect('/Index/Login');
		}
		$this->_model = new MessageModel();
		$this->_user = new UserModel();
		parent::__construct();
	}
	/**
	 * 功能：显示反馈信息列表
	 */
	public function IndexAction()
	{
		$list = $this->_model->GetMessageList();
		$this->_view->assign('list',$list);
		$this->_view->display('MessageList.php');
	}
	/**
	 * 功能：发送邮件
	 *
	 */
	public function SendMailAction()
	{
		$user = $this->_user->getInfo($this->_getParam('Id'));
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//判断是否提交发送
		{
			$this->_user->SendMail($user[F_LOGIN_EMAIL],$_POST['title'],$_POST['content']);
			$this->_redirect('/Message');
		}
		$this->_view->assign('info',$user);
		$this->_view->display('SendMail.php');
	}

}
?>
