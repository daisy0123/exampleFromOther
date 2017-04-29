<?php

function tpl_function_html_multiarray($params, &$smarty)
{
	foreach($params as $_key => $_val) {    
		switch($_key) {
			case 'val':
				$$_key = (string)$_val;
				break;
			case 'in':
				$$_key = (array)$_val;
				break;
			case 'match':
			case 'display':
				$$_key = (string)$_val;
				break;
            case 'none':
                $$_key = (string)$_val;
                break;
			default:
				$tpl->trigger_error("not a expect val", E_USER_NOTICE);
				break;
		}
	}
	
	$temp = array();

	foreach($in as $key=>$val){
		$temp[$in[$key][$match]] = $in[$key][$display];
	}

    if(array_key_exists($val,$temp))
    {
        $_html_result = $temp[$val];
    }
    else
    {
        $_html_result = $none;
    }

	return $_html_result;
}

?>
