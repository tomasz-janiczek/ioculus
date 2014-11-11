<tr>
	<td class="scheme_adminmenubar_title">
		{iScheme name=title title=$iScheme.attr.title image=$iScheme.attr.image}
		{/iScheme}
	</td>
	{if $iScheme.attr.buttons}
	<td class="scheme_adminmenubar_menu">
		{iScheme name=menu buttons=$iScheme.attr.buttons}
		{/iScheme}
	</td>
	{/if}
</tr>
