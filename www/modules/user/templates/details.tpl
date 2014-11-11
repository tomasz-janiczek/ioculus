{iScheme name="admin"}
	<a class="menu" href="{iURL module=$iModuleName action="rights" id=$user.perm_user_id}">[ Prawa ]</a>
	<br/>
	<br/>
	<table id="userInfoTable">
	<tr>
		<th>Login</th>
		<th>E-Mail</th>
		<th>Grupa</th>
	</tr>
	<tr>
		<td>{$user.handle}</td>
		<td><a href="mailto: {$user.email}">{$user.email}</a></td>
		<td><a href="{iURL module="group" action="details" id=$user.group_id}">{$user.group_define_name}</a></td>
	</tr>
	</table>
{/iScheme}
