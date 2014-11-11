<div{if $iScheme.id} id="{$iScheme.id}"{/if} class="{$iScheme.serializedClassNames}{if $iScheme.attr.dot == true} {$iScheme.class}_dot{/if}">
	<div class="{$iSchemeClass}_header{if $iScheme.attr.dot == true} {$iSchemeClass}_header_dot{/if}">{$iScheme.attr.title}</div>
	<div class="{$iSchemeClass}_body{if $iScheme.attr.dot == true} {$iSchemeClass}_body_dot{/if}">
