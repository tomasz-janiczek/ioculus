<?php

	define('IERROR_CLASS',				'iError');
	define('IERROR_DEFAULT_LANG',		'pl');

	define('IERROR_UNKNOWN',			$ERR = -1);
	define('IERROR_NOT_FOUND',			$ERR--);
	define('IERROR_PARAMS',			$ERR--);
	define('IERROR_UNSUPPORTED',		$ERR--);
	define('IERROR_EXISTS',				$ERR--);
	define('IERROR_MOD_NOT_FOUND',	$ERR--);
	define('IERROR_MOD_LOAD',			$ERR--);
	define('IERROR_MOD_CLASS',			$ERR--);
	define('IERROR_MOD_ACTIONS',		$ERR--);
	define('IERROR_MOD_DESCENDANT',	$ERR--);
	define('IERROR_MOD_NO_ACTIONS',	$ERR--);
	define('IERROR_FILE',				$ERR--);
	define('IERROR_FILE_EXISTS',			$ERR--);
	define('IERROR_FILE_NOT_FOUND',	$ERR--);
	define('IERROR_FILE_CREATE',		$ERR--);
	define('IERROR_FILE_WRITE',			$ERR--);
	define('IERROR_FILE_DELETE',		$ERR--);
	define('IERROR_ACCESS',			$ERR--);
	define('IERROR_NO_TEMPLATE',		$ERR--);
	define('IERROR_LOGIN',				$ERR--);
	define('IERROR_CONFIG',			$ERR--);
	define('IERROR_MOD_SOURCE',		$ERR--);
	define('IERROR_NODATA',			$ERR--);
	define('IERROR_VALIDATOR_EXISTS',	$ERR--);
	define('IERROR_DB_QUERY',			$ERR--);
	define('IERROR_DB_DELETE',			$ERR--);
	define('IERROR_DB_INSERT',			$ERR--);
	define('IERROR_DB_UPDATE',			$ERR--);
	define('IERROR_MOD_EXISTS',		$ERR--);
	define('IERROR_ACT_EXISTS',			$ERR--);
	define('IERROR_XML_LOAD',			$ERR--);
	define('IERROR_UPLOAD',			$ERR--);
	define('IERROR_UPLOAD_SIZE',		$ERR--);
	define('IERROR_UPLOAD_TYPE',		$ERR--);

	class iError extends PEAR_Error
	{		
		var $_messages = array(
			IERROR_UNKNOWN => array(
				'pl' => 'Nieznany błąd',
				'en' => 'Unknown error'
			),
			IERROR_NOT_FOUND => array(
				'pl' => 'Nie znaleziono żadnych danych odpowiadających podanemu kryterium',
				'en' => 'No data matching the given criteria found'
			),
			IERROR_PARAMS => array(
				'pl' => 'Wadliwe parametry',
				'en' => 'Invalid parameters'
			),
			IERROR_UNSUPPORTED => array(
				'pl' => 'Funkcja niezaimplementowana',
				'en' => 'Function not implemented'
			),
			IERROR_EXISTS => array(
				'en' => "Such a record already exists",
				'pl' => 'Taki wpis już istnieje'
			),			
			IERROR_CONFIG => array(
				'en' => 'Configuration is not valid',
				'pl' => 'Konfiguracja zawiera niewłaściwe parametry',
			),
			IERROR_MOD_NOT_FOUND => array(
				'en' => 'Module not found',
				'pl' => 'Moduł nie został odnaleziony',
			),
			IERROR_MOD_SOURCE => array(
				'en' => 'Invalid module source file',
				'pl' => 'Wadliwy plik źródłowy modułu'
			),
			IERROR_MOD_LOAD => array(
				'en' => 'An error occured while loading module %mod%',
				'pl' => 'Wystąpił błąd przy ładowaniu modułu'
			),
			IERROR_MOD_CLASS => array(
				'en' => 'Module %mod% is of wrong class (%class%), or is not an object at all',
				'pl' => 'Moduł jest obiektem złej klasy, lub nie jest w ogóle obiektem'
			),
			IERROR_MOD_DESCENDANT => array(
				'en' => 'Module %mod% is not a descendant of the class %class%',
				'pl' => 'Moduł nie jest wymaganą klasą pochodną'
			),
			IERROR_MOD_ACTIONS => array(
				'en' => 'Module %mod% actions array has invalid format',
				'pl' => 'Akcja modułu ma niewłaściwy format'
			),
			IERROR_MOD_NO_ACTIONS => array(
				'en' => 'Module %mod% has not definied any actions and can not be loaded',
				'pl' => 'Moduł nie zdefiniował żadnych akcji'
			),
			IERROR_FILE => array(
				'en' => 'Input / output error: %msg%',
				'pl' => 'Błąd wejścia / wyjścia'
			),
			IERROR_FILE_EXISTS => array(
				'en' => "File already exists",
				'pl' => 'Plik już istnieje'
			),
			IERROR_FILE_NOT_FOUND => array(
				'en' => "File doesn't exist",
				'pl' => 'Plik nie istnieje'
			),
			IERROR_FILE_CREATE => array(
				'en' => "Couldn't create a file",
				'pl' => 'Nie można utworzyć pliku'
			),
			IERROR_FILE_WRITE => array(
				'en' => "Couldn't write to a file",
				'pl' => 'Nie można zapisać danych w pliku'
			),
			IERROR_FILE_DELETE => array(
				'en' => "Couldn't delete a file",
				'pl' => 'Nie można usunąć pliku'
			),
			IERROR_ACCESS => array(
				'en' => 'Access denied',
				'pl' => 'Nie posiadasz uprawnień do tego obszaru',
			),
			IERROR_NO_TEMPLATE => array(
				'en' => 'A template for this action does not exist',
				'pl' => 'Szablon dla tej akcji nie istnieje',
			),
			IERROR_LOGIN => array(
				'en' => 'Login failed',
				'pl' => 'Logowanie nieudane',
			),
			IERROR_UNSUPPORTED => array(
				'en' => 'This option is not supported',
				'pl' => 'Ta opcja nie jest zaimplementowana',
			),
			IERROR_NODATA => array(
				'en' => 'No data matching this criteria exists',
				'pl' => 'Dane pasujące do podanego kryterium nie istnieją',
			),
			IERROR_VALIDATOR_EXISTS => array(
				'en' => 'A validator with this name already exists',
				'pl' => 'Walidator o tej nazwie już istnieje',
			),
			IERROR_DB_QUERY => array(
				'en' => 'Database query returned no results',
				'pl' => 'Zapytanie do bazy danych nie zwróciło żadnych informacji',
			),
			IERROR_DB_DELETE => array(
				'en' => 'Could not delete data from database',
				'pl' => 'Nie udało się usunąć informacji z bazy danych',
			),
			IERROR_DB_INSERT => array(
				'en' => 'Could not insert data into database',
				'pl' => 'Nie udało się wprowadzić informacji do bazy danych',
			),
			IERROR_DB_UPDATE => array(
				'en' => 'Could not update data in the database',
				'pl' => 'Nie udało się zmodyfikować informacji w bazie danych',
			),
			IERROR_MOD_EXISTS => array(
				'en' => 'Module %mod% has been already loaded',
				'pl' => 'Moduł jest już załadowany'
			),
			IERROR_ACT_EXISTS => array(
				'en' => 'Action has been already loaded',
				'pl' => 'Akcja jest już załadowany'
			),
			IERROR_XML_LOAD => array(
				'en' => 'An error occured while loading a XML file',
				'pl' => 'Wystąpił błąd podczas ładowania pliku XML'
			),
			IERROR_UPLOAD => array(
				'en' => 'An error occured while uploading a file',
				'pl' => 'Wystąpił błąd podczas przesyłania pliku'
			),
			IERROR_UPLOAD_SIZE => array(
				'en' => 'The uploaded file has a invalid size',
				'pl' => 'Przesłany plik posiada niewłaściwy rozmiar'
			),
			IERROR_UPLOAD_TYPE => array(
				'en' => 'The uploaded file is of invalid type',
				'pl' => 'Przesłany plik posiada niewłaściwy format'
			),

		);

		function getMessage($lang = IERROR_DEFAULT_LANG)
		{
			$msg = parent::getMessage();			
			if (!empty($msg))	return $msg;

			$code = parent::getCode();
			
			if (isset($this->_messages[$code])) {
				if (isset($this->_messages[$code][$lang])) return $this->_messages[$code][$lang];
				else if (isset($this->_messages[$code]['en'])) return $this->_messages[$code]['en'];
				else return "Undescribed error code {$code}";
			} else return $this->_messages[IERROR_UNKNOWN]['en'];
		}		
	}
?>
