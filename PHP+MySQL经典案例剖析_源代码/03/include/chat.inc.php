<?php
require_once(INCLUDE_PATH . 'db.inc.php');
class Chat extends DBSQL
{
	private $_limit;										//定义聊天室限制人数
	private $_duration;									//定义在线过期时间
	/**
	 * 初始化构造函数
	 *
	 */
	public function __construct()
	{
		$this->_limit = 30;								//聊天室限制人数30人
		$this->_duration = 333600;							//在线过期时间1800秒
		parent::__construct();
	}
	/**
	 * 功能：提取在线会员列表 
	 * 
	 */
	public function GetOnlineList()
	{
		$sql = "DELETE FROM EE_ONLINE_INFO WHERE (UNIX_TIMESTAMP(NOW())-F_ONLINE_TIME)>" . $this->_duration;
		$this->delete($sql);								//删除过期在线会员
		$sql = "SELECT u.F_USER_NAME,u.F_ID,u.F_USER_NICKNAME FROM EM_USER_INFO u,EE_ONLINE_INFO o WHERE u.F_ID = o.F_ID_USER_INFO";							//提取在线人数
		return $this->select($sql);
	}
	/**
	 * 功能：判断聊天室人数是否已满
	 * 返回：TRUE OR FALSE
	 */
	public function CheckIsFull()
	{
		$sql = "DELETE FROM EE_ONLINE_INFO WHERE (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(F_ONLINE_TIME))>" . $this->_duration;
		$this->delete($sql);								//删除过期在线会员
		$sql = "SELECT COUNT(F_ID) FROM EE_ONLINE_INFO";
		$r = $this->select($sql);							//提取在线会员人数
		if($r[0][0] >= $this->_limit)							//判断在线人数是否超过限制
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 功能：验证登陆信息
	 * 参数：$name 用户名,$password 密码
	 * 返回：TRUE OR FALSE
	 */
	public function CheckUser($name,$password)
	{
		$password = md5($password);
		$sql = "SELECT F_ID FROM EM_USER_INFO WHERE F_USER_NAME = '$name' AND F_USER_PASSWORD = '$password'";
		$r = $this->select($sql);
		if($r[0][F_ID] > 0)								//判断登陆信息是否正确
		{
			$data = array();
			$data[F_ID_USER_INFO] = $r[0][F_ID];
			$data[F_ONLINE_TIME] = time();
			$this->insertData('ee_online_info',$data);
			return $r[0][F_ID];
		}else{
			return false;
		}
	}
	/**
	 * 功能：检测用户名是否存在
	 * 参数：$name 用户名
	 * 返回：TRUE OR FALSE
	 */
	public function CheckUserExist($name)
	{
		$sql = "SELECT F_ID FROM EM_USER_INFO WHERE F_USER_NAME = '$name'";
		$r = $this->select($sql);
		if($r[0][F_ID] > 0)								//判断根据用户名提取的记录ID是否大于0
		{											//大于0说明该用户名存在
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 功能：提取最新的不属于该用户的一条发言
	 * 参数：$user_id 用户ID
	 * 返回：字符串
	 */
	public function GetNewMessge($user_id)
	{
		$sql = "SELECT m.F_MESS_INFO,m.F_ID,u.F_USER_NICKNAME FROM EE_MESSAGE_INFO m,";
		$sql .= "EM_USER_INFO u WHERE F_MESS_IS_NEW = 1 AND F_ID_USER_INFO <> $user_id ";
		$sql .= " AND m.F_ID_USER_INFO = u.F_ID";
		$r = $this->select($sql);
		$sql = "UPDATE EE_MESSAGE_INFO SET F_MESS_IS_NEW = 0 WHERE F_ID = " . $r[0][F_ID];
		$this->update($sql);
		$sql = "SELECT F_ID FROM EE_DISABLE_USER WHERE F_DISABLE_USER_ID = ";
		$sql .= $r[0][F_ID_USER_INFO] . " AND F_ID_USER_INFO = " . $user_id;
		$d = $this->select($sql);
		if($d[0][F_ID])									//判断是否有信息
		{
			return "";
		}else{
			return $r[0];
		}
	}
	/**
	 * 功能：提取聊天记录
	 * 参数：$page 当前页码
	 * 返回：数组
	 */
	public function GetMsgList($page=1)
	{
		$start = ($page - 1) * 30;
		$sql = "SELECT m.F_MESS_INFO,u.F_USER_NICKNAME FROM EE_MESSAGE_INFO m,";
		$sql .= "EM_USER_INFO u WHERE m.F_ID_USER_INFO = u.F_ID";
		$sql .= " ORDER BY F_MESS_TIME DESC LIMIT $start,30";
		return $this->select($sql);
	}
	/**
	 * 功能：提取聊天记录条数
	 *
	 * 返回：记录条数
	 */
	public function GetMsgCount()
	{
		$sql = "SELECT COUNT(*) FROM EE_MESSAGE_INFO";
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * 功能：检查该用户是否被踢
	 * 参数：$user_id 用户ID
	 * 返回：记录ID OR FALSE
	 */
	public function CheckIsKicked($user_id)
	{
		$sql = "SELECT F_ID FROM EE_KICK_USER WHERE F_KICK_USER_ID = $user_id";
		$r = $this->select($sql);
		if($r[0][F_ID] > 0)								//判断是否有记录，有则返回该记录ID
		{
			$sql = "DELETE FROM EE_KICK_USER WHERE F_ID = {$r[0][F_ID]}";
			$this->delete($sql);							//删除该记录
			$sql = "DELETE FROM EE_ONLINE_INFO WHERE F_ID_USER_INFO = $user_id";
			$this->delete($sql);							//删除该用户的在线记录
			return $r[0][F_ID];
		}else{
			return false;
		}
	}
	/**
	 * 功能：检查该用户是否是管理员
	 * 参数：$user_id 用户ID
	 * 返回：TRUE OR FALSE
	 */
	public function CheckIsAdmin($user_id) 
	{
		$sql = "SELECT F_USER_IS_ADMIN FROM EM_USER_INFO WHERE F_ID = $user_id";
		$r = $this->select($sql);
		if($r[0][0]) {
			return true;
		} else {
			return false;
		}
	}
}
?>
