<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once(INCLUDE_PATH . 'News.inc.php');?>
<?php
$News = new News();
$Class = $News->getInfo($_GET['ClassId'],'EM_CLASS_INFO');
$class_list = array();
$News->GetClassListAll();
if($_GET['id'])
{
	$info = $News->getInfo($_GET['id'],"EE_NEWS_DETAIL");
	$checked_index = $info['F_NDT_IS_INDEX'] ? " checked" : "";
	$checked_rec = $info['F_NDT_IS_RECOMMEND'] ? " checked" : "";
	$checked_new = $info['F_NDT_IS_NEW'] ? " checked" : "";
	$checked_hot = $info['F_NDT_IS_HOT'] ? " checked" : "";
	$checked_img = $info['F_NDT_IS_IMG'] ? " checked" : "";
	$checked_top = $info['F_NDT_IS_CLASS'] ? " checked" : "";
	list($front,$back) = explode(".",$info['F_NDT_CONTENT_URL']);
	$editor = "&action=edit&newsid=" . $_GET['id'];
}
?>
<script language='javascript' src='/Js/Base.js'></script>
<div align="center">
  <b>�� �� �� ��</b> </div>
<form action="NewsAddOk.php?MenuId=<?php echo $_GET['MenuId']?>" method="POST" name="myform" id="myform" onsubmit="return CheckForm();">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="p9">
	<tr> 
	  <td height="10"></td>
	</tr>
	<tr align="middle" > 
	  <td height="20" valign="top" bgcolor="#0066FF"> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" bordercolorlight="#000000" bordercolordark="#ffffff" class=p9>
          <tr align="center"> 
            <td height="35" colspan="9" valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="1" class="p9" align="center">
                <tr> 
                  <td width="150" height="30" align="center" bgcolor="#eeeeee">&nbsp;&nbsp;�������</td>
                  <td height="30" colspan="5" bgcolor="#eeeeee"> 
                  <?php
					echo "<select name='classid' id='classid'>";
					foreach($class_list as $class)						//ѭ����ʾ��Ŀ�б�
					{
						echo "<option value='{$class['id']}'";
						if($class['id'] == $_GET['ClassId'] or $class['id'] == $info['F_ID_CLASS_INFO'])	
							echo " selected='selected'";				//��ʾĬ��ѡ��
						echo ">{$class['class']}</option>";
					}
					echo "</select>";
				?>
                  </td>
                </tr>
                <tr> 
                  <td width="150" height="30" align="center" bgcolor="#eeeeee">&nbsp;&nbsp;���ű���</td>
                  <td height="30" colspan="5" bgcolor="#eeeeee"> <input name="caption" id="caption" size="50" value="<?php echo $info['F_NDT_CAPTION']?>" > 
                  </td>
                </tr>
                <tr>
                  <td height="30" align="center" bgcolor="#eeeeee">������</td>
                  <td height="30" colspan="5" bgcolor="#eeeeee"><input name="f_caption" type="text" id="f_caption" size="40" value="<?php echo $info['F_NDT_F_CAPTION']?>"></td>
                </tr>
                <tr> 
                  <td height="30" align="center" bgcolor="#eeeeee">&nbsp;&nbsp;�� �� ��</td>
                  <td height="30" colspan="5" bgcolor="#eeeeee"><input name="keywords" type="text" id="keywords" size="40" value="<?php echo $info['F_NDT_F_KEYWORD']?>">
                    (�ؼ���֮���ö��Ÿ�����</td>
                </tr>
                <tr>
                  <td height="30" align="center" bgcolor="#eeeeee">��Դ</td>
                  <td height="30" colspan="5" bgcolor="#eeeeee"><input name="from" type="text" id="from" size="40" value="<?php echo $info['F_NDT_FROM']?>"></td>
                </tr>
			  <tr>
                  <td height="30" align="center" bgcolor="#eeeeee">����</td>
                  <td height="30" colspan="5" bgcolor="#eeeeee"><input name="author" type="text" id=" author " size="40" value="<?php echo $info['F_NDT_AUTHOR']?>"></td>
                </tr>
                <tr> 
                  <td width="150" height="30" align="center" bgcolor="#eeeeee">������</td>
                  <td height="30" colspan="3" bgcolor="#eeeeee"> <input type="checkbox" name="recsign" value="1"<?php echo $checked_rec?>>
                    �Ƽ����� 
                    <input type="checkbox" name="indexsign" value="1"<?php echo $checked_index?>>
                    ��ҳ���� 
                    <input name="sign_hot" type="checkbox" id="sign_hot" value="1"<?php echo $checked_hot?>>
                    �ȵ����� 
                    <input name="sign_img" type="checkbox" id="sign_img" value="1"<?php echo $checked_img?>>
                    ͼƬ���� 
					<input name="sign_top" type="checkbox" id="sign_top" value="1"<?php echo $checked_top?>>
					��Ŀ��ҳ
                    <input name="new_sign" type="checkbox" id="new_sign" value="1"<?php echo $checked_new?>> 
                    ��Ѷ</td>
                  <td width="64" height="30" bgcolor="#eeeeee">�ļ�����</td>
                  <td width="285" bgcolor="#eeeeee"><input name="file_type" type="text" id="file_type" size="10" value="<?php ($back) ? $back : "shtml"?>">
                    <select name="type" id="type" onChange="typels()">
					<option value="" selected>�ı��ļ���׺</option>
					<?php
					foreach($News->type as $type)
					{
						echo "<option value='$type'>$type</option>";
					}
					?>
                    </select></td>
                </tr>
                <tr>
                  <td height="30" align="center" bgcolor="#eeeeee">���ӵ�ַ</td>
                  <td height="30" colspan="3" bgcolor="#eeeeee"><input name="link" type="text" id="link" size="40" value="<?php echo $info['F_NDT_LINK']?>"></td>
                  <td height="30" bgcolor="#eeeeee">&nbsp;</td>
                  <td bgcolor="#eeeeee">&nbsp;</td>
                </tr>
                <tr> 
                  <td width="150" height="30" align="center" bgcolor="#eeeeee"> 
                    &nbsp;&nbsp;��������</td>
                  <td colspan="5" bgcolor="#eeeeee"></td>
                </tr>					 
                <tr align="center"> 
                  <td colspan="6" valign="top" bgcolor="#eeeeee">
<div align='center'><textarea name='SaveContent' style='display:none'></textarea><iframe ID='editor' src='../../editor/editor.php?dir=news<?php echo $editor?>' frameborder=1 scrolling=no width='600' height='405'></iframe></div></td>
                </tr>
              </table></td>
          </tr>
          <tr align="center"> 
            <td height="25" colspan="9" bgcolor="#FFFFFF"> 
              <input type="submit" name="Submit" value="���"> &nbsp;&nbsp; <input type="reset" name="Submit2" value="���" ><input type="hidden" name="id" value="<?php echo $_GET['id']?>">
            </td>
          </tr>
        </table></td>
	</tr>
	<tr> 
	  <td height="10"></td>
	</tr>
  </table>
</form>
<script language = "JavaScript">
function CheckForm()
{
  if (editor.EditMode.checked==true)								//�жϱ༭���Ƿ��Ǳ༭ģʽ
	  $('SaveContent').value=editor.HtmlEdit.document.body.innerText;
  else
	  $('SaveContent').value=editor.HtmlEdit.document.body.innerHTML; 

  if ($('caption').value.trim() == "")									//�жϱ����Ƿ�Ϊ��
  {
    alert("���ⲻ��Ϊ�գ�");
	$('caption').focus();
	return false;
  }
  if ($('SaveContent').value.trim() == "")								//�ж������Ƿ�Ϊ��
  {
    alert("���ݲ���Ϊ�գ�");
	$('SaveContent').focus();
	return false;
  }
  if ($('SaveContent').value.length>65536)							//�ж������Ƿ����
  {
     alert("����̫������64K�������齫�ֳɼ�����¼�롣");
	$('SaveContent').focus();
	return false;
  }  
  return true;  
}
function typels()
{
	var mytype = $('type').options[$('type').selectedIndex].value;
	if (mytype != "") $('file_type').value = mytype;
}
</script>
