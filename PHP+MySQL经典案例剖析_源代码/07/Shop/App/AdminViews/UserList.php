<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language='javascript' src='/Js/Base.js'></script>
<form name=form1 action="" method=post>
<table cellSpacing=0 width="95%" align=center border=0>
  <tr>
    <td class=caption colSpan=2>用 户 管 理</td>
  </tr>
  <tr>
    <td colSpan=2>用户搜索：
      <input name="keyword" type="text" id="keyword">
      <select name="type" id="type">
        <option value="1" selected>用户名</option>
        <option value="2">EMAIL</option>
        <option value="3">真实姓名</option>
      </select>
      <input type="button" name="Submit" value="提交" onClick="javascript:searchuser();"></td>
  </tr>
  <tr>
    <td colSpan=2>
      <table width="100%" border=0>
        <tr>
          <th width=25><input id=allbox onclick=CA(); type=checkbox value=1 
            name=allbox></th>
          <th width=61>用户名</th>
          <th width=171>EMAIL</th>
          <th width=86>是否接收邮件</th>
          <th width=52>性别</th>
          <th width=83>真实姓名</th>
          <th width=118>注册时间</th>
          <th width=61>是否激活</th>
          <th width=112>管理</th>
		</tr>
		{*foreach item=uu from=$list[data]*}
        <tr bgColor=#ffffff>
          <td align=middle><input type=checkbox value='{*$uu[F_ID]*}' name=SelId[]> </td>
          <td>{*$uu[F_LOGIN_NAME]*}</td>
          <td align=middle>{*$uu[F_LOGIN_EMAIL]*}</td>
          <td align=middle>
		 {*if $uu[F_LOGIN_ACCEPT_EMAIL] == 1*}
		 是
		 {*else*}
		 否
		 {*/if*}
		 </td>
          <td align=middle>
		  {*if $uu[F_USER_GENDER] == 1*}
		  男
		  {*/if*}
		  {*if $uu[F_USER_GENDER] == 2*}
		  女
		  {*/if*}
		  </td>
          <td align=middle>{*$uu[F_USER_TRUENAME]*}</td>
          <td align=middle>{*$uu[F_LOGIN_TIME]|date:'m-d H:i'*}</td>
		  <td align=middle>{*if $uu[F_LOGIN_IS_ACTIVE] == 1*}
		  是
		  {*else*}
		  否
		  {*/if*}</td>
          <td align=middle><a href="/User/Info/Id/{*$uu[F_ID]*}">查看详情</a> 
		  <a href="/Order/Index/UserId/{*$uu[F_ID]*}">查看订单</a> </td>
        </tr>
		{*/foreach*}
		</table>
	</td>
  </tr>
  <tr>
    <th colSpan=2>&nbsp; <input id=cmdAdd onclick=javascript:deluser(); type=button value="删 除 用 户" name=cmdDel><input type="button" name="Submit2" value="群发邮件" onClick="javascript:window.location='/User/SendEmail'"></th>
  </tr></table>
<table width="95%" border="0" align="center">
  <tr>
    <td>{*$list[JumpBar]*}</td>
  </tr>
</table>
</form>
<script language=JavaScript type=text/JavaScript>
/**
 * 实现全选功能
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;
	}
}
/**
 * 实现搜索转向
 */
function searchuser()
{
	if($(‘keyword’).value.trim() == “”)
	{
		alert(‘请填写关键字’);
		$(‘keyword’).focus();
	}else{
		document.form1.action='/User/Redirect';
		document.form1.submit();
	}
}
/**
 * 实现删除确认
 */
function deluser()
{
	if(confirm("真的要删除吗?"))
	{
		document.form1.submit();
	}
}
</script>
