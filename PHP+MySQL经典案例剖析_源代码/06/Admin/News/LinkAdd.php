<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php require_once (INCLUDE_PATH . 'function.inc.php'); ?>
<?php
$News = new News();
$info = $News->getInfo($_GET['id'],"EM_LINK_INFO");
if ($_SERVER["REQUEST_METHOD"] == "POST"){						//判断是否提交操作
	$data['F_LINK_NAME'] = $_POST['name'];
	$data['F_LINK_URL'] = $_POST['url'];
	$data['F_LINK_COLOR'] = $_POST['color'];
	if($_GET['id'])												//判断是否为编辑状态
	{
		$News->updateData("EM_LINK_INFO",$_GET['id'],$data);		//处理编辑信息
	}else{
		$News->insertData("EM_LINK_INFO",$data);					//处理添加信息
	}
	echo "操作成功<br><a href='LinkList.php?MenuId={$_GET['MenuId']}'>返回列表</a>";
	exit;
}
?>
<script language="javascript" src="/Js/Base.js"></script>
<form action="" method="post" name="form1" onsubmit="return check_data();">
<p align="center" class="caption">添 加 链 接</p>
  <table width="70%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td bgcolor="#CCCCCC"><table width="100%"  border="0" cellpadding="0" cellspacing="1">
        <tr>
          <th>&nbsp;</th>
        </tr>
        <tr>
          <td height="60" bgcolor="#FFFFFF"><table width="80%"  border="0" align="center">
            <tr>
              <td width="28%" align="right">链接文字：</td>
              <td width="72%"><input name="name" type="text" id="name" size="30" value="<?php echo $info['F_LINK_NAME']?>"></td>
            </tr>
            <tr>
              <td align="right">链接地址：</td>
              <td><input name="url" type="text" id="url" size="30" value="<?php echo $info['F_LINK_URL']?>"></td>
            </tr>
            <tr>
              <td align="right">链接颜色：</td>
              <td><input name="color" type="text" id="color" value="<?php echo $info['F_LINK_COLOR']?>"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <th><input type="submit" name="Submit" value="提交">&nbsp;
            <input type="reset" name="Submit" value="重置"></th>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<script language="JavaScript" type="text/JavaScript">
function check_data()											//检测表单信息
{
	if($('name').value.trim() == "")									//判断连接文字是否为空
	{
		alert("请填写连接文字")
		$('name').focus()
		return false
	}
	
	if($('url').value.trim() == "")										//判断连接地址是否为空
	{
		alert("请填写连接地址")
		$('url').focus()
		return false
	}
return true
}
</script>
