<div id="SearchContent" style="width:98%; ">
<div id="top_left">
<h2 class="hot">�޸�����</h2>
</div>
</div>
<div id="contt">
<form id="form1" name="form1" method="post" action="">
<div align="left">
<h2><img src="/images/jiantou_1.gif" alt="1" width="9" height="13" />����������������</a> </h2>
</div>
<p>�� �� �룺
<input name="pwd" type="password" id="pwd" />
<br />
�ظ����룺
<input name="confirm_pwd" type="password" id="confirm_pwd" />
<br />
<input type="button" name="Submit" value="�ύ" onclick="javascript:check();" />
</form>
</div>
<script language="javascript">
function check()
{
	if ($(��pwd��).value || $(��confirm_pwd��).value) {					//�ж������Ƿ�Ϊ��
		alert('������Ŀ����Ϊ��');
		return false;
	}
	if($(��pwd��).value != $(��confirm_pwd��).value)					//�ж�����ǰ�������Ƿ�һ��
	{
		alert("����ǰ��һ��")
		$(��pwd��).focus()
		return false
	}else{
		document.form1.action="/Login/DoChange"
		document.form1.submit()
		return true
	}
}
</script>
