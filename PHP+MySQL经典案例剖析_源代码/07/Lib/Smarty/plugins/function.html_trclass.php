<?php

function tpl_function_html_trclass($params, &$smarty)
{
	global $theRow;
	$style[0] = "listbg";
	$style[1] = "listbg2";
	$rowColor = ( $theRow%2 == 0 ) ? ( $style[0] ) : ( $style[1] );
	$theRow++;
    
	$_html_result = "class=\"$rowColor\"";
	return $_html_result;

}

?>
