{if $iActionName == addform}
	{assign var=title value="Nowe uprawnienie"}
{else}
	{assign var=title value="Edycja uprawnienia"}
{/if}

{iScheme name=boxlight3 title=$title id=container}
	{iScheme name=form action=$action}
		{iScheme name=form_section}
			{iScheme name=form_field fieldName=name label=Nazwa value=$right.right_define_name maxlength=32}
			{/iScheme}
			{iScheme name=form_field type=text fieldName=description label=Opis value=$right.right_description maxlength=255}
			{/iScheme}
			{iScheme name=form_field type=labeledText label=Obszar}
				{iInput type=select name=areaid}
					{html_options options=$areas selected=$selected}
				</select>
			{/iScheme}
		{/iScheme}

		{iScheme name=form_section}
			{iScheme name=form_buttons}
			{/iScheme}
		{/iScheme}
	{/iScheme}
{/iScheme}
