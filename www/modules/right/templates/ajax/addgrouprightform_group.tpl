{if !$group_rights}
	<div>Nie przydzielono jeszcze żadnych uprawnień</div>
{else}
	{section name=i loop=$group_rights}
		<div title="{$group_rights[i].right_id}" id="right_{$group_rights[i].right_id}" class="right_list_block_item">
			{html_image file="$iImageDir/lock.gif"}
			{$group_rights[i].right_define_name}
			<div>{$group_rights[i].right_description}</div>
		</div>
	{/section}
{/if}
