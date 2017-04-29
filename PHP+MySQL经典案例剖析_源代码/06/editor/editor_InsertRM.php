<?php
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");// Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");// always modified
header("Cache-Control: no-store, no-cache, must-revalidate");// HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");// HTTP/1.0
?>
<HTML><HEAD><TITLE>插入RealPlay文件</TITLE>
<link rel="stylesheet" type="text/css" href="editor_dialog.css">
<script language="JavaScript">
function OK(){
  var str1="";
  var strurl=document.form1.url.value;
  if (strurl==""||strurl=="http://")
  {
  	alert("请先输入RealPlay文件地址，或者上传RealPlay文件！");
	document.form1.url.focus();
	return false;
  }
  else
  {
    str1="<object classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width="+document.form1.width.value+" height="+document.form1.height.value+"><param name='CONTROLS' value='ImageWindow'><param name='CONSOLE' value='Clip1'><param name='AUTOSTART' value='-1'><param name=src value="+document.form1.url.value+"></object><br><object classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA'  width="+document.form1.width.value+" height=60><param name='CONTROLS' value='ControlPanel,StatusBar'><param name='CONSOLE' value='Clip1'></object>"
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
<LEGEND align=left>RealPlay文件参数</LEGEND>
<TABLE border="0" cellpadding="0" cellspacing="3">
<TR><TD >地址：<INPUT name="url" id=url  value="http://" size=40>
<?php
if ($_SESSION[admin_media]) {
?>
    <input type="button" name="Submit" value="..." title="从已上传文件中选择" onClick="javascript:window.open('editor_SelectUpFile.php?DialogType=rm', 'selupfile', 'width=800, height=600, toolbar=no, menubar=no, scrollbars=yes, resizable=no, location=no, status=yes');">
<?php
}
?>
	</td></TR>
<TR><TD >宽度：<INPUT name="width" id=width ONKEYPRESS="event.returnValue=IsDigit();" value=500 size=7 maxlength="4" > 
&nbsp;&nbsp;高度：<INPUT name="height" id=height ONKEYPRESS="event.returnValue=IsDigit();" value=300 size=7 maxlength="4"></TD></TR>
<TR><TD align=center>支持格式为：rm、ra、ram</TD></TR>
</TABLE></fieldset></td><td width=80 align="center"><input name="cmdOK" type="button" id="cmdOK" value="  确定  " onClick="OK();">
  <br>
  <br>  <input name="cmdCancel" type=button id="cmdCancel" onclick="window.close();" value='  取消  '></td></tr>
  <tr>
    <td>
<FIELDSET align=left>
<LEGEND align=left>上传本地RealPlay文件</LEGEND>
<iframe class="TBGen" style="top:2px" ID="UploadFiles" src="upload_dialog.php?DialogType=rm" frameborder=0 scrolling=no width="350" height="25"></iframe>
</fieldset>
	</td>
    <td width=80 align="center" valign="top"><input name="UpFileName" type="hidden" id="UpFileName" value="None"></td>
  </tr>
</table>
</form>
</body>
</html>