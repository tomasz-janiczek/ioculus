{include file="www/templates/modes/xhtml/header.tpl"}

<div id="site_layout">
	<div id="site_layout_header">
		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="760" height="260" id="menu" align="middle">
			<param name="allowScriptAccess" value="sameDomain" />
			<param name="movie" value="/menu.swf" /><param name="menu" value="false" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="/www/images/flash/menu.swf" menu="false" quality="high" bgcolor="#ffffff" width="760" height="260" name="menu" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
		</object>
	</div>
	<div id="site_layout_body">
		{$iPageContent}
	</div>
	<div id="site_layout_footer">
		<div id="site_layout_footer_left">
			<span>Copyright [c] 2006 eGmina, Infrastruktura, Energetyka</span>
		</div>
		<div id="site_layout_footer_right">
			<span>
				<a href="{iURL module=library action=privacy}">Polityka Prywatności</a> |
				<a href="{iURL module=contact}">Kontakt</a>
			</span>
		</div>
	</div>
	<div id="site_layout_certs">
		{html_image file="/www/images/w3c/gray_xhtml_1.0.png"}
		{html_image file="/www/images/w3c/gray_css_2.png"}
	</div>
</div>

{include file="www/templates/modes/xhtml/footer.tpl"}