{capture assign=new_url}{iURL module=$iModuleName action=addform}{/capture}
{capture assign=cache_all_url}{iURL module=$iModuleName action=cacheall}{/capture}
{capture assign=uncache_all_url}{iURL module=$iModuleName action=uncacheall}{/capture}

<div id="menu">
	{iScheme name=button title="Nowy moduł" link=$new_url image="/www/images/admin/sections.png"}
	{/iScheme}
	{iScheme name=button title="Wszystkie do pamięci" link=$cache_all_url image="/www/images/admin/module.png" id=cacheall}
	{/iScheme}
	{iScheme name=button title="Wszystkie z pamięci" link=$uncache_all_url image="/www/images/admin/module.png" id=uncacheall}
	{/iScheme}
</div>

{iScheme name=xtable id=table}
	{iScheme name=xtable_header}
		<td>{iInput type=checkbox}</td>		
		<td>Nazwa</td>
		<td>W pamięci podręcznej</td>
		<td>Akcje</td>	{/iScheme}
	{iScheme name=xtable_body}
		{section name=i loop=$modules}
		<tr>
			<td>{iInput type=checkbox value=$modules[i].name}</td>
			<td class="name"><a href="{iURL module=$iModuleName action=detailsform name=$modules[i].name}">{$modules[i].name}</a></td>
			<td class="cache">{if $modules[i].cached}<span>Tak</span>{else}Nie{/if}</td>
			<td>
				{if !$modules[i].cached}
					<a href="{iURL module=$iModuleName action=cache name=$modules[i].name}">Do pamięci</a> |
				{else}
					<a href="{iURL module=$iModuleName action=uncache name=$modules[i].name}">Z pamięci</a> |
				{/if}
				<a href="{iURL module=$iModuleName action=detailsform name=$modules[i].name}">Detale</a>
			</td>
		</tr>
		{/section}
	{/iScheme}
{/iScheme}
