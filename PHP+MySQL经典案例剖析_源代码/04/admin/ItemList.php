<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
$dataid = $_GET['DataId'];
$id = $_GET['Id'];
$info = $Data->getInfo($id,"EE_OBJECTIVE_INFO");
$List = $Data->GetItemList($id);
?>
<html>
<head>
<title>考试系统管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form name=form1 action="" method=post>
<table cellSpacing=0 width="60%" align=center border=0>
<tr>
<td class=caption>客 观 题 选 项 管 理</td>
</tr>
<tr>
<td>客观题标题：<?php echo $info[F_OBJECTIVE_NAME]?></td>
</tr>
<tr>
<td>
<table width="100%" border=0>
<tr>
<th width=256>名称</th>
<th width=118>是否是正确答案</th>
<th width=121>管理</th>
</tr>
<?php
if($List)														//判断是否有选项信息
{
foreach($List as $value)											//循环显示选项信息
{
?>
<tr bgColor=#ffffff>
<td><?php echo $value[F_ITEM_NAME]?></td>
<td align=middle>
<?php
if($value[F_ITEM_IS_RIGHT])										//判断是否是正确答案
	echo "是";
else
	echo "否";
?>
</td>
<td align=middle>
<a href="ItemAdd.php?DataId=<?php echo $dataid?>&ObjId=<?php echo $id?>&Id=<?php echo $value[F_ID]?>">[编辑]</a> 
<a href="DelItem.php?DataId=<?php echo $dataid?>&ObjId=<?php echo $id?>&Id=<?php echo $value[F_ID]?>">[删除]</a></td>
</tr>
<?php
}
}
?>
</table></td>
</tr>
<tr>
<th>
<input id=cmdAdd type=button value=" 添 加 选 项 " name=cmdDel onClick="javascript:window.location='ItemAdd.php?DataId=<?php echo $dataid?>&ObjId=<?php echo $id?>'">
<input type="button" name="Submit2" value=" 设置选项顺序 " onClick="javascript:window.location='ItemOrder.php?DataId=<?php echo $dataid?>&Id=<?php echo $id?>'" />
<input type="button" name="Submit" value=" 返 回 列 表 " onClick="javascript:window.location='ObjList.php?Id=<?php echo $dataid?>'"></th>
</tr></table>
</form>
</body>
</html>