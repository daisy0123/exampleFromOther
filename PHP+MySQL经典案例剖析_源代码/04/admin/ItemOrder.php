<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否是提交操作
{
	foreach($_POST['id'] as $key => $value)							//循环设置选项顺序
	{
		$data = array();
		$data[F_ITEM_ORDER] = $_POST['order'][$key];
		$Data->updateData("EE_OBJECTIVE_ITEM",$value,$data);
	}
}
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
<td class=caption>设 置 客 观 题 顺 序</td>
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
<th width=121>顺序</th>
</tr>
<?php
if($List)														//判断是否有选项
{
foreach($List as $value)											//循环显示选项
{
?>
<tr bgColor=#ffffff>
<td><?php echo $value[F_ITEM_NAME]?>
  <input name="id[]" type="hidden" id="id[]" value="<?php echo $value[F_ID]?>"></td>
<td align=middle>
<?php
if($value[F_ITEM_IS_RIGHT])										//判断是否是正确答案
	echo "是";
else
	echo "否";
?>
</td>
<td align=middle>
<input name="order[]" type="text" id="order[]" size="10" value="<?php echo $value[F_ITEM_ORDER]?>">
</td>
</tr>
<?php
}
}
?>
</table></td>
</tr>
<tr>
<th><input id=cmdAdd type=submit value=" 提 交 设 置 " name=cmdDel>
  <input type="button" name="Submit" value=" 返 回 列 表 " onClick="javascript:window.location='ItemList.php?DataId=<?php echo $dataid?>&Id=<?php echo $id?>'"></th>
</tr></table>
</form>
</body>
</html>