<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once(INCLUDE_PATH . 'User.inc.php');?>
<?php 
$user = new User();
$group = array();
$info = $user->getInfo($_SESSION['F_ID'],"EM_ADMIN_INFO");
if ($_SERVER['REQUEST_METHOD'] == "POST"){							//�ж��Ƿ����ύ����
	$data = array();
	$data['F_USER_PASSWORD'] = md5($_POST['pwd']);
	$user->updateData('EM_ADMIN_INFO',$_SESSION['F_ID'],$data);			//��������
	echo "�޸ĳɹ�";
	echo "<br><a href='EditPwd.php'>����</a>";
	exit();
}
?>
<script language="javascript" src="/Js/Base.js"></script>
<form action="" method="post" name="form1" id="form1" onsubmit="return check_data()">
 <table width="70%" border="0" align="center">
  <tr>
   <th height="23" class="caption">�޸�����</th>
  </tr>
  <tr>
   <td bgcolor="#eeeeee"> 
	<table width="70%" border="0" align="center">
	 <tr> 
	  <td width="18%" align="right">�ʺ�</td>
	  <td width="82%"><?php echo $info['F_USER_NAME']?></td>
	 </tr>
	 <tr> 
	  <td align="right">����</td>
	  <td><input name="pwd" type="password" id="pwd" maxlength="16">
	   ��5��16���ַ����</td>
	 </tr>
	 <tr> 
	  <td align="right">ȷ������</td>
	  <td><input name="pwd2" type="password" id="pwd2" maxlength="16">
	   �ٴ���������</td>
	 </tr>
	</table></td>
  </tr>
  <tr>
   <th align="center"><input type="submit" name="Submit" value="�ύ"> </th>
  </tr>
 </table>
</form>
<script language="JavaScript">
/**
 * ���ܣ�����Ԫ��
 * ���أ�TRUE OR FALSE
 */
function check_data(){
	if ($('pwd').value.trim().len() < 5){									//�ж������Ƿ����
		alert("���벻��С��5���ַ�");
		$('pwd').focus();
		return false;
	}
	if ($('pwd').value.trim().len() > 16){									//�ж������Ƿ����
		alert("���벻�ô���16���ַ�");
		$('pwd').focus();
		return false
	}	
	if ($('pwd').value != $('pwd2').value){									//�ж����������Ƿ�һ��
		alert("������ȷ�����벻��");
		$('pwd').focus();
		return false;
	}
	return true
}
</script>
