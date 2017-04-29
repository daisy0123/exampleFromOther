<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Class.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
if(!$_GET['Id'])													//�ж��Ƿ��Ǳ༭����
	$id = 0;
else 
	$id = $_GET['Id'];
$Data = new Data();
$Class = new ClassModel();
$ClassList = $Class->GetClassList();
if(!$ClassList)													//�ж��Ƿ��Ѿ�����˿�Ŀ
{
	echo "������ӿ�Ŀ<br>";
	echo "<a href='ClassAdd.php'>�����ӿ�Ŀ</a>";
	exit;
}
$title = "����";
if($id)														//�ж��Ƿ��Ǳ༭����
{
	$info = $Data->getInfo($id,'EE_DATABASE_INFO');
	$title = "�༭";
}
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ����ύ����
{
	$data = array();
	$data[F_DATABASE_NAME] = $_POST['name'];
	$data[F_ID_CLASS_INFO] = $_POST['class_id'];
	$data[F_DATABASE_NOTE] = $_POST['note'];
	$data[F_DATABASE_TIME] = time();
	if($_POST['id'])												//�ж��Ƿ��Ǳ༭����
	{
		$Data->updateData("EE_DATABASE_INFO",$_POST['id'],$data);
		header("Location:DataBaseList.php");
		exit();
	}else{
		$Data->insertData("EE_DATABASE_INFO",$data);
		header("Location:DataBaseList.php");
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
<th class=caption height=23><?php echo $title?>���</th>
</tr>
<tr>
<td bgColor=#eeeeee><table width="70%" align=center border=0>
<tr>
<td align=right width="18%">�������</td>
<td width="82%">
<INPUT name=name id=name size="30" value="<?php echo $info[F_DATABASE_NAME]?>">
</td>
</tr>
<tr>
<td align=right>������Ŀ</td>
<td><select name="class_id" id="class_id">
<?php
foreach($ClassList as $value)										//ѭ����ʾ��Ŀѡ��������
{
	if($value[F_ID] == $info[F_ID_CLASS_INFO])						//����Ĭ��ѡ��
		$select = " selected";
?>
<option value="1"<?php echo $select?>><?php echo $value[F_CLASS_NAME]?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<td align=right>��ע</td>
<td><INPUT name=note id=note size="30" value="<?php echo $info[F_DATABASE_NOTE]?>"></td>
</tr>
</table></td>
</tr>
<tr>
<th align=middle><INPUT type=submit value=�ύ name=Submit>
<input name="id" type="hidden" id="id" value="<?php echo $id?>"></th>
</tr>
</table>
</form>
<SCRIPT language=JavaScript>
/**
 * ���ܣ������
 */
function check_data(){
	if(frm_add.name.value == '')									//�ж������Ƿ�Ϊ��
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