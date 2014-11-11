{capture assign=delete_url}{iURL module=article action=delete}{/capture}
{capture assign=new_url}{iURL module=article action=addform}{/capture}
{capture assign=edit_url}{iURL module=article action=editform}{/capture}

{iScheme name=adminpage1 title="Aktualności" image="/www/images/admin/addedit.png" buttons="new $new_url,edit $edit_url true,delete $delete_url,cancel"}
	<tr>
		<td>{iInput type=checkbox}</td>
		<td>Tytuł</td>
		<td>Autor</td>
		<td>Data</td>
	</tr>
	{if !$newses}
		<tr><td colspan="0">Nie istnieją żadne aktualności</td></tr>
	{else}
	{section name=i loop=$newses}
	<tr>
		<td>{iInput type=checkbox value=$newses[i].id}</td>
		<td><b><a href="{iURL module=$iModuleName action="editform" id=$newses[i].id}">{$newses[i].title}</a></b></td>
		<td>{$newses[i].handle}</td>
		<td>{$newses[i].date|date_format:"%d-%m-%Y"}</td>
	</tr>
	{/section}
	{/if}
{/iScheme}