<script language="javascript" src="/Js/Base.js"></script>
<P align=center><strong>�� �� �� ��</strong></P>
<form name="form1" method="post" action="" onSubmit="javascript:check();">
<table width="60%" border="0" align="center">
  <tr>
    <th align="left">�û���Ϣ</th>
  </tr>
  <tr>
    <td>Email��<?php echo $this->_vars['user']['F_LOGIN_EMAIL']; ?>
 �û�����<?php echo $this->_vars['user']['F_LOGIN_NAME']; ?>
</td>
  </tr>
  <tr>
    <th align="left">�ʼ�����</th>
  </tr>
  <tr>
    <td><input name="title" type="text" id="title" size="50"></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
  </tr>
  <tr>
    <td><textarea name="content" cols="100" rows="20" id="content"></textarea></td>
  </tr>
  <tr>
    <th><input type="submit" name="Submit" value="�ύ"></th>
  </tr>
</table>
</form>
<script language="javascript">
/**
 * ���ܣ�������
 */
function check()
{
	if($('title').value.trim() == '')										//�жϱ����Ƿ�Ϊ��
	{
		alert('����д����');
		$('title').focus();
		return false;
	}
	if($('content').value.trim() == '')										//�ж������Ƿ�Ϊ��
	{
		alert('����д����');
		$('content').focus();
		return false;
	}
	return true;
}
</script>
