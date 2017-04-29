<?php
class View
{
	protected $_smarty = false;
	protected $_lang = null;
    protected $_defaultLang = 'zh_CN';
	/**
	���ܣ���ʼ�����캯��
	������$lang ���Դ���
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
	 * ���ܣ�����ģ��
	 * ������$template ģ��·��
	 */
	protected function _run($template){	    
		$this->_smarty->display($template);	
	}
	/**
	 * ���ܣ�Ϊģ�������ֵ
	 * ������$var �ַ���������
	 */
    public function assign($var)
    {
        if (is_string($var))							//������ַ������򵥸���ֵ
        {
            $value = @func_get_arg(1);
            
            $this->_smarty->assign($var, $value);
        }
        elseif (is_array($var))
        {
            foreach ($var as $key => $value)			//��������飬��ѭ����ֵ
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
     * ���ܣ��ϲ�ģ��
     * ������ģ��·��
     * ���أ�smarty�ϲ����ģ���ַ���
     */
	public function render($template){
		return $this->_smarty->fetch($template);
	}
	/**
	 * ���ܣ���ʾģ��
	 * ������$template ģ��·��
	 */
	public function display($template){
        if (!$this->_smarty->template_exists($template))//�����ģ�岻����,����Ĭ��·������ʾ
	       $this->_smarty->template_dir = TEMPLATE_PATH.$this->_defaultLang . '/';
	    	    
		$this->_smarty->display($template);
	}
    /**
     * ���ܣ����õ�ǰʹ������
     * ������$lang ���Դ���
     */
	public function setLang($lang = null){
		if($lang != null){							//���������Ϊ����ֵ
			$this->_lang = $lang;
		}
	}
}
?>
