<?php
require_once('Smarty/class.template.php');
class Core_View_Smarty
{
	protected $_smarty = false;
	/**
	 * 功能：初始化构造函数
	 */
	public function __construct(){
		$this->_smarty = new template();
		$this->_smarty->template_dir = TEMPLATE_PATH;
		$this->_smarty->compile_dir  = TEMPLATE_C_PATH;
		$this->_smarty->config_dir = CONFIG_PATH;
		$this->_smarty->cache_dir = CACHE_PATH;
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
            foreach ($var as $key => $value)				//如果是数组，则循环付值
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
		$this->_smarty->display($template);
	}
}
?>
