<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')							//判断是否为提交操作
{
	if($blog->CheckPassword($blogid,$_POST['password']))					//判断密码是否正确
	{
		$_SESSION['Confirm'] = 1;
		header("Location:?BlogId=" . $blogid);							//正确转向博客首页
	}else{
		$msg = "密码错误";											//错误继续输入密码
		require(TEMPLATE_PATH . "Password.php");
	}
}
?>
