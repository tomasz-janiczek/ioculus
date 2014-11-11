		{if $pageid && !$pageContent}
			{iScheme name=boxlight4 id=library_main_prev noicon=true}
			<table id="library_main_prev_table_pageshow">
				<tr><td>
					{html_image file="/www/modules/library/images/logo_egie.jpg"}
					<p><b>Ta strona nie istnieje</b></p>
				</td></tr>
			</table>
			{/iScheme}
		{else}			
			{iScheme name=boxlight4 id=library_main_prev title=$prev_news.title}
			<table id="library_main_prev_table">
				<tr>
					{if $article_options}
					<td id="library_main_prev_date">
						{$prev_news.date|date_format:"%m-%d-%Y"}
					</td>
					<td id="library_main_prev_options">
						{iInput type=select name=library_main_prev_menu onchange="library_setOption(this)"}
							<option value="0">-- Opcje --</option>
							{html_options options=$article_options}
						</select>
					</td>
					{else}
						<td id="library_main_prev_date">
							{$prev_news.date|date_format:"%m-%d-%Y"}
						</td>
						<td id="library_main_prev_options">
							<b>{$prev_news._users_handle}</b>
						</td>
					{/if}
				</tr>
				<tr>
					<td id="library_main_prev_author_desc"></td>
					<td id="library_main_prev_author_img"></td>
				</tr>
				<tr><td id="library_main_prev_content" colspan="2">
					<a name="library_main_prev_content"></a>
					{if $prev_news.image}
						{html_image file=$prev_news.image id="library_main_prev_image"}
					{/if}
					{if $pageid}
						{$pageContent}
					{else}
						{$prev_news.description}
					{/if}
				</td></tr>
				{if ($prev_news.archive_item_id || $prev_news.page_count) && !$pageid}
				<tr class="library_main_prev_get">
					{if $prev_news.page_count}
					<td class="left" {if !$prev_news.archive_item_id}colspan="2"{/if}>
						<p>Przeczytaj artykuł</p>
						<div>
							<a href="{iURL module=$iModuleName action=$iActionName id=$prev_news.id page=1}">{html_image file="/www/images/ico_read.gif"}</a>
						</div>
					</td>
					{/if}
					{if $prev_news.archive_item_id}
					<td class="right" {if !$prev_news.page_count}colspan="2"{/if}>
						<p>Pobierz artykuł</p>
						<div>
							<p>Wersja PDF</p>
							<a href="{iURL module=archive action=download id=$prev_news.archive_item_id mode=empty}">{html_image file="/www/images/pdf_ico.gif"}</a>
						</div>
					</td>
					{/if}
				</tr>
				{/if}
				
				{if $pageid}
				<tr>
					<td id="library_main_prev_paginate" colspan="2">
						{paginate_prev id=$paginate_id text="Poprzednia"} {paginate_middle format="page" link_suffix=" " id=$paginate_id } {paginate_next text="Następna" id=$paginate_id }
					</td>
				</tr>
				{/if}
			</table>
			{/iScheme}

			{iSchemeInclude name=boxgreen type=css}
			{iSchemeInclude name=content1 type=css}

			{if $prev_news.solution}
				{capture assign=solution_text}
					<span class="library_main_solution_title">{$prev_news.solution.title}</span><br/><br/>
					<b>Zapoznaj się z artykułem, który wskaże Ci możliwe rozwiązanie powyższego problemu</b><br/><br/>
					{$prev_news.solution.description|truncate:400}
				{/capture}
				{capture assign=link}library_loadArticle('{iURL module=library action=main id=$prev_news.solution.id}'){/capture}
				{iScheme name=boxgreen title="e-GIE a rozwiązanie problemu" id=library_main_sol}
					{iScheme name=content1 image="/www/images/illustration_4.jpg" content=$solution_text link="javascript:$link"}
					{/iScheme}
				{/iScheme}
			{/if}
		{/if}