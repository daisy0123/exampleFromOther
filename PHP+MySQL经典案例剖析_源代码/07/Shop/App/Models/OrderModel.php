<?php
class OrderModel extends Core_Db_Table
{
	protected $_name = "EM_ORDER_INFO";
	/**
	 * ���ܣ���ȡ�����б�
	 * ������$userid �û�ID,$type ��������,$start ������ʼʱ��,$end ��������ʱ��,$keyword �����ؼ���
	 * ���أ�����
	 */
	public function GetOrderList($userid=0,$type=0,$start=0,$end=0,$keyword=����)
	{
		$sql = "SELECT l.F_LOGIN_NAME,o.F_ORDER_ADDRESS,o.F_ORDER_ZIPCODE,o.F_ORDER_PHONE,o.F_ORDER_TIME,";
		$sql .= "o.F_ORDER_STATUS,o.F_ID FROM EM_LOGIN_INFO l,EM_ORDER_INFO o WHERE l.F_ID = o.F_ID_LOGIN_INFO";
		if($userid)													//�ж��Ƿ����û�ID����
		{
			$sql .= " AND l.F_ID = $userid";
		}
		if($keyword)												//�ж��Ƿ��йؼ���
		{
			$keyword = urldecode($keyword);
		}
		switch ($type)												//�ж���������
		{
			case 1:												//1Ϊ���û���ƥ��
				$sql .= " AND l.F_LOGIN_NAME like '%$keyword%'";
				break;
			case 2:												//2Ϊ��EMAILƥ��
				$sql .= " AND l.F_LOGIN_EMAIL like '%$keyword%'";
				break;
			case 3:												//3Ϊ����ʵ����ƥ��
				$sql .= " AND u.F_USER_TRUENAME like '%$keyword%'";
				break;
		}
		if($start)													//�ж��Ƿ�ʱ������
		{
			$sql .= " AND o.F_ORDER_TIME >= $start AND o.F_ORDER_TIME <= $end";
		}
		$sql .= " ORDER BY o.F_ORDER_TIME DESC";
		$page = new Core_Pager($sql);
		return $page->getData();
	}
	/**
	 * ���ܣ��ı䶩��״̬
	 * ������$arr ����ID
	 * ���أ�TRUE OR FALSE
	 */
	public function DealOrder($arr)
	{
		if($arr)													//�ж��Ƿ�ѡ���˶���
		{
			$this->_db->beginTransaction();							//��ʼ������
			try {
				foreach ($arr as $id)									//ѭ��������
				{
					$sql = "UPDATE EM_ORDER_INFO SET F_ORDER_STATUS = 1 WHERE F_ID = $id";
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
	 * ���ܣ���������ѡ������
	 * ���أ�����
	 */
	public function GetDateOption()
	{
		$data = array();
		$sql = "SELECT F_ORDER_TIME FROM EM_ORDER_INFO ORDER BY F_ORDER_TIME ASC";
		$r = $this->_db->fetchRow($sql);
		$start_year = date('Y',$r[F_ORDER_TIME]);
		$sql = "SELECT F_ORDER_TIME FROM EM_ORDER_INFO ORDER BY F_ORDER_TIME DESC";
		$r = $this->_db->fetchRow($sql);
		$end_year = date('Y',$r[F_ORDER_TIME]);
		$year_option = "";
		$year = date('Y');
		for($i=$start_year;$i<=$end_year;$i++)							//ѭ��������������
		{
			$year_option .= "<option value='$i'";
			if($i == $year)											//����Ĭ��ѡ��
				$year_option .= " selected";
			$year_option .= ">$i</option>";
		}
		$data['Year'] = $year_option;
		$month_option = "";
		$month = date("n");
		for($i=1;$i<=12;$i++)											//ѭ��������������
		{
			$month_option .= "<option value='$i'";
			if($i == $month)										//����Ĭ��ѡ��
				$month_option .= " selected";
			$month_option .= ">$i</option>";			
		}
		$data['Month'] = $month_option;
		$day = date("j");
		$data['Day'] = "<option value='$day'>$day</option>";
		return $data;
	}
	/**
	 * ���ܣ���ȡ������Ʒ��Ϣ
	 * ������$orderid ����ID
	 * ���أ�����
	 */
	public function GetOrderProduct($orderid)
	{
		$data = array();
		$sql = "SELECT p.F_PRODUCT_NAME,c.F_ID_LOGIN_INFO,c.F_CART_PRODUCT_COUNT,p.F_PRODUCT_PRICE,p.F_PRODUCT_LOW_PRICE FROM EE_PRODUCT_INFO p,EE_CART_INFO c";
		$sql .= " WHERE c.F_ID_ORDER_INFO = $orderid AND c.F_ID_PRODUCT_INFO = p.F_ID";
		$data = $this->_db->fetchAll($sql);
		$count = 0;
		$price = 0;
		foreach ($data as $value)										//�����Ʒ���������ͼ۸�
		{
			if($value['F_PRODUCT_LOW_PRICE'])						//�ж��Ƿ����ۿۼ�
			{
				$price = $price + $value['F_PRODUCT_LOW_PRICE'] * $value['F_CART_PRODUCT_COUNT'];
			}else{
				$price = $price + $value['F_PRODUCT_PRICE'] * $value['F_CART_PRODUCT_COUNT'];
			}
			$count = $count + $value['F_CART_PRODUCT_COUNT'];
		}
		$data['SUM'] = $price;
		$data['COUNT'] = $count;
		return $data;
	}
	/**
	 * ���ܣ�����������
	 * ������$data ��������,$sessionid
	 * ���أ�TRUE OR FALSE
	 */
	public function InsertCart($data,$sessionid)
	{
		$this->_db->beginTransaction();						//��ʼ������
		try{
			$this->_db->insert($this->_name,$data);
			$id = $this->_db->lastInsertId();
			$sql = "UPDATE EE_CART_INFO SET F_ID_ORDER_INFO = $id";
			$sql .= " WHERE F_CART_SESSION_ID = '$sessionid'";
			$this->_db->query($sql);
		}catch(Exception $e){								//�����쳣���ع�
			$this->_db->rollBack();
			return false;
		}
		$this->_db->commit();
		return true;
	}

}
?>
