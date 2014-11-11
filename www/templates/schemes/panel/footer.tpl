<tr><td class="scheme_panel_td4">
<script language="javascript" type="text/javascript">
	var scheme_panel_chapters = Array();
	var scheme_panel_expand = Array();
	var scheme_panel_cookie = Array();
	
	{foreach name=scheme_panel_chapters from=$iScheme.attr.content item=chapter key=chapter_id}
	scheme_panel_chapters.push('{$chapter.name|truncate:37}');
	scheme_panel_expand.push({if $smarty.foreach.scheme_panel_chapters.iteration == 1}true{else}false{/if});
	scheme_panel_cookie.push('scheme_panel_chapter{$chapter_id}_cookie');
	{/foreach}

	initDhtmlgoodies_xpPane(scheme_panel_chapters, scheme_panel_expand, scheme_panel_cookie);
</script>
</td></tr>
