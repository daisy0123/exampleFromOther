<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'User.inc.php'); ?>
<?php
$User = new User();
if($_SERVER['REQUEST_METHOD'] == 'POST')							//判断是否提交删除操作
{
	if($_POST[del_id])												//判断是否选择了删除用户
	{
		foreach($_POST[del_id] as $id)								//循环删除选定用户
			$User->delData($id,"EM_USER_INFO");
	}
}
$page = $_GET['Page'];
if(!$page) $page = 1;													//判断是否有页码，默认为1
$List = $User->GetUserList($page);
$Count = $User->GetUserCount();
$Pagecount = ceil($Count / $User->pagesize);
if(!$Pagecount) $Pagecount = 1;										//判断是否有页数，默认为1
?>
<html>
<head>
<title>考试系统管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form name="form1" method="post" action="">
<table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td height="30" colspan="2" align="center" class="caption">用户列表</td>
</tr>
<tr>
<td width="82%">共有用户<?php echo $Count?>个 共<font color="red"><?php echo $page?></font>/<?php echo $Pagecount?> 每页<?php echo $User->pagesize?></td>
<td width="18%" align="right">转到：
<select name="select" onchange="javascript:location.href='?Page='+this.options[selectedIndex].value;">
<?php
for($i = 1;$i <= $Pagecount;$i++)										//循环显示页数下拉框
{
	echo "<option value='$i'";
	if($i == $page)													//设置默认页
		echo " selected";
	echo ">$i</option>";
}
?>
</select>
页</td>
</tr>
</table>
<table width="80%"  border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td bgcolor="#999999"><table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
<td><table width="100%" border="0">
<tr>
  <th width="28"> <input name="allbox" type="checkbox" id="allbox" onClick="CA();" value="1"></th>
  <th width="172">用户姓名</th>
  <th width="78">性别</th>
  <th width="83">学号</th>
  <th width="55">管理</th>
</tr>
<?php
if($List)															//判断是否有用户记录
{
	foreach($List as $key => $value){									//循环显示用户记录
?>
<tr>
  <td align="center"><?php echo "<input type='checkbox' name='del_id[]' value='{$value[F_ID]}'>" ?> </td>
  <td><?php echo $value[F_USER_NAME] ?> </td>
  <td align="center"><?php echo ($value[F_USER_GENDER]) ? "女" : "男"; ?> </td>
  <td align="center"><?php echo $value[F_USER_NO]?> </td>
  <td align="center"><a href="UserAdd.php?Id=<?php echo $value[F_ID] ?>">[编辑]</a></td>
</tr>
<?php
	}
}
else
{
?>
<tr>
<td align="center" colspan="5" bgcolor="#eeeeee">暂时没有用户！</td>
</tr>
<?php
}
?>
<tr>
<td align="center" colspan="5"><input type="button" name="Submit" value="添加用户" onClick="javascript:window.location='UserAdd.php'">
&nbsp;<input type="button" name="Submit" value="删除用户" onClick="javascript:del_user();"></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
</form>
<script language="JavaScript" type="text/JavaScript">
/**
 * 功能：实现全选功能
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;
	}
}
/**
 * 功能：确认用户删除
 */
function del_user()
{
	if(confirm("真的要删除吗?"))										//判断是否确认删除
	{
		document.form1.submit();
	}
}
</script>
</body>
</html>