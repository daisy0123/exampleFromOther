<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language='javascript' src='/Js/Base.js'></script>
<p class="caption">��ʾ��������</p>
<form action="" method="post" name="frm_set" id="frm_set" onSubmit="return check_data()">
  <table width="70%" border="0" align="center">
	<tr> 
	  <th>���<?php echo $this->_vars['info']['F_CLASS_NAME']; ?>
</th>
	</tr>
	<tr> 
	  <td bgcolor="#eeeeee"><table border="0" align="center">
		  <tr>
		    <td height="23" class="stress">���ͼƬ</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td height="23" align="right">Ԥ��ͼƬ</td>
		    <td><input name="img_default" type="checkbox" id="img_default" onchange="img_default_onchange()" value="1"
<?php if ($this->_vars['info']['F_CLASS_IMG_DEFAULT']): ?>
 Checked
<?php endif; ?> />Ĭ�� </td>
		    <td>���
              <input name="img_width" type="text" id="img_width" value="<?php echo $this->_vars['info']['F_CLASS_IMG_WIDTH']; ?>
" size="10"
 <?php if ($this->_vars['info']['F_CLASS_IMG_DEFAULT']): ?>
 disabled
<?php endif; ?> />
����</td>
		    <td>�߶�
              <input name="img_height" type="text" id="img_height" value="<?php echo $this->_vars['info']['F_CLASS_IMG_HEIGHT']; ?>
" size="10"
<?php if ($this->_vars['info']['F_CLASS_IMG_DEFAULT']): ?>
 disabled
<?php endif; ?> />
����</td>
	      </tr>
		  <tr> 
			<td height="23" class="stress">��ƷͼƬ</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr> 
			<td height="23" align="right">Ԥ��ͼƬ</td>
			<td><input name="small_default" type="checkbox" id="small_default" onChange="small_default_onchange()" value="1"
<?php if ($this->_vars['info']['F_CLASS_SMALL_IMG_DEFAULT']): ?>
 checked
<?php endif; ?> />
			  Ĭ�� </td>
			<td>��� 
			  <input name="small_width" type="text" id="small_width" value="<?php echo $this->_vars['info']['F_CLASS_SMALL_IMG_WIDTH']; ?>
" size="10"
<?php if ($this->_vars['info']['F_CLASS_SMALL_IMG_DEFAULT']): ?>
 disabled
<?php endif; ?> />���� </td>
			<td>�߶� 
			  <input name="small_height" type="text" id="small_height" value="<?php echo $this->_vars['info']['F_CLASS_SMALL_IMG_HEIGHT']; ?>
" size="10"
<?php if ($this->_vars['info']['F_CLASS_SMALL_IMG_DEFAULT']): ?>
 disabled
<?php endif; ?> /> ����</td>
		  </tr>
		  <tr> 
			<td height="23" align="right">��ͼƬ</td>
			<td><input name="big_default" type="checkbox" id="big_default" onChange="big_default_onchange()" value="1"
<?php if ($this->_vars['info']['F_CLASS_BIG_IMG_DEFAULT']): ?>
 checked
<?php endif; ?> />Ĭ�� </td>
			<td>��� 
			  <input name="big_width" type="text" id="big_width" value="<?php echo $this->_vars['info']['F_CLASS_BIG_IMG_WIDTH']; ?>
" size="10"
<?php if ($this->_vars['info']['F_CLASS_BIG_IMG_DEFAULT']): ?>
 disabled
<?php endif; ?> />���� </td>
			<td>�߶� 
			  <input name="big_height" type="text" id="big_height" value="<?php echo $this->_vars['info']['F_CLASS_BIG_IMG_HEIGHT']; ?>
" size="10"
<?php if ($this->_vars['info']['F_CLASS_BIG_IMG_DEFAULT']): ?>
 disabled
<?php endif; ?>>����</td>
		  </tr>
		  <tr> 
			<td height="23" class="stress">ÿҳ��Ʒ��</td>
			<td height="23"> <input name="pagesize_default" type="checkbox" id="pagesize_default" onChange="pagesize_default_onchange()" value="1"
<?php if ($this->_vars['info']['F_CLASS_PAGESIZE_DEFAULT']): ?>
 checked
<?php endif; ?> />Ĭ�� </td>
			<td height="23"> ÿҳ 
			  <input name="pagesize" type="text" id="pagesize" value="<?php echo $this->_vars['info']['F_CLASS_PAGESIZE']; ?>
" size="10" 
<?php if ($this->_vars['info']['F_CLASS_PAGESIZE_DEFAULT']): ?>
 disabled
<?php endif; ?> />�� </td>
			<td height="23">&nbsp;</td>
		  </tr>
		  <tr> 
			<td height="23" class="stress">ÿ�в�Ʒ��</td>
			<td height="23"> <input name="perline_default" type="checkbox" id="perline_default" onChange="perline_default_onchange()" value="1"
<?php if ($this->_vars['info']['F_CLASS_PERLINE_DEFAULT']): ?>
 checked
<?php endif; ?> />Ĭ�� </td>
			<td height="23"> ÿ�� 
			  <input name="perline" type="text" id="perline" value="<?php echo $this->_vars['info']['F_CLASS_PERLINE']; ?>
" size="10"
<?php if ($this->_vars['info']['F_CLASS_PERLINE_DEFAULT']): ?>
 disabled
<?php endif; ?> />�� </td>
			<td height="23">&nbsp;</td>
		  </tr>
		  <tr> 
			<td height="1" colspan="4" bgcolor="#000000"></td>
		  </tr>
		  <tr> 
			<td height="23" colspan="4" class="stress">˵����1��ѡ��Ĭ��ʱ����Ӧ������Ч�� <br>
			  ������2���Զ�������ʱ������Ӧ����0��<br>
			  ������2��ÿҳ��Ʒ��Ӧ����ÿ�в�Ʒ���ı�����</td>
		  </tr>
		</table></td>
	</tr>
	<tr> 
	  <th><input type="submit" name="Submit" value="�ύ">
		<input name="cmdBack" type="button" id="cmdBack" value="����" onclick="javascript:history.back()">
	  </th>
	</tr>
  </table>
</form>
<script language="JavaScript1.2">
/**
 * ���ܣ��ж�����ֵ�Ƿ�Ϊ����
 */
function isNumberFloat(inputString){
  return (!isNaN(parseInt(inputString))) ? true : false;
}
/**
 * ���ܣ��ı����ͼƬ��������״̬
 */
function img_default_onchange(){
	$('img_width').disabled = $('img_default').checked
	$('img_height').disabled = $('img_default').checked
	if (!$('img_height').disabled)								//�жϸ߶�������Ƿ��д
		$('img_width').focus()
}
/**
 * ���ܣ��ı��ƷСͼ��������״̬
 */
function small_default_onchange(){
	$('small_width').disabled = $('small_default').checked
	$('small_height').disabled = $('small_default').checked
	if (!$('small_height').disabled) 								//�ж�Сͼ�߶�������Ƿ��д
		$('small_width').focus()
}
/**
 * ���ܣ��ı��Ʒ��ͼ��������״̬
 */
function big_default_onchange(){
	$('big_width').disabled = $('big_default').checked
	$('big_height').disabled = $('big_default').checked
	if (!$('big_height').disabled) 								//�жϴ�ͼ�߶�������Ƿ��д
		$('big_width').focus()
}
/**
 * ���ܣ��ı�ÿҳ��Ʒ�������״̬
 */
function pagesize_default_onchange(){
	$('pagesize').disabled = $('pagesize_default').checked
	if (!$('pagesize').disabled) 								//�ж�ÿҳ��Ʒ���Ƿ��д
		$('pagesize').focus()
}
/**
 * ���ܣ��ı�ÿ�в�Ʒ�������״̬
 */
function perline_default_onchange(){
	$('perline').disabled = $('perline_default').checked
	if (!$('perline').disabled) 								//�ж�ÿ�в�Ʒ���Ƿ��д
		$('perline').focus()
}
/**
 * ���ܣ�������
 */
function check_data(){
	if (!$('img_default').checked){							//�ж��Ƿ�ѡ�����ͼƬĬ��ѡ��
		if (!isNumberFloat($('img_width').value) || $('img_width').value <= 0){
			alert("���Ԥ��ͼƬ���δ���û����ò���ȷ");		//�ж��������Ƿ�Ϊ���ֺʹ���0
			$('img_width').focus();
			return false;
		}
		if (!isNumberFloat($('img_height').value) || $('img_height').value <= 0){
			alert("��ƷԤ��ͼƬ�߶�δ���û����ò���ȷ");		//�ж�����߶��Ƿ�Ϊ���ֺʹ���0
			$('img_height').focus();
			return false;
		}
	}
	if (!$('small_default').checked){ 						//�ж��Ƿ�ѡ��СͼƬĬ��ѡ��
		if (!isNumberFloat($('small_width').value) || $('small_width').value <= 0){
			alert("��ƷԤ��ͼƬ���δ���û����ò���ȷ");		//�ж��������Ƿ�Ϊ���ֺʹ���0
			$('small_width').focus();
			return false;
		}
		if (!isNumberFloat($('small_height').value) || $('small_height').value <= 0){
			alert("��ƷԤ��ͼƬ�߶�δ���û����ò���ȷ");		//�ж�����߶��Ƿ�Ϊ���ֺʹ���0
			$('small_height').focus();
			return false;
		}
	}
	if (!$('big_default').checked){ 							//�ж��Ƿ�ѡ���ͼƬĬ��ѡ��
		if (!isNumberFloat($('big_width').value) || $('big_width').value <= 0){
			alert("��Ʒ��ͼƬ���δ���û����ò���ȷ");		//�ж��������Ƿ�Ϊ���ֺʹ���0
			$('big_width').focus();
			return false;
		}
		if (!isNumberFloat($('big_height').value) || $('big_height').value <= 0){
			alert("��Ʒ��ͼƬ�߶�δ���û����ò���ȷ");		//�ж�����߶��Ƿ�Ϊ���ֺʹ���0
			$('big_height').focus();
			return false;
		}
	}
	if (!$('pagesize_default').checked){ 						//�ж��Ƿ�ѡ��ÿҳ��Ʒ��Ĭ��ѡ��
		if (!isNumberFloat($('pagesize').value) || $('pagesize').value <= 0){
			alert("ÿҳ��ʾͼƬ��δ���û����ò���ȷ");		//�ж�����ÿҳ��Ʒ���Ƿ�Ϊ���ֺʹ���0
			$('pagesize').focus();
			return false;
		}
	}
	if (!$('perline_default').checked){ 						//�ж��Ƿ�ѡ��ÿ�в�Ʒ��Ĭ��ѡ��
		if (!isNumberFloat($('perline').value) || $('perline').value <= 0){
			alert("ÿ����ʾͼƬ��δ���û����ò���ȷ");		//�ж�����ÿ�в�Ʒ���Ƿ�Ϊ���ֺʹ���0
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
