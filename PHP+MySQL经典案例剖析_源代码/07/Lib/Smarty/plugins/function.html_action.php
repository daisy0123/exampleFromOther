<?php

function tpl_function_html_action($params, &$smarty)
{
   //require_once $smarty->_get_plugin_filepath('shared','escape_special_chars');

	if(array_key_exists("id",$params)){
		$value = $params['id'];
	}	else	{
		$smarty->trigger_error("html_action: value key is required", E_USER_NOTICE);
	}
	foreach($params as $_key=>$_val){
		switch($_key){
			case 'del':
				$del_action = true;
			break;
				
		    case 'edit':
				$edit_action = true;
		    break;
			default:
				if(!is_array($_val)) {
					$extra .= '&'.$_key.'='.$_val;//smarty_function_escape_special_chars($_val);
				} else {
					$smarty->trigger_error("html_options: extra attribute '$_key' cannot be an array", E_USER_NOTICE);
				}
			break;	
		}
	}

	if($edit_action){
		$_html_result = "[<a href=\"?action=edit$extra\">±à¼­</a>]";
	}
	if($del_action){
		$_html_result .= "[<a href=\"?action=del$extra\">É¾³ý</a>]";
	}    
	return $_html_result;

}

?>
