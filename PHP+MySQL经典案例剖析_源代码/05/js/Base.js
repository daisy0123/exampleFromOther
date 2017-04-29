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
	if(!checkByteLength(value,4,16)) return true;					//判断长度是否合法
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
	if(!checkByteLength(value,6,16)) return false;					//判断长度是否合法
	var patn1 = /^[a-zA-Z0-9_]+$/;
	if(!patn1.test(value) ) return false;							//判断格式是否合法
	return true; 
}
/**
 * 功能：检验Email是否合法
 * 参数：value 检验值
 * 返回：TRUE OR FALSE
 */
function validateEmail(value){
	var patn=/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
	if(!patn.test(value)) return false;								//判断Email是否合法
	return true;
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
		return false;
	}
	if(validateUsername(value))								//判断用户名是否合法
	{
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
		return false;
	}
	if(!validatePassword(value))								//判断密码是否合法
	{
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
	if(value != '')
	{
		if(!checkByteLength(value,4,20))						//判断昵称长度是否正确
		{
			return false;
		}
	}
	return true;
}
/**
 * 功能：检验Email
 * 参数：value 检验值
 * 返回：TRUE OR FALSE
 */
function CheckEmail(value)
{
	if(value == '')											//判断Email是否为空
	{
		return false;
	}
	if(!validateEmail(value))									//判断Email是否合法
	{
		return false
	}
	return true;
}
/**
 * 功能：博客名称
 * 参数：value 检验值
 * 返回：TRUE OR FALSE
 */
function CheckBlogName(value)
{
	if(value == '')											//判断名称是否为空
	{
		return false;
	}
	
	if(!checkByteLength(value,1,50))							//判断名称是否合法
	{
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
	if(!checkUserName(document.register.username.value))			//判断用户名是否正确
	{
		alert('用户名称格式不正确');
		document.register.username.focus();
		return false;
	}
	
	if(!CheckPassword(document.register.password.value))			//判断密码是否正确
	{
		alert('密码格式不正确');
		document.register.password.focus();
		return false;
	}
	
	if(!CheckConfirm(document.register.Confirm.value))				//判断确认密码是否正确
	{
		alert('确认密码与密码不一致');
		document.register.Confirm.focus();		
		return false;
	}
	
	if(!CheckNickName(document.register.NickName.value))			//判断昵称是否正确
	{
		alert('昵称不正确');
		document.register.NickName.focus();
		return false;
	}
	if(!CheckEmail(document.register.Email.value))					//判断Email是否正确
	{
		alert('Email格式不正确');
		document.register.Email.focus();
		return false;
	}
	if(!CheckBlogName(document.register.Blog.value))				//判断博客名称是否正确
	{
		alert('博客名称不正确');
		document.register.Blog.focus();
		return false;		
	}
	return true;
}
/**
 * 功能：按比例缩小图片
 * 参数：pic 图片文件,rwidth 指定宽度
 */
function resizePic(pic,rwidth) {
	pwidth = pic.width;										//取得图片宽度
	if (pwidth > rwidth) {										//如果图片宽度大于指定宽度则缩小
		pheight = pic.height;									//获取图片高度
		rheight =  Math.ceil(pheight * (rwidth/pwidth));				//按比例计算图片高度
		pic.width = rwidth;
		pic.height = rheight;
	}
}
