<?php
$url = $_GET['url'];
if(!$url)
{
	$url = "../../templates/";
	$prev = "";
}
else
{
	$tmp = substr($url,0,-1);
	$tmp = substr($tmp,0,strrpos($tmp,"/"));
	$tmp = $tmp . "/";
	$prev = "<a href='select.php?url='>&lt;&lt;�����ϲ�Ŀ¼</a>";
}
$handle = opendir("$url");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��̨����</title>
<link href="/Style/admin.css" rel="stylesheet" type="text/css">
</head>
<base target="_self">
<body>
<table width="500" border="0" align="center" cellspacing="0">
	<tr> 
	  <td class="stress">��ǰ·����<?php echo $url ?></td>
	  <td align="right"><?php echo $prev?></td>
  </tr>
	<tr> 
	  <td colspan="2"> <table width="100%" border="0">
          <tr> 
            <th width="175">�ļ���Ŀ¼����</th>
            <th width="213">�ļ�����޸�ʱ��</th>
            <th width="96">����</th>
          </tr>
          <?php
$i = 0;
while($files = readdir($handle))
{
	if($files == "." or $files == "..")
		continue;
	$arr = array();
	$bgstr = "bgcolor=" . ($key % 2 ? "#eeeeee" : "#ffffff");
	$file_url = str_replace("../../","/",$url);
	$file_url .= "$files";
	if(is_dir("$url$files"))
	{
		$back_url = "$url$files" . "/";
		$admin = "<a href='select.php?url=$back_url'>�鿴Ŀ¼</a>";
	}
	else
	{
		$arr = lstat("$url$files");
		$admin = "<input type='button' name='Submit' value='��' onclick='javascript:check(\"$file_url\")' style='BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; BORDER-BOTTOM-WIDTH: 1px; BORDER-RIGHT-WIDTH: 1px'>";
		$admin .= "&nbsp;<input type='button' name='Submit' value='Ԥ��' style='BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; BORDER-BOTTOM-WIDTH: 1px; BORDER-RIGHT-WIDTH: 1px' onclick='javascript:window.open(\"$file_url\");'>";
	}
?>
          <tr <?php echo $bgstr ?>> 
            <td> <?php echo $files ?> </td>
            <td align="center"> <?php echo ($arr[8]) ? date("Y-m-d",$arr[8]) : " " ?> </td>
            <td align="center"> <?php echo $admin?></td>
          </tr>
          <?php
	$i++;
}
closedir($handle);
?>
        </table></td>
	</tr>
	<tr> 
	  <th colspan="2">&nbsp; </th>
	</tr>
</table>
<script language="JavaScript" type="text/JavaScript">
function check(url){
	window.returnValue = url
	window.close()
}
</script>
</body>
</html>