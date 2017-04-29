<?php
class RegisterModel extends Core_Db_Table
{
    private   $privateAccount = array("system","admin","root");				//���屣���ʺ�
    private   $post;	
    public    $error = array();
	protected $_name = 'em_login_info';
	
    public function __construct()
    {
        $this->post = $_POST;
		parent::__construct();
    }
	/**
	 * ���ܣ����ע���ύ����
	 * ���أ�����
	 */
    public function checkAll()
    {
        	$userError = $this->checkUser();								//����û���
        	$mailError = $this->checkMail();								//���EMAIL
        	$passError = $this->checkPass();								//�������
        	$cnfmError = $this->checkCnfm();								//���ȷ������
        	$vrfyError = $this->checkVeify();								//�����֤��
        	return array_merge($this->error,$userError,$mailError,$passError,$cnfmError,$vrfyError);
    }
    /**
     * ���ܣ������û�ע�����ݣ����������
     * ���أ�����
     */
    public function applyRegister(){
       	//����ͼƬ��֤��session
        	session_unregister("verify_code");
        	$email = trim($this->post['email']);
        	$loginName = trim($this->post['name']);
        	$password = md5(trim($this->post['password']));
		$isacceptemail = $this->post['isacceptemail'];
        	//�û���½��Ϣ��
        	$this->_db->beginTransaction();
        	$member_rows = array("F_LOGIN_EMAIL"        => $email,
                             "F_LOGIN_NAME"         => $loginName,
                             "F_LOGIN_PASSWORD"     => $password,
                             "F_LOGIN_ACCEPT_EMAIL" => 1,
                             "F_LOGIN_IS_ACTIVE"    => 1,
                             "F_LOGIN_TIME"         => time()
							 );
        	unset($password);
        	try {
            	$this->_db->insert("EM_LOGIN_INFO",$member_rows);
        	} catch (Exception $e) {										//�����쳣���ع�
        		$this->_db->rollBack();
            	return false;
        	}
		//��ʼ���û���ϸ��Ϣ��
        	$id = $this->_db->lastInsertId();
        	$user_rows = array("F_ID_LOGIN_INFO" => $id);
        	try {
            	$this->_db->insert("EE_USER_INFO",$user_rows);
        	} catch (Exception $e) {										//�����쳣���ع�
        		$this->_db->rollBack();
            	return false;
        	}        
        	$this->_db->commit();        
		$mailServer = substr($email,strpos($email,"@")+1);
        	$mailServerAddAry = array("gmail.com"    => "http://mail.google.com/",
                                  "163.com"      => "http://mail.163.com/",
                                  "126.com"      => "http://www.126.com/",
                                  "tom.com"      => "http://mail.tom.com/",
                                  "qq.com"       => "http://mail.qq.com/",
                                  "hotmail.com"  => "http://www.hotmail.com/",
                                  "yahoo.com.cn" => "http://cn.mail.yahoo.com/",
                                  "sina.com"     => "http://mail.sina.com/",
                                  "21cn.com"     => "http://mail.21cn.com/",
                                  "yeah.net"     => "http://www.yeah.net/",
                                  "yahoo.com"    => "http://mail.yahoo.com/",
                                  "sogou.com"    => "http://mail.sogou.com/",
                                  "188.com"      => "http://www.188.com/",
                                  "etang.com"    => "http://mail.etang.com/",
                                  "msn.com"      => "http://www.hotmail.com");
		
        	$mailServerAdd = $mailServerAddAry[$mailServer];
        	return array("email"      => $email,
                     "mailserver" => $mailServerAdd);
    }

    /**
     * ���ܣ����ע���û���
     * ���أ�����
     */
    public function checkUser(){
        	if ("" == $this->post['name'])									//�ж��û����Ƿ�Ϊ��
			return array("NAME_ERR"   => true,
					  "NAME_MSG"   => "�û�������Ϊ��",
					  "NAME_VALUE" => trim($this->post['name']));
        	//�ַ�����
        	if(false == preg_match('/^[A-Za-z0-9_]{3,18}$/',$this->post['name']))		//�ж��û����ĸ�ʽ�ͳ���
        		return array("NAME_ERR"   => true,
                    	  "NAME_MSG"   => "�û�����ʽ����ȷ���û���Ϊ��ĸ��ͷ����ĸ�����ֵ���ϡ��ַ�����Ϊ3-18",
                    	  "NAME_VALUE" => trim($this->post['name']));
        	//�ܱ����ʻ�����
        	if (in_array(strtolower($this->post['name']),$this->privateAccount))		//�ж��û����Ƿ��ܱ���
        		return array("NAME_ERR"   => true,
                     	  "NAME_MSG"   => "�Բ�����û���Ϊ�����ʺ�",
                     	  "NAME_VALUE" => trim($this->post['name']));
        	//��¼����������
        	$sql = "SELECT F_ID FROM EM_LOGIN_INFO WHERE LOWER(F_LOGIN_NAME) = '".strtolower(trim($this->post['name']))."'";
        	$result = $this->_db->fetchRow($sql);
        	if (!empty($result))
            	return array("NAME_ERR"   => true,
                         "NAME_MSG"   => "���û����Ѿ�������",
                         "NAME_VALUE" => trim($this->post['name']));
        	return array("NAME_VALUE"=>trim($this->post['name']));
    }
	/**
	 * ���ܣ�����û�EMAIL
	 * ���أ�����
	 */
    private function checkMail()
    {
        	//������
        	if ("" == trim($this->post['email']))								//�ж�EMAIL�Ƿ�Ϊ��
        		return array("MAIL_ERR"   => true,
                     "MAIL_MSG"   => "Email��ַ����Ϊ��",
                     "MAIL_VALUE" => trim($this->post['email']));

        	//EMAIL��ʽ����
        	if(false == preg_match('/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/',trim($this->post['email'])))
        		return array("MAIL_ERR"   => true,							//�ж�EMAIL�ĸ�ʽ
                    	  "MAIL_MSG"   => "Email��ʽ����",
                    	  "MAIL_VALUE" => trim($this->post['email']));

        	//EMAIL��ע������
        	$sql = "SELECT F_ID FROM EM_LOGIN_INFO WHERE LOWER(F_LOGIN_EMAIL) = '".strtolower(trim($this->post['email']))."'";
        	$result = $this->_db->fetchAll($sql);
        	if (!empty($result))											//�жϸ�EMAIL�Ƿ�ע��
            	return array("MAIL_ERR"   => true,
                         "MAIL_MSG"   => "Email��ַ�Ѿ�����",
                         "MAIL_VALUE" => trim($this->post['email']));
        	return array("MAIL_VALUE"=>trim($this->post['email']));
    }
	/**
	 * ���ܣ����ע������
	 * ���أ�����
	 */
    private function checkPass()
    {
        	//������
        	if (""==trim($this->post['password']))								//�ж������Ƿ�Ϊ��
        		return array("PASS_ERR"   => true,
                     	  "PASS_MSG"   => "���벻��Ϊ��",
                     	  "PASS_VALUE" => trim($this->post['password']));
        	//�������ƣ�6-20λ֮��
        	if (20 < strlen(trim($this->post['password'])) || 6 > strlen(trim($this->post['password'])))
        		return array("PASS_ERR"   => true,						//�ж�����ĳ���
                     	  "PASS_MSG"   => "���볤�Ȳ���ȷ��6-20���ַ�",
                     	  "PASS_VALUE" => trim($this->post['password']));
        	return array("PASS_VALUE"=> trim($this->post['password']));
    }
	/**
	 * ���ܣ����ȷ������
	 * ���أ�����
	 */
    private function checkCnfm()
    {
        	if ("" == trim($this->post['rpassword']))							//�ж�ȷ�������Ƿ�Ϊ��
        		return array("CNFM_ERR"   => true,
                     "CNFM_MSG"   => "ȷ�����벻��Ϊ��",
                     "CNFM_VALUE" => trim($this->post['rpassword']));

        	if (trim($this->post['password'])!== trim($this->post['rpassword']))		//�ж�ȷ�������Ƿ���ȷ
        		return array("CNFM_ERR"   => true,
                     "CNFM_MSG"   => "�����ȷ�����벻��ͬ",
                     "CNFM_VALUE" => trim($this->post['rpassword']));
        	return array("CNFM_VALUE"=>trim($this->post['rpassword']));
    }
	/**
	 * ���ܣ������֤��
	 * ���أ�����
	 */
    private function checkVeify()
    {
        	if ("" == trim($this->post['verify']))								//�ж���֤���Ƿ�Ϊ��
        		return array("VRFY_ERR"   => true,
                     "VRFY_MSG"   => "��֤�벻��Ϊ��",
                     "VRFY_VALUE" => trim($this->post['verify']));
        	if (strtolower($_SESSION['verify_code'])!=strtolower(trim($this->post['verify'])))
        		return array("VRFY_ERR"   => true,						//�ж���֤���Ƿ���ȷ
                     "VRFY_MSG"   => "��֤�벻��ȷ",
                     "VRFY_VALUE" => trim(trim($this->post['verify'])));
        	return array("VRFY_MSG"=>"��֤���Ѹ��£�����������");
    }
    /**
     * ���ܣ����ü���״̬
     * ������$email �û�EMAIL
     * ���أ�TRUE OR FALSE
     */
    public function SetActive($email)
    {
    	$sql = "UPDATE EM_LOGIN_INFO SET F_LOGIN_IS_ACTIVE = '1' WHERE LOWER(F_LOGIN_EMAIL) = '" . strtolower(trim($email)) . "'";
    	return $this->_db->query($sql);
    }
	/**
	 * ���ܣ�����Ƿ��Ѽ���
	 * ������$email �û�EMAIL
	 * @return unknown
	 */
	public function CheckIsActive($email)
    {
        $sql = "SELECT F_LOGIN_IS_ACTIVE FROM EM_LOGIN_INFO WHERE LOWER(F_LOGIN_EMAIL) = '" . strtolower(trim($email)) . "'";
        $r = $this->_db->fetchRow($sql);
        if($r[F_LOGIN_IS_ACTIVE] == 0)							//�ж��Ƿ��Ѽ���
        	return false;
        else
        	return true;
    }

}
?>
