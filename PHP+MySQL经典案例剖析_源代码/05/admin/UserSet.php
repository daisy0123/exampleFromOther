<?php
$user_info = $user->getInfo($_SESSION['User']['F_ID'],"EM_USER_INFO");
if($_SERVER['REQUEST_METHOD'] == 'POST')							//�ж��Ƿ����ύ����
{
	$data = array();
	if($_FILES['file']['size'] > 0)										//�ж��Ƿ���ͼƬ�ϴ�
	{
		$result = upload($_FILES['file'],UPLOAD_PATH,MAX_UPLOAD_SIZE);	//�����ϴ�ͼƬ
		if($result['errocode'] == 'size_erro')								//�ж��ϴ�ͼƬ�Ƿ����
		{
			echo "ͼƬ���󣬲��ܳ���200K";
			exit();
		}
		if($result['errocode'] == 'type_erro')								//�ж��ϴ��ļ����Ͳ���ȷ
		{
			echo "�ϴ��ļ�����ͼƬ";
			exit();
		}
		$data['F_USER_HEAD'] = $result['file_name'];
	}
	$data['F_USER_NICKNAME'] = $_POST['nickname'];
	if($_POST['password'])											//�ж��Ƿ��ύ�����޸�
	{
		$data['F_USER_PASSWORD'] = md5($_POST['password']);
	}
	$data['F_USER_EMAIL'] = $_POST['email'];
	$data['F_USER_QQ'] = $_POST['qq'];
	$data['F_USER_MSN'] = $_POST['msn'];
	if($user->updateData("EM_USER_INFO",$_SESSION['User']['F_ID'],$data))	//�ж��Ƿ����óɹ�
	{
		echo "���óɹ�";
	}
}
?>
<DIV class=wrap>
<H2>��������</H2>
<FORM id=register name=register action="Index.php?Action=UserSet" method=post enctype="multipart/form-data">
<FIELDSET>
<LEGEND>����</LEGEND>
<P><LABEL>�û���: (�����޸�)<BR><INPUT disabled value=<?php echo $user_info['F_USER_NAME']?> name=username> 
</LABEL>
<P><LABEL>�ǳ�:<BR><INPUT value=<?php echo $user_info['F_USER_NICKNAME']?> name=nickname></LABEL></FIELDSET> 
<FIELDSET><LEGEND>��ϵ��Ϣ</LEGEND>
<P><LABEL>Email: (����)<BR><INPUT value=<?php echo $user_info['F_USER_EMAIL']?> name=email>
</LABEL></P>
<P><LABEL>QQ:<BR><INPUT name=qq value="<?php echo $user_info['F_USER_QQ']?>"> </LABEL></P>
<P><LABEL>MSN:<BR><INPUT name=msn value="<?php echo $user_info['F_USER_MSN']?>"></LABEL> </P>
<P><LABEL>ͷ��:<BR><input type="file" name="file"><img src="<?php echo ($user_info['F_USER_HEAD']) ? UPLOAD_DIR . $user_info['F_USER_HEAD'] : "/images/default.gif";?>" height="85" width="85" /></LABEL></p>
</LABEL>
</FIELDSET>
<FIELDSET><LEGEND>������������</LEGEND>
<P class=desc>�������������룬����������������������ͬһ�������롣�����뱣�������հס�</P>
<LABEL>������:<INPUT type=password size=16 name=password> </LABEL>
<LABEL>���ٴ�����:<INPUT type=password size=16 name=confirm> </LABEL>
</FIELDSET><br>
<P><INPUT type=submit value="�ύ��������" name=submit> 
</P>
</FORM>
</DIV>
<script language="javascript">
function CheckForm()
{
	if(document.register.password.value != '')
	{
		if(!CheckPassword(document.register.password.value))			//�ж������Ƿ���ȷ
		{
			alert('�����ʽ����ȷ');
			document.register.password.focus();
			return false;
		}
		
		if(!CheckConfirm(document.register.Confirm.value))				//�ж�ȷ�������Ƿ���ȷ
		{
			alert('ȷ�����������벻һ��');
			document.register.Confirm.focus();		
			return false;
		}
	}
	if(!CheckNickName(document.register.NickName.value))			//�ж��ǳ��Ƿ���ȷ
	{
		alert('�ǳƲ���ȷ');
		document.register.NickName.focus();
		return false;
	}
	if(!CheckEmail(document.register.Email.value))					//�ж�Email�Ƿ���ȷ
	{
		alert('Email��ʽ����ȷ');
		document.register.Email.focus();
		return false;
	}
}
</script>
