<?php
session_start();
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'chat.inc.php');
$chat = new Chat();
$msg = htmlspecialchars(addslashes($_POST['msg']));
$data = array();
$data['F_MESS_INFO'] = $msg;
$data['F_ID_USER_INFO'] = $_SESSION['UserId'];
$data['F_MESS_IS_NEW'] = 1;
$data['F_MESS_TIME'] = time();
$chat->insertData('EE_MESSAGE_INFO',$data);
?>
