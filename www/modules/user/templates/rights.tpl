{iScheme name="admin"}
	<a class="menu" href="{iURL module=$iModuleName action="addrightform" id=$user.perm_user_id}">[ Dodaj prawo ]</a>
	<p class="paginate">Prawa {$paginate.first}-{$paginate.last} z wszystkich {$paginate.total}</p>
	<table id="rightsTable">
		<tr>
			<th>Obszar</th>
			<th>Prawo</th>
			<th>Akcje</th>
		</tr>
		{if !$rights}
			<tr><td colspan="3">Ten użytkownik nie posiada żadnych praw</td></tr>
		{else}
		{section name="userRightsList" loop=$rights}
		<tr>
			<td><a href="{iURL module="right" action="editareaform" id=$rights[userRightsList].area_id}">{$rights[userRightsList].area_define_name}</a></td>
			<td><a href="{iURL module="right" action="editform" id=$rights[userRightsList].right_id}">{$rights[userRightsList].right_define_name}</a></td>
			<td><a href="{iURL module=$iModuleName action="deleteright" id=$user.perm_user_id rightid=$rights[userRightsList].right_id}">Usuń</a></td>
		</tr>
		{/section}
		{/if}
	</table>
	<p class="paginate">{paginate_prev id=$id text="Poprzednie"} {paginate_middle id=$id} {paginate_next id=$id text="Następne"}</p>
{/iScheme}