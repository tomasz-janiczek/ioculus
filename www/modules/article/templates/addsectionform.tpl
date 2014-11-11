{if $iActionName == "editform"}	{assign var=title value="Edycja sekcji"}
{else}
	{assign var=title value="Nowa sekcja"}
{/if}

{iScheme name=boxlight3 title=$title}
	{iScheme name=form action=$action}
		{iScheme name=form_section}
			{iScheme name=form_field type=select label=Typ fieldName=type}
				{html_options options=$types selected=$section.type}
			</select>
			{/iScheme}
			{iScheme name=form_field type=text label=Nazwa fieldName=name value=$section.name}
			{/iScheme}
			{iScheme name=form_field type=textarea label=Opis fieldName=description value=$section.description}
			{/iScheme}
		{/iScheme}

		{iScheme name=form_section}
			{iScheme name=form_buttons}
			{/iScheme}
		{/iScheme}
	{/iScheme}
{/iScheme}
