{capture assign=delete_url}{iURL module=archive action=deleteitem}{/capture}
{capture assign=new_url}{iURL module=archive action=uploadform id=$iArgs.id}{/capture}
{capture assign=edit_url}{iURL module=archive action=edititemform}{/capture}

<div id="menu">
	{iScheme name=button  id="delete_selected" title="Usuń wybrane" link=$delete_url image="/www/images/admin/trash.png"}
	{/iScheme}
	{iScheme name=button title="Dodaj nowy plik" link=$new_url image="/www/images/admin/addedit.png"}
	{/iScheme}
</div>

{iScheme name=xtable id=table}
	{iScheme name=xtable_header}
		<td>{iInput type=checkbox}</td>
		<td>Nazwa</td>
		<td>Rozmiar</td>
		<td>Nazwa pliku</td>
		<td>Akcje</td>	{/iScheme}
	{iScheme name=xtable_body}
		{section name=i loop=$list}
		<tr>
			<td>{iInput type=checkbox value=$list[i].filename}</td>
			<td>{$list[i].name}</td>
			<td>{$list[i].size}</td>
			<td><a href="{iURL module=$iModuleName action=download id=$list[i].filename}" alt="{$list[i].filename}">{$list[i].filename}</a></td>
			<td>
				<a href="{iURL module=$iModuleName action=deleteitem id=$list[i].filename}">Usuń</a>
			</td>
		</tr>
		{/section}
	{/iScheme}
{/iScheme}
