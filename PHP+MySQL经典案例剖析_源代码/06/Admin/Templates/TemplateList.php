<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'Template.inc.php'); ?>
<?php
$Temp = new Temp();
if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否是提交操作
{
	if($_POST['del_id'])											//判断是否选择了模块
	{
		foreach($_POST['del_id'] as $id)							//循环删除模块
			$Temp->delData($id,"EE_TEMPLATE_INFO");
	}
}
$List = array();
$List = $Temp->GetTempList($_GET['id']);
$Info = $Temp->getInfo($_GET['id'],"EM_CLASS_INFO");
?>
<form name="form1" method="post" action="">
  <table width="98%" border="0" align="center" cellspacing="0">
	<tr> 
	  <td colspan="2" class="caption">模 块 管 理</td>
	</tr>
	<tr> 
	  <td class="stress">当前类别：<?php echo $Info['F_CLASS_NAME'] ?></td>
	  <td class="stress">&nbsp;</td>
	</tr>
	<tr> 
	  <td colspan="2"> <table width="100%" border="0">
          <tr> 
            <th width="24"> <input name="allbox" type="checkbox" id="allbox" onClick="CA();" value="1"></th>
            <th width="190">模块名称</th>
            <th width="183">模块说明</th>
            <th width="84">模块类型</th>
            <th width="154">代码</th>
            <th width="102">管理</th>
          </tr>
          <?php
foreach($List as $key => $l){										//循环显示模块信息
	extract($l);
	$bgstr = "bgcolor=" . ($key % 2 ? "#eeeeee" : "#ffffff");
?>
          <tr <?php echo $bgstr ?>> 
            <td align="center"> <?php echo "<input type='checkbox' name='del_id[]' value='$F_ID'>" ?> 
            </td>
            <td> <?php echo $F_TMP_NAME ?> </td>
            <td align="center"> <?php echo $F_TMP_NOTE ?> </td>
            <td align="center"> <?php echo ($F_TMP_TYPE) ? "文字" : "图片(文字)" ?> </td>
            <td align="center"><?php echo "[".$F_TMP_NAME ."]"?></td>
            <td align="center"><a href="TemplateAdd.php?Id=<?php echo $F_ID ?>&ClassId=<?php echo $_GET['id']?>&MenuId=<?php echo $_GET['MenuId']?>">[修改]</a> 
              <a href="#" onClick="javascript:view('<?php echo $F_ID ?>','<?php echo $_GET['MenuId']?>')">[预览]</a></td>
          </tr>
          <?php
}
?>
        </table></td>
	</tr>
	<tr> 
	  <th colspan="2"> <input name="cmdAdd" type="button" id="cmdAdd" value="添加模块" onClick="window.location='TemplateAdd.php?ClassId=<?php echo $_GET['id']?>&MenuId=<?php echo $_GET['MenuId']?>'">
      &nbsp;<input type="submit" name="Submit" value="删除模块"></th>
	</tr>
</table>
</form>
<script language="JavaScript">
/**
 * 功能：实现全选功能
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;
	}
}
/**
 * 功能：弹出预览对话框
 */
function view(ID,MENUID){
	var w=650;h=550;
	var theDes	="status:no;center:yes;help:no;minimize:yes;maximize:yes;dialogWidth:"+w+"px;scroll:auto;dialogHeight:"+h+"px;border:think";
	window.showModalDialog("TemplateView.php?Id=" + ID + "&MenuId=" + MENUID,null,theDes);
}
</script>
