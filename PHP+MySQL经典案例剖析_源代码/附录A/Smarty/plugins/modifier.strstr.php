<?php
/**
 * Smarty-Light strstr modifier plugin
 *
 * Type:     modifier
 * Name:     strstr
 * Purpose:  Wrapper for the PHP 'strstr' function
 * Credit:   Taken from the original Smarty
 *           http://smarty.php.net
 */
function tpl_modifier_strstr($string, $key) {
	return strstr($string, $key);
}
?>