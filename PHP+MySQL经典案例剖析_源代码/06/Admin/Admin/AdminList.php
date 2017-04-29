<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once(INCLUDE_PATH . 'User.inc.php');?>
<?php 
$user = new User();
$list = array();
$list = $user->GetAdminList();
?>
<table width="80%" border="0" align="center">
 <tr>
  <td height="30" class="caption">用户管理</td>
 </tr>
 <tr>
  <td height="80">
    <table width="60%" border="0" align="center">
	<tr> 
	 <th width="123" height="23">用户帐号</th>
	 <th width="113">组名称</th>
	 <th width="120">管理</th>
	</tr>
<?php
foreach($list as $key => $value){								//循环显示管理员
	$info = $user->getInfo($value['F_ID_GROUP_INFO'],"EM_GROUP_INFO");
	$admin = "<a href='EditAdmin.php?Id={$value['F_ID']}&MenuId={$_GET['MenuId']}'>[编辑]</a> ";
	if($value['F_ID'] > 1)
		$admin .= "<a href='DelAdmin.php?Id={$value['F_ID']}&MenuId={$_GET['MenuId']}' onclick=\"return confirm('真的要删除此用户吗')\">[删除]</a> ";
	if($key % 2 == 0)
		$bg = "#ffffff";
	else
		$bg = "#eeeeee";
?>
	<tr bgcolor="<?php echo $bg?>"> 
	 <td align="center"><?php echo $value['F_USER_NAME']; ?></td>
	 <td align="center"><?php echo $info['F_GROUP_NAME'] ?></td>
	 <td align="center"><?php echo $admin; ?></td>
	</tr>
<?php
}
?>
   </table>
  </td>
 </tr>
<tr>
    <td align=middle>
	<input onClick="window.location='AddAdmin.php?MenuId=<?php echo $_GET['MenuId']?>'" type=button value=新增管理员 name=Submit> 
</td>
</tr>
</table>
