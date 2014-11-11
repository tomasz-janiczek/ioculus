<?php

	require_once('dispatcher.php');
	
	class iParamValidator extends iDispatcher
	{
		var $prefix = 'validator_';
		
		function & singleton()
		{
			static $instance = null;

			if (!$instance) $instance =& iParamValidator::factory();

			return $instance;
		}

		function & factory()
		{
			$obj =& new iParamValidator();
			return $obj;
		}
		
		function isInt(&$x)
		{
			return (is_numeric($x) ? intval(0 + $x) == $x : false);
		}
		
		function & validator_isInt(&$args)
		{
			if ($this->isInt($args['value'])) return true;
			else return $this->raiseError(null, IERROR_PARAMS);
		}

		function & validator_isNatural(&$args)
		{
		        if ($this->isInt($args['value']) && $args['value'] >= 0) return true;
			else return $this->raiseError(null, IERROR_PARAMS);
		}

		function & validator_isPositiveInt(&$args)
		{
		        if ($this->isInt($args['value']) && $args['value'] > 0) return true;
			else return $this->raiseError(null, IERROR_PARAMS);
		}

		function & validator_isNegativeInt(&$args)
		{
			if ($this->isInt($args['value']) && $args['value'] < 0) return true;
			else return $this->raiseError(null, IERROR_PARAMS);
		}

		function & validator_isZero(&$args)
		{
			if ($this->isInt($args['value']) && $args['value'] === 0) return true;
			else return $this->raiseError(null, IERROR_PARAMS);
		}

		function & validator_isId(&$args)
		{
			return $this->validator_isNatural($args);
		}

		function & validator_isEmpty(&$args)
		{
			if (mb_strlen($args['value'], 'utf-8') === 0) return true;
			else return $this->raiseError(null, IERROR_PARAMS);
		}

		function & validator_isNotEmpty(&$args)
		{
			if (mb_strlen($args['value'], 'utf-8') > 0) return true;
			else return $this->raiseError(null, IERROR_PARAMS);
		}

		function & validator_maxLength(&$args)
		{
			if (mb_strlen($args['value'], 'utf-8') > $args['params']['max']) return $this->raiseError(null, IERROR_PARAMS);
			else return true;
		}

		function & validator_inRange(&$args)
		{
			if ($args['value'] >= $args['params']['min'] && $args['value'] <= $args['params']['max']) return true;
			else return $this->raiseError(null, IERROR_PARAMS);
		}

		function & validator_inLengthRange(&$args)
		{
			if (mb_strlen($args['value'], 'utf-8') >= (int) $args['params']['min'] &&
				mb_strlen($args['value'], 'utf-8') <= (int) $args['params']['max'])
				return true;
			else
				return $this->raiseError(null, IERROR_PARAMS);
		}
		
		function & validator_isMailAddress(&$args)
		{
			require_once('Validate.php');
			
			if (Validate::email($args['value'])) return true;
	         	else return $this->raiseError(null, IERROR_PARAMS);
		} 

		function & validator_isPhoneNumber(&$args)
		{
			require_once('Validate.php');
		
			if (Validate::string($args['value'], array('format' => VALIDATE_NUM.VALIDATE_SPACE.'\+\-\(\)'))) return true;
	         	else return $this->raiseError(null, IERROR_PARAMS);
		} 

		function & validator_isName(&$args)
		{
//			if (Validate::string($args['value'], array('format' => VALIDATE_EALPHA.VALIDATE_SPACE."'")))
				return true;
//         	else return $this->raiseError(null, IERROR_PARAMS);
		} 

		function & validator_isNIP(&$args)
		{
			require_once('Validate/PL.php');
			
			if (Validate_PL::nip($args['value'])) return true;
	         	else return $this->raiseError(null, IERROR_PARAMS);
		} 

		function & validator_isPassword(&$args)
		{
			$value = iconv('UTF-8', 'ISO-8859-2', $args['value']);
			if (preg_match('/^[A-Za-z]\w{5,}$/', $value)) return true;
	         	else return $this->raiseError(null, IERROR_PARAMS);
		} 		

		function & validator_isHandle(&$args)
		{
			$value = iconv('UTF-8', 'ISO-8859-2', $args['value']);
			if (preg_match('/^[A-Za-z][\w\.]{2,}$/', $value)) return true;
	         	else return $this->raiseError(null, IERROR_PARAMS);
		} 		
	}
?>
