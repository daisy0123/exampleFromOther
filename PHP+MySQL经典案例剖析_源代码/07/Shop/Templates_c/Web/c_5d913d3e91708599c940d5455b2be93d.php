<?php require_once('C:\xampplite\htdocs\07\Lib\Smarty\plugins\function.html_options.php'); $this->register_function("html_options", "tpl_function_html_options"); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�����̳�ϵͳ</title>
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
    <td height="200" align="left"><p class="STYLE1">�����̳�ϵͳ��ʾ</p>
    <p><span class="STYLE2">1��<a href="/Product">�²�Ʒ</a></span></p>
	<p class="STYLE2">2�������������Ʒ</p>
	<?php if (count((array)$this->_vars['class'])): foreach ((array)$this->_vars['class'] as $this->_vars['uu']): ?>
	<p><?php echo $this->_vars['uu']['prev']; ?>
<span class="STYLE2"><a href="/Product/List/Id/<?php echo $this->_vars['uu']['id']; ?>
"><?php echo $this->_vars['uu']['class_name']; ?>
</a></span></p>
	<?php endforeach; else: ?>
	<p>��ʱ�޷��࣡</p>
	<?php endif; ?>
	<p class="STYLE2">4����Ʒ����</p>
	<p class="STYLE2">
	<form name="form2" method="post" action="/Product/Redirect" onSubmit="javascript:Check();">
<h3>��Ʒ������
<input name="keyword" type="text" id="keyword" size="40">
<select id="class_id" name="class_id">
<option value="0" selected="selected">���з���</option>
<?php echo tpl_function_html_options(array('options' => $this->_vars['option']), $this);?>
</select>
<input type="submit" name="Submit2" value=" �� �� ">
</h3>
</form>
	</p>
	<p class="STYLE2">5����ѯ�ҵĶ��� ��ǰ��¼�û���<?php if ($_SESSION['User']['F_ID']): ?> <?php echo $_SESSION['User']['F_LOGIN_NAME']; ?>
<a href="/Login/LoginOut">[�˳���¼]</a> <?php else: ?> <a href="/Login">��δ��¼</a><a href="/Login/ForgetPwd">[��������]</a> <?php endif; ?></p>
<form name="form1" method="post" action="/Order/Redirect">
<table cellspacing="0" cellpadding="0" width="100%" border="0">
    <tr>
      <td><h4 class="bule">������ѯ</h4></td>
    </tr>
    <tr>
      <td><p>
        <select id="start_y" name="start_y">
	  <?php echo $this->_vars['date']['Year']; ?>

	  </select>
        ��
	    <select id="start_m" onChange="javascript:register_buildDay(this.value,'start_y','start_d');" name="start_m">
	  <?php echo $this->_vars['date']['Month']; ?>
  		
	  </select>
	    ��
	    <select id="start_d" name="start_d">
	  <?php echo $this->_vars['date']['Day']; ?>
 
	  </select>
	    ��
	  ��
      <select id="end_y" name="end_y">
	  <?php echo $this->_vars['date']['Year']; ?>
  
	  </select>
      ��
      <select id="end_m" onChange="javascript:register_buildDay(this.value,'end_y','end_d');" name="end_m">
	  <?php echo $this->_vars['date']['Month']; ?>
  
	  </select>
      ��
      <select id="end_d" name="end_d">
	  <?php echo $this->_vars['date']['Day']; ?>

	  </select>
      ��
        <input type="submit" value="��ѯ" name="button" />
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
 * ���ܣ������ύ��
 */
function Check()
{
	if($('keyword').value.trim() == '')									//�ж������ؼ����Ƿ�Ϊ��
	{
		alert('����д�ؼ���');
		$('keyword').focus();
		return false;
	}
	return true;
}
</script>
</body>
</html>
