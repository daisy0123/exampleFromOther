<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<p class="caption">增加产品属性</p>
<form action="" method="post" enctype="multipart/form-data" name="frm_add" id="frm_add" onsubmit="return check_data()">
 <table width="400" border="0" align="center">
  <tr>
   	  <th height="23" align="center">类别：<?php echo $this->_vars['class']['F_CLASS_NAME']; ?>
</th>
  </tr>
  <tr>
   	  <td height="100" bgcolor="#eeeeee"> 
		<table width="85%" border="0" align="center">
	 <tr> 
	  <td width="18%" height="24" align="right">属性名称<font color="red">*</font></td>
	  <td width="82%"><input name="name" type="text" id="name" value="<?php echo $this->_vars['info']['F_PROPERTY_NAME']; ?>
">
	   25个汉字以内</td>
	 </tr>
	</table>
	  </td>
  </tr>
  <tr>
   	  <th align="center"> <input type="submit" name="Submit" value="提交">
		<input name="cmdBack" type="button" id="cmdBack" value="返回" onclick="javascript:history.back()"></th>
  </tr>
 </table>
</form>
<script language='javascript'>
/**
 * 功能：检测表单项
 */
function check_data(){
	if ($('name').value.trim() == ''){								//检查属性名称是否为空
		alert("属性名称不得为空")
		$('name').focus()
		return false
	}
	if ($('name').value.trim().len() > 25)							//检查属性名称是否过长
	{
		alert("属性名称过长")
		$('name').focus()
		return false
	}
	return true;
}
</script>
