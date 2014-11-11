<div class="{$iSchemeClass}_image">
	{html_image file=$Scheme.attr.image|default:"/www/images/egie_logo.gif"}
</div>
<div class="{$iSchemeClass}_body">
	<div class="{$iSchemeClass}_body_header">
		<div class="{$iSchemeClass}_body_dot"></div>
		<div class="{$iSchemeClass}_body_title">{$iScheme.attr.title}</div>
		<div class="{$iSchemeClass}_body_author">{$iScheme.attr.author}, {$iScheme.attr.date}</div>
	</div>
	{$iScheme.attr.text}
