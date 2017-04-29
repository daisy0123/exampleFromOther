<?php
$url = $_GET['url'];
$tmp = substr($url,0,-1);
$tmp = substr($tmp,strrpos($tmp,"/")+1,strlen($tmp));
$handle = opendir("$url");										//打开目录
$i = 0;
while(readdir($handle))										//循环读取目录
{
	$i = $i+1;
}
closedir($handle);
$tmp1 = substr($url,0,-1);
$tmp1 = substr($tmp1,0,strrpos($tmp1,"/"));
$tmp1 = $tmp1 . "/";
if($url == "../../")												//如果url等于../../则返回上级的连接为#
	$back_url = "#";
else
	$back_url = "?url=$tmp1";									//不是则付值返回上级目录连接
$handle = opendir("$url");
$arr_type = array();											//定义文件类型
$arr_type = array("htm" => "HTML Document","html" => "HTML Document","shtml" => "HTML Document",
	"php" => "PHP 文件","asp" => "ASP 文件","txt" => "文本文件","doc" => "DOC Document","sql" => "SQL Script File"
	,"zip" => "WinRAR 档案文件","rar" => "WinRAR 档案文件","exe" => "可执行文件","js" => "JScript Script File","css" => "CSS 文件"
	,"bmp" => "图片文件","gif" => "图片文件","jpg" => "图片文件","swf" => "Flash 文件");
$img_type = array();											//定义文件标识图片
$img_type = array("htm" => "/Images/html.gif","html" => "/Images/html.gif","shtml" => "/Images/html.gif",
	"php" => "/Images/php.gif","asp" => "/Images/php.gif","txt" => "/Images/txt.gif","doc" => "/Images/txt.gif","sql" => "/Images/txt.gif"
	,"zip" => "/Images/winrar.gif","rar" => "/Images/winrar.gif","exe" => "可执行文件","js" => "/Images/php.gif","css" => "/Images/txt.gif"
	,"bmp" => "/Images/bmp.gif","gif" => "/Images/gif.gif","jpg" => "/Images/gif.gif","swf" => "/Images/flash.gif");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>文件管理</title>
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
          <td height="20">共 <?php echo $i?> 个文件(夹)</td>
        </tr>
        <tr>
          <td height="20">另请参阅：</td>
        </tr>
        <tr>
          <td height="20"><a href="<?php echo $back_url?>">回上级目录</a></td>
        </tr>
        <tr>
          <td height="20"><a href="javascript:window.close()">返回系统界面</a></td>
        </tr>
      </table></td>
    <td width="78%" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="30%" height="25" bgcolor="#666666"><span class="style5">名称</span></td>
        <td width="13%" bgcolor="#666666"><span class="style5">大小</span></td>
        <td width="25%" bgcolor="#666666"><span class="style5">类型</span></td>
        <td width="21%" bgcolor="#666666"><span class="style5">修改时间</span></td>
        <td width="11%" bgcolor="#666666"><span class="style5">操作</span></td>
      </tr>
<?php
while($file = readdir($handle))									//循环显示文件及目录
{
	if($file == "." or $file == ".." or $file == "Thumbs.db")				//判断为真则不显示
		continue;
	if(is_dir("$url$file"))										//判断是否是文件夹
	{
		$type = "文件夹";
		$link_url = "?url=$url$file"."/";							//文件夹连接
		$target = "_self";
		$img = "/Images/file.gif";
	}else{
		$back = array();
		$back = explode(".",$file);
		$_back = strtolower($back[count($back)-1]);
		$type = $arr_type[$_back];
		if(!$type)											//判断是否定义了该文件
			$type = "未知";
		$size = number_format(filesize("$url$file")/1024,2);			//取得文件大小
		$link_url = "$url$file";								//文件连接
		$target = "_blank";
		$img = $img_type[$_back];
		if(!$img)											//判断是否定义了该文件标识图片
			$img = "/Images/none.gir";
	}
	$arr = array();
	$arr = lstat("$url$files");									//提取文件信息
?>
      <tr>
        <td height="20"><img src="<?php echo $img?>"><a href="<?php echo $link_url?>" target="<?php echo $target?>"><?php echo $file?></a></td>
        <td><?php echo $size?>KB</td>
        <td><?php echo $type?></td>
        <td><?php echo date("Y-m-d",$arr[8])?></td>
        <td><a href="Delete.php?url=<?php echo "$url$file"?>" onClick="return confirm('真的要删除<?php echo $file?>吗?')">删除</a></td>
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
