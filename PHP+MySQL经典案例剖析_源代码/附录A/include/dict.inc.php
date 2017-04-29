<?php
require_once(INCLUDE_PATH . 'db.inc.php');
Class Dict extends DBSQL									//定义类Dict继承DBSQL类
{
	private $_name = 'ZD_LANGUAGE_DICT'; 					//定义表名称
	public $_pagesize = 10;                                       //定义每页提取记录条数
	public function __construct()								//初始化构造函数
	{
		parent::__construct();
	}
	/**
	 * 功能：提取语言列表
	 * 参数：$page 当前页码
	 * 返回：数组	
	 */
	public function getList($page=1)
	{
		$start = ($page - 1) * $this->_pagesize;
		$sql = "SELECT * FROM " . $this->_name . " ORDER BY F_ID DESC";
		$sql .= " LIMIT " . $start . "," . $this->_pagesize . "";
		return $this->select($sql);
	}
	/**
	 * 功能：提取表的记录条数
	 * 返回：记录条数
	 */
	public function getCount()
	{
		$sql = "SELECT COUNT(F_ID) FROM " . $this->_name;
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * 功能：插入数据
	 * 参数：$data 数组(格式：$data['字段名'] = 值)
	 * 返回：插入记录的ID
	 */
	public function insertData($data)
	{
		$field = implode(',',array_keys($data));			//定义sql语句的字段部分
		$i = 0;
		foreach($data as $key => $val)						//组合sql语句的值部分
		{
			$value .= "'" . $val . "'";
			if($i < count($data) - 1)						//判断是否到数组的最后一个值
				$value .= ",";
			$i++;
		}
		$sql = "INSERT INTO " . $this->_name . "(" . $field . ") VALUES(" . $value . ")";
		return $this->insert($sql);
	}
	/**
	 * 功能：更新数据
	 * 参数：$data 数组(格式：$data[‘字段名’] = 值),$where 字符串
	 * 返回：TRUE OR FALSE
	 */
	public function updateData($data,$where='')
	{
		$col = array();
		foreach ($data as $key => $value)
		{
			$col[] = $key . "='" . $value ."'";
		}
		$sql = "UPDATE " . $this->_name . " SET " . implode(',',$col) . " WHERE " . $where . "";
		return $this->update($sql);
	}
	/**
	 * 功能：删除记录
	 * 参数：$id 表ID
	 * 返回：TRUE OR FALSE
	 */
	public function delData($id)
	{
		$this->begintransaction();
		try{
			$sql = "DELETE FROM ZM_LANGUAGE_TRANS WHERE F_ID_DICT = " . $id;
			$this->delete($sql);									//先删除翻译表里面的相关数据
			$sql = "DELETE FROM " . $this->_name . " WHERE F_ID = " . $id;
			$this->delete($sql);
		}catch(Exception $e){
			$this->rollback();
		}
		$this->commit();
		return true;
	}
	/**
	 * 功能：提取指定ID的信息
	 * 参数：$id 记录ID
	 * 返回：数组
	 */
	public function getInfo($id)
	{
		$sql = "SELECT * FROM " . $this->_name . " WHERE F_ID = " . $id;
		$r = $this->select($sql);
		return $r[0];
	}
}
?>
