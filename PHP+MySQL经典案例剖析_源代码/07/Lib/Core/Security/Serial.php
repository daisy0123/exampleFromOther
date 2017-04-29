<?php
class Core_Security_Serial
{		
	protected $_db;
	/*
	 * ���ܣ�����ע�����к�
	 * ���أ��ַ���
	 */
	private function tranCode($sourceCode){
	    $codeLen = strlen($sourceCode);
	    if ( $codeLen % 6 ){										//�ж��ַ��������Ƿ���6�ı���
	    		$subNum = $codeLen + 6 - $codeLen % 6;
	    } else {
	    		$subNum = $codeLen;
	    }
	    $codeBase = str_pad($sourceCode, $subNum, '.');				//�Ҳ�.��
	    $codeBaseArray = str_split($codeBase, 6);					//���ַ�������һ������
	    $codeRevArray = array_reverse($codeBaseArray);				//������������
	    $serialCode = implode($codeRevArray);						//��ϳ��µ��ַ���
	    return $serialCode;
	}
	/**
	 * ���ܣ���EMAILΪԴ�������к�
	 * ������$userEmail �û�EMAIL
	 * ���أ��ַ���
	 */
	public function getSerial($userEmail)
	{
		$serialSource = "{".$userEmail."}".time();						//��{EMAIL}��ʱ���Ϊ�ַ���Դ
		$serialSource = base64_encode($serialSource);				//base64����
		$serialCode = $this->tranCode($serialSource);					//�������к�
	    return $serialCode;
	}
	/*
	 * ���ܣ�У�鼤�����к��Ƿ���ȷ
	 * ���أ�FALSE OR �û�EMAIL
	 */
	public function checkSerial($serialCode)
	{
		$serialSource = $this->tranCode($serialCode);
		$dotpos = strrpos($serialSource, ".");
		$serialSource = base64_decode(substr($serialSource, 0, $dotpos-1));
		if ( eregi("^\{{1}(.+)*\}{1}(.+)*", $serialSource, $arr) ) {				//�ж����к��Ƿ���ȷ
			$userEmail = $arr[1];
			$time = $arr[2];
			if (($time-time()) > 172800 ) {							//�ж����к��Ƿ����
				return FALSE;
			} else {
		    		$this->_db = Zend::registry("db");
		    		$strSQL = "SELECT F_ID FROM EM_LOGIN_INFO WHERE F_LOGIN_EMAIL = :email";
		        	if ($this->_db->fetchRow($strSQL,array('email'=>$userEmail))){
		    	    		return $userEmail;							//�ж�EMAIL�Ƿ���ȷ
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
