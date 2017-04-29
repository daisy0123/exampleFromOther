<?php
class ProductModel extends Core_Db_Table
{
	protected $_name = "EE_PRODUCT_INFO";
	/**
	 * 功能：分页提取产品列表
	 * 参数：$classid 类别ID
	 * 返回：数组
	 */
	public function GetProductList($classid)
	{
		$sql = "SELECT F_ID,F_PRODUCT_NAME,F_PRODUCT_ORDER,F_PRODUCT_SMALL_IMG,F_PRODUCT_BIG_IMG FROM EE_PRODUCT_INFO WHERE F_ID_CLASS_INFO = $classid ORDER BY F_PRODUCT_ORDER,F_ID DESC";
		return $this->listPage($sql);
	}
	/**
	 * 功能：删除产品
	 * 参数：$arr 产品ID数组
	 * 返回：TRUE OR FALSE
	 */
	public function DelProduct($arr)
	{
		if($arr)													//判断是否选择了删除产品
		{
			$this->_db->beginTransaction();							//开始事务处理
			try{
				foreach($arr as $id)									//循环删除产品及相关信息
				{
					$sql = "DELETE FROM EE_PRODUCT_INFO WHERE F_ID = $id";
					$this->_db->query($sql);
					$sql = "DELETE FROM EE_PRODUCT_NEW WHERE F_ID_PRODUCT_INFO = $id";
					$this->_db->query($sql);
					$sql = "DELETE FROM EE_PRODUCT_RECOMMEND WHERE F_ID_PRODUCT_INFO = $id";
					$this->_db->query($sql);
				}
			} catch (Exception $e){									//捕获异常
				$this->_db->rollBack();								//回滚
				return false;
			}
			$this->_db->commit();
		}
		return true;
	}
	/**
	 * 功能：分页提取新产品列表
	 * 返回：数组
	 */
	public function GetNewList()
	{
		$sql = "SELECT c.F_CLASS_NAME,p.F_PRODUCT_NAME,n.F_ID,n.F_NEW_ORDER FROM EM_CLASS_INFO c,EE_PRODUCT_INFO p,EE_PRODUCT_NEW n";
		$sql .= " WHERE n.F_ID_PRODUCT_INFO = p.F_ID AND p.F_ID_CLASS_INFO = c.F_ID ORDER BY n.F_NEW_ORDER";
		$page = new Core_Pager($sql);
		return $page->getData();
	}
	/**
	 * 功能：删除新产品
	 * 参数：$arr 新产品ID数组
	 * 返回：TRUE
	 */
	public function DelNew($arr)
	{
		if($arr)													//判断是否选择了新产品
		{
			foreach($arr as $id)										//循环删除新产品
			{
				$sql = "DELETE FROM EE_PRODUCT_NEW WHERE F_ID = $id";
				$this->_db->query($sql);
			}
		}
		return true;
	}
	/**
	 * 功能：添加新产品
	 * 参数：$product_id 产品ID
	 * 返回：TRUE OR FALSE
	 */
	public function AddNew($product_id)
	{
		$data = array();
		$data[F_ID_PRODUCT_INFO] = $product_id;
		$data[F_NEW_ORDER] = 0;
		if($this->_db->insert("EE_PRODUCT_NEW",$data))						//判断是否操作成功
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 功能：提取该类别下所有产品
	 * 参数：$classid 类别ID
	 * 返回：数组
	 */
	public function GetProductListAll($classid)
	{
		$sql = "SELECT F_ID,F_PRODUCT_NAME FROM EE_PRODUCT_INFO WHERE F_ID_CLASS_INFO = $classid";
		return $this->_db->fetchPairs($sql);
	}
	/**
	 * 功能：设置新产品显示顺序
	 * 参数：$arr 新产品ID,$order 顺序值
	 * 返回：TRUE
	 */
	public function SetNewOrder($arr,$order)
	{
		foreach ($arr as $key => $id)									//循环设置新产品顺序
		{
			$sql = "UPDATE EE_PRODUCT_NEW SET F_NEW_ORDER = {$order[$key]} WHERE F_ID = $id";
			$this->_db->query($sql);
		}
		return true;
	}
	/**
	 * 功能：分页提取推荐产品列表
	 * 返回：数组
	 */
	public function GetRecommendList()
	{
		$sql = "SELECT c.F_CLASS_NAME,p.F_PRODUCT_NAME,n.F_ID,n.F_RECOMMEND_ORDER FROM EM_CLASS_INFO c,EE_PRODUCT_INFO p, EE_PRODUCT_RECOMMEND n";
		$sql .= " WHERE n.F_ID_PRODUCT_INFO = p.F_ID AND p.F_ID_CLASS_INFO = c.F_ID ORDER BY n.F_RECOMMEND_ORDER";
		$page = new Core_Pager($sql);
		return $page->getData();
	}
	/**
	 * 功能：添加推荐产品
	 * 参数：$product_id 产品ID
	 * 返回：TRUE OR FALSE
	 */
	public function AddRecommend($product_id)
	{
		$data = array();
		$data[F_ID_PRODUCT_INFO] = $product_id;
		$data[F_RECOMMEND_ORDER] = 0;
		if($this->_db->insert("EE_PRODUCT_RECOMMEND",$data))				//判断是否操作成功
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 功能：设置推荐产品显示顺序
	 * 参数：$arr 推荐产品ID,$order 顺序值
	 * 返回：TRUE
	 */
	public function SetRecommendOrder($arr,$order)
	{
		foreach ($arr as $key => $id)									//循环设置推荐产品顺序
		{
			$sql = "UPDATE EE_PRODUCT_RECOMMEND SET F_RECOMMEND_ORDER = {$order[$key]} WHERE F_ID = $id";
			$this->_db->query($sql);
		}
		return true;
	}
	/**
	 * 功能：前台提取新产品列表
	 * 参数：$pagesize 每页提取数量
	 * 返回：数组
	 */
	public function GetNewProducts($pagesize)
	{
		$sql = "SELECT c.F_CLASS_NAME,c.F_ID AS CLASS_ID,p.F_PRODUCT_NAME,p.F_ID,p.F_PRODUCT_SMALL_IMG,p.F_PRODUCT_PRICE,p.F_PRODUCT_LOW_PRICE FROM EM_CLASS_INFO c,EE_PRODUCT_INFO p,EE_PRODUCT_NEW n";
		$sql .= " WHERE n.F_ID_PRODUCT_INFO = p.F_ID AND p.F_ID_CLASS_INFO = c.F_ID ORDER BY n.F_NEW_ORDER";
		$page = new Core_Pager($sql,$pagesize);
		return $page->getData();
	}
	/**
	 * 功能：按分类提取产品列表
	 * 参数：$classid 分类ID,$pagesize 每页提取数量,$keyword 关键字
	 * 返回：数组
	 */
	public function GetProducts($classid=0,$pagesize,$keyword='')
	{
		$sql = "SELECT F_ID,F_PRODUCT_NAME,F_PRODUCT_SMALL_IMG,F_PRODUCT_BIG_IMG,F_PRODUCT_PRICE,F_PRODUCT_LOW_PRICE FROM EE_PRODUCT_INFO WHERE";
		if($classid)									//判断是否有类别ID
		{
			$sql .= " F_ID_CLASS_INFO = $classid";
			if($keyword)								//判断是否有关键字
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
	 * 功能：添加反馈信息
	 * 参数：$product_id 产品ID,$userid 用户ID,$content 内容
	 * 返回：TRUE OR FALSE
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
