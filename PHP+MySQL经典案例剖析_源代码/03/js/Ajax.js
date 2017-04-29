/**
 * 功能：初始化一个XMLHTTP对象
 */
function InitAjax()
{
	var Ajax=false; 
	try { 
		Ajax = new ActiveXObject("Msxml2.XMLHTTP"); 
	}catch (e) { 
		try { 
			Ajax = new ActiveXObject("Microsoft.XMLHTTP"); 
		}catch (E) { 
			Ajax = false; 
		} 
	}
	if (!Ajax && typeof XMLHttpRequest!='undefined') { 
		Ajax = new XMLHttpRequest(); 
	} 
	return Ajax;
}
/**
 * 功能：检查用户名是否重复
 * 参数：value 用户名
 */
function CheckUserName(value)
{
	if(value == '')									//判断用户名是否为空
	{
		document.getElementById("UserName").className = 'msg';
		return true;
	}
	if(validateUsername(value))					//判断用户名格式是否正确
	{
		document.getElementById("UserName").className = 'error';
		document.getElementById("UserName").innerHTML = '用户名格式错误！用户名长度为4－20位，以字母开始字母和数字组成，不能包含特殊字符，不能是汉字。';
		return true;
	}
	var url = "CheckUserName.php?UserName=" + value;	//定义服务器端的URL
	var ErrorMsg = document.getElementById("UserName");	//获取返回信息显示层
	var Ajax = InitAjax();								//初始化Ajax对象
	Ajax.open("GET", url, true); 						//使用GET方法请求
	Ajax.onreadystatechange = function() {				//获取执行状态
		if (Ajax.readyState == 4 && Ajax.status == 200) {	//如果执行正常则将返回内容赋值给上面指定的层
			ErrorMsg.innerHTML = Ajax.responseText;
		} 
	}
	Ajax.send(null); 
}
/**
 * 功能：执行工具栏
 * 参数：value 操作类型
 */
function Do(value,userid)
{
	if(value == '4')
	{
		window.open('MsgList.php');
	}else{
		var url = "Operation.php?type=" + value+"&userid="+userid; 
		var Ajax = InitAjax();
		Ajax.open("GET", url, true); 
		Ajax.onreadystatechange = function() { 
			if (Ajax.readyState == 4 && Ajax.status == 200) {
				document.frames['info'].document.getElementById('msg').innerHTML += Ajax.responseText;
			}
		}
		Ajax.send(null);
	}
}
/**
 * 功能：发言
 */
function AddMsg()
{
	var url = "AddMsg.php";								//定义请求文件
	var msg = document.getElementById('content');
	var post="msg="+msg.value;							//定义提交内容
	var ajax = InitAjax();									//初始化Ajax对象
	ajax.open("POST",url,true);
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send(post);
	ajax.onreadystatechange = function()
	{
		if(ajax.readyState == 4 && ajax.status == 200)			//判断获取状态，成功则附加发言在显示区
		{	
			document.frames['info'].document.getElementById('msg').innerHTML +=  "我说:" + ubb2html(msg.value) + "<br>";
			msg.value = "";
			document.frames['info'].document.getElementById('msg').scrollTop = document.body.srollHeight;
			//使滚动条始终在底部
		}
	}
}
function ubb2html(strUBB){
	var re=strUBB;
	// 转换HTML实体
	re=re.replace(/\[img\]/ig,"<img src=\"").replace(/\[\/img\]/ig,"\" \/>");
	re=re.replace(/\[COLOR=([\s\S]+?)\]([\s\S]+?)\[\/COLOR\]/gi,"<font color=$1>$2</font>");

	// 还原 html 和 code 中的 UBB 转意符
	re=re.replace(/\\\[/g,"[").replace(/\\\]/g,"]");
	return(re);
}
