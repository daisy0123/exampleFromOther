<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once(INCLUDE_PATH . 'News.inc.php');?>
<?php require_once(INCLUDE_PATH . 'function.inc.php');?>
<?php
$News = new News();
$content = $_POST["SaveContent"];
$time = time();
if (!$_POST['indexsign']) $indexsign = 0;								//�ж��Ƿ�ѡ������ҳ��־
if (!$_POST['sign_top']) $sign_top = 0;								//�ж��Ƿ�ѡ������Ŀ��ҳ��־
if (!$_POST['new_sign']) $new_sign = 0;								//�ж��Ƿ�ѡ���˿�Ѷ��־
if (!$_POST['recsign']) $rec = 0;										//�ж��Ƿ�ѡ�����Ƽ���־
if (!$_POST['sign_hot']) $sign_hot = 0;								//�ж��Ƿ�ѡ�����ȵ��־
if (!$_POST['sign_img']) $sign_img = 0;								//�ж��Ƿ�ѡ����ͼƬ��־
$class = $News->getInfo($_POST['classid'],'EM_CLASS_INFO');
$path = $class['F_CLASS_PATH'];
if($_POST['link'])												//�ж��Ƿ����ύ���ӵ�ַ
	$content = "<script>window.location=\"{$_POST['link']}\";</script>";
$data['F_ID_CLASS_INFO'] = $_POST['classid'];
$data['F_NDT_CAPTION'] = $_POST['caption'];
$data['F_NDT_F_CAPTION'] = $_POST['f_caption'];
$data['F_NDT_KEYWORDS'] = $_POST['keyword'];
$data['F_NDT_CONTENT'] = $content;
if(!$_POST['id'])													//�ж��Ƿ�Ϊ�༭����
{
	$filename = $path . "_content/" . date("Ymd",$time) . "/" . $time . ".{$_POST['file_type']}";
	$file_path = "../.." . $path . "_content/" . date("Ymd",$time) . "/";
	if(!file_exists($file_path))	{									//����Ŀ¼
		mkdirsByPath($file_path);
	}
	$data['F_NDT_TIME'] = $time;
	$data['F_NDT_CONTENT_URL'] = $filename;
	$data['F_NDT_VIEWS'] = 0;
	$data['F_NDT_IS_DEL'] = 0;
	$data['F_NDT_IS_CHECK'] = 0;
	$data['F_NDT_IMG_URL'] = "";
}
$data['F_NDT_IS_RECOMMEND'] = $rec;
$data['F_NDT_IS_INDEX'] = $sign_index;
$data['F_NDT_IS_IMG'] = $sign_img;
$data['F_NDT_IS_CLASS'] = $sign_top;
$data['F_NDT_IS_HOT'] = $sign_hot;
$data['F_NDT_IS_NEW'] = $sign_new;
$data['F_NDT_FROM'] = $_POST['from'];
$data['F_NDT_AUTHOR'] = $_POST['author'];
$data['F_NDT_LINK'] = $_POST['link'];
if($_POST['id'])													//�ж��Ƿ�Ϊ�༭����
{
	$News->updateData("EE_NEWS_DETAIL",$_POST['id'],$data);
}else{
	$News->insertData("EE_NEWS_DETAIL",$data);
}
echo "<p align=center class=caption>�����ɹ�</p>";
echo "<br><p align=center><a href='NewsList.php?id={$_POST['classid']}&MenuId={$_GET['MenuId']}'>�����б�</a></p>";
?>
