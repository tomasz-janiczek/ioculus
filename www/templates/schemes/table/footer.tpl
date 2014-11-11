	<tr class="scheme_table_bottombar">
		<td colspan="0">
	{if $paginate && $paginate_id}
		{paginate_prev id=$paginate_id text="<<"} {paginate_middle id=$paginate_id format="page"} {paginate_next id=$paginate_id text=">>"} |
		Wyniki {$paginate.first} - {$paginate.last} z {$paginate.total} | Wyświetl # 
		{iInput type=select name=display_set_size}
		{section loop=55 step=5 start=10 name=display_set_size}
			<option value="{$smarty.section.display_set_size.index}">{$smarty.section.display_set_size.index}</option>
		{/section}
		</select>
	{/if}
		</td>
	</tr>
	{if $iScheme.attr.bottom}
	<tr class="scheme_table_bottom_menu">
		<td colspan="0">
			{$iScheme.attr.bottom}
		</td>
	</tr>
	{/if}
	</table>
	{capture assign=params}
		$H({ldelim}
			'select_cells' : {$iScheme.attr.selectCells|default:"true"}
		{rdelim})
	{/capture}
	<script language="javascript" type="text/javascript">scheme_table_init({$params});</script>
</td></tr>
