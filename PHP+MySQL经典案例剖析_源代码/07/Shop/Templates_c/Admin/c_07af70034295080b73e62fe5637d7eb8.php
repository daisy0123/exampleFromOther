<?php require_once('C:\xampplite\htdocs\07\Lib\Smarty\plugins\modifier.date.php'); $this->register_modifier("date", "tpl_modifier_date");  require_once('C:\xampplite\htdocs\07\Lib\Smarty\plugins\modifier.nl2br.php'); $this->register_modifier("nl2br", "tpl_modifier_nl2br"); ?><link href="/Style/admin.css" rel="stylesheet" type="text/css">
<P align=center><B>�� �� �� Ϣ �� ��</B></P>
<?php if (count((array)$this->_vars['list']['data'])): foreach ((array)$this->_vars['list']['data'] as $this->_vars['uu']): ?>
<table cellSpacing=0 cellPadding=0 width="70%" align=center border=0>
<tr>	
<td bgColor=#0066cc>
<table cellSpacing=1 cellPadding=0 width="100%" border=0>
<tr>
<Th height=22 align="left">��Ʒ���ƣ�<?php echo $this->_vars['uu']['F_PRODUCT_NAME']; ?>
</Th>
</tr>
<tr>
<td bgColor=#ffffff>
<table width="100%" border=0>
<tr>
<td bgColor=#666666><FONT 
color=#ffffff><?php echo $this->_vars['uu']['F_LOGIN_NAME']; ?>
&nbsp;&nbsp;����ʱ�䣺<?php echo $this->_run_modifier($this->_vars['uu']['F_MESSAGE_TIME'], 'date', 1, "Y-m-d H:i:s"); ?>
</FONT></td>
</tr>
<tr>
<td><?php echo $this->_run_modifier($this->_vars['uu']['F_MESSAGE_CONTENT'], 'nl2br', 1); ?>
</td>
</tr>
<tr>
<td align=right height=22>
<a href="/Message/SendMail/Id/<?php echo $this->_vars['uu']['F_ID_LOGIN_INFO']; ?>
">[�����ʼ�]</a> 
<a onclick="return confirm('���Ҫɾ����')" href="/Message/Del/Id/<?php echo $this->_vars['uu']['F_ID']; ?>
">[ɾ����Ϣ]</a></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
<?php endforeach; else: ?>
<table cellSpacing=0 cellPadding=0 width="70%" align=center border=0>
<tr>	
<td>û�м�¼��</td>
</tr>
</table>
<?php endif; ?>
<table width="70%" border="0" align="center">
  <tr>
    <td><?php echo $this->_vars['list']['JumpBar']; ?>
</td>
  </tr>
</table>
