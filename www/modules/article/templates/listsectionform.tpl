{capture assign=delete_url}{iURL module=article action=deletesection}{/capture}
{capture assign=new_url}{iURL module=article action=addsectionform}{/capture}

<div id="menu">
	{iScheme name=button  id="delete_selected" title="Usuń wybrane" link=$delete_url image="/www/images/admin/trash.png"}
	{/iScheme}
	{iScheme name=button title="Nowa sekcja" link=$new_url image="/www/images/admin/addedit.png"}
	{/iScheme}
	<div id="select">
		{iInput type=select name=types label="Typ sekcji" id=types}
			{html_options options=$types selected=$type_selected}
		</select>
	</div>
</div>

{iScheme name=xtable}
	{iScheme name=xtable_header}
		<td>{iInput type=checkbox}</td>
		<td>Nazwa</td>
		<td>Typ</td>
		<td>Opis</td>
		<td>Akcje</td>
	{/iScheme}
	{iScheme name=xtable_body}
	{section name=i loop=$list}
	<tr>
		<td>{iInput type=checkbox value=$list[i].id}</td>
		<td><a href="{iURL module=$iModuleName action=listform id=$list[i].id}">{$list[i].name|truncate:100}</a></td>
		<td>
			<a href="{iURL module=$iModuleName action=edittypeform id=$list[i].type_id}">{$list[i].type_description|default:$list[i].type_name|default:"Nieznany"}</a>
		</td>
		<td>{$list[i].description|truncate:60}</td>
		<td>
			<a href="{iURL module=$iModuleName action=listform id=$list[i].id}">Artykuły</a> |
			<a href="{iURL module=$iModuleName action=editsectionform id=$list[i].id}">Edytuj</a> |
			<a href="{iURL module=$iModuleName action=delete id=$list[i].id}">Usuń</a>
		</td>
	</tr>
	{/section}
	{/iScheme}
{/iScheme}