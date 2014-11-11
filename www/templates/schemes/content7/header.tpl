<tr><td>
	<table>
	{counter assign=max_sections start=1}
	{foreach from=$iScheme.attr.content key=date item=section name=scheme_content7_j}
	{if $max_sections <= 10}
		<tr><td class="scheme_content7_date {if $smarty.foreach.scheme_content7_j.first}scheme_content7_date_top{/if}" colspan="2">{$date}</td></tr>
		{section name="scheme_content7_i" loop=$section}
		<tr>
			<td class="scheme_content7_title"><a href="{$section[scheme_content7_i].link}"><ul><li>{$section[scheme_content7_i].title|truncate:30}</li></ul></a></td>
			<td class="scheme_content7_arrow"><a href="{$section[scheme_content7_i].link}">{html_image file="/www/images/arrow_green_double.jpg"}</a></td>
		</tr>
		{counter assign=max_sections}
		{/section}
	{/if}
	{/foreach}
	</table>