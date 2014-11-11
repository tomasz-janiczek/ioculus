{capture assign=delete_url}{iURL module=right action=deletegroupright gid=$group.group_id}{/capture}
{capture assign=new_url}{iURL module=right action=addgrouprightform gid=$group.group_id}{/capture}

{iScheme name=adminpage1 title="Uprawnienia / "|cat:$group.group_define_name image="/www/images/admin/user.png" buttons="new $new_url,delete $delete_url true true rid,cancel"}
		<tr>
			<td>{iInput type=checkbox}</td>
			<td>Nazwa</td>
			<td>Obszar</td>
			<td>Opis</td>
		</tr>
		{if !$rights}
		<tr><td colspan="0">Grupie nie przydzielono jeszcze żadnych uprawnień</td></tr>
		{else}
		{section name="i" loop=$rights}
		<tr>
			<td>{iInput type=checkbox value=$rights[i].right_id}</td>
			<td><a href="{iURL module=right action=details id=$rights[i].right_id}">{$rights[i].right_define_name}</a></td>
			<td>{$rights[i].area_define_name}</td>
			<td>{$rights[i].right_description}</td>
		</tr>
		{/section}
		{/if}
{/iScheme}
