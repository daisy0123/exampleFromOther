<?php
require_once(INCLUDE_PATH . 'db.inc.php');
Class Lang extends DBSQL									//������Lang�̳�DBSQL��
{
	private $_name = 'ZD_LANGUAGE';		 					//���������
	private $_trans_name = 'ZD_LANGUAGE_TRANS';				//���巭�������
	public $_pagesize = 10;                                 		//����ÿҳ��ȡ��¼����
	public function __construct()								//��ʼ�����캯��
	{
		parent::__construct();
	}
	/**
	 * ���ܣ���ȡ�����б�
	 * ������$page ��ǰҳ��
	 * ���أ�����
	 */
	public function getList()
	{
		$sql = "SELECT * FROM " . $this->_name;
		return $this->select($sql);
	}
	/**
	 * ���ܣ���������
	 * ������$data ����(��ʽ��$data[���ֶ�����] = ֵ)
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
			$col[] = $key . "= '" . $value ."'";
		}
		$sql = "UPDATE " . $this->_name . " SET " . implode(',',$col) . " WHERE " . $where . "";
		return $this->update($sql);
	}
	/**
	 * ���ܣ��������±�1.3����
	 * ������$arr_dict �����ֵ�ID����,$lang_id ����ID,$arr_value����ֵ����
	 * ���أ�TRUE
	 */
	public function updateTransData($arr_dict,$lang_id,$arr_value)
	{
		$this->begintransaction();
		try {
			foreach($arr_dict as $key => $id)
			{
				$sql = "SELECT F_ID FROM " . $this->_trans_name	;
				$sql .= " WHERE F_ID_DICT = $id AND F_ID_LANG = $lang_id";
				$r = $this->select($sql);
				if($r[0][F_ID])
				{
					if($arr_value[$key])						//�ж��ύ���ı����Ƿ���ֵ
					{
						$sql = "UPDATE " . $this->_trans_name . " SET F_TEXT = '" . $arr_value[$key] . "'";
						$sql .= " WHERE F_ID = " . $r[F_ID];
						$this->update($sql);
					}else{
						continue;
					}
				}else{
					if($arr_value[$key])
					{
						$sql = "INSERT INTO " . $this->_trans_name . "(F_ID_DICT,F_ID_LANG,F_TEXT)";
						$sql .= " VALUES($id,$lang_id,'{$arr_value[$key]}')";
						$this->insert($sql);
					}else{
						continue;
					}
				}
			}
		}catch (Exception $e)
		{
			$this->rollback();
			$msg = $e;
			include(ERRFILE);
		}
		$this->commit();
		return true;
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
			$sql = "DELETE FROM ZM_LANGUAGE_TRANS WHERE F_ID_LANG = " . $id;
			$this->delete($sql);									//��ɾ�������������������
			$sql = "DELETE FROM " . $this->_name . " WHERE F_ID = " . $id;
			$this->delete($sql);
		}catch(Exception $e){
			$this->rollback();
			$msg = $e;
			include(ERRFILE);
			return false;
		}
		$this->commit();
		return true;
	}
	/**
	 * ���ܣ�ȡָ��ID�����Լ�¼
	 * ������$id ��¼ID
	 * ���أ�����
	 */
	public function getInfo($id)
	{
		$sql = "SELECT * FROM " . $this->_name . " WHERE F_ID = " . $id;
		$r = $this->select($sql);
		return $r[0];
	}
	/**
	 * ���ܣ�ȡָ���ֵ�����ID������ID�ķ������ݼ�¼
	 * ������$dict_id�ֵ�����ID,$lang_id����ID
	 * ���أ�����
	 */
	public function getTransInfo($dict_id,$lang_id)
	{
		$sql = "SELECT * FROM " . $this->_trans_name;
		$sql .= " WHERE F_ID_DICT = $dict_id AND F_ID_LANG = $lang_id";
		$r = $this->select($sql);
		return $r[0];
	}
	/**
	 * ���ܣ�ȡָ������ID�ķ�������
	 * ������$lang_id����ID
	 * ���أ�����
	 */
	public function getTransList($lang_id)
	{
		$sql = "SELECT D.F_CODE,T.F_TEXT FROM ZD_LANGUAGE_DICT D,ZD_LANGUAGE_TRANS T WHERE D.F_ID = T.F_ID_DICT AND T.F_ID_LANG = $lang_id";
		return $this->select($sql);
	}
}
?>
