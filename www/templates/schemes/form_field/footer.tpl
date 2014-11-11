{if $iScheme.attr.type == "textarea"}{$iScheme.attr.value}</textarea>{/if}
</div>
<div class="scheme_form_field_require">
{if $iScheme.attr.required == true}
	{html_image file="/www/images/warning.gif"}
{/if}
</div>
