<?php
/**
 * 功能：解析Url地址，把Page参数去掉组合成一个地址
 * 返回：翻页地址
 */
function ParseUrl()
{
	$url = $_SERVER['REQUEST_URI'];						//提取当前地址
	if(strpos($url, '?'))										//判断是否有携带参数
	{
		$file = substr($url, 0,strpos($url, '?'));						//取得文件地址
		$para = substr($url,strpos($url,'?')+1,strlen($url));			//取得参数字符串
		$array = explode('&',$para);							//分解参数
		for($i=0;$i<sizeof($array);$i++)							//循环组合参数
		{
			$tmp = array();
			$tmp = explode("=",$array[$i]);						//分解参数名和值
			if($tmp[0] != 'Page')								//判断参数是否为Page
			{											//不是则组合参数
				if($i != 0)									//判断是否为第一个参数,不是则加’&’
					$link .= "&";
				$link .= $array[$i];
			}
		}
		$link = $file . "?" . $link . "&";							//组合成翻页连接地址
	}else{
		$link = $url . "?";
	}
	return $link;
}
/**
 * 功能：输出翻页字符串
 * 参数：$pagecount 总页数,$curr_page 当前页码,$pagesize 每页文章数
 * 返回：翻页字符串
 */
function Page($pagecount,$curr_page,$pagesize)
{
	$url = ParseUrl();
	$prev = $page - 1;
	$next = $page + 1;
	$start = "<a href='" . $url . "Page=1'>首页</a>";
	$prev_link = ($prev_link >= 1) ? "<a href='" . $url . "Page=$prev'>上一页</a>" : "上一页";
	$next_link = ($next <= $pagecount) ? "<a href='" . $url . "Page=$next'>下一页</a>" : "下一页";
	$end = "<a href='" . $url ."Page=$pagecount'>尾页</a>";
	$str = "当前第" . $curr_page . "页 共" . $pagecount . "页 每页" . $pagesize;
	$str .= " " . $start . " " . $prev_link . " " . $next_link . " " . $end;
	return $str; 
}
/**
 * 功能：计算当前年月的天数
 * 参数：$year 年,$month 月
 * 返回：天数
 */
function ud_date_get_month_days($year,$month){
	$big_month = "0,01,03,05,07,08,010,012";						//定义大月
	$small_month = "0,04,06,09,011";								//定义小月

	if (substr($month,0,1))										//取月的第一位
		$month = "0" . $month;

	if (strpos($big_month,$month))									//判断该月是否是大月,是则31天
		$days = 31;
	else{
		if (strpos($small_month,$month))							//判断是否是小月,是则30天
			$days = 30;
		else{
			$leap_year = checkdate(2,29,$year);						//判断是否是闰年
			$days = $leap_year ? 29 : 28;							//是则29天不是则28天
		}
	}
	return $days;
}
/**
 * 功能：计算给出指定时间之前或之后多少个单位时间的时间
 * 参数：$timestamp 给定的时间戳,$step 增量,$type 时间单位,可以是’year’,’month’,’day’
 */
function ud_date_date_add($timestamp,$step,$type = "day"){
	$date_time_array = getdate($timestamp);							//取得时间/日期信息
	$hours = $date_time_array["hours"];
	$minutes = $date_time_array["minutes"];
	$seconds = $date_time_array["seconds"];
	$month = $date_time_array["mon"];
	$day = $date_time_array["mday"];
	$year = $date_time_array["year"];
	switch ($type) {												//判断时间单位
	case "year": $year +=$step; break;
	case "month": $month +=$step; break;
	case "day":$day+=$step; break;
	} 
	$timestamp = mktime($hours ,$minutes, $seconds,$month ,$day, $year);
	return $timestamp;
}
/**
 * 功能：递归创建文件夹
 * 参数：$param 文件路径
 */
function mkdirsByPath($param){
	if(! file_exists($param)) {											//判断该文件是否存在
		mkdirsByPath(dirname($param));								//递归创建
		@mkdir($param);
	}
	return realpath($param);
}
/**
 * 功能：处理上传文件
 * 参数：$file_info 上传文件信息,$path 上传文件夹,$max_file_size 上传文件最大限制
 * 返回：数组
 */
function upload($file_info,$path,$max_file_size){
	extract($file_info);

	if ($size == 0){									//判断上传文件大小是否为0
		$result[errcode] = "zero";
		return $result;
	}
	
	$a = pathinfo($name);
	$ext = strtolower($a['extension']);
	$result = array();
	if (substr($type,0,5) != 'image'){						//判断上传文件是否是图片
		$result[errcode] = "type_erro";
		return $result;
	}
	$size = $size / 1024;
	if ($size > $max_file_size){						//判断上传文件大小是否超过限制
		$result[errcode] = "size_erro";
		return $result;
	}
	$f_name = date("YmdHis") . "." . $ext;
	$sub_path = date("Ymd") . "/";
	$path = $path . $sub_path;
	$target = $path . $f_name;
	$i = 1;
	while(file_exists($target)){							//循环判断文件是否已存在
		$f_name = date("YmdHis") . ($i++) . "." . $ext;
		$target = $path . $f_name;
	}
	if(!file_exists($target))							//不存在则创建路径
		mkdirsByPath(dirname($target));
	$result['errcode'] = move_uploaded_file($tmp_name,$target);
	list($width,$height) = getimagesize("$path$f_name");
	$result['file_name'] = $sub_path . $f_name;
	$result['width'] = $width;
	$result['height'] = $height;
	$result['size'] = $size;
	$result['type'] = $type;
	return $result;
}
?>
