<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$class_list = array();
$News->GetClassListAll();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>后台管理</title>
<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
/**
 * 功能：检测有没有选择栏目
 */
function check_class()
{
	if(form1.class_id.value == 0)								//判断栏目ID是否为0
	{
		alert("请选择栏目")
		return false
	}
return true
}
</script>
</head>
<body bgcolor="#999999">
<form name="form1" method="post" action="GenBatchContent.php?MenuId=<?php echo $_GET['MenuId']?>" onSubmit="return check_class();">
  <table width="70%"  border="1" align="center" cellpadding="0" cenllspacing="0">
    <tr>
      <td height="300"><table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center">
		  <fieldset title=''>
<legend align=center>
按照信息栏目
</legend>
<p align="center">选择栏目</p>
<p align="center">
<?php
echo "<select name='classid' id='classid'>";
echo "<option value=0 selected='selected'>请选择栏目</option>";
foreach($class_list as $class)									//循环显示栏目列表
{
	echo "<option value='{$class['id']}'";
	echo ">{$class['class']}</option>";
}
echo "</select>";
?>
</p>
<input type="submit" name="Submit" value=" 生成指定栏目信息 ">
</fieldset>
<br>
</td>
        </tr>
        <tr>
          <td align="center">
		  <fieldset title=''>
<legend align=center>
生成所有信息
</legend>
<input type="button" name="Submit" value=" 重新生成所有信息 " onClick="window.location = 'GenBatchContent.php?MenuId=<?php echo $_GET['MenuId']?>'">
          </fieldset>
		  </td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
