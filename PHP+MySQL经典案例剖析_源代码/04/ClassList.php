<?php require_once('config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Class.inc.php'); ?>
<?php
$Class = new ClassModel();
$List = $Class->GetClassList();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>����ϵͳ</title>
<link type="text/css" rel="stylesheet" href="/style/style.css">
</head>

<body>
<table width="300" border="0" align="center">
<tr>
<td colspan="2">��Ŀѡ�� <a href="ChangPwd.php">[�޸�����]</a></td>
</tr>
<?php
if($List)														//�ж��Ƿ��п�Ŀ
{
foreach($List as $key => $value)									//ѭ����ʾ��Ŀ��Ϣ
{
if($key % 2  == 0)												//�ж��Ƿ���һ�еĿ�ʼ
{
?>
<tr>
<?php
}
?>
<td>��<a href="DataList.php?Id=<?php echo $value[F_ID]?>"><?php echo $value[F_CLASS_NAME]?></a></td>
<?php
if($key % 2 == 1)												//�ж��Ƿ���һ�еĽ���
{
?>
</tr>
<?php
}
}
if($key % 2 < 1)													//�ж����һ���Ƿ����
{
	for(;$key % 2 < 1;$key++)										//ѭ���������һ��
		echo "<td width='50%'>&nbsp;</td>";
	echo "</tr>";
}
}
?>
</table>
</body>
</html>