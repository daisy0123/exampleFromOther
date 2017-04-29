/**
 * 功能：指定菜单伸缩
 * 参数：菜单ID
 * 返回：FALSE
 */
function Tree(ID){
	obj=document.getElementById("cate_"+ID);			//获取子菜单对象	
	img=document.getElementById("img_"+ID);			//获取菜单伸缩图片对象
	if(obj.style.display=="none"){						//判断子菜单是否已收缩
		obj.style.display="";							//是则伸展
		img_re=new RegExp("_open\\.gif$");				//定义正则表达式用于图片替换
		img.src=img.src.replace(img_re,'_fold.gif');		//替换显示图片
	}else{
		obj.style.display="none";						//否则收缩
		img_re=new RegExp("_fold\\.gif$");				//定义正则表达式用于图片替换
		img.src=img.src.replace(img_re,'_open.gif');		//替换显示图片
	}
	return false;
}
/**
 * 功能：伸展所有菜单
 * 参数：count 菜单数
 * 返回：FALSE
 */
function Clear(count){
	var i;
	for(i=0;i<count;i++){								//循环所有菜单
		obj=document.getElementById("cate_"+"a"+i);		//获取子菜单对象
		img=document.getElementById("img_"+"a"+i);		//获取菜单伸缩图片对象
		if(obj && obj.style.display=="none"){				//判断子菜单是否已收缩
			obj.style.display="";						//是则伸展
			img_re=new RegExp("_open\\.gif$");			//定义正则表达式用于图片替换
			img.src=img.src.replace(img_re,'_fold.gif');	//替换显示图片
		}
	}
	return false;
}
/**
 * 功能：收缩所有菜单
 * 参数：count 菜单数
 * 返回：FALSE
 */
function SetAdminDeploy(count){
	var i;
	for(i=0;i<count;i++){								//循环所有菜单
		obj=document.getElementById("cate_"+"a"+i);		//获取子菜单对象
		img=document.getElementById("img_"+"a"+i);		//获取菜单伸缩图片对象
		if(obj && obj.style.display==""){					//判断子菜单是否已伸展
			obj.style.display="none";					//是则收缩
			img_re=new RegExp("_fold\\.gif$");			//定义正则表达式用于图片替换
			img.src=img.src.replace(img_re,'_open.gif');	//替换显示图片
		}
	}
	return false;
}
