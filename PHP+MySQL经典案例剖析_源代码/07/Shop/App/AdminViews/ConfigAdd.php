<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<p class="caption">�༭������</p>
<form action="/Config/{*$action*}" method="post" enctype="multipart/form-data" name="frm_add" id="frm_add" onSubmit="return check_data()">
 <table width="75%" border="0" align="center">
  <tr>
   	  <th height="23">�������Ʒ������Ϣ</th>
  </tr>
  <tr>
   	  <td height="100" bgcolor="#eeeeee"> 
		<table width="80%" border="0" align="center">
		  <tr>
	  		<td width="18%" align="right">��ʶ<font color="red">*</font></td>
	  		<td width="82%">{*$info[F_CONFIG_NAME]*}</td>
	 </tr>
	 <tr>
	  		<td align="right">������<font color="red">*</font></td>
	  <td><input name="note" type="text" id="note" value="{*$info[F_CONFIG_NOTE]*}">
			  ���100���ַ�</td>
	 </tr>
	 <tr>
	  		<td align="right">����ֵ<font color="red">*</font></td>
	  		<td><input name="value" type="text" id="value" value="{*$info[F_CONFIG_VALUE]*}">
			  ����ֵ����</td>
	 </tr>
	</table>
	  </td>
  </tr>
  <tr>
   	  <th align="center"> <input type="submit" name="Submit" value="�ύ">
		<input name="cmdBack" type="button" id="cmdBack" value="����" onClick="javascript:history.back()">
		<input name="id" type="hidden" id="id" value="{*$info[F_ID]*}"></th>
  </tr>
 </table>
</form>
<script language='javascript'>
/**
 * ���ܣ�������
 */
function check_data(){
	if ($('note').value.trim() == ''){										//�ж��������Ƿ�Ϊ��
		alert("�������Ϊ��")
		$('note').focus()
		return false
	}
	if ($('value').value.trim() == ''){										//�ж�����ֵ����Ϊ��
		alert("ֵ����Ϊ��")
		$('value').focus()
		return false
	}
	return true;
}
</script>
