{iScheme name=admin}
	{iScheme name=form}
		<form method="post" action="{$action}">
			{iInput type=select name=uid label=Użytkownik}
				{html_options options=$users}
			</select>
			{iInput type=image src="/www/images/button_select.gif" id=buttonSubmit}
		</form>
	{/iScheme}
{/iScheme}
