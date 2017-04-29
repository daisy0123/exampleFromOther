<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
$Data->delData($_GET['Id'],"EE_OBJECTIVE_ITEM");
header("Location:ItemList.php?DataId={$_GET['DataId']}&Id={$_GET['ObjId']}");
?>
