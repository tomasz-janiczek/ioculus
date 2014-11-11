{if !$rights}
	<div>Brak uprawnień możliwych do przydzielenia</div>
{else}
	{section name=i loop=$rights}
		<div title="{$rights[i].right_id}" id="right_{$rights[i].right_id}" class="right_list_block_item">
			{html_image file="$iImageDir/lock.gif"}
			{$rights[i].right_define_name}
			<div>{$rights[i].right_description}</div>
		</div>
	{/section}
{/if}
