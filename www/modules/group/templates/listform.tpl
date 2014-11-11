{capture assign=delete_url}{iURL module=group action=delete}{/capture}
{capture assign=new_url}{iURL module=group action=addform}{/capture}
{capture assign=edit_url}{iURL module=group action=editform}{/capture}

<div id="menu">
	{iScheme name=button  id="delete_selected" title="Usuń wybrane" link=$delete_url image="/www/images/admin/trash.png"}
	{/iScheme}
	{iScheme name=button title="Nowa grupa" link=$new_url image="/www/images/admin/addedit.png"}
	{/iScheme}
</div>

{iScheme name=xtable id=table}
	{iScheme name=xtable_header}
		<td>{iInput type=checkbox}</td>
		<td>Nazwa</td>
		<td>Typ</td>
		<td>Opis</td>
		<td>Akcje</td>	{/iScheme}
	{iScheme name=xtable_body}
		{section name=i loop=$groups}
		<tr>
			<td>{iInput type=checkbox value=$groups[i].group_id}</td>
			<td><b><a href="{iURL module=$iModuleName action=details id=$groups[i].group_id}">{$groups[i].group_define_name}</a></b></td>
			<td>{$groups[i].group_type_name}</td>
			<td>{$groups[i].group_description}</td>
			<td>
				<a href="{iURL module=$iModuleName action=editform id=$groups[i].group_id}">Edytuj</a> |
				<a href="{iURL module=$iModuleName action=delete id=$groups[i].group_id}">Usuń</a>
			</td>
		</tr>
		{/section}
	{/iScheme}
{/iScheme}
