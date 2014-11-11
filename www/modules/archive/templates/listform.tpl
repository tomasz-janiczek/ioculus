{capture assign=delete_url}{iURL module=$iModuleName action=delete}{/capture}
{capture assign=new_url}{iURL module=$iModuleName action=add}{/capture}
{capture assign=edit_url}{iURL module=$iModuleName action=editform}{/capture}

<div id="menu">
	{iScheme name=button  id="delete_selected" title="Usuń wybrane" link=$delete_url image="/www/images/admin/trash.png"}
	{/iScheme}
	{iScheme name=button title="Nowe archiwum" link=$new_url image="/www/images/admin/addedit.png"}
	{/iScheme}
</div>

{iScheme name=xtable id=table}
	{iScheme name=xtable_header}
		<td>{iInput type=checkbox}</td>
		<td>ID archiwum</td>
		<td>Rozmiar</td>
		<td>Elementów</td>
		<td>Swobodny dostęp</td>
		<td>Akcje</td>	{/iScheme}
	{iScheme name=xtable_body}
		{section name=i loop=$list}
		<tr>
			<td>{iInput type=checkbox value=$list[i].id}</td>
			<td><b><a href="{iURL module=$iModuleName action="listitemform" id=$list[i].id}">{$list[i].id}</a></b></td>
			<td>{$list[i].size}</td>
			<td>{$list[i].count}</td>
			<td><a href="{iURL module=$iModuleName action=switchlock id=$list[i].id}">{if $list[i].free_access}Tak{else}Nie{/if}</a></td>
			<td>
				<a href="{iURL module=$iModuleName action=delete id=$list[i].id}">Usuń</a> |
				<a href="{iURL module=$iModuleName action=listitemform id=$list[i].id}">Pliki</a>
			</td>
		</tr>
		{/section}
	{/iScheme}
{/iScheme}
