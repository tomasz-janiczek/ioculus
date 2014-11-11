<?php

	require_once('dispatcher.php');

	class iParamModifier extends iDispatcher
	{
		var $prefix = 'modifier_';
			
		function & singleton()
		{
			static $instance = null;

			if (!$instance) $instance =& iParamModifier::factory();

			return $instance;
		}

		function & factory()
		{
		    $obj =& new iParamModifier();
		    return $obj;
		}
	    
		function & modifier_uppercase(&$args)
		{
			$args['value'] = mb_strtoupper($args['value'], 'utf-8');
			return true;
		}

		function & modifier_lowercase(&$args)
		{
			$args['value'] = mb_strtolower($args['value'], 'utf-8');
			return true;
		}

		function & modifier_nowhitespace(&$args)
		{
			$args['value'] = trim($args['value']);
			$args['value'] = preg_replace('/\s+/', '', $args['value']);
			return true;
		}

		function & modifier_stripHTMLTags(&$args)
		{
			$args['value'] = strip_tags($args['value']);
			return true;
		}

		function & modifier_strip_slashes(&$args)
		{
			$args['value'] = stripslashes($args['value']);
			return true;
		}

		function & modifier_basename(&$args)
		{
			$args['value'] = basename($args['value']);
			return true;
		}

		function & modifier_bbcode(&$args)
		{
			require_once('HTML/BBCodeParser.php');
			
			$args['value'] = HTML_BBCodeParser::staticQparse($args['value']);
			return true;
		}

		function & modifier_default(&$args)
		{
			$args['value'] = $args['params']['value'];
			return true;
		}
		
		function & modifier_truncate(&$args)
		{
			$trailer = !empty($args['params']['trailer']) ? $args['params']['trailer'] : '...';
			$length = $args['params']['length'] - mb_strlen($trailer, 'utf-8');

			if (mb_strlen($args['value'], 'utf-8') <= $length) return true;
			
			if (!empty($args['params']['wordwrap']) && $args['params']['wordwrap'] === 'false') {
				$args['value'] = substr($args['value'], 0, $length) . $trailer;
			} else {
				$array = explode("<ibr>", wordwrap($args['value'], $length, "<ibr>"));
				$args['value'] = $array[0] . $trailer;
				unset($array);
			}

			return true;
		}

		function & modifier_htmlSpecialCharsDecode(&$args)
		{
			$args['value'] = strtr($args['value'], array_flip(get_html_translation_table(HTML_SPECIALCHARS)));

			return true;
		}

		function & modifier_decodeURIcomponent(&$args)
		{
			$args['value'] = urldecode($args['value']);
			iParamModifier::modifier_htmlSpecialCharsDecode($args);

			return true;
		}

		function & modifier_decodeURIcomponentArray(&$args)
		{
			iParamModifier::modifier_decodeURIcomponent($args);
			parse_str($args['value'], $args['value']);

			return true;
		}

		function & modifier_explode(&$args)
		{
			if (empty($args['value'])) $args['value'] = array();
			else if (!strpos($args['value'], $args['params']['separator'])) $args['value'] = array($args['value']);
			else {
				$args['value'] = explode($args['params']['separator'], $args['value']);
				foreach ($args['value'] as $key => $val) {
					$args['value'][$key] = trim($val);
					if (empty($args['value'][$key])) unset($args['value'][$key]);
				}
			}

			return true;
		}

	}
?>
