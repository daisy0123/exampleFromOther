<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Class.inc.php'); ?>
<?php
$Class = new ClassModel();
$List = $Class->GetClassList();
?>
<html>
<head>
<title>����ϵͳ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<table width="70%" align=center border=0>
<tr>
<td class=caption height=30>��Ŀ����</td>
</tr>
<tr>
<td height=80>
<table width="90%" align=center border=0>
<tr>
<th width=91 height=23>��Ŀ����</th>
<th width=260>��ע</th>
<th width=106>����</th>
</tr>
<?php
if($List)															//�ж��Ƿ��м�¼
{
foreach($List as $value){												//ѭ����ʾ��Ŀ�б�
?>
<tr bgColor=#ffffff>
<td align=middle><?php echo $value[F_CLASS_NAME]?></td>
<td><?php echo $value[F_CLASS_NOTE]?></td>
<td align=middle>
<a href="ClassAdd.php?Id=<?php echo $value[F_ID]?>">[�༭]</a> 
<a onclick="return confirm('���Ҫɾ����Ȩ����')" href="DelClass.php?Id=<?php echo $value[F_ID]?>">[ɾ��]</a>
</td>
</tr>
<?php
}
}
?>
</table></td></tr>
<tr>
<td align=middle><INPUT onClick="window.location='ClassAdd.php'" type=button value=������Ŀ name=Submit> 
</td>
</tr>
</table>
</body>
</html>