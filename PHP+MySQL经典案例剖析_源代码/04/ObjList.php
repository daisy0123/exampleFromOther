<?php require_once('config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
$ClassInfo = $Data->getInfo($_GET['ClassId'],"EM_CLASS_INFO");
$DataInfo = $Data->getInfo($_GET['Id'],"EE_DATABASE_INFO");
$List = $Data->GetObjListAll($_GET['Id']);
if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否是提交批改
{
	$Result = array();
	$sum = 0;
	foreach($_POST['id'] as $objid)									//循环批改试题
	{
		$info = $Data->getInfo($objid,"EE_OBJECTIVE_INFO");
		switch($Data->CheckIsRight($objid,$_POST['f_' . $objid]))		//判断批改结果
		{
			case 0:											//0为没做该题
				$Result[$objid]['Result'] = "<font color=red>您未选择该题！</font>";
				break;
			case 1:											//1为答对
				$Result[$objid]['Result'] = "<font color=red>您答对了！</font>";
				$sum = $sum + $info[F_OBJECTIVE_SCORE];
				break;
			case 2:											//2为答错
				$Result[$objid]['Result'] = "<font color=red>您答错了！</font>";
				break;		
		}
	}
	$is_submit = true;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>考试系统</title>
<link type="text/css" rel="stylesheet" href="/style/style.css">
</head>

<body>
<form name=form1 action="ObjList.php?ClassId=<?php echo $_GET['ClassId']?>&Id=<?php echo $_GET['Id']?>&Action=Result" method=post>
<table width="550" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td height="28" background="1Up.gif" style="padding-left:25px;">
<?php echo $ClassInfo[F_CLASS_NAME]?> - <?php echo $DataInfo[F_DATABASE_NAME]?> - 客观题</td>
</tr>
<?php
if($List)														//判断是否有试题信息
{
foreach($List as $key => $value)									//循环显示试题信息
{
$i = $key + 1;
$ItemList = $Data->GetItemList($value[F_ID]);
?>
<tr>
<td style="padding-left:20px; padding-right:20px;"><table width="100%" border="0">
<tr>
<td>
<?php echo $i?>.<?php echo $value[F_OBJECTIVE_NAME]?>
<input name="id[]" type="hidden" id="id[]" value="<?php echo $value[F_ID]?>" />
(<?php echo $value[F_OBJECTIVE_SCORE]?>分)
</td>
</tr>
<tr>
<td>
<?php
if($ItemList)													//判断是否有选项信息
{
foreach($ItemList as $val)											//循环显示选项
{
if($value[F_OBJECTIVE_TYPE] == 1)								//判断是否是单选
{
?>
<input type="radio" name="f_<?php echo $value[F_ID]?>" value="<?php echo $val[F_ID]?>" />
<?php
}else{
?>
<input type="checkbox" name="f_<?php echo $value[F_ID]?>[]" value="<?php echo $val[F_ID]?>" />
<?php
}
echo $val[F_ITEM_NAME];
}
}
?></td>
</tr>
<tr>
  <td>
<?php
if($_GET['Action'] == 'Result')										//判断是否是查看答案,显示答案
{
	echo "正确答案:" . $Data->GetRight($value[F_ID]) . "<br>";
	if($is_submit)												//判断是否提交批改,显示批改结果
	{
		echo $Result[$value[F_ID]]['Result'];
	}
}
?>
</td>
</tr>
<?php
}
}
?>
</table>
<table width="100%" border="0">
<tr>
<td>
<?php
if($_GET['Action'] == 'Result' and $is_submit)							//判断是否提交批改,显示总得分
{
	echo "您的总得分为：$sum 分";
}
?>
</td>
</tr>
</table>
</td>
</tr>
</table>
<table width="550" border="0" align="center">
<tr>
<td align="center">
<input type="submit" name="Submit" value="提交批改" /> 
<input type="button" name="Submit2" value="查看答案" onclick="window.location='ObjList.php?ClassId=<?php echo $_GET['ClassId']?>&Id=<?php echo $_GET['Id']?>&Action=Result'" />
<input type="button" name="Submit3" value="进入主观题" onclick="window.location='SubList.php?ClassId=<?php echo $_GET['ClassId']?>&Id=<?php echo $_GET['Id']?>'" />
</td>
</tr>
</table>
</form>
</body>
</html>