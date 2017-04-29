<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
$dataid = $_GET['DataId'];
$objid = $_GET['ObjId'];
$id = $_GET['Id'];
$title = "添加";
if($id)														//判断是否是编辑操作
{
	$info = $Data->getInfo($id,"EE_OBJECTIVE_ITEM");
	$title = "编辑";	
}
$objinfo = $Data->getInfo($objid,"EE_OBJECTIVE_INFO");
if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否是提交操作
{
	if($objinfo[F_OBJECTIVE_TYPE] == 1 and $_POST['isright'])			//判断是单选和是正确答案
	{
		$Data->UpdateRightItem($objid);							//单选只能保留一个正确答案
	}
	$data = array();
	$data[F_ID_OBJECTIVE_INFO] = $objid;
	$data[F_ITEM_NAME] = $_POST['name'];
	$data[F_ITEM_IS_RIGHT] = $_POST['isright'];		
	if($_POST['id'])												//判断是否是编辑操作
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
<title>考试系统管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form id=frm_add name=frm_add onSubmit="return check_data()" action="" method=post>
<table width="70%" align=center border=0>
<tr>
<th class=caption height=23>添加选项</th>
</tr>
<tr>
<td bgColor=#eeeeee><table width="80%" align=center border=0>
<tr>
<td align=right>所属题目</td>
<td><?php echo $objinfo[F_OBJECTIVE_NAME]?></td>
</tr>
<tr>
<td align=right width="20%">选项</td>
<td width="80%"><INPUT name=name id=name size="30" value="<?php echo $info[F_ITEM_NAME]?>"></td>
</tr>
<tr>
<td align=right>是否是正确答案</td>
<td>
<input name="isright" type="radio" value="1"
<?php
if($info[F_ITEM_IS_RIGHT] == 1)									//判断是否是正确答案
echo " checked";
?>
>
是
<input type="radio" name="isright" value="0"
<?php
if($info[F_ITEM_IS_RIGHT] == 0)									//判断是否是错误答案
echo " checked";
?>
>
否</td>
</tr>

</table></td>
</tr>
<tr>
<th align=middle><INPUT type=submit value=提交 name=Submit>
<input name="id" type="hidden" id="id" value="<?php echo $id?>"></th>
</tr>
</table>
</form>
<SCRIPT language=JavaScript>
function check_data(){
	if(frm_add.name.value == '')									//判断选项是否为空
	{
		alert("选项不能为空")
		frm_add.name.focus()
		return false
	}
	return true
}
</SCRIPT>
</body>
</html>