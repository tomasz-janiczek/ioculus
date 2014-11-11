{if $iActionName == addform}
	{assign var=title value="Nowy użytkownik"}
{else}
	{assign var=title value="Edycja użytkownika"}
{/if}

{iScheme name=boxlight3 title=$title id=container}
	{iScheme name=form action=$action}
		{iScheme name=form_section}
		{if $iActionName == addform}
			{iScheme name=form_field fieldName=type type=select label=Typ}
				{html_options options=$types selected=$user.perm_type|default:1}
			</select>
			{/iScheme}
			{iScheme name=form_field fieldName=handle type=text label=Login maxlength=32}
			{/iScheme}
		{/if}
			{iScheme name=form_field fieldName=passwd type=password label=Hasło maxlength=32}
			{/iScheme}
			{iScheme name=form_field fieldName=passwd_confirm type=password label="Powtórz hasło" maxlength=32}
			{/iScheme}
			{iScheme name=form_field fieldName=email type=text label="E-Mail" maxlength=32 value=$user.email maxlength=64}
			{/iScheme}
		{/iScheme}

		{iScheme name=form_section}
			{iScheme name=form_buttons}
			{/iScheme}
		{/iScheme}
	{/iScheme}
{/iScheme}
