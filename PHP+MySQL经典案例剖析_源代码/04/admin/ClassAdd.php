<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Class.inc.php'); ?>
<?php
if(!$_GET['Id'])														//�ж��Ƿ��Ǳ༭����
	$id = 0;
else 
	$id = $_GET['Id'];
$Class = new ClassModel();
$title = "����";
if($id)															//�ж��Ƿ��Ǳ༭����
{
	$info = $Class->getInfo($id,'EM_CLASS_INFO');
	$title = "�༭";
}
if($_SERVER['REQUEST_METHOD'] == 'POST')							//�ж��Ƿ����ύ����
{
	$data = array();
	$data[F_CLASS_NAME] = $_POST['name'];
	$data[F_CLASS_NOTE] = $_POST['note'];
	if($_POST['id'])													//�ж��Ƿ��Ǳ༭����
	{
		$Class->updateData("EM_CLASS_INFO",$_POST['id'],$data);
		header("Location:ClassList.php");
		exit();
	}else{
		$Class->insertData("EM_CLASS_INFO",$data);
		header("Location:ClassList.php");
		exit();				
	}
}
?>
<html>
<head>
<title>����ϵͳ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form id=frm_add name=frm_add onSubmit="return check_data()" action="" method=post>
<table width="70%" align=center border=0>
<tr>
<th class=caption height=23><?php echo $title?>��Ŀ</th></tr>
<tr>
<td bgColor=#eeeeee>
<table width="70%" align=center border=0>
<tr>
<td align=right width="18%">����</td>
<td width="82%">
<INPUT name=name id=name size="30" value="<?php echo $info[F_CLASS_NAME]?>">
</td>
</tr>
<tr>
<td align=right>��ע</td>
<td>
<INPUT name=note id=note size="30" value="<?php echo $info[F_CLASS_NOTE]?>">
</td></tr>
</table></td></tr>
<tr>
<th align=middle><INPUT type=submit value=�ύ name=Submit>
  <input name="id" type="hidden" id="id" value="<?php echo $id?>"></th>
</tr>
</table>
</form>
<SCRIPT language=JavaScript>
/**
 * ���ܣ�����
 */
function check_data(){
	if(frm_add.name.value == '')										//�жϿ�Ŀ�����Ƿ�Ϊ��
	{
		alert("���Ʋ���Ϊ��")
		frm_add.name.focus()
		return false
	}
	return true
}
</SCRIPT>
</body>
</html>