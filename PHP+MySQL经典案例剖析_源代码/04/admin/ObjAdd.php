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
	$info = $Data->getInfo($id,'EE_OBJECTIVE_INFO');
	$title = "�༭";
}
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ����ύ����
{
	$data = array();
	$data[F_OBJECTIVE_NAME] = $_POST['name'];
	$data[F_ID_DATABASE_INFO] = $dataid;
	$data[F_OBJECTIVE_SCORE] = number_format($_POST['score'],2);
	$data[F_OBJECTIVE_TYPE] = $_POST['type'];
	if($_POST['id'])												//�ж��Ƿ��Ǳ༭����
	{
		$Data->updateData("EE_OBJECTIVE_INFO",$_POST['id'],$data);
		header("Location:ObjList.php?Id=$dataid");
		exit();
	}else{
		$data[F_OBJECTIVE_ORDER] = 0;
		$data[F_OBJECTIVE_RIGHT] = 0;
		$data[F_OBJECTIVE_WRONG] = 0;	
		$Data->insertData("EE_OBJECTIVE_INFO",$data);
		header("Location:ObjList.php?Id=$dataid");
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
<th class=caption height=23><?php echo $title?>�͹���</th>
</tr>
<tr>
<td bgColor=#eeeeee><table width="70%" align=center border=0>
<tr>
<td align=right>�������</td>
<td><?php echo $datainfo[F_DATABASE_NAME]?></td>
</tr>
<tr>
<td align=right width="18%">����</td>
<td width="82%"><INPUT name=name id=name size="30" value="<?php echo $info[F_OBJECTIVE_NAME]?>"></td>
</tr>
<tr>
<td align=right>����</td>
<td>
<input name="type" type="radio" value="1"
<?php
if($info[F_OBJECTIVE_TYPE] == 1)									//�ж������Ƿ��ǵ�ѡ
	echo " checked";
?>
>
��ѡ
<input type="radio" name="type" value="2"
<?php
if($info[F_OBJECTIVE_TYPE] == 2)									//�ж������Ƿ��Ƕ�ѡ
	echo " checked";
?>
>
��ѡ</td>
</tr>
<tr>
<td align=right>��ֵ</td>
<td><input name="score" type="text" id="score" value="<?php echo $info[F_OBJECTIVE_SCORE]?>"></td>
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
	return true
}
</SCRIPT>
</body>
</html>