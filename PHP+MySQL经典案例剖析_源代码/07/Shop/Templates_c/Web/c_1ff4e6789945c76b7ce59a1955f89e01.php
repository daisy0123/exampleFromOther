<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>会员注册</title>
<link href="/Style/index.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="SearchContent" style="width:98%; ">
  <div id="top_left">
    <h2 class="hot">注册网上商城用户</h2>
  </div>
  </div>
<div id="contt">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 20px">
<tr>
<td width="20%" rowspan="2" valign="top"><img src="/images/login_ok.gif" alt="loginok" width="139" height="121"/></td>
<td width="80%" class="right70"><h2 class="STYLE1">恭喜您注册成功！</h2>
  <p>我们给您发送了激活邮件，地址为：<?php echo $this->_vars['apply']['email']; ?>
<br />
请<?php if ($this->_vars['apply']['mailserver'] != ""): ?>
前往&nbsp;
<a href="<?php echo $this->_vars['apply']['mailserver']; ?>
" target="_blank"><strong><?php echo $this->_vars['apply']['mailserver']; ?>
</strong></a>
&nbsp;<?php endif; ?>查收，或返回到<a href="/"><strong>首页</strong></a>。 <br />
  </p></td>
</tr>
<tr>
<td class="right70"></td>
</tr>
</table>
</body>
</html>