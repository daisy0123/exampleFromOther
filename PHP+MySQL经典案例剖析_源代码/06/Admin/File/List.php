<?php
$url = $_GET['url'];
$tmp = substr($url,0,-1);
$tmp = substr($tmp,strrpos($tmp,"/")+1,strlen($tmp));
$handle = opendir("$url");										//��Ŀ¼
$i = 0;
while(readdir($handle))										//ѭ����ȡĿ¼
{
	$i = $i+1;
}
closedir($handle);
$tmp1 = substr($url,0,-1);
$tmp1 = substr($tmp1,0,strrpos($tmp1,"/"));
$tmp1 = $tmp1 . "/";
if($url == "../../")												//���url����../../�򷵻��ϼ�������Ϊ#
	$back_url = "#";
else
	$back_url = "?url=$tmp1";									//������ֵ�����ϼ�Ŀ¼����
$handle = opendir("$url");
$arr_type = array();											//�����ļ�����
$arr_type = array("htm" => "HTML Document","html" => "HTML Document","shtml" => "HTML Document",
	"php" => "PHP �ļ�","asp" => "ASP �ļ�","txt" => "�ı��ļ�","doc" => "DOC Document","sql" => "SQL Script File"
	,"zip" => "WinRAR �����ļ�","rar" => "WinRAR �����ļ�","exe" => "��ִ���ļ�","js" => "JScript Script File","css" => "CSS �ļ�"
	,"bmp" => "ͼƬ�ļ�","gif" => "ͼƬ�ļ�","jpg" => "ͼƬ�ļ�","swf" => "Flash �ļ�");
$img_type = array();											//�����ļ���ʶͼƬ
$img_type = array("htm" => "/Images/html.gif","html" => "/Images/html.gif","shtml" => "/Images/html.gif",
	"php" => "/Images/php.gif","asp" => "/Images/php.gif","txt" => "/Images/txt.gif","doc" => "/Images/txt.gif","sql" => "/Images/txt.gif"
	,"zip" => "/Images/winrar.gif","rar" => "/Images/winrar.gif","exe" => "��ִ���ļ�","js" => "/Images/php.gif","css" => "/Images/txt.gif"
	,"bmp" => "/Images/bmp.gif","gif" => "/Images/gif.gif","jpg" => "/Images/gif.gif","swf" => "/Images/flash.gif");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ļ�����</title>
<link href="/Style/admin.css" rel="stylesheet" type="text/css">
</head>
<base target="_self">
<body>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="22%" valign="top"><table width="96%"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="170"><img src="/Images/logo.gif" width="170" height="72">
          <table width="96%"  border="0">
            <tr>
              <td width="23%">&nbsp;</td>
              <td width="77%"><span class="LogoFont"><?php echo $tmp?></span></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td bgcolor="#0066CC" height="4"></td>
        <td width="1"></td>
      </tr>
    </table>
	  <table width="100%"  border="0">
        <tr>
          <td height="20">�� <?php echo $i?> ���ļ�(��)</td>
        </tr>
        <tr>
          <td height="20">������ģ�</td>
        </tr>
        <tr>
          <td height="20"><a href="<?php echo $back_url?>">���ϼ�Ŀ¼</a></td>
        </tr>
        <tr>
          <td height="20"><a href="javascript:window.close()">����ϵͳ����</a></td>
        </tr>
      </table></td>
    <td width="78%" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="30%" height="25" bgcolor="#666666"><span class="style5">����</span></td>
        <td width="13%" bgcolor="#666666"><span class="style5">��С</span></td>
        <td width="25%" bgcolor="#666666"><span class="style5">����</span></td>
        <td width="21%" bgcolor="#666666"><span class="style5">�޸�ʱ��</span></td>
        <td width="11%" bgcolor="#666666"><span class="style5">����</span></td>
      </tr>
<?php
while($file = readdir($handle))									//ѭ����ʾ�ļ���Ŀ¼
{
	if($file == "." or $file == ".." or $file == "Thumbs.db")				//�ж�Ϊ������ʾ
		continue;
	if(is_dir("$url$file"))										//�ж��Ƿ����ļ���
	{
		$type = "�ļ���";
		$link_url = "?url=$url$file"."/";							//�ļ�������
		$target = "_self";
		$img = "/Images/file.gif";
	}else{
		$back = array();
		$back = explode(".",$file);
		$_back = strtolower($back[count($back)-1]);
		$type = $arr_type[$_back];
		if(!$type)											//�ж��Ƿ����˸��ļ�
			$type = "δ֪";
		$size = number_format(filesize("$url$file")/1024,2);			//ȡ���ļ���С
		$link_url = "$url$file";								//�ļ�����
		$target = "_blank";
		$img = $img_type[$_back];
		if(!$img)											//�ж��Ƿ����˸��ļ���ʶͼƬ
			$img = "/Images/none.gir";
	}
	$arr = array();
	$arr = lstat("$url$files");									//��ȡ�ļ���Ϣ
?>
      <tr>
        <td height="20"><img src="<?php echo $img?>"><a href="<?php echo $link_url?>" target="<?php echo $target?>"><?php echo $file?></a></td>
        <td><?php echo $size?>KB</td>
        <td><?php echo $type?></td>
        <td><?php echo date("Y-m-d",$arr[8])?></td>
        <td><a href="Delete.php?url=<?php echo "$url$file"?>" onClick="return confirm('���Ҫɾ��<?php echo $file?>��?')">ɾ��</a></td>
      </tr>
<?php
}
?>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
