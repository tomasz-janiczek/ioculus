{literal}
<!--[if IE]>
<style>
	#action #library_main_prev_table,
	#action #library_main_prev_table_pageshow {
		width:			92%;
	}
</style>
<![endif]-->
{/literal}

<table id="library_main">
	<tr>
		<td id="library_main_col1">
			{iScheme name=panel id=library_main_nav onclick="library_loadArticle" module=$iModuleName action=main content=$chapters}
			{/iScheme}
			
			{iScheme name=boxsilver title="Sieć e-GIE" id=library_main_bonus}
				<table>
				{section name=j loop=$egie_news max=4}
					{capture assign=link}javascript:library_loadArticle('{iURL module=$iModuleName action=main id=$egie_news[j].id}'){/capture}
					{math assign=idx equation="x + 1" x=$smarty.section.j.index}
					<tr>
						<td>{html_image file="/www/images/icon"|cat:"$idx"|cat:".gif"}</td>
						<td><a href="{$link}">{$egie_news[j].title|truncate:40}</a>
						</td>
					</tr>
				{/section}
				</table>
			{/iScheme}

			{iScheme name=boxyellow title="Newsletter" id="library_main_newsletter"}
				{iScheme name=content3}
					Chcesz być powiadamiany o nowych artykułach? Zapisz się na nasz newsletter!
				{/iScheme}
			{/iScheme}
		</td>

		<td id="library_main_col2">
		</td>

		<td id="library_main_col3">
			<span id="library_main_prev_container">
				{iIncludeTemplate file="/www/modules/library/templates/main_ajax.tpl"}
			</span>
									
			{iScheme name=bar text="Najnowsze artykuły" id="library_main_bar"}
			{/iScheme}

			{iScheme name=boxlight4 id=library_main_news notitle=true}
				{section name=i loop=$news}
					{capture assign=link}javascript:library_loadArticle('{iURL module=$iModuleName action=main id=$news[i].id}'){/capture}
					{iScheme name=content2 title=$news[i].title content=$news[i].description|truncate:300 image=$news[i].image link=$link date=$news[i].date|date_format:"%m-%d-%Y" author=$news[i]._users_handle}
					{/iScheme}
				{/section}
			{/iScheme}
		</td>
	</tr>
</table>
