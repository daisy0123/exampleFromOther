<?php
abstract class Core_Db_Table extends Zend_Db_Table {
    protected $_primary = 'F_ID';
	/**
	 * 功能：以列表的形式显示所有表内数据
	 * 参数：$where 条件,$order 排序条件
	 * 返回：数组
	 */
    public function listAll($where = null, $order = null)
    {
		$sql = "SELECT * FROM {$this->_name} ";
		if ($where != null)
			$sql .= "WHERE $where";
		if ($order != null)
			$sql .= "ORDER BY $order";
		return $this->_db->fetchAll($sql);
    }
    /**
     * 功能：取得单行记录
     * 参数：$id 表ID
     * 返回：数组
     */
	public function getInfo($id){ 
	    $sql = "SELECT * FROM " . $this->_name . " WHERE F_ID=:fid"; 
	    return $this->_db->fetchRow($sql,array('fid'=>$id));
	}
	/**
	 * 功能：以分页的方式显示数据
	 *
	 * @param string $pageSQL 默认查找本身所有的数据
	 * @return array    array('data'=>......, 'JumpBar'=> .......) 
	 *                  data为分页数据,JumpBar为分页字符串
	 */
	public function listPage($pageSQL=""){
		if($pageSQL==""){
			$pageSQL = "SELECT * FROM {$this->_name} ORDER BY F_ID DESC";
		}
		$page = new Core_Pager($pageSQL);
		return $page->getData();
	}
}
?>
