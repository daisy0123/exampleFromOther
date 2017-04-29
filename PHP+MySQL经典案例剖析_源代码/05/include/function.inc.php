<?php
/**
 * ���ܣ�����Url��ַ����Page����ȥ����ϳ�һ����ַ
 * ���أ���ҳ��ַ
 */
function ParseUrl()
{
	$url = $_SERVER['REQUEST_URI'];						//��ȡ��ǰ��ַ
	if(strpos($url, '?'))										//�ж��Ƿ���Я������
	{
		$file = substr($url, 0,strpos($url, '?'));						//ȡ���ļ���ַ
		$para = substr($url,strpos($url,'?')+1,strlen($url));			//ȡ�ò����ַ���
		$array = explode('&',$para);							//�ֽ����
		for($i=0;$i<sizeof($array);$i++)							//ѭ����ϲ���
		{
			$tmp = array();
			$tmp = explode("=",$array[$i]);						//�ֽ��������ֵ
			if($tmp[0] != 'Page')								//�жϲ����Ƿ�ΪPage
			{											//��������ϲ���
				if($i != 0)									//�ж��Ƿ�Ϊ��һ������,������ӡ�&��
					$link .= "&";
				$link .= $array[$i];
			}
		}
		$link = $file . "?" . $link . "&";							//��ϳɷ�ҳ���ӵ�ַ
	}else{
		$link = $url . "?";
	}
	return $link;
}
/**
 * ���ܣ������ҳ�ַ���
 * ������$pagecount ��ҳ��,$curr_page ��ǰҳ��,$pagesize ÿҳ������
 * ���أ���ҳ�ַ���
 */
function Page($pagecount,$curr_page,$pagesize)
{
	$url = ParseUrl();
	$prev = $page - 1;
	$next = $page + 1;
	$start = "<a href='" . $url . "Page=1'>��ҳ</a>";
	$prev_link = ($prev_link >= 1) ? "<a href='" . $url . "Page=$prev'>��һҳ</a>" : "��һҳ";
	$next_link = ($next <= $pagecount) ? "<a href='" . $url . "Page=$next'>��һҳ</a>" : "��һҳ";
	$end = "<a href='" . $url ."Page=$pagecount'>βҳ</a>";
	$str = "��ǰ��" . $curr_page . "ҳ ��" . $pagecount . "ҳ ÿҳ" . $pagesize;
	$str .= " " . $start . " " . $prev_link . " " . $next_link . " " . $end;
	return $str; 
}
/**
 * ���ܣ����㵱ǰ���µ�����
 * ������$year ��,$month ��
 * ���أ�����
 */
function ud_date_get_month_days($year,$month){
	$big_month = "0,01,03,05,07,08,010,012";						//�������
	$small_month = "0,04,06,09,011";								//����С��

	if (substr($month,0,1))										//ȡ�µĵ�һλ
		$month = "0" . $month;

	if (strpos($big_month,$month))									//�жϸ����Ƿ��Ǵ���,����31��
		$days = 31;
	else{
		if (strpos($small_month,$month))							//�ж��Ƿ���С��,����30��
			$days = 30;
		else{
			$leap_year = checkdate(2,29,$year);						//�ж��Ƿ�������
			$days = $leap_year ? 29 : 28;							//����29�첻����28��
		}
	}
	return $days;
}
/**
 * ���ܣ��������ָ��ʱ��֮ǰ��֮����ٸ���λʱ���ʱ��
 * ������$timestamp ������ʱ���,$step ����,$type ʱ�䵥λ,�����ǡ�year��,��month��,��day��
 */
function ud_date_date_add($timestamp,$step,$type = "day"){
	$date_time_array = getdate($timestamp);							//ȡ��ʱ��/������Ϣ
	$hours = $date_time_array["hours"];
	$minutes = $date_time_array["minutes"];
	$seconds = $date_time_array["seconds"];
	$month = $date_time_array["mon"];
	$day = $date_time_array["mday"];
	$year = $date_time_array["year"];
	switch ($type) {												//�ж�ʱ�䵥λ
	case "year": $year +=$step; break;
	case "month": $month +=$step; break;
	case "day":$day+=$step; break;
	} 
	$timestamp = mktime($hours ,$minutes, $seconds,$month ,$day, $year);
	return $timestamp;
}
/**
 * ���ܣ��ݹ鴴���ļ���
 * ������$param �ļ�·��
 */
function mkdirsByPath($param){
	if(! file_exists($param)) {											//�жϸ��ļ��Ƿ����
		mkdirsByPath(dirname($param));								//�ݹ鴴��
		@mkdir($param);
	}
	return realpath($param);
}
/**
 * ���ܣ������ϴ��ļ�
 * ������$file_info �ϴ��ļ���Ϣ,$path �ϴ��ļ���,$max_file_size �ϴ��ļ��������
 * ���أ�����
 */
function upload($file_info,$path,$max_file_size){
	extract($file_info);

	if ($size == 0){									//�ж��ϴ��ļ���С�Ƿ�Ϊ0
		$result[errcode] = "zero";
		return $result;
	}
	
	$a = pathinfo($name);
	$ext = strtolower($a['extension']);
	$result = array();
	if (substr($type,0,5) != 'image'){						//�ж��ϴ��ļ��Ƿ���ͼƬ
		$result[errcode] = "type_erro";
		return $result;
	}
	$size = $size / 1024;
	if ($size > $max_file_size){						//�ж��ϴ��ļ���С�Ƿ񳬹�����
		$result[errcode] = "size_erro";
		return $result;
	}
	$f_name = date("YmdHis") . "." . $ext;
	$sub_path = date("Ymd") . "/";
	$path = $path . $sub_path;
	$target = $path . $f_name;
	$i = 1;
	while(file_exists($target)){							//ѭ���ж��ļ��Ƿ��Ѵ���
		$f_name = date("YmdHis") . ($i++) . "." . $ext;
		$target = $path . $f_name;
	}
	if(!file_exists($target))							//�������򴴽�·��
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
