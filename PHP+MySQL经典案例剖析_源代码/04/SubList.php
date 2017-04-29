<?php require_once('config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
$ClassInfo = $Data->getInfo($_GET['ClassId'],"EM_CLASS_INFO");
$DataInfo = $Data->getInfo($_GET['Id'],"EE_DATABASE_INFO");
$List = $Data->GetSubListAll($_GET['Id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>考试系统</title>
<link type="text/css" rel="stylesheet" href="/style/style.css">
</head>

<body>
<form name=form1 action="SubList.php?ClassId=<?php echo $_GET['ClassId']?>&Id=<?php echo $_GET['Id']?>&Action=Result" method=post>

<table width="550" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td height="28" background="1.gif" style="padding-left:25px;">
<?php echo $ClassInfo[F_CLASS_NAME]?> - <?php echo $DataInfo[F_DATABASE_NAME]?> - 主观题 </td>
</tr>
<tr>
<td style="padding-left:20px; padding-right:20px;">
<table width="100%" border="0">
<?php
if($List)														//判断是否有试题信息
{
foreach($List as $key => $value)									//循环显示试题信息
{
$i = $key + 1;
?>
<tr>
<td><?php echo $i?><?php echo nl2br($value[F_SUBJECTIVE_NAME])?>
(<?php echo $value[F_SUBJECTIVE_SCORE]?>分)</td>
</tr>
<tr>
<td align="center">
<textarea name="f_<?php echo $value[F_ID]?>" cols="60" rows="10" id="f_<?php echo $value[F_ID]?>"><?php echo $_POST["f{$value[F_ID]}"]?></textarea></td>
</tr>
<?php
if($_GET['Action'] == 'Result')										//判断是否提交查看答案
{
?>
<tr>
  <td>参考答案：</td>
</tr>
<tr>
  <td><?php echo nl2br($value[F_SUBJECTIVE_ANSWER])?></td>
</tr>
<?php
}
}
}
?>
</table></td>
</tr>
</table>
<table width="550" border="0" align="center">
<tr>
<td align="center"><input type="submit" name="Submit2" value="查看答案" /></td>
</tr>
</table>
</form>
</body>
</html>