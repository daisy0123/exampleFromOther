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
<title>��̨����</title>
<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
/**
 * ���ܣ������û��ѡ����Ŀ
 */
function check_class()
{
	if(form1.class_id.value == 0)								//�ж���ĿID�Ƿ�Ϊ0
	{
		alert("��ѡ����Ŀ")
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
������Ϣ��Ŀ
</legend>
<p align="center">ѡ����Ŀ</p>
<p align="center">
<?php
echo "<select name='classid' id='classid'>";
echo "<option value=0 selected='selected'>��ѡ����Ŀ</option>";
foreach($class_list as $class)									//ѭ����ʾ��Ŀ�б�
{
	echo "<option value='{$class['id']}'";
	echo ">{$class['class']}</option>";
}
echo "</select>";
?>
</p>
<input type="submit" name="Submit" value=" ����ָ����Ŀ��Ϣ ">
</fieldset>
<br>
</td>
        </tr>
        <tr>
          <td align="center">
		  <fieldset title=''>
<legend align=center>
����������Ϣ
</legend>
<input type="button" name="Submit" value=" ��������������Ϣ " onClick="window.location = 'GenBatchContent.php?MenuId=<?php echo $_GET['MenuId']?>'">
          </fieldset>
		  </td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
