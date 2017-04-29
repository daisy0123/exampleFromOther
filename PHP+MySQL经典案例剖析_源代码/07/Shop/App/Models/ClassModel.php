<?php
class ClassModel extends Core_Db_Table
{
	protected $_name = "EM_CLASS_INFO";
	/**
	 * ���ܣ���ȡָ����ID����б�
	 * ������$parentid ���ID
	 * ���أ�����
	 */
	public function GetClassList($parent_id)
	{
		$sql = "SELECT * FROM EM_CLASS_INFO WHERE F_PARENT_ID = $parent_id ORDER BY F_CLASS_ORDER DESC,F_ID DESC";
		return $this->_db->fetchAll($sql);
	}
	/**
	 * ���ܣ���ȡ�����
	 */
	public function GetClassListAll(){
		$deep = 0;
		$this->_GetClassList(0);	
	}
	/**
	 * ���ܣ���ȡĳ��������
	 * ������$parent_id ���ID
	 */
	public function _GetClassList($parent_id){
		GLOBAL $deep,$classlist;
		$deep++;
		$c_list = $this->GetClassList($parent_id);
		$cur_class_num = count($classlist);
		if ($cur_class_num > 0)									//�ж��Ƿ������
			$classlist[count($classlist) - 1][sub_num] = count($c_list);
		foreach($c_list as $class){									//ѭ��������������
			$c_id = $class[F_ID];
			$c_name = $class[F_CLASS_NAME];
			for ($i = 0,$prev = "";$i < $deep - 1;$i++)	$prev .= "��";
			$classlist[] = array("id" => $c_id,"parent_id" => $class[F_PANRET_ID],"class_name" => $c_name, "tree" => $prev . $c_name,"prev" => $prev);
			$this->_GetClassList($c_id);							//�ݹ��������
		}
		$deep--;
	}
	/**
	 * ���ܣ���ȡ��Ӧ���Ƶ�������Ϣ
	 * ������$name ��������
	 * ���أ�����
	 */
	public function GetDefaultConfig($name)
	{
		$sql = "SELECT F_CONFIG_VALUE FROM EM_CONFIG_INFO WHERE F_CONFIG_NAME = '$name'";
		$r = $this->_db->fetchRow($sql);
		return $r[F_CONFIG_VALUE];
	}
	/**
	 * ���ܣ���ȡ����Ʒ����
	 * ������$id ���ID
	 * ���أ�����
	 */
	public function GetPropertyList($id)
	{
		$sql = "SELECT * FROM EE_PROPERTY_INFO WHERE F_ID_CLASS_INFO = $id ORDER BY F_PROPERTY_ORDER";
		return $this->_db->fetchAll($sql);
	}
	/**
	 * ���ܣ���ȡ����Ʒ��
	 * ������$id ���ID
	 * ���أ�����Ʒ��
	 */
	public function GetProductCount($id)
	{
		$sql = "SELECT COUNT(F_ID) FROM EE_PRODUCT_INFO WHERE F_ID_CLASS_INFO = $id";
		$r = $this->_db->fetchRow($sql);
		return $r[0];
	}
	/**
	 * ���ܣ��ж�ͬһ�����Ƿ������ͬ�������
	 * ������$name ����,$parent_id �����ID,$id ���ID 
	 * ���أ�TRUE OR FALSE
	 */
	public function CheckClassNameExit($name,$parent_id=0,$id=0)
	{
		$sql = "SELECT F_ID FROM EM_CLASS_INFO WHERE F_CLASS_NAME = '$name'";
		$sql .= " AND F_PARENT_ID = $parent_id";
		if($class_id)
			$sql .= " AND F_ID <> $id";
		$r = $this->_db->fetchRow($sql);
		if($r[0])												//�жϼ�¼�Ƿ����
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * ���ܣ��������˳��
	 * ������$class_arr ���ID����,$order ˳������
	 * ���أ�TRUE OR FALSE
	 */
	public function SetClassOrder($class_arr,$order)
	{
		$this->_db->beginTransaction();							//��ʼ������
		try{
			foreach($class_arr as $key => $value)					//ѭ������˳��
			{
				$sql = "UPDATE EM_CLASS_INFO SET F_CLASS_ORDER = {$order[$key]} WHERE F_ID = $value";
				$this->_db->query($sql);
			}
		}catch (Exception $e){									//�����쳣
			$this->_db->rollBack();								//�ع�����FALSE
			return false;
		}
		$this->_db->commit();									//�ύ����TRUE
		return true;
	}
	/**
	 * ���ܣ�ɾ�������ز�Ʒ��������Ϣ
	 * ������$id ���ID
	 * ���أ�TRUE OR FALSE
	 */
	public function Delete($id)
	{
		$this->_db->beginTransaction();							//��ʼ������
		try {
			$sql = "DELETE FROM EM_CLASS_INFO WHERE F_ID = $id";
			$this->_db->query($sql);								//ɾ�������Ϣ
			$sql = "DELETE FROM EE_PRODUCT_INFO WHERE F_ID_CLASS_INFO = $id";
			$this->_db->query($sql);								//ɾ����ز�Ʒ��Ϣ
			$sql = "DELETE FROM EE_PROPERTY_INFO WHERE F_ID_CLASS_INFO = $id";
			$this->_db->query($sql);								//ɾ�����������Ϣ
		}catch (Exception $e){									//�����쳣
			$this->_db->rollBack();								//�ع�
			return false;
		}
		$this->_db->commit();
		return true;
	}
	/**
	 * ���ܣ��������²�Ʒ����
	 * ������$arr �ύ����,$classid ���ID,$id ���༭����ID
	 * ���أ�TRUE OR FALSE
	 */
	public function UpdateProperty($arr,$classid,$id=0)
	{
		$sql = "SELECT F_ID FROM EE_PROPERTY_INFO WHERE F_PROPERTY_NAME = '{$arr[name]}' AND F_ID_CLASS_INFO = $classid";
		if($id)											//�ж��Ƿ��Ǳ༭״̬
		{
			$sql .= " AND F_ID <> $id";
		}
		$r = $this->_db->fetchRow($sql);
		if($r['F_ID'])										//�ж����������Ƿ����
			return false;
		if($id)											//�ж��Ƿ��Ǳ༭״̬
		{
			$data['F_PROPERTY_NAME'] = $arr['name'];
			$this->_db->update('EE_PROPERTY_INFO',$data,'F_ID = ' . $id);
			return true;
		}else{
			$filename = $this->GetNextPropertyField($classid);
			$data['F_ID_CLASS_INFO'] = $classid;
			$data['F_PROPERTY_NAME'] = $arr['name'];
			$data['F_PROPERTY_FIELDNAME'] = $filename;
			$this->_db->insert("EE_PROPERTY_INFO",$data);
			return true;
		}
	}
	/**
	 * ���ܣ���ȡ������Ϣ
	 * ������$id ����ID
	 * ���أ�����
	 */
	public function GetPropertyInfo($id) {
		$sql = "SELECT * FROM EE_PROPERTY_INFO WHERE F_ID = " . $id;
		return $this->_db->fetchRow($sql);
	}
	/**
	 * ���ܣ�ȡ����һ�����Ե��ֶ�����
	 * ������$classid ���ID
	 * ���أ��ֶ�����
	 */
	private function GetNextPropertyField($classid){
		$last = 0;
		$sql = "SELECT * FROM EE_PROPERTY_INFO WHERE F_ID_CLASS_INFO = $classid ORDER BY F_PROPERTY_FIELDNAME";
		$list = $this->_db->fetchAll($sql);
		foreach($list as $property){							//ѭ��ȡ�����һ�������ֶ�
			$index = substr($property[F_PROPERTY_FIELDNAME],-2);
			if ($index - $last > 1)
				break;
			$last = $index;
		}
		$next = $last + 1;
		return "F_PRODUCT_PROPERTY" . str_pad($next,2,"0",STR_PAD_LEFT);
	}
	/**
	 * ���ܣ�ȡ�ò�Ʒ���Ը���
	 * ������$classid ���ID
	 * ���أ����Ը���
	 */
	public function GetPropertyCount($classid){
		$sql = "SELECT COUNT(F_ID) FROM EE_PROPERTY_INFO WHERE F_ID_CLASS_INFO = $classid";
		$r = $this->_db->fetchRow($sql);
		return $r[0];
	}
	/**
	 * ���ܣ�ɾ����Ʒ����
	 * ������$id ����ID
	 * ���أ�TRUE OR FALSE
	 */
	public function DelProperty($id)
	{
		$sql = "DELETE FROM EE_PROPERTY_INFO WHERE F_ID = $id";
		return $this->_db->query($sql);
	}
	/**
	 * ���ܣ���������˳��
	 * ������$arr ����ID����,$order ˳������
	 * ���أ�TRUE OR FALSE
	 */
	public function SetPropertyOrder($arr,$order)
	{
		$this->_db->beginTransaction();						//��ʼ������
		try{
			foreach($arr as $key => $id)						//ѭ������˳��
			{
				$sql = "UPDATE EE_PROPERTY_INFO SET F_PROPERTY_ORDER = {$order[$key]} WHERE F_ID = $id";
				$this->_db->query($sql);
			}
		} catch (Exception $e){								//��׽�쳣
			$this->_db->rollBack();							//�ع�
			return false;
		}
		$this->_db->commit();
		return true;
	}

}
?>
