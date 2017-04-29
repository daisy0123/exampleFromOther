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
     * ���ܣ���ʾ��½����
     */
	public function IndexAction ()
	{
		if(isset($_SESSION['User']))								//�ж��Ƿ��Ѿ���½
		{
			$msg = "���Ѿ���½�ˣ�";
			$this->_view->assign("img","/images/info.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/'>������ҳ</a>");
			$this->_view->display("sysmsg.php");
			exit;
		}
		$this->_view->display("Login.php");
	}
    /**
     * ���ܣ�����½�ύ��Ϣ
     */
    public function CheckAction()
    {
       	$error = $this->_model->check();
        	if ($error['CONT_ERR'] || $error['NAME_ERR'] || $error['PASS_ERR'] || $error['VRFY_ERR']) {
            	$this->_view->assign("error",$error);						//�ж��Ƿ�ͨ�����
            	$this->_view->display("Login.php");
       	} else { 
        		if($this->_model->doLogin())							//�ж��Ƿ��½�ɹ�
			{
				$msg = "��½�ɹ�";
				$this->_view->assign("img","/images/info.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='/'>���ص���ҳ</a>");
				$this->_view->display("sysmsg.php");
			}else{
				$msg = "��½ʧ�ܣ��û������������";
				$this->_view->assign("img","/images/err.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='/Login'>����</a>");
				$this->_view->display("sysmsg.php");				
			}
		}
     }
    public function __call($name,$value)
    {
        $this->_redirect("/".$this->_action->getControllerName());
    }
    /**
	 * ���ܣ���������
	 */	
	public function ForgetPwdAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')				//�ж��Ƿ��ύ����
		{
			$name = trim($_POST['name']);
			$email = trim($_POST['email']);
			if($this->_model->chkMebExtByNameMail($name,$email))	//�ж��û�����EMAIL�Ƿ���ȷ
			{
				$Security = new Core_Security_Serial();
				$Serial = $Security->getSerial($email);
				$url = WEB_DOMAIN . "/Login/ChangePwd/Serial/$Serial";
				try {
					$this->_user->SendMail($email,"�һ�����",sprintf("���ã�%s, <br>�������µ�ַ��������.",$name) . "<br><a href='$url' target='_blank'>$url</a>");
				}catch (Exception $e)
				{
					$this->_view->assign("msg","�ʼ�����ʧ�ܣ������ʼ�����");
					$this->_view->assign("img","/images/info.gif");
					$this->_view->assign("url","<a href='/'>���ص���ҳ</a>");
					$this->_view->display("sysmsg.php");
					exit();
				}
				$this->_view->assign("msg","����һ���ʼ����������䣬����գ�");
				$this->_view->assign("img","/images/info.gif");
				$this->_view->assign("url","<a href='/'>���ص���ҳ</a>");
				$this->_view->display("sysmsg.php");
				exit();
			}else{
				$this->_view->assign("msg","�û������������");
			}
		}
		$this->_view->display("ForgetPwd.php");
	}
    /**
	 * ���ܣ��޸�����
	 */	
	public function ChangePwdAction()
	{
		$Security = new Core_Security_Serial();
		if($email = $Security->checkSerial($this->_getParam("Serial")))	//�ж���֤���Ƿ���ȷ
		{
			$_SESSION['CHANGPSW_EMAIL'] = $email;
			$this->_view->display("ChangePwd.php");
		}else{
			$msg = "��֤�������ѹ���";
			$this->_view->assign("img","/images/err.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/'>������ҳ</a>");
			$this->_view->display("sysmsg.php");
			exit();
		}
	}
    /**
	 * ���ܣ������޸���������
	 */	
	public function DoChangeAction()
	{
		if($this->_model->updatePwd($_SESSION['CHANGPSW_EMAIL'],$_POST[pwd]))
		{													//�ж��Ƿ��޸ĳɹ�
			$msg = "�޸ĳɹ�";
			$this->_view->assign("img","/images/msg_ok.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/Login'>���ص�½</a>");
			$this->_view->display("sysmsg.php");
			session_unregister('CHANGPSW_EMAIL');
		}else{
			$msg = "�޸�ʧ��";
			$this->_view->assign("img","/images/err.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/'>������ҳ</a>");
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
