<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once(INCLUDE_PATH . 'News.inc.php'); ?>
<?php require_once(INCLUDE_PATH . 'function.inc.php');?>
<?php
$News = new News();
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if($_POST['default']){												//�ж��Ƿ�����Ĭ��ͼƬ
		$sql = "SELECT * FROM EE_NEWS_IMG WHERE F_NIG_DEFAULT = 1 AND F_ID_NEWS_INFO = {$_GET['id']}";
		if($News->select($sql)){										//�ж��Ƿ����Ĭ��ͼƬ
			$sql = "UPDATE EE_NEWS_IMG set F_NIG_DEFAULT = 0 WHERE F_ID_NEWS_INFO = {$_GET['id']}";														//��������Ϊ0
			$News->update($sql);
		}
	}
	if($_FILES['file']['size'] > 0)										//�ж��Ƿ����ϴ�ͼƬ
	{
		$result = upload($_FILES['file'],UPLOAD_PATH,MAX_UPLOAD_SIZE);	//�ϴ�ͼƬ
		if($result['errcode'] === 'size_erro')								//�ж�ͼƬ�Ƿ����
		{
			echo "ͼƬ���󣬲��ܳ���" . MAX_UPLOAD_SIZE . "K";
			echo "<a href='PicList.php?id={$_GET['id']}&MenuId={$_GET['MenuId']}'>�����б�</a>";
			exit();
		}
		if($result['errcode'] === 'type_erro')								//�ж��ļ������ǲ���ͼƬ
		{
			echo "�ϴ��ļ�����ͼƬ";
			echo "<a href='PicList.php?id={$_GET['id']}&MenuId={$_GET['MenuId']}'>�����б�</a>";
			exit();
		}
		$upload = $result['file_name'];									//ȡ���ϴ���ַ
		$data[F_ID_NEWS_INFO] = $_GET['id'];
		$data[F_NIG_IS_DEFAULT] = 1;
		$data[F_NIG_FILENAME] = $upload;
		$data[F_NIG_CAPTION] = $_POST['caption'];
		if($News->insertData("EE_NEWS_IMG",$data))				//�ж���Ϣ�Ƿ���ɹ�
		{
			echo "�ϴ�ͼƬ�ɹ�<br>";
			echo "<a href='PicList.php?id={$_GET['id']}&MenuId={$_GET['MenuId']}'>�����б�</a>";
			exit();			
		}
	}else{
		echo "��û���ϴ�ͼƬ<br>";
		echo "<a href='PicList.php?id={$_GET['id']}&MenuId={$_GET['MenuId']}'>�����б�</a>";
		exit();
	}
}
?>
