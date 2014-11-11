<tr><td class="scheme_panel_td1">{$iScheme.attr.title|default:"Nawigacja"}</td></tr>
<tr><td class="scheme_panel_td2"></td></tr>
<tr><td class="scheme_panel_td3">

<div id="dhtmlgoodies_xpPane">
	{if $iScheme.attr.content}
	{foreach name=scheme_panel_chapters from=$iScheme.attr.content item=chapter}
	<div class="dhtmlgoodies_panel">
		<div>
			<ul>
			{foreach from=$chapter.articles item=item}
				<li>
					{capture assign=url}{iURL module=$iScheme.attr.module action=$iScheme.attr.action id=$item.id}{/capture}
					<a href="{if !$iScheme.attr.onclick}{$url}{else}javascript:{$iScheme.attr.onclick}('{$url}'){/if}">
						{$item.title|truncate:28}
					</a>
				</li>
			{/foreach}
			</ul>
		</div>  
	</div>
	{/foreach}
	{/if}
</div>

</td></tr>