/**
 * 功能：生成日期下拉框
 */
function register_buildDay(month,year,day)
{
	var yearOb=$(year);
	var dayOb=$(day);
	dayOb.length = 0;
	var lastDay=register_getDay(yearOb.value,Number(month));				//获取当月天数
	for(var i=1;i<=lastDay;i++)											//循环生成下拉框
	{
		var dayOption=document.createElement("OPTION");
		dayOb.options.add(dayOption);
		dayOption.innerText=i;
		dayOption.value=i;
		dayOb.selectedIndex=0;
	}
}
/**
 * 功能：获得指定年月的天数
 */
function register_getDay(Year,Month)
{
	var LastDay = 0;
	switch (Month)
	{		
		case 1:													//1,3,5,7,8,10,12为31天
		case 3:
		case 5:
		case 7:
		case 8:
		case 10:
		case 12:
			LastDay=31;
			break;		
		case 4:													//4,6,9,11为30天
		case 6:
		case 9:
		case 11:
			LastDay=30;
			break;
		case 2:
			if ((Year%4==0&&Year%100!=0)||Year%400==0)				//判断是否是闰年
			{				
				LastDay=29;
			}else	{
				LastDay=28;
			}
			break;
		default:
			LastDay=0;
	}
	return LastDay;
}
