<?php
require_once(INCLUDE_PATH . 'db.inc.php');
class ClassModel extends DBSQL
{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * ���ܣ���ȡ��Ŀ�б�
	 * ���أ�����
	 */
	public function GetClassList()
	{
		$sql = "SELECT * FROM EM_CLASS_INFO ORDER BY F_ID DESC";
		return $this->select($sql);
	}
/**
	 * ���ܣ�ɾ����Ŀ�������Ϣ
	 * ������$id ��ĿID
	 * ���أ�TRUE OR FALSE
	 */
	public function DelClass($id)
	{
		$this->begintransaction();										//��ʼ������
		try {
			$sql = "DELETE FROM EM_CLASS_INFO WHERE F_ID = $id";
			$this->delete($sql);										//ɾ����Ŀ��Ϣ
			$sql = "SELECT F_ID FROM EE_DATABASE_INFO WHERE F_ID_CLASS_INFO = $id";
			$list = $this->select($sql);									//ɾ�������Ϣ
			foreach ($list as $value)
			{
				$sql = "DELETE FROM EE_OBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = {$value [F_ID]}";
				$this->delete($sql);									//ɾ���͹�����Ϣ
				$sql = "DELETE FROM EE_OBJECTIVE_INFO o,EE_OBJECTIVE_ITEM i WHERE ";
				$sql .= "o.F_ID_DATABASE_INFO = {$value[F_ID]} AND o.F_ID = i.F_ID_ OBJECTIVE_INFO";
				$this->delete($sql);									//ɾ���͹���ѡ����Ϣ
				$sql = "DELETE FROM EE_SUBJECTIVE_INFO WHERE F_ID_DATABASE_INFO = {$value[F_ID]}";
				$this->delete($sql);									//ɾ����������Ϣ
			}
		}catch (Exception $e){										//�����쳣���ع�
			$this->rollback();
			return false;
		}
		$this->commit();
		return true;
	}
}
?>
