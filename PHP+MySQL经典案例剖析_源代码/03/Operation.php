<?php
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'chat.inc.php');
session_start();
header('Content-type: text/html;charset=GB2312');
$chat = new Chat();
if($_SESSION['UserId'] == $_GET['userid']) {
	echo "�����ܶ��Լ����в���";
	exit;
}
switch ($_GET['type'])
{
	case 1:											//ִ�����β���
		$sql = "SELECT F_ID FROM WHERE F_DISABLE_USER_ID = " . $_GET['userid'];
		$sql .= " AND F_ID_USER_INFO = " . $_SESSION['UserId'];
		$r = $chat->select($sql);
		if($r[0][F_ID])									//�жϸ��û��Ƿ��ѱ����ι�
		{
			echo "���û��ѱ����ι���";
		}else{
			$data['F_DISABLE_USER_ID'] = $_GET['userid'];
			$data['F_ID_USER_INFO'] = $_SESSION['UserId'];
			$chat->insertData('EE_DISABLE_USER',$data);
			$user = $chat->getInfo($_GET['userid'],'EM_USER_INFO');
			echo $_SESSION['Nick'] . "������" . $user['F_USER_NICKNAME'] . "�ķ���";
		}
		break;
	case 2:											//������β���
		$sql = "SELECT F_ID FROM WHERE F_DISABLE_USER_ID = " . $_GET['userid'];
		$sql .= " AND F_ID_USER_INFO = " . $_SESSION['UserId'];
		$r = $chat->select($sql);
		if($r[0][F_ID])								//�жϸ��û��Ƿ����ι�
		{
			$sql = "DELETE FROM EE_DISABLE_USER WHERE F_DISABLE_USER_ID = " . $_GET['userid'];
			$sql .= " AND F_ID_USER_INFO = " . $_SESSION['UserId'];
			$chat->delete($sql);
			$user = $chat->getInfo($_GET['userid'],'EM_USER_INFO');
			echo $_SESSION['Nick'] . "�������" . $user['F_USER_NICKNAME'] . "�ķ���";
		}else{
			echo "����ʧ�ܣ����û�δ������";
		}
		break;
	case 3:											//���˲���
		$data['F_KICK_USER_ID'] = $_GET['userid'];
		$chat->insertData('EE_KICK_USER',$data);
		$user = $chat->getInfo($_GET['userid'],'EM_USER_INFO');
		echo $user['F_USER_NICKNAME'] . "���߳�������";
		break;
}
?>