<?php
$url = $_GET['url'];
$tmp1 = substr($url,0,strrpos($url,"/"));
$tmp1 = $tmp1 . "/";
if(is_dir($url))													//�ж��Ƿ���Ŀ¼
{
	rmdir($url);												//ɾ��Ŀ¼
	echo "ɾ���ɹ�<br><a href='List.php?url=$tmp1'>����</a>";
}else{
	unlink($url);												//ɾ���ļ�
	echo "ɾ���ɹ�<br><a href='List.php?url=$tmp1'>����</a>";
}
?>
