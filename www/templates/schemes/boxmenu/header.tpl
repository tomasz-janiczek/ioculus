<tr><td>
	{if $iScheme.attr.label}<label>{$iScheme.attr.label}</label>{/if}
	<div>
		{if $iScheme.attr.inputName}
		{iInput type=hidden name=$iScheme.attr.inputName}
		{/if}
		<ul class="scheme_boxmenu_menu">
		{section name=scheme_boxmenu_i loop=$iScheme.attr.items}
			<li class="scheme_boxmenu_item" title="{$smarty.section.scheme_boxmenu_i.index}">Strona {$smarty.section.scheme_boxmenu_i.index}</li>
		{/section}
