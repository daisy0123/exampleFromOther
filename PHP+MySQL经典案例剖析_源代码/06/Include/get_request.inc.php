<?php
// 启动SESSION,生成SESSION变量,REQUEST变量等
session_start();
if (!session_is_registered("sess_active_url"))
	session_register("sess_active_url");

$_SESSION[sess_active_url] = $_SERVER['PHP_SELF'];

if (!session_is_registered("sess_active_time"))
	session_register("sess_active_time");

$_SESSION['sess_active_time'] = time();

if ($_SERVER['QUERY_STRING'])
	$_SESSION['sess_active_url'] .= '?' . $_SERVER['QUERY_STRING'];

extract($_SESSION,EXTR_PREFIX_ALL,"s");
extract($_REQUEST,EXTR_PREFIX_ALL,"req");
?>