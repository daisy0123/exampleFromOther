var http_request = false;
/**
 * ���ܣ�ִ�в�Ʒ��ѯ
 */
function doQuery(urlparam,functionname)	
{
	var url = "/Ajax/Product/" + urlparam;
	http_request = false;
	if (window.XMLHttpRequest) {							//�ж��Ƿ����window.XMLHttpRequest
		http_request = new XMLHttpRequest();				//��ʼ��XMLHttp����
		if (http_request.overrideMimeType) {
			http_request.overrideMimeType('text/html');
		}
	} else if (window.ActiveXObject) {						//�ж��Ƿ����window.ActiveXObject
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e){
			try {
				http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
	if (!http_request) {									//�ж��Ƿ��ʼ����XMLHttp����
		alert('�޷�����XMLhttp����');
		return false;
	}
	http_request.onreadystatechange = functionname;
	http_request.open('GET', url, true);
	http_request.send(null); 
}
/**
 * �ж�ִ��״̬
 */
function doing() {
	if (http_request.readyState == 4) {						//�ж�ajax����״̬�Ƿ�Ϊ4
		window.status = "";
		if(http_request.status == 200){						//�ж�ajax����״̬�Ƿ�Ϊ200
			try {
        		eval(http_request.responseText);
			} catch(e) {}
		} else {
			alert("��ȡ���ݴ���");
		}
	} else {
		try {
			window.status = "����������������б�...";		//��ֵ������״̬��
		} catch (e) {}
	}
}
/**
 * ��ѯ
 */
function query(value) {
	if(value > 0)										//�ж����ѡ����ֵ�Ƿ�Ϊ0
	{
		doQuery("ClassId/"+value,doing)					//����0��ִ�в�ѯ
	}else{
		$('product_id').options.length = 0;					//����Ѳ�Ʒ��������Ϊ��
	}
}
/**
 * ����������ѡ��
 */
function setOpts(valueArray,optionArray) {
	var selObj = $('product_id');
	selObj.options.length = 1;
	if (optionArray.length == valueArray.length) {				//�ж��������ѡ���Ƿ��ֵ�ĸ������
		for(j=0; j<optionArray.length; j++) {					//ѭ������������ѡ��
			if (optionArray[j]=="" && valueArray[j]==="") {		//�ж�������ѡ���ֵ�Ƿ�Ϊ��
				continue;
			} else {
				selObj.options.add(new Option(optionArray[j], valueArray[j]));
			}
		}
	}
	selObj.options[0].selected = true;
}
