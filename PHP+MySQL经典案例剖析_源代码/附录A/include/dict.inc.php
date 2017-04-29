<?php
require_once(INCLUDE_PATH . 'db.inc.php');
Class Dict extends DBSQL									//������Dict�̳�DBSQL��
{
	private $_name = 'ZD_LANGUAGE_DICT'; 					//���������
	public $_pagesize = 10;                                       //����ÿҳ��ȡ��¼����
	public function __construct()								//��ʼ�����캯��
	{
		parent::__construct();
	}
	/**
	 * ���ܣ���ȡ�����б�
	 * ������$page ��ǰҳ��
	 * ���أ�����	
	 */
	public function getList($page=1)
	{
		$start = ($page - 1) * $this->_pagesize;
		$sql = "SELECT * FROM " . $this->_name . " ORDER BY F_ID DESC";
		$sql .= " LIMIT " . $start . "," . $this->_pagesize . "";
		return $this->select($sql);
	}
	/**
	 * ���ܣ���ȡ��ļ�¼����
	 * ���أ���¼����
	 */
	public function getCount()
	{
		$sql = "SELECT COUNT(F_ID) FROM " . $this->_name;
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * ���ܣ���������
	 * ������$data ����(��ʽ��$data['�ֶ���'] = ֵ)
	 * ���أ������¼��ID
	 */
	public function insertData($data)
	{
		$field = implode(',',array_keys($data));			//����sql�����ֶβ���
		$i = 0;
		foreach($data as $key => $val)						//���sql����ֵ����
		{
			$value .= "'" . $val . "'";
			if($i < count($data) - 1)						//�ж��Ƿ���������һ��ֵ
				$value .= ",";
			$i++;
		}
		$sql = "INSERT INTO " . $this->_name . "(" . $field . ") VALUES(" . $value . ")";
		return $this->insert($sql);
	}
	/**
	 * ���ܣ���������
	 * ������$data ����(��ʽ��$data[���ֶ�����] = ֵ),$where �ַ���
	 * ���أ�TRUE OR FALSE
	 */
	public function updateData($data,$where='')
	{
		$col = array();
		foreach ($data as $key => $value)
		{
			$col[] = $key . "='" . $value ."'";
		}
		$sql = "UPDATE " . $this->_name . " SET " . implode(',',$col) . " WHERE " . $where . "";
		return $this->update($sql);
	}
	/**
	 * ���ܣ�ɾ����¼
	 * ������$id ��ID
	 * ���أ�TRUE OR FALSE
	 */
	public function delData($id)
	{
		$this->begintransaction();
		try{
			$sql = "DELETE FROM ZM_LANGUAGE_TRANS WHERE F_ID_DICT = " . $id;
			$this->delete($sql);									//��ɾ�������������������
			$sql = "DELETE FROM " . $this->_name . " WHERE F_ID = " . $id;
			$this->delete($sql);
		}catch(Exception $e){
			$this->rollback();
		}
		$this->commit();
		return true;
	}
	/**
	 * ���ܣ���ȡָ��ID����Ϣ
	 * ������$id ��¼ID
	 * ���أ�����
	 */
	public function getInfo($id)
	{
		$sql = "SELECT * FROM " . $this->_name . " WHERE F_ID = " . $id;
		$r = $this->select($sql);
		return $r[0];
	}
}
?>
