<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once(INCLUDE_PATH . 'User.inc.php');?>
<?php
$User = new User();
$list = array();
$list = $User->GetGroupList();
$MenuId = $_GET['MenuId'];
?>
<TABLE width="70%" align=center border=0>
  <TR>
    <TD class=caption height=30>组管理</TD>
  </TR>
  <TR>
    <TD height=80>
      <TABLE width="90%" align=center border=0>
        <TR>
          <TH width=94 height=23>组名称</TH>
          <TH width=291>组描述</TH>
          <TH width=88>管理</TH></TR>
<?php
foreach($list as $value)											//循环输出组信息
{
	if($value['F_ID'] == 1)										//判断是否是默认组
	{
		$admin = "[默认组]";
	}else{ 
		$admin = "<A href='AddGroup.php?Id={$value[F_ID]}&MenuId=$MenuId'>[编辑]</A>";
		$admin .= " <A href='DelGroup.php?Id={$value[F_ID]}&MenuId=$MenuId' onclick=\"return confirm('真的要删除此权限吗')\">[删除]</A>";
	}
?>
        <TR bgColor=#eeeeee>
          <TD align=middle bgcolor="#eeeeee"><?php echo $value['F_GROUP_NAME']?></TD>
          <TD><?php echo $value['F_GROUP_DESCRIPTION'] ?></TD>
          <TD align=middle><?php echo $admin?></TD>
        </TR>
<?php
}
?>
        </TABLE>
  		</TD>
  </TR>
  <TR>
    <TD align=middle><INPUT onClick="window.location='AddGroup.php?MenuId=<?php echo $MenuId?>'" type=button value=新增组 name=Submit> 
    </TD>
  </TR>
</TABLE>
