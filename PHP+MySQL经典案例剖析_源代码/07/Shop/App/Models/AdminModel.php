<?php
class AdminModel extends Core_Db_Table
{
	protected $_name = "EM_ADMIN_INFO";
	
	public function checkLogin($user,$password) {
		$password = md5($password);
		$sql = "SELECT F_ID,F_USER_NAME FROM " . $this->_name . " WHERE F_USER_NAME = '$user' AND F_USER_PASSWORD = '$password'";
		$r = $this->_db->fetchRow($sql);
		if($r[F_ID]) {
			return $r;
		} else {
			return false;
		}
	}
}
?>
