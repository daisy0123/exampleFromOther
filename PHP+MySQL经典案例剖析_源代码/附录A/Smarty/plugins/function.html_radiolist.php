<?php
/*
    html_radiolist name="aa" options=$array selected=
*/
function tpl_function_html_radiolist($params, &$tpl) {
	extract($params);

	if (!isset($name) || empty($name)) {
		$tpl->trigger_error("html_radio: missing 'name' parameter");
		return;
	}

    if(!isset($options) || !is_array($options))
    {
        $tpl->trigger_error("html_radio: missing 'options' parameter");
		return;
    }

	$html_result = "";
    foreach ($options as $_key => $_val)
    {
        $html_result .= "<label for=\"$name.$_val\">$_val</label><INPUT TYPE=\"RADIO\" NAME=\"$name\" ID=\"$name.$_val\" VALUE=\"$_key\"";    
        if(isset($selected) && $selected == $_key)
        {
            $html_result .= " CHECKED";
        }
        $html_result .= ">&nbsp;";
    }
	return $html_result;
}
?>