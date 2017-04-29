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
	 * ���ܣ���ҳ��ȡ�û��б�
	 * ��������ǰҳ��
	 * ���أ�����
	 */
	public function GetUserList($page=1)
	{
		$start = ($page - 1) * $this->pagesize;
		$sql = "SELECT * FROM EM_USER_INFO ORDER BY F_ID DESC LIMIT $start,$this->pagesize";
		return $this->select($sql);
	}
	/**
	 * ���ܣ���ȡ�û�����
	 * ���أ��û�����
	 */	
	public function GetUserCount()
	{
		$sql = "SELECT COUNT(F_ID) FROM EM_USER_INFO";
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * ���ܣ���֤��½��Ϣ
	 * ���أ���֤ͨ�������û���Ϣ���飬��ͨ������FALSE
	 */		
	public function CheckLogin($no,$password)
	{
		$password = md5($password);
		$sql = "SELECT * FROM EM_USER_INFO WHERE F_USER_NO = '$no'";
		$sql .= " AND F_USER_PASSWORD = '$password'";
		$r = $this->select($sql);
		if($r[0][F_ID])											//�ж��Ƿ���֤ͨ��
		{
			return $r[0];
		}else{
			return false;
		}
	}
}
?>
