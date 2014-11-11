<tr><td>
	<p>{$iScheme.attr.description}</p>
	<ul>
	{section name=scheme_content9_i loop=$iScheme.attr.content max=$iScheme.attr.max|default:10}
		<li>
		<a href="javascript:sitePopUp('{$iScheme.attr.content[scheme_content9_i].link|default:"#"}')">
			{$iScheme.attr.content[scheme_content9_i].name|truncate:85}
		</a>
		</li>
	{/section}
	</ul>