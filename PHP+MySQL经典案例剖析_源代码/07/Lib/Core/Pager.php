<?php
class Core_Pager
{
    private $_pageSize = 20;							//ÿҳ��ʾ����
    private $_pageStart = 1;							//��ʼҳ��
    private $_sectionNum = 10;						//��ʾҳ����
    private $_db;									//���ݿ���ʶ���
    private $_linkUrl;								//��ҳ���ӵ�ַ
    private $_offset = 0;								//ƫ����
    private $_count = 0;								//��¼��
    private $_pageNum = 1;							//��ǰҳ��
    private $_pageSQL ;								//��ҳSQL
    private $_sqlBind =null;							//������
    /**
     * ���ܣ�Page���캯��
     * ������$pageSQL��ҳ��ԭʼSQL���,$pageSizeÿҳ��ʾ����,$bind �󶨲���
     */
    public function __construct($pageSQL,$pageSize = 20,$bind=null)
    {
        $this->_pageSQL = $pageSQL;
        $this->_sqlBind = $bind;
        $this->_pageSize = $pageSize;
        $this->_db = Zend::registry("db");       
        $this->_parseURL();      
    }
    /**
 	* ���ܣ�����Url��ַ����Page����ȥ����ϳ�һ����ַ
	*/
    public function _parseURL()
    {
        $path = $_SERVER['REQUEST_URI'];
        if (strstr($path, '?')) {							//�ж�url���Ƿ����ʺ�
            $path = substr($path, 0, strpos($path, '?'));
        }
        $path = explode('/', trim($path, '/'));				//���url
        $controller = isset($path[0]) ? $path[0] : "Index";
        $action = isset($path[1]) ? $path[1] : "Index";
        $linkUrl = "/$controller/$action";
        $params = array();
        for ($i=2; $i<sizeof($path); $i=$i+2) {				//ѭ�������ַ
            if ($path[$i] != "page"){						//�жϲ����Ƿ�Ϊpage
                $pName = $path[$i];
                $pValue = isset($path[$i+1]) ? $path[$i+1] : "";
                $linkUrl .= "/$pName/$pValue";
            } else {
                $this->_pageNum = isset($path[$i+1]) ? (int)$path[$i+1]:1;
            }
        }
        $this->_linkUrl = $linkUrl;  
    }
	/**
 	* ���ܣ�ȡ�÷�ҳ�����Ĳ���
 	* ���أ�JumpBar ��ҳ�ַ���,data ��ʾ����
 	*/
    public function getData()
    {
        return array('JumpBar'  =>  $this->_getJumpBar(),
                     'data'     =>  $this->_getData());
    }
	/**
 	* ���ܣ�ȡ�ü�¼��
 	*/
    private function _getRecordCount()
    {
         $strSQLx = $this->_db->limit($this->_pageSQL, $this->_pageSize*$this->_sectionNum , ($this->_pageStart-1) * $this->_pageSize);
         $strSQL = "SELECT COUNT(*) FROM (" . $strSQLx . ") AS COUNTTAB";
         $count = $this->_db->fetchOne($strSQL,$this->_sqlBind) ; 
         return $count;
    }
	/**
 	* ���ܣ����ɷ�ҳ�ַ���
 	*/
    private function _getJumpBar()
    {
        $iStartPage = $this->_pageNum - (int)($this->_sectionNum /2) + 1;
        $iStartPage = ($iStartPage < 1)?1:$iStartPage;
        $this->_pageStart = $iStartPage;
        $this->_offset = ($iStartPage - 1) * $this->_pageSize;  
        $this->_count = ($iStartPage - 1 + $this->_sectionNum) * $this->_pageSize;
        $count = $this->_getRecordCount();
        $pageCount = ceil($count / $this->_pageSize);
        $strJumpBar = '';
        if ($this->_pageNum == 1)						//�жϵ�ǰ�Ƿ��ǵ�һҳ
            $strJumpBar .= '��һҳ&nbsp;&nbsp;';
        else 
            $strJumpBar .= "<a href='{$this->_linkUrl}/page/" . ($this->_pageNum-1) . "'>��һҳ</a>&nbsp;&nbsp;";
        $i = 0;
		if(!$pageCount) $pageCount = 1;
        for ($i = 0; $i< $pageCount; $i++){				//ѭ������ҳ��
            if ( $this->_pageNum == $iStartPage + $i) 
                $strJumpBar .= ($iStartPage + $i) . "&nbsp;&nbsp;";
            else
                $strJumpBar .= "<a href='{$this->_linkUrl}/pagez/" . ($iStartPage + $i) . "'>" . ($iStartPage + $i) . "</a>&nbsp;&nbsp;";
        }
        if ( $this->_pageNum == ($iStartPage + $i-1) && $count < ($this->_sectionNum * $this->_pageSize))     
            $strJumpBar .= '��һҳ';					//�ж��Ƿ�����һҳ
        else
            $strJumpBar .= "<a href='{$this->_linkUrl}/pagez/" . ($this->_pageNum+1) . "'>��һҳ</a>";
        return $strJumpBar;
    }
	/**
 	* ���ܣ���ȡ��ҳ��ʾ����
 	*/
    private function _getData()
    { 
        $strSQL = $this->_db->limit($this->_pageSQL, $this->_pageSize , ($this->_pageNum-1) * $this->_pageSize);
        return $this->_db->fetchAll($strSQL,$this->_sqlBind);
    }
}
?>
