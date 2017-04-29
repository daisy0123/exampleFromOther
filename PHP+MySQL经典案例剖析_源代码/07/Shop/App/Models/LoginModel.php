<?php
class LoginModel extends Core_Db_Table
{
    protected $post;
    private $user_exist = false;
	protected $_name = "EM_LOGIN_INFO";
    /**
     * 初始化构造函数,处理$_POST.
     */
    public function __construct()
    {
        $this->post = $_POST;
        parent::__construct();
    }
	/**
      * 功能：检测用户登陆信息
      */
    public function check() {
        return array_merge($this->checkName(),
        				   $this->checkPassword(),
        				   $this->checkVerify());
    }
    /**
     * 功能：校验用户名.
     * 返回：数组
     */
    private function checkName()
    {
        if ("" == trim($this->post['name']))								//判断用户名是否为空
        		return array("NAME_ERR" => true,
        			 	 "NAME_MSG" => "用户名不能为空");

        if (false === $this->checkLoginNameExists(trim($this->post['name']))) {
            	return array("NAME_ERR"   => true,					//判断用户名是否存在
            			  "NAME_MSG"   => “用户名不存在”,
           			  "NAME_VALUE" => trim($this->post['name']));
        }
        $this->user_exist = true;
        return array("NAME_VALUE"=>trim($this->post['name']));
    }
    /**
     * 功能：校验密码.
     * 返回：数组
     */
    private function checkPassword()
    {
        if ("" == trim($this->post['password']))							//判断密码是否为空
        		return array("PASS_ERR" => true,
        	             "PASS_MSG" => "密码不能为空");

        if ($this->user_exist && false === $this->checkPass(trim($this->post['name']),trim($this->post['password']))) {	//判断密码是否正确
            	return array("PASS_ERR" => true,
            			  "PASS_MSG" => “密码错误”,
            			  "PASS_VALUE" =>trim($this->post['password']));
        }
        return array("PASS_VALUE"=>trim($this->post['password']));
    }
    /**
     * 功能：校验验证码.
     * 返回：数组
     */
    public function checkVerify() {
        if ("" == trim($this->post['verify']))								//判断验证码是否为空
        		return array("VRFY_ERR"   => true,
       			      "VRFY_MSG"   => "验证码不能为空",
        				 "VRFY_VALUE" => trim($this->post['verify']));
        if (strtolower($_SESSION['verify_code'])!=strtolower(trim($this->post['verify'])))
        		return array("VRFY_ERR"   => true,					//判断验证码是否正确
        				  "VRFY_MSG"   => "验证码不能为空",
        				"VRFY_VALUE" => trim($this->post['verify']));
        return array("VRFY_MSG"=>"验证码已更新，请重新输入");
    }
    /**
     * 功能：检测密码是否正确
     * 参数：$name 用户名,$password 未经MD5的密码
     * 返回：TRUE OR FALSE
     */
    public function checkPass($name,$password) {
		$sql = "SELECT F_ID FROM EM_LOGIN_INFO WHERE LOWER(F_LOGIN_NAME) ='{$name}' AND F_LOGIN_PASSWORD = '"	. md5($password) . "'";
        	$r = $this->_db->fetchRow($sql);
        	return (!empty($r));
   	}
	/**
      * 功能：判断用户名是否存在
      * 返回：TRUE OR FALSE
      */
	public function checkLoginNameExists($name)
	{
		$sql = "SELECT F_ID FROM EM_LOGIN_INFO WHERE LOWER(F_LOGIN_NAME) = '" . strtolower($name) . "'";
		$r = $this->_db->fetchRow($sql);
		if($r[F_ID])											//判断用户名是否存在
		{
			return true;
		}else{
			return false;
		}
	}
    /**
     * 功能：执行登陆
     */
    	public function doLogin() {
        	session_unregister("verify_code");
		$name = trim($this->post['name']);
		$password = $this->post['password'];
		$sql = "SELECT F_ID,F_LOGIN_NAME,F_LOGIN_EMAIL,F_LOGIN_IS_ACTIVE FROM EM_LOGIN_INFO WHERE LOWER(F_LOGIN_NAME) ='$name' AND F_LOGIN_PASSWORD = '"	. md5($password) . "'";	
		$r = $this->_db->fetchRow($sql);
		if($r)													//判断是否登陆成功
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
	 * 功能：检测用户提交找回密码用户名和邮箱信息
	 * 参数：$name 用户名,$email 用户邮箱
	 */
    public function chkMebExtByNameMail($name,$email) {
        if (empty($email))										//判断email是否为空
        	return false;
		if(empty($name))										//判断用户名是否为空
			return false;
        	$sql = "SELECT F_ID FROM EM_LOGIN_INFO WHERE LOWER(F_LOGIN_EMAIL) = '" . strtolower($email) . "'";
        	$sql .= "AND LOWER(F_LOGIN_NAME) = '" .  strtolower($name) . "'";
        	$result = $this->_db->fetchRow($sql);	
        	if (!empty($result))										//判断用户名和email是否正确
        		return true;
        	else
        		return false;
    	}
	/**
	 * 功能：修改密码
	 * 参数：$email 用户EMAIL,$password 密码
	 */
	public function updatePwd($email,$password)
	{
        $password = md5($password);
        $sql = "UPDATE EM_LOGIN_INFO SET F_LOGIN_PASSWORD = '$password' WHERE LOWER(F_LOGIN_EMAIL) = '" . strtolower($email) ."'";
        return $this->_db->query($sql);
	}

}
?>
