<?php
require_once(INCLUDE_PATH . 'db.inc.php');
require_once(INCLUDE_PATH . 'ip.inc.php');
class Stat extends DBSQL{
	protected $Time;											//���嵱ǰʱ�����
	protected $Year;											//���嵱ǰ�����
	protected $Month;											//���嵱ǰ�±���
	protected $Day;											//���嵱ǰ�ձ���
	protected $Hour;											//���嵱ǰʱ����
	protected $ViewInfo = array();									//����ͳ����Ϣ����
	protected $DayStart;											//���嵱�쿪ʼʱ��
	protected $MonthStart;										//���嵱�¿�ʼʱ��
	protected $ipclass;
	public function __construct()
	{
		parent::__construct();
		$this->ipclass = new IpModel();
		$this->DayStart = mktime(0,0,0,date('m'),date('d'),date('Y'));
		$this->DayEnd = mktime(23,59,59,date('m'),date('d'),date('Y'));
		$this->MonthStart = mktime(0,0,0,date('m'),date('d'),date('Y'));
		$this->Year = date("Y");
		$this->Month = date("n");
		$this->Day = date("j");
		$this->Time = time();
		$this->GetViewerInfo();
		$this->begintransaction();
		try{
			$this->InitSearch();
			$this->InitRefer();
			$this->InitClient();
			$this->InitDay();
			$this->InitMonth();
			$this->InitUser();
		}catch (Exception $e)
		{
			$this->rollback();
		}
		$this->commit();
	}
	/**
	 * ���ܣ���ȡͳ����Ϣ
	 *
	 */
	private function GetViewerInfo()
	{
		$this->ViewInfo['Time'] = $this->Time;
		$this->ViewInfo['Language'] = $_GET['language'];
		$this->ViewInfo['Page'] = $_GET['pageurl'];
		$this->ViewInfo['Screen'] = $_GET[screensize];
		$this->ViewInfo['Agent'] = $_SERVER["HTTP_USER_AGENT"];
		$this->ViewInfo['Referer'] = $_GET['referer'];
		$ip = $_SERVER["REMOTE_ADDR"];
		$ip1 = $_SERVER["HTTP_X_FORWARDED_FOR"];
		$ip2 = $_SERVER["HTTP_CLIENT_IP"];
		($ip1) ? $ip = $ip1 : null ;
		($ip2) ? $ip = $ip2 : null ;
		$this->ViewInfo['Ip'] = ip2long($ip);
		$this->ViewInfo['Charset'] = $_GET["charset"];
		preg_match( "|(http://[^/]+?)/.*|isU",$this->ViewInfo['Referer'],$Tmp);
		$this->ViewInfo['Site'] = trim($Tmp[1]);
		$this->GetBrowser();
		$this->GetSystem();
	}
	/**
	 * ���ܣ���ʼ������������·��2.6
	 *
	 */
	private function InitSearch()
	{
		$data = array();
		$DomainName = $this->ViewInfo['Site'];
		$RefererUrl = $this->ViewInfo['Referer'];
		$KeyWord = "";
		if(strstr($DomainName,'baidu.com'))							//�ж��Ƿ����԰ٶ�
		{
			$KeyWord = urldecode($this->Match("|baidu.+wo?r?d=([^\&]*)|is",$RefererUrl));
			$DomainName = "www.baidu.com";
		}
		else if(strstr($DomainName,'google.com'))						//�ж��Ƿ�����google
		{
			$KeyWord = utf82gb2312(urldecode($this->Match("|google.+q=([^\&]*)|is",$RefererUrl)));
			$DomainName = "www.google.com";
		}
		else if(strstr($DomainName,'sohu.com'))						//�ж��Ƿ������Ѻ�
		{
			$KeyWord = urldecode($this->Match("|sohu.+query=([^\&]*)|is",$RefererUrl));
			$DomainName = "www.sohu.com";
		}
		else if(strstr($DomainName,'sina.com.cn'))					//�ж��Ƿ���������
		{
			$KeyWord = urldecode($this->Match("|sina.+searchkey=([^\&]*)|is",$RefererUrl));
			$DomainName = "www.sina.com.cn";
		}
		else if(strstr( $DomainName, '163.com') )						//�ж��Ƿ���������
		{
			$KeyWord = urldecode($this->Match("|163.+q=([^\&]*)|is",$RefererUrl));
			$DomainName = "www.163.com";
		}
		else if(strstr($DomainName,'yahoo.com'))						//�ж��Ƿ������Ż�
		{
			$KeyWord = iconv("utf-8","gb2312",urldecode($this->Match("|yahoo.+p=([^\&]*)|is",$RefererUrl)));
			$DomainName = "www.yahoo.com";
		}
		else if(strstr($DomainName,'lycos.com'))						//�ж��Ƿ�����lycos
		{
			$KeyWord = urldecode($this->Match("|lycos.+query=([^\&]*)|is",$RefererUrl));
			$DomainName = "www.lycos.com";
		}
		else if(strstr($DomainName,'3721.com'))					//�ж��Ƿ�����3721
		{
			$KeyWord = urldecode($this->Match("|3721.+p=([^\&]*)|is",$RefererUrl));
			$DomainName = "www.3721.com";
		}
		else if(strstr($DomainName,'qq.com'))					//�ж��Ƿ�����qq
		{
			$KeyWord = urldecode($this->Match("|qq.+word=([^\&]*)|is",$RefererUrl));
			$DomainName = "www.qq.com";
		}
		else if(strstr($DomainName,'tom.com'))					//�ж��Ƿ�����tom
		{
			$KeyWord = urldecode($this->Match("|tom.+word=([^\&]*)|is",$RefererUrl));
			$DomainName = "www.tom.com";
		}
		else if(strstr($DomainName,'21cn.com'))					//�ж��Ƿ�����21cn
		{
			$KeyWord = urldecode($this->Match("|21cn.+word=([^\&]*)|is",$RefererUrl));
			$DomainName = "www.21cn.com";
		}
		else if(strstr($DomainName,'sogou.com'))					//�ж��Ƿ������ѹ�
		{
			$KeyWord = urldecode($this->Match("|sogou.+query=([^\&]*)|is",$RefererUrl));
			$DomainName = "www.sogou.com";
		}
		else if(strstr($DomainName, 'aol.com'))					//�ж��Ƿ�����aol
		{
			$KeyWord = urldecode($this->Match("|aol.+query=([^\&]*)|is",$RefererUrl));
			$DomainName = "www.aol.com";
		}
		if($KeyWord)										//�ж��Ƿ�ͨ�������������
		{
			$data['F_SEARCH_IP'] = $this->ViewInfo['Ip'];
			$data['F_SEARCH_TIME'] = $this->ViewInfo['Time'];
			$data['F_SEARCH_URL'] = $DomainName;
			$data['F_SEARCH_KEYWORD'] = $KeyWord;
			$this->insertData("EM_SEARCH_INFO",$data);
		}
	}
	/**
	 * ���ܣ���ʼ����վ��·��2.5
	 *
	 */
	private function InitRefer()
	{
		$data = array();
		$data['F_REFER_URL'] = $this->ViewInfo['Site'];
		$data['F_REFER_IP'] = $this->ViewInfo['Ip'];
		$data['F_REFER_TIME'] = $this->ViewInfo['Time'];
		$data['F_REFER_PAGE'] = $this->ViewInfo['Referer'];
		$this->insertData("EM_REFER_INFO",$data);
	}
	/**
	 * ���ܣ���ʼ���ͻ�����Ϣ��2.4
	 *
	 */
	private function InitClient()
	{
		$data = array();
		$data['F_CLIENT_IP'] = $this->ViewInfo['Ip'];
		$data['F_CLIENT_TIME'] = $this->ViewInfo['Time'];
		$data['F_CLIENT_AREA'] = $this->ipclass->getlocation($this->ViewInfo['Ip']);
		$data['F_CLIENT_BROWSER'] = $this->ViewInfo['Browser'];
		$data['F_CLIENT_SCREEN'] = $this->ViewInfo['Screen'];
		$data['F_CLIENT_SYSTEM'] = $this->ViewInfo['System'];
		$data['F_CLIENT_LANGUAGE'] = $this->ViewInfo['Language'];
		$this->insertData('EM_CLIENT_INFO',$data);
	}
	/**
	 * ���ܣ�����������Ϣ
	 *
	 */
	private function GetBrowser()
	{
		$Browser = '����';
														//�ж��Ƿ���myie
		if(strpos(strtolower($this->ViewInfo[Agent]),"myie")) {
			$Browser = "MYIE";
		}
														//�ж��Ƿ���Netscape
		if(strpos(strtolower($this->ViewInfo[Agent]),"netscape")) {
			$Browser = "Netscape";
		}
														//�ж��Ƿ���Opera
		if(strpos(strtolower($this->ViewInfo[Agent]),"opera")) {
			$Browser = "Opera";
		}
														//�ж��Ƿ���NetCaptor
		if(strpos(strtolower($this->ViewInfo[Agent]),"netcaptor")) {
			$Browser = "NetCaptor";
		}
														//�ж��Ƿ���TT
		if(strpos(strtolower($this->ViewInfo[Agent]),"tencenttraveler")) {
			$Browser = "TencentTraveler";
		}
														//�ж��Ƿ���Firefox
		if(strpos(strtolower($this->ViewInfo[Agent]),"firefox")) {
			$Browser = "Firefox";
		}
														//�ж��Ƿ���msie
		if(strpos(strtolower($this->ViewInfo[Agent]),"msie")) {
			$Browser = "IE";
		}
		$this->ViewInfo['Browser'] = $Browser;
	}
	/**
	 * ���ܣ�ȡ�ÿͻ��˲���ϵͳ��Ϣ
	 *
	 */
	private function GetSystem()
	{
		$System = '����';
														//�ж��Ƿ���Windows NT
		if(strpos(strtolower($this->ViewInfo[Agent]), "windows nt")) {
			$System = "Windows NT";
		}
														//�ж��Ƿ���Windowsϵ��
		if(strpos(strtolower($this->ViewInfo[Agent]), "windows")) {
			$System = "Windows";
		}
														//�ж��Ƿ���Mac
		if(strpos(strtolower($this->ViewInfo[Agent]), "mac")) {
			$System = "Mac";
		}
														//�ж��Ƿ���unix
		if(strpos(strtolower($this->ViewInfo[Agent]), "unix")) {
			$System = "UNIX";
		}
														//�ж��Ƿ���Linux
		if(strpos(strtolower($this->ViewInfo[Agent]),  "linux")) {
			$System = "LINUX";
		}
														//�ж��Ƿ���SunOS
		if(strpos(strtolower($this->ViewInfo[Agent]), "sunos")) {
			$System = "SunOs";
		}
														//�ж��Ƿ���BSD
		if(strpos(strtolower($this->ViewInfo[Agent]), "bsd")) {
			$System = "BSD";
		}
		$this->ViewInfo['System'] = $System;
	}
	/**
	 * ���ܣ���ʼ���û���Ϣ��
	 *
	 */
	private function InitUser()
	{
		$data = array();
		$data['F_USER_IP'] = $this->ViewInfo['Ip'];
		$data['F_USER_TIME'] = $this->ViewInfo['Time'];
		$this->insertData('EM_USER_INFO',$data);
	}
	/**
	 * ���ܣ���ʼ������Ϣ��
	 *
	 */
	private function InitDay()
	{
		if($id = $this->checkIsNewDay())						//�ж��Ƿ�������
		{
			$field = "F_DAY_COUNT = F_DAY_COUNT + 1";
			if($this->checkIsNewViewer($this->DayStart,$this->DayEnd))			//�ж��Ƿ����·�����
			{
				$field .= ",F_DAY_IP_COUNT = F_DAY_IP_COUNT + 1";
			}
			$hour = date("G",$this->ViewInfo['Time']) + 8;
			$field .= ",F_DAY_HOUR" . $hour . " = F_DAY_HOUR" . $hour . " + 1";
			for ($i = 0;$i <= 23;$i++)							//��0-23ѭ����$i�Ǳ�ʾһ�������
			{
				$start = mktime($i,0,0,$this->Month,$this->Day,$this->Year);
				$end = mktime($i,59,59,$this->Month,$this->Day,$this->Year);
				$sql = "SELECT count(F_ID) FROM EM_USER_INFO WHERE F_USER_IP = " . $this->ViewInfo['Ip'];
				$sql .= " AND F_USER_TIME >= $start AND F_USER_TIME <= $end";
				$r = $this->select($sql);
				if($r[0][0] > 0)								//�ж��Ƿ���û��Ƿ���ʹ�
				{
					$field .= ",F_DAY_HOUR" . $i . "_IP = F_DAY_HOUR" . $i . "_IP + 1";
					break;
				}
			}
			$sql = "UPDATE EM_DAY_DATA SET $field WHERE F_ID = $id";
			$this->update ($sql);
		}else{
			$field = 'F_DAY_YEAR,';
			$value = $this->Year . ",";
			$field .= 'F_DAY_MONTH,';
			$value .= $this->Month . ",";
			$field .= 'F_DAY_DAY,';
			$value .= $this->Day . ",";
			$field .= 'F_DAY_COUNT,';
			$value .= 1 . ",";
			$field .= 'F_DAY_IP_COUNT,';
			$value .= 1 . ",";
			$hour = date("G",$this->ViewInfo['Time']) + 8;
			$field .= "F_DAY_HOUR" . $hour . ",";
			$value .= 1 . ",";
			$field .= "F_DAY_HOUR" . $hour . "_IP,";
			$value .= 1 . ",";
			$field .= 'F_DAY_TIME';
			$value .= mktime(0,0,0,$this->Month,$this->Day,$this->Year);
			$sql = "INSERT INTO EM_DAY_DATA($field) VALUES($value)";
			$this->insert($sql);
		}
	}
	/**
	 * ���ܣ���ʼ������Ϣ��
	 *
	 */
	private function InitMonth()
	{
		$data = array();
		if($id = $this->checkIsNewMonth())						//�ж��Ƿ�������
		{
			$field = 'F_MONTH_COUNT = F_MONTH_COUNT + 1';
			if($this->checkIsNewViewer($this->MonthStart))		//�ж��Ƿ����·�����
			{
				$field .= 'F_MONTH_IP_COUNT = F_MONTH_IP_COUNT + 1';
			}
			$sql = "UPDATE EM_MONTH_DATA SET $field WHERE F_ID = $id";
			$this->update($sql);
		}else{
			$field = 'F_MONTH_YEAR,';
			$value = $this->Year . ",";
			$field .= 'F_MONTH_MONTH,';
			$value .= $this->Month . ",";
			$field .= 'F_MONTH_COUNT,';
			$value .= 1 . ",";
			$field .= 'F_MONTH_IP_COUNT';
			$value .= 1;
			$sql = "INSERT INTO EM_MONTH_DATA($field) VALUES($value)";
			$this->insert ($sql);
		}
	}
	/**
	 * ���ܣ�����Ƿ�������
	 *
	 * ���أ�0������Ϣ��ID
	 */
	private function checkIsNewMonth()
	{
		$sql = "SELECT F_ID FROM EM_MONTH_DATA WHERE F_MONTH_YEAR = '" . $this->Year . "' AND ";
		$sql .= "F_MONTH_MONTH = '" . $this->Month . "'";
		$r = $this->select($sql);
		if($r[0][0] > 0)										//��¼ID����0��������
		{
			return $r[0][0];
		}else{
		return 0;
		}
	}
	/**
	 * ���ܣ�����Ƿ����·�����
	 *
	 * ������$start ��ʼͳ��ʱ��,$end ����ʱ��
	 * ���أ�true or false
	 */
	private function checkIsNewViewer($start,$end)
	{
		$sql = "SELECT count(F_ID) FROM EM_USER_INFO WHERE F_USER_IP = " . $this->ViewInfo['Ip'] . " AND F_USER_TIME >= $start AND F_USER_TIME <= $end";
		$r = $this->select($sql);
		if($r[0][0] > 0)										//��¼ID�������0�����·�����
		{
			return false;
		}else{
			return true;
		}
	}
	/**
	 * ���ܣ�����Ƿ�������
	 *
	 * ���أ�0������Ϣ��ID
	 */
	private function checkIsNewDay()
	{
		$sql = "SELECT F_ID FROM EM_DAY_DATA WHERE F_DAY_YEAR = '" . $this->Year . "' AND ";
		$sql .= "F_DAY_MONTH = '" . $this->Month . "' AND F_DAY_DAY = '" . $this->Day . "'";
		$r = $this->select($sql);
		if($r[0][0] > 0)										//��¼ID����0��������
		{
			return $r[0][0];
		}else{
			return 0;
		}
	}
}
?>