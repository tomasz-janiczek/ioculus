{if $iActionName == addform}
	{assign var=title value="Nowa grupa"}
{else}
	{assign var=title value="Edycja grupy"}
{/if}

{iScheme name=boxlight3 title=$title id=container}
	{iScheme name=form action=$action}
		{iScheme name=form_section}
			{iScheme name=form_field type=text label="Nazwa grupy" fieldName=name value=$group.group_define_name maxlength=32}{/iScheme}
			{iScheme name=form_field type=labeledText label="Typ grupy" value=$group.group_type}
				{iInput type=select name=type}
					{html_options options=$group_types selected=$group.group_type}
				</select>
			{/iScheme}
			{iScheme name=form_field type=textarea fieldName=description label="Opis grupy" value=$group.group_description maxlength=255}{/iScheme}
		{/iScheme}

		{iScheme name=form_section}
			{iScheme name=form_buttons}
			{/iScheme}
		{/iScheme}
	{/iScheme}
{/iScheme}
