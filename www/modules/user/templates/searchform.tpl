{iScheme name="admin"}
	<form method="post" action="{$action}">
		{html_center type="horizontal"}
		<br/>
		{iInput type="text" label="Login" name="handle" value=$user.handle}
		<br/>
		{iInput type="select" label="Grupa" name="group"}
		{html_options options=$groups selected=$selectedGroup}
		</select>
		<br/>
		{iInput type="submit" value="Szukaj"}
		{/html_center}
	</form>
{/iScheme}
