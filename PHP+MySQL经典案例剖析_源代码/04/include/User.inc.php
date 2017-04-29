<?php
require_once(INCLUDE_PATH . 'db.inc.php');
class User extends DBSQL
{
	public $pagesize;
	public function __construct()
	{
		$this->pagesize = 20;
		parent::__construct();
	}
	/**
	 * 功能：分页提取用户列表
	 * 参数：当前页码
	 * 返回：数组
	 */
	public function GetUserList($page=1)
	{
		$start = ($page - 1) * $this->pagesize;
		$sql = "SELECT * FROM EM_USER_INFO ORDER BY F_ID DESC LIMIT $start,$this->pagesize";
		return $this->select($sql);
	}
	/**
	 * 功能：提取用户数量
	 * 返回：用户数量
	 */	
	public function GetUserCount()
	{
		$sql = "SELECT COUNT(F_ID) FROM EM_USER_INFO";
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * 功能：验证登陆信息
	 * 返回：验证通过返回用户信息数组，不通过返回FALSE
	 */		
	public function CheckLogin($no,$password)
	{
		$password = md5($password);
		$sql = "SELECT * FROM EM_USER_INFO WHERE F_USER_NO = '$no'";
		$sql .= " AND F_USER_PASSWORD = '$password'";
		$r = $this->select($sql);
		if($r[0][F_ID])											//判断是否验证通过
		{
			return $r[0];
		}else{
			return false;
		}
	}
}
?>
