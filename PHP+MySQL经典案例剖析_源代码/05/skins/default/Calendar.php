<?php
if($_GET['Year'] && $_GET['Month'])									//判断是否有年和月的参数
{
	$year = $_GET['Year'];
	$month = $_GET['Month'];
	$day = "1";
	$timestamp = mktime(0,0,0,$month,$day,$year);
}else{														//没有则默认为当前年和月
	$year = date("Y");
	$month = date("m");
	$day = date("j");
	$timestamp = time();
}
$days = ud_date_get_month_days($year,$month);						//取得当前年月的天数
$first_of_month = mktime(0,0,0,$month,1,$year);						//取得当前年月的第一天的时间戳
$prev_date = ud_date_date_add($timestamp,-1,"month");					//计算前一月的时间戳
list($prev_year,$prev_month) = explode("-",date("Y-m",$prev_date));		//取得前一月的年和月
$next_date = ud_date_date_add($timestamp,1,"month");					//计算后一月的时间戳
list($next_year,$next_month) = explode("-",date("Y-m",$next_date));			//取得后一月的年和月
$first_week = date("w",$first_of_month);								//取得该月第一天是星期几
$v_days = $days + $first_week;
$week_num = (int)($v_days / 7);									//计算该月共有几个星期
if ($v_days % 7)												//如果余数大于0则星期数加1
	$week_num++;
$weeks = array();
$day_index = 1;
for ($i = 0;$i < $week_num;$i++){									//把该月的每一天循环付值给数组
	for ($j = 0;$j < 7;$j++){										//数组的列为星期数
		if (($i == 0) && ($j < $first_week) || ($day_index > $days))			//判断该天是否存在
			$weeks[$i][$j] = "&nbsp;";
		else{
			$weeks[$i][$j] = $day_index++;
		}
	}
}
echo "<div id=\"Prev\"><a href='/index.php?BlogId=$blogid&Year=$prev_year&Month=$prev_month'> << </a></div>";
echo "<div id=\"Next\"><a href='/index.php?BlogId=$blogid&Year=$next_year&Month=$next_month'> >> </a></div>";
echo "<table border=1 width=\"100%\" align=\"center\" bgColor=#ffffdf bordercolordark=\"white\" bordercolorlight=\"black\" cellspacing=\"0\">";
echo "<tr><th height=\"22\">日</th><th height=\"22\">一</th><th height=\"22\">二</th><th height=\"22\">三</th><th height=\"22\">四</th><th height=\"22\">五</th><th height=\"22\">六</th></tr>";
for ($i = 0;$i < $week_num;$i++){									//循环显示天数
	echo "<tr>";
	for ($j = 0;$j < 7;$j++){
		$disp_day = $weeks[$i][$j];
		$disp_date = date("Y-m-d",@mktime(0,0,0,$month,"$disp_day",$year));
		$td_str = "<td height=\"22\" ";
		if ($disp_day == $day){									//如果是当天则改变其显示的颜色
			$td_str .= "bgcolor=\"blue\"";
			$day_color = "white";
		}else{
			$day_color = "#fe0000";			
		}
		$r = $blog->GetPostList($blogid,0,'',$disp_date,$status,1);
		if($r)													//判断该天是否有文章,有显示连接
			$disp_day = "<a href='/index.php?BlogId=$blogid&Date=$disp_date'><font color='red'>" . $weeks[$i][$j] . "</font></a>";
		$td_str .= "><div align=\"center\">";
		$td_str .= "<font color=\"$day_color\">" . $disp_day . "</font></div></td>";
		echo $td_str . "\n";
	}
	echo "</tr>";
}
echo "</table>";
?>
