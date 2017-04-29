<?php
class RegisterModel extends Core_Db_Table
{
    private   $privateAccount = array("system","admin","root");				//定义保留帐号
    private   $post;	
    public    $error = array();
	protected $_name = 'em_login_info';
	
    public function __construct()
    {
        $this->post = $_POST;
		parent::__construct();
    }
	/**
	 * 功能：检测注册提交数据
	 * 返回：数组
	 */
    public function checkAll()
    {
        	$userError = $this->checkUser();								//检测用户名
        	$mailError = $this->checkMail();								//检测EMAIL
        	$passError = $this->checkPass();								//检测密码
        	$cnfmError = $this->checkCnfm();								//检测确认密码
        	$vrfyError = $this->checkVeify();								//检测验证码
        	return array_merge($this->error,$userError,$mailError,$passError,$cnfmError,$vrfyError);
    }
    /**
     * 功能：处理用户注册数据，把数据入库
     * 返回：数组
     */
    public function applyRegister(){
       	//销毁图片验证的session
        	session_unregister("verify_code");
        	$email = trim($this->post['email']);
        	$loginName = trim($this->post['name']);
        	$password = md5(trim($this->post['password']));
		$isacceptemail = $this->post['isacceptemail'];
        	//用户登陆信息表
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
        	} catch (Exception $e) {										//捕获异常，回滚
        		$this->_db->rollBack();
            	return false;
        	}
		//初始化用户详细信息表
        	$id = $this->_db->lastInsertId();
        	$user_rows = array("F_ID_LOGIN_INFO" => $id);
        	try {
            	$this->_db->insert("EE_USER_INFO",$user_rows);
        	} catch (Exception $e) {										//捕获异常，回滚
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
     * 功能：检测注册用户名
     * 返回：数组
     */
    public function checkUser(){
        	if ("" == $this->post['name'])									//判断用户名是否为空
			return array("NAME_ERR"   => true,
					  "NAME_MSG"   => "用户名不能为空",
					  "NAME_VALUE" => trim($this->post['name']));
        	//字符限制
        	if(false == preg_match('/^[A-Za-z0-9_]{3,18}$/',$this->post['name']))		//判断用户名的格式和长度
        		return array("NAME_ERR"   => true,
                    	  "NAME_MSG"   => "用户名格式不正确。用户名为字母开头，字母和数字的组合。字符长度为3-18",
                    	  "NAME_VALUE" => trim($this->post['name']));
        	//受保护帐户限制
        	if (in_array(strtolower($this->post['name']),$this->privateAccount))		//判断用户名是否受保护
        		return array("NAME_ERR"   => true,
                     	  "NAME_MSG"   => "对不起该用户名为保护帐号",
                     	  "NAME_VALUE" => trim($this->post['name']));
        	//登录名存在限制
        	$sql = "SELECT F_ID FROM EM_LOGIN_INFO WHERE LOWER(F_LOGIN_NAME) = '".strtolower(trim($this->post['name']))."'";
        	$result = $this->_db->fetchRow($sql);
        	if (!empty($result))
            	return array("NAME_ERR"   => true,
                         "NAME_MSG"   => "该用户名已经存在了",
                         "NAME_VALUE" => trim($this->post['name']));
        	return array("NAME_VALUE"=>trim($this->post['name']));
    }
	/**
	 * 功能：检测用户EMAIL
	 * 返回：数组
	 */
    private function checkMail()
    {
        	//空限制
        	if ("" == trim($this->post['email']))								//判断EMAIL是否为空
        		return array("MAIL_ERR"   => true,
                     "MAIL_MSG"   => "Email地址不能为空",
                     "MAIL_VALUE" => trim($this->post['email']));

        	//EMAIL格式限制
        	if(false == preg_match('/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/',trim($this->post['email'])))
        		return array("MAIL_ERR"   => true,							//判断EMAIL的格式
                    	  "MAIL_MSG"   => "Email格式错误",
                    	  "MAIL_VALUE" => trim($this->post['email']));

        	//EMAIL被注册限制
        	$sql = "SELECT F_ID FROM EM_LOGIN_INFO WHERE LOWER(F_LOGIN_EMAIL) = '".strtolower(trim($this->post['email']))."'";
        	$result = $this->_db->fetchAll($sql);
        	if (!empty($result))											//判断该EMAIL是否被注册
            	return array("MAIL_ERR"   => true,
                         "MAIL_MSG"   => "Email地址已经存在",
                         "MAIL_VALUE" => trim($this->post['email']));
        	return array("MAIL_VALUE"=>trim($this->post['email']));
    }
	/**
	 * 功能：检测注册密码
	 * 返回：数组
	 */
    private function checkPass()
    {
        	//空限制
        	if (""==trim($this->post['password']))								//判断密码是否为空
        		return array("PASS_ERR"   => true,
                     	  "PASS_MSG"   => "密码不能为空",
                     	  "PASS_VALUE" => trim($this->post['password']));
        	//长度限制，6-20位之间
        	if (20 < strlen(trim($this->post['password'])) || 6 > strlen(trim($this->post['password'])))
        		return array("PASS_ERR"   => true,						//判断密码的长度
                     	  "PASS_MSG"   => "密码长度不正确。6-20个字符",
                     	  "PASS_VALUE" => trim($this->post['password']));
        	return array("PASS_VALUE"=> trim($this->post['password']));
    }
	/**
	 * 功能：检测确认密码
	 * 返回：数组
	 */
    private function checkCnfm()
    {
        	if ("" == trim($this->post['rpassword']))							//判断确认密码是否为空
        		return array("CNFM_ERR"   => true,
                     "CNFM_MSG"   => "确认密码不能为空",
                     "CNFM_VALUE" => trim($this->post['rpassword']));

        	if (trim($this->post['password'])!== trim($this->post['rpassword']))		//判断确认密码是否正确
        		return array("CNFM_ERR"   => true,
                     "CNFM_MSG"   => "密码和确认密码不相同",
                     "CNFM_VALUE" => trim($this->post['rpassword']));
        	return array("CNFM_VALUE"=>trim($this->post['rpassword']));
    }
	/**
	 * 功能：检测验证码
	 * 返回：数组
	 */
    private function checkVeify()
    {
        	if ("" == trim($this->post['verify']))								//判断验证码是否为空
        		return array("VRFY_ERR"   => true,
                     "VRFY_MSG"   => "验证码不能为空",
                     "VRFY_VALUE" => trim($this->post['verify']));
        	if (strtolower($_SESSION['verify_code'])!=strtolower(trim($this->post['verify'])))
        		return array("VRFY_ERR"   => true,						//判断验证码是否正确
                     "VRFY_MSG"   => "验证码不正确",
                     "VRFY_VALUE" => trim(trim($this->post['verify'])));
        	return array("VRFY_MSG"=>"验证码已更新，请重新输入");
    }
    /**
     * 功能：设置激活状态
     * 参数：$email 用户EMAIL
     * 返回：TRUE OR FALSE
     */
    public function SetActive($email)
    {
    	$sql = "UPDATE EM_LOGIN_INFO SET F_LOGIN_IS_ACTIVE = '1' WHERE LOWER(F_LOGIN_EMAIL) = '" . strtolower(trim($email)) . "'";
    	return $this->_db->query($sql);
    }
	/**
	 * 功能：检测是否已激活
	 * 参数：$email 用户EMAIL
	 * @return unknown
	 */
	public function CheckIsActive($email)
    {
        $sql = "SELECT F_LOGIN_IS_ACTIVE FROM EM_LOGIN_INFO WHERE LOWER(F_LOGIN_EMAIL) = '" . strtolower(trim($email)) . "'";
        $r = $this->_db->fetchRow($sql);
        if($r[F_LOGIN_IS_ACTIVE] == 0)							//判断是否已激活
        	return false;
        else
        	return true;
    }

}
?>
