<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$sql = "SELECT * FROM EM_INDEX_INFO";
$r = $News->select($sql);
$info = $r[0];
if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否为提交操作
{
	$data['F_INDEX_NAME'] = $_POST['file_name'];
	$data['F_INDEX_TEMPLATE_URL'] = $_POST['template_url'];
	if($info)													//判断是否为编辑状态
	{
		$sql = "UPDATE EM_INDEX_INFO SET F_INDEX_NAME = {$_POST['file_name']}";
		$sql .= ",F_INDEX_TEMPLATE_URL = ‘{$_POST['template_url']}’;";
		if($News->update ($sql))									//判断是否操作成功
		{
			echo "设置成功<br>";
			echo "<a href='Index.php?MenuId={$_GET['MenuId']}'>返回首页设置</a>";
			exit;
		}
	}else{
		if($News->insertData("EM_INDEX_INFO",$data))				//判断是否操作成功
		{
			echo "设置成功<br>";
			echo "<a href='Index.php?MenuId={$_GET['MenuId']}'>返回首页设置</a>";
			exit;
		}
	}
}
?>
<script language="javascript" src="/Js/Base.js"></script>
<form name="myform" action="" method="post">
<table width="80%" border="0" align="center">
  <tr>
    <td height="30" class="caption">首页设置</td>
  </tr>
  <tr>
    <td height="80"><table width="75%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#666666"><table width="100%"  border="0">
          <tr>
            <td width="26%" height="25" align="center"><span style="color: #FFCC00">首页模板</span></td>
            <td width="74%"><input name="template_url" type="text" id="template_url" size="30" value="<?php echo $info['F_INDEX_TEMPLATE_URL']?>">
              <input type="button" name="Submit" value="选择模板.." style="BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; BORDER-BOTTOM-WIDTH: 1px; BORDER-RIGHT-WIDTH: 1px" onClick="select_template()"></td>
          </tr>
          <tr>
            <td height="25" align="center"><span style="color: #FFCC00">文件名称</span></td>
            <td><input name="file_name" type="text" id="file_name" value="<?php echo $info[F_INDEX_NAME]?>"></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><input type="submit" name="Submit" value="提 交">
    &nbsp;<input type="button" name="Submit" value="刷 新" onClick="window.location='GenIndex.php?MenuId=<?php echo $_GET['MenuId']?>'">
    </td>
  </tr>
</table>
</form>
<script language='javascript'>
function check_data(){
	if ($('template_url').value.trim() == ''){								//判断首页模板是否为空
		alert("首页模板不能为空");
		$('template_url').focus();
		return false;
	}
	if ($('file_name').value.trim() == ''){								//判断文件名是否为空
		alert("文件名称不能为空");
		$('file_name').focus();
		return false;
	}
	return true;
}
/**
 * 弹出模板选择网页对话框
 */
function select_template(){
	var w=650;h=550;
	var theDes	="status:no;center:yes;help:no;minimize:yes;maximize:yes;dialogWidth:"+w+"px;scroll:auto;dialogHeight:"+h+"px;border:think";
	var rv	=window.showModalDialog("../Template/Select.php",null,theDes);
	if(rv){
		document.myform.template_url.value = rv;
	}
}
</script>
