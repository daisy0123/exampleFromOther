<?php require_once('C:\xampplite\htdocs\07\Lib\Smarty\plugins\function.html_options.php'); $this->register_function("html_options", "tpl_function_html_options"); ?><link href="/Style/Index.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<table cellSpacing=0 cellPadding=0 width="800" border=0>
<tr>
<td height=25>当前您的位置：<A 
href="/">首页</A> -- 产品搜索</td>
</tr>
<tr>
<td height=1></td>
</tr>
<tr>
<td vAlign=top>
<form name="form2" method="post" action="/Product/Redirect" onSubmit="javascript:Check();">
<h3>产品搜索：
<input name="keyword" type="text" id="keyword" size="40">
<select id="class_id" name="class_id">
<option value="0" selected="selected">所有分类</option>
<?php echo tpl_function_html_options(array('options' => $this->_vars['option']), $this);?>
</select>
<input type="submit" name="Submit2" value=" 搜 索 ">
</h3>
</form></td>
</tr>
<?php if (count((array)$this->_vars['list']['data'])): foreach ((array)$this->_vars['list']['data'] as $this->_vars['key'] => $this->_vars['uu']): ?>
<?php if ($this->_vars['key'] % $this->_vars['perline'] == 0): ?>
<tr>
<?php endif; ?>
<td vAlign=top width="<?php echo $this->_vars['td_width']; ?>
">
<table width="100%" border=0>
<tr>
<td>
<table align=center border=0>
<tr>
<td align=middle>
<a href="/Product/Info/Id/<?php echo $this->_vars['uu']['F_ID']; ?>
" target="_blank"><img 
height=<?php echo $this->_vars['height']; ?>
 
src="<?php if ($this->_vars['uu']['F_PRODUCT_SMALL_IMG']):  echo $this->_vars['path'];  echo $this->_vars['uu']['F_PRODUCT_SMALL_IMG'];  else: ?>/Images/no-photo.gif<?php endif; ?>" 
width=<?php echo $this->_vars['width']; ?>
 border=0></a></td></tr>
<tr align=middle height=20>
<td bgColor=#464646><FONT 
color=#ffffff><?php echo $this->_vars['uu']['F_PRODUCT_NAME']; ?>
</FONT></td></tr>
<tr align=middle height=20>
  <td>价格：<span style="TEXT-DECORATION: line-through;COLOR: #787878; "><?php echo $this->_vars['uu']['F_PRODUCT_PRICE']; ?>
</span></td>
</tr>
<tr align=middle height=20>
  <td>折扣价：<font color="red"><?php echo $this->_vars['uu']['F_PRODUCT_LOW_PRICE']; ?>
</font></td>
</tr>
</table></td>
</tr></table>
</td>
<?php if ($this->_vars['key'] % $this->_vars['perline'] == $this->_vars['_perline']): ?>
</tr>
<?php endif; ?>
<?php endforeach; endif; ?>
<?php if (count((array)$this->_vars['data'])): foreach ((array)$this->_vars['data'] as $this->_vars['uu']): ?>
<?php echo $this->_vars['uu']; ?>

<?php endforeach; endif; ?>
</table>
<div id="page" style="width:800px;"><?php echo $this->_vars['list']['JumpBar']; ?>
</div>
<script language="javascript">
/**
 * 功能：检测表单提交项
 */
function Check()
{
	if($('keyword').value.trim() == '')									//判断搜索关键字是否为空
	{
		alert('请填写关键字');
		$('keyword').focus();
		return false;
	}
	return true;
}
</script>
