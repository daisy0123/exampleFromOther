<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
if(!$_GET['Id'])													//�ж��Ƿ��Ǳ༭����
	$id = 0;
else 
	$id = $_GET['Id'];
$dataid = $_GET['DataId'];
$Data = new Data();
$datainfo = $Data->getInfo($dataid,"EE_DATABASE_INFO");
$title = "����";
if($id)														//�ж��Ƿ��Ǳ༭����
{
	$info = $Data->getInfo($id,'EE_SUBJECTIVE_INFO');
	
	$title = "�༭";
}
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ����ύ����
{
	$data = array();
	$data[F_SUBJECTIVE_NAME] = $_POST['name'];
	$data[F_ID_DATABASE_INFO] = $dataid;
	$data[F_SUBJECTIVE_SCORE] = $_POST['score'];
	$data[F_SUBJECTIVE_ANSWER] = $_POST['answer'];
	if($_POST['id'])												//�ж��Ƿ��Ǳ༭����
	{
		$Data->updateData("EE_SUBJECTIVE_INFO",$_POST['id'],$data);
		header("Location:SubList.php?Id=$dataid");
		exit();
	}else{
		$data[F_SUBJECTIVE_ORDER] = 0;
		$Data->insertData("EE_SUBJECTIVE_INFO",$data);
		header("Location:SubList.php?Id=$dataid");
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
<th class=caption height=23><?php echo $title?>��Ŀ</th>
</tr>
<tr>
<td bgColor=#eeeeee><table width="80%" align=center border=0>
<tr>
<td align=right>�������</td>
<td><?php echo $datainfo[F_DATABASE_NAME]?></td>
</tr>
<tr>
<td align=right width="20%">����</td>
<td width="80%">
<INPUT name=name id=name size="50" value="<?php echo $info[F_SUBJECTIVE_NAME]?>">
</td>
</tr>
<tr>
<td align=right>��ֵ</td>
<td><input name="score" type="text" id="score" value="<?php echo $info[F_SUBJECTIVE_SCORE]?>"></td>
</tr>
<tr>
<td align=right>�ο���</td>
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="2" align=center>
<textarea name="answer" cols="80" rows="10" id="answer"><?php echo $info[F_SUBJECTIVE_ANSWER]?></textarea>
</td>
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
function check_data(){
	if(frm_add.name.value == '')									//�жϱ����Ƿ�Ϊ��
	{
		alert("���ⲻ��Ϊ��")
		frm_add.name.focus()
		return false
	}
	if(frm_add.score.value == '')									//�жϷ�ֵ�Ƿ�Ϊ��
	{
		alert("��ֵ����Ϊ��")
		frm_add.score.focus()
		return false
	}
	if(isNaN(parseInt(frm_add.score.value)))							//�жϷ�ֵ�Ƿ�Ϊ����
	{
		alert("��ֵӦ��Ϊ����")
		frm_add.score.focus()
		return false
	}
	if(frm_add.answer.value == '')									//�жϲο����Ƿ�Ϊ��
	{
		alert("�ο��𰸲���Ϊ��")
		frm_add.answer.focus()
		return false
	}
	return true
}
</SCRIPT>
</body>
</html>