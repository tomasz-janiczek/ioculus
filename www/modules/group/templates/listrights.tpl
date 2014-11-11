{capture assign=delete_url}{iURL module=group action=deleteright gid=$group.group_id}{/capture}
{capture assign=new_url}{iURL module=group action=addrightform gid=$group.group_id}{/capture}

{iScheme name=adminpage1 title="Uprawnienia grupy "|cat:$group.group_define_name" image="/www/images/admin/user.png" buttons="new $new_url,delete $delete_url,cancel"}
		<tr>
			<td>Nazwa</td>
			<td>Opis</td>
		</tr>
		{if !$rights}
		<tr><td colspan="0">Grupie nie przydzielono jeszcze żadnych uprawnień/td></tr>
		{else}
		{section name="i" loop=$rights}
		<tr>
			<td><a href="{iURL module=right action=details id=$rights[i].right_id}">{$rights[i].right_define_name}</a></td>
			<td>{$rights[i].right_description}</td>
		</tr>
		{/section}
		{/if}
{/iScheme}