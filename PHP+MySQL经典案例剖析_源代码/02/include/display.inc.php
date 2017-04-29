<?php
require_once(INCLUDE_PATH . 'db.inc.php');
class Display extends DBSQL
{
	/**
	 * ��ʼ�����캯��
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}
	//���ܺ���
		/**
	 * ���ܣ���ȡ��ҳ��ʾ��Ϣ
	 *
	*/
	public function GetIndex()
	{
		$data = array();
		$sql = "SELECT count(F_ID) FROM EM_USER_INFO";
		$r = $this->select($sql);
		$data['COUNT'] = ($r[0][0]) ? $r[0][0] : 0;										//�ܷ�����
		$sql = "SELECT count(distinct(F_USER_IP)) FROM EM_USER_INFO GROUP BY F_USER_IP";
		$r = $this->select($sql);
		$data['IPCOUNT'] = ($r[0][0]) ? $r[0][0] : 0;									//��Ψһ�ÿ���
		$sql = "SELECT sum(F_DAY_COUNT) AS daycount,sum(F_DAY_IP_COUNT) AS dayip,count(F_ID)";
		$sql .= " AS days,max(F_DAY_COUNT) AS maxday,max(F_DAY_IP_COUNT) AS maxip FROM EM_DAY_DATA";
		$r = $this->select($sql);
		$data['DAYCOUNT'] = @number_format($r[0]['daycount']/$r[0]['days'],0);		//ƽ���շ�����
		$data['DAYIP'] = @number_format($r[0]['dayip']/$r[0]['days'],0);				//ƽ����Ψһ�ÿ���
		$data['MAXDAY'] = ($r[0]['maxday']) ? $r[0]['maxday'] : 0;								//����շ�����
		$data['MAXDAYIP'] = ($r[0]['maxip']) ? $r[0]['maxip'] : 0;								//�����Ψһ�ÿ���
		$sql = "SELECT max(F_MONTH_COUNT) AS maxmonth,max(F_MONTH_IP_COUNT) AS maxip FROM EM_MONTH_DATA";
		$r = $this->select($sql);
		$data['MAXMONTH'] = ($r[0]['maxmonth']) ? $r[0]['maxmonth'] : 0;							//����·�����
		$data['MAXMONTHIP'] = ($r[0]['maxip']) ? $r[0]['maxip'] : 0;								//�����Ψһ�ÿ���
		return $data;
	}
	/**
	 * ���ܣ���ȡ����24Сʱ����ͳ����Ϣ
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
	 * ���ܣ���ȡСʱͳ����Ϣ
	 *
	 * ������$date ��ѯ����
	 * ���أ�����
	 */
	public function GetHour($date='')
	{
		$str = "";
		for($i = 0;$i <= 23;$i++)									//�����շ�������ѯ�ֶ�
		{
			$str .= 'sum(F_DAY_HOUR' . $i . ') as F_DAY_HOUR' . $i;
			if($i < 23)											//�ж��Ƿ�23��������ӡ�,��
			{
				$str .= ",";
			}
		}
		
		$ip_str = "";
		for($i = 0;$i <= 23;$i++)								//������Ψһ�ÿͲ�ѯ�ֶ�
		{
			$ip_str .= 'sum(F_DAY_HOUR' . $i . '_IP) as F_DAY_HOUR' . $i . '_IP';
			if($i < 23)										//�ж��Ƿ�23��������ӡ�,��
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
	 * ���ܣ���ȡ��ͳ����Ϣ
	 * ������$year ��,$month ��,$day ��
	 */
	public function GetDay($year = '',$month = '',$day)
	{
		$sql = "SELECT sum(F_DAY_COUNT) as F_DAY_COUNT,sum(F_DAY_IP_COUNT) as F_DAY_IP_COUNT";
		$sql .= " FROM EM_DAY_DATA WHERE F_DAY_DAY = '$day' GROUP BY F_DAY_DAY";
		if($year)								//�ж��Ƿ����ύ������������ȡ��������
		{
			$sql = "SELECT F_DAY_COUNT,F_DAY_IP_COUNT FROM EM_DAY_DATA WHERE F_DAY_YEAR = '$year'";
			$sql .= " AND F_DAY_MONTH = '$month' AND F_DAY_DAY = '$day'";
		}
		$r = $this->select($sql);
		return $r[0];
	}
	/**
	 * ���ܣ���ȡ��ͳ����Ϣ
	 *
	 * ������$year ��,$month ��
	 * ��������
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
	 * ���ܣ���ȡ��ͳ����Ϣ
	 * ������$year ��
	 * ���أ�����
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
	 * ���ܣ�������ȡ�ͻ���ͳ����Ϣ
	 * ������$action ��ȡͳ����Ϣ������
	 * ���أ�����
	 */
	public function GetAgent($action)
	{
		switch ($action)
		{
			case 'Area':								//���ݲ���Ϊ��Area��,��ȡ��Դ������Ϣ
				$field = 'F_CLIENT_AREA';
				break;
			case 'Browser':								//���ݲ���Ϊ��Browser��,��ȡ�������Ϣ
				$field = 'F_CLIENT_BROWSER';
				break;
			case 'System':								//���ݲ���Ϊ��System��,��ȡ����ϵͳ��Ϣ
				$field = 'F_CLIENT_SYSTEM';
				break;
			case 'Screen':								//���ݲ���Ϊ��Screen��,��ȡ�ֱ�����Ϣ
				$field = 'F_CLIENT_SCREEN';
				break;
			case 'Language':							//���ݲ���Ϊ��Language��,��ȡ�ͻ�����Ϣ
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
	 * ���ܣ�������ȡ��������ͳ����Ϣ
	 * ������$action ��ȡͳ����Ϣ������
	 * ���أ�����
	 */
	public function GetSearch($action)
	{
		switch ($action)
		{
			case 'Search':								//���ݲ���Ϊ��Search��,��ȡ����������·��Ϣ
				$field = 'F_SEARCH_URL';
				break;
			case 'Keyword':								//���ݲ���Ϊ��Keyword��,��ȡ�����ؼ�����Ϣ
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
			case 'Refer':										//���ݲ���Ϊ��Refer��,��ʾ��վ��·��Ϣ
				$field = 'F_REFER_URL';
				break;
			case 'Page':										//���ݲ���Ϊ��Page��,��ʾ�ܷ�ҳ����Ϣ
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
