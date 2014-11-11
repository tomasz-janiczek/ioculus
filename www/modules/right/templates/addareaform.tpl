{if $iActionName == editareaform}
	{assign var=title value="Edycja obszaru"}
{else}
	{assign var=title value="Nowy obszar"}
{/if}

{iScheme name=boxlight3 title=$title}
	{iScheme name=form action=$action}
		{iScheme name=form_section}
			{iScheme name=form_field fieldName=name label=Nazwa value=$area.area_define_name maxlength=32}
			{/iScheme}
			{iScheme name=form_field fieldName=description label=Opis value=$area.area_description maxlength=255}
			{/iScheme}
		{/iScheme}
		{iScheme name=form_section}
			{iScheme name=form_buttons}
			{/iScheme}
		{/iScheme}
	{/iScheme}
{/iScheme}
