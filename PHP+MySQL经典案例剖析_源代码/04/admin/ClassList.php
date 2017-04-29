<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Class.inc.php'); ?>
<?php
$Class = new ClassModel();
$List = $Class->GetClassList();
?>
<html>
<head>
<title>考试系统管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<table width="70%" align=center border=0>
<tr>
<td class=caption height=30>科目管理</td>
</tr>
<tr>
<td height=80>
<table width="90%" align=center border=0>
<tr>
<th width=91 height=23>科目名称</th>
<th width=260>备注</th>
<th width=106>管理</th>
</tr>
<?php
if($List)															//判断是否有记录
{
foreach($List as $value){												//循环显示科目列表
?>
<tr bgColor=#ffffff>
<td align=middle><?php echo $value[F_CLASS_NAME]?></td>
<td><?php echo $value[F_CLASS_NOTE]?></td>
<td align=middle>
<a href="ClassAdd.php?Id=<?php echo $value[F_ID]?>">[编辑]</a> 
<a onclick="return confirm('真的要删除此权限吗')" href="DelClass.php?Id=<?php echo $value[F_ID]?>">[删除]</a>
</td>
</tr>
<?php
}
}
?>
</table></td></tr>
<tr>
<td align=middle><INPUT onClick="window.location='ClassAdd.php'" type=button value=新增科目 name=Submit> 
</td>
</tr>
</table>
</body>
</html>