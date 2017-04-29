<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'Template.inc.php'); ?>
<?php
$Temp = new Temp();
?>
<form name="myform" method="post" action="">
<table width="80%" border="0" align="center">
 <tr>
  <td height="30" class="caption">代码查询</td>
 </tr>
 <tr>
  <td height="80">
    <table width="70%" border="0" align="center">
	<tr> 
	 <th height="30"><U>请从下拉菜单中选择代码</U></th>
	 </tr>
	<tr> 
	 <td height="60" align="center"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
       <tr>
         <td width="53%" align="center"><select name="name" id="name" onChange="codels()">
           <option value="" selected>请选择代码</option>
		   <?php
		   foreach($Temp->code as $key => $code)					//循环输出代码选择框
		   {
		   		echo "<option value='$key'>$code</option>";
		   }
		   ?>
         </select></td>
         <td width="47%" align="center"><input name="code" type="text" id="code" size="25" onclick="javascript:oCopy(this);"></td>
       </tr>
     </table></td>
	 </tr>
	<tr>
	  <th height="30" align="center">点击输入框将自动拷贝相应代码</th>
	  </tr>
   </table>
  </td>
 </tr>
 <tr>
  <td align="center">&nbsp;
  </td>
 </tr>
</table>
</form>
<script language="JavaScript" type="text/JavaScript">
/**
 * 功能：将选择框的值付给输入框
 */
function codels()
{
	var mycode = document.myform.name.options[document.myform.name.selectedIndex].value;
	if (mycode != "")											//判断选择框的值不为空付值
		document.myform.code.value = mycode;
}
/**
 * 功能：复制输入框的内容
 */
function oCopy(obj){
	obj.select(); 
	js=obj.createTextRange();
	js.execCommand("Copy");
	alert("复制成功");
} 
</script>
