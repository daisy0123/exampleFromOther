<?php
require_once(INCLUDE_PATH . 'db.inc.php');
Class Lang extends DBSQL									//定义类Lang继承DBSQL类
{
	private $_name = 'ZD_LANGUAGE';		 					//定义表名称
	private $_trans_name = 'ZD_LANGUAGE_TRANS';				//定义翻译表名称
	public $_pagesize = 10;                                 		//定义每页提取记录条数
	public function __construct()								//初始化构造函数
	{
		parent::__construct();
	}
	/**
	 * 功能：提取语言列表
	 * 参数：$page 当前页码
	 * 返回：数组
	 */
	public function getList()
	{
		$sql = "SELECT * FROM " . $this->_name;
		return $this->select($sql);
	}
	/**
	 * 功能：插入数据
	 * 参数：$data 数组(格式：$data[‘字段名’] = 值)
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
			$col[] = $key . "= '" . $value ."'";
		}
		$sql = "UPDATE " . $this->_name . " SET " . implode(',',$col) . " WHERE " . $where . "";
		return $this->update($sql);
	}
	/**
	 * 功能：批量更新表1.3数据
	 * 参数：$arr_dict 数据字典ID数组,$lang_id 语言ID,$arr_value更新值数组
	 * 返回：TRUE
	 */
	public function updateTransData($arr_dict,$lang_id,$arr_value)
	{
		$this->begintransaction();
		try {
			foreach($arr_dict as $key => $id)
			{
				$sql = "SELECT F_ID FROM " . $this->_trans_name	;
				$sql .= " WHERE F_ID_DICT = $id AND F_ID_LANG = $lang_id";
				$r = $this->select($sql);
				if($r[0][F_ID])
				{
					if($arr_value[$key])						//判断提交的文本框是否有值
					{
						$sql = "UPDATE " . $this->_trans_name . " SET F_TEXT = '" . $arr_value[$key] . "'";
						$sql .= " WHERE F_ID = " . $r[F_ID];
						$this->update($sql);
					}else{
						continue;
					}
				}else{
					if($arr_value[$key])
					{
						$sql = "INSERT INTO " . $this->_trans_name . "(F_ID_DICT,F_ID_LANG,F_TEXT)";
						$sql .= " VALUES($id,$lang_id,'{$arr_value[$key]}')";
						$this->insert($sql);
					}else{
						continue;
					}
				}
			}
		}catch (Exception $e)
		{
			$this->rollback();
			$msg = $e;
			include(ERRFILE);
		}
		$this->commit();
		return true;
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
			$sql = "DELETE FROM ZM_LANGUAGE_TRANS WHERE F_ID_LANG = " . $id;
			$this->delete($sql);									//先删除翻译表里面的相关数据
			$sql = "DELETE FROM " . $this->_name . " WHERE F_ID = " . $id;
			$this->delete($sql);
		}catch(Exception $e){
			$this->rollback();
			$msg = $e;
			include(ERRFILE);
			return false;
		}
		$this->commit();
		return true;
	}
	/**
	 * 功能：取指定ID的语言记录
	 * 参数：$id 记录ID
	 * 返回：数组
	 */
	public function getInfo($id)
	{
		$sql = "SELECT * FROM " . $this->_name . " WHERE F_ID = " . $id;
		$r = $this->select($sql);
		return $r[0];
	}
	/**
	 * 功能：取指定字典数据ID和语言ID的翻译数据记录
	 * 参数：$dict_id字典数据ID,$lang_id语言ID
	 * 返回：数组
	 */
	public function getTransInfo($dict_id,$lang_id)
	{
		$sql = "SELECT * FROM " . $this->_trans_name;
		$sql .= " WHERE F_ID_DICT = $dict_id AND F_ID_LANG = $lang_id";
		$r = $this->select($sql);
		return $r[0];
	}
	/**
	 * 功能：取指定语言ID的翻译数据
	 * 参数：$lang_id语言ID
	 * 返回：数组
	 */
	public function getTransList($lang_id)
	{
		$sql = "SELECT D.F_CODE,T.F_TEXT FROM ZD_LANGUAGE_DICT D,ZD_LANGUAGE_TRANS T WHERE D.F_ID = T.F_ID_DICT AND T.F_ID_LANG = $lang_id";
		return $this->select($sql);
	}
}
?>
