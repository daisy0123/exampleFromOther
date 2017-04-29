<?php
class User extends DBSQL 
{
	public function __construct()
	{
		parent::__construct();
	}
	/**
      * 功能：验证登陆信息
      * 参数：$username 用户名,$password 密码
      * 返回：false 或 数组
      */
	public function CheckLogin($username,$password)
	{
		$password = md5($password);
		$sql = "SELECT F_ID,F_USER_NAME,F_ID_GROUP_INFO FROM EM_ADMIN_INFO";
		$sql .= " WHERE F_USER_NAME = '$username' AND F_USER_PASSWORD = '$password'";
		$r = $this->select($sql);
		if($r[0]['F_ID'] > 0)										//判断是否有记录，有则返回数组
		{
			return $r[0];
		}else{
			return false;
		}
	}
	/**
	 * 功能：提取该组的菜单
	 * 参数：$groupid 组ID,$parentid 菜单父ID
	 * 返回：数组
	 */
	public function GetMenuList($groupid,$parentid)
	{
		$sql = "SELECT m.F_MENU_NAME,m.F_MENU_LINK,g.F_ID_MENU_INFO FROM EE_MENU_GROUP g,EM_MENU_INFO m";
		$sql .= " WHERE g.F_ID_GROUP_INFO = $groupid AND g.F_ID_MENU_INFO = m.F_ID AND g.F_PARENT_ID = $parentid";
		return $this->select($sql);
	}
	/**
	 * 功能：提取用户组列表
	 * 返回：数组
	 */	
	public function GetGroupList()
	{
		$sql = "SELECT * FROM EM_GROUP_INFO";
		return $this->select($sql);
	}
	/**
	 * 功能：判断帐号是否存在
	 * 参数：$username 帐号
	 * 返回：数组
	 */	
	public function CheckAdminExist($username)
	{
		$sql = "SELECT F_ID FROM EM_ADMIN_INFO WHERE F_USER_NAME = '$username'";
		$r = $this->select($sql);
		if($r[0][0] > 0)
			return true;
		else 
			return false;
	}
	/**
	 * 功能：提取菜单列表
	 * 参数：$parent_id 父ID
	 * 返回：数组
	 */
	public function GetMenu($parent_id=0)
	{
		$sql = "SELECT * FROM EM_MENU_INFO WHERE F_PARENT_ID = $parent_id";
		return $this->select($sql);
	}
	/**
	 * 功能：检测该用户组是否已拥有此菜单
	 * 参数：$group_id 组ID,$menu_id 菜单ID
	 * 返回：TRUE OR FALSE
	 */
	public function CheckMenuExit($group_id,$menu_id)
	{
		$sql = "SELECT F_ID FROM EE_MENU_GROUP WHERE F_ID_GROUP_INFO = $group_id AND F_ID_MENU_INFO = $menu_id";
		$r = $this->select($sql);
		if($r[0][0])												//判断是否有该记录
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 功能：检测该用户组是否已存在
	 * 参数：$name 组名称
	 * 返回：TRUE OR FALSE
	 */	
	public function CheckGroupExit($name)
	{
		$sql = "SELECT F_ID FROM EM_GROUP_INFO WHERE F_GROUP_NAME = '$name'";
		$r = $this->select($sql);
		if($r[0][0]) 											//判断是否有该记录
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 功能：删除组及相关菜单和用户信息
	 * 参数：$id 组ID
	 * 返回：TRUE OR FALSE
	 */
	public function DelGroup($id)
	{
		$this->begintransaction();									//开始事务处理
		try {
			$sql = "DELETE FROM EM_GROUP_INFO WHERE F_ID = $id";
			$this->delete($sql);									//删除组信息
			$sql = "DELETE FROM EM_ADMIN_INFO WHERE F_ID_GROUP_INFO = $id";
			$this->delete($sql);									//删除用户信息
			$sql = "DELETE FROM EE_MENU_GROUP WHERE F_ID_GROUP_INFO = $id";
			$this->delete($sql);									//删除菜单信息
		}catch (Exception $e){									//捕获异常
			echo $e;											//输出异常
			$this->rollback();									//回滚
			exit();
		}
		$this->commit();										//提交
		return true;
	}
	public function GetAdminList() {
		$sql = "SELECT * FROM EM_ADMIN_INFO";
		return $this->select($sql);
	}
}
?>
