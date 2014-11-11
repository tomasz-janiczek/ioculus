<!--[if IE]>
<style>
table.scheme_content4 .scheme_content4_image2 {ldelim}
	vertical-align:		top;
	margin:				0;
	padding:			0;
{rdelim}

</style>
<![endif]-->		

<tr><td>
	<table>
		<tr>
			<td class="scheme_content4_image1">
				<a href="{$iScheme.attr.link|default:"#"}">{html_image file=$iScheme.attr.image|default:"/images/egie_logo.gif"}</a>
			</td>
			<td class="scheme_content4_image2{if $iScheme.attr.image2} scheme_content4_image2_img{/if}">
				{if $iScheme.attr.image2}
					<a href="{$iScheme.attr.link|default:"#"}">{html_image file=$iScheme.attr.image2}</a>
				{else}
					{if $iScheme.attr.array == true}
						<ul>
						{section name=scheme_content4_i loop=$iScheme.attr.description max=4}
							<li>{$iScheme.attr.description[scheme_content4_i]|truncate:18}</li>
						{/section}
						</ul>
					{else}
						{$iScheme.attr.description}
					{/if}
				{/if}
			</td>
		</tr>
		<tr>
			<td colspan="2" class="scheme_content4_content">
				{$iScheme.attr.content|truncate:115}
