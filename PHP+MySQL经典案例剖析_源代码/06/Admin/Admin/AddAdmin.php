<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once(INCLUDE_PATH . 'User.inc.php');?>
<?php 
$user = new User();
$group = array();
$group = $user->GetGroupList();
if ($_SERVER['REQUEST_METHOD'] == "POST"){							//判断是否是提交操作
	if(!$user->CheckAdminExist($_POST['username']))						//判断帐号是否存在
	{
		$data = array();
		$data['F_USER_NAME'] = $_POST['username'];
		$data['F_USER_PASSWORD'] = md5($_POST['pwd']);
		$data['F_ID_GROUP_INFO'] = $_POST['groupid'];
		$user->insertData('EM_ADMIN_INFO',$data);						//插入数据
		echo "添加成功";
		echo "<br><a href='AdminList.php?MenuId={$_GET['MenuId']}'>返回管理员列表</a>";
		exit();
	}else{														//存在则提示
		echo "管理员帐号已存在";
	}
}
?>
<script language="javascript" src="/Js/Base.js"></script>
<form action="" method="post" name="form1" id="form1" onsubmit="return check_data()">
 <table width="70%" border="0" align="center">
  <tr>
   <th height="23" class="caption">增加管理员</th>
  </tr>
  <tr>
   <td bgcolor="#eeeeee"> 
	<table width="70%" border="0" align="center">
	 <tr> 
	  <td width="18%" align="right">帐号</td>
	  <td width="82%"><input name="username" type="text" id="username" maxlength="16">
	    由3至16个字符组成</td>
	 </tr>
	 <tr> 
	  <td align="right">密码</td>
	  <td><input name="pwd" type="password" id="pwd" maxlength="16">
	   由5至16个字符组成</td>
	 </tr>
	 <tr> 
	  <td align="right">确认密码</td>
	  <td><input name="pwd2" type="password" id="pwd2" maxlength="16">
	   再次输入密码</td>
	 </tr>
	 <tr> 
	  <td align="right">用户组</td>
	  <td><select name="groupid" id="groupid">
	  <option value="">请选择</option>
<?php
foreach($group as $value)											//循环输出用户组选项
{
	$html = "<option value='{$value['F_ID']}'";
	$html .= ">{$value['F_GROUP_NAME']}</option>";
	echo $html;
}
?>
	   </select></td>
	 </tr>
	</table></td>
  </tr>
  <tr>
   <th align="center"><input type="submit" name="Submit" value="提交"> </th>
  </tr>
 </table>
</form>
<script language="JavaScript">
/**
 * 功能：检测表单元素
 * 返回：TRUE OR FALSE
 */
function check_data(){
	if($('username').value.trim() == "")									//判断帐号是否为空
	{
		alert("帐号不能为空");
		$('username').focus();
		return false;
	}
	if ($('username').value.trim().len() < 3)								//判断帐号是否过短
	{
		alert("帐号不得小于3个字符");
		$('username').username.focus();
		return false;
	}
	if($('username').value.trim().len() > 16)								//判断帐号是否过长
	{
		alert("帐号不得大于16个字符");
		$('username').focus();
		return false;
	}
	if ($('pwd').value.trim().len() < 5){									//判断密码是否过短
		alert("密码不得小于5个字符");
		$('pwd').focus();
		return false;
	}
	if ($('pwd').value.trim().len() > 16){									//判断密码是否过长
		alert("密码不得大于16个字符");
		$('pwd').focus();
		return false
	}	
	if ($('pwd').value != $('pwd2').value){									//判断两次密码是否一致
		alert("密码与确认密码不符");
		$('pwd').focus();
		return false;
	}
	if($('groupid').options[$('groupid').selectedIndex].value == "")				//判断是否选择了用户组
	{
		alert("请选择用户组");
		return false;
	}
	return true
}
</script>
