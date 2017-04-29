<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once(INCLUDE_PATH . 'User.inc.php');?>
<?php 
$user = new User();
$group = array();
$group = $user->GetGroupList();
$info = $user->getInfo($_GET['Id'],"EM_ADMIN_INFO");
if ($_SERVER['REQUEST_METHOD'] == "POST"){							//判断是否是提交操作
	$data = array();
	$data['F_USER_PASSWORD'] = md5($_POST['pwd']);
	$data['F_ID_GROUP_INFO'] = $_POST['groupid'];
	$user->updateData('EM_ADMIN_INFO',$_GET['Id'],$data);				//更新数据
	echo "编辑成功";
	echo "<br><a href='AdminList.php?MenuId={$_GET[‘MenuId’]}'>返回管理员列表</a>";
	exit();
}
?>
<script language="javascript" src="/Js/Base.js"></script>
<form action="" method="post" name="form1" id="form1" onsubmit="return check_data()">
 <table width="70%" border="0" align="center">
  <tr>
   <th height="23" class="caption">编辑管理员</th>
  </tr>
  <tr>
   <td bgcolor="#eeeeee"> 
	<table width="70%" border="0" align="center">
	 <tr> 
	  <td width="18%" align="right">帐号</td>
	  <td width="82%"><?php echo $info['F_USER_NAME']?></td>
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
	if($value['F_ID'] == $info['F_ID_GROUP_INFO'])						//判断输出默认选项
		$html .= " selected='selected'";
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
