<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
$dataid = $_GET['DataId'];
$objid = $_GET['ObjId'];
$id = $_GET['Id'];
$title = "���";
if($id)														//�ж��Ƿ��Ǳ༭����
{
	$info = $Data->getInfo($id,"EE_OBJECTIVE_ITEM");
	$title = "�༭";	
}
$objinfo = $Data->getInfo($objid,"EE_OBJECTIVE_INFO");
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ����ύ����
{
	if($objinfo[F_OBJECTIVE_TYPE] == 1 and $_POST['isright'])			//�ж��ǵ�ѡ������ȷ��
	{
		$Data->UpdateRightItem($objid);							//��ѡֻ�ܱ���һ����ȷ��
	}
	$data = array();
	$data[F_ID_OBJECTIVE_INFO] = $objid;
	$data[F_ITEM_NAME] = $_POST['name'];
	$data[F_ITEM_IS_RIGHT] = $_POST['isright'];		
	if($_POST['id'])												//�ж��Ƿ��Ǳ༭����
	{
		$Data->updateData("EE_OBJECTIVE_ITEM",$_POST['id'],$data);
		header("Location:ItemList.php?DataId=$dataid&Id=$objid ");
		exit();
	}else{
		$data[F_ITEM_ORDER] = 0;		
		$Data->insertData("EE_OBJECTIVE_ITEM",$data);
		header("Location:ItemList.php?DataId=$dataid&Id=$objid ");
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
<th class=caption height=23>���ѡ��</th>
</tr>
<tr>
<td bgColor=#eeeeee><table width="80%" align=center border=0>
<tr>
<td align=right>������Ŀ</td>
<td><?php echo $objinfo[F_OBJECTIVE_NAME]?></td>
</tr>
<tr>
<td align=right width="20%">ѡ��</td>
<td width="80%"><INPUT name=name id=name size="30" value="<?php echo $info[F_ITEM_NAME]?>"></td>
</tr>
<tr>
<td align=right>�Ƿ�����ȷ��</td>
<td>
<input name="isright" type="radio" value="1"
<?php
if($info[F_ITEM_IS_RIGHT] == 1)									//�ж��Ƿ�����ȷ��
echo " checked";
?>
>
��
<input type="radio" name="isright" value="0"
<?php
if($info[F_ITEM_IS_RIGHT] == 0)									//�ж��Ƿ��Ǵ����
echo " checked";
?>
>
��</td>
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
	if(frm_add.name.value == '')									//�ж�ѡ���Ƿ�Ϊ��
	{
		alert("ѡ���Ϊ��")
		frm_add.name.focus()
		return false
	}
	return true
}
</SCRIPT>
</body>
</html>