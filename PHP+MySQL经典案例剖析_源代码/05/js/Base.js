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
	if(!checkByteLength(value,4,16)) return true;					//�жϳ����Ƿ�Ϸ�
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
	if(!checkByteLength(value,6,16)) return false;					//�жϳ����Ƿ�Ϸ�
	var patn1 = /^[a-zA-Z0-9_]+$/;
	if(!patn1.test(value) ) return false;							//�жϸ�ʽ�Ƿ�Ϸ�
	return true; 
}
/**
 * ���ܣ�����Email�Ƿ�Ϸ�
 * ������value ����ֵ
 * ���أ�TRUE OR FALSE
 */
function validateEmail(value){
	var patn=/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
	if(!patn.test(value)) return false;								//�ж�Email�Ƿ�Ϸ�
	return true;
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
		return false;
	}
	if(validateUsername(value))								//�ж��û����Ƿ�Ϸ�
	{
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
		return false;
	}
	if(!validatePassword(value))								//�ж������Ƿ�Ϸ�
	{
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
	if(value != '')
	{
		if(!checkByteLength(value,4,20))						//�ж��ǳƳ����Ƿ���ȷ
		{
			return false;
		}
	}
	return true;
}
/**
 * ���ܣ�����Email
 * ������value ����ֵ
 * ���أ�TRUE OR FALSE
 */
function CheckEmail(value)
{
	if(value == '')											//�ж�Email�Ƿ�Ϊ��
	{
		return false;
	}
	if(!validateEmail(value))									//�ж�Email�Ƿ�Ϸ�
	{
		return false
	}
	return true;
}
/**
 * ���ܣ���������
 * ������value ����ֵ
 * ���أ�TRUE OR FALSE
 */
function CheckBlogName(value)
{
	if(value == '')											//�ж������Ƿ�Ϊ��
	{
		return false;
	}
	
	if(!checkByteLength(value,1,50))							//�ж������Ƿ�Ϸ�
	{
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
	if(!checkUserName(document.register.username.value))			//�ж��û����Ƿ���ȷ
	{
		alert('�û����Ƹ�ʽ����ȷ');
		document.register.username.focus();
		return false;
	}
	
	if(!CheckPassword(document.register.password.value))			//�ж������Ƿ���ȷ
	{
		alert('�����ʽ����ȷ');
		document.register.password.focus();
		return false;
	}
	
	if(!CheckConfirm(document.register.Confirm.value))				//�ж�ȷ�������Ƿ���ȷ
	{
		alert('ȷ�����������벻һ��');
		document.register.Confirm.focus();		
		return false;
	}
	
	if(!CheckNickName(document.register.NickName.value))			//�ж��ǳ��Ƿ���ȷ
	{
		alert('�ǳƲ���ȷ');
		document.register.NickName.focus();
		return false;
	}
	if(!CheckEmail(document.register.Email.value))					//�ж�Email�Ƿ���ȷ
	{
		alert('Email��ʽ����ȷ');
		document.register.Email.focus();
		return false;
	}
	if(!CheckBlogName(document.register.Blog.value))				//�жϲ��������Ƿ���ȷ
	{
		alert('�������Ʋ���ȷ');
		document.register.Blog.focus();
		return false;		
	}
	return true;
}
/**
 * ���ܣ���������СͼƬ
 * ������pic ͼƬ�ļ�,rwidth ָ�����
 */
function resizePic(pic,rwidth) {
	pwidth = pic.width;										//ȡ��ͼƬ���
	if (pwidth > rwidth) {										//���ͼƬ��ȴ���ָ���������С
		pheight = pic.height;									//��ȡͼƬ�߶�
		rheight =  Math.ceil(pheight * (rwidth/pwidth));				//����������ͼƬ�߶�
		pic.width = rwidth;
		pic.height = rheight;
	}
}
