<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<p class="caption">产品图片</p>
<form action="" method="post" enctype="multipart/form-data" name="frm_add" id="frm_add" onSubmit="return check_data()">
 <table width="400" border="0" align="center">
  <tr>
   	  <th height="23" align="center">产品：<?php echo $this->_vars['info']['F_PRODUCT_NAME']; ?>
</th>
  </tr>
  <tr>
   	  <td height="100" bgcolor="#eeeeee"> 
	  <?php if ($this->_vars['msg']): ?>
		<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td>
			<font color="red">
			<?php if (count((array)$this->_vars['msg'])): foreach ((array)$this->_vars['msg'] as $this->_vars['uu']): ?>
			<p><?php echo $this->_vars['uu']; ?>
</p>
			<?php endforeach; endif; ?>
			</font></td>
          </tr>
        </table>
	 <?php endif; ?>
		<table width="85%" border="0" align="center">
	 <tr> 
	  <td width="18%" height="24" align="right">小图</td>
	  <td width="82%"><input name="small" type="file" id="small"></td>
	 </tr>
	 <?php if ($this->_vars['info']['F_PRODUCT_SMALL_IMG']): ?>
	 <tr>
	   <td height="24" align="right">小图预览</td>
	   <td><a href="<?php echo $this->_vars['upload_path'];  echo $this->_vars['info']['F_PRODUCT_SMALL_IMG']; ?>
"><img src="<?php echo $this->_vars['upload_path'];  echo $this->_vars['info']['F_PRODUCT_SMALL_IMG']; ?>
" width="80" height="80" border="0" /></a></td>
	   </tr>
	 <?php endif; ?>
	 <tr>
	   <td height="24" align="right">大图</td>
	   <td><input name="big" type="file" id="big"></td>
	   </tr>
	 <?php if ($this->_vars['info']['F_PRODUCT_BIG_IMG']): ?>
	 <tr>
	   <td height="24" align="right">大图预览</td>
	   <td><a href="<?php echo $this->_vars['upload_path'];  echo $this->_vars['info']['F_PRODUCT_BIG_IMG']; ?>
"><img src="<?php echo $this->_vars['upload_path'];  echo $this->_vars['info']['F_PRODUCT_BIG_IMG']; ?>
" width="80" height="80" border="0" /></a></td>
	   </tr>
	 <?php endif; ?>
	</table>
	  </td>
  </tr>
  <tr>
   	  <th align="center"> <input type="submit" name="Submit" value="提交">
		<input name="cmdBack" type="button" id="cmdBack" value="返回" onClick="javascript:history.back()">
		<input name="pid" type="hidden" id="pid" value="<?php echo $this->_vars['info']['F_ID']; ?>
"></th>
  </tr>
 </table>
</form>