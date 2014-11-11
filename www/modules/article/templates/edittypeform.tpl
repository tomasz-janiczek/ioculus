{if $iActionName == "edittypeform"}
	{assign var=title value="Edytuj typ sekcji"}
{else}
	{assign var=title value="Nowy typ sekcji"}
{/if}

{iScheme name=boxlight4 title=$title}
	{iScheme name=form action=$action}
		{iScheme name=form_section}
			{iScheme name=form_field type=text fieldName=name label=Nazwa value=$type.name maxlength=32}
			{/iScheme}
			{iScheme name=form_field type=textarea fieldName=description label=Opis value=$type.description maxlength=255}
			{/iScheme}
		{/iScheme}

		{iScheme name=form_section}
			{iScheme name=form_buttons}
			{/iScheme}
		{/iScheme}		
	{/iScheme}
{/iScheme}
