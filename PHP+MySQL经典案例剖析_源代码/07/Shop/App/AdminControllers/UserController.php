<?php
class UserController extends Core_Controller_Action 
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
		$this->_model = new UserModel();
		$this->_mail = new Zend_Mail('gb2312');
		parent::__construct();
	}
	/**
	 * 功能：显示用户列表
	 *
	 */
	public function IndexAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//判断是否提交删除
		{
			$this->_model->DelUser($_POST['SelId']);
		}
		$type = $this->_getParam('Type');
		$keyword = $this->_getParam('Keyword');
		$list = $this->_model->GetUserList($type,$keyword);
		$this->_view->assign('list',$list);
		$this->_view->display('UserList.php');
	}
	/**
	 * 功能：搜索转向
	 *
	 */
	public function RedirectAction()
	{
		$type = $_POST['type'];
		$keyword = urlencode($_POST['keyword']);
		$this->_redirect("/User/Index/Type/$type/Keyword/$keyword");
	}
	/**
	 * 功能：邮件群发
	 *
	 */
	public function SendEmailAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$list = $this->_model->GetAcceptEmailUser();
			$title = $_POST['title'];
			$content = $_POST['content'];
			foreach($list as $value)
			{
				$this->_model->SendMail($to,$title,$content);
			}
			$this->_redirect('/User');
		}
		$this->_view->display('SendMail.php');
	}
	/**
	 * 功能：显示用户详细信息
	 *
	 */
	public function InfoAction()
	{
		$info = $this->_model->GetUserInfo($this->_getParam('Id'));
		$this->_view->assign('info',$info);
		$this->_view->display('UserDetail.php');
	}

}
?>
