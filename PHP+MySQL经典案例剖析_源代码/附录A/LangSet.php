<?php
require_once("config.inc.php");
require_once(INCLUDE_PATH . 'core.inc.php');
Core::chgLanguage($_GET['Lang']);					//�ı�����
$backurl = $_GET['ReturnUrl'];						//ȡ�÷��ص�ַ
header("Location:$backurl");						//�ض��򵽷��ص�ַ
?>