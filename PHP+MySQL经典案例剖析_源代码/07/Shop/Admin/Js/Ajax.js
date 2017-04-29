var http_request = false;
/**
 * 功能：执行产品查询
 */
function doQuery(urlparam,functionname)	
{
	var url = "/Ajax/Product/" + urlparam;
	http_request = false;
	if (window.XMLHttpRequest) {							//判断是否存在window.XMLHttpRequest
		http_request = new XMLHttpRequest();				//初始化XMLHttp对象
		if (http_request.overrideMimeType) {
			http_request.overrideMimeType('text/html');
		}
	} else if (window.ActiveXObject) {						//判断是否存在window.ActiveXObject
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e){
			try {
				http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
	if (!http_request) {									//判断是否初始化了XMLHttp对象
		alert('无法创建XMLhttp对象');
		return false;
	}
	http_request.onreadystatechange = functionname;
	http_request.open('GET', url, true);
	http_request.send(null); 
}
/**
 * 判断执行状态
 */
function doing() {
	if (http_request.readyState == 4) {						//判断ajax返回状态是否为4
		window.status = "";
		if(http_request.status == 200){						//判断ajax返回状态是否为200
			try {
        		eval(http_request.responseText);
			} catch(e) {}
		} else {
			alert("获取数据错误！");
		}
	} else {
		try {
			window.status = "正在向服务器请求列表...";		//付值给窗口状态栏
		} catch (e) {}
	}
}
/**
 * 查询
 */
function query(value) {
	if(value > 0)										//判断类别选择框的值是否为0
	{
		doQuery("ClassId/"+value,doing)					//不是0则执行查询
	}else{
		$('product_id').options.length = 0;					//是则把产品下拉框置为空
	}
}
/**
 * 设置下拉框选项
 */
function setOpts(valueArray,optionArray) {
	var selObj = $('product_id');
	selObj.options.length = 1;
	if (optionArray.length == valueArray.length) {				//判断下拉框的选项是否和值的个数相等
		for(j=0; j<optionArray.length; j++) {					//循环设置下拉框选项
			if (optionArray[j]=="" && valueArray[j]==="") {		//判断下拉框选项和值是否为空
				continue;
			} else {
				selObj.options.add(new Option(optionArray[j], valueArray[j]));
			}
		}
	}
	selObj.options[0].selected = true;
}
