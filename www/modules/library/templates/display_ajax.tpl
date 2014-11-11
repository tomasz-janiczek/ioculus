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
						{html_image file=$prev_news.image}
					{/if}
					{$prev_news.description}
				</td></tr>
				{if $prev_news.archive_item_id}
				<tr>
					<td id="library_main_prev_download" colspan="2">
						Strony
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
