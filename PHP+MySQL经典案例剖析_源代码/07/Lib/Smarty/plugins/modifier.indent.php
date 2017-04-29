<?php
/**
 * Smarty-Light replace modifier plugin
 *
 * Type:     modifier
 * Name:     indent
 * Purpose:  add /t to string
 * Credit:   Taken from the original Smarty
 *           http://smarty.php.net
 */
function tpl_modifier_indent($string,$chars=4,$char=" ")
{
    return preg_replace('!^!m',str_repeat($char,$chars),$string);
}
?>