<?php
$post = 0;
if($_GET['PostId'])													//�ж��Ƿ�������ID
{
	$post = $_GET['PostId'];
	$info = $blog->getInfo($post,"EE_BLOG_POSTS");
	if($info['F_ID_USER_INFO'] != $_SESSION['User']['F_ID'])				//�жϴ������Ƿ��Ǹ��û���
	{
		echo "����Ȩ�鿴����";
		exit();
	}
	$title = "<p>���£�{$info['F_POSTS_TITLE']}</p>";
}	
$page = 1;
if($_GET['Page'])													//�ж��Ƿ���ҳ��
	$page = $_GET['Page'];
$list = $blog->GetCommentsList($blogid,$post,$blog->pagesize,$page);
$count = $blog->GetCommentsCount($blogid,$post);
$pagecount = ceil($count/$blog->pagesize);
if(!$pagecount)														//�ж��Ƿ���ҳ��,Ĭ��Ϊ1
	$pagecount = 1;
?>
<div class="wrap">
<h2>����</h2>
<ul>
<?php 
echo $title;
if($list)															//�ж��Ƿ�������
{
	foreach($list as $value)											//ѭ����ʾ����
	{
?>
  <li>
  <p><strong><?php echo $value['F_COMMENTS_USER']?></strong> | 
  IP ��ַ: <?php echo long2ip($value['F_COMMENTS_USER_IP'])?></p>
  <p><?php echo $value['F_COMMENTS_CONTENT']?></P>
  <p><?php echo date("Y-m-d H:i",$value['F_COMMENTS_DATE'])?>  �� 
  [ <a onclick="return confirm('���Ҫɾ����?');" href="Index.php?Action=DelComments&ComId=<?php echo $value['F_ID']?>">ɾ��</a>
   | <a href="/Index.php?BlogId=<?php echo $blogid?>&Post=<?php echo $value['F_ID_POSTS_INFO']?>&Action=Post" target="_blank">�鿴����</a> ]</p></li>
<?php
	}
}
?>
</ul>
<div id="page"><?php echo Page($pagecount,$page,$blog->pagesize)?></div>
</div>
