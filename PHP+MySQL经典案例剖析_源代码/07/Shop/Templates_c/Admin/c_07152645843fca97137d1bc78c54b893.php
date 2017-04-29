<?php require_once('C:\xampplite\htdocs\07\Lib\Smarty\plugins\modifier.date.php'); $this->register_modifier("date", "tpl_modifier_date"); ?><link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p align="center" class="caption">查看用户详细信息</p>
  <table width="60%" border="0" align="center">
  <tr>
    <th colspan="2" align="left">用户登陆信息</th>
  </tr>
  <tr>
    <td width="26%">用户名：</td>
    <td width="74%"><?php echo $this->_vars['info']['F_LOGIN_NAME']; ?>
</td>
  </tr>
  <tr>
    <td>EMAIL：</td>
    <td><?php echo $this->_vars['info']['F_LOGIN_EMAIL']; ?>
</td>
  </tr>
  <tr>
    <td>是否接收邮件：</td>
    <td><?php if ($this->_vars['info']['F_LOGIN_ACCEPT_EMAIL'] == 1): ?>是<?php else: ?>否<?php endif; ?></td>
  </tr>
  <tr>
    <td>注册时间：</td>
    <td><?php echo $this->_run_modifier($this->_vars['info']['F_LOGIN_TIME'], 'date', 1, "Y-m-d H:i:s"); ?>
</td>
  </tr>
  <tr>
    <th colspan="2" align="left">用户详细信息</th>
  </tr>
  <tr>
    <td>真实姓名：</td>
    <td><?php echo $this->_vars['info']['F_USER_TRUENAME']; ?>
</td>
  </tr>
  <tr>
    <td>用户性别：</td>
    <td><?php if ($this->_vars['info']['F_USER_GENDER'] == 1): ?>男<?php endif; ?>
	   <?php if ($this->_vars['info']['F_USER_GENDER'] == 2): ?>女<?php endif; ?>
	</td>
  </tr>
  <tr>
    <td>所在区域：</td>
    <td><?php echo $this->_vars['info']['F_USER_AREA']; ?>
</td>
  </tr>
  <tr>
    <td>邮政编码：</td>
    <td><?php echo $this->_vars['info']['F_USER_ZIPCODE']; ?>
</td>
  </tr>
  <tr>
    <td>联系地址：</td>
    <td><?php echo $this->_vars['info']['F_USER_ADDRESS']; ?>
</td>
  </tr>
  <tr>
    <td>移动电话：</td>
    <td><?php echo $this->_vars['info']['F_USER_MOBILE']; ?>
</td>
  </tr>
  <tr>
    <td>固定电话：</td>
    <td><?php echo $this->_vars['info']['F_USER_PHONE']; ?>
</td>
  </tr>
  <tr>
    <td>家庭电话：</td>
    <td><?php echo $this->_vars['info']['F_USER_HOME_PHONE']; ?>
</td>
  </tr>
  <tr>
    <th colspan="2"><input type="button" name="Submit" value="返回用户列表" onClick="javascript:window.history.back();"></th>
  </tr>
</table>
