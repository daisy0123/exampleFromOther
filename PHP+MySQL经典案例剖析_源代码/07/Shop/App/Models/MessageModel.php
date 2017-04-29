<?php
class MessageModel extends Core_Db_Table
{
	protected $_name = "EE_MESSAGE_INFO";
	/**
	 * 功能：提取反馈信息列表
	 * 返回：数组
	 */
	public function GetMessageList()
	{
		$sql = "SELECT p.F_PRODUCT_NAME,m.*,l.F_LOGIN_NAME FROM EE_MESSAGE_INFO m,EE_PRODUCT_INFO p,EM_LOGIN_INFO l";
		$sql .= "  WHERE m.F_ID_PRODUCT_INFO = p.F_ID AND m.F_ID_LOGIN_INFO = l.F_ID ORDER BY F_MESSAGE_TIME DESC";
		$page = new Core_Pager($sql);
		return $page->getData();
	}
}
?>
