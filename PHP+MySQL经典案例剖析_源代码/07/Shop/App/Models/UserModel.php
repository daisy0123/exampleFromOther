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
	 * ���ܣ���ȡ�û��б�
	 * ������$type ��������,$keyword �����ؼ���
	 * ���أ�����
	 */
	public function GetUserList($type=0,$keyword='')
	{
		$sql = "SELECT l.F_LOGIN_NAME,l.F_ID,l.F_LOGIN_EMAIL,l.F_LOGIN_IS_ACTIVE,l.F_LOGIN_ACCEPT_EMAIL,l.F_LOGIN_TIME,u.F_USER_TRUENAME,u.F_USER_GENDER FROM EM_LOGIN_INFO l,EE_USER_INFO u";
		$sql .= " WHERE l.F_ID = u.F_ID_LOGIN_INFO";
		$keyword = urldecode($keyword);
		switch ($type)												//�ж���������
		{
			case 1:												//1Ϊ���û�������
				$sql .= " AND l.F_LOGIN_NAME like '%$keyword%'";
				break;
			case 2:												//2Ϊ��EMAIL����
				$sql .= " AND l.F_LOGIN_EMAIL like '%$keyword%'";
				break;
			case 3:												//3Ϊ����ʵ��������
				$sql .= " AND u.F_USER_TRUENAME like '%$keyword%'";
				break;
		}
		$sql .= " ORDER BY l.F_ID DESC";
		$page = new Core_Pager($sql);
		return $page->getData();
	}
	/**
	 * ���ܣ�ɾ���û�
	 * ������$arr �û�ID
	 * ���أ�TRUE OR FALSE
	 */
	public function DelUser($arr)
	{
		if($arr)													//�ж��Ƿ�ѡ�����û�
		{
			$this->_db->beginTransaction();							//��ʼ������
			try {
				foreach($arr as $id)									//ѭ��ɾ���û���Ϣ
				{
					$sql = "DELETE FROM EM_LOGIN_INFO WHERE F_ID = $id";
					$this->_db->query($sql);
					$sql = "DELETE FROM EE_USER_INFO WHERE F_ID_LOGIN_INFO = $id";
					$this->_db->query($sql);
				}
			}catch (Exception $e){									//�����쳣
				$this->_db->rollBack();								//�ع�
				return false;
			}
			$this->_db->commit();
		}
		return true;
	}
	/**
	 * ���ܣ������ʼ�
	 * ������$to �ռ�������,$title �ʼ�����,$content �ʼ�����
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
	 * ���ܣ���ȡ�û���Ϣ,������½��Ϣ����ϸ��Ϣ
	 * ������$id �û�ID
	 * ���أ�����
	 */
	public function GetUserInfo($id)
	{
		$sql = "SELECT l.*,u.* FROM EM_LOGIN_INFO l,EE_USER_INFO u WHERE l.F_ID = $id AND l.F_ID = u.F_ID_LOGIN_INFO";
		return $this->_db->fetchRow($sql);
	}
	/**
	 * ���ܣ������û���ϸ��Ϣ
	 * ������$userid �û�ID,$data ������Ϣ
	 * ���أ�TRUE OR FALSE
	 */
	public function UpdateUserInfo($userid,$data)
	{
		return $this->_db->update("EE_USER_INFO",$data,"F_ID_LOGIN_INFO = $userid");
	}

}
?>
