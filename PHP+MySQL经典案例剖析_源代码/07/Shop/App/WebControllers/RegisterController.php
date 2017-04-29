<?php
class RegisterController extends Core_Controller_Action
{
	protected $_model;
	protected $_user;
	/**
	 * ��ʼ�����캯��
	 *
	 */
	public function __construct()
	{
		$this->_model = new RegisterModel();
		$this->_user = new UserModel();
		parent::__construct();
	}
	/**
	 * ���ܣ���ʾע��ҳ��
	 *
	 */
    public function IndexAction()
    {
        $this->_view->display("Register.php");
    }
    /**
     * ���ܣ����ע���ύ����
     *
     */
    public function checkAction()
    {
        $error = $this->_model->checkAll();								//���ע������
        if ($error['NAME_ERR'] || $error['MAIL_ERR'] || $error['PASS_ERR'] || $error['CNFM_ERR'] || $error['VRFY_ERR']) {												//�ж����м���Ƿ�ͨ��
            $this->_view->assign("error",$error);
            $this->_view->display("Register.php");
        } else {
            $apply = $this->_model->applyRegister();						//����ע������
            if (false == $apply) {										//�ж��Ƿ�ע��ɹ�
    			$msg = "ϵͳ�ڲ�����";
    			$this->_view->assign("img","/images/err.gif");
    			$this->_view->assign("msg",$msg);
    			$this->_view->assign("url","<a href='/Register'>����</a>");
    			$this->_view->display("Sysmsg.php");
    			exit();
            }
            $to = $_POST["email"];
            $subject = "�����̳��ʺż���";
            $Security = new Core_Security_Serial();
            $Serial = $Security->getSerial($to);
            $url = WEB_DOMAIN . '/Register/Active/Serial/' . $Serial;
            $body = sprintf(_("���ã� %s<br> ��ϲ��ע���Ϊ�����̳��û�!<br>�������е�ַ�����ʺ�<br>%s"),$_POST["name"],$url);
            $this->_view->assign('url',$url);
            $this->_view->assign('user',$_POST["name"]);
            try {
            	@$this->_user->SendMail($to,$subject,$body);					//���ͼ����ʼ�
            }catch (Exception $e)
            {
            	
            }
            $this->_view->assign("apply",$apply);
            $this->_view->display("RegisterOk.php");
        }
    }
    /**
     * ���ܣ������ò����ڵķ����ĵ��ô˷���
     */
    public function __call($name,$args)
    {
        $this->_redirect("/".$this->_action->getControllerName());
    }
    /**
     * ���ܣ��û��ʻ�����
     *
     */
    public function ActiveAction()
    {
    		$Security = new Core_Security_Serial();
    		$serial = $this->_getParam("Serial");
    		if($email = $Security->checkSerial($serial))					//�жϼ������Ƿ���ȷ
    		{
    			$msg = "����ɹ�";
    			$this->_view->assign("img","/images/msg_ok.gif");
    			$check = $this->_model->CheckIsActive($email);
			if(isset($_SESSION['User']))							//�ж��Ƿ��ѵ�½
    				$_SESSION['User']['F_LOGIN_IS_ACTIVE'] = 1;
    			if($check)											//�ж��Ƿ��Ѿ������
    			{
					$msg = "���Ѿ������ˣ���";
    			}else{
    				$this->_model->SetActive($email);					//���ü���״̬
    			}
    			$this->_view->assign("img","/images/info.gif");
    			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/'>���ص���ҳ</a>");
			$this->_view->display("sysmsg.php");
    		}else{
    			$this->_view->assign("img","/images/info.gif");
    			$this->_view->assign("msg","�������Ѵ�����ѹ��ڣ����½���û��������·��ͼ����ʼ�");
			$this->_view->assign("url","<a href='/'>���ص���ҳ</a>");
			$this->_view->display("sysmsg.php");
    		}
	}

}
?>
