<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<p class="caption">
{*if $info[F_ID]*}
�༭
{*else*}
����
{*/if*}��Ʒ</p>
<form action="/Product/{*$action*}" method="post" enctype="multipart/form-data" name="frm_add" id="frm_add" onSubmit="return check_data()">
 
<table width="85%" border="0" align="center">
<tr>
   
<th align="center">�����Ʒ��ϸ��Ϣ </th>
  </tr>
  <tr>
   
  <td height="100" bgcolor="#eeeeee"> 
	<table width="90%" border="0" align="center">
	  <tr> 
		<td height="24" align="right">���</td>
  <td class="stress">{*$class[F_CLASS_NAME]*}</td>
 </tr>
 <tr> 
		<td height="24" align="right">��Ʒ����<font color="red">*</font></td>
		<td>
<input name="name" type="text" id="name" size="40" value="{*$info[F_PRODUCT_NAME]*}">
   25����������</td>
 </tr>
 <tr>
   <td height="24" align="right">��Ʒ�۸�<font color="red">*</font></td>
   <td><input name="price" type="text" id="price" value="{*$info[F_PRODUCT_PRICE]*}"></td>
 </tr>
 <tr>
   <td height="24" align="right">�ۿۼ۸�</td>
   <td>
     <input name="low_price" type="text" id="low_price" value="{*$info[F_PRODUCT_LOW_PRICE]*}">
   </td>
 </tr>
{*foreach item=uu key=key from=$property*}
 <tr>
  <td height="24" align="right"><input name="p_id[]" type="hidden" value="{*$uu[F_PROPERTY_FIELDNAME]*}"> 
   {*$uu[F_PROPERTY_NAME]*}</td>
  <td><input name="value[]" type="text" value="{*$property_value[$key]*}">
   100����������</td>
 </tr>
{*/foreach*}
 <tr>
   <td height="24" align="right" valign="top">��ϸ˵��</td>
   <td><textarea name="content" cols="70" rows="10" id="content">{*$info[F_PRODUCT_DESCRIPTION]*}</textarea></td>
   </tr>
</table></td>
  </tr>
  <tr>
   
<th align="center"> <input type="submit" name="Submit" value="�ύ">
	<input name="cmdBack" type="button" id="cmdBack" value="����" onClick="javascript:history.back();">
	<input name="classid" type="hidden" id="classid" value="{*$class[F_ID]*}">
	<input name="id" type="hidden" id="id" value="{*$info[F_ID]*}">
	</th>
  </tr>
 </table>
</form>
<script language='javascript'>
/**
 * ���ܣ��ж�����ֵ�Ƿ�Ϊ����
 */
function isNumberFloat(inputString){
  return (!isNaN(parseInt(inputString))) ? true : false;
}
/**
 * ���ܣ�������
 */
function check_data(){
	if ($('name').value.trim() == ''){										//����Ʒ�����Ƿ�Ϊ��
		alert("��Ʒ���Ʋ���Ϊ��")
		$('name').focus()
		return false
	}
	if($('price').value.trim() == '')										//�жϲ�Ʒ�۸��Ƿ�Ϊ��
	{
		alert('��Ʒ�۸���Ϊ��');
		$('price').focus();
		return false;
	}
	if(!isNumberFloat($('price').value))									//�жϲ�Ʒ�۸��Ƿ�Ϊ����
	{
		alert('��Ʒ�۸�ӦΪ����');
		$('price').focus();
		return false;
	}
	if($('low_price').value.trim() != '')									//�ж��ۿۼ۸��Ƿ�Ϊ��
	{
		if(!isNumberFloat($('low_price').value))							//�ж��ۿۼ۸��Ƿ�Ϊ����
		{
			alert('�ۿۼ۸�ӦΪ����');
			$('low_price').focus();
			return false;
		}
	}
	if ($('content').value.trim() == "")									//����Ʒ�����Ƿ�Ϊ��
	{
		alert("���ݲ���Ϊ�գ�");
		$('content').focus();
		return false;
	}
	return true; 
}
</script>
