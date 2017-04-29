<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否是提交操作
{
	if($_POST['SelId'])											//判断是否选择了题库
	{
		foreach($_POST['SelId'] as $id)								//循环删除题库
		{
			$Data->DelDataBase($id);
		}
	}
}
if($_GET['Page'])												//判断是否有页码
	$page = $_GET['Page'];
else
	$page = 1;
$List = $Data->GetDataList($page);
$Count = $Data->GetDataCount();
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
<td class=caption colSpan=2>题 库 管 理</td>
</tr>
<tr>
<td width="80%">共有题库<?php echo $Count?>个 共 <font color="red"><?php echo $page?></font> / <?php echo $Pagecount?> 页 每页 <?php echo $Data->pagesize?></td>
<td width="20%" align="right">转到
<select name="select" onchange="javascript:location.href='?Page='+this.options[selectedIndex].value;">
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
<th width=26><input id=allbox onclick=CA(); type=checkbox value=1 
name=allbox></th>
<th width=157>题库名称</th>
<th width=74>所属科目</th>
<th width=120>备注</th>
<th width=91>创建时间</th>
<th width=79>客观题数目</th>
<th width=76>主观题数目</th>
<th width=150>管理</th>
</tr>
<?php
if($List)														//判断是否有题库记录
{
foreach($List as $value)											//循环显示题库记录
{
	$Info = $Data->getInfo($value[F_ID_CLASS_INFO],"EM_CLASS_INFO");
	$Objcount = $Data->GetObjCount($value[F_ID]);
	$Subcount = $Data->GetSubCount($value[F_ID]);
?>
<tr bgColor=#ffffff>
<td align=middle><input type=checkbox value='<?php echo $value[F_ID]?>' name=SelId[]> </td>
<td><?php echo $value[F_DATABASE_NAME]?></td>
<td align=middle><?php echo $Info[F_CLASS_NAME]?></td>
<td align=middle><?php echo $value[F_DATABASE_NOTE]?></td>
<td align=middle><?php echo date("Y-m-d",$value[F_DATABASE_TIME]);?></td>
<td align=middle><?php echo $Objcount;?></td>
<td align=middle><?php echo $Subcount;?></td>
<td align=middle><a href="ObjList.php?Id=<?php echo $value[F_ID]?>">[客观题]</a> 
<a href="SubList.php?Id=<?php echo $value[F_ID]?>">[主观题]</a> 
<a href="DataBaseAdd.php?Id=<?php echo $value[F_ID]?>">[编辑]</a></td>
</tr>
<?php
}
}
?>
</table>
</td>
</tr>
<tr>
<th colSpan=2>&nbsp; <input id=cmdAdd onclick=javascript:deldata(); type=button value=" 删 除 题 库 " name=cmdDel>
<input type="button" name="Submit2" value=" 添 加 题 库 " onClick="javascript:window.location='DataBaseAdd.php'"></th>
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
function deldata()
{
	if(confirm("真的要删除吗?"))
	{
		document.form1.submit();
	}
}
</script>
</body>
</html>