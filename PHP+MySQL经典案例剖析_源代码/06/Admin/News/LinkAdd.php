<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php require_once (INCLUDE_PATH . 'function.inc.php'); ?>
<?php
$News = new News();
$info = $News->getInfo($_GET['id'],"EM_LINK_INFO");
if ($_SERVER["REQUEST_METHOD"] == "POST"){						//�ж��Ƿ��ύ����
	$data['F_LINK_NAME'] = $_POST['name'];
	$data['F_LINK_URL'] = $_POST['url'];
	$data['F_LINK_COLOR'] = $_POST['color'];
	if($_GET['id'])												//�ж��Ƿ�Ϊ�༭״̬
	{
		$News->updateData("EM_LINK_INFO",$_GET['id'],$data);		//����༭��Ϣ
	}else{
		$News->insertData("EM_LINK_INFO",$data);					//���������Ϣ
	}
	echo "�����ɹ�<br><a href='LinkList.php?MenuId={$_GET['MenuId']}'>�����б�</a>";
	exit;
}
?>
<script language="javascript" src="/Js/Base.js"></script>
<form action="" method="post" name="form1" onsubmit="return check_data();">
<p align="center" class="caption">�� �� �� ��</p>
  <table width="70%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td bgcolor="#CCCCCC"><table width="100%"  border="0" cellpadding="0" cellspacing="1">
        <tr>
          <th>&nbsp;</th>
        </tr>
        <tr>
          <td height="60" bgcolor="#FFFFFF"><table width="80%"  border="0" align="center">
            <tr>
              <td width="28%" align="right">�������֣�</td>
              <td width="72%"><input name="name" type="text" id="name" size="30" value="<?php echo $info['F_LINK_NAME']?>"></td>
            </tr>
            <tr>
              <td align="right">���ӵ�ַ��</td>
              <td><input name="url" type="text" id="url" size="30" value="<?php echo $info['F_LINK_URL']?>"></td>
            </tr>
            <tr>
              <td align="right">������ɫ��</td>
              <td><input name="color" type="text" id="color" value="<?php echo $info['F_LINK_COLOR']?>"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <th><input type="submit" name="Submit" value="�ύ">&nbsp;
            <input type="reset" name="Submit" value="����"></th>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<script language="JavaScript" type="text/JavaScript">
function check_data()											//������Ϣ
{
	if($('name').value.trim() == "")									//�ж����������Ƿ�Ϊ��
	{
		alert("����д��������")
		$('name').focus()
		return false
	}
	
	if($('url').value.trim() == "")										//�ж����ӵ�ַ�Ƿ�Ϊ��
	{
		alert("����д���ӵ�ַ")
		$('url').focus()
		return false
	}
return true
}
</script>
