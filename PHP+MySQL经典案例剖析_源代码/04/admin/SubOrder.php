<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
$id = $_GET['Id'];
if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否是提交操作
{
	foreach($_POST['SelId'] as $key => $del_id)						//循环设置顺序
	{
		$data = array();
		$data[F_SUBJECTIVE_ORDER] = $_POST['order'][$key];
		$Data->updateData("EE_SUBJECTIVE_INFO",$del_id,$data);
	}
}
if($_GET['Page'])												//判断是否有页码
	$page = $_GET['Page'];
else
	$page = 1;
$List = $Data->GetSubList($id,$page);
$Count = $Data->GetSubCount($id);
$Pagecount = ceil($Count / $Data->pagesize);
if(!$Pagecount) $Pagecount = 1;									//判断是否有页数
?>
<html>
<head>
<title>考试系统管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form name=form1 action="" method=post>
<table cellSpacing=0 width="95%" align=center border=0>
<tr>
<td class=caption colSpan=2>设 置  主 观 题 顺 序</td>
</tr>
<tr>
<td width="80%">共有试题<?php echo $Count?>个 共 <font color="red"><?php echo $page?></font> / <?php echo $Pagecount?> 页 每页 <?php echo $Data->pagesize?></td>
<td width="20%" align="right">转到
<select name="select" onChange="javascript:location.href='?Id=<?php echo $id?>Page='+this.options[selectedIndex].value;">
<?php
for($i = 1;$i <= $Pagecount;$i++)									//循环显示翻页下拉框
{
	echo "<option value='$i'";
	if($i == $page)												//设置默认选项
		echo " selected";
	echo ">$i</option>";
}
?>
</select>
页</td>
</tr>
<tr>
<td colSpan=2>
<table width="100%" border=0>
<tr>
<th width=348>标题</th>
<th width=255>参考答案</th>
<th width=190>顺序</th>
</tr>
<?php
if($List)														//判断是否有试题记录
{
foreach($List as $value)											//循环显示试题信息
{
?>
<tr bgColor=#ffffff>
<td><?php echo $value[F_SUBJECTIVE_NAME]?>
  <input name="SelId[]" type="hidden" id="SelId[]" value="<?php echo $value[F_ID]?>"></td>
<td align=middle><?php echo $value[F_SUBJECTIVE_ANSWER]?></td>
<td align=middle>
<input name="order[]" type="text" id="order[]" size="10" value="<?php echo $value[F_SUBJECTIVE_ORDER]?>">
</td>
</tr>
<?php
}
}
?>
</table>
</td>
</tr>
<tr>
<th colSpan=2><input id=cmdAdd type=submit value=" 提 交 设 置 " name=cmdDel>
  <input type="button" name="Submit" value=" 返 回 列 表 " onClick="javascript:window.location='SubList.php?Id=<?php echo $id?>'"></th>
</tr></table>
</form>
</body>
</html>