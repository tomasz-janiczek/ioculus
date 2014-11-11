			{iScheme name=boxlight4 id=library_studium_main_prev title=$prev_news.title}
			<table id="library_studium_main_prev_table">
				<tr>
					<td id="library_studium_main_prev_author_desc"></td>
					<td id="library_studium_main_prev_author_img"></td>
				</tr>
				<tr><td id="library_studium_main_prev_content" colspan="2">
					<a name="library_studium_main_prev_content"></a>
					{if $prev_news.image}
						{html_image file=$prev_news.image}
					{/if}
					{$prev_news.content}
				</td></tr>
			</table>
			{/iScheme}

			{iSchemeInclude name=boxgreen type=css}
			{iSchemeInclude name=content1 type=css}

