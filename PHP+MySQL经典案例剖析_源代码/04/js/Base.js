/**
 * ���ܣ�ȡ�ý��㣬�ı�DIV��ʽ
 * ������value ������ʶ
 */
function GetFocus(value)
{
	switch(value)
	{
		case 1:											//value=1�ı��û���DIV��ʽ
			document.getElementById('UserName').className = 'info';
		break;
		case 2:											//value=2�ı�����DIV��ʽ
			document.getElementById('Pwd').className = 'info';
		break;
		case 3:											//value=3�ı��ظ�����DIV��ʽ
			document.getElementById('Confirm_Pwd').className = 'info';
		break;
		case 4:											//value=4�ı��ǳ�DIV��ʽ
			document.getElementById('Nick').className = 'info';
		break;
	}
}
/**
 * ���ܣ����鳤���Ƿ���ȷ
 * ������str ����ֵ,minlen ��С����,maxlen ��󳤶�
 * ���أ�TRUE OR FALSE
 */
function checkByteLength(str,minlen,maxlen) {
	if (str == null) return false;									//Ϊ�շ���false
	var l = str.length;
	var blen = 0;
	for(i=0; i<l; i++) {										//ѭ��ȡ�ü���ֵ�ĳ���
		if ((str.charCodeAt(i) & 0xff00) != 0) {
			blen ++;
		}
		blen ++;
	}
	if (blen > maxlen || blen < minlen) {							//�жϳ����Ƿ�Ϸ�
		return false;
	}
	return true;
}
/**
 * ���ܣ������û����Ƿ�Ϸ�
 * ������value ����ֵ
 * ���أ�TRUE OR FALSE
 */
function validateUsername(value){
	var patn = /^[a-zA-Z]+[a-zA-Z0-9]+$/; 
	//var patn = /^[^\s]*$/;
	if(!checkByteLength(value,4,20)) return true;					//�жϳ����Ƿ�Ϸ�
	if(!patn.test(value)){										//�жϸ�ʽ�Ƿ�Ϸ�
		return true;
	}
	return false; 
}
/**
 * ���ܣ����������Ƿ�Ϸ�
 * ������value ����ֵ
 * ���أ�TRUE OR FALSE
 */
function validatePassword(value){
	if(!checkByteLength(value,5,15)) return 1;						//�жϳ����Ƿ�Ϸ�
	var patn1 = /^[a-zA-Z0-9_]+$/;
	if(!patn1.test(value) ) return 1;								//�жϸ�ʽ�Ƿ�Ϸ�
	return 0; 
}
/**
 * ���ܣ������û���
 * ������value ����ֵ
 * ���أ�TRUE OR FALSE
 */
function checkUserName(value)
{
	if(value == '')											//�ж��û����Ƿ�Ϊ�գ�����false
	{
		document.getElementById("UserName").className = 'msg';
		return false;
	}
	if(!validateUsername(value))								//�ж��û����Ƿ�Ϸ�
	{
		document.getElementById("UserName").className = 'error';
		document.getElementById("UserName").innerHTML = '�û�����ʽ�����û�������Ϊ4��20λ������ĸ��ʼ��ĸ��������ɣ����ܰ��������ַ��������Ǻ��֡�';
		return false;
	}
	return true;
}
/**
 * ���ܣ���������
 * ������value ����ֵ
 * ���أ�TRUE OR FALSE
 */
function CheckPassword(value)
{
	if(value == '')											//�ж������Ƿ�Ϊ��
	{
		document.getElementById("Pwd").className = 'msg';
		return false;
	}
	if(!validatePassword(value))								//�ж������Ƿ�Ϸ�
	{
		document.getElementById("Pwd").className = 'error';
		document.getElementById("Pwd").innerHTML = '�û������ʽ�����û���������5~15����ĸ(���ִ�Сд)��������ɡ�';
		return false;
	}
	return true;
}
/**
 * ���ܣ������ظ�����
 * ������value ����ֵ
 * ���أ�TRUE OR FALSE
 */
function CheckConfirm(value)
{
	if(value != document.register.password.value)					//�ж��ظ������Ƿ����������
	{
		document.getElementById("Confirm").className = 'error';
		document.getElementById("Confirm").innerHTML = '�ظ���������벻һ��!';
		return false;
	}
	return true;
}
/**
 * ���ܣ������ǳ�
 * ������value ����ֵ
 * ���أ�TRUE OR FALSE
 */
function CheckNickName(value)
{
	if(value == '')											//�ж��ǳ��Ƿ�Ϊ��
	{
		document.getElementById("Nick").className = 'msg';
		return false;		
	}
	if(!checkByteLength(value,4,20))							//�ж��ǳƳ����Ƿ���ȷ
	{
		document.getElementById("Nick").className = 'error';
		document.getElementById("Nick").innerHTML = '�ǳƳ��Ȳ���ȷ���ǳƳ���Ϊ4��20λ��';
		return false;
	}
	return true;
}
/**
 * ���ܣ�������ĸ����Ƿ���ȷ
 * ���أ�TRUE OR FALSE
 */
function CheckForm()
{
	if(!checkUserName(document.register.UserID.value))			//�ж��û����Ƿ���ȷ
	{
		return false;
	}
	
	if(!CheckPassword(document.register.password.value))			//�ж������Ƿ���ȷ
	{
		return false;
	}
	
	if(!CheckConfirm(document.register.Confirm.value))				//�ж�ȷ�������Ƿ���ȷ
	{
		return false;
	}
	
	if(!CheckNickName(document.register.NickName.value))			//�ж��ǳ��Ƿ���ȷ
	{
		return false;
	}
	return true;
}
/**
 * ���ܣ����������ɫ��ǩ
 * ������color ��ɫ����
 */
function showcolor(color){
	fontbegin="[color="+color+"]";
	fontend="[/color]";
	fontchuli();
}
/**
 * ���ܣ�������ɫ����
 */
function fontchuli(){
	if ((document.selection)&&(document.selection.type == "Text")) {	//�ж��Ƿ���ѡ�������ַ�
		var range = document.selection.createRange();	
		var ch_text=range.text;
		range.text = fontbegin + ch_text + fontend;
	}else {												//���δѡ�ַ���Ĭ���������������
		document.frm_write.content.value=fontbegin+document.frm_write.content.value+fontend;
		document.frm_write.content.focus();
	}
}
/**
 * ���ܣ���ʾ����
 * ������face ����·��
 */
function showface(face)
{
	facetext = "[img]"+face+"[/img]";							//��ɱ������
	document.frm_write.content.value+=facetext;					//��������������֮��
	document.getElementById('Layer1').style.display = 'none';			//���ر���ѡ���
	document.frm_write.content.focus();							//���㶨λ�������
}
function Select(value,name)
{
	var flag = false;
	for(j= 0 ; j < document.form1.frm_write.options.length ; j++)		//ѭ���б�ÿһ��ѡ��
	{
		if(document.form1.frm_write.options[j].value == value)		//�жϸ�ѡ���Ƿ����
			flag = true;
	}
	if(!flag)												//�����ѡ�����
	{
		SelectOption = new Option(name,value);					//������ѡ��
		document.form1.frm_write.options[document.form1.frm_write.options.length] = SelectOption ;
	}
}