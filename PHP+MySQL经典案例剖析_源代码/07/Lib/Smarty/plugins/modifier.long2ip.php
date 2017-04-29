<?php
/**
 * Smarty-Light long2ip modifier plugin
 *
 * Type:     modifier
 * Name:     long2ip
 * Purpose:  Wrapper for the PHP 'long2ip' function
 */
function tpl_modifier_long2ip($string) {
	return long2ip($string);
}
?>