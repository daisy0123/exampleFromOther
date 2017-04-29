<?php require_once("Inc/config.inc.php"); ?>
<?php
$ALLOW_FILE_FORMAT = "jpg|gif|png|bmp|swf|xls|doc|txt|ppt";
if ($_SESSION[admin_media])
	$ALLOW_FILE_FORMAT .= "|wmv|asf|avi|mpg|ram|rm|ra";

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
<?php

function upload(){
	global $SavePath,$absPath,$MaxFileSize,$ALLOW_FILE_FORMAT;
	extract($_FILES[FileName]);
	if ($size == 0){
		$msg = "����ѡ����Ҫ�ϴ����ļ���";
		$err = true;
	}
/*	if (substr($type,0,5) != "image"){
		$msg = "���ϴ����ļ����ʹ�����ֻ���ϴ�ͼƬ�ļ�";
		$err = true;
	}*/
	if ($size > $MaxFileSize * 1024){
		$msg = "���ϴ����ļ��ܴ�С������������ƣ�" . ($MaxFileSize / 1024) . "M��";
		$err = true;
	}
	if (!$err){
		$file_info = pathinfo($name);
		$extname = $file_info[extension];
		if (strpos($ALLOW_FILE_FORMAT,$extname) === false){
			$msg = "���ϴ����ļ����ʹ�����ֻ���ϴ��������͵��ļ���\\n$ALLOW_FILE_FORMAT";
			$err = true;
		}
	}
	if (!$err){
		$ext = "." . $extname;
		$basename = basename($file_info['basename'], $ext);
		$filename = date("YmdHis") . $ext;
		$target = $SavePath . $filename;
		if (!move_uploaded_file($tmp_name,$target)){
			$msg = "�ļ��ϴ�ʧ��";
			$err = true;
		}
	}
	if (!$err){
		$req_ImgWidth = (int)($_POST[ImgWidth]);
		$req_ImgHeight = (int)($_POST[ImgHeight]);
		$req_AlignType = (int)($_POST[AlignType]);
		
		$target = $absPath . $filename;
		$strJS = "<SCRIPT language=javascript>\n";
		$msg = "�ϴ��ļ��ɹ���";
		
		$strJS .=  "parent.HtmlEdit.focus();\n";
		$strJS .=  "var range = parent.HtmlEdit.document.selection.createRange();\n";
		switch($extname){
			case "jpg":
			case "gif":
			case "png":
			case "bmp":
				$strJS .=  "range.pasteHTML('<img src=$target";
				if ($req_ImgWidth)
					$strJS .=  " width=$req_ImgWidth";
				if ($req_ImgHeight)
					$strJS .=  " height=$req_ImgHeight";
				switch($req_AlignType){
					case 0:
					case 1:
						$strJS .= " align=left";
						break;
					case 2:
						$strJS .= " align=center";
						break;
					case 3:
						$strJS .= " align=right";
				}
				$strJS .= " border=0>');\n";
				break;
			case "swf":
				$strJS .= "range.pasteHTML('<object classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000 codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0";
				if ($req_ImgWidth)
					$strJS .=  " width=$req_ImgWidth";
				if ($req_ImgHeight)
					$strJS .=  " height=$req_ImgHeight";
				$strJS .= "><param name=movie value=$target>";
				$strJS .= "<param name=quality value=high>";
				$strJS .= "<embed src=$target quality=high pluginspage=http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash type=application/x-shockwave-flash";
				if ($req_ImgWidth)
					$strJS .=  " width=$req_ImgWidth";
				if ($req_ImgHeight)
					$strJS .=  " height=$req_ImgHeight";
				$strJS .= "></embed></object>');\n";
				break;
			default:
	$strJS .= "range.text='[upload=$extname]$target". "[/upload]';\n";
		}
		$strJS .=  "parent.parent.AddItem('$target')\n";
		$strJS .=  "alert('$msg');\n";
		//$strJS .=  "history.go(-1);\n";
		$strJS .=  "parent.HtmlEdit.focus();\n";
		$strJS .=  "</script>";
	}
	else{
		$strJS = "<SCRIPT language=javascript>\n";
		$strJS .=  "alert('$msg');\n";
		//$strJS .=  "history.go(-1);\n";
		$strJS .=  "parent.HtmlEdit.focus();\n";
		$strJS .=  "</script>";
	}
	echo $strJS;
	echo "<script>window.history.back()</script>";
}

?>
