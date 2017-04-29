<?php
class ProductModel extends Core_Db_Table
{
	protected $_name = "EE_PRODUCT_INFO";
	/**
	 * ���ܣ���ҳ��ȡ��Ʒ�б�
	 * ������$classid ���ID
	 * ���أ�����
	 */
	public function GetProductList($classid)
	{
		$sql = "SELECT F_ID,F_PRODUCT_NAME,F_PRODUCT_ORDER,F_PRODUCT_SMALL_IMG,F_PRODUCT_BIG_IMG FROM EE_PRODUCT_INFO WHERE F_ID_CLASS_INFO = $classid ORDER BY F_PRODUCT_ORDER,F_ID DESC";
		return $this->listPage($sql);
	}
	/**
	 * ���ܣ�ɾ����Ʒ
	 * ������$arr ��ƷID����
	 * ���أ�TRUE OR FALSE
	 */
	public function DelProduct($arr)
	{
		if($arr)													//�ж��Ƿ�ѡ����ɾ����Ʒ
		{
			$this->_db->beginTransaction();							//��ʼ������
			try{
				foreach($arr as $id)									//ѭ��ɾ����Ʒ�������Ϣ
				{
					$sql = "DELETE FROM EE_PRODUCT_INFO WHERE F_ID = $id";
					$this->_db->query($sql);
					$sql = "DELETE FROM EE_PRODUCT_NEW WHERE F_ID_PRODUCT_INFO = $id";
					$this->_db->query($sql);
					$sql = "DELETE FROM EE_PRODUCT_RECOMMEND WHERE F_ID_PRODUCT_INFO = $id";
					$this->_db->query($sql);
				}
			} catch (Exception $e){									//�����쳣
				$this->_db->rollBack();								//�ع�
				return false;
			}
			$this->_db->commit();
		}
		return true;
	}
	/**
	 * ���ܣ���ҳ��ȡ�²�Ʒ�б�
	 * ���أ�����
	 */
	public function GetNewList()
	{
		$sql = "SELECT c.F_CLASS_NAME,p.F_PRODUCT_NAME,n.F_ID,n.F_NEW_ORDER FROM EM_CLASS_INFO c,EE_PRODUCT_INFO p,EE_PRODUCT_NEW n";
		$sql .= " WHERE n.F_ID_PRODUCT_INFO = p.F_ID AND p.F_ID_CLASS_INFO = c.F_ID ORDER BY n.F_NEW_ORDER";
		$page = new Core_Pager($sql);
		return $page->getData();
	}
	/**
	 * ���ܣ�ɾ���²�Ʒ
	 * ������$arr �²�ƷID����
	 * ���أ�TRUE
	 */
	public function DelNew($arr)
	{
		if($arr)													//�ж��Ƿ�ѡ�����²�Ʒ
		{
			foreach($arr as $id)										//ѭ��ɾ���²�Ʒ
			{
				$sql = "DELETE FROM EE_PRODUCT_NEW WHERE F_ID = $id";
				$this->_db->query($sql);
			}
		}
		return true;
	}
	/**
	 * ���ܣ�����²�Ʒ
	 * ������$product_id ��ƷID
	 * ���أ�TRUE OR FALSE
	 */
	public function AddNew($product_id)
	{
		$data = array();
		$data[F_ID_PRODUCT_INFO] = $product_id;
		$data[F_NEW_ORDER] = 0;
		if($this->_db->insert("EE_PRODUCT_NEW",$data))						//�ж��Ƿ�����ɹ�
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * ���ܣ���ȡ����������в�Ʒ
	 * ������$classid ���ID
	 * ���أ�����
	 */
	public function GetProductListAll($classid)
	{
		$sql = "SELECT F_ID,F_PRODUCT_NAME FROM EE_PRODUCT_INFO WHERE F_ID_CLASS_INFO = $classid";
		return $this->_db->fetchPairs($sql);
	}
	/**
	 * ���ܣ������²�Ʒ��ʾ˳��
	 * ������$arr �²�ƷID,$order ˳��ֵ
	 * ���أ�TRUE
	 */
	public function SetNewOrder($arr,$order)
	{
		foreach ($arr as $key => $id)									//ѭ�������²�Ʒ˳��
		{
			$sql = "UPDATE EE_PRODUCT_NEW SET F_NEW_ORDER = {$order[$key]} WHERE F_ID = $id";
			$this->_db->query($sql);
		}
		return true;
	}
	/**
	 * ���ܣ���ҳ��ȡ�Ƽ���Ʒ�б�
	 * ���أ�����
	 */
	public function GetRecommendList()
	{
		$sql = "SELECT c.F_CLASS_NAME,p.F_PRODUCT_NAME,n.F_ID,n.F_RECOMMEND_ORDER FROM EM_CLASS_INFO c,EE_PRODUCT_INFO p, EE_PRODUCT_RECOMMEND n";
		$sql .= " WHERE n.F_ID_PRODUCT_INFO = p.F_ID AND p.F_ID_CLASS_INFO = c.F_ID ORDER BY n.F_RECOMMEND_ORDER";
		$page = new Core_Pager($sql);
		return $page->getData();
	}
	/**
	 * ���ܣ�����Ƽ���Ʒ
	 * ������$product_id ��ƷID
	 * ���أ�TRUE OR FALSE
	 */
	public function AddRecommend($product_id)
	{
		$data = array();
		$data[F_ID_PRODUCT_INFO] = $product_id;
		$data[F_RECOMMEND_ORDER] = 0;
		if($this->_db->insert("EE_PRODUCT_RECOMMEND",$data))				//�ж��Ƿ�����ɹ�
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * ���ܣ������Ƽ���Ʒ��ʾ˳��
	 * ������$arr �Ƽ���ƷID,$order ˳��ֵ
	 * ���أ�TRUE
	 */
	public function SetRecommendOrder($arr,$order)
	{
		foreach ($arr as $key => $id)									//ѭ�������Ƽ���Ʒ˳��
		{
			$sql = "UPDATE EE_PRODUCT_RECOMMEND SET F_RECOMMEND_ORDER = {$order[$key]} WHERE F_ID = $id";
			$this->_db->query($sql);
		}
		return true;
	}
	/**
	 * ���ܣ�ǰ̨��ȡ�²�Ʒ�б�
	 * ������$pagesize ÿҳ��ȡ����
	 * ���أ�����
	 */
	public function GetNewProducts($pagesize)
	{
		$sql = "SELECT c.F_CLASS_NAME,c.F_ID AS CLASS_ID,p.F_PRODUCT_NAME,p.F_ID,p.F_PRODUCT_SMALL_IMG,p.F_PRODUCT_PRICE,p.F_PRODUCT_LOW_PRICE FROM EM_CLASS_INFO c,EE_PRODUCT_INFO p,EE_PRODUCT_NEW n";
		$sql .= " WHERE n.F_ID_PRODUCT_INFO = p.F_ID AND p.F_ID_CLASS_INFO = c.F_ID ORDER BY n.F_NEW_ORDER";
		$page = new Core_Pager($sql,$pagesize);
		return $page->getData();
	}
	/**
	 * ���ܣ���������ȡ��Ʒ�б�
	 * ������$classid ����ID,$pagesize ÿҳ��ȡ����,$keyword �ؼ���
	 * ���أ�����
	 */
	public function GetProducts($classid=0,$pagesize,$keyword='')
	{
		$sql = "SELECT F_ID,F_PRODUCT_NAME,F_PRODUCT_SMALL_IMG,F_PRODUCT_BIG_IMG,F_PRODUCT_PRICE,F_PRODUCT_LOW_PRICE FROM EE_PRODUCT_INFO WHERE";
		if($classid)									//�ж��Ƿ������ID
		{
			$sql .= " F_ID_CLASS_INFO = $classid";
			if($keyword)								//�ж��Ƿ��йؼ���
			{
				$keyword = urldecode($keyword);
				$sql .= " AND F_PRODUCT_NAME LIKE '%$keyword%'";
			}
		}else{
			$keyword = urldecode($keyword);
			$sql .= " F_PRODUCT_NAME LIKE '%$keyword%'";
		}
		$sql .= " ORDER BY F_PRODUCT_ORDER,F_ID DESC";
		$page = new Core_Pager($sql,$pagesize);
		return $page->getData();
	}
	/**
	 * ���ܣ���ӷ�����Ϣ
	 * ������$product_id ��ƷID,$userid �û�ID,$content ����
	 * ���أ�TRUE OR FALSE
	 */
	public function AddMessage($product_id,$userid,$content)
	{
		$data = array();
		$data[F_ID_PRODUCT_INFO] = $product_id;
		$data[F_ID_LOGIN_INFO] = $userid;
		$data[F_MESSAGE_CONTENT] = $content;
		$data[F_MESSAGE_TIME] = time();
		return $this->_db->insert("EE_MESSAGE_INFO",$data);
	}
}
?>
