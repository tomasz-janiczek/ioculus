{capture assign=action}{iURL module=$iModuleName action=create}{/capture}

{iScheme name=boxlight3 title="Nowy moduł"}
	{iScheme name=form action=$action}
		{iScheme name=form_section}
			{iScheme name=form_field type=text fieldName=name label=Nazwa maxlength=255 required=true}
			{/iScheme}
			{iScheme name=form_field type=text fieldName=author label="Autor" maxlength=255}
			{/iScheme}
			{iScheme name=form_field type=textarea fieldName=description label="Opis"}
			{/iScheme}
		{/iScheme}
		
		{iScheme name=form_section}
			{iScheme name=form_field type=text fieldName=actions label="Akcje" maxlength=255}
			{/iScheme}
		{/iScheme}

		{iScheme name=form_section}
			{iScheme name=form_buttons}
			{/iScheme}
		{/iScheme}
	{/iScheme}
{/iScheme}
