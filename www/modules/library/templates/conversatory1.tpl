{literal}
<!--[if IE]>
<style>
	#action #library_register td.scheme_boxyellow_td2 {
		padding-top:		15px;
	}	

	#action #library_register p {
		margin-bottom:		15px;
	}	
</style>
<![endif]-->
{/literal}

<table id="library_layout">
	<tr>
		<td id="library_col1">
			{iScheme name=panel id="library_nav" title="Nawigacja" module=$iModuleName action=conversatory1 content=$chapters}
			{/iScheme}

			{iScheme name=boxyellow title="Newsletter"}
				{iScheme name=content3}
					Chcesz być powiadamiany o nowych artykułach? Zapisz się na nasz newsletter!
				{/iScheme}
			{/iScheme}

			{iScheme name=boxsilver title="Ostatnio dodane" id="library_newest"}
				<ul>
					{foreach from=$newest item=title key=id}
					<li>
						<a href="{iURL module=$iModuleName action=conversatory2 id=$id}" title="{$title}">{$title}</a>
					</li>
					{/foreach}
				</ul>
			{/iScheme}
		</td>

		<td id="library_col2">
		</td>

		<td id="library_col3">
			{iScheme name=boxgreen title=$section.name class="conv_block" id="conv_section_desc"}
				{$section.description}
			{/iScheme}
			
			{section name=i loop=$articles}
			{iScheme name=boxlight4 noicon=true class="conv_block"}
				{capture assign=url}{iURL module=$iModuleName action=conversatory2 id=$articles[i].id}{/capture}
				{iScheme name=content2 title=$articles[i].title content=$articles[i].description image=$articles[i].image link=$url}
				{/iScheme}
			{/iScheme}
			{/section}

		</td>
	</tr>
</table>
