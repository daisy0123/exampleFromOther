<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>无标题文档</title>
</head>

<body>
选择语言：<select name="language" onchange="javascript:location.href='LangSet.php?Lang='+this.options[selectedIndex].value+'&ReturnUrl='+ encodeURIComponent(location.pathname)">
{*foreach value=uu from=$lan*}
<option value="{*$uu[F_CODE]*}">{*$uu[F_NAME]*}</option>
{*/foreach*}
</select>
{*foreach value=uu from=$item*}
 <p>原始数据：{*$uu[F_CODE]*} 翻译：{*t*}{*$uu[F_CODE]*}{*/t*}</p>
{*foreachelse*}
<p>无数据</p>
{*/foreach*}
</body>
</html>
