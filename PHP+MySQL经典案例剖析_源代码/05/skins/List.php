<?php
include('header.php');										//����ͷ�ļ�
$page = $_GET['Page'];										//ȡ�õ�ǰҳ��
if(!$page)													//�����ҳ����Ĭ��Ϊ1
	$page = 1;
$cat = $_GET['Cat'];											//ȡ�õ�ǰ����ID
if(!$cat)													//����޷���ID��Ĭ��Ϊ0
	$cat = 0;
$keyword = $_GET['Keywords'];								//ȡ�������ؼ���
if(!$keyword)												//����޹ؼ�����Ĭ��Ϊ��
	$keyword = '';
$date = $_GET['Date'];										//ȡ����������
if(!$date)													//�����������Ĭ��Ϊ��
	$date = '';
$status = 0;												//����ȡ���µ�״̬,Ĭ��Ϊȡ��������
if(!isset($_SESSION['User']['F_ID']))								//������ο�����ȡ����������
{
	$status = 1;
}else{
	if(!($blog_user['F_ID_USER_INFO'] == $_SESSION['User']['F_ID']))	//����ǵ�½�û������ǲ�����
	{													//����ȡ������ֻ����Ա���������б�
		$status = 2;
	}
}
$list = $blog->GetPostList($blogid,$cat,$keyword,$date,$status,$page);	//��������ȡ�����б�
$count = $blog->GetPostCount($blogid,$cat,$keyword,$date,$status);	//��ȡ������Ŀ
$pagecount = ceil($count/$blog->pagesize);						//����ҳ��
if(!$pagecount)												//�������ҳ��Ϊ0��Ĭ��Ϊ1
	$pagecount = 1;
?>
<div id="main">
<div id="left">
<?php
if($list)													//�ж��Ƿ�������
{
	foreach($list as $value)									//ѭ����ʾ����
	{
?>
<div id="post">
<div id="title"><a href='/Index.php?BlogId=<?php echo $blogid?>&Action=Post&Post=<?php echo $value['F_ID']?>'><?php echo $value['F_POSTS_TITLE']?></a></div>
<div id="time"><?php echo date("Y-m-d H:i:s",$value['F_POSTS_ISSUE_DATE'])?></div>
<div id="description">
<?php
if($value['F_POSTS_UPLOAD'])								//�ж��Ƿ����ϴ�ͼƬ
{
	echo ��<img src='" . UPLOAD_PATH . "{$value['F_POSTS_UPLOAD']}' onload='resizePic(this,400)'>";
}
if(mb_strlen($value['F_POSTS_CONTENTS']) > 50)					//�ж�������Ϣ�Ƿ����50���ַ�
	echo mb_substr($value['F_POSTS_CONTENTS'],0,50) . ����";		//��ȡ50���ַ���ʾ
else
	echo $value['F_POSTS_CONTENTS'];						//��ʾ��������
?></div>
<div id="info">
����:<a href='/Index.php?BlogId=<?php echo $blogid?>&Cat=<?php echo $value['CatId']?>'><?php echo $value['F_CATEGORIES_NAME']?></a>
<?php
if($value['F_POSTS_IS_COMMENTED'] AND $blog_info['F_BLOG_COMMENTS'])
{														//�жϸ����º͸ò����Ƿ��������
?>
|<a href='/Index.php?BlogId=<?php echo $blogid?>&Action=Post&Post=<?php echo $value['F_ID']?>#Comments'>����</a>(<?php echo $value['F_POSTS_COMMENTS']?>)
<?php
}
?>
|���ʴ���(<?php echo $value['F_POSTS_VIEWS']?>)</div>
</div>
<?php
	}
}
?>
<div id="page">
<?php $str = Page($pagecount,$page,$blog->pagesize);echo $str;?>	//�����ҳ��Ϣ
</div>
</div>
<div id="right">
<?php require_once("Right.php")?>								//�����Ҳ����ļ�
</div>
</div>
<?php
include('footer.php');											//�����ײ��ļ�
?>
