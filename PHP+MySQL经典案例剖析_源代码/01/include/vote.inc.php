<?php
require_once(INCLUDE_PATH . 'db.inc.php');
class Vote extends DBSQL
{
	public $_name = 'EM_VOTE_INFO';									//定义调查表名称变量
	public $_item = 'EE_ITEM_INFO';									//定义调查选项表名称变量
	public $_user = 'EE_VOTE_USER';									//定义用户信息表名称变量
	public $_pagesize = 10;											//定义每页提取记录数
	public $_type = array("1"=>"单选",								//定义选项类型
					"2"=>"多选");
	public $_display = array("0"=>"禁用",							//定义调查启用显示
					"1"=>"启用");
	public function __construct()
	{
		parent::__construct();
	}
	/**
	* 功能：提取调查列表
	* 参数：$where 查询条件
	* 返回：数组
	*/
	public function getVoteList($where = ''){
		$sql = "SELECT * FROM " . $this->_name;
		if($where)													//如果参数有值，则加入查询条件
		{
			$sql .= ' WHERE ' . $where;
		}
		return $this->select($sql);
	}

	/**
	 * 功能：提取指定表的指定ID的记录
	 * 参数：$id 表ID,$name 表名称
	 * 返回：数组
	 */
	public function getInfo($id,$name)
	{
		$sql = "SELECT * FROM " . $name . " WHERE F_ID = $id";
		$r = $this->select($sql);
		return $r[0];
	}
	/**
	 * 功能：向指定表中插入数据
	 * 参数：$name 表名称,$data 数组(格式：$data['字段名'] = 值)
	 * 返回：插入记录ID
	 */
	public function insertData($name,$data)
	{
		$field = implode(',',array_keys($data));					//定义sql语句的字段部分
		$i = 0;
		foreach($data as $key => $val)								//组合sql语句的值部分
		{
			$value .= "'" . $val . "'";
			if($i < count($data) - 1)								//判断是否到数组的最后一个值
				$value .= ",";
			$i++;
		}
		$sql = "INSERT INTO " . $name . "(" . $field . ") VALUES(" . $value . ")";
		//echo $sql;
		return $this->insert($sql);
	}
	/**
	* 功能：更新指定表指定ID的调查表记录
	* 参数：$name 表名称,$id 表ID,$data 数组(格式：$data['字段名'] = 值)
	* 返回：TRUE OR FALSE
	*/
	public function updateData($name,$id,$data){	 
		$col = array();
		foreach ($data as $key => $value)
		{
			$col[] = $key . "='" . $value . "'";
		}
		$sql = "UPDATE " . $name . " SET " . implode(',',$col) . " WHERE F_ID = $id";
		return $this->update($sql);
	}
	/**
	* 功能：删除指定ID的调查表记录及相关表记录
	* 参数：$id 调查表ID
	* 返回：TRUE OR FALSE
	*/
	public function delData($id){
		$this->begintransaction();
		try{
			$sql = "DELETE FROM " . $this->_item . " WHERE F_ID_VOTE_INFO = " . $id;
			$this->delete($sql);										//删除调查选项里面的相关数据
			$sql = "DELETE FROM " . $this->_user . " WHERE F_ID_VOTE_INFO = " . $id;
			$this->delete($sql);										//删除用户统计表里面的相关数据
			$sql = "DELETE FROM " . $this->_name . " WHERE F_ID = " . $id;
			$this->delete($sql);
		}catch(Exception $e){
			$this->rollback();
			return false;
		}
		$this->commit();
		return true;
	}
	/**
	 * 功能：提取指定调查ID的选项
	 * 参数：$vote_id 调查ID
	 * 返回：数组
	 */
	public function getItemList($vote_id)
	{
		$sql = "SELECT * FROM " . $this->_item . " WHERE F_ID_VOTE_INFO = $vote_id ORDER BY F_ITEM_ORDER";
		return $this->select($sql);
	}
	/**
	 * 功能：删除指定ID的选项表记录
	 * 参数：$id 表ID
	 * 返回：TRUE OR FALSE
	 */
	public function delItemData($id)
	{
		$sql = "DELETE FROM " . $this->_item . " WHERE F_ID = $id";
		return $this->delete($sql);
	}
	/**
	 * 功能：提取指定调查ID的用户统计信息
	 * 参数：$vote_id 调查ID,$page 当前页码
	 * 返回：数组
	 */
	public function getUserList($vote_id,$page=1)
	{
		$start = ($page - 1) * $this->_pagesize;
		$sql = "SELECT * FROM " . $this->_user . " WHERE F_ID_VOTE_INFO = $vote_id";
		$sql .= " LIMIT $start,$this->_pagesize";
		return $this->select($sql);
	}
	/**
	 * 功能：提取指定调查ID用户统计记录的条数
	 * 参数：$vote_id 调查ID
	 * 返回：记录条数
	 */
	public function getUserCount($vote_id)
	{
		$sql = "SELECT COUNT(F_ID) FROM " . $this->_user . " WHERE F_ID_VOTE_INFO = $vote_id";
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * 功能：删除指定ID的用户统计记录
	 * 参数：$id 用户统计表ID
	 * 返回：TRUE OR FALSE
	 */
	public function delUserData($id)
	{
		$sql = "DELETE FROM " . $this->_user . " WHERE F_ID = $id";
		return $this->delete($sql);
	}
	/**
	 * 功能：设置指定调查的选项顺序
	 * 参数：$id 选项ID数组,$order 选项顺序数组
	 * 返回：TRUE OR FALSE
	 */
	public function setOrder($id,$order)
	{
		if($id)
		{
			$this->begintransaction();
			try {
				foreach ($id as $key => $value)
				{
					$sql = "UPDATE " . $this->_item . " SET F_ITEM_ORDER = {$order[$key]} WHERE F_ID = $value";
					$this->update($sql);
				}
			}catch (Exception $e)
			{
				$this->rollback();
				return false;
			}
			$this->commit();
		}
		return true;
	}
	/**
	 * 功能：按区域统计用户信息
	 * 参数：$id 调查ID
	 * 返回：数组
	 */
	public function areaList($id)
	{
		$sql = "SELECT COUNT(F_ID) AS C,F_USER_AREA FROM " . $this->_user;
		$sql .= " WHERE F_ID_VOTE_INFO = $id GROUP BY F_USER_AREA";
		return $this->select($sql);
	}
	/**
	 * 功能：检查用户合法性
	 * 参数：$ip 用户IP,$voteid 调查ID,
	 * 返回：TRUE OR FALSE
	 */
	public function checkIsValid($ip,$voteid)
	{
		$sql = "SELECT F_ID FROM " . $this->_user . " WHERE F_USER_IP = $ip AND F_ID_VOTE_INFO = $voteid";
		$r = $this->select($sql);
		if($r[0][F_ID] > 0)					//如果该IP已经为该调查投过票则返回FALSE
		{
			return false;
		}else{
			return true;
		}
	}
	/**
	 * 功能：处理投票数据和用户信息更新相关数据表
	 * 参数：$item 调查选项ID,$voteid 调查ID,$ip 用户IP,$location 用户所在区域
	 * 返回：TRUE
	 */
	public function updateResult($item,$voteid,$ip,$location)
	{
		if(is_array($item))					//判断item是否是数组，是则为多选调查，循环处理数据
		{
			$this->begintransaction();			//开始事务处理
			try {
				foreach ($item as $value)
				{
					$sql = "UPDATE " . $this->_item . " SET F_ITEM_COUNT = F_ITEM_COUNT + 1 WHERE F_ID = $value";
					echo $sql;
					$this->update($sql);
				}
				$data = array();
				$data['F_USER_IP'] = $ip;
				$data['F_USER_TIME'] = time();
				$data['F_USER_AREA'] = $location;
				$data['F_ID_VOTE_INFO'] = $voteid;
				$this->insertData($this->_user,$data);
			}catch (Exception $e){			//出现异常，则回滚
				$this->rollback();
			}
			$this->commit();				//正常提交
			return true;
		}else{
			$this->begintransaction();			//开始事务处理
			try {
				$sql = "UPDATE " . $this->_item . " SET F_ITEM_COUNT = F_ITEM_COUNT + 1 WHERE F_ID = $item";
				$this->update($sql);
				$data = array();
				$data['F_USER_IP'] = $ip;
				$data['F_USER_TIME'] = time();
				$data['F_USER_AREA'] = $location;
				$data['F_ID_VOTE_INFO'] = $voteid;
				$this->insertData($this->_user,$data);
			}catch (Exception $e){			//出现异常，则回滚
				$this->rollback();
			}
			$this->commit();				//正常提交
			return true;
		}
	}
}
?>
