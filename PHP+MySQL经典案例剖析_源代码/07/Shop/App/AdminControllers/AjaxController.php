<?php
class AjaxController extends Core_Controller_Action
{
    public function __construct()
    {
        $this->_model = new ProductModel();
        parent::__construct();
    }
    public function IndexAction()
    {
        
    }
    /**
     * ���ܣ���ѯ��Ʒ
     * 
     */
    public function ProductAction()
    {
        $data = $this->_model->GetProductListAll($this->_getParam('ClassId'));
        if(empty($data))									//�ж������Ƿ�Ϊ��
        {
        	echo "$('product_id').options[0].selected=true;$('product_id').options.length=1;$('product_id').disabled=true;";
        }else{
        	echo "setOpts(new Array('".implode(array_keys($data),"','")."'),new Array('".implode($data,"','")."'));";
        }
    }
}
?>
