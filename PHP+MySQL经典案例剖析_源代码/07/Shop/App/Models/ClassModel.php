<?php
class ClassModel extends Core_Db_Table
{
	protected $_name = "EM_CLASS_INFO";
	/**
	 * 功能：提取指定父ID类别列表
	 * 参数：$parentid 类别ID
	 * 返回：数组
	 */
	public function GetClassList($parent_id)
	{
		$sql = "SELECT * FROM EM_CLASS_INFO WHERE F_PARENT_ID = $parent_id ORDER BY F_CLASS_ORDER DESC,F_ID DESC";
		return $this->_db->fetchAll($sql);
	}
	/**
	 * 功能：提取类别树
	 */
	public function GetClassListAll(){
		$deep = 0;
		$this->_GetClassList(0);	
	}
	/**
	 * 功能：提取某个类别的树
	 * 参数：$parent_id 类别ID
	 */
	public function _GetClassList($parent_id){
		GLOBAL $deep,$classlist;
		$deep++;
		$c_list = $this->GetClassList($parent_id);
		$cur_class_num = count($classlist);
		if ($cur_class_num > 0)									//判断是否有类别
			$classlist[count($classlist) - 1][sub_num] = count($c_list);
		foreach($c_list as $class){									//循环组合类别树数组
			$c_id = $class[F_ID];
			$c_name = $class[F_CLASS_NAME];
			for ($i = 0,$prev = "";$i < $deep - 1;$i++)	$prev .= "　";
			$classlist[] = array("id" => $c_id,"parent_id" => $class[F_PANRET_ID],"class_name" => $c_name, "tree" => $prev . $c_name,"prev" => $prev);
			$this->_GetClassList($c_id);							//递归调用自身
		}
		$deep--;
	}
	/**
	 * 功能：提取对应名称的配置信息
	 * 参数：$name 配置名称
	 * 返回：数组
	 */
	public function GetDefaultConfig($name)
	{
		$sql = "SELECT F_CONFIG_VALUE FROM EM_CONFIG_INFO WHERE F_CONFIG_NAME = '$name'";
		$r = $this->_db->fetchRow($sql);
		return $r[F_CONFIG_VALUE];
	}
	/**
	 * 功能：提取类别产品属性
	 * 参数：$id 类别ID
	 * 返回：数组
	 */
	public function GetPropertyList($id)
	{
		$sql = "SELECT * FROM EE_PROPERTY_INFO WHERE F_ID_CLASS_INFO = $id ORDER BY F_PROPERTY_ORDER";
		return $this->_db->fetchAll($sql);
	}
	/**
	 * 功能：提取类别产品数
	 * 参数：$id 类别ID
	 * 返回：类别产品数
	 */
	public function GetProductCount($id)
	{
		$sql = "SELECT COUNT(F_ID) FROM EE_PRODUCT_INFO WHERE F_ID_CLASS_INFO = $id";
		$r = $this->_db->fetchRow($sql);
		return $r[0];
	}
	/**
	 * 功能：判断同一级下是否存在相同类别名称
	 * 参数：$name 名称,$parent_id 父类别ID,$id 类别ID 
	 * 返回：TRUE OR FALSE
	 */
	public function CheckClassNameExit($name,$parent_id=0,$id=0)
	{
		$sql = "SELECT F_ID FROM EM_CLASS_INFO WHERE F_CLASS_NAME = '$name'";
		$sql .= " AND F_PARENT_ID = $parent_id";
		if($class_id)
			$sql .= " AND F_ID <> $id";
		$r = $this->_db->fetchRow($sql);
		if($r[0])												//判断记录是否存在
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 功能：设置类别顺序
	 * 参数：$class_arr 类别ID数组,$order 顺序数组
	 * 返回：TRUE OR FALSE
	 */
	public function SetClassOrder($class_arr,$order)
	{
		$this->_db->beginTransaction();							//开始事务处理
		try{
			foreach($class_arr as $key => $value)					//循环设置顺序
			{
				$sql = "UPDATE EM_CLASS_INFO SET F_CLASS_ORDER = {$order[$key]} WHERE F_ID = $value";
				$this->_db->query($sql);
			}
		}catch (Exception $e){									//捕获异常
			$this->_db->rollBack();								//回滚返回FALSE
			return false;
		}
		$this->_db->commit();									//提交返回TRUE
		return true;
	}
	/**
	 * 功能：删除类别及相关产品和属性信息
	 * 参数：$id 类别ID
	 * 返回：TRUE OR FALSE
	 */
	public function Delete($id)
	{
		$this->_db->beginTransaction();							//开始事务处理
		try {
			$sql = "DELETE FROM EM_CLASS_INFO WHERE F_ID = $id";
			$this->_db->query($sql);								//删除类别信息
			$sql = "DELETE FROM EE_PRODUCT_INFO WHERE F_ID_CLASS_INFO = $id";
			$this->_db->query($sql);								//删除相关产品信息
			$sql = "DELETE FROM EE_PROPERTY_INFO WHERE F_ID_CLASS_INFO = $id";
			$this->_db->query($sql);								//删除相关属性信息
		}catch (Exception $e){									//捕获异常
			$this->_db->rollBack();								//回滚
			return false;
		}
		$this->_db->commit();
		return true;
	}
	/**
	 * 功能：插入或更新产品属性
	 * 参数：$arr 提交数据,$classid 类别ID,$id 被编辑属性ID
	 * 返回：TRUE OR FALSE
	 */
	public function UpdateProperty($arr,$classid,$id=0)
	{
		$sql = "SELECT F_ID FROM EE_PROPERTY_INFO WHERE F_PROPERTY_NAME = '{$arr[name]}' AND F_ID_CLASS_INFO = $classid";
		if($id)											//判断是否是编辑状态
		{
			$sql .= " AND F_ID <> $id";
		}
		$r = $this->_db->fetchRow($sql);
		if($r['F_ID'])										//判断属性名称是否存在
			return false;
		if($id)											//判断是否是编辑状态
		{
			$data['F_PROPERTY_NAME'] = $arr['name'];
			$this->_db->update('EE_PROPERTY_INFO',$data,'F_ID = ' . $id);
			return true;
		}else{
			$filename = $this->GetNextPropertyField($classid);
			$data['F_ID_CLASS_INFO'] = $classid;
			$data['F_PROPERTY_NAME'] = $arr['name'];
			$data['F_PROPERTY_FIELDNAME'] = $filename;
			$this->_db->insert("EE_PROPERTY_INFO",$data);
			return true;
		}
	}
	/**
	 * 功能：提取属性信息
	 * 参数：$id 属性ID
	 * 返回：数组
	 */
	public function GetPropertyInfo($id) {
		$sql = "SELECT * FROM EE_PROPERTY_INFO WHERE F_ID = " . $id;
		return $this->_db->fetchRow($sql);
	}
	/**
	 * 功能：取得下一个属性的字段名称
	 * 参数：$classid 类别ID
	 * 返回：字段名称
	 */
	private function GetNextPropertyField($classid){
		$last = 0;
		$sql = "SELECT * FROM EE_PROPERTY_INFO WHERE F_ID_CLASS_INFO = $classid ORDER BY F_PROPERTY_FIELDNAME";
		$list = $this->_db->fetchAll($sql);
		foreach($list as $property){							//循环取得最后一个属性字段
			$index = substr($property[F_PROPERTY_FIELDNAME],-2);
			if ($index - $last > 1)
				break;
			$last = $index;
		}
		$next = $last + 1;
		return "F_PRODUCT_PROPERTY" . str_pad($next,2,"0",STR_PAD_LEFT);
	}
	/**
	 * 功能：取得产品属性个数
	 * 参数：$classid 类别ID
	 * 返回：属性个数
	 */
	public function GetPropertyCount($classid){
		$sql = "SELECT COUNT(F_ID) FROM EE_PROPERTY_INFO WHERE F_ID_CLASS_INFO = $classid";
		$r = $this->_db->fetchRow($sql);
		return $r[0];
	}
	/**
	 * 功能：删除产品属性
	 * 参数：$id 属性ID
	 * 返回：TRUE OR FALSE
	 */
	public function DelProperty($id)
	{
		$sql = "DELETE FROM EE_PROPERTY_INFO WHERE F_ID = $id";
		return $this->_db->query($sql);
	}
	/**
	 * 功能：设置属性顺序
	 * 参数：$arr 属性ID数组,$order 顺序数组
	 * 返回：TRUE OR FALSE
	 */
	public function SetPropertyOrder($arr,$order)
	{
		$this->_db->beginTransaction();						//开始事务处理
		try{
			foreach($arr as $key => $id)						//循环设置顺序
			{
				$sql = "UPDATE EE_PROPERTY_INFO SET F_PROPERTY_ORDER = {$order[$key]} WHERE F_ID = $id";
				$this->_db->query($sql);
			}
		} catch (Exception $e){								//捕捉异常
			$this->_db->rollBack();							//回滚
			return false;
		}
		$this->_db->commit();
		return true;
	}

}
?>
