<?php
require_once(INCLUDE_PATH . 'db.inc.php');
class Data extends DBSQL
{
	public $pagesize;
	public function __construct()
	{
		$this->pagesize = 20;
		parent::__construct();
	}
	/**
	 * ���ܣ���ҳ��ȡ����б�
	 * ������$id ��ĿID,$page ҳ��
	 * ���أ�����
	 */
	public function GetDataList($id=0,$page=1)
	{
		$start = ($page - 1) * $this->pagesize;
		$sql = "SELECT d.*,c.F_CLASS_NAME FROM EM_CLASS_INFO c,EE_DATABASE_INFO d";
		$sql .= " WHERE c.F_ID = d.F_ID_CLASS_INFO ";
		if($id)
			$sql .= " AND c.F_ID = $id";
		$sql .= " ORDER BY d.F_ID DESC";
		$sql .= " LIMIT $start,$this->pagesize";
		return $this->select($sql);
	}
	/**
	 * ���ܣ���ȡ�������
	 * ������$id ��ĿID
	 * ���أ��������
	 */
	public function GetDataCount($id=0)
	{
		$sql = "SELECT COUNT(F_ID) FROM EE_DATABASE_INFO";
		if($id)
			$sql .= " WHERE F_ID_CLASS_INFO = $id";
		$r = $this->select($sql);
		return $r[0][0];		
	}
	/**
	 * ���ܣ�ɾ����⼰���������Ϣ
	 * ������$id ���ID
	 * ���أ�TRUE OR FALSE
	 */
	public function DelDataBase($id)
	{
		$this->begintransaction();									//��ʼ������
		try {
			$sql = "DELETE FROM EE_OBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
			$this->delete($sql);									//ɾ���͹���
			$sql = "DELETE FROM EE_OBJECTIVE_INFO o,EE_OBJECTIVE_ITEM i ";
			$sql .= "WHERE o.F_ID_DATABASE_INFO = $id,o.F_ID = i.F_ID_OBJECTIVE_INFO";
			$this->delete($sql);									//ɾ���͹���ѡ��
			$sql = "DELETE FROM EE_SUBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
			$this->delete($sql);									//ɾ��������
			$sql = "DELETE FROM EE_DATABASE_INFO WHERE F_ID = $id";
			$this->delete($sql);									//ɾ�������Ϣ
		}catch (Exception $e){									//�����쳣���ع�
			$this->rollback();
			return false;
		}
		return true;
	}
	/**
	 * ���ܣ���ȡ�͹�������
	 * ������$id ���ID
	 * ���أ��͹�������
	 */
	public function GetObjCount($id)
	{
		$sql = "SELECT COUNT(F_ID) FROM EE_OBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * ���ܣ���ȡ����������
	 * ������$id ���ID
	 * ���أ�����������
	 */
	public function GetSubCount($id)
	{
		$sql = "SELECT COUNT(F_ID) FROM EE_SUBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * ���ܣ���ҳ��ȡ�͹����б�
	 * ������$id ���ID,$page ҳ��
	 * ���أ�����
	 */
	public function GetObjList($id,$page=1)
	{
		$start = ($page - 1) * $this->pagesize;
		$sql = "SELECT * FROM EE_OBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
		$sql .= " ORDER BY F_OBJECTIVE_ORDER DESC LIMIT $start,$this->pagesize";
		return $this->select($sql);
	}
	/**
	 * ���ܣ���ҳ��ȡ�͹����б�
	 * ������$id ���ID,$page ҳ��
	 * ���أ�����
	 */
	public function GetSubList($id,$page=1)
	{
		$start = ($page - 1) * $this->pagesize;
		$sql = "SELECT * FROM EE_SUBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
		$sql .= " ORDER BY F_SUBJECTIVE_ORDER DESC LIMIT $start,$this->pagesize";
		return $this->select($sql);
	}
	/**
	 * ���ܣ�ɾ���͹���
	 * ������$id ����ID
	 * ���أ�TRUE OR FALSE
	 */
	public function DelObj($id)
	{
		$this->begintransaction();									//��ʼ������
		try {
			$sql = "DELETE FROM EE_OBJECTIVE_ITEM WHERE F_ID_OBJECTIVE_INFO = $id";
			$this->delete($sql);									//ɾ������ѡ��
			$sql = "DELETE FROM EE_OBJECTIVE_INFO WHERE F_ID = $id";
			$this->delete($sql);									//ɾ������
		} catch (Exception $e){									//�����쳣���ع�
			$this->rollback();
			return false;
		}
		return true;
	}
	/**
	 * ���ܣ���ȡѡ���б�
	 * ������$id �͹���ID
	 * ���أ�����
	 */
	public function GetItemList($id)
	{
		$sql = "SELECT * FROM EE_OBJECTIVE_ITEM WHERE F_ID_OBJECTIVE_INFO = $id";
		$sql .= " ORDER BY F_ITEM_ORDER DESC";
		return $this->select($sql);
	}
	/**
	 * ���ܣ��ı�ѡ���Ƿ�����ȷ��״̬
	 * ������$id �͹���ID
	 * ���أ�TRUE OR FALSE
	 */	
	public function UpdateRightItem($id)
	{
		$sql = "UPDATE EE_OBJECTIVE_ITEM SET F_ITEM_IS_RIGHT = 0 WHERE F_ID_OBJECTIVE_INFO = $id";
		return $this->update($sql);
	}
	/**
	 * ���ܣ�����û���ѡ���Ƿ���ȷ
	 * ������$objid �͹���ID,$item ��ID
	 * ���أ�0 Ϊδѡ�����,1Ϊ����ȷ,2Ϊ�𰸴���
	 */	
	public function CheckIsRight($objid,$item)
	{
		if(!$item)												//�ж��Ƿ�ѡ���˸���
		{
			return 0;
		}
		$r = $this->getInfo($objid,"EE_OBJECTIVE_INFO");
		if($r[F_OBJECTIVE_TYPE] == 1)							//�жϸ����Ƿ��ǵ�ѡ
		{
			$sql = "SELECT F_ITEM_IS_RIGHT FROM EE_OBJECTIVE_ITEM WHERE F_ID = $item";
			$i = $this->select($sql);
			if($i[0][0] == 1)										//�жϴ��Ƿ���ȷ
				return 1;
			else
				return 2;
		}else{
			$sql = "SELECT F_ID FROM EE_OBJECTIVE_ITEM WHERE F_ID_OBJECTIVE_INFO = $objid";
			$sql .= " AND F_ITEM_IS_RIGHT = 1";
			$i = $this->select($sql);
			$arr = array();
			foreach($i as $value)								//���������ȷ������
			{
				$arr[] = $value[F_ID];
			}
			if(count($arr) == count($item))							//�ж�ѡ���Ƿ�ʹ𰸸�����ͬ
			{
				foreach($item as $value)							//ѭ���ж�ѡ���Ƿ���ȷ
				{
					if(!in_array($value,$arr))						//�ж�ѡ���Ƿ���ȷ
					{
						return 2;
					}
				}
				return 1;
			}else{
				return 2;
			}
		}
	}
	/**
	 * ���ܣ���ȡ���п͹���Ŀ��Ϣ
	 * ������$id���ID
	 * ���أ�����
	 */		
	public function GetObjListAll($id)
	{
		$sql = "SELECT * FROM EE_OBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
		$sql .= " ORDER BY F_OBJECTIVE_ORDER DESC";
		return $this->select($sql);
	}
	/**
	 * ���ܣ���ȡ����������Ŀ��Ϣ
	 * ������$id���ID
	 * ���أ�����
	 */		
	public function GetSubListAll($id)
	{
		$sql = "SELECT * FROM EE_SUBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
		$sql .= " ORDER BY F_SUBJECTIVE_ORDER DESC";
		return $this->select($sql);
	}
	/**
	 * ���ܣ���ȡ��Ŀ����ȷ��
	 * ������$id��ĿID
	 * ���أ���ȷ��
	 */
	public function GetRight($id) {
		$sql = "SELECT F_ID FROM EE_OBJECTIVE_ITEM WHERE F_ID = $id";
		$r = $this->select($sql);
		return $r[0][0];	
	}
}
?>
