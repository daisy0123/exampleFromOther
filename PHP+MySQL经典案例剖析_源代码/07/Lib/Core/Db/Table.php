<?php
abstract class Core_Db_Table extends Zend_Db_Table {
    protected $_primary = 'F_ID';
	/**
	 * ���ܣ����б����ʽ��ʾ���б�������
	 * ������$where ����,$order ��������
	 * ���أ�����
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
     * ���ܣ�ȡ�õ��м�¼
     * ������$id ��ID
     * ���أ�����
     */
	public function getInfo($id){ 
	    $sql = "SELECT * FROM " . $this->_name . " WHERE F_ID=:fid"; 
	    return $this->_db->fetchRow($sql,array('fid'=>$id));
	}
	/**
	 * ���ܣ��Է�ҳ�ķ�ʽ��ʾ����
	 *
	 * @param string $pageSQL Ĭ�ϲ��ұ������е�����
	 * @return array    array('data'=>......, 'JumpBar'=> .......) 
	 *                  dataΪ��ҳ����,JumpBarΪ��ҳ�ַ���
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
