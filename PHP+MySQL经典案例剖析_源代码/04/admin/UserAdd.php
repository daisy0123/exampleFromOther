<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'User.inc.php'); ?>
<?php
$User = new User();
$id = $_GET['Id'];
$title = "����";
if($id)															//�ж��Ƿ��Ǳ༭����
{
	$info = $User->getInfo($id,"EM_USER_INFO");
	$title = "�༭";
}
if($_SERVER['REQUEST_METHOD'] == 'POST')							//�ж��Ƿ����ύ����
{
	$data = array();
	$data[F_USER_NAME] = $_POST['username'];
	$data[F_USER_NO] = $_POST['no'];
	$data[F_USER_GENDER] = $_POST['gender'];
	$data[F_USER_OTHER] = $_POST['note'];
	if($_POST['pwd'])												//�ж��Ƿ��޸�����
		$data[F_USER_PASSWORD] = md5($_POST['pwd']);
	if($_POST['id'])													//�ж��Ƿ��Ǳ༭����
	{
		$User->updateData("EM_USER_INFO",$_POST['id'],$data);
		header("Location:UserList.php");
		exit();
	}else{
		$User->insertData("EM_USER_INFO",$data);
		header("Location:UserList.php");
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
<th class=caption height=23><?php echo $title?>�û�</th></tr>
<tr>
<td bgColor=#eeeeee>
<table width="70%" align=center border=0>
<tr>
<td align=right width="18%">ѧ��</td>
<td width="82%">
<INPUT id=no maxLength=16 name=no value="<?php echo $info[F_USER_NO]?>"> 
��3��16���ַ����</td></tr>
<tr>
<td align=right>����</td>
<td><INPUT id=pwd type=password maxLength=16 name=pwd> 
<?php 
if($id)															//�ж��Ƿ��Ǳ༭����
	echo "������޸������뱣��Ϊ��";
else 
	echo "��5��16���ַ����";
?></td></tr>
<tr>
<td align=right>ȷ������</td>
<td><INPUT id=pwd2 type=password maxLength=16 name=pwd2> 
�ٴ���������</td></tr>
<tr>
<td align=right>����</td>
<td>
<input name="username" type="text" id="username" value="<?php echo $info[F_USER_NAME]?>">
</td>
</tr>
<tr>
<td align=right>�Ա�</td>
<td><input name="gender" type="radio" value="0"
<?php 
if($info[F_USER_GENDER] == 0)										//�ж��Ƿ�������
	echo " checked"
?>
>
��
<input type="radio" name="gender" value="1"
<?php 
if($info[F_USER_GENDER] == 1)										//�ж��Ƿ���Ů��
	echo " checked"
?>
>
Ů</td>
</tr>
<tr>
<td align=right>��ע</td>
<td><input name="note" type="text" id="note" size="40" maxlength="100" value="<?php echo $info[F_USER_OTHER]?>"></td>
</tr>
</table></td></tr>
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
	if(frm_add.no.value == '')											//�ж�ѧ���Ƿ�Ϊ��
	{
		alert("ѧ�Ų���Ϊ��")
		frm_add.no.focus()
		return false
	}
	<?php
	if(!$id)														//�ж��Ƿ��Ǳ༭״̬
	{
	?>
	if (frm_add.pwd.value.length < 5){									//�ж����볤���Ƿ�Ϸ�
		alert("���벻��С��5��Ӣ���ַ�")
		frm_add.pwd.focus();
		return false
	}
	if (frm_add.pwd.value != frm_add.pwd2.value){							//�ж�ȷ�������Ƿ���ȷ
		alert("������ȷ�����벻��")
		frm_add.pwd.value = ""
		frm_add.pwd2.value = ""
		frm_add.pwd.focus();
		return false
	}
	<?php
	}
	?>
	if(frm_add.username.value == '')									//�ж������Ƿ�Ϊ��
	{
		alert("��������Ϊ��")
		frm_add.username.focus()
		return false
	}
	return true
}
</SCRIPT>
</body>
</html>