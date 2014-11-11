	<tr>
		<td rowspan="4" class="scheme_content2_image">
			<div>
				{if $iScheme.attr.link}<a href="{$iScheme.attr.link}">{/if}
				{html_image file=$iScheme.attr.image|default:"/www/images/egie_logo.gif"}
				{if $iScheme.attr.link}</a>{/if}
			</div>
		</td>
		<td class="scheme_content2_title">
			{html_image file="/www/images/dot_grey.jpg"}
			{$iScheme.attr.title|default:"Wydarzenie"}
		</td>
		<td class="scheme_content2_date">
			{if $iScheme.attr.author}{$iScheme.attr.author}{/if}{if $iScheme.attr.date}, {$iScheme.attr.date}{/if}
		</td>
	</tr>
	<tr>
		<td class="scheme_content2_content" colspan="2">
			{$iScheme.attr.content}
		</td>
	</tr>
	<tr>
		<td colspan="3" class="scheme_content2_link">
			{if $iScheme.attr.link}
			<a href="{$iScheme.attr.link}">{html_image file="/www/images/read_more_blue.gif"}</a>
			{/if}
		</td>
	</tr>
	<tr>
		<td colspan="3" class="scheme_content2_menu">
		{if $iScheme.attr.menu}
		{section name=content2_i loop=$iScheme.attr.menu}
			{if $smarty.section.content2_i.index > 0} | {/if} <a href="{$iScheme.attr.menu[content2_i].link}">{$iScheme.attr.menu[content2_i].name}</a>
		{/section}
		{/if}
		</td>
	</tr>
