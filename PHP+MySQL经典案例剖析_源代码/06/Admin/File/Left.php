<?php
session_start();
if($_SESSION['F_ID'] > 1)											//判断是否是默认系统管理员
{
	echo "你没有权限查看目录";
	exit();
}
$handle = opendir("../../");											//打开根目录
?>
<html>
<head>
<META content="text/html; charset=gb2312" http-equiv=Content-Type>
<title>后台管理</title>
<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<base target="main">
</head>
<BODY>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="25" align="center" bgcolor="#666666"><span class="style1">目录管理</span></td>
  </tr>
</table>
<table width="140" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> <table width="100%" border="0">
<?php
while($file = readdir($handle))										//循环查找目录
{
	if($file == "." or $file == "..")									//判断是否等于’.’或’..’是则不显示
		continue;
	if(!is_dir("../../$file"))											//判断是否是目录不是则不显示
		continue;
	$url = "../../$file/";
?>
        <tr> 
          <td>
             <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="15%"><a href="List.php?url=<?php echo $url?>" target='mainFrame'><img src="/Images/file.gif" border="0"></a></td>
                    <td width="85%" height="20"><a href="List.php?url=<?php echo $url?>" target='mainFrame'><?php echo $file?></a></td>
                  </tr>
            </table>
          </td>
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
