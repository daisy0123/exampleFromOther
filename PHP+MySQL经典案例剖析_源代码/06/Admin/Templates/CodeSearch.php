<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'Template.inc.php'); ?>
<?php
$Temp = new Temp();
?>
<form name="myform" method="post" action="">
<table width="80%" border="0" align="center">
 <tr>
  <td height="30" class="caption">�����ѯ</td>
 </tr>
 <tr>
  <td height="80">
    <table width="70%" border="0" align="center">
	<tr> 
	 <th height="30"><U>��������˵���ѡ�����</U></th>
	 </tr>
	<tr> 
	 <td height="60" align="center"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
       <tr>
         <td width="53%" align="center"><select name="name" id="name" onChange="codels()">
           <option value="" selected>��ѡ�����</option>
		   <?php
		   foreach($Temp->code as $key => $code)					//ѭ���������ѡ���
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
	  <th height="30" align="center">���������Զ�������Ӧ����</th>
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
 * ���ܣ���ѡ����ֵ���������
 */
function codels()
{
	var mycode = document.myform.name.options[document.myform.name.selectedIndex].value;
	if (mycode != "")											//�ж�ѡ����ֵ��Ϊ�ո�ֵ
		document.myform.code.value = mycode;
}
/**
 * ���ܣ���������������
 */
function oCopy(obj){
	obj.select(); 
	js=obj.createTextRange();
	js.execCommand("Copy");
	alert("���Ƴɹ�");
} 
</script>
