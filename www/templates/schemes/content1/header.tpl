	<tr>
		<td class="scheme_content1_image{if $iScheme.attr.schemeName} scheme_{$iScheme.attr.schemeName}_image{/if}">
			{if $iScheme.attr.image}
				{if $iScheme.attr.link}<a href="{$iScheme.attr.link}">{/if}
				{html_image file=$iScheme.attr.image}{else}{html_image file="/www/images/egie_logo.gif"}
				{if $iScheme.attr.link}</a>{/if}
			{/if}
		</td>
		<td class="scheme_content1_body{if $iScheme.attr.schemeName} scheme_{$iScheme.attr.schemeName}_body{/if}">
			{if $iScheme.attr.content && $iScheme.attr.array == true}
			<ul>
			{section name=scheme_content1_i loop=$iScheme.attr.content}
				<li>{$iScheme.attr.content[scheme_content1_i]}</li>
			{/section}
			</ul>
			{elseif $iScheme.attr.content}
				{$iScheme.attr.content}
			{/if}
