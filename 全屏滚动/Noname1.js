(function($){
	var _prefix=(function(temp){
		var aPrefix=["webkit","Moz","o","ms"],
			props="";
		for(var i in aPrefix){
			props=aPrefix[i]+"Transition";
			if(temp.style[props]!==undefined){
				return "-"+aPrefix[i].toLowerCase()+"-";
			}
		}
		return flase;
	})(document.createElement(PageSwitch));//获取浏览器前缀方法

	var PageSwitch=(function(){
		function PageSwitch(element,options){
			this.settings=$.extend(true,$.fn.PageSwitch.defaults,options||{});
			this.element=element;
			this.init();
		}
		PageSwitch.prototype={
			init:function(){
				var me=this;
				me.selectors=me.settings.selectors;
				me.sections=me.element.find(me.selectors.sections);
				me.section=me.sections.find(me.selectors.section);
				
				me.direction=me.settings.direction=="vertical"?true:false;
				me.pagesCount=me.pagesCount();
				me.index=(me.settings.index>=0&&me.settings.index<me.pagesCount)?me.settings.index:0;
				if(!me.direction){
					me._initLayout();
				}
				if(me.settings.pagination){
					me._initPaging();
				}
				me._initEvent();
			},
			pagesCount:function(){
				return this.section.length;
			},
			switchLength:function(){
				return this.direction?this.element.height():this.element.width();
			},
			prev:function(){
				var me=this;
				if(me.index>0){
					me.index--;
				}else if(me.settings.loop){
					me,index=me.pagesCount-1;
				}
				me._scrollPage();
			},
			next:function(){
				var me=this;
				if(me.index<me.pagesCount){
					me.index++;
				}else if(me.settings.loop){
					me,index=0;
				}
				me._scrollPage();
			},
			_initLayout:function(){
				var me=this;
				var width=(me.PagesCount*100)+"%",
					cellWidth=(100/me.pagesCount).toFixed(2)+"%";
				me.sections.width(width);
				me.section.width(cellWidth).css("float","left");
			},
			_initPaging:function(){
				var me=this,
					pagesClass=me.selectors.page.subString(1);
				    me.activeClass=me.selectors.active.subString(1);
				var pageHtml="<ul class="+pagesClass+">";
				for(var i=0;i<me.pagesCount;i++){
					pageHtml+="<li></li>";
				}
				pageHtml+="<ul>";
				me.element.append(pageHtml);
				var pages=me.element.find(me.selectors.page);
				me.pageItem=pages.find("li");
				me.pageItem.eq(0).addClass('active');

				if(me.direction){
					pages.addClass("vertical");
				}else{
					pages.addClass("horizontal");
				}
				
			},
				//初始化五个事件
			_initEvent:function(){
				var me=this;
				me.element.on("click",me.selectors.pages+"li",function(){
					me.index=$(this).index();
					me._scrollPage();
				});
				me.element.on("mousewheel DOMMouseScroll",function(e){
					var dalta=e.originalEvent.wheelDelta||-e.originalEvent.wheelDelta;
					if(delta>0&&(me.index&&!me.settings.loop||me.settings.loop)){
						me.prev();//上一页
					}else if(delta<0&&(me.index<(me.pagesCount-1)&&!me.settings.loop||me.settings.loop)){
						me.next();
					}
				});
				if(me.settings.keyboard){
					$(window).on("keydown",function(e){
						var keyCode=e.keyCode;
						if(keyCode==37||keyCode==38){
							me.prev();
						}else if(keyCode==39||keyCode==40){
							me.next();
						}
					});
				}
				$(window).resize(function(){
					var currentLength=me.switchLength(),
						offset=me.settings.direction?me.section.eq(me.index).offset().top:me.section.eq(me.index).offset().left;
						if(Math.abs(offset)>currentLength/2&&me.index<(me.pagesCount-1)){
							me.index++;
						}
						if(me.index){
							me._scrollPage();
						}
				});

               me.sections.on("webkitTransitionEnd msTransitionend mozTransitionend transitionend",function(){
					if(me.ssttings.callback && $.type(me.settings.callback)=="function"){
						me.settings.callback();
					}
			   });
			},
			_scrollPage:function(){
				var me=this,
				    dest=me.section.eq(me.index).position();
				if(!dest) return;
				me.canScroll=false;
				if(_prefix){
					me.sections.css(_prefis+"transition","all"+me.settings.duration+"ms"+me.settings.easing);
					var translate=me.direction?"translateY(-"+dest.top+"px)":"translateX(-"+dest.left+"px)";
					me.sections.css(_prefix+"transform",translate);
				}else{
					var animateCss=me.direction?{top:-dest.top}:{left:-dest.left};
					me.sections.animate(animateCss,me.settings.duration,function(){
						me.canScroll=true;
						if(me.ssttings.callback && $.type(me.settings.callback)=="function"){
						me.settings.callback();
					}
					});
				}
						 if(me.settings.pagination){
                    me.pageItem.eq(me.index).addClass(me.activeClass).siblings("li").removeClass(me.activeClass);
                }
			}
		};//dom结构初始化
		return PageSwitch;
	})();
	$.fn.PageSwitch=function(options){
		console.log('star');
		return this.each(function(){
			var me=$(this),
				instance=me.data("PageSwitch");//插件的实例
			if(!instance){
				instance=new PageSwitch(me,options);
				me.data("PageSwitch",instance);
			}//判断是否存在，否则创建
			if($.type(options)==="string")  return instance[options]();
			
		});
	}
	$.fn.PageSwitch.defaults={
		selectors:{
			sections:".sections",
			section:".section",
			page:".page",
			active:".active"
		},
		index:0,
		easing:"ease",
		duration:500,//动画页面执行的时间
		loop:"false",//页面是否循环播放
		pagination:true,//是否进行分页处理
		keyboard:true,//是否触发键盘事件
		direction:"vertical",
		callback:""
	};
	   $(function(){
            $("[data-PageSwitch]").PageSwitch({
                loop:true,
                direction:"horizontal",
                callback:function(){
                    
                }
            });
        });
})(jQuery);