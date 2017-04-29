/**
 * ���ܣ���ʼ��һ��XMLHTTP����
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
 * ���ܣ�����û����Ƿ��ظ�
 * ������value �û���
 */
function CheckUserName(value)
{
	if(value == '')									//�ж��û����Ƿ�Ϊ��
	{
		document.getElementById("UserName").className = 'msg';
		return true;
	}
	if(validateUsername(value))					//�ж��û�����ʽ�Ƿ���ȷ
	{
		document.getElementById("UserName").className = 'error';
		document.getElementById("UserName").innerHTML = '�û�����ʽ�����û�������Ϊ4��20λ������ĸ��ʼ��ĸ��������ɣ����ܰ��������ַ��������Ǻ��֡�';
		return true;
	}
	var url = "CheckUserName.php?UserName=" + value;	//����������˵�URL
	var ErrorMsg = document.getElementById("UserName");	//��ȡ������Ϣ��ʾ��
	var Ajax = InitAjax();								//��ʼ��Ajax����
	Ajax.open("GET", url, true); 						//ʹ��GET��������
	Ajax.onreadystatechange = function() {				//��ȡִ��״̬
		if (Ajax.readyState == 4 && Ajax.status == 200) {	//���ִ�������򽫷������ݸ�ֵ������ָ���Ĳ�
			ErrorMsg.innerHTML = Ajax.responseText;
		} 
	}
	Ajax.send(null); 
}
/**
 * ���ܣ�ִ�й�����
 * ������value ��������
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
 * ���ܣ�����
 */
function AddMsg()
{
	var url = "AddMsg.php";								//���������ļ�
	var msg = document.getElementById('content');
	var post="msg="+msg.value;							//�����ύ����
	var ajax = InitAjax();									//��ʼ��Ajax����
	ajax.open("POST",url,true);
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send(post);
	ajax.onreadystatechange = function()
	{
		if(ajax.readyState == 4 && ajax.status == 200)			//�жϻ�ȡ״̬���ɹ��򸽼ӷ�������ʾ��
		{	
			document.frames['info'].document.getElementById('msg').innerHTML +=  "��˵:" + ubb2html(msg.value) + "<br>";
			msg.value = "";
			document.frames['info'].document.getElementById('msg').scrollTop = document.body.srollHeight;
			//ʹ������ʼ���ڵײ�
		}
	}
}
function ubb2html(strUBB){
	var re=strUBB;
	// ת��HTMLʵ��
	re=re.replace(/\[img\]/ig,"<img src=\"").replace(/\[\/img\]/ig,"\" \/>");
	re=re.replace(/\[COLOR=([\s\S]+?)\]([\s\S]+?)\[\/COLOR\]/gi,"<font color=$1>$2</font>");

	// ��ԭ html �� code �е� UBB ת���
	re=re.replace(/\\\[/g,"[").replace(/\\\]/g,"]");
	return(re);
}
