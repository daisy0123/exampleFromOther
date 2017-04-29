<?php
class MessageController extends Core_Controller_Action 
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
		$this->_model = new MessageModel();
		$this->_user = new UserModel();
		parent::__construct();
	}
	/**
	 * ���ܣ���ʾ������Ϣ�б�
	 */
	public function IndexAction()
	{
		$list = $this->_model->GetMessageList();
		$this->_view->assign('list',$list);
		$this->_view->display('MessageList.php');
	}
	/**
	 * ���ܣ������ʼ�
	 *
	 */
	public function SendMailAction()
	{
		$user = $this->_user->getInfo($this->_getParam('Id'));
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//�ж��Ƿ��ύ����
		{
			$this->_user->SendMail($user[F_LOGIN_EMAIL],$_POST['title'],$_POST['content']);
			$this->_redirect('/Message');
		}
		$this->_view->assign('info',$user);
		$this->_view->display('SendMail.php');
	}

}
?>
