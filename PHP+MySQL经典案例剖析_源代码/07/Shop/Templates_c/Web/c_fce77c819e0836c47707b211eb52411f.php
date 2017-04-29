<?php require_once('C:\xampplite\htdocs\07\Lib\Smarty\plugins\modifier.nl2br.php'); $this->register_modifier("nl2br", "tpl_modifier_nl2br"); ?><link href="/Style/Index.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<form id=form1 name=form1 action="/Product/SendMessage?Back=' + encodeURIComponent(location.pathname) + '" method=post onSubmit="javascript:Check();">        
<table cellSpacing=0 cellPadding=0 width="600" border=0>
<tr vAlign=top>
<td width=290>
<table cellSpacing=0 cellPadding=5 width="100%" border=0>
<tr>
<td align=middle width=120><?php if ($this->_vars['info']['F_PRODUCT_BIG_IMG']): ?><a href="<?php echo $this->_vars['path'];  echo $this->_vars['info']['F_PRODUCT_BIG_IMG']; ?>
" 
target=_blank><img height=127 
src="<?php echo $this->_vars['path'];  echo $this->_vars['info']['F_PRODUCT_BIG_IMG']; ?>
" 
width=95 border=0></a><?php else: ?><img height=127 
src="/Images/no-photo.gif" 
width=95 border=0><?php endif; ?></td>
<td 
class=line_h20><B>名称</B>：<?php echo $this->_vars['info']['F_PRODUCT_NAME']; ?>

<BR>
<?php if (count((array)$this->_vars['property'])): foreach ((array)$this->_vars['property'] as $this->_vars['uu']): ?>
<B><?php echo $this->_vars['uu']['F_CAPTION']; ?>
</B>：<?php echo $this->_vars['uu']['F_VALUE']; ?>
<BR>
<?php endforeach; endif; ?>
<B>市场价</B>：￥<?php echo $this->_vars['info']['F_PRODUCT_PRICE']; ?>
<BR>
<B>商城价</B>：￥<?php echo $this->_vars['info']['F_PRODUCT_LOW_PRICE']; ?>
<br>
<input type="button" name="Submit4" value="放入购物车" onClick="javascript:Cart(<?php echo $this->_vars['info']['F_ID']; ?>
)"></td>
</tr>
<tr>
<td align=middle><?php if ($this->_vars['info']['F_PRODUCT_BIG_IMG']): ?><a 
href="<?php echo $this->_vars['path'];  echo $this->_vars['info']['F_PRODUCT_BIG_IMG']; ?>
" 
target=_blank>点击看大图</a><?php endif; ?></td>
<td>&nbsp;</td></tr></table></td>
</tr></table>
<table cellSpacing=0 cellPadding=8 width="600" border=0>
<tr>
<td class=font11 width=116>商品简介</td></tr></table>
<table cellSpacing=12 cellPadding=0 width="600" border=0>
<tr>
<td height=2><?php echo $this->_run_modifier($this->_vars['info']['F_PRODUCT_DESCRIPTION'], 'nl2br', 1); ?>
</td>
</tr></table>
<table cellSpacing=0 cellPadding=8 width="600" border=0>
<tr>
<td class=font11>用户反馈</td>
<td align=right>&nbsp;</td></tr></table>
<table cellSpacing=10 cellPadding=0 width="600" border=0>
<tr>
<td>
<table width="100%" border="0">
<?php if ($this->_vars['isLogin'] == 1): ?>
<tr>
<td width="24%">用户名：</td>
<td colspan="2"><?php echo $_SESSION['User']['F_LOGIN_NAME']; ?>
</td>
</tr>
<?php else: ?>
<tr>
<td width="24%">用户名：</td>
<td colspan="2"><input name="name" type="text" id="name">
<font color="red">*</font></td>
</tr>
<tr>
<td>密　码：</td>
<td colspan="2"><input name="password" type="password" id="password">
<font color="red">*</font></td>
</tr>
<?php endif; ?>
<tr>
<td valign="top">内　容：</td>
<td colspan="2"><textarea name="content" cols="50" rows="8" id="content"></textarea>
<font color="red">*</font></td>
</tr>
<tr>
<td>验证码：</td>
<td width="17%" valign="middle"><input name="verify" type="text" id="verify" size="10"></td>
<td width="59%" valign="middle"><img src="/Index/GetVerifyImg" style="cursor: pointer" onclick="this.src='/Index/GetVerifyImg';" title="如看不清楚,请点击此处换一张" border="1"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td colspan="2"><input type="submit" name="Submit3" value="提交">
  <input name="id" type="hidden" id="id" value="<?php echo $this->_vars['info']['F_ID']; ?>
" /></td>
</tr>
</table></td></tr></table>
</form>
<script language="javascript">
/**
 * 功能：检测表单项
 */
function Check()
{
	<?php if ($this->_vars['isLogin'] == 0): ?>											//判断是否已登陆
	if($('name').value.trim() == '')									//判断用户名是否为空
	{
		alert('用户名不能为空');
		$('name').focus();
		return false;
	}
	if($('password').value == '')									//判断密码是否为空
	{
		alert('密码不能为空');
		$('password').focus();
		return false;
	}
	<?php endif; ?>
	if($('content').value == '')										//判断内容是否为空
	{
		alert('内容不能为空');
		$('content').focus();
		return false;
	}
	if($('verify').value.trim() == '')										//判断验证码是否为空
	{
		alert('验证码不能为空');
		$('verify').focus();
		return false;
	}	
	return true;
}
/**
 * 功能：打开购物车窗口
 */
function Cart(ID)
{
	window.open('/Cart/AddCart/Id/'+ ID, 'cart', 'height=100,width=400,toolbar=yes,menubar=yes,scrollbars=yes, resizable=yes,location=yes,status=yes')
}
</script>
