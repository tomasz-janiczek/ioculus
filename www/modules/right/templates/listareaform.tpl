{capture assign=delete_url}{iURL module=right action=deletearea}{/capture}
{capture assign=new_url}{iURL module=right action=addareaform}{/capture}
{capture assign=edit_url}{iURL module=right action=editareaform}{/capture}

<div id="menu">
	{iScheme name=button  id="delete_selected" title="Usuń wybrane" link=$delete_url image="/www/images/admin/trash.png"}
	{/iScheme}
	{iScheme name=button title="Nowy obszar" link=$new_url image="/www/images/admin/addedit.png"}
	{/iScheme}
</div>

{iScheme name=xtable id=table}
	{iScheme name=xtable_header}
		<td>{iInput type=checkbox}</td>
		<td id="right_listarea_name">Nazwa</td>
		<td>Opis</td>
		<td>Akcje</td>	{/iScheme}
	{iScheme name=xtable_body}
		{section name=i loop=$areas}
		<tr>
			<td>{iInput type=checkbox value=$areas[i].area_id}</td>
			<td><a href="{iURL module=$iModuleName action=editareaform id=$areas[i].area_id}">{$areas[i].area_define_name}</a></td>
			<td>{$areas[i].area_description}</td>
			<td>
				<a href="{iURL module=$iModuleName action=editareaform id=$areas[i].area_id}">Edytuj</a> |
				<a href="{iURL module=$iModuleName action=deletearea id=$areas[i].area_id}">Usuń</a>
			</td>
		</tr>
		{/section}
	{/iScheme}
{/iScheme}
