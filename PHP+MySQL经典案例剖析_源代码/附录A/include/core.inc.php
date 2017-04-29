<?php
class Core
{
	static private $_lang = null;
	private function __construct()
	{}
	/**
	* 功能：设置系统语言
	*/
	static public function setLanguage(){
		$lang = self::getLanguage();       
		putenv('LANG='.$lang);
		setlocale(LC_ALL, $lang); 
		$locale = LOCALE;
		$locale = str_replace("/","\\",LOCALE);  //如果是windows
		bindtextdomain($lang,$locale);
		textdomain($lang);				
	} 
	/**
	* 功能：改变当前语言
	*/
	static public function chgLanguage($lang = null){	 
		self::$_lang = $lang;   
		setcookie("LANG", $lang , time() + 3600 * 24,'/');  
	}	
	/**
	* 功能：取得当前使用的语言
	* 返回：$Lang 语言代码
	*/
	static public function getLanguage(){
		if (self::$_lang)						//如果$_lang有值，则返回$_lang
			return self::$_lang;
		
		if (isset($_COOKIE['LANG'])){			//如果$_COOKIE['LANG']有值，则返回$_COOKIE['LANG']
			return $_COOKIE['LANG'];
		}
		preg_match('/^([a-z\-]+)/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $Matches); 
		$LangRef = $Matches[1];  
		switch ($LangRef) {					//判断系统语言
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
