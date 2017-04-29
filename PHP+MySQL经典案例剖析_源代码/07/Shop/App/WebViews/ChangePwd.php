<div id="SearchContent" style="width:98%; ">
<div id="top_left">
<h2 class="hot">修改密码</h2>
</div>
</div>
<div id="contt">
<form id="form1" name="form1" method="post" action="">
<div align="left">
<h2><img src="/images/jiantou_1.gif" alt="1" width="9" height="13" />请输入您的新密码</a> </h2>
</div>
<p>新 密 码：
<input name="pwd" type="password" id="pwd" />
<br />
重复密码：
<input name="confirm_pwd" type="password" id="confirm_pwd" />
<br />
<input type="button" name="Submit" value="提交" onclick="javascript:check();" />
</form>
</div>
<script language="javascript">
function check()
{
	if ($(‘pwd’).value || $(‘confirm_pwd’).value) {					//判断密码是否为空
		alert('必填项目不能为空');
		return false;
	}
	if($(‘pwd’).value != $(‘confirm_pwd’).value)					//判断密码前后输入是否一致
	{
		alert("密码前后不一致")
		$(‘pwd’).focus()
		return false
	}else{
		document.form1.action="/Login/DoChange"
		document.form1.submit()
		return true
	}
}
</script>
