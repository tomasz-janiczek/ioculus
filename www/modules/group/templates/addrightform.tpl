{iScheme name=admin}
	{iScheme name=form}
		<form method="post" action="{iURL module=$iModuleName action=addright gid=$group.group_id}">
			{iInput type=select name=rid label=Prawo}
				{html_options options=$rights}
			</select>
			{iInput type=image src="/www/images/button_add.gif" id=buttonSubmit}
		</form>
	{/iScheme}
{/iScheme}
