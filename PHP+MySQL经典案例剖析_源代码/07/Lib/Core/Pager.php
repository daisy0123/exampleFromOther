<?php
class Core_Pager
{
    private $_pageSize = 20;							//每页显示数量
    private $_pageStart = 1;							//开始页码
    private $_sectionNum = 10;						//显示页数段
    private $_db;									//数据库访问对象
    private $_linkUrl;								//翻页连接地址
    private $_offset = 0;								//偏移量
    private $_count = 0;								//记录数
    private $_pageNum = 1;							//当前页码
    private $_pageSQL ;								//分页SQL
    private $_sqlBind =null;							//绑定数据
    /**
     * 功能：Page构造函数
     * 参数：$pageSQL分页的原始SQL语句,$pageSize每页显示条数,$bind 绑定参数
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
 	* 功能：解析Url地址，把Page参数去掉组合成一个地址
	*/
    public function _parseURL()
    {
        $path = $_SERVER['REQUEST_URI'];
        if (strstr($path, '?')) {							//判断url里是否有问号
            $path = substr($path, 0, strpos($path, '?'));
        }
        $path = explode('/', trim($path, '/'));				//拆分url
        $controller = isset($path[0]) ? $path[0] : "Index";
        $action = isset($path[1]) ? $path[1] : "Index";
        $linkUrl = "/$controller/$action";
        $params = array();
        for ($i=2; $i<sizeof($path); $i=$i+2) {				//循环重组地址
            if ($path[$i] != "page"){						//判断参数是否为page
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
 	* 功能：取得分页处理后的参数
 	* 返回：JumpBar 分页字符串,data 显示数据
 	*/
    public function getData()
    {
        return array('JumpBar'  =>  $this->_getJumpBar(),
                     'data'     =>  $this->_getData());
    }
	/**
 	* 功能：取得记录数
 	*/
    private function _getRecordCount()
    {
         $strSQLx = $this->_db->limit($this->_pageSQL, $this->_pageSize*$this->_sectionNum , ($this->_pageStart-1) * $this->_pageSize);
         $strSQL = "SELECT COUNT(*) FROM (" . $strSQLx . ") AS COUNTTAB";
         $count = $this->_db->fetchOne($strSQL,$this->_sqlBind) ; 
         return $count;
    }
	/**
 	* 功能：生成分页字符串
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
        if ($this->_pageNum == 1)						//判断当前是否是第一页
            $strJumpBar .= '上一页&nbsp;&nbsp;';
        else 
            $strJumpBar .= "<a href='{$this->_linkUrl}/page/" . ($this->_pageNum-1) . "'>上一页</a>&nbsp;&nbsp;";
        $i = 0;
		if(!$pageCount) $pageCount = 1;
        for ($i = 0; $i< $pageCount; $i++){				//循环生成页码
            if ( $this->_pageNum == $iStartPage + $i) 
                $strJumpBar .= ($iStartPage + $i) . "&nbsp;&nbsp;";
            else
                $strJumpBar .= "<a href='{$this->_linkUrl}/pagez/" . ($iStartPage + $i) . "'>" . ($iStartPage + $i) . "</a>&nbsp;&nbsp;";
        }
        if ( $this->_pageNum == ($iStartPage + $i-1) && $count < ($this->_sectionNum * $this->_pageSize))     
            $strJumpBar .= '下一页';					//判断是否有下一页
        else
            $strJumpBar .= "<a href='{$this->_linkUrl}/pagez/" . ($this->_pageNum+1) . "'>下一页</a>";
        return $strJumpBar;
    }
	/**
 	* 功能：获取分页显示数据
 	*/
    private function _getData()
    { 
        $strSQL = $this->_db->limit($this->_pageSQL, $this->_pageSize , ($this->_pageNum-1) * $this->_pageSize);
        return $this->_db->fetchAll($strSQL,$this->_sqlBind);
    }
}
?>
