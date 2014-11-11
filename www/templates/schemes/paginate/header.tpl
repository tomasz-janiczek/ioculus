<tr><td>
{if $iScheme.attr.type == "top"}
	{$iScheme.attr.title|default:"Pozycje"} <b>{$iScheme.attr.paginate.first}-{$iScheme.attr.paginate.last}</b> z wszystkich <b>{$iScheme.attr.paginate.total}</b>
{else}
	{paginate_prev id=$iScheme.attr.pid text="Poprzednie"} <b>{paginate_middle id=$iScheme.attr.pid}</b> {paginate_next id=$iScheme.attr.pid text="Następne"}
{/if}
