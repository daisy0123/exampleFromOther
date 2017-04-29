<?php require_once('C:\xampplite\htdocs\07\Lib\Smarty\plugins\modifier.date.php'); $this->register_modifier("date", "tpl_modifier_date"); ?><link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<script language="javascript" src="/Js/Date.js"></script>
<table cellSpacing=0 width="95%" align=center border=0>
  <tr>
    <td class=caption colSpan=2>订 单 管 理</td>
  </tr>
  <tr>
    <td colSpan=2>
<form name=search action="/Order/Redirect<?php if ($this->_vars['userid']): ?>/UserId/<?php echo $this->_vars['userid'];  endif; ?>" method=post onSubmit="javascript:return Check();">
	订单搜索：<span id="searchuser">
      <input name="keyword" type="text" id="keyword" size="10">
      <select name="type" id="type">
        <option value="1" selected>用户名</option>
        <option value="2">EMAIL</option>
        <option value="3">真实姓名</option>
      </select>
      <input name="user" type="hidden" id="user" value="1">
	  </span>
	  <span id="date">
	  <select id="start_y" name="start_y">
	  <?php echo $this->_vars['date']['Year']; ?>

	  </select>
	  <select id="start_m" onChange="javascript:register_buildDay(this.value,'start_y','start_d');" name="start_m">
	  <?php echo $this->_vars['date']['Month']; ?>
  		
	  </select>
	  <select id="start_d" name="start_d">
	  <?php echo $this->_vars['date']['Day']; ?>
 
	  </select>
	  -
      <select id="end_y" name="end_y">
	  <?php echo $this->_vars['date']['Year']; ?>
  
	  </select>
      <select id="end_m" onChange="javascript:register_buildDay(this.value,'end_y','end_d');" name="end_m">
	  <?php echo $this->_vars['date']['Month']; ?>
  
	  </select>
      <select id="end_d" name="end_d">
	  <?php echo $this->_vars['date']['Day']; ?>

	  </select>
      <input name="time" type="hidden" id="time" value="1">
	  </span>
	  <input type="submit" name="Submit" value="提交">
	  <a href="#" onClick="javascript:ChangeUser();">[<span id="disp_user">隐藏</span>用户条件]</a>
	  <a href="#" onClick="javascript:ChangeDate();">[<span id="disp_date">隐藏</span>时间条件]</a>
	  </form>
	  </td>
  </tr>
  <tr>
    <td colSpan=2>
<form name=form1 action="" method=post onSubmit="">
      <table width="100%" border=0>
        <tr>
          <th width=25><input id=allbox onclick=CA(); type=checkbox value=1 name=allbox></th>
          <th width=99>用户名</th>
          <th width=165>地址</th>
          <th width=98>邮政编码</th>
          <th width=111>固定电话</th>
          <th width=109>下单时间</th>
          <th width=57>状态</th>
          <th width=109>管理</th></tr>
		<?php if (count((array)$this->_vars['list']['data'])): foreach ((array)$this->_vars['list']['data'] as $this->_vars['uu']): ?>
        <tr bgColor=#ffffff>
          <td align=middle><input type=checkbox value='<?php echo $this->_vars['uu']['F_ID']; ?>
' name=SelId[]> </td>
          <td><?php echo $this->_vars['uu']['F_LOGIN_NAME']; ?>
</td>
          <td align=middle><?php echo $this->_vars['uu']['F_ORDER_ADDRESS']; ?>
</td>
          <td align=middle><?php echo $this->_vars['uu']['F_ORDER_ZIPCODE']; ?>
</td>
          <td align=middle><?php echo $this->_vars['uu']['F_ORDER_PHONE']; ?>
</td>
          <td align=middle><?php echo $this->_run_modifier($this->_vars['uu']['F_ORDER_TIME'], 'date', 1, 'm-d H:i'); ?>
</td>
          <td align=middle><?php if ($this->_vars['uu']['F_ORDER_STATUS'] == 1): ?>已处理<?php else: ?>未处理<?php endif; ?></td>
          <td align=middle><a href="/Order/List/Id/<?php echo $this->_vars['uu']['F_ID']; ?>
">查看详情</a></td>
        </tr>
		<?php endforeach; endif; ?>
		  <tr>
    		<th colSpan=8>&nbsp;
      <input type="submit" name="Submit2" value="处理订单" /></th>
  		</tr>
		</table>
</form>
	</td>
  </tr>
  </table>
<table width="95%" border="0" align="center">
  <tr>
    <td><?php echo $this->_vars['list']['JumpBar']; ?>
</td>
  </tr>
</table>
<SCRIPT language=JavaScript type=text/JavaScript>
/**
 * 功能：实现全选
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;
	}
}
/**
 * 功能：检测表单项
 */
function Check()
{
	if($('user').value == 1)											//判断是否有按用户搜索
	{
		if($('keyword').value.trim() == '')									//判断关键字是否为空
		{
			alert('请填写搜索关键字');
			return false;
		}
	}
	return true;
}
/**
 * 功能：隐藏/显示按用户搜索条件
 */
function ChangeUser()
{
	if($('searchuser').style.display == '')									//判断用户搜索条件是否显示
	{
		$('searchuser').style.display = 'none';								//隐藏用户搜索条件
		$('user').value = 0;
		$('disp_user').innerHTML = "显示";
	}else{
		$('searchuser').style.display = '';								//显示用户搜索条件
		$('user').value = 1;
		$('disp_user').innerHTML = "隐藏";
	}
}
/**
 * 功能：隐藏/显示时间搜索条件
 */
function ChangeDate()
{
	if($('date').style.display == '')										//判断时间搜索条件是否显示
	{
		$('date').style.display = 'none';									//隐藏时间搜索条件
		$('time').value = 0;
		$('disp_date').innerHTML = "显示";
	}else{
		$('date').style.display = '';										//显示时间搜索条件
		$('time').value = 1;
		$('disp_date').innerHTML = "隐藏";
	}
}
</SCRIPT>
