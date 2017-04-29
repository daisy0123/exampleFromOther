<?php
class LoginModel extends Core_Db_Table
{
    protected $post;
    private $user_exist = false;
	protected $_name = "EM_LOGIN_INFO";
    /**
     * ��ʼ�����캯��,����$_POST.
     */
    public function __construct()
    {
        $this->post = $_POST;
        parent::__construct();
    }
	/**
      * ���ܣ�����û���½��Ϣ
      */
    public function check() {
        return array_merge($this->checkName(),
        				   $this->checkPassword(),
        				   $this->checkVerify());
    }
    /**
     * ���ܣ�У���û���.
     * ���أ�����
     */
    private function checkName()
    {
        if ("" == trim($this->post['name']))								//�ж��û����Ƿ�Ϊ��
        		return array("NAME_ERR" => true,
        			 	 "NAME_MSG" => "�û�������Ϊ��");

        if (false === $this->checkLoginNameExists(trim($this->post['name']))) {
            	return array("NAME_ERR"   => true,					//�ж��û����Ƿ����
            			  "NAME_MSG"   => ���û��������ڡ�,
           			  "NAME_VALUE" => trim($this->post['name']));
        }
        $this->user_exist = true;
        return array("NAME_VALUE"=>trim($this->post['name']));
    }
    /**
     * ���ܣ�У������.
     * ���أ�����
     */
    private function checkPassword()
    {
        if ("" == trim($this->post['password']))							//�ж������Ƿ�Ϊ��
        		return array("PASS_ERR" => true,
        	             "PASS_MSG" => "���벻��Ϊ��");

        if ($this->user_exist && false === $this->checkPass(trim($this->post['name']),trim($this->post['password']))) {	//�ж������Ƿ���ȷ
            	return array("PASS_ERR" => true,
            			  "PASS_MSG" => ���������,
            			  "PASS_VALUE" =>trim($this->post['password']));
        }
        return array("PASS_VALUE"=>trim($this->post['password']));
    }
    /**
     * ���ܣ�У����֤��.
     * ���أ�����
     */
    public function checkVerify() {
        if ("" == trim($this->post['verify']))								//�ж���֤���Ƿ�Ϊ��
        		return array("VRFY_ERR"   => true,
       			      "VRFY_MSG"   => "��֤�벻��Ϊ��",
        				 "VRFY_VALUE" => trim($this->post['verify']));
        if (strtolower($_SESSION['verify_code'])!=strtolower(trim($this->post['verify'])))
        		return array("VRFY_ERR"   => true,					//�ж���֤���Ƿ���ȷ
        				  "VRFY_MSG"   => "��֤�벻��Ϊ��",
        				"VRFY_VALUE" => trim($this->post['verify']));
        return array("VRFY_MSG"=>"��֤���Ѹ��£�����������");
    }
    /**
     * ���ܣ���������Ƿ���ȷ
     * ������$name �û���,$password δ��MD5������
     * ���أ�TRUE OR FALSE
     */
    public function checkPass($name,$password) {
		$sql = "SELECT F_ID FROM EM_LOGIN_INFO WHERE LOWER(F_LOGIN_NAME) ='{$name}' AND F_LOGIN_PASSWORD = '"	. md5($password) . "'";
        	$r = $this->_db->fetchRow($sql);
        	return (!empty($r));
   	}
	/**
      * ���ܣ��ж��û����Ƿ����
      * ���أ�TRUE OR FALSE
      */
	public function checkLoginNameExists($name)
	{
		$sql = "SELECT F_ID FROM EM_LOGIN_INFO WHERE LOWER(F_LOGIN_NAME) = '" . strtolower($name) . "'";
		$r = $this->_db->fetchRow($sql);
		if($r[F_ID])											//�ж��û����Ƿ����
		{
			return true;
		}else{
			return false;
		}
	}
    /**
     * ���ܣ�ִ�е�½
     */
    	public function doLogin() {
        	session_unregister("verify_code");
		$name = trim($this->post['name']);
		$password = $this->post['password'];
		$sql = "SELECT F_ID,F_LOGIN_NAME,F_LOGIN_EMAIL,F_LOGIN_IS_ACTIVE FROM EM_LOGIN_INFO WHERE LOWER(F_LOGIN_NAME) ='$name' AND F_LOGIN_PASSWORD = '"	. md5($password) . "'";	
		$r = $this->_db->fetchRow($sql);
		if($r)													//�ж��Ƿ��½�ɹ�
		{
			$_SESSION['User']['F_ID'] = $r[F_ID];
			$_SESSION['User']['F_LOGIN_NAME'] = $r[F_LOGIN_NAME];
			$_SESSION['User']['F_LOGIN_EMAIL'] = $r[F_LOGIN_EMAIL];
			$_SESSION['User']['F_LOGIN_IS_ACTIVE'] = $r[F_LOGIN_IS_ACTIVE];	
			return true;
		}else{
			return false;
		}
    }
	/**
	 * ���ܣ�����û��ύ�һ������û�����������Ϣ
	 * ������$name �û���,$email �û�����
	 */
    public function chkMebExtByNameMail($name,$email) {
        if (empty($email))										//�ж�email�Ƿ�Ϊ��
        	return false;
		if(empty($name))										//�ж��û����Ƿ�Ϊ��
			return false;
        	$sql = "SELECT F_ID FROM EM_LOGIN_INFO WHERE LOWER(F_LOGIN_EMAIL) = '" . strtolower($email) . "'";
        	$sql .= "AND LOWER(F_LOGIN_NAME) = '" .  strtolower($name) . "'";
        	$result = $this->_db->fetchRow($sql);	
        	if (!empty($result))										//�ж��û�����email�Ƿ���ȷ
        		return true;
        	else
        		return false;
    	}
	/**
	 * ���ܣ��޸�����
	 * ������$email �û�EMAIL,$password ����
	 */
	public function updatePwd($email,$password)
	{
        $password = md5($password);
        $sql = "UPDATE EM_LOGIN_INFO SET F_LOGIN_PASSWORD = '$password' WHERE LOWER(F_LOGIN_EMAIL) = '" . strtolower($email) ."'";
        return $this->_db->query($sql);
	}

}
?>
