<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Class.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
if(!$_GET['Id'])													//判断是否是编辑操作
	$id = 0;
else 
	$id = $_GET['Id'];
$Data = new Data();
$Class = new ClassModel();
$ClassList = $Class->GetClassList();
if(!$ClassList)													//判断是否已经添加了科目
{
	echo "请先添加科目<br>";
	echo "<a href='ClassAdd.php'>点击添加科目</a>";
	exit;
}
$title = "增加";
if($id)														//判断是否是编辑操作
{
	$info = $Data->getInfo($id,'EE_DATABASE_INFO');
	$title = "编辑";
}
if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否是提交操作
{
	$data = array();
	$data[F_DATABASE_NAME] = $_POST['name'];
	$data[F_ID_CLASS_INFO] = $_POST['class_id'];
	$data[F_DATABASE_NOTE] = $_POST['note'];
	$data[F_DATABASE_TIME] = time();
	if($_POST['id'])												//判断是否是编辑操作
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
<title>考试系统管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form id=frm_add name=frm_add onSubmit="return check_data()" action="" method=post>
<table width="70%" align=center border=0>
<tr>
<th class=caption height=23><?php echo $title?>题库</th>
</tr>
<tr>
<td bgColor=#eeeeee><table width="70%" align=center border=0>
<tr>
<td align=right width="18%">题库名称</td>
<td width="82%">
<INPUT name=name id=name size="30" value="<?php echo $info[F_DATABASE_NAME]?>">
</td>
</tr>
<tr>
<td align=right>所属科目</td>
<td><select name="class_id" id="class_id">
<?php
foreach($ClassList as $value)										//循环显示科目选择下拉框
{
	if($value[F_ID] == $info[F_ID_CLASS_INFO])						//设置默认选项
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
<td align=right>备注</td>
<td><INPUT name=note id=note size="30" value="<?php echo $info[F_DATABASE_NOTE]?>"></td>
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
/**
 * 功能：表单检测
 */
function check_data(){
	if(frm_add.name.value == '')									//判断名称是否为空
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