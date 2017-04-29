<?php
class OrderModel extends Core_Db_Table
{
	protected $_name = "EM_ORDER_INFO";
	/**
	 * 功能：提取订单列表
	 * 参数：$userid 用户ID,$type 搜索类型,$start 搜索开始时间,$end 搜索结束时间,$keyword 搜索关键字
	 * 返回：数组
	 */
	public function GetOrderList($userid=0,$type=0,$start=0,$end=0,$keyword=””)
	{
		$sql = "SELECT l.F_LOGIN_NAME,o.F_ORDER_ADDRESS,o.F_ORDER_ZIPCODE,o.F_ORDER_PHONE,o.F_ORDER_TIME,";
		$sql .= "o.F_ORDER_STATUS,o.F_ID FROM EM_LOGIN_INFO l,EM_ORDER_INFO o WHERE l.F_ID = o.F_ID_LOGIN_INFO";
		if($userid)													//判断是否有用户ID参数
		{
			$sql .= " AND l.F_ID = $userid";
		}
		if($keyword)												//判断是否有关键字
		{
			$keyword = urldecode($keyword);
		}
		switch ($type)												//判断搜索类型
		{
			case 1:												//1为按用户名匹配
				$sql .= " AND l.F_LOGIN_NAME like '%$keyword%'";
				break;
			case 2:												//2为按EMAIL匹配
				$sql .= " AND l.F_LOGIN_EMAIL like '%$keyword%'";
				break;
			case 3:												//3为按真实姓名匹配
				$sql .= " AND u.F_USER_TRUENAME like '%$keyword%'";
				break;
		}
		if($start)													//判断是否按时间搜索
		{
			$sql .= " AND o.F_ORDER_TIME >= $start AND o.F_ORDER_TIME <= $end";
		}
		$sql .= " ORDER BY o.F_ORDER_TIME DESC";
		$page = new Core_Pager($sql);
		return $page->getData();
	}
	/**
	 * 功能：改变订单状态
	 * 参数：$arr 订单ID
	 * 返回：TRUE OR FALSE
	 */
	public function DealOrder($arr)
	{
		if($arr)													//判断是否选择了订单
		{
			$this->_db->beginTransaction();							//开始事务处理
			try {
				foreach ($arr as $id)									//循环处理订单
				{
					$sql = "UPDATE EM_ORDER_INFO SET F_ORDER_STATUS = 1 WHERE F_ID = $id";
					$this->_db->query($sql);
				}
			}catch (Exception $e){									//捕获异常
				$this->_db->rollBack();								//回滚
				return false;
			}
			$this->_db->commit();
		}
		return true;
	}
	/**
	 * 功能：生成日期选择数组
	 * 返回：数组
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
		for($i=$start_year;$i<=$end_year;$i++)							//循环生成年下拉框
		{
			$year_option .= "<option value='$i'";
			if($i == $year)											//设置默认选项
				$year_option .= " selected";
			$year_option .= ">$i</option>";
		}
		$data['Year'] = $year_option;
		$month_option = "";
		$month = date("n");
		for($i=1;$i<=12;$i++)											//循环生成月下拉框
		{
			$month_option .= "<option value='$i'";
			if($i == $month)										//设置默认选项
				$month_option .= " selected";
			$month_option .= ">$i</option>";			
		}
		$data['Month'] = $month_option;
		$day = date("j");
		$data['Day'] = "<option value='$day'>$day</option>";
		return $data;
	}
	/**
	 * 功能：提取订单产品信息
	 * 参数：$orderid 订单ID
	 * 返回：数组
	 */
	public function GetOrderProduct($orderid)
	{
		$data = array();
		$sql = "SELECT p.F_PRODUCT_NAME,c.F_ID_LOGIN_INFO,c.F_CART_PRODUCT_COUNT,p.F_PRODUCT_PRICE,p.F_PRODUCT_LOW_PRICE FROM EE_PRODUCT_INFO p,EE_CART_INFO c";
		$sql .= " WHERE c.F_ID_ORDER_INFO = $orderid AND c.F_ID_PRODUCT_INFO = p.F_ID";
		$data = $this->_db->fetchAll($sql);
		$count = 0;
		$price = 0;
		foreach ($data as $value)										//计算产品的总数量和价格
		{
			if($value['F_PRODUCT_LOW_PRICE'])						//判断是否有折扣价
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
	 * 功能：处理订单数据
	 * 参数：$data 订单数据,$sessionid
	 * 返回：TRUE OR FALSE
	 */
	public function InsertCart($data,$sessionid)
	{
		$this->_db->beginTransaction();						//开始事务处理
		try{
			$this->_db->insert($this->_name,$data);
			$id = $this->_db->lastInsertId();
			$sql = "UPDATE EE_CART_INFO SET F_ID_ORDER_INFO = $id";
			$sql .= " WHERE F_CART_SESSION_ID = '$sessionid'";
			$this->_db->query($sql);
		}catch(Exception $e){								//捕获异常，回滚
			$this->_db->rollBack();
			return false;
		}
		$this->_db->commit();
		return true;
	}

}
?>
