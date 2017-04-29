<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'User.inc.php'); ?>
<?php
$User = new User();
$id = $_GET['Id'];
$title = "增加";
if($id)															//判断是否是编辑操作
{
	$info = $User->getInfo($id,"EM_USER_INFO");
	$title = "编辑";
}
if($_SERVER['REQUEST_METHOD'] == 'POST')							//判断是否是提交操作
{
	$data = array();
	$data[F_USER_NAME] = $_POST['username'];
	$data[F_USER_NO] = $_POST['no'];
	$data[F_USER_GENDER] = $_POST['gender'];
	$data[F_USER_OTHER] = $_POST['note'];
	if($_POST['pwd'])												//判断是否修改密码
		$data[F_USER_PASSWORD] = md5($_POST['pwd']);
	if($_POST['id'])													//判断是否是编辑操作
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
<title>考试系统管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form id=frm_add name=frm_add onSubmit="return check_data()" action="" method=post>
<table width="70%" align=center border=0>
<tr>
<th class=caption height=23><?php echo $title?>用户</th></tr>
<tr>
<td bgColor=#eeeeee>
<table width="70%" align=center border=0>
<tr>
<td align=right width="18%">学号</td>
<td width="82%">
<INPUT id=no maxLength=16 name=no value="<?php echo $info[F_USER_NO]?>"> 
由3至16个字符组成</td></tr>
<tr>
<td align=right>密码</td>
<td><INPUT id=pwd type=password maxLength=16 name=pwd> 
<?php 
if($id)															//判断是否是编辑操作
	echo "如果不修改密码请保持为空";
else 
	echo "由5至16个字符组成";
?></td></tr>
<tr>
<td align=right>确认密码</td>
<td><INPUT id=pwd2 type=password maxLength=16 name=pwd2> 
再次输入密码</td></tr>
<tr>
<td align=right>姓名</td>
<td>
<input name="username" type="text" id="username" value="<?php echo $info[F_USER_NAME]?>">
</td>
</tr>
<tr>
<td align=right>性别</td>
<td><input name="gender" type="radio" value="0"
<?php 
if($info[F_USER_GENDER] == 0)										//判断是否是男性
	echo " checked"
?>
>
男
<input type="radio" name="gender" value="1"
<?php 
if($info[F_USER_GENDER] == 1)										//判断是否是女性
	echo " checked"
?>
>
女</td>
</tr>
<tr>
<td align=right>备注</td>
<td><input name="note" type="text" id="note" size="40" maxlength="100" value="<?php echo $info[F_USER_OTHER]?>"></td>
</tr>
</table></td></tr>
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
	if(frm_add.no.value == '')											//判断学号是否为空
	{
		alert("学号不能为空")
		frm_add.no.focus()
		return false
	}
	<?php
	if(!$id)														//判断是否是编辑状态
	{
	?>
	if (frm_add.pwd.value.length < 5){									//判断密码长度是否合法
		alert("密码不得小于5个英文字符")
		frm_add.pwd.focus();
		return false
	}
	if (frm_add.pwd.value != frm_add.pwd2.value){							//判断确认密码是否正确
		alert("密码与确认密码不符")
		frm_add.pwd.value = ""
		frm_add.pwd2.value = ""
		frm_add.pwd.focus();
		return false
	}
	<?php
	}
	?>
	if(frm_add.username.value == '')									//判断姓名是否为空
	{
		alert("姓名不能为空")
		frm_add.username.focus()
		return false
	}
	return true
}
</SCRIPT>
</body>
</html>