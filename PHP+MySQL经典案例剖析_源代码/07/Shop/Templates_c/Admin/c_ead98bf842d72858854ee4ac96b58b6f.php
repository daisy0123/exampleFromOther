<script language="javascript" src="/Js/Base.js"></script>
<P align=center><strong>发 送 邮 件</strong></P>
<form name="form1" method="post" action="" onSubmit="javascript:check();">
<table width="60%" border="0" align="center">
  <tr>
    <th align="left">用户信息</th>
  </tr>
  <tr>
    <td>Email：<?php echo $this->_vars['user']['F_LOGIN_EMAIL']; ?>
 用户名：<?php echo $this->_vars['user']['F_LOGIN_NAME']; ?>
</td>
  </tr>
  <tr>
    <th align="left">邮件标题</th>
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
    <th><input type="submit" name="Submit" value="提交"></th>
  </tr>
</table>
</form>
<script language="javascript">
/**
 * 功能：检测表单项
 */
function check()
{
	if($('title').value.trim() == '')										//判断标题是否为空
	{
		alert('请填写标题');
		$('title').focus();
		return false;
	}
	if($('content').value.trim() == '')										//判断内容是否为空
	{
		alert('请填写内容');
		$('content').focus();
		return false;
	}
	return true;
}
</script>
