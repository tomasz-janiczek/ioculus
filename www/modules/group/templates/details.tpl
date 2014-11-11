{capture assign=delete_url}{iURL module=group action=deletegroupuser gid=$group.group_id}{/capture}
{capture assign=new_url}{iURL module=group action=addgroupuserform gid=$group.group_id}{/capture}
{capture assign=rights_url}{iURL module=right action=addgrouprightform id=$group.group_id}{/capture}

{iScheme name=adminpage1 title="Grupy / "|cat:$group.group_define_name image="/www/images/admin/user.png" buttons="new $new_url,delete $delete_url true true,rights $rights_url,cancel"}
		<tr>
			<td>{iInput type=checkbox}</td>
			<td>Użytkownik</td>
		</tr>
		{if !$members}
		<tr><td colspan="0">Grupa jest pusta</td></tr>
		{else}
		{foreach from=$members item=member}
		<tr>
			<td>{iInput type=checkbox value=$member.perm_user_id}</td>
			<td>{$member.handle}</td>
		</tr>
		{/foreach}
		{/if}
{/iScheme}
