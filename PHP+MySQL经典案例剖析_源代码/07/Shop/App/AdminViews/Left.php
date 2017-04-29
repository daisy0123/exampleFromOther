<html>
<head>
<title>后台管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<style type="text/css">
table { BORDER-TOP: 0px; BORDER-LEFT: 0px; BORDER-BOTTOM: 2px}
select {
	FONT-SIZE: 12px;
	COLOR: #000000; background-color: #E0E2F1;
}
a { TEXT-DECORATION: none; color:#000000}
a:hover{ text-decoration: underline;}
body {font-family:Verdana;FONT-SIZE: 12px;MARGIN: 0;color: #000000;background: #F7F7F7;}
textarea,input,object{font-size: 12px;}
td { BORDER-RIGHT: 1px; BORDER-TOP: 0px; FONT-SIZE: 12px; COLOR: #000000;}
.b{background:#F7F7F7;}

.head { color: #ffffff;background: #739ACE;}
.head td{color: #ffffff;}
.head a{color: #ffffff;}
.head_2 {background: #CED4E8;}
.head_2 td{color: #000000;}
.left_padding{background:#F7F7F7;}
.hr  {border-top: 1px solid #6365CE; border-bottom: 0; border-left: 0; border-right: 0; }
.bold {font-weight:bold;}
.smalltxt {font-family: Tahoma, Verdana; font-size: 12px;color: #000000;}
.i_table{border: 1px solid #6365CE;background:#DEE3EF;}
</style>

<!---->
</head>
<body topmargin=5 leftmargin=5>
<script language="JavaScript" src="/Js/Menu.js"></script>
<table width=100% align="center" cellpadding=3 cellspacing=0>
<tr><td class=head height=23 align=center>
<a target="right" href="/Index/Right"><b>管理区首页</b></a> | <a target="_top" href="/Index/LoginOut"><b>退出</b></a>
</td></tr>
<tr>
<td class=b align=center>
<a href="#" onclick="return Clear();">+ 全部展开</a> <a href="#" onclick="return Set();">- 全部收缩</a>
</td></tr>

<!---->
<tr>
<td>
<table width=98% align=center cellspacing=1 cellpadding=4 class=i_table><tr>
  <td class=head>
<a style="float:right" href="#" onclick="return Tree('a0',1);"><img src="/Images/cate_fold.gif" width="14" height="14" border=0 id="img_a0"></a>
<b>产品管理</b></td>
</tr>
<tbody id="cate_a0" style="">
<tr><td class=left_padding>
<a target=right href="/Class/Index/Type/1">类别管理</a><br>
<a target=right href="/Class/Index/Type/2">产品管理</a><br>
<a target=right href="/Product/NewList">产品新标识管理</a><br>
<a target=right href="/Product/RecommendList">推荐产品管理</a><br>
<a target=right href="/Config">配置管理</a><br>
<a target=right href="/Class/Property">默认产品属性管理</a><br>
</td></tr>
</tbody></table></td></tr>
<tr>
<td>
<table width=98% align=center cellspacing=1 cellpadding=4 class=i_table><tr><td class=head>
<a style="float:right" href="#" onclick="return IndexDeploy('a1',1)"><img id="img_a1" src="/Images/cate_fold.gif" border=0></a>
<b>用户管理</b></td></tr>
<tbody id="cate_a1" style="">
<tr><td class=left_padding>
<a target=right href="/User">用户管理</a><br>
</td></tr>
</tbody></table></td></tr>
<tr>
<td>
<table width=98% align=center cellspacing=1 cellpadding=4 class=i_table><tr>
  <td class=head>
<a style="float:right" href="#" onclick="return IndexDeploy('a2',1)"><img id="img_a2" src="/Images/cate_fold.gif" border=0></a>
<b>订单管理</b></td>
</tr>
<tbody id="cate_a2" style="">
<tr><td class=left_padding>
<a target=right href="/Order">订单管理</a><br>
</td></tr>
</tbody></table></td></tr>
<tr>
<td>
<table width=98% align=center cellspacing=1 cellpadding=4 class=i_table><tr>
  <td class=head>
<a style="float:right" href="#" onclick="return IndexDeploy('a3',1)"><img id="img_a3" src="/Images/cate_fold.gif" border=0></a>
<b>反馈信息管理</b></td>
</tr>
<tbody id="cate_a3" style="">
<tr><td class=left_padding>
<a target=right href="/Message">反馈信息管理</a><br>
</td></tr>
</tbody></table></td></tr>
<tr><td class=head_2 align=center>&nbsp;
</td></tr></table>
</td>
</body></html>
