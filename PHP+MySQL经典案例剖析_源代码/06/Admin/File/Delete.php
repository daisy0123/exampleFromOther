<?php
$url = $_GET['url'];
$tmp1 = substr($url,0,strrpos($url,"/"));
$tmp1 = $tmp1 . "/";
if(is_dir($url))													//判断是否是目录
{
	rmdir($url);												//删除目录
	echo "删除成功<br><a href='List.php?url=$tmp1'>返回</a>";
}else{
	unlink($url);												//删除文件
	echo "删除成功<br><a href='List.php?url=$tmp1'>返回</a>";
}
?>
