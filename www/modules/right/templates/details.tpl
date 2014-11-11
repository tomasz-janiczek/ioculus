{iScheme name="admin"}
	<br/>
	<table id="rightInfoTable">
		<tr>
			<th>Nazwa</th>
			<th>Opis</th>
		</tr>
		<tr>
			<td><a href="{iURL module=$iModuleName action="editform" id=$right.right_id}">{$right.right_define_name}</a></td>
			<td>{$right.right_description}</td>
		</tr>
	</table>
{/iScheme}
