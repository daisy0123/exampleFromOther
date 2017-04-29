<?php require_once('C:\xampplite\htdocs\07\Lib\Smarty\plugins\function.html_options.php'); $this->register_function("html_options", "tpl_function_html_options"); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>网上商城系统</title>
<link href="/Style/Index.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<script language="javascript" src="/Js/Date.js"></script>
<style type="text/css">
<!--
.STYLE1 {font-size: 14px}
.STYLE2 {font-size: 12px}
-->
</style>
</head>

<body>
<table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="200" align="left"><p class="STYLE1">网上商城系统演示</p>
    <p><span class="STYLE2">1、<a href="/Product">新产品</a></span></p>
	<p class="STYLE2">2、按分类浏览产品</p>
	<?php if (count((array)$this->_vars['class'])): foreach ((array)$this->_vars['class'] as $this->_vars['uu']): ?>
	<p><?php echo $this->_vars['uu']['prev']; ?>
<span class="STYLE2"><a href="/Product/List/Id/<?php echo $this->_vars['uu']['id']; ?>
"><?php echo $this->_vars['uu']['class_name']; ?>
</a></span></p>
	<?php endforeach; else: ?>
	<p>暂时无分类！</p>
	<?php endif; ?>
	<p class="STYLE2">4、产品搜索</p>
	<p class="STYLE2">
	<form name="form2" method="post" action="/Product/Redirect" onSubmit="javascript:Check();">
<h3>产品搜索：
<input name="keyword" type="text" id="keyword" size="40">
<select id="class_id" name="class_id">
<option value="0" selected="selected">所有分类</option>
<?php echo tpl_function_html_options(array('options' => $this->_vars['option']), $this);?>
</select>
<input type="submit" name="Submit2" value=" 搜 索 ">
</h3>
</form>
	</p>
	<p class="STYLE2">5、查询我的订单 当前登录用户：<?php if ($_SESSION['User']['F_ID']): ?> <?php echo $_SESSION['User']['F_LOGIN_NAME']; ?>
<a href="/Login/LoginOut">[退出登录]</a> <?php else: ?> <a href="/Login">您未登录</a><a href="/Login/ForgetPwd">[忘记密码]</a> <?php endif; ?></p>
<form name="form1" method="post" action="/Order/Redirect">
<table cellspacing="0" cellpadding="0" width="100%" border="0">
    <tr>
      <td><h4 class="bule">订单查询</h4></td>
    </tr>
    <tr>
      <td><p>
        <select id="start_y" name="start_y">
	  <?php echo $this->_vars['date']['Year']; ?>

	  </select>
        年
	    <select id="start_m" onChange="javascript:register_buildDay(this.value,'start_y','start_d');" name="start_m">
	  <?php echo $this->_vars['date']['Month']; ?>
  		
	  </select>
	    月
	    <select id="start_d" name="start_d">
	  <?php echo $this->_vars['date']['Day']; ?>
 
	  </select>
	    日
	  至
      <select id="end_y" name="end_y">
	  <?php echo $this->_vars['date']['Year']; ?>
  
	  </select>
      年
      <select id="end_m" onChange="javascript:register_buildDay(this.value,'end_y','end_d');" name="end_m">
	  <?php echo $this->_vars['date']['Month']; ?>
  
	  </select>
      月
      <select id="end_d" name="end_d">
	  <?php echo $this->_vars['date']['Day']; ?>

	  </select>
      日
        <input type="submit" value="查询" name="button" />
      </p>
      </td>
    </tr>
</table>
</form>
	</td>
  </tr>
</table>
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
</body>
</html>
