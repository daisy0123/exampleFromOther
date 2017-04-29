<?php
class User extends DBSQL
{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * ���ܣ�����û����Ƿ����
	 * ������$name �û���
	 * ���أ�TRUE OR FALSE
	 */
	public function CheckUserNameExist($name)
	{
		$sql = "SELECT F_ID FROM EM_USER_INFO WHERE F_USER_NAME = '$name'";
		$r = $this->select($sql);
		if($r[0][0])												//����û����Ƿ��ظ�
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * ���ܣ��û�ע��
	 * ������$array ע���ύ��Ϣ
	 */
	public function Register($array)
	{
		$this->begintransaction();									//��ʼ������
		try{
			$data = array();
			$data['F_USER_NAME'] = $array['username'];
			$data['F_USER_PASSWORD'] = md5($array['password']);
			$data['F_USER_NICKNAME'] = $array['NickName'];
			$data['F_USER_EMAIL'] = $array['Email'];
			$data['F_USER_REGTIME'] = time();
			$userid = $this->insertData("EM_USER_INFO",$data);		//�������ݵ���5.1
			$data = array();
			$data['F_BLOG_NAME'] = $array['Blog'];
			$data['F_BLOG_DEFAULT_SKINS'] = 'default';
			$data['F_BLOG_REGTIME'] = time();
			$blogid = $this->insertData("EM_BLOG_INFO",$data);		//�������ݵ���5.2
			$data = array();
			$data['F_ID_BLOG_INFO'] = $blogid;
			$data['F_ID_USER_INFO'] = $userid;
			$data['F_BLOG_IS_LOCKED'] = 0;
			$data['F_BLOG_PERM_COMMENTS'] = 1;
			$this->insertData("EE_BLOG_USER",$data);				//�������ݵ���5.3
			$data = array();
			$data['F_ID_BLOG_INFO'] = $blogid;
			$data['F_CATEGORIES_NAME'] = 'Ĭ�Ϸ���';
			$data['F_CATEGORIES_DESCRIPTION'] = 'Ĭ�Ϸ���';
			$data['F_CATEGORIES_POSTS'] = 0;
			$data['F_CATEGORIES_DEFAULT'] = 1;
			$this->insertData("EE_BLOG_CATEGORIES",$data);			//�������ݵ���5.4
		}catch (Exception $e)
		{
			$this->rollback();									//�����쳣��ع�������false
			return false;
		}
		$this->commit();										//δ�����쳣���ύ������true
		return $blogid;
	}
	/**
	 * ���ܣ��û���½
	 * ������$name �û���,$password �û�����
	 * ���أ�TRUE OR FALSE
	 */
	public function Login($name,$password)
	{
		$password = md5($password);
		$name = strtoupper($name);
		$sql = "SELECT F_ID,F_USER_NAME,F_USER_NICKNAME FROM EM_USER_INFO ";
		$sql .= "WHERE UPPER(F_USER_NAME) = '$name' AND F_USER_PASSWORD = '$password'";			
		$r = $this->select($sql);
		if($r[0][F_ID])											//�жϵ�½��Ϣ�Ƿ���ȷ
		{
			$_SESSION['User']['F_ID'] = $r[0][F_ID];					//��ID���뵽SESSION����
			if(!isset($r[0]['F_USER_NICKNAME']))			//�ж��ǳ��Ƿ���ڣ����������SESSION
				$_SESSION['User']['User_Name'] = $r[0]['F_USER_NAME'];
			else										//�����ڣ�����û�������SESSION
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
