		</td>
		<td class="scheme_content1_arrows{if $iScheme.attr.schemeName} scheme_{$iScheme.attr.schemeName}_arrows{/if}">
			{if $iScheme.attr.content}
			<ul>
			{section name=scheme_content1_i loop=$iScheme.attr.content}
				<li>{if $iScheme.attr.links}<a href="{$iScheme.attr.links[scheme_content1_i].content}">{/if}>>{if $iScheme.attr.links}</a>{/if}</li>
			{/section}
			</ul>
			{/if}
		</td>
	</tr>