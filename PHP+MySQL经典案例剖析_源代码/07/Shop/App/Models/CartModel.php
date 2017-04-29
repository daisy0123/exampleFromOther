<?php
class CartModel extends Core_Db_Table
{
	protected $_name = "EE_CART_INFO";
	/**
	 * ���ܣ���ȡ���ﳵ��Ʒ�б�
	 * ������$sessionid
	 * ���أ�����
	 */
	public function GetProductList($sessionid)
	{
		$sql = "SELECT p.F_PRODUCT_NAME,c.F_CART_PRODUCT_COUNT, p.F_PRODUCT_PRICE,";
		$sql .= "c.F_ID,p.F_PRODUCT_LOW_PRICE FROM EE_CART_INFO c,EE_PRODUCT_INFO p";
		$sql .= " WHERE c.F_ID_PRODUCT_INFO = p.F_ID AND c.F_CART_SESSION_ID = '$sessionid'";
		$sql .= " AND c.F_ID_ORDER_INFO = 0 ORDER BY c.F_ID DESC";
		return $this->_db->fetchAll($sql);
	}
	/**
	 * ���ܣ��Ѳ�Ʒ���빺�ﳵ
	 * ������$sessionid,$userid �û�ID,$productid ��ƷID
	 * ���أ�TRUE OR FALSE
	 */
	public function AddToCart($sessionid,$userid=0,$productid)
	{
		$time = time();
		$data = array();
		$data[F_ID_LOGIN_INFO] = $userid;
		$data[F_CART_SESSION_ID] = $sessionid;
		$data[F_ID_PRODUCT_INFO] = $productid;
		$data[F_CART_PRODUCT_COUNT] = 1;
		$data[F_ID_ORDER_INFO] = 0;
		$data[F_CART_TIME] = $time;
		$sql = "SELECT F_ID FROM EE_CART_INFO WHERE F_CART_SESSION_ID = '$sessionid'";
		$sql .= " AND F_ID_ORDER_INFO = 0";
		$r = $this->_db->fetchRow($sql);
		if($r[F_ID])											//�жϹ��ﳵ�Ƿ��иò�Ʒ
		{
			return true;
		}else{
			return $this->_db->insert("EE_CART_INFO",$data);
		}
	}
	/**
	 * ���ܣ���չ��ﳵ�����в�Ʒ
	 * ������$sessionid
	 * ���أ�TRUE OR FALSE
	 */
	public function Truncate($sessionid)
	{
		$sql = "DELETE FROM EE_CART_INFO WHERE F_CART_SESSION_ID = '$sessionid'";
		$sql .= " AND F_ID_ORDER_INFO = 0";
		return $this->_db->query($sql);
	}
	/**
	 * ���ܣ����¹��ﳵ��Ʒ����
	 * ������$sessionid,$idAry ID����,$countAry ��������
	 */
	public function UpdateCount($sessionid,$idAry,$countAry)
	{
		if($idAry)
		{
			foreach($idAry as $key => $id)
			{
				$sql = "UPDATE EE_CART_INFO SET F_CART_PRODUCT_COUNT = {$countAry[$key]}";
				$sql .= " WHERE F_ID = $id";
				$this->_db->query($sql);
			}
		}
		return true;
	}
	/**
	 * ���ܣ�ɾ�����ﳵ��ָ����Ʒ
	 * ������$id ��ƷID,$sessionid
	 * ���أ�TRUE OR FALSE
	 */
	public function DelProduct($id,$sessionid)
	{
		$sql = "DELETE FROM EE_CART_INFO WHERE F_CART_SESSION_ID = '$sessionid'";
		$sql .= " AND F_ID = $id";
		return $this->_db->query($sql);
	}

}
?>
