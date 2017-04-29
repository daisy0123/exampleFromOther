<?php
$user_info = $user->getInfo($_SESSION['User']['F_ID'],"EM_USER_INFO");
if($_SERVER['REQUEST_METHOD'] == 'POST')							//判断是否是提交操作
{
	$data = array();
	if($_FILES['file']['size'] > 0)										//判断是否有图片上传
	{
		$result = upload($_FILES['file'],UPLOAD_PATH,MAX_UPLOAD_SIZE);	//处理上传图片
		if($result['errocode'] == 'size_erro')								//判断上传图片是否过大
		{
			echo "图片过大，不能超过200K";
			exit();
		}
		if($result['errocode'] == 'type_erro')								//判断上传文件类型不正确
		{
			echo "上传文件不是图片";
			exit();
		}
		$data['F_USER_HEAD'] = $result['file_name'];
	}
	$data['F_USER_NICKNAME'] = $_POST['nickname'];
	if($_POST['password'])											//判断是否提交密码修改
	{
		$data['F_USER_PASSWORD'] = md5($_POST['password']);
	}
	$data['F_USER_EMAIL'] = $_POST['email'];
	$data['F_USER_QQ'] = $_POST['qq'];
	$data['F_USER_MSN'] = $_POST['msn'];
	if($user->updateData("EM_USER_INFO",$_SESSION['User']['F_ID'],$data))	//判断是否设置成功
	{
		echo "设置成功";
	}
}
?>
<DIV class=wrap>
<H2>个人设置</H2>
<FORM id=register name=register action="Index.php?Action=UserSet" method=post enctype="multipart/form-data">
<FIELDSET>
<LEGEND>名称</LEGEND>
<P><LABEL>用户名: (不能修改)<BR><INPUT disabled value=<?php echo $user_info['F_USER_NAME']?> name=username> 
</LABEL>
<P><LABEL>昵称:<BR><INPUT value=<?php echo $user_info['F_USER_NICKNAME']?> name=nickname></LABEL></FIELDSET> 
<FIELDSET><LEGEND>联系信息</LEGEND>
<P><LABEL>Email: (必填)<BR><INPUT value=<?php echo $user_info['F_USER_EMAIL']?> name=email>
</LABEL></P>
<P><LABEL>QQ:<BR><INPUT name=qq value="<?php echo $user_info['F_USER_QQ']?>"> </LABEL></P>
<P><LABEL>MSN:<BR><INPUT name=msn value="<?php echo $user_info['F_USER_MSN']?>"></LABEL> </P>
<P><LABEL>头像:<BR><input type="file" name="file"><img src="<?php echo ($user_info['F_USER_HEAD']) ? UPLOAD_DIR . $user_info['F_USER_HEAD'] : "/images/default.gif";?>" height="85" width="85" /></LABEL></p>
</LABEL>
</FIELDSET>
<FIELDSET><LEGEND>更改您的密码</LEGEND>
<P class=desc>如果您想更改密码，请在下面的密码框两次输入同一个新密码。否则请保持密码框空白。</P>
<LABEL>新密码:<INPUT type=password size=16 name=password> </LABEL>
<LABEL>请再次输入:<INPUT type=password size=16 name=confirm> </LABEL>
</FIELDSET><br>
<P><INPUT type=submit value="提交个人设置" name=submit> 
</P>
</FORM>
</DIV>
<script language="javascript">
function CheckForm()
{
	if(document.register.password.value != '')
	{
		if(!CheckPassword(document.register.password.value))			//判断密码是否正确
		{
			alert('密码格式不正确');
			document.register.password.focus();
			return false;
		}
		
		if(!CheckConfirm(document.register.Confirm.value))				//判断确认密码是否正确
		{
			alert('确认密码与密码不一致');
			document.register.Confirm.focus();		
			return false;
		}
	}
	if(!CheckNickName(document.register.NickName.value))			//判断昵称是否正确
	{
		alert('昵称不正确');
		document.register.NickName.focus();
		return false;
	}
	if(!CheckEmail(document.register.Email.value))					//判断Email是否正确
	{
		alert('Email格式不正确');
		document.register.Email.focus();
		return false;
	}
}
</script>
