<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News(); 
switch($News->DelClass($_GET['id'])){								//判断删除返回结果
	case 1:													//返回1,删除成功
		$msg = "类别已经删除";
		$url = "right.php";
		echo "<script language='javascript'>
		parent.frames('left').location.reload();
		</script>";
		break;
	case 0:													//返回0,未知错误
		$msg = "未知错误，栏目未能删除";
		$url = "ClassInfo.php?id={$_GET['id']}&MenuId={$_GET['MenuId']}";
		break;
	case -1:													//返回-1,此栏目下有信息
		$msg = "此栏目下有信息存在，不能删除";
		$url = "ClassInfo.php?id={$_GET['id']}&MenuId={$_GET['MenuId']}";
		break;
	case -2:													//返回-2,此栏目下有子栏目
		$msg = "此栏目下有子栏目存在，不能删除";
		$url = "ClassInfo.php?id={$_GET['id']}&MenuId={$_GET['MenuId']}";
		break;
}
echo "<script language='JavaScript' type='text/JavaScript'>
alert('$msg');
window.location = '$url';
</script>";
exit;
?>
