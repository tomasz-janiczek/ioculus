	<div class="{$iScheme.class}_label"><span>{$iScheme.attr.label}</span></div>
	<div class="{$iScheme.class}_content">
	{if $iScheme.attr.type == textarea ||$iScheme.attr.type == select}{iInput type=$iScheme.attr.type id=$iScheme.attr.id|default:$iScheme.attr.fieldName name=$iScheme.attr.fieldName}
	{else}
		{iInput type=$iScheme.attr.type|default:"text" id=$iScheme.attr.id|default:$iScheme.attr.fieldName name=$iScheme.attr.fieldName value=$iScheme.attr.value maxlength=$iScheme.attr.maxlength}
	{/if}