//功能：显示开始日期指定月份的天数
//参数：month 月份
function register_buildDay(month)
{
	var yearOb=document.getElementById('year');			//取得开始日期年份
	var dayOb=document.getElementById('day');			//取得开始日期天数
	
	document.getElementById('day').length = 0;	
	var lastDay=register_getDay(yearOb.value,Number(month));//取得当月的天数
	for(var i=1;i<=lastDay;i++)								//循环输出下拉选择框
	{
		var dayOption=document.createElement("OPTION");
		dayOb.options.add(dayOption);
		dayOption.innerText=i;
		dayOption.value=i;
		dayOb.selectedIndex=0;
	}
}
//功能：重新设置开始日期的天数
function register_resetDay()
{
	var dayObject=document.getElementById('start_d');
	var dayLength=dayObject.length;
	
	for(var i=1;i<dayLength;dayLength--)					//将开始日期天数的下拉框循环移处
	{
		dayObject.remove(i);
	}
}
//功能：取得指定年份和月份的天数
//参数：year 年份 month 月份
function register_getDay(Year,Month)
{
	var LastDay = 0;
	switch (Month)											//判断月份,1,3,5,7,8,10,12天数为31天，4,6,9,11为30天
	{		
		case 1:
		case 3:
		case 5:
		case 7:
		case 8:
			Month="0"+ Month;
		case 10:
		case 12:
			LastDay=31;
			break;		
		case 4:
		case 6:
		case 9:
			Month="0"+ Month;
		case 11:
			LastDay=30;
			break;				
		case 2:												//判断是否为闰年，是则2月为29天，不是则为28天
			Month="0"+ Month;
			if ((Year%4==0&&Year%100!=0)||Year%400==0)
			{				
				LastDay=29;
			}
			else
			{
				LastDay=28;
			}
			break;
		default:
			LastDay=0;
	}

	return LastDay;
}