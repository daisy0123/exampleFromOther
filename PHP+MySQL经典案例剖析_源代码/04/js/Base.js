/**
 * 功能：取得焦点，改变DIV样式
 * 参数：value 输入框标识
 */
function GetFocus(value)
{
	switch(value)
	{
		case 1:											//value=1改变用户名DIV样式
			document.getElementById('UserName').className = 'info';
		break;
		case 2:											//value=2改变密码DIV样式
			document.getElementById('Pwd').className = 'info';
		break;
		case 3:											//value=3改变重复密码DIV样式
			document.getElementById('Confirm_Pwd').className = 'info';
		break;
		case 4:											//value=4改变昵称DIV样式
			document.getElementById('Nick').className = 'info';
		break;
	}
}
/**
 * 功能：检验长度是否正确
 * 参数：str 检验值,minlen 最小长度,maxlen 最大长度
 * 返回：TRUE OR FALSE
 */
function checkByteLength(str,minlen,maxlen) {
	if (str == null) return false;									//为空返回false
	var l = str.length;
	var blen = 0;
	for(i=0; i<l; i++) {										//循环取得检验值的长度
		if ((str.charCodeAt(i) & 0xff00) != 0) {
			blen ++;
		}
		blen ++;
	}
	if (blen > maxlen || blen < minlen) {							//判断长度是否合法
		return false;
	}
	return true;
}
/**
 * 功能：检验用户名是否合法
 * 参数：value 检验值
 * 返回：TRUE OR FALSE
 */
function validateUsername(value){
	var patn = /^[a-zA-Z]+[a-zA-Z0-9]+$/; 
	//var patn = /^[^\s]*$/;
	if(!checkByteLength(value,4,20)) return true;					//判断长度是否合法
	if(!patn.test(value)){										//判断格式是否合法
		return true;
	}
	return false; 
}
/**
 * 功能：检验密码是否合法
 * 参数：value 检验值
 * 返回：TRUE OR FALSE
 */
function validatePassword(value){
	if(!checkByteLength(value,5,15)) return 1;						//判断长度是否合法
	var patn1 = /^[a-zA-Z0-9_]+$/;
	if(!patn1.test(value) ) return 1;								//判断格式是否合法
	return 0; 
}
/**
 * 功能：检验用户名
 * 参数：value 检验值
 * 返回：TRUE OR FALSE
 */
function checkUserName(value)
{
	if(value == '')											//判断用户名是否为空，返回false
	{
		document.getElementById("UserName").className = 'msg';
		return false;
	}
	if(!validateUsername(value))								//判断用户名是否合法
	{
		document.getElementById("UserName").className = 'error';
		document.getElementById("UserName").innerHTML = '用户名格式错误！用户名长度为4－20位，以字母开始字母和数字组成，不能包含特殊字符，不能是汉字。';
		return false;
	}
	return true;
}
/**
 * 功能：检验密码
 * 参数：value 检验值
 * 返回：TRUE OR FALSE
 */
function CheckPassword(value)
{
	if(value == '')											//判断密码是否为空
	{
		document.getElementById("Pwd").className = 'msg';
		return false;
	}
	if(!validatePassword(value))								//判断密码是否合法
	{
		document.getElementById("Pwd").className = 'error';
		document.getElementById("Pwd").innerHTML = '用户密码格式错误！用户的密码由5~15个字母(区分大小写)或数字组成。';
		return false;
	}
	return true;
}
/**
 * 功能：检验重复密码
 * 参数：value 检验值
 * 返回：TRUE OR FALSE
 */
function CheckConfirm(value)
{
	if(value != document.register.password.value)					//判断重复密码是否与密码相符
	{
		document.getElementById("Confirm").className = 'error';
		document.getElementById("Confirm").innerHTML = '重复密码和密码不一致!';
		return false;
	}
	return true;
}
/**
 * 功能：检验昵称
 * 参数：value 检验值
 * 返回：TRUE OR FALSE
 */
function CheckNickName(value)
{
	if(value == '')											//判断昵称是否为空
	{
		document.getElementById("Nick").className = 'msg';
		return false;		
	}
	if(!checkByteLength(value,4,20))							//判断昵称长度是否正确
	{
		document.getElementById("Nick").className = 'error';
		document.getElementById("Nick").innerHTML = '昵称长度不正确！昵称长度为4－20位。';
		return false;
	}
	return true;
}
/**
 * 功能：检验表单的各项是否正确
 * 返回：TRUE OR FALSE
 */
function CheckForm()
{
	if(!checkUserName(document.register.UserID.value))			//判断用户名是否正确
	{
		return false;
	}
	
	if(!CheckPassword(document.register.password.value))			//判断密码是否正确
	{
		return false;
	}
	
	if(!CheckConfirm(document.register.Confirm.value))				//判断确认密码是否正确
	{
		return false;
	}
	
	if(!CheckNickName(document.register.NickName.value))			//判断昵称是否正确
	{
		return false;
	}
	return true;
}
/**
 * 功能：组成字体颜色标签
 * 参数：color 颜色代码
 */
function showcolor(color){
	fontbegin="[color="+color+"]";
	fontend="[/color]";
	fontchuli();
}
/**
 * 功能：字体颜色处理
 */
function fontchuli(){
	if ((document.selection)&&(document.selection.type == "Text")) {	//判断是否有选种输入字符
		var range = document.selection.createRange();	
		var ch_text=range.text;
		range.text = fontbegin + ch_text + fontend;
	}else {												//如果未选字符则默认整个输入的内容
		document.frm_write.content.value=fontbegin+document.frm_write.content.value+fontend;
		document.frm_write.content.focus();
	}
}
/**
 * 功能：显示表情
 * 参数：face 表情路径
 */
function showface(face)
{
	facetext = "[img]"+face+"[/img]";							//组成表情代码
	document.frm_write.content.value+=facetext;					//附加在输入内容之后
	document.getElementById('Layer1').style.display = 'none';			//隐藏表情选择层
	document.frm_write.content.focus();							//焦点定位在输入框
}
function Select(value,name)
{
	var flag = false;
	for(j= 0 ; j < document.form1.frm_write.options.length ; j++)		//循环列表每一个选项
	{
		if(document.form1.frm_write.options[j].value == value)		//判断该选项是否存在
			flag = true;
	}
	if(!flag)												//如果该选项不存在
	{
		SelectOption = new Option(name,value);					//生成新选项
		document.form1.frm_write.options[document.form1.frm_write.options.length] = SelectOption ;
	}
}