<?php
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");// Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");// always modified
header("Cache-Control: no-store, no-cache, must-revalidate");// HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");// HTTP/1.0
?>
<HTML><HEAD><TITLE>插入视频文件</TITLE>
<link rel="stylesheet" type="text/css" href="editor_dialog.css">
<script language="JavaScript">
function OK(){
  var str1="";
  var strurl=document.form1.url.value;
  if (strurl==""||strurl=="http://")
  {
  	alert("请先输入视频文件地址，或者上传视频文件！");
	document.form1.url.focus();
	return false;
  }
  else
  {
    str1="<embed src="+document.form1.url.value+" width="+document.form1.width.value+" height="+document.form1.height.value+"></embed>"
    window.returnValue = str1+"$$$"+document.form1.UpFileName.value;
    window.close();
  }
}
function IsDigit()
{
  return ((event.keyCode >= 48) && (event.keyCode <= 57));
}
</script>
</head>
<BODY bgColor=menu topmargin=15 leftmargin=15 >
<form name="form1" method="post" action="">
<table width=100% border="0" cellpadding="0" cellspacing="2">
  <tr><td>
<FIELDSET align=left>
<LEGEND align=left>视频文件参数</LEGEND>
<TABLE border="0" cellpadding="0" cellspacing="3">
<TR><TD >地址：<INPUT name="url" id=url  value="http://" size=40>
<?php
if ($_SESSION[admin_media]) {
?>
    <input type="button" name="Submit" value="..." title="从已上传文件中选择" onClick="javascript:window.open('editor_SelectUpFile.php?DialogType=media', 'selupfile', 'width=800, height=600, toolbar=no, menubar=no, scrollbars=yes, resizable=no, location=no, status=yes');">
<?php
}
?>
	</td></TR>
<TR><TD >宽度：<INPUT name="width" id=width  ONKEYPRESS="event.returnValue=IsDigit();" value=352 size=7 maxlength="4"> 
&nbsp;&nbsp;高度：<INPUT id=height ONKEYPRESS="event.returnValue=IsDigit();" value=288 size=7 maxlength="4"></TD></TR>
<TR><TD align=center>支持格式为：avi、wmv、mpg、asf</TD></TR>
 </TABLE></fieldset></td><td width=80 align="center"><input name="cmdOK" type="button" id="cmdOK" value="  确定  " onClick="OK();">
   <br>
   <br>   <input name="cmdCancel" type=button id="cmdCancel" onclick="window.close();" value='  取消  '></td></tr>
   <tr>
    <td>
<FIELDSET align=left>
<LEGEND align=left>上传本地视频文件</LEGEND>
<iframe class="TBGen" style="top:2px" ID="UploadFiles" src="upload_dialog.php?DialogType=media" frameborder=0 scrolling=no width="350" height="25"></iframe>
</fieldset>
	</td>
    <td width=80 align="center"><input name="UpFileName" type="hidden" id="UpFileName" value="None"></td>
   </tr>
</table>
</form>
</body>
</html>
