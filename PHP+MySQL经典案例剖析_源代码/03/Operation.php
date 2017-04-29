<?php
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'chat.inc.php');
session_start();
header('Content-type: text/html;charset=GB2312');
$chat = new Chat();
if($_SESSION['UserId'] == $_GET['userid']) {
	echo "您不能对自己进行操作";
	exit;
}
switch ($_GET['type'])
{
	case 1:											//执行屏蔽操作
		$sql = "SELECT F_ID FROM WHERE F_DISABLE_USER_ID = " . $_GET['userid'];
		$sql .= " AND F_ID_USER_INFO = " . $_SESSION['UserId'];
		$r = $chat->select($sql);
		if($r[0][F_ID])									//判断该用户是否已被屏蔽过
		{
			echo "该用户已被屏蔽过了";
		}else{
			$data['F_DISABLE_USER_ID'] = $_GET['userid'];
			$data['F_ID_USER_INFO'] = $_SESSION['UserId'];
			$chat->insertData('EE_DISABLE_USER',$data);
			$user = $chat->getInfo($_GET['userid'],'EM_USER_INFO');
			echo $_SESSION['Nick'] . "屏蔽了" . $user['F_USER_NICKNAME'] . "的发言";
		}
		break;
	case 2:											//解除屏蔽操作
		$sql = "SELECT F_ID FROM WHERE F_DISABLE_USER_ID = " . $_GET['userid'];
		$sql .= " AND F_ID_USER_INFO = " . $_SESSION['UserId'];
		$r = $chat->select($sql);
		if($r[0][F_ID])								//判断该用户是否被屏蔽过
		{
			$sql = "DELETE FROM EE_DISABLE_USER WHERE F_DISABLE_USER_ID = " . $_GET['userid'];
			$sql .= " AND F_ID_USER_INFO = " . $_SESSION['UserId'];
			$chat->delete($sql);
			$user = $chat->getInfo($_GET['userid'],'EM_USER_INFO');
			echo $_SESSION['Nick'] . "解除屏蔽" . $user['F_USER_NICKNAME'] . "的发言";
		}else{
			echo "操作失败，该用户未被屏蔽";
		}
		break;
	case 3:											//踢人操作
		$data['F_KICK_USER_ID'] = $_GET['userid'];
		$chat->insertData('EE_KICK_USER',$data);
		$user = $chat->getInfo($_GET['userid'],'EM_USER_INFO');
		echo $user['F_USER_NICKNAME'] . "被踢出聊天室";
		break;
}
?>