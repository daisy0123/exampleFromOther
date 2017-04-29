<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
$id = $_GET['Id'];
if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否是提交操作
{
	if($_POST['SelId'])											//判断是否选择了试题
	{
		foreach($_POST['SelId'] as $del_id)							//循环删除试题
		{
			$Data->DelObj($del_id);
		}
	}
}
if($_GET['Page'])												//判断是否有页码
	$page = $_GET['Page'];
else
	$page = 1;
$List = $Data->GetObjList($id,$page);
$Count = $Data->GetObjCount($id);
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
<td class=caption colSpan=2>客 观 题 管 理</td>
</tr>
<tr>
<td width="80%">共有试题<?php echo $Count?>个 共 <font color="red"><?php echo $page?></font> / <?php echo $Pagecount?> 页 每页 <?php echo $Data->pagesize?></td>
<td width="20%" align="right">转到
<select name="select" onChange="javascript:location.href='?Id=<?php echo $id?>Page='+this.options[selectedIndex].value;">
<?php
for($i = 1;$i <= $Pagecount;$i++)									//显示分页下拉框
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
<th width=24><input id=allbox onclick=CA(); type=checkbox value=1 
name=allbox></th>
<th width=350>标题</th>
<th width=72>题目分值</th>
<th width=72>题目类型</th>
<th width=66>正确比列</th>
<th width=64>错误比列</th>
<th width=129>管理</th>
</tr>
<?php
if($List)														//判断是否有试题信息
{
foreach($List as $value)											//循环显示试题信息
{
	$sum = $value[F_OBJECTIVE_RIGHT] + $value[F_OBJECTIVE_WRONG];
	$right = @number_format(($value[F_OBJECTIVE_RIGHT] / $sum) * 100,2) . "%";
	$wrong = @number_format(($value[F_OBJECTIVE_WRONG] / $sum) * 100,2) . "%";	
?>
<tr bgColor=#ffffff>
<td align=middle><input type=checkbox value='<?php echo $value[F_ID]?>' name=SelId[]> </td>
<td><?php echo $value[F_OBJECTIVE_NAME]?></td>
<td align=middle><?php echo $value[F_OBJECTIVE_SCORE]?>分</td>
<td align=middle>
<?php 
if($value[F_OBJECTIVE_TYPE] == 1)								//判断是否是单选
{
	echo "单选";
}else{
	echo "多选";
}
?>
</td>
<td align=middle><?php echo $right?>(<?php echo $value[F_OBJECTIVE_RIGHT]?>)</td>
<td align=middle><?php echo $wrong?>(<?php echo $value[F_OBJECTIVE_WRONG]?>)</td>
<td align=middle><a href="ItemList.php?DataId=<?php echo $id?>&Id=<?php echo $value[F_ID]?>">[选项管理]</a>
<a href="ObjAdd.php?DataId=<?php echo $id?>&Id=<?php echo $value[F_ID]?>">[编辑]</a></td>
</tr>
<?php
}
}
?>
</table>
</td>
</tr>
<tr>
<th colSpan=2>
<input id=cmdAdd onclick=javascript:delobj(); type=button value=" 删 除 试 题 " name=cmdDel>
<input type="button" name="Submit2" value=" 添 加 试 题 " onClick="javascript:window.location='ObjAdd.php?DataId=<?php echo $id?>'">
<input type="button" name="Submit" value="设置试题顺序" onClick="javascript:window.location='ObjOrder.php?Id=<?php echo $id?>'"></th>
</tr></table>
</form>
<script language=JavaScript type=text/JavaScript>
/**
 * 实现全选功能
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;
	}
}
/**
 * 实现删除确认
 */
function delobj()
{
	if(confirm("真的要删除吗?"))
	{
		document.form1.submit();
	}
}
</script>
</body>
</html>