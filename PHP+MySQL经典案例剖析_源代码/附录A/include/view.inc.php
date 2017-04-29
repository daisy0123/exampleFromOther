<?php
class View
{
	protected $_smarty = false;
	protected $_lang = null;
    protected $_defaultLang = 'zh_CN';
	/**
	功能：初始化构造函数
	参数：$lang 语言代码
	**/
	public function __construct($lang=null){
		$this->setLang($lang);
		$this->_smarty = new template();
		if ($this->_lang !== null)
			$sub_dir = $this->_lang."/";
		else
			$sub_dir = "";
		$this->_smarty->template_dir = TEMPLATE_PATH.$sub_dir;
		$this->_smarty->compile_dir  = TEMPLATE_C_PATH;
		$this->_smarty->config_dir   = CONFIG_PATH;
		$this->_smarty->cache_dir    = CACHE_PATH;
	}
	/**
	 * 功能：调用模板
	 * 参数：$template 模板路径
	 */
	protected function _run($template){	    
		$this->_smarty->display($template);	
	}
	/**
	 * 功能：为模板变量付值
	 * 参数：$var 字符串或数组
	 */
    public function assign($var)
    {
        if (is_string($var))							//如果是字符串，则单个付值
        {
            $value = @func_get_arg(1);
            
            $this->_smarty->assign($var, $value);
        }
        elseif (is_array($var))
        {
            foreach ($var as $key => $value)			//如果是数组，则循环付值
            {
                $this->_smarty->assign($key, $value);
            }
        }
        else
        {
            throw new Exception('assign() expects a string or array, got '.gettype($var));
        }
    }
    /**
     * 功能：合并模板
     * 参数：模板路径
     * 返回：smarty合并后的模板字符串
     */
	public function render($template){
		return $this->_smarty->fetch($template);
	}
	/**
	 * 功能：显示模板
	 * 参数：$template 模板路径
	 */
	public function display($template){
        if (!$this->_smarty->template_exists($template))//如果该模板不存在,则在默认路径下显示
	       $this->_smarty->template_dir = TEMPLATE_PATH.$this->_defaultLang . '/';
	    	    
		$this->_smarty->display($template);
	}
    /**
     * 功能：设置当前使用语言
     * 参数：$lang 语言代码
     */
	public function setLang($lang = null){
		if($lang != null){							//如果参数不为空则付值
			$this->_lang = $lang;
		}
	}
}
?>
