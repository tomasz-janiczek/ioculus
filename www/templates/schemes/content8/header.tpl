<tr><td>
	<ul>
	{section name=scheme_content8_i loop=$iScheme.attr.content max=3}
		<li>
			<b>{$iScheme.attr.content[scheme_content8_i].name}</b> <i>(wkrótce)</i><br/>
			{$iScheme.attr.content[scheme_content8_i].description|truncate:95}
		</li>
	{/section}
	</ul>