{if !$prefs}
	{iScheme name="content5"}
	{/iScheme}
{else}
<table>
	<tr>
		<td colspan="2"><b>{$prefs.name} {$prefs.lastname}</b></td>
	</tr>
	<tr>
		<td>Telefon</td>
		<td>{$prefs.phone|default:"Niedostępny"}</td>
	</tr>
	<tr>
		<td>E-Mail</td>
		<td>{if $prefs.email}{mailto address=$prefs.email text=$prefs.email encode="hex"}{else}Niedostępny{/if}</td>
	</tr>
</table>
{/if}
