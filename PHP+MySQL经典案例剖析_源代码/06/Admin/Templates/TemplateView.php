<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'Template.inc.php'); ?>
<?php
$Temp = new Temp();
$info = $Temp->getInfo($_GET['Id'],"EE_TEMPLATE_INFO");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>预览</title>
<link href="/Style/admin.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#CCCCCC">
<table width="500"  border="0" align="center">
  <tr>
    <td><?php echo $info['F_TMP_CODE'];?></td>
  </tr>
</table>
</body>
</html>
