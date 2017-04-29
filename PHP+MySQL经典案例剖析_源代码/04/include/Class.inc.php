<?php
require_once(INCLUDE_PATH . 'db.inc.php');
class ClassModel extends DBSQL
{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 功能：提取科目列表
	 * 返回：数组
	 */
	public function GetClassList()
	{
		$sql = "SELECT * FROM EM_CLASS_INFO ORDER BY F_ID DESC";
		return $this->select($sql);
	}
/**
	 * 功能：删除科目及相关信息
	 * 参数：$id 科目ID
	 * 返回：TRUE OR FALSE
	 */
	public function DelClass($id)
	{
		$this->begintransaction();										//开始事务处理
		try {
			$sql = "DELETE FROM EM_CLASS_INFO WHERE F_ID = $id";
			$this->delete($sql);										//删除科目信息
			$sql = "SELECT F_ID FROM EE_DATABASE_INFO WHERE F_ID_CLASS_INFO = $id";
			$list = $this->select($sql);									//删除题库信息
			foreach ($list as $value)
			{
				$sql = "DELETE FROM EE_OBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = {$value [F_ID]}";
				$this->delete($sql);									//删除客观题信息
				$sql = "DELETE FROM EE_OBJECTIVE_INFO o,EE_OBJECTIVE_ITEM i WHERE ";
				$sql .= "o.F_ID_DATABASE_INFO = {$value[F_ID]} AND o.F_ID = i.F_ID_ OBJECTIVE_INFO";
				$this->delete($sql);									//删除客观题选项信息
				$sql = "DELETE FROM EE_SUBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = {$value[F_ID]}";
				$this->delete($sql);									//删除主观题信息
			}
		}catch (Exception $e){										//捕获异常，回滚
			$this->rollback();
			return false;
		}
		$this->commit();
		return true;
	}
}
?>
