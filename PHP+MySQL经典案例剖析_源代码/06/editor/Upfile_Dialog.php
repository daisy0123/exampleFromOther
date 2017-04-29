<?php require_once("Inc/config.inc.php"); ?>
<html>
<head>
<title>上传文件</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="editor_dialog.css">
</head>
<body bgColor=menu leftmargin="2" topmargin="5" marginwidth="0" marginheight="0">
<?php
$SavePath = $SaveUpFilesPath;   //存放上传文件的目录
$absPath = $abs_upload_path;
if (substr($SavePath,-1) != "/")
	 $SavePath .= "/";			 //在目录后加(/)
if (substr($absPath,-1) != "/")
	 $absPath .= "/";			 //在目录后加(/)

if (!$EnableUploadFile)
	echo "系统未开放文件上传功能";
else
	upload();		// 上传文件
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
		$msg = "请先选择你要上传的文件！";
		$FoundErr = true;
	}
	if ($size > $MaxFileSize * 1024){
		$msg = "你上传的文件总大小超出了最大限制（" . ($MaxFileSize / 1024) . "M）";
		$FoundErr = true;
	}
	$file_info = pathinfo($name);
	$extname = $file_info[extension];
	if (strpos($$ext_list_name,$extname) === false){
		$msg = "这种文件类型不允许上传！您只能上传下列类型的文件：\\n" . $$ext_list_name;
		$FoundErr = true;
	}
	$ext = "." . $extname;
	$basename = basename($file_info['basename'], $ext);
	$filename = date("YmdHis") . $ext;
	$target = $SavePath . $filename;
	if (!$FundErr){
		if (!move_uploaded_file($tmp_name,$target)){
			echo "文件上传失败";
			$FoundErr = true;
		}
		else
			echo "文件上传成功";
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
