{iScheme name=admin}
	{iScheme name=menustandard empty=true}
		<td><a href="{iURL module=$iModuleName action=adduserrightform uid=$user.perm_user_id}">{html_image file="/www/images/icons/actions/gtk-add.png"}<div>Dodaj</div></a></td>
		<td><a href="javascript:scheme_multidelete_submit('right_listuser')">{html_image file="/www/images/icons/status/error.png"}<div>Usuń</div></a></td>
		<td><a href="javascript:iCheckbox_switchAll('right_listuser', true)">{html_image file="/www/images/icons/actions/document-new.png"}<div>Zaznacz<br/>wszystko</div></a></td>
		<td><a href="javascript:iCheckbox_switchAll('right_listuser', false)">{html_image file="/www/images/icons/actions/leftjust.png"}<div>Odznacz<br/>wszystko</div></a></td>
	{/iScheme}
		
	{capture assign=url}{iURL module=$iModuleName action=deleteuserright uid=$user.perm_user_id}{/capture}
	{iScheme name=multidelete field=rid action=$url}{/iScheme}

	{iScheme name=paginate pid=$id paginate=$paginate type=top}{/iScheme}

	{iScheme name=table}
		<table id="right_listuser">
		<tr>
			<th></th>
			<th>Nazwa</th>
			<th>Opis</th>
		</tr>
		{if !$rights}
		<tr><td colspan="3">Brak praw</td></tr>
		{else}
		{section name="i" loop=$rights}
		<tr>
			<td>{iInput type=checkbox value=$rights[i].right_id}</td>
			<td><a href="{iURL module=right action=details id=$rights[i].right_id}">{$rights[i].right_define_name}</a></td>
			<td>{$rights[i].right_description}</td>
		</tr>
		{/section}
		{/if}
		</table>
	{/iScheme}

	{iScheme name=paginate pid=$id type=bottom}{/iScheme}
	
	{iScheme name=buttonback}{/iScheme}
{/iScheme}