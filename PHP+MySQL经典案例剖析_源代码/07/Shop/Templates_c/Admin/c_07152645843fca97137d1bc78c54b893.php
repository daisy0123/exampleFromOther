<?php require_once('C:\xampplite\htdocs\07\Lib\Smarty\plugins\modifier.date.php'); $this->register_modifier("date", "tpl_modifier_date"); ?><link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p align="center" class="caption">�鿴�û���ϸ��Ϣ</p>
  <table width="60%" border="0" align="center">
  <tr>
    <th colspan="2" align="left">�û���½��Ϣ</th>
  </tr>
  <tr>
    <td width="26%">�û�����</td>
    <td width="74%"><?php echo $this->_vars['info']['F_LOGIN_NAME']; ?>
</td>
  </tr>
  <tr>
    <td>EMAIL��</td>
    <td><?php echo $this->_vars['info']['F_LOGIN_EMAIL']; ?>
</td>
  </tr>
  <tr>
    <td>�Ƿ�����ʼ���</td>
    <td><?php if ($this->_vars['info']['F_LOGIN_ACCEPT_EMAIL'] == 1): ?>��<?php else: ?>��<?php endif; ?></td>
  </tr>
  <tr>
    <td>ע��ʱ�䣺</td>
    <td><?php echo $this->_run_modifier($this->_vars['info']['F_LOGIN_TIME'], 'date', 1, "Y-m-d H:i:s"); ?>
</td>
  </tr>
  <tr>
    <th colspan="2" align="left">�û���ϸ��Ϣ</th>
  </tr>
  <tr>
    <td>��ʵ������</td>
    <td><?php echo $this->_vars['info']['F_USER_TRUENAME']; ?>
</td>
  </tr>
  <tr>
    <td>�û��Ա�</td>
    <td><?php if ($this->_vars['info']['F_USER_GENDER'] == 1): ?>��<?php endif; ?>
	   <?php if ($this->_vars['info']['F_USER_GENDER'] == 2): ?>Ů<?php endif; ?>
	</td>
  </tr>
  <tr>
    <td>��������</td>
    <td><?php echo $this->_vars['info']['F_USER_AREA']; ?>
</td>
  </tr>
  <tr>
    <td>�������룺</td>
    <td><?php echo $this->_vars['info']['F_USER_ZIPCODE']; ?>
</td>
  </tr>
  <tr>
    <td>��ϵ��ַ��</td>
    <td><?php echo $this->_vars['info']['F_USER_ADDRESS']; ?>
</td>
  </tr>
  <tr>
    <td>�ƶ��绰��</td>
    <td><?php echo $this->_vars['info']['F_USER_MOBILE']; ?>
</td>
  </tr>
  <tr>
    <td>�̶��绰��</td>
    <td><?php echo $this->_vars['info']['F_USER_PHONE']; ?>
</td>
  </tr>
  <tr>
    <td>��ͥ�绰��</td>
    <td><?php echo $this->_vars['info']['F_USER_HOME_PHONE']; ?>
</td>
  </tr>
  <tr>
    <th colspan="2"><input type="button" name="Submit" value="�����û��б�" onClick="javascript:window.history.back();"></th>
  </tr>
</table>
