<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')							//�ж��Ƿ�Ϊ�ύ����
{
	if($blog->CheckPassword($blogid,$_POST['password']))					//�ж������Ƿ���ȷ
	{
		$_SESSION['Confirm'] = 1;
		header("Location:?BlogId=" . $blogid);							//��ȷת�򲩿���ҳ
	}else{
		$msg = "�������";											//���������������
		require(TEMPLATE_PATH . "Password.php");
	}
}
?>
