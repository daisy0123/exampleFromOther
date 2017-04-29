<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Class.inc.php'); ?>
<?php
if(!$_GET['Id'])														//判断是否是编辑操作
	$id = 0;
else 
	$id = $_GET['Id'];
$Class = new ClassModel();
$title = "增加";
if($id)															//判断是否是编辑操作
{
	$info = $Class->getInfo($id,'EM_CLASS_INFO');
	$title = "编辑";
}
if($_SERVER['REQUEST_METHOD'] == 'POST')							//判断是否是提交操作
{
	$data = array();
	$data[F_CLASS_NAME] = $_POST['name'];
	$data[F_CLASS_NOTE] = $_POST['note'];
	if($_POST['id'])													//判断是否是编辑操作
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
<title>考试系统管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form id=frm_add name=frm_add onSubmit="return check_data()" action="" method=post>
<table width="70%" align=center border=0>
<tr>
<th class=caption height=23><?php echo $title?>科目</th></tr>
<tr>
<td bgColor=#eeeeee>
<table width="70%" align=center border=0>
<tr>
<td align=right width="18%">名称</td>
<td width="82%">
<INPUT name=name id=name size="30" value="<?php echo $info[F_CLASS_NAME]?>">
</td>
</tr>
<tr>
<td align=right>备注</td>
<td>
<INPUT name=note id=note size="30" value="<?php echo $info[F_CLASS_NOTE]?>">
</td></tr>
</table></td></tr>
<tr>
<th align=middle><INPUT type=submit value=提交 name=Submit>
  <input name="id" type="hidden" id="id" value="<?php echo $id?>"></th>
</tr>
</table>
</form>
<SCRIPT language=JavaScript>
/**
 * 功能：检测表单
 */
function check_data(){
	if(frm_add.name.value == '')										//判断科目名称是否为空
	{
		alert("名称不能为空")
		frm_add.name.focus()
		return false
	}
	return true
}
</SCRIPT>
</body>
</html>