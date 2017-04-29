var _Iframe = false;
var _CountPage = 'count.php';									//count.php文件路径
if( _Iframe == false )											//是否包含在iframe里面
{
	var _Pageurl = escape(location.href);						//取得当前页面地址
	var _Referer = escape(document.referrer);					//取得来路网页地址
}
else
{
	var _Pageurl = escape(top.location.href);						//取得当前页面地址
	var _Referer = escape(top.document.referrer);					//取得来路网页地址
}
var _Language = (navigator.systemLanguage?navigator.systemLanguage:navigator.language);//取得客户端语言
var _ScreenSize = screen.width + '*' + screen.height;				//取得客户端分辨率
var _Charset = document.charset	;							//网页字符集
var _CountUrl = _CountPage + '?'
+ 'pageurl=' + _Pageurl
+ '&referer=' + _Referer
+ '&language=' + _Language
+ '&screensize=' + _ScreenSize
+ '&charset=' + _Charset;
document.write("<script src='" + _CountUrl + "'></script>");