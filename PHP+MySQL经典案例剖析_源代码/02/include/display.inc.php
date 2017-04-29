<?php
require_once(INCLUDE_PATH . 'db.inc.php');
class Display extends DBSQL
{
	/**
	 * 初始化构造函数
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}
	//功能函数
		/**
	 * 功能：提取首页显示信息
	 *
	*/
	public function GetIndex()
	{
		$data = array();
		$sql = "SELECT count(F_ID) FROM EM_USER_INFO";
		$r = $this->select($sql);
		$data['COUNT'] = ($r[0][0]) ? $r[0][0] : 0;										//总访问量
		$sql = "SELECT count(distinct(F_USER_IP)) FROM EM_USER_INFO GROUP BY F_USER_IP";
		$r = $this->select($sql);
		$data['IPCOUNT'] = ($r[0][0]) ? $r[0][0] : 0;									//总唯一访客两
		$sql = "SELECT sum(F_DAY_COUNT) AS daycount,sum(F_DAY_IP_COUNT) AS dayip,count(F_ID)";
		$sql .= " AS days,max(F_DAY_COUNT) AS maxday,max(F_DAY_IP_COUNT) AS maxip FROM EM_DAY_DATA";
		$r = $this->select($sql);
		$data['DAYCOUNT'] = @number_format($r[0]['daycount']/$r[0]['days'],0);		//平均日访问量
		$data['DAYIP'] = @number_format($r[0]['dayip']/$r[0]['days'],0);				//平均日唯一访客量
		$data['MAXDAY'] = ($r[0]['maxday']) ? $r[0]['maxday'] : 0;								//最大日访问量
		$data['MAXDAYIP'] = ($r[0]['maxip']) ? $r[0]['maxip'] : 0;								//最大日唯一访客量
		$sql = "SELECT max(F_MONTH_COUNT) AS maxmonth,max(F_MONTH_IP_COUNT) AS maxip FROM EM_MONTH_DATA";
		$r = $this->select($sql);
		$data['MAXMONTH'] = ($r[0]['maxmonth']) ? $r[0]['maxmonth'] : 0;							//最大月访问量
		$data['MAXMONTHIP'] = ($r[0]['maxip']) ? $r[0]['maxip'] : 0;								//最大月唯一访客量
		return $data;
	}
	/**
	 * 功能：提取当天24小时整点统计信息
	 *
	*/
	public function GetToday()
	{
		$year = date("Y");
		$month = date("n");
		$day = date("j");
		$sql = "SELECT * FROM EM_DAY_DATA WHERE F_DAY_YEAR = '$year'";
		$sql .= " AND F_DAY_MONTH = '$month' AND F_DAY_DAY = '$day'";
		$r = $this->select($sql);
		return $r[0];
	}
	/**
	 * 功能：提取小时统计信息
	 *
	 * 参数：$date 查询日期
	 * 返回：数组
	 */
	public function GetHour($date='')
	{
		$str = "";
		for($i = 0;$i <= 23;$i++)									//构造日访问量查询字段
		{
			$str .= 'sum(F_DAY_HOUR' . $i . ') as F_DAY_HOUR' . $i;
			if($i < 23)											//判断是否到23，不是则加’,’
			{
				$str .= ",";
			}
		}
		
		$ip_str = "";
		for($i = 0;$i <= 23;$i++)								//构造日唯一访客查询字段
		{
			$ip_str .= 'sum(F_DAY_HOUR' . $i . '_IP) as F_DAY_HOUR' . $i . '_IP';
			if($i < 23)										//判断是否到23，不是则加’,’
			{
				$ip_str .= ",";
			}
		}		
		$sql = "SELECT $str,$ip_str FROM EM_DAY_DATA";
		if($date)
		{
			$sql = "SELECT * FROM EM_DAY_DATA WHERE F_DAY_TIME = $date";
		}
		return $this->select($sql);
	}
	/**
	 * 功能：提取日统计信息
	 * 参数：$year 年,$month 月,$day 日
	 */
	public function GetDay($year = '',$month = '',$day)
	{
		$sql = "SELECT sum(F_DAY_COUNT) as F_DAY_COUNT,sum(F_DAY_IP_COUNT) as F_DAY_IP_COUNT";
		$sql .= " FROM EM_DAY_DATA WHERE F_DAY_DAY = '$day' GROUP BY F_DAY_DAY";
		if($year)								//判断是否有提交搜索，有则提取搜索数据
		{
			$sql = "SELECT F_DAY_COUNT,F_DAY_IP_COUNT FROM EM_DAY_DATA WHERE F_DAY_YEAR = '$year'";
			$sql .= " AND F_DAY_MONTH = '$month' AND F_DAY_DAY = '$day'";
		}
		$r = $this->select($sql);
		return $r[0];
	}
	/**
	 * 功能：提取月统计信息
	 *
	 * 参数：$year 年,$month 月
	 * 返回数组
	 */
	public function GetMonth($year='',$month)
	{
		$sql = "SELECT sum(F_MONTH_COUNT) as F_MONTH_COUNT,sum(F_MONTH_IP_COUNT)";
		$sql .= " as F_MONTH_IP_COUNT FROM EM_MONTH_DATA WHERE F_MONTH_MONTH = '$month' GROUP BY F_MONTH_MONTH";
		if($year)
		{
			$sql = "SELECT F_MONTH_COUNT,F_MONTH_IP_COUNT,F_MONTH_MONTH FROM ";
			$sql .= "EM_MONTH_DATA WHERE F_MONTH_YEAR = '$year' AND F_MONTH_MONTH = '$month'";
		}
		$r = $this->select($sql);
		return $r[0];
	}
	/**
	 * 功能：提取年统计信息
	 * 参数：$year 年
	 * 返回：数组
	 */
	public function GetYear($year = '')
	{
		$sql = "SELECT sum(F_MONTH_COUNT) as F_YEAR_COUNT,sum(F_MONTH_IP_COUNT) as ";
		$sql .= "F_YEAR_IP_COUNT,F_MONTH_YEAR FROM EM_MONTH_DATA GROUP BY F_MONTH_YEAR";
		if($year)
		{
			$sql = "SELECT sum(F_MONTH_COUNT) as F_YEAR_COUNT,sum(F_MONTH_IP_COUNT) as ";
			$sql .= "F_YEAR_IP_COUNT,F_MONTH_YEAR FROM EM_MONTH_DATA WHERE F_MONTH_YEAR = '$year'GROUP BY F_MONTH_YEAR";
		}
		$r = $this->select($sql);
		return $r;
	}
	/**
	 * 功能：分组提取客户端统计信息
	 * 参数：$action 提取统计信息的类型
	 * 返回：数组
	 */
	public function GetAgent($action)
	{
		switch ($action)
		{
			case 'Area':								//传递参数为’Area’,提取来源地域信息
				$field = 'F_CLIENT_AREA';
				break;
			case 'Browser':								//传递参数为’Browser’,提取浏览器信息
				$field = 'F_CLIENT_BROWSER';
				break;
			case 'System':								//传递参数为’System’,提取操作系统信息
				$field = 'F_CLIENT_SYSTEM';
				break;
			case 'Screen':								//传递参数为’Screen’,提取分辨率信息
				$field = 'F_CLIENT_SCREEN';
				break;
			case 'Language':							//传递参数为’Language’,提取客户端信息
				$field = 'F_CLIENT_LANGUAGE';
				break;
			default:
				break;
		}
		$data = array();
		$sql = "SELECT count(F_CLIENT_IP) as COUNT,$field FROM EM_CLIENT_INFO GROUP BY $field";
		$r = $this->select($sql);
		foreach ((array)$r as $key => $value)
		{
			$sql = "SELECT count(F_CLIENT_IP) as IPCOUNT FROM EM_CLIENT_INFO WHERE $field = '{$value[$field]}' GROUP BY F_CLIENT_IP";
			$s = $this->select($sql);
			$data[$key]['COUNT'] = $value['COUNT'];
			$data[$key][$field] = $value[$field];
			$data[$key]['IPCOUNT'] = $s[0]['IPCOUNT'];
		}
		return $data;
	}
	/**
	 * 功能：分组提取搜索引擎统计信息
	 * 参数：$action 提取统计信息的类型
	 * 返回：数组
	 */
	public function GetSearch($action)
	{
		switch ($action)
		{
			case 'Search':								//传递参数为’Search’,提取搜索引擎来路信息
				$field = 'F_SEARCH_URL';
				break;
			case 'Keyword':								//传递参数为’Keyword’,提取搜索关键字信息
				$field = 'F_SEARCH_KEYWORD';
				break;
			default:
				break;
		}
		$data = array();
		$sql = "SELECT count(F_SEARCH_IP) as COUNT,$field FROM EM_SEARCH_INFO GROUP BY $field";
		$r = $this->select($sql);
		foreach ($r as $key => $value)
		{
			$sql = "SELECT count(F_SEARCH_IP) as IPCOUNT FROM EM_SEARCH_INFO WHERE $field = '{$value[$field]}' GROUP BY F_SEARCH_IP";
			$s = $this->select($sql);
			$data[$key]['COUNT'] = $value['COUNT'];
			$data[$key][$field] = $value[$field];
			$data[$key]['IPCOUNT'] = $s[0]['IPCOUNT'];
		}
		return $data;
	}
	public function GetPage($action) {
		switch ($action)
		{
			case 'Refer':										//传递参数为’Refer’,显示网站来路信息
				$field = 'F_REFER_URL';
				break;
			case 'Page':										//传递参数为’Page’,显示受访页面信息
				$field = 'F_REFER_PAGE';
				break;
			default:
				break;
		}
		$data = array();
		$sql = "SELECT count(F_REFER_IP) as COUNT,$field FROM em_refer_info GROUP BY $field";
		$r = $this->select($sql);
		foreach ($r as $key => $value)
		{
			$sql = "SELECT count(F_REFER_IP) as IPCOUNT FROM EM_REFER_INFO WHERE $field = '{$value[$field]}' GROUP BY F_REFER_IP";
			$s = $this->select($sql);
			$data[$key]['COUNT'] = $value['COUNT'];
			$data[$key][$field] = $value[$field];
			$data[$key]['IPCOUNT'] = $s[0]['IPCOUNT'];
		}
		return $data;
	}
}
?>
