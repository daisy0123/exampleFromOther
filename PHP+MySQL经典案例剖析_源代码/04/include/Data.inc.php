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
	 * 功能：分页提取题库列表
	 * 参数：$id 科目ID,$page 页码
	 * 返回：数组
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
	 * 功能：提取题库数量
	 * 参数：$id 科目ID
	 * 返回：题库数量
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
	 * 功能：删除题库及相关试题信息
	 * 参数：$id 题库ID
	 * 返回：TRUE OR FALSE
	 */
	public function DelDataBase($id)
	{
		$this->begintransaction();									//开始事务处理
		try {
			$sql = "DELETE FROM EE_OBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
			$this->delete($sql);									//删除客观题
			$sql = "DELETE FROM EE_OBJECTIVE_INFO o,EE_OBJECTIVE_ITEM i ";
			$sql .= "WHERE o.F_ID_DATABASE_INFO = $id,o.F_ID = i.F_ID_OBJECTIVE_INFO";
			$this->delete($sql);									//删除客观题选项
			$sql = "DELETE FROM EE_SUBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
			$this->delete($sql);									//删除主观题
			$sql = "DELETE FROM EE_DATABASE_INFO WHERE F_ID = $id";
			$this->delete($sql);									//删除题库信息
		}catch (Exception $e){									//捕获异常，回滚
			$this->rollback();
			return false;
		}
		return true;
	}
	/**
	 * 功能：提取客观题数量
	 * 参数：$id 题库ID
	 * 返回：客观题数量
	 */
	public function GetObjCount($id)
	{
		$sql = "SELECT COUNT(F_ID) FROM EE_OBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * 功能：提取主观题数量
	 * 参数：$id 题库ID
	 * 返回：主观题数量
	 */
	public function GetSubCount($id)
	{
		$sql = "SELECT COUNT(F_ID) FROM EE_SUBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * 功能：分页提取客观题列表
	 * 参数：$id 题库ID,$page 页码
	 * 返回：数组
	 */
	public function GetObjList($id,$page=1)
	{
		$start = ($page - 1) * $this->pagesize;
		$sql = "SELECT * FROM EE_OBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
		$sql .= " ORDER BY F_OBJECTIVE_ORDER DESC LIMIT $start,$this->pagesize";
		return $this->select($sql);
	}
	/**
	 * 功能：分页提取客观题列表
	 * 参数：$id 题库ID,$page 页码
	 * 返回：数组
	 */
	public function GetSubList($id,$page=1)
	{
		$start = ($page - 1) * $this->pagesize;
		$sql = "SELECT * FROM EE_SUBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
		$sql .= " ORDER BY F_SUBJECTIVE_ORDER DESC LIMIT $start,$this->pagesize";
		return $this->select($sql);
	}
	/**
	 * 功能：删除客观题
	 * 参数：$id 试题ID
	 * 返回：TRUE OR FALSE
	 */
	public function DelObj($id)
	{
		$this->begintransaction();									//开始事务处理
		try {
			$sql = "DELETE FROM EE_OBJECTIVE_ITEM WHERE F_ID_OBJECTIVE_INFO = $id";
			$this->delete($sql);									//删除试题选项
			$sql = "DELETE FROM EE_OBJECTIVE_INFO WHERE F_ID = $id";
			$this->delete($sql);									//删除试题
		} catch (Exception $e){									//捕获异常，回滚
			$this->rollback();
			return false;
		}
		return true;
	}
	/**
	 * 功能：提取选项列表
	 * 参数：$id 客观题ID
	 * 返回：数组
	 */
	public function GetItemList($id)
	{
		$sql = "SELECT * FROM EE_OBJECTIVE_ITEM WHERE F_ID_OBJECTIVE_INFO = $id";
		$sql .= " ORDER BY F_ITEM_ORDER DESC";
		return $this->select($sql);
	}
	/**
	 * 功能：改变选项是否是正确答案状态
	 * 参数：$id 客观题ID
	 * 返回：TRUE OR FALSE
	 */	
	public function UpdateRightItem($id)
	{
		$sql = "UPDATE EE_OBJECTIVE_ITEM SET F_ITEM_IS_RIGHT = 0 WHERE F_ID_OBJECTIVE_INFO = $id";
		return $this->update($sql);
	}
	/**
	 * 功能：检测用户所选答案是否正确
	 * 参数：$objid 客观题ID,$item 答案ID
	 * 返回：0 为未选择该题,1为答案正确,2为答案错误
	 */	
	public function CheckIsRight($objid,$item)
	{
		if(!$item)												//判断是否选择了该题
		{
			return 0;
		}
		$r = $this->getInfo($objid,"EE_OBJECTIVE_INFO");
		if($r[F_OBJECTIVE_TYPE] == 1)							//判断该题是否是单选
		{
			$sql = "SELECT F_ITEM_IS_RIGHT FROM EE_OBJECTIVE_ITEM WHERE F_ID = $item";
			$i = $this->select($sql);
			if($i[0][0] == 1)										//判断答案是否正确
				return 1;
			else
				return 2;
		}else{
			$sql = "SELECT F_ID FROM EE_OBJECTIVE_ITEM WHERE F_ID_OBJECTIVE_INFO = $objid";
			$sql .= " AND F_ITEM_IS_RIGHT = 1";
			$i = $this->select($sql);
			$arr = array();
			foreach($i as $value)								//重新组合正确答案数组
			{
				$arr[] = $value[F_ID];
			}
			if(count($arr) == count($item))							//判断选项是否和答案个数相同
			{
				foreach($item as $value)							//循环判断选项是否正确
				{
					if(!in_array($value,$arr))						//判断选项是否正确
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
	 * 功能：提取所有客观题目信息
	 * 参数：$id题库ID
	 * 返回：数组
	 */		
	public function GetObjListAll($id)
	{
		$sql = "SELECT * FROM EE_OBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
		$sql .= " ORDER BY F_OBJECTIVE_ORDER DESC";
		return $this->select($sql);
	}
	/**
	 * 功能：提取所有主观题目信息
	 * 参数：$id题库ID
	 * 返回：数组
	 */		
	public function GetSubListAll($id)
	{
		$sql = "SELECT * FROM EE_SUBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = $id";
		$sql .= " ORDER BY F_SUBJECTIVE_ORDER DESC";
		return $this->select($sql);
	}
	/**
	 * 功能：提取题目的正确答案
	 * 参数：$id题目ID
	 * 返回：正确答案
	 */
	public function GetRight($id) {
		$sql = "SELECT F_ID FROM EE_OBJECTIVE_ITEM WHERE F_ID = $id";
		$r = $this->select($sql);
		return $r[0][0];	
	}
}
?>
