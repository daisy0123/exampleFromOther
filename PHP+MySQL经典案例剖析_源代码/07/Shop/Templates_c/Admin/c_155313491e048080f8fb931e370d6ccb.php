<?php require_once('C:\xampplite\htdocs\07\Lib\Smarty\plugins\function.html_options.php'); $this->register_function("html_options", "tpl_function_html_options");  require_once('C:\xampplite\htdocs\07\Lib\Smarty\plugins\function.html_options.php'); $this->register_function("html_options", "tpl_function_html_options"); ?><link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<form action="/Class/<?php echo $this->_vars['action']; ?>
" method="post" enctype="multipart/form-data" name="frm_add" id="frm_add" onsubmit="return check_data()">
  <table width="85%" border="0" align="center">
    <tr>
   	  <th height="23">
	  <?php if ($this->_vars['action'] == 'Insert'): ?>
	  增加
	  <?php else: ?>
	  编辑
	  <?php endif; ?>产品分类</th>
  </tr>
  <tr>
   	  <td height="100" bgcolor="#eeeeee"> 
		<table border="0" align="center">
          <tr> 
            <td align="right" class="stress">所属类别</td>
            <td class="stress">
			<?php if ($this->_vars['action'] == 'Insert'): ?>
			<?php if ($this->_vars['class_id'] == 0): ?>
			<作为顶级分类><input type="hidden" id="class_id" name="class_id" value="<?php echo $this->_vars['class_id']; ?>
" />
			<?php else: ?>
			<select id="class_id" name="class_id">
			<option value="0">顶级分类</option>
			<?php echo tpl_function_html_options(array('options' => $this->_vars['option'],'selected' => $this->_vars['class_id']), $this);?>
			</select>
			<?php endif; ?>
			<?php else: ?>
			<select id="class_id" name="class_id">
			<option value="0">顶级分类</option>
			<?php echo tpl_function_html_options(array('options' => $this->_vars['option'],'selected' => $this->_vars['info']['F_PARENT_ID']), $this);?>
			</select>			
			<?php endif; ?>
			</td>
          </tr>
          <tr> 
            <td align="right">类别名称<font color="red">*</font></td>
            <td> <input name="name" type="text" id="name" value="<?php echo $this->_vars['info']['F_CLASS_NAME']; ?>
">
              25个汉字以内</td>
          </tr>
          <tr> 
            <td align="right">类别说明</td>
            <td><input name="note" type="text" id="note" value="<?php echo $this->_vars['info']['F_CLASS_NOTE']; ?>
">
              100个汉字以内</td>
          </tr>
          <tr> 
            <td align="right">标识图片</td>
            <td><input name="image" type="file" id="image"style="width:300px"> 
            </td>
          </tr>
          <tr>
            <td align="right">是否使用默认产品属性</td>
            <td><select name="use_default" id="use_default">
                <option value="1"
				<?php if ($this->_vars['info']['F_CLASS_IS_DEFAULT_PROPERTY'] == 1): ?> 	//判断使用默认属性是否为1
				selected="selected"
				<?php endif; ?>>是</option>
                <option value="0"
				<?php if ($this->_vars['info']['F_CLASS_IS_DEFAULT_PROPERTY'] == 0): ?> 	//判断使用默认属性是否为0
				selected="selected"
				<?php endif; ?>>否</option>
              </select></td>
          </tr>
		<?php if ($this->_vars['class_id'] == 0 || $this->_vars['info']['F_PARENT_ID'] == 0): ?>	
          <tr id='parent_property'> 
            <td align="right">是否使用继承父类别属性</td>
            <td><select name="use_parent_property" id="use_parent_property">
                <option value="1"
				<?php if ($this->_vars['info']['F_CLASS_IS_PARENT_PROPERTY'] == 1): ?> 	//判断继承父属性是否为1
				selected="selected"
				<?php endif; ?>>是</option>
                <option value="0"
				<?php if ($this->_vars['info']['F_CLASS_IS_PARENT_PROPERTY'] == 0): ?> 	//判断继承父属性是否为0
				selected="selected"
				<?php endif; ?>>否</option>
              </select></td>
          </tr>
 		<?php endif; ?>
        </table>
	  </td>
  </tr>
  <tr>
   	  <th align="center">
	  <input type="submit" name="Submit" value="提交">
	  <input name="id" type="hidden" id="id" value="<?php echo $this->_vars['info']['F_ID']; ?>
" /></th>
  </tr>
 </table>
</form>
<script language='javascript'>
/**
 * 功能：检测表单项
 */
function check_data(){
	if ($('name').value.trim() == ''){									//判断类别名称是否为空
		alert("类别名称不得为空")
		$('name').focus()
		return false
	}
	return true;
}
</script>
