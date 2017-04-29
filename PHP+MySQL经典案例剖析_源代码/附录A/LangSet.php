<?php
require_once("config.inc.php");
require_once(INCLUDE_PATH . 'core.inc.php');
Core::chgLanguage($_GET['Lang']);					//改变语言
$backurl = $_GET['ReturnUrl'];						//取得返回地址
header("Location:$backurl");						//重定向到返回地址
?>