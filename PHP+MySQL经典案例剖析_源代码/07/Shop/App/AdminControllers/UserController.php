<?php
class UserController extends Core_Controller_Action 
{
	/**
	 * ���ܣ���ʼ�����캯��
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
	 * ���ܣ���ʾ�û��б�
	 *
	 */
	public function IndexAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//�ж��Ƿ��ύɾ��
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
	 * ���ܣ�����ת��
	 *
	 */
	public function RedirectAction()
	{
		$type = $_POST['type'];
		$keyword = urlencode($_POST['keyword']);
		$this->_redirect("/User/Index/Type/$type/Keyword/$keyword");
	}
	/**
	 * ���ܣ��ʼ�Ⱥ��
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
	 * ���ܣ���ʾ�û���ϸ��Ϣ
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
