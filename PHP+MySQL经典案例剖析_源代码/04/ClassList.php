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
<title>考试系统</title>
<link type="text/css" rel="stylesheet" href="/style/style.css">
</head>

<body>
<table width="300" border="0" align="center">
<tr>
<td colspan="2">科目选择 <a href="ChangPwd.php">[修改密码]</a></td>
</tr>
<?php
if($List)														//判断是否有科目
{
foreach($List as $key => $value)									//循环显示科目信息
{
if($key % 2  == 0)												//判断是否是一行的开始
{
?>
<tr>
<?php
}
?>
<td>·<a href="DataList.php?Id=<?php echo $value[F_ID]?>"><?php echo $value[F_CLASS_NAME]?></a></td>
<?php
if($key % 2 == 1)												//判断是否是一行的结束
{
?>
</tr>
<?php
}
}
if($key % 2 < 1)													//判断最后一行是否结束
{
	for(;$key % 2 < 1;$key++)										//循环补足最后一行
		echo "<td width='50%'>&nbsp;</td>";
	echo "</tr>";
}
}
?>
</table>
</body>
</html>