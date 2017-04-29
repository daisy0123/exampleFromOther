<?php
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'chat.inc.php');
$chat = new Chat();
$page = $_GET['page'];								//获取当前页码
if(!$page)											//如果无当前页码默认为1
	$page = 1;
$list = $chat->GetMsgList();
$count = $chat->GetMsgCount();
$pagecount = ceil($count/30);							//计算页数
if(!$pagecount)										//如果无页数则默认为1
	$pagecount = 1;
$url = "?page=";									//定义翻页跳转URL
/**
 * 功能：该函数用于解析ubb2的代码
*/
function ubb2html($content){
	$content = str_replace("\n","<br>",$content);							//先将\n替换成<br>
	$arr_conv = array(												//定义解析的正则表达式
		array("!\[sup\](.*)\[/sup\]!Ui",'<sup>$VALUE</sup>'),
		array("!\[sub\](.*)\[/sub\]!Ui",'<sub>$VALUE</sub>'),
		array("!\[u\](.*)\[/u\]!Ui",'<u>$VALUE</u>'),
		array("!\[b\](.*)\[/b\]!Ui",'<b>$VALUE</b>'),
		array("!\[i\](.*)\[/i\]!Ui",'<i>$VALUE</i>'),
		array("!\[face=(.+)\](.*)\[/face\]!Ui",'<font face=$VALUE>$TEXT</font>'),
		array("!\[size=(.+)\](.*)\[/size\]!Ui",'<font size=$VALUE>$TEXT</font>'),
		array("!\[color=(.+)\](.*)\[/color\]!Ui",'<font color=$VALUE>$TEXT</font>'),
		array("!\[(left)\](.*)\[/left\]!Ui",'<div align=$VALUE>$TEXT</div>'),
		array("!\[(right)\](.*)\[/right\]!Ui",'<div align=$VALUE>$TEXT</div>'),
		array("!\[(center)\](.*)\[/center\]!Ui",'<div align=$VALUE>$TEXT</div>'),
		array("!\[align=(.*)\](.*)\[/right\]!Ui",'<div align=$VALUE>$TEXT</div>'),
		array("!\[(email)](.*)\[/email\]!Ui",'<a href=\'mailto:$TEXT\'>$TEXT</a>'),
		array("!\[email=mailto:(.*)\](.+)\[/email\]!Ui",'<a href=\'mailto:$VALUE\'>$TEXT</a>'),
		array("!\[url=(.+)\](.+)\[/url\]!Ui",'<a href=\'$VALUE\' target=\'_blank\'>$TEXT</a>'),
		array("!\[(url)\](.*)\[/url\]!Ui",'<a href=\'$TEXT\' target=\'_blank\'>$TEXT</a>'),
		array("!\[(img)\](.*)\[/img\]!Ui",'<img src=\'$TEXT\'></img>'),
		array("!\[(em)([0-9]{1,2})\]!Ui",'<img src=\'/images/em/em$TEXT.gif\'>'),
		array("!\[(quote)\](.*)\[/quote\]!Ui",'<br><blockquote><hr>$TEXT<hr></blockquote>'),
		array("!\[(sound)\](.*)\[/sound\]!Ui",'<a href="$TEXT" target=_blank><IMG SRC="images/mid.gif" border=0 alt="背景音乐"></a><bgsound src="$TEXT" loop="-1">'));
	$arr_media = array(												//定义解析煤体标签的正则式
		array("!\[flash=([0-9]+),([0-9]+)\](.*)\[/flash\]!Ui",'<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="$WIDTH" height="$HEIGHT">
  <param name="movie" value="$URL">
  <param name="quality" value="high">
  <embed src="$URL" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="$WIDTH" height="$HEIGHT"></embed></object>'),
	array("!\[dir=([0-9]+),([0-9]+)\](.*)\[/dir\]!Ui",'<object classid="clsid:166B1BCA-3F9C-11CF-8075-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=8,5,0,0" width="$WIDTH" height="$HEIGHT">
  <param name="src" value="$URL">
  <embed src="$URL" pluginspage="http://www.macromedia.com/shockwave/download/" width="$WIDTH" height="$HEIGHT"></embed></object>'),
	array("!\[rm=([0-9]+),([0-9]+)\](.*)\[/rm\]!Ui",'<OBJECT classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA class=OBJECT id=RAOCX width="$WIDTH" height="$HEIGHT"><PARAM NAME=SRC VALUE="$URL"><PARAM NAME=CONSOLE VALUE=Clip1><PARAM NAME=CONTROLS VALUE=imagewindow><PARAM NAME=AUTOSTART VALUE=true></OBJECT><br><OBJECT classid=CLSID:CFCDAA03-8BE4-11CF-B84B-0020AFBBCCFA height=32 id=video2 width="$WIDTH"><PARAM NAME=SRC VALUE="$URL"><PARAM NAME=AUTOSTART VALUE=-1><PARAM NAME=CONTROLS VALUE=controlpanel><PARAM NAME=CONSOLE VALUE=Clip1></OBJECT>'),
	array("!\[mp=([0-9]+),([0-9]+)\](.*)\[/mp\]!Ui",'<object align=middle classid=CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95 class=OBJECT id=MediaPlayer width="$WIDTH" height="$HEIGHT"><param name=ShowStatusBar value=-1><param name=Filename value="$URL"><embed type=application/x-oleobject codebase=http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701 flename=mp src="$URL" width="$WIDTH" height="$HEIGHT"></embed></object>'),
	array("!\[qt=([0-9]+),([0-9]+)\](.*)\[/qt\]!Ui",'<embed src="$URL" width="$WIDTH" height="$HEIGHT" autoplay=true loop=false controller=true playeveryframe=false cache=false scale=TOFIT bgcolor=#000000 kioskmode=false targetcache=false pluginspage=http://www.apple.com/quicktime/>'),
	array("!\[img=([0-9]+),([0-9]+)\](.*)\[/img\]!Ui",'<img width="$WIDTH" height="$HEIGHT" src="$URL"></img>')
		);

	for ($i = 0;$i < count($arr_conv);$i++){							//循环匹配并解析
		$pattern = $arr_conv[$i][0];
		$rep = $arr_conv[$i][1];
		while ($col_num = preg_match_all($pattern,$content,$m)){
			$p = array();
			$arr_rep = array();
			for ($j = 0;$j < $col_num;$j++){
				$pt = $m[0][$j];
				$value = $m[1][$j];
				$text = $m[2][$j];
				$tmp_p = str_replace('$VALUE',$value,$rep);
				$p[] = $pt;
				$arr_rep[] = str_replace('$TEXT',$text,$tmp_p);
			}
			$content = str_replace($p,$arr_rep,$content);				//替换成html格式
		}
	}
	for ($i = 0;$i < count($arr_media);$i++){							//循环匹配并解析
		$pattern = $arr_media[$i][0];
		$rep = $arr_media[$i][1];
		while ($col_num = preg_match_all($pattern,$content,$m)){
			$p = array();
			$arr_rep = array();
			for ($j = 0;$j < $col_num;$j++){
				$pt = $m[0][$j];
				$width = $m[1][$j];
				$height = $m[2][$j];
				$url = $m[3][$j];
				$tmp_p = str_replace('$WIDTH',$width,$rep);
				$tmp_p = str_replace('$HEIGHT',$height,$tmp_p);
				$p[] = $pt;
				$arr_rep[] = str_replace('$URL',$url,$tmp_p);
			}
			$content = str_replace($p,$arr_rep,$content);				//替换成html格式
		}
	}
	return str_replace("\n","<br>",$content);
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>查看聊天记录</title>
<style type="text/css">
body
{
font-size:12px;
text-align:center;
}
</style>
</head>

<body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0" bgcolor="#ECFDFF">
<div style="word-break:break-all;width:890px; text-align:left;">
<?php
if($list)
{
	foreach($list as $value)
	{
?>
<p>
<font color="#0000FF"><?php echo $value['F_USER_NICKNAME']?></font>
<font color="#282828">说：</font>
<font color="#FDA700"><?php echo ubb2html($value['F_MESS_INFO'])?></font>
<?php
	}
}
?>
</div>
<table width='890' align='center' border='0' cellspacing='0'>
  <tr>
	<td align="left"> 共有 <b><?php echo $count?></b> 信息 共 <font color='#FF0000'><b><?php echo $page?></b></font> / <b><?php echo $pagecount?></b>页 每页<strong>30</strong></td>
	<td width="30">转到</td>
	<td width="50"><select name="page" style="width:50px" onChange="javascript:location.href=document.getElementById('url')+this.options[selectedIndex].value">
	<?php
	for($i=1;$i<=$pagecount;$i++)
	{
		echo "<option value='$i'";
		if($i == $page)
			echo " selected='selected'";
		echo ">$i</option>";
	}
	?>
			  </select>
		<input type="hidden" name="url" value="<?php echo $url?>" /></td>
	<td width="15">页 </td>
  </tr>
</table>
</body>
</html>
