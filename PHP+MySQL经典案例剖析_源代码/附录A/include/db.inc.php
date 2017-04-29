<?php
/**
功能：数据库的基础操作类
**/
class DBSQL{
	private $CONN = "";									//定义数据库连接变量
	/**
	 * 功能：初始化构造函数，连接数据库
	 */
	public function __construct(){
		try {											//捕获连接错误并显示错误文件
			$conn = mysql_connect(ServerName,UserName,PassWord);
		}catch (Exception $e)
		{
			$msg = $e;
			include(ERRFILE);
		}
		try {											//捕获数据库选择错误并显示错误文件
			mysql_select_db(DBName,$conn);
		}catch (Exception $e)
		{
			$msg = $e;
			include(ERRFILE);
		}
		$this->CONN = $conn;
	}
	/**
	 * 功能：数据库查询函数
	 * 参数：$sql SQL语句
	 * 返回：二唯数组或false
	 */
	public function select($sql = ""){	
		if (empty($sql)) return false;					//如果SQL语句为空则返回FALSE
		if (empty($this->CONN)) return false;			//如果连接为空则返回FALSE
		try{											//捕获数据库选择错误并显示错误文件
			$results = mysql_query($sql,$this->CONN);
		}catch (Exception $e){
			$msg = $e;
			include(ERRFILE);
		}		
		if ((!$results) or (empty($results))) {			//如果查询结果为空则释放结果并返回FALSE
			@mysql_free_result($results);
			return false;
		}
		
		$count = 0;
		$data = array();
		
		while ($row = @mysql_fetch_array($results)) {	//把查询结果重组成一个二维数组
			$data[$count] = $row;
			$count++;
		}
		
		@mysql_free_result($results);
		
		return $data;
	}
	/**
	 * 功能：数据插入函数
	 * 参数：$sql SQL语句
	 * 返回：0或新插入数据的ID
	 */
	public function insert($sql = ""){
		if (empty($sql)) return 0;						//如果SQL语句为空则返回FALSE
		if (empty($this->CONN)) return 0;				//如果连接为空则返回FALSE
		try{											//捕获数据库选择错误并显示错误文件
			$results = mysql_query($sql,$this->CONN);
		}catch(Exception $e){
			$msg = $e;
			include(ERRFILE);
		}
		if (!$results) 									//如果插入失败返回0，否则返回当前插入数据ID
			return 0;
		else
			return @mysql_insert_id($this->CONN);
	}
	
	/**
	 * 功能：数据更新函数
	 * 参数：$sql SQL语句
	 * 返回：TRUE OR FALSE
	 */
	public function update($sql = ""){
		if(empty($sql)) return false;					//如果SQL语句为空则返回FALSE
		if(empty($this->CONN)) return false;			//如果连接为空则返回FALSE
		try{											//捕获数据库选择错误并显示错误文件
			$result = mysql_query($sql,$this->CONN);
		}catch(Exception $e){
			$msg = $e;
			include(ERRFILE);

		}
		return $result;
	}
	/**
	 * 功能：数据删除函数
	 * 参数：$sql SQL语句
	 * 返回：TRUE OR FALSE
	 */
	public function delete($sql = ""){
		if(empty($sql)) return false;					//如果SQL语句为空则返回FALSE
		if(empty($this->CONN)) return false;			//如果连接为空则返回FALSE
		try{
			$result = mysql_query($sql,$this->CONN);
		}catch(Exception $e){
			$msg = $e;
			include(ERRFILE);
		}
		return $result;
	}
	/**
	 * 功能：定义事务
	 */
	public function begintransaction()
	{
		mysql_query("SET  AUTOCOMMIT=0");				//设置为不自动提交，因为MYSQL默认立即执行
		mysql_query("BEGIN");							//开始事务定义
	}
	/**
	 * 功能：回滚
	 */
	public function rollback()
	{
		mysql_query("ROOLBACK");
	}
	/**
	 * 功能：提交执行
	 */
	public function commit()
	{
		mysql_query("COMMIT");
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
		$field = implode(',',array_keys($data));			//定义sql语句的字段部分
		$i = 0;
		foreach($data as $key => $val)						//组合sql语句的值部分
		{
			$value .= "'" . $val . "'";
			if($i < count($data) - 1)						//判断是否到数组的最后一个值
				$value .= ",";
			$i++;
		}
		$sql = "INSERT INTO " . $name . "(" . $field . ") VALUES(" . $value . ")";
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
	 * 功能：删除指定ID的表记录
	 * 参数：$id表ID,$name 表名称
	 * 返回：TRUE OR FALSE
	 */
	public function delData($id,$name)
	{
		$sql = "DELETE FROM " . $name . " WHERE F_ID = $id";
		return $this->delete($sql);
	}

}
?>
