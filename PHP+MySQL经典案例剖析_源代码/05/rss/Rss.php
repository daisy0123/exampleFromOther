<?php
header("Content-type: application/xml");								//����ͷ��Ϣ
require_once("../config.inc.php");
require_once(INCLUDE_PATH . "db.inc.php");
$db = new DBSQL();
$blogid = $_GET['BlogId'];
if(!$blogid)													//�ж��Ƿ���BlogId����
{
	echo "��������";
	exit();
}
$info = $db->getInfo($blogid,"EM_BLOG_INFO");						//��ȡBlog��Ϣ
$sql = "SELECT u.F_USER_EMAIL FROM EE_BLOG_USER b,EM_USER_INFO u";
$sql .= " WHERE b.F_ID_BLOG_INFO = $blogid AND b.F_ID_USER_INFO = u.F_ID";
$user = $db->select($sql);											//��ȡ�û�EMAIL��Ϣ
$email = $user[0][0];
$sql = "SELECT c.F_CATEGORIES_NAME,p.F_POSTS_TITLE,p.F_POSTS_CONTENTS,p.F_ID";
$sql .= ",p.F_POSTS_ISSUE_DATE FROM EE_BLOG_CATEGORIES c,EE_BLOG_POSTS p";
$sql .= " WHERE c.F_ID_BLOG_INFO = $blogid AND c.F_ID = p.F_ID_CATEGORIES";
$list = $db->select($sql);											//��ȡ�����б�
$str = "<?xml version='1.0' encoding='gb2312'?>\n";
$str .= "<rss version='2.0'>\n";
$str .= "<channel>\n";
$str .= "<title>{$info['F_BLOG_NAME']}</title>\n";
$str .= "<link>http://blog.xxx.com</link>\n";
$str .= "<description>{$info['F_BLOG_DESCRIPTION']}</description>\n";
$str .= "<language>zh-cn</language>\n";
if($list)														//�ж��Ƿ�������
{
	foreach($list as $value)										//ѭ����ʾ����
	{
		
		$str .= "<item>\n";
		$str .= "<title>{$value['F_POSTS_TITLE']}</title>\n";
		$str .= "<description>{$value['F_POSTS_CONTENTS']}</description>\n";
		$str .= "<link>http://blog.xxx.com/?BlogId=$blogid&amp;Action=Post&amp;Post={$value['F_ID']}</link>\n";
		$str .= "<category>{$value['F_CATEGORIES_NAME']}</category>\n";
		$str .= "<author>$email</author>\n";
		$str .= "<pubDate>" . date(DATE_RFC822,$value['F_POSTS_ISSUE_DATE']) . "</pubDate>\n";
		$str .= "<comments>http://blog.xxx.com/?BlogId=$blogid&amp;Action=Post&amp;Post={$value['F_ID']}#comments</comments>\n";
		$str .= "</item>\n";
	}
}
$str .= "</channel>";
$str .= "</rss>";
echo $str;
?>
