var _Iframe = false;
var _CountPage = 'count.php';									//count.php�ļ�·��
if( _Iframe == false )											//�Ƿ������iframe����
{
	var _Pageurl = escape(location.href);						//ȡ�õ�ǰҳ���ַ
	var _Referer = escape(document.referrer);					//ȡ����·��ҳ��ַ
}
else
{
	var _Pageurl = escape(top.location.href);						//ȡ�õ�ǰҳ���ַ
	var _Referer = escape(top.document.referrer);					//ȡ����·��ҳ��ַ
}
var _Language = (navigator.systemLanguage?navigator.systemLanguage:navigator.language);//ȡ�ÿͻ�������
var _ScreenSize = screen.width + '*' + screen.height;				//ȡ�ÿͻ��˷ֱ���
var _Charset = document.charset	;							//��ҳ�ַ���
var _CountUrl = _CountPage + '?'
+ 'pageurl=' + _Pageurl
+ '&referer=' + _Referer
+ '&language=' + _Language
+ '&screensize=' + _ScreenSize
+ '&charset=' + _Charset;
document.write("<script src='" + _CountUrl + "'></script>");