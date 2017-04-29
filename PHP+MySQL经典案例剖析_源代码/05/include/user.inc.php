<?php
class User extends DBSQL
{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 功能：检测用户名是否存在
	 * 参数：$name 用户名
	 * 返回：TRUE OR FALSE
	 */
	public function CheckUserNameExist($name)
	{
		$sql = "SELECT F_ID FROM EM_USER_INFO WHERE F_USER_NAME = '$name'";
		$r = $this->select($sql);
		if($r[0][0])												//检测用户名是否重复
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 功能：用户注册
	 * 参数：$array 注册提交信息
	 */
	public function Register($array)
	{
		$this->begintransaction();									//开始事务处理
		try{
			$data = array();
			$data['F_USER_NAME'] = $array['username'];
			$data['F_USER_PASSWORD'] = md5($array['password']);
			$data['F_USER_NICKNAME'] = $array['NickName'];
			$data['F_USER_EMAIL'] = $array['Email'];
			$data['F_USER_REGTIME'] = time();
			$userid = $this->insertData("EM_USER_INFO",$data);		//插入数据到表5.1
			$data = array();
			$data['F_BLOG_NAME'] = $array['Blog'];
			$data['F_BLOG_DEFAULT_SKINS'] = 'default';
			$data['F_BLOG_REGTIME'] = time();
			$blogid = $this->insertData("EM_BLOG_INFO",$data);		//插入数据到表5.2
			$data = array();
			$data['F_ID_BLOG_INFO'] = $blogid;
			$data['F_ID_USER_INFO'] = $userid;
			$data['F_BLOG_IS_LOCKED'] = 0;
			$data['F_BLOG_PERM_COMMENTS'] = 1;
			$this->insertData("EE_BLOG_USER",$data);				//插入数据到表5.3
			$data = array();
			$data['F_ID_BLOG_INFO'] = $blogid;
			$data['F_CATEGORIES_NAME'] = '默认分类';
			$data['F_CATEGORIES_DESCRIPTION'] = '默认分类';
			$data['F_CATEGORIES_POSTS'] = 0;
			$data['F_CATEGORIES_DEFAULT'] = 1;
			$this->insertData("EE_BLOG_CATEGORIES",$data);			//插入数据到表5.4
		}catch (Exception $e)
		{
			$this->rollback();									//出现异常则回滚，返回false
			return false;
		}
		$this->commit();										//未出现异常则提交，返回true
		return $blogid;
	}
	/**
	 * 功能：用户登陆
	 * 参数：$name 用户名,$password 用户密码
	 * 返回：TRUE OR FALSE
	 */
	public function Login($name,$password)
	{
		$password = md5($password);
		$name = strtoupper($name);
		$sql = "SELECT F_ID,F_USER_NAME,F_USER_NICKNAME FROM EM_USER_INFO ";
		$sql .= "WHERE UPPER(F_USER_NAME) = '$name' AND F_USER_PASSWORD = '$password'";			
		$r = $this->select($sql);
		if($r[0][F_ID])											//判断登陆信息是否正确
		{
			$_SESSION['User']['F_ID'] = $r[0][F_ID];					//把ID记入到SESSION里面
			if(!isset($r[0]['F_USER_NICKNAME']))			//判断昵称是否存在，存在则记入SESSION
				$_SESSION['User']['User_Name'] = $r[0]['F_USER_NAME'];
			else										//不存在，则把用户名记入SESSION
				$_SESSION['User']['User_Name'] = $r[0]['F_USER_NICKNAME'];
			return true;
		}else{
			return false;
		}
	}
	
	public function GetBlogId($userid) {
		$sql = "SELECT F_ID_BLOG_INFO FROM EE_BLOG_USER WHERE F_ID_USER_INFO = $userid";
		$r = $this->select($sql);
		return $r[0][0];
	}
}
?>
