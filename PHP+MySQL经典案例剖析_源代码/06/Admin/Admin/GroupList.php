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
    <TD class=caption height=30>�����</TD>
  </TR>
  <TR>
    <TD height=80>
      <TABLE width="90%" align=center border=0>
        <TR>
          <TH width=94 height=23>������</TH>
          <TH width=291>������</TH>
          <TH width=88>����</TH></TR>
<?php
foreach($list as $value)											//ѭ���������Ϣ
{
	if($value['F_ID'] == 1)										//�ж��Ƿ���Ĭ����
	{
		$admin = "[Ĭ����]";
	}else{ 
		$admin = "<A href='AddGroup.php?Id={$value[F_ID]}&MenuId=$MenuId'>[�༭]</A>";
		$admin .= " <A href='DelGroup.php?Id={$value[F_ID]}&MenuId=$MenuId' onclick=\"return confirm('���Ҫɾ����Ȩ����')\">[ɾ��]</A>";
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
    <TD align=middle><INPUT onClick="window.location='AddGroup.php?MenuId=<?php echo $MenuId?>'" type=button value=������ name=Submit> 
    </TD>
  </TR>
</TABLE>
