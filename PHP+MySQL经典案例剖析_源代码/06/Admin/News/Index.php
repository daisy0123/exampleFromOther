<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$sql = "SELECT * FROM EM_INDEX_INFO";
$r = $News->select($sql);
$info = $r[0];
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ�Ϊ�ύ����
{
	$data['F_INDEX_NAME'] = $_POST['file_name'];
	$data['F_INDEX_TEMPLATE_URL'] = $_POST['template_url'];
	if($info)													//�ж��Ƿ�Ϊ�༭״̬
	{
		$sql = "UPDATE EM_INDEX_INFO SET F_INDEX_NAME = {$_POST['file_name']}";
		$sql .= ",F_INDEX_TEMPLATE_URL = ��{$_POST['template_url']}��;";
		if($News->update ($sql))									//�ж��Ƿ�����ɹ�
		{
			echo "���óɹ�<br>";
			echo "<a href='Index.php?MenuId={$_GET['MenuId']}'>������ҳ����</a>";
			exit;
		}
	}else{
		if($News->insertData("EM_INDEX_INFO",$data))				//�ж��Ƿ�����ɹ�
		{
			echo "���óɹ�<br>";
			echo "<a href='Index.php?MenuId={$_GET['MenuId']}'>������ҳ����</a>";
			exit;
		}
	}
}
?>
<script language="javascript" src="/Js/Base.js"></script>
<form name="myform" action="" method="post">
<table width="80%" border="0" align="center">
  <tr>
    <td height="30" class="caption">��ҳ����</td>
  </tr>
  <tr>
    <td height="80"><table width="75%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#666666"><table width="100%"  border="0">
          <tr>
            <td width="26%" height="25" align="center"><span style="color: #FFCC00">��ҳģ��</span></td>
            <td width="74%"><input name="template_url" type="text" id="template_url" size="30" value="<?php echo $info['F_INDEX_TEMPLATE_URL']?>">
              <input type="button" name="Submit" value="ѡ��ģ��.." style="BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; BORDER-BOTTOM-WIDTH: 1px; BORDER-RIGHT-WIDTH: 1px" onClick="select_template()"></td>
          </tr>
          <tr>
            <td height="25" align="center"><span style="color: #FFCC00">�ļ�����</span></td>
            <td><input name="file_name" type="text" id="file_name" value="<?php echo $info[F_INDEX_NAME]?>"></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><input type="submit" name="Submit" value="�� ��">
    &nbsp;<input type="button" name="Submit" value="ˢ ��" onClick="window.location='GenIndex.php?MenuId=<?php echo $_GET['MenuId']?>'">
    </td>
  </tr>
</table>
</form>
<script language='javascript'>
function check_data(){
	if ($('template_url').value.trim() == ''){								//�ж���ҳģ���Ƿ�Ϊ��
		alert("��ҳģ�岻��Ϊ��");
		$('template_url').focus();
		return false;
	}
	if ($('file_name').value.trim() == ''){								//�ж��ļ����Ƿ�Ϊ��
		alert("�ļ����Ʋ���Ϊ��");
		$('file_name').focus();
		return false;
	}
	return true;
}
/**
 * ����ģ��ѡ����ҳ�Ի���
 */
function select_template(){
	var w=650;h=550;
	var theDes	="status:no;center:yes;help:no;minimize:yes;maximize:yes;dialogWidth:"+w+"px;scroll:auto;dialogHeight:"+h+"px;border:think";
	var rv	=window.showModalDialog("../Template/Select.php",null,theDes);
	if(rv){
		document.myform.template_url.value = rv;
	}
}
</script>
