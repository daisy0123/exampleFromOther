<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<p class="caption">
{*if $info[F_ID]*}
编辑
{*else*}
增加
{*/if*}产品</p>
<form action="/Product/{*$action*}" method="post" enctype="multipart/form-data" name="frm_add" id="frm_add" onSubmit="return check_data()">
 
<table width="85%" border="0" align="center">
<tr>
   
<th align="center">输入产品详细信息 </th>
  </tr>
  <tr>
   
  <td height="100" bgcolor="#eeeeee"> 
	<table width="90%" border="0" align="center">
	  <tr> 
		<td height="24" align="right">类别</td>
  <td class="stress">{*$class[F_CLASS_NAME]*}</td>
 </tr>
 <tr> 
		<td height="24" align="right">产品名称<font color="red">*</font></td>
		<td>
<input name="name" type="text" id="name" size="40" value="{*$info[F_PRODUCT_NAME]*}">
   25个汉字以内</td>
 </tr>
 <tr>
   <td height="24" align="right">产品价格<font color="red">*</font></td>
   <td><input name="price" type="text" id="price" value="{*$info[F_PRODUCT_PRICE]*}"></td>
 </tr>
 <tr>
   <td height="24" align="right">折扣价格</td>
   <td>
     <input name="low_price" type="text" id="low_price" value="{*$info[F_PRODUCT_LOW_PRICE]*}">
   </td>
 </tr>
{*foreach item=uu key=key from=$property*}
 <tr>
  <td height="24" align="right"><input name="p_id[]" type="hidden" value="{*$uu[F_PROPERTY_FIELDNAME]*}"> 
   {*$uu[F_PROPERTY_NAME]*}</td>
  <td><input name="value[]" type="text" value="{*$property_value[$key]*}">
   100个汉字以内</td>
 </tr>
{*/foreach*}
 <tr>
   <td height="24" align="right" valign="top">详细说明</td>
   <td><textarea name="content" cols="70" rows="10" id="content">{*$info[F_PRODUCT_DESCRIPTION]*}</textarea></td>
   </tr>
</table></td>
  </tr>
  <tr>
   
<th align="center"> <input type="submit" name="Submit" value="提交">
	<input name="cmdBack" type="button" id="cmdBack" value="返回" onClick="javascript:history.back();">
	<input name="classid" type="hidden" id="classid" value="{*$class[F_ID]*}">
	<input name="id" type="hidden" id="id" value="{*$info[F_ID]*}">
	</th>
  </tr>
 </table>
</form>
<script language='javascript'>
/**
 * 功能：判断输入值是否为数字
 */
function isNumberFloat(inputString){
  return (!isNaN(parseInt(inputString))) ? true : false;
}
/**
 * 功能：检测表单项
 */
function check_data(){
	if ($('name').value.trim() == ''){										//检测产品名称是否为空
		alert("产品名称不得为空")
		$('name').focus()
		return false
	}
	if($('price').value.trim() == '')										//判断产品价格是否为空
	{
		alert('产品价格不能为空');
		$('price').focus();
		return false;
	}
	if(!isNumberFloat($('price').value))									//判断产品价格是否为数字
	{
		alert('产品价格应为数字');
		$('price').focus();
		return false;
	}
	if($('low_price').value.trim() != '')									//判断折扣价格是否为空
	{
		if(!isNumberFloat($('low_price').value))							//判断折扣价格是否为数字
		{
			alert('折扣价格应为数字');
			$('low_price').focus();
			return false;
		}
	}
	if ($('content').value.trim() == "")									//检测产品描述是否为空
	{
		alert("内容不能为空！");
		$('content').focus();
		return false;
	}
	return true; 
}
</script>
