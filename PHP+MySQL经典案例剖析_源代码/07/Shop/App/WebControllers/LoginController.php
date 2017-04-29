<?php
class LoginController extends Core_Controller_Action
{
	public function __construct()
	{
		$this->_model = new LoginModel();
		$this->_user = new UserModel();
		parent::__construct();
	}
    /**
     * 功能：显示登陆界面
     */
	public function IndexAction ()
	{
		if(isset($_SESSION['User']))								//判断是否已经登陆
		{
			$msg = "您已经登陆了！";
			$this->_view->assign("img","/images/info.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/'>返回首页</a>");
			$this->_view->display("sysmsg.php");
			exit;
		}
		$this->_view->display("Login.php");
	}
    /**
     * 功能：检测登陆提交信息
     */
    public function CheckAction()
    {
       	$error = $this->_model->check();
        	if ($error['CONT_ERR'] || $error['NAME_ERR'] || $error['PASS_ERR'] || $error['VRFY_ERR']) {
            	$this->_view->assign("error",$error);						//判断是否通过检测
            	$this->_view->display("Login.php");
       	} else { 
        		if($this->_model->doLogin())							//判断是否登陆成功
			{
				$msg = "登陆成功";
				$this->_view->assign("img","/images/info.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='/'>返回到主页</a>");
				$this->_view->display("sysmsg.php");
			}else{
				$msg = "登陆失败，用户名或密码错误";
				$this->_view->assign("img","/images/err.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='/Login'>返回</a>");
				$this->_view->display("sysmsg.php");				
			}
		}
     }
    public function __call($name,$value)
    {
        $this->_redirect("/".$this->_action->getControllerName());
    }
    /**
	 * 功能：忘记密码
	 */	
	public function ForgetPwdAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')				//判断是否提交操作
		{
			$name = trim($_POST['name']);
			$email = trim($_POST['email']);
			if($this->_model->chkMebExtByNameMail($name,$email))	//判断用户名和EMAIL是否正确
			{
				$Security = new Core_Security_Serial();
				$Serial = $Security->getSerial($email);
				$url = WEB_DOMAIN . "/Login/ChangePwd/Serial/$Serial";
				try {
					$this->_user->SendMail($email,"找回密码",sprintf("您好！%s, <br>请点击以下地址重设密码.",$name) . "<br><a href='$url' target='_blank'>$url</a>");
				}catch (Exception $e)
				{
					$this->_view->assign("msg","邮件发送失败，请检查邮件设置");
					$this->_view->assign("img","/images/info.gif");
					$this->_view->assign("url","<a href='/'>返回到主页</a>");
					$this->_view->display("sysmsg.php");
					exit();
				}
				$this->_view->assign("msg","发送一封邮件到您的邮箱，请查收！");
				$this->_view->assign("img","/images/info.gif");
				$this->_view->assign("url","<a href='/'>返回到主页</a>");
				$this->_view->display("sysmsg.php");
				exit();
			}else{
				$this->_view->assign("msg","用户名或邮箱错误");
			}
		}
		$this->_view->display("ForgetPwd.php");
	}
    /**
	 * 功能：修改密码
	 */	
	public function ChangePwdAction()
	{
		$Security = new Core_Security_Serial();
		if($email = $Security->checkSerial($this->_getParam("Serial")))	//判断验证码是否正确
		{
			$_SESSION['CHANGPSW_EMAIL'] = $email;
			$this->_view->display("ChangePwd.php");
		}else{
			$msg = "验证码错误或已过期";
			$this->_view->assign("img","/images/err.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/'>返回主页</a>");
			$this->_view->display("sysmsg.php");
			exit();
		}
	}
    /**
	 * 功能：处理修改密码数据
	 */	
	public function DoChangeAction()
	{
		if($this->_model->updatePwd($_SESSION['CHANGPSW_EMAIL'],$_POST[pwd]))
		{													//判断是否修改成功
			$msg = "修改成功";
			$this->_view->assign("img","/images/msg_ok.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/Login'>返回登陆</a>");
			$this->_view->display("sysmsg.php");
			session_unregister('CHANGPSW_EMAIL');
		}else{
			$msg = "修改失败";
			$this->_view->assign("img","/images/err.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/'>返回首页</a>");
			$this->_view->display("sysmsg.php");
		}
	}
	
	public function LoginOutAction() 
	{
		session_destroy();
		$this->_redirect("/");
	}
}
?>
