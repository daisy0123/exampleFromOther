<?php
require_once("config.inc.php");
require_once(INCLUDE_PATH . "vote.inc.php");
require_once(INCLUDE_PATH . "ip.inc.php");
$vote = new Vote();
$ipclass = new IpModel();
$ip = getenv("REMOTE_ADDR");
$ip1 = getenv("HTTP_X_FORWARDED_FOR");
$ip2 = getenv("HTTP_CLIENT_IP");
($ip1) ? $ip = $ip1 : null ;											//$ip1有值则复给ip
($ip2) ? $ip = $ip2 : null ;											//$ip2有值则复给ip
$longip = ip2long($ip);											//将IP转化为整数
if(!isset($_POST['item']))											//判断用户是否选择了选项
{
	echo "<script>alert('您未选择调查选项！');window.history.back();</script>";
	exit();
}
if($vote->checkIsValid($longip,$_POST['id']))							//判断用户是否合法
{
	$location = $ipclass->ip2location($longip);						//匹配IP地址取得所在地区
	$vote->updateResult($_POST['item'],$_POST['id'],$longip,$location);	//更新数据库表
	header("Location:Result.php?id={$_POST['id']}");					//跳转到结果页面
}else{
	echo "<script>alert('您已经投过票了！');window.location='Result.php?id={$_POST['id']}'</script>";					//不合法则提醒并跳转到结果页面
	exit();
}
?>
