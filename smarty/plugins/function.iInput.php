<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     iInput
 * Purpose:  create HTML code for an INPUT element
 * -------------------------------------------------------------
 */
function smarty_function_iInput($params, &$smarty)
{
	if (!empty($params['_params'])) {
		$_params = $params['_params'];
		unset($params['_params']);
		$params = array_merge($_params, $params);
	} else if (isset($params['_params'])) unset($params['_params']);
	
	if (empty($params['type'])) return;
	
	$prefix = '';
	$output = '';
	$class = '';
	$addId = true;
	
	switch ($params['type']) {
	case 'text':
	case 'password':
	case 'submit':
	case 'checkbox':
	case 'select':
	case 'file':
	case 'textarea':
	case 'hidden':
	case 'button':
	case 'image':
	case 'reset':
	case 'radio':
		$class = $prefix . $params['type'];
		if (!empty($params['class'])) {
			$class .= ' ' . $params['class'];
			unset($params['class']);
		}
		$addId = false;
		break;
		
	default:
		return;
	}
	
	if (!empty($params['label']) && !empty($params['name'])) {
		$output .= '<label for="' . $params['name'] . '">' . $params['label'] . "</label>";
		unset($params['label']);
	}
	if ($params['type'] === 'select') $output .= '<select class="' . $class . '"';
	else if ($params['type'] === 'textarea') $output .= '<textarea class="' . $class . '" rows="1" cols="1"';
	else if ($params['type'] === 'button') $output .= '<button class="' . $class . '" type="' . $params['type'] . '"';
	else $output .= '<input class="' . $class . '" type="' . $params['type'] . '"';
	$type = $params['type'];
	unset($params['type']);
	foreach ($params as $key => $value) {
		$output .= ' ' . $key . '="' . $value . '"';
	}
	if (empty($params['id']) && !empty($params['name']) && $addId) $output .= ' id="' . $params['name'] . '"';
	if ($type === 'select' || $type === 'textarea' || $type === 'button') $output .= '>';
	else $output .= '/>';
	
	return $output;
}

?>
