{capture assign=delete_url}{iURL module=user action=delete}{/capture}
{capture assign=new_url}{iURL module=user action=addform}{/capture}

<div id="menu">
	{iScheme name=button  id="delete_selected" title="Usuń wybranych" link=$delete_url image="/www/images/admin/trash.png"}
	{/iScheme}
	{iScheme name=button title="Nowy użytkownik" link=$new_url image="/www/images/admin/addedit.png"}
	{/iScheme}
</div>

{iScheme name=xtable id=table}
	{iScheme name=xtable_header}
		<td>{iInput type=checkbox}</td>
		<td id="user_list_handle">Login</td>
		<td id="user_list_type">Rodzaj</td>
		<td>Status</td>
		<td>Ostatnie logowanie</td>
		<td>Akcje</td>	{/iScheme}
	{iScheme name=xtable_body}
		{section name=i loop=$users}
		<tr>
			<td>{iInput type=checkbox value=$users[i].perm_user_id}</td>
			<td><b><a href="{iURL module=$iModuleName action=editform id=$users[i].perm_user_id}">{$users[i].handle}</a></b></td>
			{assign var=typeIndex value=$users[i].perm_type|default:0}
			<td>{$types[$typeIndex]}</td>
			<td>{if $users[i].is_active}Aktywny{else}Nieaktywny{/if}</td>
			<td>{$users[i].lastlogin|date_format:"%d.%m.%Y"|default:"Nigdy"}</td>
			<td>
				{if !$users[i].is_active}<a href="{iURL module=$iModuleName action=activate id=$users[i].perm_user_id}">Aktywuj</a> |{/if}
				<a href="{iURL module=$iModuleName action=editform id=$users[i].perm_user_id}">Edytuj</a> |
				<a href="{iURL module=$iModuleName action=delete id=$users[i].perm_user_id}">Usuń</a>
			</td>
		</tr>
		{/section}
	{/iScheme}
{/iScheme}