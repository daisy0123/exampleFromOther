<?php
session_start();
if($_SESSION['F_ID'] > 1)											//�ж��Ƿ���Ĭ��ϵͳ����Ա
{
	echo "��û��Ȩ�޲鿴Ŀ¼";
	exit();
}
$handle = opendir("../../");											//�򿪸�Ŀ¼
?>
<html>
<head>
<META content="text/html; charset=gb2312" http-equiv=Content-Type>
<title>��̨����</title>
<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<base target="main">
</head>
<BODY>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="25" align="center" bgcolor="#666666"><span class="style1">Ŀ¼����</span></td>
  </tr>
</table>
<table width="140" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> <table width="100%" border="0">
<?php
while($file = readdir($handle))										//ѭ������Ŀ¼
{
	if($file == "." or $file == "..")									//�ж��Ƿ���ڡ�.����..��������ʾ
		continue;
	if(!is_dir("../../$file"))											//�ж��Ƿ���Ŀ¼��������ʾ
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
