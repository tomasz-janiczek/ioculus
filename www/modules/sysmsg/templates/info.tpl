{iScheme name=boxlight3 title=$title id=box}
	<div id="image">{html_image file=$iImageDir|cat:"/$icon"|cat:".gif"}</div>
	<div id="body">
		<div id="text">
			{$msg}
		</div>
		<div id="button">
			<a href="{$url}">{html_image file="/www/images/button_ok.gif"}</a>
		</div>
	</div>
{/iScheme}
