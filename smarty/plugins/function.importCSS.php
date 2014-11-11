<?php

function smarty_function_importCSS($params, &$smarty)
{
    if(empty($params['file'])) {
        $smarty->trigger_error("importCSS: missing 'file' parameter");
        return false;
    }

    $_output = '<style type="text/css" media="screen">';
    $_output .= '@import url("' . $params['file'] . '");';
    $_output .= "</style>";

    unset($params['file']);
    foreach ($params as $key => $value) {
	$output .= ' ' . $key . '="' . $value . '"';
    }

    return $_output;
}

?>
