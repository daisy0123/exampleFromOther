<?php require_once('../include/get_request.inc.php'); ?>
<?php require_once('../include/form_func.inc.php'); ?>
<?php require_once("Inc/config.inc.php"); ?>
<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=gb2312">
<style type="text/css">
body {font-size:	9pt}
td {font-size:	9pt}
</style>
</head>
<BODY bgcolor="#FFFFFF" MONOSPACE>
<?php
$perline = 4;

function JoinChar($strUrl){
	if ($strUrl  =  "")
		return "";

	if (strpos($strUrl,"?") + 1 < strlen($strUrl)) { 
		if (strpos($strUrl,"?") > 0) {
			if (strpos($strUrl,"&") + 1 < strlen($strUrl))
				$str  =  $strUrl . "&";
			else
				$str  =  $strUrl;
		}
		else
			$str  =  $strUrl . "?";
	}
	else
		$str  =  $strUrl;
	return $str;
}

$pagesize = 20;
$page = $_REQUEST[page];

if (!$page) $page = 1;
$start = ($page - 1) * $pagesize + 1;
$end = $start + $pagesize - 1;
$UpFileType_pic = "jpg|gif|bmp|png";
$UpFileType_flash = "swf";
$UpFileType_media = "wmv|asf|avi|mpg";
$UpFileType_rm = "ram|rm|ra";

$SavePath = $SaveUpFilesPath;   //����ϴ��ļ���Ŀ¼
$absPath = $abs_upload_path;
if (substr($SavePath,-1) != "/")
	 $SavePath .= "/";			 //��Ŀ¼���(/)
if (substr($absPath,-1) != "/")
	 $absPath .= "/";			 //��Ŀ¼���(/)

$ext_list_name = 'UpFileType_' . $req_DialogType;
$dir = opendir($SaveUpFilesPath);
$file_list = array();
$total = 0;
$total_size = 0;
$total_own_size = 0;
while (false !== ($filename = readdir($dir))){
	if ($filename == "." || $filename == "..")	continue;
	$total++;
	$arr_info = pathinfo($filename);
	$ext_name = $arr_info[extension];
	if (strpos($$ext_list_name,$ext_name) === false)  continue;
	$full_name = $SavePath . $filename;
	$file_info = stat($full_name);
	$size = $file_info[size];
	$total_size += $size;
	if ($total >= $start && $total <= $end){
		$file_list[] = array("name" => $filename,
					"path" => $full_name,
					"abspath" => $absPath . $filename,
					"size" => ceil($size / 1024) . "K",
					"time" => date("Y-m-d H:i:s",$file_info[mtime]));
	}
}
//				"type" => mime_content_type($full_name),
closedir($dir);
$page_count = ceil($total / $pagesize);

$width = ceil(100 / $perline) . "%";
echo "<table width=100% border=0>\n";

foreach($file_list as $key => $file){
	extract($file);
	if ($key % $perline == 0)
		echo "<tr align=center>\n";
	echo "<td width='$width'><table><tr align=center><td><a href='#' onClick=\"javascript:window.opener.document.form1.url.value='$abspath';window.opener.document.form1.UpFileName.value='$abspath';window.close();\"><img src='$path' width='140' height='100' border='0' title='���ͼƬ�����أ���������ļ������鿴ԭʼ�ļ���'></a></td></tr>\n";
	echo "<tr><td>�� �� ����<a href='$path' target='pic_view'>$name</a></td></tr>";
//	echo "<tr><td>�ļ����ͣ�" . $type . "</td></tr>";
	echo "<tr><td>�ļ���С��" . $size . "</td></tr>";
	echo "<tr><td>�޸�ʱ�䣺" . $time . "</td></tr></table></td>\n";
	if ($key % $perline == $perline - 1)
		echo "</tr>\n";
}
for (;$key % $perline < $perline - 1;$key++){
	echo "<td width='$width'>&nbsp;</td>";
}
if ($key % $perline == $perline - 1)
	echo "</tr>";
echo "</table>";
echo "<table width='100%'><tr><td align=center>";
echo "���� <b>$total</b> ���ļ����� <b> <fount color='red'>$page</font> / $page_count </b> ҳ��ռ�� <b>" . ceil($total_size / 1024) . "</b> K <b>$pagesize</b> ���ļ�/ҳ ";
$first = ($page > 2) ? "<a href='?DialogType=$req_DialogType&page=1'>��ҳ</a> " : "��ҳ ";
$prev = ($page > 1) ? "<a href='?DialogType=$req_DialogType&page=" . ($page - 1) . "'>��һҳ</a> " : "��һҳ ";
$next = ($page < $page_count) ? "<a href='?DialogType=$req_DialogType&page=" . ($page + 1) . "'>��һҳ</a> " : "��һҳ ";
$last = ($page_count - $page > 1) ? "<a href='?DialogType=$req_DialogType&page=$page_count'>βҳ</a> " : "βҳ";

echo "&nbsp;$first $prev $next $last &nbsp;ת�� " ;
ud_frm_make_page_menu("page","",$page_count,$page,"javascript:go_page(this.value)");
echo " ҳ</td></tr></table>";
?>
<script language="JavaScript">
<!--
function go_page(ID){
	window.location='?DialogType=<?php echo $req_DialogType ?>&page=' + ID
}
//-->
</script>
</body>
</html>