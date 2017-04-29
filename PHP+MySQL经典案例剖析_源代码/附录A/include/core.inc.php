<?php
class Core
{
	static private $_lang = null;
	private function __construct()
	{}
	/**
	* ���ܣ�����ϵͳ����
	*/
	static public function setLanguage(){
		$lang = self::getLanguage();       
		putenv('LANG='.$lang);
		setlocale(LC_ALL, $lang); 
		$locale = LOCALE;
		$locale = str_replace("/","\\",LOCALE);  //�����windows
		bindtextdomain($lang,$locale);
		textdomain($lang);				
	} 
	/**
	* ���ܣ��ı䵱ǰ����
	*/
	static public function chgLanguage($lang = null){	 
		self::$_lang = $lang;   
		setcookie("LANG", $lang , time() + 3600 * 24,'/');  
	}	
	/**
	* ���ܣ�ȡ�õ�ǰʹ�õ�����
	* ���أ�$Lang ���Դ���
	*/
	static public function getLanguage(){
		if (self::$_lang)						//���$_lang��ֵ���򷵻�$_lang
			return self::$_lang;
		
		if (isset($_COOKIE['LANG'])){			//���$_COOKIE['LANG']��ֵ���򷵻�$_COOKIE['LANG']
			return $_COOKIE['LANG'];
		}
		preg_match('/^([a-z\-]+)/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $Matches); 
		$LangRef = $Matches[1];  
		switch ($LangRef) {					//�ж�ϵͳ����
			case 'zh-cn' : 
				$Lang = 'zh_CN';
				break; 
			case 'zh-tw' : 
				$Lang = 'zh_TW';
				break; 
			case 'en-us' :
				$Lang = 'en_US';
				break;           
			default: 
				$Lang = 'zh_CN';
				break; 
		}  
		return $Lang;
	}
}
?>
