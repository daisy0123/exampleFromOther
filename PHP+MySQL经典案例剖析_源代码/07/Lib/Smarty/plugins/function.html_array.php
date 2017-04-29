<?php

function tpl_function_html_array($params, &$smarty)
{
	foreach($params as $_key => $_val) {    
		switch($_key) {
			case 'val':
				$$_key = (string)$_val;
				break;
			case 'in':
				$$_key = (array)$_val;
				break;
            case 'none':
                $$_key = (string)$_val;
                break;
			default:
				$tpl->trigger_error("not a expect val", E_USER_NOTICE);
				break;
		}
	}

    if(array_key_exists($val,$in))
    {
        $_html_result = $in[$val];
    }
    else
    {
        $_html_result = $none;
    }

	return $_html_result;
}

?>
