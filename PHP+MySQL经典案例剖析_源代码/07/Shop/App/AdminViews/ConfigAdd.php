<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<p class="caption">编辑配置项</p>
<form action="/Config/{*$action*}" method="post" enctype="multipart/form-data" name="frm_add" id="frm_add" onSubmit="return check_data()">
 <table width="75%" border="0" align="center">
  <tr>
   	  <th height="23">请输入产品分类信息</th>
  </tr>
  <tr>
   	  <td height="100" bgcolor="#eeeeee"> 
		<table width="80%" border="0" align="center">
		  <tr>
	  		<td width="18%" align="right">标识<font color="red">*</font></td>
	  		<td width="82%">{*$info[F_CONFIG_NAME]*}</td>
	 </tr>
	 <tr>
	  		<td align="right">配置项<font color="red">*</font></td>
	  <td><input name="note" type="text" id="note" value="{*$info[F_CONFIG_NOTE]*}">
			  最多100个字符</td>
	 </tr>
	 <tr>
	  		<td align="right">设置值<font color="red">*</font></td>
	  		<td><input name="value" type="text" id="value" value="{*$info[F_CONFIG_VALUE]*}">
			  设置值数字</td>
	 </tr>
	</table>
	  </td>
  </tr>
  <tr>
   	  <th align="center"> <input type="submit" name="Submit" value="提交">
		<input name="cmdBack" type="button" id="cmdBack" value="返回" onClick="javascript:history.back()">
		<input name="id" type="hidden" id="id" value="{*$info[F_ID]*}"></th>
  </tr>
 </table>
</form>
<script language='javascript'>
/**
 * 功能：检测表单项
 */
function check_data(){
	if ($('note').value.trim() == ''){										//判断配置项是否为空
		alert("配置项不得为空")
		$('note').focus()
		return false
	}
	if ($('value').value.trim() == ''){										//判断设置值不能为空
		alert("值不得为空")
		$('value').focus()
		return false
	}
	return true;
}
</script>
