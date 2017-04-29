<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once(INCLUDE_PATH . 'User.inc.php');?>
<?php
$User = new User();
$list = array();
$list = $User->GetMenu(0);
$id = $_GET['Id'];
if($id)														//判断是否是编辑状态
{
	$info = $User->getInfo($id,"EM_GROUP_INFO");
}
$MenuId = $_GET['MenuId'];
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if($User->CheckGroupExit($_POST['name']))
	{
		echo "组名称重复<br>";
		echo "<a href='javascript:window.history.back();'>返回</a>";
		exit();
	}
	if($id)													//判断是否是编辑状态
	{
		$data[F_GROUP_NAME] = $_POST['name'];
		$data[F_GROUP_DESCRIPTION] = $_POST['description'];
		$User->updateData("EM_GROUP_NAME",$id,$data);			//更新数据
		$User->DelMenuGroup($id);								//删除原来的组菜单信息
	}else{
		$data[F_GROUP_NAME] = $_POST['name'];
		$data[F_GROUP_DESCRIPTION] = $_POST['description'];
		$id = $User->insertData("EM_GROUP_INFO",$data);			//插入数据
	}
	$User->begintransaction();									//事务处理开始
	if($_POST['main'])											//判断是否提交了主菜单数据
	{
		try {
			foreach($_POST['main'] as $value)						//循环插入主菜单数据
			{
				$data = array();
				$data[F_ID_GROUP_INFO] = $id;
				$data[F_ID_MENU_INFO] = $value;
				$data[F_PARENT_ID] = 0;
				$User->insertData("EE_MENU_GROUP",$data);
			}
		}catch (Exception $e){									//捕获异常
			echo "操作失败";
			echo $e;
			$User->rollback();									//出现异常，回滚
		}
	}
	
	if($_POST['sub'])											//判断是否提交了子菜单数据
	{
		try{
			foreach($_POST['sub'] as $value)						//循环插入子菜单
			{
				list($main,$sub) = explode("_",$value);
				if(!$User->CheckMenuExit($id,$main))				//判断该子菜单的父菜单是否存在
				{
					$data = array();
					$data[F_ID_GROUP_INFO] = $id;
					$data[F_ID_MENU_INFO] = $main;
					$data[F_PARENT_ID] = 0;
					$User->insertData("EE_MENU_GROUP",$data);	//不存在则插入父菜单
				}
				$data = array();
				$data[F_ID_GROUP_INFO] = $id;
				$data[F_ID_MENU_INFO] = $sub;
				$data[F_PARENT_ID] = $main;
				$User->insertData("EE_MENU_GROUP",$data);
			}
		}catch (Exception $e){									//捕获异常
			echo "操作失败";									//输出异常
			echo $e;
			$User->rollback();									//回滚
		}
	}
	$User->commit();											//提交
	echo "操作成功<br>";
	echo "<a href='GroupList.php?MenuId=$MenuId'>返回列表</a>";
	exit();
}
?>
<script language=javascript src='/Js/Base.js'></script>
<form id=form1 name=form1 onSubmit="return Check();" action="" method=post>
<table width="60%" align=center border=0>
  <tr>
    <th class=caption height=23>增加组</th>
  </tr>
  <tr>
    <td bgColor=#eeeeee>
      <table width="88%" align=center border=0>
        <tr>
          <td align=right width="23%">组名称</td>
          <td width="77%"><input id=name maxLength=16 name=name value="<?php echo $info['F_GROUP_NAME']?>"></td></tr>
        <tr>
          <td align=right>组描述</td>
          <td><input name="description" type="text" id="description" size="40" value="<?php echo $info['F_GROUP_DESCRIPTION']?>"></td>
        </tr>          
        <tr>
          <td vAlign=top align=right height=60>所属权限</td>
          <td vAlign=top><table width="100%" border="0">
            <tr>
              <td>
			  <?php
			  foreach($list as $value)
			  {
			  		$check = "";
			  		$sub = array();
			  		$sub = $User->GetMenu($value[F_ID]);
			  		$count = count($sub);
			  		if($id)
			  		{
			  			if($User->CheckMenuExit($id,$value['F_ID']))
			  			{
			  				$check = " checked='checked'";
			  			}
			  		}
			  ?>
			  <div>
			  <input name="main[]" type="checkbox" id="main[]" value="<?php echo $value['F_ID']?>"<?php echo $check?>>
               <?php echo $value[F_MENU_NAME]?>
                  <table width="100%" border="0">
              <?php
              	foreach($sub as $key => $val)
              	{
              		$check = "";
              		if($id)
			  		{
			  			if($User->CheckMenuExit($id,$val['F_ID']))
			  			{
			  				$check = " checked='checked'";
			  			}
			  		}
              		if($key % 2 == 0)
              		{
              ?>
                    <tr>
              <?php
              		}
              ?>
                      <td width="50%" align="left" class="pad">
                      <input name="sub[]" type="checkbox" id="sub[]" value="<?php echo $value[F_ID]?>_<?php echo $val[F_ID]?>"<?php echo $check?>><?php echo $val[F_MENU_NAME]?>
                      </td>
			  <?php
					if($key % 2 == 1)
					{
			?>
                    </tr>			
			<?php
					}
			?>
              <?php
              	}
              	if($key % 2 < 1)
              	{
              		for(;$key % 2 < 1;$key++)
              			echo "<td width=50%>&nbsp;</td>";
              		echo "</tr>";
              	}
              ?>
                  </table>
			  </div>
			  <?php
			  }
			  ?>
			  </td>
            </tr>                  
          </table></td>
        </tr></table></td></tr>
  <tr>
    <th align=middle><input type=submit value=提交 name=Submit> 
</th></tr></table></form>
<script language=JavaScript>
function Check()
{
	if($('name').value.trim() == "")
	{
		alert("请填写组名称");
		$('name').focus();
		return false;
	}
	if($('description').value.trim() == "")
	{
		alert("请填写组描述");
		$('description').focus();
		return false;
	}
	return true;
}
</script>
