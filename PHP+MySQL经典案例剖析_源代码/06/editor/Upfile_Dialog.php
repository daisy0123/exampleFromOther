<?php require_once("Inc/config.inc.php"); ?>
<html>
<head>
<title>�ϴ��ļ�</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="editor_dialog.css">
</head>
<body bgColor=menu leftmargin="2" topmargin="5" marginwidth="0" marginheight="0">
<?php
$SavePath = $SaveUpFilesPath;   //����ϴ��ļ���Ŀ¼
$absPath = $abs_upload_path;
if (substr($SavePath,-1) != "/")
	 $SavePath .= "/";			 //��Ŀ¼���(/)
if (substr($absPath,-1) != "/")
	 $absPath .= "/";			 //��Ŀ¼���(/)

if (!$EnableUploadFile)
	echo "ϵͳδ�����ļ��ϴ�����";
else
	upload();		// �ϴ��ļ�
?>
</body>
</html>
<?php

function upload(){
	global $SavePath,$absPath;

	$UpFileType_pic = "jpg|gif|bmp|png";
	$UpFileType_flash = "swf";
	$UpFileType_media = "wmv|asf|avi|mpg";
	$UpFileType_rm = "ram|rm|ra";
	$DialogType = $_REQUEST['DialogType'];
	$ext_list_name = 'UpFileType_' . $DialogType;
	extract($_FILES[FileName]);
	if ($size = 0){
		$msg = "����ѡ����Ҫ�ϴ����ļ���";
		$FoundErr = true;
	}
	if ($size > $MaxFileSize * 1024){
		$msg = "���ϴ����ļ��ܴ�С������������ƣ�" . ($MaxFileSize / 1024) . "M��";
		$FoundErr = true;
	}
	$file_info = pathinfo($name);
	$extname = $file_info[extension];
	if (strpos($$ext_list_name,$extname) === false){
		$msg = "�����ļ����Ͳ������ϴ�����ֻ���ϴ��������͵��ļ���\\n" . $$ext_list_name;
		$FoundErr = true;
	}
	$ext = "." . $extname;
	$basename = basename($file_info['basename'], $ext);
	$filename = date("YmdHis") . $ext;
	$target = $SavePath . $filename;
	if (!$FundErr){
		if (!move_uploaded_file($tmp_name,$target)){
			echo "�ļ��ϴ�ʧ��";
			$FoundErr = true;
		}
		else
			echo "�ļ��ϴ��ɹ�";
	}

	$target = $absPath . $filename;
	$strJS = "<SCRIPT language=javascript>\n";
	if (!$FoundErr){
		$strJS .= "parent.document.form1.url.value='$target';\n";
		$strJS .= "parent.document.form1.UpFileName.value='$target';\n";
//		$strJS .= "window.location='Upload_Dialog.php?DialogType=$DialogType';\n";
	}
	else{
		$strJS .= "alert('$msg');\n";
		$strJS .= "window.location='Upload_Dialog.php?DialogType=$DialogType';\n";
	}
	$strJS .= "</script>\n";
	echo $strJS;
}

?>
