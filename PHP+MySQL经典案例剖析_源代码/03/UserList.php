<?php
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'chat.inc.php');
session_start();
header('Content-type: text/html;charset=GB2312');
$chat = new Chat();
if($id=$chat->CheckIsKicked($_SESSION['UserId']))					//�жϸ��û��Ƿ񱻹���Ա�߳�������
{
	session_destroy();										//���session
	echo '0';
	exit;
}
$list = $chat->GetOnlineList();
$str = "<ul>";
if($list)
{
	foreach($list as $value)
	{
		$str .= "<li>";
		$str .= "<a href=\"#\" onclick=\"javascript:Select('{$value[F_ID]}','{$value['F_USER_NICKNAME']}')\">" . $value['F_USER_NICKNAME'] . "</a>";
		$str .= "</li>";
	}
}
$str .= "</ul>";
echo $str;
?>
