<html>
<head>
<title>后台管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<base target="right">
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
<table width="100%" border="0" align="center">
  <tr> 
    <td height="120" valign="top"> 
{*foreach item=uu from=$list*}	
{*$uu[prev]*}
{*if $uu[sub_num] > 0*}	
<img src="/images/plus.gif" />
{*else*}
<img src="/images/nofollow.gif" />
{*/if*}
<a href="{*$url*}{*$uu[id]*}" target='main'>{*$uu[class_name]*}</a> <br />
{*/foreach*}
    </td>
  </tr>
{*if $type == 1*}
  <tr>
    <td align="center" valign="top"> <input name="cmdAdd" type="submit" id="cmdAdd" value="新建顶层栏目" onClick="javascript:parent.frames('main').location='/Class/Add/ParentId/0'"> 
    </td>
  </tr>
  <tr>
    <td align="center" valign="top"><input type="button" name="Submit2" value="设置排列顺序" onClick="javascript:parent.frames('main').location='/Class/Order/Id/0'"></td>
  </tr>
{*/if*}
</table>
</body>
</html>