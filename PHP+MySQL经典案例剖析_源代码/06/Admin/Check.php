<?php require_once(INCLUDE_PATH . 'db.inc.php')?>
<?php
ob_start();
session_start();
$db = new DBSQL();
$sql = "SELECT F_ID FROM EE_MENU_GROUP WHERE F_ID_GROUP_INFO = " . $_SESSION['GROUP_ID'];
$sql .= " AND F_ID_MENU_INFO = " . $_GET['MenuId'];
$r = $db->select($sql);
if(!($r[0][0] > 0))											//�ж��Ƿ��м�¼��������ʾ��Ȩ��
{
	echo "<script>alert('���޴�Ȩ��');window.location='/Admin/Index.php';</script>";
	exit();
}
?>
<link href="/Style/admin.css" rel="stylesheet" type="text/css">