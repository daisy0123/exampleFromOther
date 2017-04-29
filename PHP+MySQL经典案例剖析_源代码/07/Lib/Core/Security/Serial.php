<?php
class Core_Security_Serial
{		
	protected $_db;
	/*
	 * 功能：生成注册序列号
	 * 返回：字符串
	 */
	private function tranCode($sourceCode){
	    $codeLen = strlen($sourceCode);
	    if ( $codeLen % 6 ){										//判断字符串长度是否是6的倍数
	    		$subNum = $codeLen + 6 - $codeLen % 6;
	    } else {
	    		$subNum = $codeLen;
	    }
	    $codeBase = str_pad($sourceCode, $subNum, '.');				//右补.号
	    $codeBaseArray = str_split($codeBase, 6);					//把字符串生成一个数组
	    $codeRevArray = array_reverse($codeBaseArray);				//倒序重组数组
	    $serialCode = implode($codeRevArray);						//组合成新的字符串
	    return $serialCode;
	}
	/**
	 * 功能：以EMAIL为源生成序列号
	 * 参数：$userEmail 用户EMAIL
	 * 返回：字符串
	 */
	public function getSerial($userEmail)
	{
		$serialSource = "{".$userEmail."}".time();						//用{EMAIL}加时间戳为字符串源
		$serialSource = base64_encode($serialSource);				//base64编码
		$serialCode = $this->tranCode($serialSource);					//生成序列号
	    return $serialCode;
	}
	/*
	 * 功能：校验激活序列号是否正确
	 * 返回：FALSE OR 用户EMAIL
	 */
	public function checkSerial($serialCode)
	{
		$serialSource = $this->tranCode($serialCode);
		$dotpos = strrpos($serialSource, ".");
		$serialSource = base64_decode(substr($serialSource, 0, $dotpos-1));
		if ( eregi("^\{{1}(.+)*\}{1}(.+)*", $serialSource, $arr) ) {				//判断序列号是否正确
			$userEmail = $arr[1];
			$time = $arr[2];
			if (($time-time()) > 172800 ) {							//判断序列号是否过期
				return FALSE;
			} else {
		    		$this->_db = Zend::registry("db");
		    		$strSQL = "SELECT F_ID FROM EM_LOGIN_INFO WHERE F_LOGIN_EMAIL = :email";
		        	if ($this->_db->fetchRow($strSQL,array('email'=>$userEmail))){
		    	    		return $userEmail;							//判断EMAIL是否正确
		    		} else {
		        		return FALSE;
		        }
			}
		} else {
			return FALSE;
		}
	}
}
?>
