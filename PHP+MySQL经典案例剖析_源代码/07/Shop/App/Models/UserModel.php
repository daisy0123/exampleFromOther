<?php
class UserModel extends Core_Db_Table
{
	protected $_name = "EM_LOGIN_INFO";
	protected $_mail;
	public function __construct()
	{
		$this->_mail = new Zend_Mail('gb2312');
		parent::__construct();
	}
	/**
	 * 功能：提取用户列表
	 * 参数：$type 搜索类型,$keyword 搜索关键字
	 * 返回：数组
	 */
	public function GetUserList($type=0,$keyword='')
	{
		$sql = "SELECT l.F_LOGIN_NAME,l.F_ID,l.F_LOGIN_EMAIL,l.F_LOGIN_IS_ACTIVE,l.F_LOGIN_ACCEPT_EMAIL,l.F_LOGIN_TIME,u.F_USER_TRUENAME,u.F_USER_GENDER FROM EM_LOGIN_INFO l,EE_USER_INFO u";
		$sql .= " WHERE l.F_ID = u.F_ID_LOGIN_INFO";
		$keyword = urldecode($keyword);
		switch ($type)												//判断搜索类型
		{
			case 1:												//1为按用户名搜索
				$sql .= " AND l.F_LOGIN_NAME like '%$keyword%'";
				break;
			case 2:												//2为按EMAIL搜索
				$sql .= " AND l.F_LOGIN_EMAIL like '%$keyword%'";
				break;
			case 3:												//3为按真实姓名搜索
				$sql .= " AND u.F_USER_TRUENAME like '%$keyword%'";
				break;
		}
		$sql .= " ORDER BY l.F_ID DESC";
		$page = new Core_Pager($sql);
		return $page->getData();
	}
	/**
	 * 功能：删除用户
	 * 参数：$arr 用户ID
	 * 返回：TRUE OR FALSE
	 */
	public function DelUser($arr)
	{
		if($arr)													//判断是否选择了用户
		{
			$this->_db->beginTransaction();							//开始事务处理
			try {
				foreach($arr as $id)									//循环删除用户信息
				{
					$sql = "DELETE FROM EM_LOGIN_INFO WHERE F_ID = $id";
					$this->_db->query($sql);
					$sql = "DELETE FROM EE_USER_INFO WHERE F_ID_LOGIN_INFO = $id";
					$this->_db->query($sql);
				}
			}catch (Exception $e){									//捕获异常
				$this->_db->rollBack();								//回滚
				return false;
			}
			$this->_db->commit();
		}
		return true;
	}
	/**
	 * 功能：发送邮件
	 * 参数：$to 收件人邮箱,$title 邮件标题,$content 邮件内容
	 */
	public function SendMail($to,$title,$content)
	{
		$this->_mail->setFrom('admin@xxx.com','XXX');
		$this->_mail->addto($to);
		$this->_mail->setSubject($title);
		$this->_mail->setBodyHtml($content);
		$this->_mail->send();
	}
	/**
	 * 功能：提取用户信息,包括登陆信息和详细信息
	 * 参数：$id 用户ID
	 * 返回：数组
	 */
	public function GetUserInfo($id)
	{
		$sql = "SELECT l.*,u.* FROM EM_LOGIN_INFO l,EE_USER_INFO u WHERE l.F_ID = $id AND l.F_ID = u.F_ID_LOGIN_INFO";
		return $this->_db->fetchRow($sql);
	}
	/**
	 * 功能：更新用户详细信息
	 * 参数：$userid 用户ID,$data 更新信息
	 * 返回：TRUE OR FALSE
	 */
	public function UpdateUserInfo($userid,$data)
	{
		return $this->_db->update("EE_USER_INFO",$data,"F_ID_LOGIN_INFO = $userid");
	}

}
?>
