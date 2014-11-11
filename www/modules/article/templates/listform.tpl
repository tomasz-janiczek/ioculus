{capture assign=delete_url}{iURL module=article action=delete}{/capture}
{capture assign=new_url}{iURL module=article action=addform id=$iArgs.id}{/capture}

<div id="menu">
	{iScheme name=button  id="delete_selected" title="Usuń wybrane" link=$delete_url image="/www/images/admin/trash.png"}
	{/iScheme}
	{iScheme name=button title="Nowy artykuł" link=$new_url image="/www/images/admin/addedit.png"}
	{/iScheme}
</div>

{iScheme name=xtable id=table}
	{iScheme name=xtable_header}
		<td>{iInput type=checkbox}</td>
		<td>Tytuł</td>
		<td>Autor</td>
		<td>Data</td>
		<td>Autor modyfikacji</td>
		<td>Data modyfikacji</td>
		<td>Priorytet</td>
		<td>Akcje</td>
	{/iScheme}
	{iScheme name=xtable_body}
		{section name=i loop=$list}
		<tr>
			<td>{iInput type=checkbox value=$list[i].id}</td>
			<td><b><a href="{iURL module=$iModuleName action="editform" id=$list[i].id}">{$list[i].title|truncate:50}</a></b></td>
			<td>{$list[i].author_handle}</td>
			<td>{$list[i].date|date_format:"%d.%m.%Y"}</td>
			<td>{$list[i].mod_author_handle}</td>
			<td>{$list[i].mod_date|date_format:"%d.%m.%Y"}</td>
			<td>
				{iInput type=text name=priority id="priority_"|cat:$list[i].id class=priority value=$list[i].priority}
			</td>
			<td>
				<a href="{iURL module=$iModuleName action="editform" id=$list[i].id}">Edytuj</a> |
				<a href="{iURL module=$iModuleName action="delete" id=$list[i].id}">Usuń</a>
			</td>
		</tr>
		{/section}
	{/iScheme}
{/iScheme}
