<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<p class="caption">���Ӳ�Ʒ����</p>
<form action="" method="post" enctype="multipart/form-data" name="frm_add" id="frm_add" onsubmit="return check_data()">
 <table width="400" border="0" align="center">
  <tr>
   	  <th height="23" align="center">���<?php echo $this->_vars['class']['F_CLASS_NAME']; ?>
</th>
  </tr>
  <tr>
   	  <td height="100" bgcolor="#eeeeee"> 
		<table width="85%" border="0" align="center">
	 <tr> 
	  <td width="18%" height="24" align="right">��������<font color="red">*</font></td>
	  <td width="82%"><input name="name" type="text" id="name" value="<?php echo $this->_vars['info']['F_PROPERTY_NAME']; ?>
">
	   25����������</td>
	 </tr>
	</table>
	  </td>
  </tr>
  <tr>
   	  <th align="center"> <input type="submit" name="Submit" value="�ύ">
		<input name="cmdBack" type="button" id="cmdBack" value="����" onclick="javascript:history.back()"></th>
  </tr>
 </table>
</form>
<script language='javascript'>
/**
 * ���ܣ�������
 */
function check_data(){
	if ($('name').value.trim() == ''){								//������������Ƿ�Ϊ��
		alert("�������Ʋ���Ϊ��")
		$('name').focus()
		return false
	}
	if ($('name').value.trim().len() > 25)							//������������Ƿ����
	{
		alert("�������ƹ���")
		$('name').focus()
		return false
	}
	return true;
}
</script>
