<?php
$data = array();
$data['F_ID_BLOG_INFO'] = $blogid;
$data['F_ID_POSTS_INFO'] = $_POST['postid'];
$data['F_ID_USER_INFO'] = $_SESSION['User']['F_ID'];
$data['F_COMMENTS_USER'] = $_POST['username'];
$ip = getenv("REMOTE_ADDR");
$ip1 = getenv("HTTP_X_FORWARDED_FOR");
$ip2 = getenv("HTTP_CLIENT_IP");
($ip1) ? $ip = $ip1 : null ;											//$ip1��ֵ�򸶸�ip
($ip2) ? $ip = $ip2 : null ;											//$ip2��ֵ�򸶸�ip
$longip = ip2long($ip);											//��IPת��Ϊ����
$data['F_COMMENTS_USER_IP'] = $longip;
$data['F_COMMENTS_DATE'] = time();
$data['F_COMMENTS_CONTENT'] = addslashes(htmlspecialchars($_POST['content']));
$blog->UpdatePostsComments($_POST['postid']);						//���¸����µ�������
$blog->insertData('EE_BLOG_COMMENTS',$data);
header("Location:" . urldecode($_GET['ReturnUrl']) . "");
?>
