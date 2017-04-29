<?php
if($_GET['Year'] && $_GET['Month'])									//�ж��Ƿ�������µĲ���
{
	$year = $_GET['Year'];
	$month = $_GET['Month'];
	$day = "1";
	$timestamp = mktime(0,0,0,$month,$day,$year);
}else{														//û����Ĭ��Ϊ��ǰ�����
	$year = date("Y");
	$month = date("m");
	$day = date("j");
	$timestamp = time();
}
$days = ud_date_get_month_days($year,$month);						//ȡ�õ�ǰ���µ�����
$first_of_month = mktime(0,0,0,$month,1,$year);						//ȡ�õ�ǰ���µĵ�һ���ʱ���
$prev_date = ud_date_date_add($timestamp,-1,"month");					//����ǰһ�µ�ʱ���
list($prev_year,$prev_month) = explode("-",date("Y-m",$prev_date));		//ȡ��ǰһ�µ������
$next_date = ud_date_date_add($timestamp,1,"month");					//�����һ�µ�ʱ���
list($next_year,$next_month) = explode("-",date("Y-m",$next_date));			//ȡ�ú�һ�µ������
$first_week = date("w",$first_of_month);								//ȡ�ø��µ�һ�������ڼ�
$v_days = $days + $first_week;
$week_num = (int)($v_days / 7);									//������¹��м�������
if ($v_days % 7)												//�����������0����������1
	$week_num++;
$weeks = array();
$day_index = 1;
for ($i = 0;$i < $week_num;$i++){									//�Ѹ��µ�ÿһ��ѭ����ֵ������
	for ($j = 0;$j < 7;$j++){										//�������Ϊ������
		if (($i == 0) && ($j < $first_week) || ($day_index > $days))			//�жϸ����Ƿ����
			$weeks[$i][$j] = "&nbsp;";
		else{
			$weeks[$i][$j] = $day_index++;
		}
	}
}
echo "<div id=\"Prev\"><a href='/index.php?BlogId=$blogid&Year=$prev_year&Month=$prev_month'> << </a></div>";
echo "<div id=\"Next\"><a href='/index.php?BlogId=$blogid&Year=$next_year&Month=$next_month'> >> </a></div>";
echo "<table border=1 width=\"100%\" align=\"center\" bgColor=#ffffdf bordercolordark=\"white\" bordercolorlight=\"black\" cellspacing=\"0\">";
echo "<tr><th height=\"22\">��</th><th height=\"22\">һ</th><th height=\"22\">��</th><th height=\"22\">��</th><th height=\"22\">��</th><th height=\"22\">��</th><th height=\"22\">��</th></tr>";
for ($i = 0;$i < $week_num;$i++){									//ѭ����ʾ����
	echo "<tr>";
	for ($j = 0;$j < 7;$j++){
		$disp_day = $weeks[$i][$j];
		$disp_date = date("Y-m-d",@mktime(0,0,0,$month,"$disp_day",$year));
		$td_str = "<td height=\"22\" ";
		if ($disp_day == $day){									//����ǵ�����ı�����ʾ����ɫ
			$td_str .= "bgcolor=\"blue\"";
			$day_color = "white";
		}else{
			$day_color = "#fe0000";			
		}
		$r = $blog->GetPostList($blogid,0,'',$disp_date,$status,1);
		if($r)													//�жϸ����Ƿ�������,����ʾ����
			$disp_day = "<a href='/index.php?BlogId=$blogid&Date=$disp_date'><font color='red'>" . $weeks[$i][$j] . "</font></a>";
		$td_str .= "><div align=\"center\">";
		$td_str .= "<font color=\"$day_color\">" . $disp_day . "</font></div></td>";
		echo $td_str . "\n";
	}
	echo "</tr>";
}
echo "</table>";
?>
