<?php
class IndexController extends Core_Controller_Action 
{
	/**
	 * 功能：初始化构造函数
	 */
	public function __construct()
	{
        $this->_model = new AdminModel();
		parent::__construct();
	}
	/**
	 * 功能：首页
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
	 * 功能：左边导航条
	 */
	public function LeftAction()
	{
		$this->_view->display("Left.php");
	}
	/**
	 * 功能：右边
	 */
	public function RightAction()
	{
		$this->_view->display("Right.php");
	}
	/**
	 * 功能：登陆
	 */	
	public function LoginAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if(strtolower($_SESSION['verify_code']) != strtolower($_POST['code'])) {
				$msg = "验证码错误";
			} else {
				if($r = $this->_model->checkLogin($_POST['username'],$_POST['password'])) {
					$_SESSION['admin']['username'] = $r[F_USER_NAME];
					$_SESSION['admin']['uid'] = $r[F_ID];
					$this->_redirect('/');
				} else {
					$msg = "用户名或密码错误";
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
