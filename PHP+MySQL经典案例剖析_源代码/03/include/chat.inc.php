<?php
require_once(INCLUDE_PATH . 'db.inc.php');
class Chat extends DBSQL
{
	private $_limit;										//������������������
	private $_duration;									//�������߹���ʱ��
	/**
	 * ��ʼ�����캯��
	 *
	 */
	public function __construct()
	{
		$this->_limit = 30;								//��������������30��
		$this->_duration = 333600;							//���߹���ʱ��1800��
		parent::__construct();
	}
	/**
	 * ���ܣ���ȡ���߻�Ա�б� 
	 * 
	 */
	public function GetOnlineList()
	{
		$sql = "DELETE FROM EE_ONLINE_INFO WHERE (UNIX_TIMESTAMP(NOW())-F_ONLINE_TIME)>" . $this->_duration;
		$this->delete($sql);								//ɾ���������߻�Ա
		$sql = "SELECT u.F_USER_NAME,u.F_ID,u.F_USER_NICKNAME FROM EM_USER_INFO u,EE_ONLINE_INFO o WHERE u.F_ID = o.F_ID_USER_INFO";							//��ȡ��������
		return $this->select($sql);
	}
	/**
	 * ���ܣ��ж������������Ƿ�����
	 * ���أ�TRUE OR FALSE
	 */
	public function CheckIsFull()
	{
		$sql = "DELETE FROM EE_ONLINE_INFO WHERE (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(F_ONLINE_TIME))>" . $this->_duration;
		$this->delete($sql);								//ɾ���������߻�Ա
		$sql = "SELECT COUNT(F_ID) FROM EE_ONLINE_INFO";
		$r = $this->select($sql);							//��ȡ���߻�Ա����
		if($r[0][0] >= $this->_limit)							//�ж����������Ƿ񳬹�����
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * ���ܣ���֤��½��Ϣ
	 * ������$name �û���,$password ����
	 * ���أ�TRUE OR FALSE
	 */
	public function CheckUser($name,$password)
	{
		$password = md5($password);
		$sql = "SELECT F_ID FROM EM_USER_INFO WHERE F_USER_NAME = '$name' AND F_USER_PASSWORD = '$password'";
		$r = $this->select($sql);
		if($r[0][F_ID] > 0)								//�жϵ�½��Ϣ�Ƿ���ȷ
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
	 * ���ܣ�����û����Ƿ����
	 * ������$name �û���
	 * ���أ�TRUE OR FALSE
	 */
	public function CheckUserExist($name)
	{
		$sql = "SELECT F_ID FROM EM_USER_INFO WHERE F_USER_NAME = '$name'";
		$r = $this->select($sql);
		if($r[0][F_ID] > 0)								//�жϸ����û�����ȡ�ļ�¼ID�Ƿ����0
		{											//����0˵�����û�������
			return true;
		}else{
			return false;
		}
	}
	/**
	 * ���ܣ���ȡ���µĲ����ڸ��û���һ������
	 * ������$user_id �û�ID
	 * ���أ��ַ���
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
		if($d[0][F_ID])									//�ж��Ƿ�����Ϣ
		{
			return "";
		}else{
			return $r[0];
		}
	}
	/**
	 * ���ܣ���ȡ�����¼
	 * ������$page ��ǰҳ��
	 * ���أ�����
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
	 * ���ܣ���ȡ�����¼����
	 *
	 * ���أ���¼����
	 */
	public function GetMsgCount()
	{
		$sql = "SELECT COUNT(*) FROM EE_MESSAGE_INFO";
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * ���ܣ������û��Ƿ���
	 * ������$user_id �û�ID
	 * ���أ���¼ID OR FALSE
	 */
	public function CheckIsKicked($user_id)
	{
		$sql = "SELECT F_ID FROM EE_KICK_USER WHERE F_KICK_USER_ID = $user_id";
		$r = $this->select($sql);
		if($r[0][F_ID] > 0)								//�ж��Ƿ��м�¼�����򷵻ظü�¼ID
		{
			$sql = "DELETE FROM EE_KICK_USER WHERE F_ID = {$r[0][F_ID]}";
			$this->delete($sql);							//ɾ���ü�¼
			$sql = "DELETE FROM EE_ONLINE_INFO WHERE F_ID_USER_INFO = $user_id";
			$this->delete($sql);							//ɾ�����û������߼�¼
			return $r[0][F_ID];
		}else{
			return false;
		}
	}
	/**
	 * ���ܣ������û��Ƿ��ǹ���Ա
	 * ������$user_id �û�ID
	 * ���أ�TRUE OR FALSE
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
