{iScheme name=admin}
		<form method="post" action="{$action}">
			{iInput type=select name=gid label=Grupa}
				{html_options options=$groups}
			</select>
			{iInput type=image src="/www/images/button_select.gif" id=buttonSubmit}
		</form>
{/iScheme}
