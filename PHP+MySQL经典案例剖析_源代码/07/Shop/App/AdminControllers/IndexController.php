<?php
class IndexController extends Core_Controller_Action 
{
	/**
	 * ���ܣ���ʼ�����캯��
	 */
	public function __construct()
	{
        $this->_model = new AdminModel();
		parent::__construct();
	}
	/**
	 * ���ܣ���ҳ
	 */
	public function IndexAction()
	{
		if(!$_SESSION['admin'])
		{
			$this->_redirect('/Index/Login');
		}
		$this->_view->display("Index.php");
	}
	/**
	 * ���ܣ���ߵ�����
	 */
	public function LeftAction()
	{
		$this->_view->display("Left.php");
	}
	/**
	 * ���ܣ��ұ�
	 */
	public function RightAction()
	{
		$this->_view->display("Right.php");
	}
	/**
	 * ���ܣ���½
	 */	
	public function LoginAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if(strtolower($_SESSION['verify_code']) != strtolower($_POST['code'])) {
				$msg = "��֤�����";
			} else {
				if($r = $this->_model->checkLogin($_POST['username'],$_POST['password'])) {
					$_SESSION['admin']['username'] = $r[F_USER_NAME];
					$_SESSION['admin']['uid'] = $r[F_ID];
					$this->_redirect('/');
				} else {
					$msg = "�û������������";
				}
			}
		}
		$this->_view->assign('msg',$msg);
		$this->_view->display("Login.php");
	}
	
	public function LoginOutAction()
	{
		session_destroy();
		$this->_redirect("/");
	}
	public function GetVerifyImgAction()
	{
		header('Cache-control: private, no-cache'); 
		$_SESSION['verify_code'] = Core_Security_Verify::getVerify();
		Core_Security_Verify::GetImage($_SESSION['verify_code']);
	}
}
?>
