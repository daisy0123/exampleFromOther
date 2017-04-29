<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language='javascript' src='/Js/Base.js'></script>
<p class="caption">显示参数设置</p>
<form action="" method="post" name="frm_set" id="frm_set" onSubmit="return check_data()">
  <table width="70%" border="0" align="center">
	<tr> 
	  <th>类别：<?php echo $this->_vars['info']['F_CLASS_NAME']; ?>
</th>
	</tr>
	<tr> 
	  <td bgcolor="#eeeeee"><table border="0" align="center">
		  <tr>
		    <td height="23" class="stress">类别图片</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td height="23" align="right">预览图片</td>
		    <td><input name="img_default" type="checkbox" id="img_default" onchange="img_default_onchange()" value="1"
<?php if ($this->_vars['info']['F_CLASS_IMG_DEFAULT']): ?>
 Checked
<?php endif; ?> />默认 </td>
		    <td>宽度
              <input name="img_width" type="text" id="img_width" value="<?php echo $this->_vars['info']['F_CLASS_IMG_WIDTH']; ?>
" size="10"
 <?php if ($this->_vars['info']['F_CLASS_IMG_DEFAULT']): ?>
 disabled
<?php endif; ?> />
像素</td>
		    <td>高度
              <input name="img_height" type="text" id="img_height" value="<?php echo $this->_vars['info']['F_CLASS_IMG_HEIGHT']; ?>
" size="10"
<?php if ($this->_vars['info']['F_CLASS_IMG_DEFAULT']): ?>
 disabled
<?php endif; ?> />
像素</td>
	      </tr>
		  <tr> 
			<td height="23" class="stress">产品图片</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr> 
			<td height="23" align="right">预览图片</td>
			<td><input name="small_default" type="checkbox" id="small_default" onChange="small_default_onchange()" value="1"
<?php if ($this->_vars['info']['F_CLASS_SMALL_IMG_DEFAULT']): ?>
 checked
<?php endif; ?> />
			  默认 </td>
			<td>宽度 
			  <input name="small_width" type="text" id="small_width" value="<?php echo $this->_vars['info']['F_CLASS_SMALL_IMG_WIDTH']; ?>
" size="10"
<?php if ($this->_vars['info']['F_CLASS_SMALL_IMG_DEFAULT']): ?>
 disabled
<?php endif; ?> />像素 </td>
			<td>高度 
			  <input name="small_height" type="text" id="small_height" value="<?php echo $this->_vars['info']['F_CLASS_SMALL_IMG_HEIGHT']; ?>
" size="10"
<?php if ($this->_vars['info']['F_CLASS_SMALL_IMG_DEFAULT']): ?>
 disabled
<?php endif; ?> /> 像素</td>
		  </tr>
		  <tr> 
			<td height="23" align="right">大图片</td>
			<td><input name="big_default" type="checkbox" id="big_default" onChange="big_default_onchange()" value="1"
<?php if ($this->_vars['info']['F_CLASS_BIG_IMG_DEFAULT']): ?>
 checked
<?php endif; ?> />默认 </td>
			<td>宽度 
			  <input name="big_width" type="text" id="big_width" value="<?php echo $this->_vars['info']['F_CLASS_BIG_IMG_WIDTH']; ?>
" size="10"
<?php if ($this->_vars['info']['F_CLASS_BIG_IMG_DEFAULT']): ?>
 disabled
<?php endif; ?> />像素 </td>
			<td>高度 
			  <input name="big_height" type="text" id="big_height" value="<?php echo $this->_vars['info']['F_CLASS_BIG_IMG_HEIGHT']; ?>
" size="10"
<?php if ($this->_vars['info']['F_CLASS_BIG_IMG_DEFAULT']): ?>
 disabled
<?php endif; ?>>像素</td>
		  </tr>
		  <tr> 
			<td height="23" class="stress">每页产品数</td>
			<td height="23"> <input name="pagesize_default" type="checkbox" id="pagesize_default" onChange="pagesize_default_onchange()" value="1"
<?php if ($this->_vars['info']['F_CLASS_PAGESIZE_DEFAULT']): ?>
 checked
<?php endif; ?> />默认 </td>
			<td height="23"> 每页 
			  <input name="pagesize" type="text" id="pagesize" value="<?php echo $this->_vars['info']['F_CLASS_PAGESIZE']; ?>
" size="10" 
<?php if ($this->_vars['info']['F_CLASS_PAGESIZE_DEFAULT']): ?>
 disabled
<?php endif; ?> />个 </td>
			<td height="23">&nbsp;</td>
		  </tr>
		  <tr> 
			<td height="23" class="stress">每行产品数</td>
			<td height="23"> <input name="perline_default" type="checkbox" id="perline_default" onChange="perline_default_onchange()" value="1"
<?php if ($this->_vars['info']['F_CLASS_PERLINE_DEFAULT']): ?>
 checked
<?php endif; ?> />默认 </td>
			<td height="23"> 每行 
			  <input name="perline" type="text" id="perline" value="<?php echo $this->_vars['info']['F_CLASS_PERLINE']; ?>
" size="10"
<?php if ($this->_vars['info']['F_CLASS_PERLINE_DEFAULT']): ?>
 disabled
<?php endif; ?> />个 </td>
			<td height="23">&nbsp;</td>
		  </tr>
		  <tr> 
			<td height="1" colspan="4" bgcolor="#000000"></td>
		  </tr>
		  <tr> 
			<td height="23" colspan="4" class="stress">说明：1、选择默认时，相应设置无效； <br>
			  　　　2、自定义设置时，输入应大于0；<br>
			  　　　2、每页产品数应该是每行产品数的倍数。</td>
		  </tr>
		</table></td>
	</tr>
	<tr> 
	  <th><input type="submit" name="Submit" value="提交">
		<input name="cmdBack" type="button" id="cmdBack" value="返回" onclick="javascript:history.back()">
	  </th>
	</tr>
  </table>
</form>
<script language="JavaScript1.2">
/**
 * 功能：判断输入值是否为数字
 */
function isNumberFloat(inputString){
  return (!isNaN(parseInt(inputString))) ? true : false;
}
/**
 * 功能：改变类别图片宽高输入框状态
 */
function img_default_onchange(){
	$('img_width').disabled = $('img_default').checked
	$('img_height').disabled = $('img_default').checked
	if (!$('img_height').disabled)								//判断高度输入框是否可写
		$('img_width').focus()
}
/**
 * 功能：改变产品小图宽高输入框状态
 */
function small_default_onchange(){
	$('small_width').disabled = $('small_default').checked
	$('small_height').disabled = $('small_default').checked
	if (!$('small_height').disabled) 								//判断小图高度输入框是否可写
		$('small_width').focus()
}
/**
 * 功能：改变产品大图宽高输入框状态
 */
function big_default_onchange(){
	$('big_width').disabled = $('big_default').checked
	$('big_height').disabled = $('big_default').checked
	if (!$('big_height').disabled) 								//判断大图高度输入框是否可写
		$('big_width').focus()
}
/**
 * 功能：改变每页产品数输入框状态
 */
function pagesize_default_onchange(){
	$('pagesize').disabled = $('pagesize_default').checked
	if (!$('pagesize').disabled) 								//判断每页产品数是否可写
		$('pagesize').focus()
}
/**
 * 功能：改变每行产品数输入框状态
 */
function perline_default_onchange(){
	$('perline').disabled = $('perline_default').checked
	if (!$('perline').disabled) 								//判断每行产品数是否可写
		$('perline').focus()
}
/**
 * 功能：检测表单项
 */
function check_data(){
	if (!$('img_default').checked){							//判断是否选择类别图片默认选项
		if (!isNumberFloat($('img_width').value) || $('img_width').value <= 0){
			alert("类别预览图片宽度未设置或设置不正确");		//判断输入宽度是否为数字和大于0
			$('img_width').focus();
			return false;
		}
		if (!isNumberFloat($('img_height').value) || $('img_height').value <= 0){
			alert("产品预览图片高度未设置或设置不正确");		//判断输入高度是否为数字和大于0
			$('img_height').focus();
			return false;
		}
	}
	if (!$('small_default').checked){ 						//判断是否选择小图片默认选项
		if (!isNumberFloat($('small_width').value) || $('small_width').value <= 0){
			alert("产品预览图片宽度未设置或设置不正确");		//判断输入宽度是否为数字和大于0
			$('small_width').focus();
			return false;
		}
		if (!isNumberFloat($('small_height').value) || $('small_height').value <= 0){
			alert("产品预览图片高度未设置或设置不正确");		//判断输入高度是否为数字和大于0
			$('small_height').focus();
			return false;
		}
	}
	if (!$('big_default').checked){ 							//判断是否选择大图片默认选项
		if (!isNumberFloat($('big_width').value) || $('big_width').value <= 0){
			alert("产品大图片宽度未设置或设置不正确");		//判断输入宽度是否为数字和大于0
			$('big_width').focus();
			return false;
		}
		if (!isNumberFloat($('big_height').value) || $('big_height').value <= 0){
			alert("产品大图片高度未设置或设置不正确");		//判断输入高度是否为数字和大于0
			$('big_height').focus();
			return false;
		}
	}
	if (!$('pagesize_default').checked){ 						//判断是否选择每页产品数默认选项
		if (!isNumberFloat($('pagesize').value) || $('pagesize').value <= 0){
			alert("每页显示图片数未设置或设置不正确");		//判断输入每页产品数是否为数字和大于0
			$('pagesize').focus();
			return false;
		}
	}
	if (!$('perline_default').checked){ 						//判断是否选择每行产品数默认选项
		if (!isNumberFloat($('perline').value) || $('perline').value <= 0){
			alert("每行显示图片数未设置或设置不正确");		//判断输入每行产品数是否为数字和大于0
			$('perline').focus();
			return false;
		}
	}
	$('small_width').value = parseInt($('small_width').value)
	$('small_height').value = parseInt($('small_height').value)
	$('big_width').value = parseInt($('big_width').value)
	$('big_height').value = parseInt($('big_height').value)
	$('pagesize').value = parseInt($('pagesize').value)
	$('perline').value = parseInt($('perline').value)
	return true;
}
</script>
