<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once(INCLUDE_PATH . 'News.inc.php'); ?>
<?php require_once(INCLUDE_PATH . 'function.inc.php');?>
<?php
$News = new News();
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if($_POST['default']){												//判断是否设置默认图片
		$sql = "SELECT * FROM EE_NEWS_IMG WHERE F_NIG_DEFAULT = 1 AND F_ID_NEWS_INFO = {$_GET['id']}";
		if($News->select($sql)){										//判断是否存在默认图片
			$sql = "UPDATE EE_NEWS_IMG set F_NIG_DEFAULT = 0 WHERE F_ID_NEWS_INFO = {$_GET['id']}";														//有则设置为0
			$News->update($sql);
		}
	}
	if($_FILES['file']['size'] > 0)										//判断是否有上传图片
	{
		$result = upload($_FILES['file'],UPLOAD_PATH,MAX_UPLOAD_SIZE);	//上传图片
		if($result['errcode'] === 'size_erro')								//判断图片是否过大
		{
			echo "图片过大，不能超过" . MAX_UPLOAD_SIZE . "K";
			echo "<a href='PicList.php?id={$_GET['id']}&MenuId={$_GET['MenuId']}'>返回列表</a>";
			exit();
		}
		if($result['errcode'] === 'type_erro')								//判断文件类型是不是图片
		{
			echo "上传文件不是图片";
			echo "<a href='PicList.php?id={$_GET['id']}&MenuId={$_GET['MenuId']}'>返回列表</a>";
			exit();
		}
		$upload = $result['file_name'];									//取得上传地址
		$data[F_ID_NEWS_INFO] = $_GET['id'];
		$data[F_NIG_IS_DEFAULT] = 1;
		$data[F_NIG_FILENAME] = $upload;
		$data[F_NIG_CAPTION] = $_POST['caption'];
		if($News->insertData("EE_NEWS_IMG",$data))				//判断信息是否处理成功
		{
			echo "上传图片成功<br>";
			echo "<a href='PicList.php?id={$_GET['id']}&MenuId={$_GET['MenuId']}'>返回列表</a>";
			exit();			
		}
	}else{
		echo "你没有上传图片<br>";
		echo "<a href='PicList.php?id={$_GET['id']}&MenuId={$_GET['MenuId']}'>返回列表</a>";
		exit();
	}
}
?>
