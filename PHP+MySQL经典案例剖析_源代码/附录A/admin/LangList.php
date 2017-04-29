<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'lang.inc.php');
$lang = new Lang();
$list = $lang->getList();
?>
<html>
<head>
<title>语言管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<table width="98%" border="0" align="center" cellspacing="0" class=i_table>
<tr class="head">
<td width="6%">序号 </td>
<td width="20%">语言码 </td>
<td width="40%">语言名称</td>
<td width="30%">操作</td>
</tr> 
<?php
if($list)
{
	foreach($list as $key => $value)
	{
?>
  <tr class="l_field">
    <td><?php echo ($key + 1)?></td>
    <td align="left"><?php echo $value['F_CODE']?></td>
    <td align="left"><?php echo $value['F_NAME']?></td>
    <td align="left">
    [<a href="LangEdit.php?id=<?php echo $value[F_ID]?>">编辑</a>][<a href="LangDel.php?id=<?php echo $value[F_ID]?>">删除</a>]
    [<a href="TransList.php?id=<?php echo $value[F_ID]?>">语言翻译</a>]
    [<a href="Complie.php?id=<?php echo $value[F_ID]?>">编译</a>]</td>
  </tr>
<?php
	}
}
?>	
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8"><input type="button" name="Submit3" value="添加" onclick="javascript:window.location='LangAdd.php'" /></td>
  </tr>
</table>
</body>
</html>