<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
if(!$_GET['Id'])													//判断是否是编辑操作
	$id = 0;
else 
	$id = $_GET['Id'];
$dataid = $_GET['DataId'];
$Data = new Data();
$datainfo = $Data->getInfo($dataid,"EE_DATABASE_INFO");
$title = "增加";
if($id)														//判断是否是编辑操作
{
	$info = $Data->getInfo($id,'EE_SUBJECTIVE_INFO');
	
	$title = "编辑";
}
if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否是提交操作
{
	$data = array();
	$data[F_SUBJECTIVE_NAME] = $_POST['name'];
	$data[F_ID_DATABASE_INFO] = $dataid;
	$data[F_SUBJECTIVE_SCORE] = $_POST['score'];
	$data[F_SUBJECTIVE_ANSWER] = $_POST['answer'];
	if($_POST['id'])												//判断是否是编辑操作
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
<title>考试系统管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form id=frm_add name=frm_add onSubmit="return check_data()" action="" method=post>
<table width="70%" align=center border=0>
<tr>
<th class=caption height=23><?php echo $title?>题目</th>
</tr>
<tr>
<td bgColor=#eeeeee><table width="80%" align=center border=0>
<tr>
<td align=right>所属题库</td>
<td><?php echo $datainfo[F_DATABASE_NAME]?></td>
</tr>
<tr>
<td align=right width="20%">标题</td>
<td width="80%">
<INPUT name=name id=name size="50" value="<?php echo $info[F_SUBJECTIVE_NAME]?>">
</td>
</tr>
<tr>
<td align=right>分值</td>
<td><input name="score" type="text" id="score" value="<?php echo $info[F_SUBJECTIVE_SCORE]?>"></td>
</tr>
<tr>
<td align=right>参考答案</td>
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
<th align=middle><INPUT type=submit value=提交 name=Submit>
<input name="id" type="hidden" id="id" value="<?php echo $id?>"></th>
</tr>
</table>
</form>
<SCRIPT language=JavaScript>
function check_data(){
	if(frm_add.name.value == '')									//判断标题是否为空
	{
		alert("标题不能为空")
		frm_add.name.focus()
		return false
	}
	if(frm_add.score.value == '')									//判断分值是否为空
	{
		alert("分值不能为空")
		frm_add.score.focus()
		return false
	}
	if(isNaN(parseInt(frm_add.score.value)))							//判断分值是否为数字
	{
		alert("分值应该为数字")
		frm_add.score.focus()
		return false
	}
	if(frm_add.answer.value == '')									//判断参考答案是否为空
	{
		alert("参考答案不能为空")
		frm_add.answer.focus()
		return false
	}
	return true
}
</SCRIPT>
</body>
</html>