<?php
/**
 * Smarty-Light date modifier plugin
 *
 * Type:     modifier
 * Name:     date
 * Purpose:  formats a date given a UNIX timestamp, based on the
 *           PHP "date" function
 * Input:
 *         - string: input date string
 *         - format: date format for output
 *         - default_date: default date if $string is empty
 */
function tpl_modifier_date($string, $format="r", $default_date=null) {
	//require_once $smarty->_compile_obj->_get_plugin_dir() . 'shared.make_timestamp.php';

	if($string != '') {
		return date($format, tpl_make_timestamp($string));
	} elseif (isset($default_date) && $default_date != '') {		
		return date($format, tpl_make_timestamp($default_date));
	} else {
		return;
	}
}

/**
 * Smarty-Light make_timestamp function
 *
 * Taken from the original Smarty
 * http://smarty.php.net
 *
 */
function tpl_make_timestamp($string) {
	if(empty($string)) {
		$string = "now";
	}

	if (is_numeric($string) && $string != -1)
		return $string;

	$time = strtotime($string);
	if ($time > 0)
		return $time;
	else
		return time();
}
?>