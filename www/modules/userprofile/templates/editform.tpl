{assign var=fullname value=$prefs.name|cat:" "|cat:$prefs.lastname|capitalize}

{iScheme name=tabpane}
	{iScheme name=tabpane_page title="Dane personalne"}
		{capture assign=url}{iURL module=$iModuleName action=edit id=$iArgs.id}{/capture}
		{iScheme name=form action=$url}
			{iScheme name=form_section}
				{iScheme name=form_field type=labeledText label="Login"}
					<b>{$prefs.handle}</b>
				{/iScheme}
			{/iScheme}

			{iScheme name=form_section}							
				{iScheme name=form_field fieldName=passwd type=password label="Hasło" maxlength=64}{/iScheme}
				{iScheme name=form_field fieldName=passwd_confirm type=password label="Potwierdź hasło" maxlength=64}{/iScheme}
			{/iScheme}

			{iScheme name=form_section}							
				{iScheme name=form_field fieldName=email type=text label="E-Mail" maxlength=64 value=$prefs.email}{/iScheme}
			{/iScheme}
	
			{iScheme name=form_section}							
				{iScheme name=form_field fieldName=name type=text label="Imię" maxlength=64 value=$prefs.name}{/iScheme}
				{iScheme name=form_field fieldName=lastname type=text label="Nazwisko" maxlength=64 value=$prefs.lastname}{/iScheme}
			{/iScheme}

			{iScheme name=form_section}							
				{iScheme name=form_field fieldName=position type=text label="Stanowisko" maxlength=64 value=$prefs.position}{/iScheme}
				{iScheme name=form_field fieldName=company type=text label="Firma / Gmina" maxlength=64 value=$prefs.company}{/iScheme}
				{iScheme name=form_field fieldName=nip type=text label="NIP" maxlength=64 value=$prefs.nip}{/iScheme}
				{iScheme name=form_field fieldName=address type=text label="Adres" maxlength=64 value=$prefs.address}{/iScheme}
				{iScheme name=form_field fieldName=location type=text label="Miejscowość" maxlength=64 value=$prefs.location}{/iScheme}
				{iScheme name=form_field fieldName=phone type=text label="Telefon" maxlength=64 value=$prefs.phone}{/iScheme}
			{/iScheme}

			{iScheme name=form_section}				
				{iScheme name=form_field_empty}
					{iInput type=image src="/www/images/button_edit.gif"}
				{/iScheme}			
			{/iScheme}
			
		{/iScheme}
	{/iScheme}
{/iScheme}
