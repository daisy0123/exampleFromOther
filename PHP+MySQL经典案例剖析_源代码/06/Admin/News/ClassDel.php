<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News(); 
switch($News->DelClass($_GET['id'])){								//�ж�ɾ�����ؽ��
	case 1:													//����1,ɾ���ɹ�
		$msg = "����Ѿ�ɾ��";
		$url = "right.php";
		echo "<script language='javascript'>
		parent.frames('left').location.reload();
		</script>";
		break;
	case 0:													//����0,δ֪����
		$msg = "δ֪������Ŀδ��ɾ��";
		$url = "ClassInfo.php?id={$_GET['id']}&MenuId={$_GET['MenuId']}";
		break;
	case -1:													//����-1,����Ŀ������Ϣ
		$msg = "����Ŀ������Ϣ���ڣ�����ɾ��";
		$url = "ClassInfo.php?id={$_GET['id']}&MenuId={$_GET['MenuId']}";
		break;
	case -2:													//����-2,����Ŀ��������Ŀ
		$msg = "����Ŀ��������Ŀ���ڣ�����ɾ��";
		$url = "ClassInfo.php?id={$_GET['id']}&MenuId={$_GET['MenuId']}";
		break;
}
echo "<script language='JavaScript' type='text/JavaScript'>
alert('$msg');
window.location = '$url';
</script>";
exit;
?>
