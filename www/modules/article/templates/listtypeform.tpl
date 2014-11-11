{capture assign=delete_url}{iURL module=article action=deletetype}{/capture}
{capture assign=new_url}{iURL module=article action=addtypeform}{/capture}

{iScheme name=adminmenubar title="Typy sekcji" image="/www/images/admin/sections.png" buttons="new $new_url,delete $delete_url true true,cancel"}
{/iScheme}

{iScheme name=xtable}
	{iScheme name=xtable_header}
		<td>{iInput type=checkbox}</td>
		<td>Nazwa</td>
		<td>Opis</td>
		<td>Akcje</td>
	{/iScheme}
	{iScheme name=xtable_body}
	{section name=i loop=$list}
	<tr>
		<td>{iInput type=checkbox value=$list[i].id}</td>
		<td><a href="{iURL module=$iModuleName action=edittypeform id=$list[i].id}">{$list[i].name|truncate:100}</a></td>
		<td>{$list[i].description|truncate:60}</td>
		<td>
			<a href="{iURL module=$iModuleName action="editform" id=$list[i].id}">Edytuj</a> |
			<a href="{iURL module=$iModuleName action="delete" id=$list[i].id}">Usuń</a>
		</td>
	</tr>
	{/section}
	{/iScheme}
{/iScheme}
