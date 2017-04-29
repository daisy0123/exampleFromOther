<?php
class RegisterController extends Core_Controller_Action
{
	protected $_model;
	protected $_user;
	/**
	 * 初始化构造函数
	 *
	 */
	public function __construct()
	{
		$this->_model = new RegisterModel();
		$this->_user = new UserModel();
		parent::__construct();
	}
	/**
	 * 功能：显示注册页面
	 *
	 */
    public function IndexAction()
    {
        $this->_view->display("Register.php");
    }
    /**
     * 功能：检测注册提交数据
     *
     */
    public function checkAction()
    {
        $error = $this->_model->checkAll();								//检测注册数据
        if ($error['NAME_ERR'] || $error['MAIL_ERR'] || $error['PASS_ERR'] || $error['CNFM_ERR'] || $error['VRFY_ERR']) {												//判断所有检测是否通过
            $this->_view->assign("error",$error);
            $this->_view->display("Register.php");
        } else {
            $apply = $this->_model->applyRegister();						//处理注册数据
            if (false == $apply) {										//判断是否注册成功
    			$msg = "系统内部错误";
    			$this->_view->assign("img","/images/err.gif");
    			$this->_view->assign("msg",$msg);
    			$this->_view->assign("url","<a href='/Register'>返回</a>");
    			$this->_view->display("Sysmsg.php");
    			exit();
            }
            $to = $_POST["email"];
            $subject = "网上商城帐号激活";
            $Security = new Core_Security_Serial();
            $Serial = $Security->getSerial($to);
            $url = WEB_DOMAIN . '/Register/Active/Serial/' . $Serial;
            $body = sprintf(_("您好！ %s<br> 恭喜您注册成为网上商城用户!<br>请点击下列地址激活帐号<br>%s"),$_POST["name"],$url);
            $this->_view->assign('url',$url);
            $this->_view->assign('user',$_POST["name"]);
            try {
            	@$this->_user->SendMail($to,$subject,$body);					//发送激活邮件
            }catch (Exception $e)
            {
            	
            }
            $this->_view->assign("apply",$apply);
            $this->_view->display("RegisterOk.php");
        }
    }
    /**
     * 功能：当调用不存在的方法的调用此方法
     */
    public function __call($name,$args)
    {
        $this->_redirect("/".$this->_action->getControllerName());
    }
    /**
     * 功能：用户帐户激活
     *
     */
    public function ActiveAction()
    {
    		$Security = new Core_Security_Serial();
    		$serial = $this->_getParam("Serial");
    		if($email = $Security->checkSerial($serial))					//判断激活码是否正确
    		{
    			$msg = "激活成功";
    			$this->_view->assign("img","/images/msg_ok.gif");
    			$check = $this->_model->CheckIsActive($email);
			if(isset($_SESSION['User']))							//判断是否已登陆
    				$_SESSION['User']['F_LOGIN_IS_ACTIVE'] = 1;
    			if($check)											//判断是否已经激活过
    			{
					$msg = "您已经激活了！！";
    			}else{
    				$this->_model->SetActive($email);					//设置激活状态
    			}
    			$this->_view->assign("img","/images/info.gif");
    			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/'>返回到主页</a>");
			$this->_view->display("sysmsg.php");
    		}else{
    			$this->_view->assign("img","/images/info.gif");
    			$this->_view->assign("msg","激活码已错误或已过期，请登陆到用户中心重新发送激活邮件");
			$this->_view->assign("url","<a href='/'>返回到主页</a>");
			$this->_view->display("sysmsg.php");
    		}
	}

}
?>
