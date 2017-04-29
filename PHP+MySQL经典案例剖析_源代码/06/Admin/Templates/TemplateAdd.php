<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'Template.inc.php'); ?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$Temp = new Temp();
$News = new News();
$class_list = array();
$News->GetClassListAll();
$html = " checked";
$character = " checked";
$rec_no = " checked";
$hot_no = " checked";
$new_no = " checked";
$branch_no = " checked";
$status_yes = " checked";
if($_GET['Id'])													//判断是否是编辑状态
{
	$info = $Temp->getInfo($_GET['Id'],"EE_TEMPLATE_INFO");
	if($info['F_TMP_WAY'] == 0)						 			//设置生成方式的默认选项
	{
		$js = " checked";
		$html = "";
	}
	if($info['F_TMP_TYPE'] == 0)									//设置模块类型的默认选项
	{
		$pic = " checked";
		$character = "";
	}
	if($info['F_TMP_RECOMMEND'] == 1)							//设置推荐的默认选项
	{
		$rec_yes = " checked";
		$rec_no = "";
	}
	if($info['F_TMP_HOT'] == 1)									//设置热点的默认选项
	{
		$hot_yes = " checked";
		$hot_no = "";
	}
	if($info['F_TMP_IS_NEW'] == 1)								//设置快讯的默认选项
	{
		$new_no = "";
		$new_yes = " checked";
	}
	if($info['F_TMP_IS_BRANCH'] == 1)								//设置分行的默认选项
	{
		$branch_no = "";
		$branch_yes = " checked";
	}
	if($info['F_TMP_STATUS'] == 1)								//设置模块状态的默认选项
	{
		$status_yes = "";
		$status_no = " checked";
	}
}
if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否为提交操作
{
	if($Temp->AddTemplate($_GET['Id'],$_POST))						//判断是否操作成功
	{
		echo "操作成功<br>";
		echo "<a href='TemplateList.php?id={$_GET['ClassId']}&MenuId={$_GET['MenuId']}'>返回列表</a>";
		exit();
	}
}
?>
<script lanuage='javascript' src='/Js/Base.js'></script>
<p align="center"><b>添加模块<b></p>
<form name="form1" method="post" action="" onSubmit="return check()">
  <table width="80%"  border="0" align="center">
    <tr>
      <td bgcolor="#CCCCCC"><table width="100%"  border="0">
        <tr>
          <td width="22%" align="right">模块生成方式</td>
          <td colspan="2"><input name="way" type="radio" value="1"<?php echo $html?>>
            HTML
              <input type="radio" name="way" value="0"<?php echo $js?>>
            JS</td>
        </tr>
        <tr>
          <td align="right">模块类型</td>
          <td colspan="2"><input name="type" type="radio" value="1"<?php echo $character?>>
            文字
            <input type="radio" name="type" value="0"<?php echo $pic?>>
            图片(文字)</td>
        </tr>
        <tr>
          <td align="right">所属类别</td>
          <td colspan="2">
          <?php
			echo "<select name='news_class' id='news_class'>";
			echo "<option value='0'>请选择</option>";
			foreach($class_list as $class)								//循环显示栏目列表
			{
				echo "<option value='{$class['id']}'";
				if($class['id'] == $info['F_NEWS_CLASS'])					//显示默认选项
					echo " selected='selected'";
				echo ">{$class['class']}</option>";
			}
			echo "</select>";  
		  ?>
          </td>
        </tr>
        <tr>
          <td align="right">模块名称</td>
          <td colspan="2"><input name="name" type="text" id="name" size="30" value="<?php echo $info['F_TMP_NAME']?>"></td>
        </tr>
        <tr>
          <td align="right">显示信息数量</td>
          <td colspan="2"><input name="news_count" type="text" id="news_count" size="10" value="<?php echo $info['F_TMP_NEWS_COUNT']?>">
            条</td>
        </tr>
        <tr>
          <td align="right">信息分列</td>
          <td colspan="2"><select name="news_row" id="news_row">
			<?php
			for($i = 1;$i <= 10;$i++)									//显示信息分列选项
			{
				echo "<option value='$i'";
				if($i == $info['F_TMP_NEWS_ROW'])					//设置默认选项
					echo " selected";
				echo ">$i</option>";
			}
			?>
          </select>
            列</td>
        </tr>
        <tr>
          <td align="right">显示标题长度</td>
          <td colspan="2"><input name="cap_len" type="text" id="cap_len" value="<?php echo $info['F_TMP_CAP_LEN']?>">
            字符</td>
        </tr>
        <tr>
          <td align="right">显示内容长度</td>
          <td width="31%"><input name="con_len" type="text" id="con_len" value="<?php echo $info['F_TMP_CON_LEN']?>">
            字符</td>
          <td width="47%">前
            <input name="con_count" type="text" id="con_count" value="<?php echo $info['F_TMP_CON_COUNT']?>">
            条显示</td>
          </tr>
        <tr>
          <td align="right">绑定文件</td>
          <td colspan="2"><input name="template_url" type="text" id="template_url" size="40" value="<?php echo $info['F_TMP_URL']?>">
            <input type="button" name="Submit" value="请选择.." style="BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; BORDER-BOTTOM-WIDTH: 1px; BORDER-RIGHT-WIDTH: 1px" onClick="select_template()"></td>
          </tr>
        <tr>
          <td align="right">推荐</td>
          <td colspan="2"><input name="recommend" type="radio" value="0"<?php echo $rec_no?>>
            否
            <input type="radio" name="recommend" value="1"<?php echo $rec_yes?>>
            是</td>
        </tr>
        <tr>
          <td align="right">热点</td>
          <td colspan="2"><input name="hot" type="radio" value="0"<?php echo $hot_no?>>
            否
            <input type="radio" name="hot" value="1"<?php echo $hot_yes?>>
            是</td>
        </tr>
        <tr>
          <td align="right">快讯</td>
          <td colspan="2"><input name="new" type="radio" value="0"<?php echo $new_no?>>
            否
            <input type="radio" name="new" value="1"<?php echo $new_yes?>>
            是</td>
        </tr>
        <tr>
          <td align="right">分行</td>
          <td colspan="2"><input name="branch" type="radio" value="0"<?php echo $branch_no?>>
            否
            <input type="radio" name="branch" value="1"<?php echo $branch_yes?>>
            是</td>
          </tr>
        <tr>
          <td align="right">状态</td>
          <td colspan="2"><input name="state" type="radio" value="1"<?php echo $status_yes?>>
            正常更新
            <input type="radio" name="state" value="0"<?php echo $status_no?>>
            保留</td>
          </tr>
        <tr>
          <td align="right" valign="top">模块说明</td>
          <td colspan="2"><textarea name="note" cols="40" rows="6" id="note"><?php echo $info['F_TMP_NOTE']?></textarea></td>
          </tr>
        <tr>
          <td colspan="3" align="center" valign="top"><input type="submit" name="Submit" value=" 提交 ">&nbsp;
            <input type="reset" name="Submit" value=" 清除 "><input type='hidden' name='class_id' value='<?php echo $_GET['ClassId']?>'></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
<script language="JavaScript" type="text/JavaScript">
function check()
{
	if($('news_class').value == 0)								//判断所属栏目是否为空
	{
		alert("请选择所属栏目")
		$('class_id').focus()
		return false
	}
	if($('name').value.trim() == '')								//判断模块名称是否为空
	{
		alert("请填写模块名称")
		$('name').focus()
		return false
	}
	if($('news_count').value.trim() == '')							//判断信息数量是否为空
	{
		alert("请填写信息数量")
		$('news_count').focus()
		return false
	}
	if($('cap_len').value.trim == '')								//判断标题长度是否为空
	{
		alert("请填写标题长度")
		$('cap_len').focus()
		return false
	}
	if($('template_url').value.trim == '')							//判断绑定文件是否为空
	{
		alert("请选择绑定文件")
		$('template_url').focus()
		return false
	}
return true
}
/**
 * 弹出模板选择对话框
 */
function select_template(){
	var w	=650;h=550;
	var theDes	="status:no;center:yes;help:no;minimize:yes;maximize:yes;dialogWidth:"+w+"px;scroll:auto;dialogHeight:"+h+"px;border:think";
	var rv	=window.showModalDialog("Select.php",null,theDes);
	if(rv){
		document.form1.template_url.value = rv;
	}
}
</script>
