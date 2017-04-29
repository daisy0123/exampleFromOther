<?php require_once('C:\xampplite\htdocs\07\Lib\Smarty\plugins\modifier.date.php'); $this->register_modifier("date", "tpl_modifier_date"); ?><link href="/Style/Index.css" rel="stylesheet" type="text/css">
<script language='javascript' src='/Js/Base.js'></script>
<script language='javascript' src='/Js/Date.js'></script>
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
<?php if ($this->_vars['action'] == 'Search'): ?>
<table width="100%" border="0">
  <tr>
    <td><p><p>查询结果：</p></p></td>
  </tr>
</table>
<table cellspacing="1" cellpadding="0" width="100%" align="center" 
      bgcolor="#003366" border="0">
  <tbody>
    <tr>
      <td class="STYLE3" valign="center" align="middle" width="15%" 
          bgcolor="#ddf3ff" height="25">时间</td>
      <td class="STYLE3" valign="center" align="middle" width="25%" 
          bgcolor="#ddf3ff" height="25">联系地址</td>
      <td class="STYLE3" valign="center" align="middle" width="16%" 
          bgcolor="#ddf3ff">邮政编码</td>
      <td class="STYLE3" valign="center" align="middle" width="20%" 
          bgcolor="#ddf3ff">联系电话</td>
      <td class="STYLE3" valign="center" align="middle" width="11%" 
          bgcolor="#ddf3ff">状态</td>
      <td class="STYLE3" valign="center" align="middle" width="13%" 
          bgcolor="#ddf3ff">操作</td>
    </tr>
	<?php if (count((array)$this->_vars['list']['data'])): foreach ((array)$this->_vars['list']['data'] as $this->_vars['uu']): ?>
    <tr>
      <td valign="center" bgcolor="#FFFFFF"><?php echo $this->_run_modifier($this->_vars['uu']['F_ORDER_TIME'], 'date', 1, 'Y-m-d'); ?>
</td>
      <td bgcolor="#FFFFFF"><?php echo $this->_vars['uu']['F_ORDER_ADDRESS']; ?>
</td>
      <td bgcolor="#FFFFFF"><?php echo $this->_vars['uu']['F_ORDER_ZIPCODE']; ?>
</td>
      <td bgcolor="#FFFFFF"><?php echo $this->_vars['uu']['F_ORDER_PHONE']; ?>
</td>
      <td bgcolor="#FFFFFF"><?php if ($this->_vars['uu']['F_ORDER_STATUS'] == 1): ?>
		已处理
		<?php else: ?>
		未处理<?php endif; ?></td>
      <td bgcolor="#FFFFFF"><a href="/Order/List/Id/<?php echo $this->_vars['uu']['F_ID']; ?>
" target="_blank">[查看详情]</a></td>
    </tr>
	<?php endforeach; endif; ?>
  </tbody>
</table>
<table width="100%" border="0">
  <tr>
    <td><?php echo $this->_vars['list']['JumpBar']; ?>
</td>
  </tr>
</table>
<?php endif; ?>
</form>
