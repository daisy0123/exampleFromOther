<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��̨����</title>
<link href="/Style/admin.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#B6C8D6" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>	
    <td align="center"><input type="button" name="Submit" value="��վ��ҳ(��Ŀ¼)" style="width:158" onClick="javascript:parent.parent.frames('n_right').location='Index.php?MenuId=<?php echo $_GET['MenuId']?>'"></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="120" valign="top"> 
      <?php
$MenuId = $_GET['MenuId'];
$News = new News();
switch ($_GET['Type'])											//�ж����ĸ�����ģ�����
{
	case 0:													//0��ʾ����Ŀ����
		$url = "ClassInfo.php";									//��������Ϊ��Ŀ��Ϣҳ
		break;
	case 1:													//1��ʾ����Ϣ����
		$url = "NewsList.php";									//�������ӵ���Ϣ�б�ҳ
		break;
	case 2:													//2��ʾ����Ϣ���
		$url = "CheckList.php";									//�������ӵ��ȴ������Ϣ�б�
		break;
	case 3:													//3��ʾ��ģ�����
		$url = "../Templates/TemplateList.php";						//�������ӵ�ģ���б�
		break;
}
$html = "<table width='100%'>";
$class_list = array();
$News->GetClassListAll();
foreach($class_list as $key => $l)									//ѭ����ʾ��Ŀ
{
	extract($l);
	if($parent_id == 0)											//�ж��Ƿ��Ƕ�����Ŀ
		$images = "<img src='/Images/plus.gif'>";
	else
		$images = "";
	$html .= "<tr><td>$images<a href='$url?id=$id&MenuId=$MenuId' target='n_right'>$class</a></td></tr>";
}
$html .= "</table>";
echo $html;
?>
    </td>
  </tr>
  <?php
if($_GET['Type'] == 0){											//�ж��Ƿ�����Ŀ����
?>
  <tr> 
    <td align="center"> <input type="button" name="Button" value="����������Ŀ" onClick="javascript:parent.parent.frames('n_right').location='ClassAdd.php?id=0&MenuId=<?php echo $MenuId?>'"> 
    </td>
  </tr>
  <?php
}
?>
</table>
