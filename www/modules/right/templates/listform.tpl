{capture assign=delete_url}{iURL module=right action=delete}{/capture}
{capture assign=new_url}{iURL module=right action=addform}{/capture}
{capture assign=area_url}{iURL module=right action=listareaform}{/capture}

<div id="menu">
	{iScheme name=button  id="delete_selected" title="Usuń wybrane" link=$delete_url image="/www/images/admin/trash.png"}
	{/iScheme}
	{iScheme name=button title="Nowe uprawnienie" link=$new_url image="/www/images/admin/addedit.png"}
	{/iScheme}
	{iScheme name=button title="Obszary uprawnień" link=$area_url image="/www/images/admin/module.png"}
	{/iScheme}
</div>

{iScheme name=xtable id=table}
	{iScheme name=xtable_header}
		<td>{iInput type=checkbox}</td>
		<td id="right_list_area">Obszar</td>
		<td id="right_list_name">Nazwa</td>
		<td>Opis</td>
		<td>Akcje</td>	{/iScheme}
	{iScheme name=xtable_body}
		{section name=i loop=$rights}
		<tr>
			<td>{iInput type=checkbox value=$rights[i].right_id}</td>
			<td><a href="{iURL module=$iModuleName action=editareaform id=$rights[i].areas[0].area_id}">{$rights[i].areas[0].area_define_name}</a></td>
			<td><a href="{iURL module=$iModuleName action=editform id=$rights[i].right_id}">{$rights[i].right_define_name}</a></td>
			<td>{$rights[i].right_description}</td>
			<td>
				<a href="{iURL module=$iModuleName action=editform id=$rights[i].right_id}">Edytuj</a> |
				<a href="{iURL module=$iModuleName action=delete id=$rights[i].right_id}">Usuń</a>
			</td>
		</tr>
		{/section}
	{/iScheme}
{/iScheme}
