<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
if(!$_GET['id'])
	$id = 0;
else 
	$id = $_GET['id'];
$News = new News();
$class_list = array();
$News->GetClassListAll();
$class_id = $_GET['ClassId'];
if($id)														//判断是否有编辑栏目ID
{
	$info = $News->getInfo($id,'EM_CLASS_INFO');
	list($front,$back) = explode(".",$info['F_CLASS_INDEX_NAME']);
}
?>
<script language="javascript" src="/Js/Base.js"></script>
<form name="frmClass" method="post" action="ClassAddOk.php?MenuId=<?php echo $_GET['MenuId']?>" onsubmit="return check_data()">
  <table width=90% align="center" cellpadding=4 cellspacing=1>
	<tbody>
	  <td align="center"><font color="#6699FF"><strong>新增栏目 - 新闻栏目管理</strong></font></td>
	</tr>
	<td height="15"> <table width="85%" border="0" align="center" bordercolorlight="#5598DA" bordercolordark="#ffffff" bgcolor="#eeeeee">
	  <tr>
        <td height="25" align="right">所属栏目</td>
        <td height="25">
        <?php
		if($class_id)													//判断是否有父ID
		{ 
			echo "<select name='parent_id' id='parent_id'>";
			echo "<option value='0'>请选择</option>";
			foreach($class_list as $class)								//循环显示栏目列表
			{
				echo "<option value='{$class['id']}'";
				if($class['id'] == $class_id)									//显示默认选项
					echo " selected='selected'";
				echo ">{$class['class']}</option>";
			}
			echo "</select>";
		}else	{
			echo "<font color='red'>根类别</font>";
		}
		?>
		</td>
	    </tr>
          <tr> 
            <td width="256" height="25" align="right">栏目名称</td>
            <td width="435" height="25"><input name="name" type="text" id="name" size="20" maxlength="12" value="<?php echo $info['F_CLASS_NAME']?>"></td>
          </tr>
          <tr> 
            <td height="25" align="right">说明</td>
            <td height="25"><input name="note" type="text" id="note" size="30" maxlength="25" value="<?php echo $info['F_CLASS_NOTE']?>"> 
            </td>
          </tr>
          <tr>
            <td height="25" align="right">栏目目录名称</td>
            <td height="25"><input name="url" type="text" id="url" value="<?php echo $info['F_CLASS_URL_NAME']?>">
            (英文)</td>
          </tr>
          <tr>
            <td height="25" align="right">栏目首页文件名</td>
            <td height="25"><input name="front" type="text" id="front" size="8" value="<?php echo $front?>">
              .
              <input name="back" type="text" id="back" size="8" value="<?php echo $back?>"></td>
          </tr>
          <tr>
            <td height="25" align="right">栏目首页模板路径</td>
            <td height="25"><input name="template_url" type="text" id="template_url" size="40" value="<?php echo $info['F_CLASS_TEMPLATE_URL']?>"><input type="button" name="Submit" value="选择模板.." style="BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; BORDER-BOTTOM-WIDTH: 1px; BORDER-RIGHT-WIDTH: 1px" onClick="select_template()"></td>
          </tr>
          <tr>
            <td height="25" align="right">栏目信息页模板</td>
            <td height="25"><input name="news_template" type="text" id="news_template" size="40" value="<?php echo $info['F_CLASS_NEWS_TEMPLATE']?>"><input type="button" name="Submit" value="选择模板.." style="BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; BORDER-BOTTOM-WIDTH: 1px; BORDER-RIGHT-WIDTH: 1px" onClick="select_news()"></td>
          </tr>
          <tr>
            <td height="25" align="right">栏目列表样式模板路径</td>
            <td height="25"><input name="list_style" type="text" id="list_style" size="40" value="<?php echo $info['F_CLASS_LIST_STYLE']?>"><input type="button" name="Submit" value="选择模板.." style="BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; BORDER-BOTTOM-WIDTH: 1px; BORDER-RIGHT-WIDTH: 1px" onClick="select_list_style()"></td>
          </tr>
          <tr>
            <td height="25" align="right">栏目XML模板路径</td>
            <td height="25"><input name="xml" type="text" id="xml" size="40" value="<?php echo $info['F_CLASS_RSS_STYLE']?>"><input type="button" name="Submit" value="选择模板.." style="BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; BORDER-BOTTOM-WIDTH: 1px; BORDER-RIGHT-WIDTH: 1px" onClick="select_xml()"></td>
          </tr>
          <tr>
            <td height="25" align="right">每页提取新闻数量</td>
            <td height="25"><input name="news_count" type="text" id="news_count" size="20" value="<?php echo $info['F_CLASS_NEWS_COUNT']?>"></td>
          </tr>
          <tr>
            <td height="25" align="right">信息分列</td>
            <td height="25">
			<?php
			for($i=1;$i<=4;$i++)										//循环显示分类选择
			{
				echo "<input type='radio' name='news_row' value='$i'";
				if($info['F_CLASS_NEWS_ROW'])						//判断是否是编辑状态
				{
					if($i == $info['F_CLASS_NEWS_ROW'])				//设置默认选项
						echo " checked";
				}else{
					if($i == 1)										//设置默认选项
						echo " checked";
				}
				echo ">$i";
			}
			?>
			</td>
          </tr>
          <tr>
            <td height="25" align="right">是否是图片栏目</td>
            <td height="25"><input name="img" type="radio" value="1"<?php if($info['F_CLASS_SIGN_IMAGE'] == 1) echo " checked"?>>
              是
              <input name="img" type="radio" value="0"<?php if(!$info['F_CLASS_SIGN_IMAGE']) echo " checked"?>>
              否</td>
          </tr>
          <tr>
            <td height="25" align="right">新闻标题字符数</td>
            <td height="25"><input name="cap_len" type="text" id="cap_len" size="20" value="<?php echo $info['F_CLASS_CAP_LEN']?>"></td>
          </tr>
          <tr>
            <td height="25" align="right">新闻内容字符数</td>
            <td height="25"><input name="con_len" type="text" id="con_len" size="20" value="<?php echo $info['F_CLASS_CON_LEN']?>"></td>
          </tr>
        </table></td>
	</tr>
	<tr> 
	  <td height="15" align="center"><input name="cmdSubmit" type="submit" id="cmdSubmit" value="提交"> &nbsp; 
	  <input name="cmdReset" type="reset" id="cmdReset" value="重置"><input type="hidden" name="class_id" id="class_id" value="<?php echo $class_id?>"></td></tr>
  </table>
</form>
<script language='javascript'>
/**
 * 功能：检测表单项
 */
function check_data(){
	if ($('name').trim().value == ""){									//判断栏目名称是否为空
		alert("栏目名称不能为空")
		$('name').focus()
		return false
	}
	if ($('url').trim().value == ""){									//判断栏目目录名称是否为空
		alert("栏目目录名称不能为空")
		$('url').focus()
		return false
	}
	if ($('front').trim().value == ""){									//判断栏目首页文件名是否为空
		alert("栏目首页文件名不能为空")
		frmClass.front.focus()
		return false
	}
	if ($('back').trim().value == ""){									//判断栏目首页文件名是否为空
		alert("栏目首页文件名不能为空")
		$('back').focus()
		return false
	}
	if ($('template_url').trim().value == ""){							//判断栏目首页模板文件路径
		alert("栏目首页模板文件路径不能为空")
		$('template_url').focus()
		return false
	}
	if(!($('list_style').trim().value == ""))								//判断栏目列表模板是否为空
	{														//不为空
		var regu = /^[-]{0,1}[0-9]{1,}$/;
		if(!regu.test($('news_count').value))							//判断新闻数量是否为数字
		{
			alert("每页提取新闻数量应为数字")
			$('news_count').focus()
			return false
		}
		
		if(!regu.test($('cap_len').value)) 							//判断新闻标题字符数是否为数字
		{
			alert("新闻标题字符数应为数字")
			$('cap_len').focus()
			return false
		}
		
		if(!regu.test($('con_len').value)) 							//判断新闻内容字符数是否为数字
		{
			alert("新闻内容字符数应为数字")
			$('con_len').focus()
			return false
		}
	}
	return true
}
/**
 * 功能：弹出首页模板选择框
 */
function select_template(){
	var w=650;h=550;
	var theDes	="status:no;center:yes;help:no;minimize:yes;maximize:yes;dialogWidth:"+w+"px;scroll:auto;dialogHeight:"+h+"px;border:think";
	var rv	=window.showModalDialog("../Templates/Select.php",null,theDes);
	if(rv){														//判断是否有返回值
		document.frmClass.template_url.value = rv;
	}
}
/**
 * 功能：弹出信息页模板选择框
 */
function select_news(){
	var w=650;h=550;
	var theDes	="status:no;center:yes;help:no;minimize:yes;maximize:yes;dialogWidth:"+w+"px;scroll:auto;dialogHeight:"+h+"px;border:think";
	var rv	=window.showModalDialog("../Templates/Select.php",null,theDes);
	if(rv){ 													//判断是否有返回值
		document.frmClass.news_template.value = rv;
	}
}
/**
 * 功能：弹出列表页模板选择框
 */
function select_list_style(){
	var w	=650;h=550;
	var theDes	="status:no;center:yes;help:no;minimize:yes;maximize:yes;dialogWidth:"+w+"px;scroll:auto;dialogHeight:"+h+"px;border:think";
	var rv	=window.showModalDialog("../Templates/Select.php",null,theDes);
	if(rv){ 													//判断是否有返回值
		document.frmClass.list_style.value = rv;
	}
}
/**
 * 功能：弹出RSS页模板选择框
 */
function select_xml(){
	var w	=650;h=550;
	var theDes	="status:no;center:yes;help:no;minimize:yes;maximize:yes;dialogWidth:"+w+"px;scroll:auto;dialogHeight:"+h+"px;border:think";
	var rv	=window.showModalDialog("../Templates/Select.php",null,theDes);
	if(rv){ 													//判断是否有返回值
		document.frmClass.xml.value = rv;
	}
}
</script>
