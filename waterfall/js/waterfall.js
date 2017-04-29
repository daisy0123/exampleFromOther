window.onload=function(){
	waterfall("container","box");	
	var imgData={"data":[{"src":"1.jpg"},{"src":"2.jpg"},{"src":"3.jpg"},{"src":"4.jpg"},{"src":"5.jpg"},{"src":"6.jpg"},{"src":"7.jpg"}]};
	window.onscroll=function(){
		if(checkFlag()){
			var cparent=document.getElementById("container");
			for(var i=0;i<imgData.data.length;i++){
				var ccontent=document.createElement("div");
				ccontent.className="box";
				cparent.appendChild(ccontent);
				var boximg=document.createElement("div");
				boximg.className="box_img";
				ccontent.appendChild(boximg);
				var img=document.createElement("img");
				img.src="img/"+imgData.data[i].src;
				boximg.appendChild(img);
			}
			waterfall("container","box");
		}
		
	}
}

function checkFlag(){
	var cparent=document.getElementById("container");
	var ccontent=getChildElement(cparent,"box");
	var lastContentHeight=ccontent[ccontent.length-1].offsetTop;
	var scrolltop=document.documentElement.scrollTop ||document.body.scrollTop;
	var pageHeight=document.documentElement.clientHeight||document.body.clientHeight;
	if(lastContentHeight<scrolltop+pageHeight){
		return true;
	}
}

function waterfall(parent,content){
		var cparent=document.getElementById(parent);
		var ccontent=getChildElement(cparent,content);
		var imgWidth=ccontent[0].offsetWidth;
		var num=Math.floor(document.documentElement.clientWidth/imgWidth);
		cparent.style.cssText="width:"+imgWidth*num+"px;margin:0 auto";
		
		var boxHeightArr=[];
		for(var i=0;i<ccontent.length;i++){
			if(i<num){
				boxHeightArr[i]=ccontent[i].offsetHeight;
			}else{
				var minHeight=Math.min.apply(null,boxHeightArr);
				var minIndex=getminheightLocation(boxHeightArr,minHeight);		
				ccontent[i].style.position="absolute";
				ccontent[i].style.top=minHeight+"px";
				ccontent[i].style.left=ccontent[minIndex].offsetLeft+"px";
				boxHeightArr[minIndex]=boxHeightArr[minIndex]+ccontent[i].offsetHeight;
			}
		}
}
function getminheightLocation(boxHeightArr,minHeight){
	for(var i in boxHeightArr){
		if(boxHeightArr[i]==minHeight){
			return i;
		}
	}
}


function getChildElement(parent,content){
	var contentArr=[];
	var allcontent=parent.getElementsByTagName("*");
	for(var i=0;i<allcontent.length;i++){
		if(allcontent[i].className==content){
			contentArr.push(allcontent[i]);
		}
	}
	return contentArr;
}
