<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'vote.inc.php');
$vote = new Vote();
list($year,$month,$day) = explode("-",date('Y-m-d'));
if($_SERVER['REQUEST_METHOD'] == 'POST')							//判断是否是提交请求，是则添加数据
{
	$data['F_VOTE_TITLE'] = $_POST['title'];
	$data['F_VOTE_START'] = mktime(0,0,0,$_POST['start_m'],$_POST['start_d'],$_POST['start_y']);
	$data['F_VOTE_END'] = mktime(0,0,0,$_POST['end_m'],$_POST['end_d'],$_POST['end_y']);
	$data['F_VOTE_ITEM_TYPE'] = $_POST['type'];
	$data['F_VOTE_IS_DISPLAY'] = $_POST['display'];
	if($vote->insertData($vote->_name,$data))						//判断是否操作成功
		echo "操作成功";
	else
		echo "操作失败";

	echo "<a href='VoteList.php'>返回</a>";
	exit();
}
?>
<html>
<head>
<title>投票管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<script language="javascript" src="../js/date.js"></script>
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form name="form1"  action="" method="post" onsubmit="javascript:return check();">
  <table width="60%" border="0" align="center" cellpadding="0" cellspacing="0" class=i_table>
    <tr class="title">
      <td colspan="2" align="left" bgcolor="#FFFFFF" class="caption">新增投票</td>
    </tr>
    <tr class="l_field">
      <td align="right" bgcolor="#FFFFFF">调查标题：</td>
      <td bgcolor="#FFFFFF"><input name="title" type="text" id="title" size="40" /></td>
    </tr>
    <tr class="l_field">
      <td align="right" bgcolor="#FFFFFF">所属类型：</td>
      <td bgcolor="#FFFFFF"><select name="type" id="type">
<?php
foreach ($vote->_type as $key => $value)							//循环显示类型选择下拉框
{
	echo "<option value=$key>$value</option>";
}
?>  
      </select>      </td>
    </tr>
    <tr class="l_field">
      <td width="24%" align="right" bgcolor="#FFFFFF">开始时间：</td>
      <td width="76%" bgcolor="#FFFFFF">
      <select name="start_y" id="start_y">
<?php
for($i=1;$i<=($year+1);$i++)										//循环显示开始年份下拉框
{
	echo "<option value=$i";
	if($i == $year)													//设置默认选项
		echo " selected='selected'";
	echo ">$i</option>";
}
?>
      </select>
        年
        <select name="start_m" id="start_m" onchange="javascript:register_buildDay(this.value);">
<?php
for($i=1;$i<=12;$i++)												//循环显示开始月份下拉框
{
	if($i < 10)
		$i = '0' . $i;
	echo "<option value=$i";
	if($i == $month)												//设置默认选项
		echo " selected='selected'";
	echo ">$i</option>";
}
?>
        </select>
        月
        <select name="start_d" id="start_d">
<?php
echo "<option value='$day'>$day</option>";
?>
        </select>
      日      </td>
    </tr>
    <tr class="l_field">
      <td align="right" bgcolor="#FFFFFF">结束时间：</td>
      <td bgcolor="#FFFFFF">
<select name="end_y" id="end_y">
<?php
for($i=1;$i<=($year+1);$i++)										//循环显示结束年份下拉框
{
	echo "<option value=$i";
	if($i == $year)													//设置默认选项
		echo " selected='selected'";
	echo ">$i</option>";
}
?>
</select>
年
<select name="end_m" id="end_m" onchange="javascript:register_buildEndDay(this.value);">
<?php
for($i=1;$i<=12;$i++)												//循环显示结束月份下拉框
{
	if($i < 10)
		$i = '0' . $i;
	echo "<option value=$i";
	if($i == $month)												//设置默认选项
		echo " selected='selected'";
	echo ">$i</option>";
}
?>
</select>
月
<select name="end_d" id="end_d">
<?php
echo "<option value='$day'>$day</option>";
?>
</select>
日 </td>
    </tr>
    <tr class="l_field">
      <td align="right" bgcolor="#FFFFFF">是否启用：</td>
      <td bgcolor="#FFFFFF"><input name="display" type="radio" value="1" checked="checked" />
        启用
        <input type="radio" name="display" value="0" />
      禁用</td>
    </tr>
    <tr class="title">
      <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="提交" />
        &nbsp;
      <input type="reset" name="reset" value="重置" /></td>
    </tr>
  </table>
</form>
<script language="javascript">
//功能：检查日期格式是否是有效格式
function checkIsValidDate(str)
{
    if(str == "")													//如果参数为空，则返回false
        return false;
    var arrDate = str.split("-");									//把参数用split函数分割成数组，它等同与PHP中的explode函数
    if(parseInt(arrDate[0],10) < 100)								//如果年份小于100，则表示是21世纪
        arrDate[0] = 2000 + parseInt(arrDate[0],10) + "";
    var date =  new Date(arrDate[0],(parseInt(arrDate[1],10) -1)+"",arrDate[2]);	//格式化为日期格式
    if(date.getYear() == arrDate[0]									//判断格式化后日期的年，月，日是否和参数的相等，相等则是有效格式
       && date.getMonth() == (parseInt(arrDate[1],10) -1)+""
       && date.getDate() == arrDate[2])
        return true;
    else
        return false;
}
//功能：检查开始时间是否小于结束日期
//参数：strStart 开始日期，strEnd 结束日期
function checkDateEarlier(strStart,strEnd)
{
    if(checkIsValidDate(strStart) == false || checkIsValidDate(strEnd) == false)
        return false;												//检查日期格式是否有效
    if (( strStart == "" ) || ( strEnd == "" ))						//检查日期是否为空
        return false;
    var arr1 = strStart.split("-");
    var arr2 = strEnd.split("-");
    var date1 = new Date(arr1[0],parseInt(arr1[1].replace(/^0/,""),10) - 1,arr1[2]);
    var date2 = new Date(arr2[0],parseInt(arr2[1].replace(/^0/,""),10) - 1,arr2[2]);
    if(arr1[1].length == 1)											//将月份格式化为08这种形式
        arr1[1] = "0" + arr1[1];
    if(arr1[2].length == 1)											//将日格式化为08这种形式
        arr1[2] = "0" + arr1[2];
    if(arr2[1].length == 1)											//将月份格式化为08这种形式
        arr2[1] = "0" + arr2[1];
    if(arr2[2].length == 1)											//将日格式化为08这种形式
        arr2[2]="0" + arr2[2];
    var d1 = arr1[0] + arr1[1] + arr1[2];							//将开始日期组合成一个字符串
    var d2 = arr2[0] + arr2[1] + arr2[2];							//将结束日期组合成一个字符串
    if(parseInt(d1,10) > parseInt(d2,10))							//将两个字符串转化成整数,如果d1>d2则开始日期大于结束日期
       return false;
    else
       return true;
}
//定义一个javascript的原形
String.prototype.len = function(){									//计算字符串的长度（一个双字节字符长度计2，ASCII字符计1）
	return this.replace(/[^\x00-\xff]/g,"aa").length;
}
function check()
{
	var Start = document.form1.start_y.value + "-" + document.form1.start_m.value + "-" + document.form1.start_d.value;
	var End = document.form1.end_y.value + "-" + document.form1.end_m.value + "-" + document.form1.end_d.value;
	
	if(document.form1.title.value == '')			//判断标题是否为空,为空则返回false
	{
		alert('请填写调查名称');
		document.form1.title.focus();
		return false;
	}
	if(document.form1.title.value.len() > 100)		//判断标题长度是否超过100
	{
		alert('调查标题不能超过100个字')
		document.form1.title.focus();
		return false;
	}
	if(!checkDateEarlier(Start,End))				//判断开始日期是否大于结束日期
	{
		alert('开始日期不能小于结束日期');
		return false;
	}
}
</script>
</body>
</html>
