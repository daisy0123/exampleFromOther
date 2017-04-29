<?php
/**
 * Smarty-Light {strip}{/strip} block plugin
 *
 * -------------------------------------------------------------
 * File:     block.t.php
 * Type:     block function
 * Name:     t (short for translate through gettext)
 * Purpose:  return a translated string 
 */
function tpl_block_t($params, $content, &$tpl) {	
	return gettext($content);
}
?>