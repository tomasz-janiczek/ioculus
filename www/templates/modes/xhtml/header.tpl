<!DOCTYPE {$iDocType}>
<html>
<head>
<title>[eGIE] eGmina, Infrastruktura, Energetyka</title>
<meta http-equiv="content-type" content="text/html; charset={$iDocumentCharset}"/>
<meta name="description" content="eGmina, Infrastruktura, Energetyka - witryna platformy eGIE"/>
<meta name="keywords" content="egmina,e-gmina,infrastruktura,energetyka,platforma,ebiznes,gmina,gminy,system informatyczny,restrukturyzacja,telepraca,inkubator,studenci,egmina,e-gmina,infrastruktura,energetyka,platforma,ebiznes,gmina,gminy,system informatyczny,restrukturyzacja,telepraca,inkubator,studenci,doradztwo,consulting"/>
<script src="/www/javascript/effects/prototype.js" type="text/javascript"></script>
<script src="/www/javascript/events.js" type="text/javascript"></script>
<script src="/www/javascript/drag-drop-custom.js" type="text/javascript"></script>
<script src="/www/javascript/event-selectors.js" type="text/javascript"></script>
<script src="/www/javascript/ioculus.js" type="text/javascript"></script>
{if $iJSFiles}
{section name="js" loop=$iJSFiles}
<script src="{$iJSFiles[js]}" type="text/javascript"></script>
{/section}
{/if}
<link rel="stylesheet" type="text/css" href="/www/styles/layout.css" media="screen"/>
{if $iCSSFiles}
{section name="css" loop=$iCSSFiles}
<link rel="stylesheet" type="text/css" href="{$iCSSFiles[css]}" media="screen"/>
{/section}
{/if}
{if $iCSSFiles_IE}
<!--[if IE]>
{section name="css" loop=$iCSSFiles_IE}
<link rel="stylesheet" type="text/css" href="{$iCSSFiles_IE[css]}" media="screen"/>
{/section}
<![endif]-->
{/if}
{if $iCSSFiles_IE6}
<!--[if IE6]>
{section name="css" loop=$iCSSFiles_IE6}
<link rel="stylesheet" type="text/css" href="{$iCSSFiles_IE6[css]}" media="screen"/>
{/section}
<![endif]-->
{/if}
{if $iCSSFiles_IE5}
<!--[if IE5]>
{section name="css" loop=$iCSSFiles_IE5}
<link rel="stylesheet" type="text/css" href="{$iCSSFiles_IE5[css]}" media="screen"/>
{/section}
<![endif]-->
{/if}
<link rel="Shortcut icon" href="www/images/favicon.ico"/>
</head>

<body onload="Core._onLoad('{$iModuleName}', '{$iActionName}')">
	<script type="text/javascript">Core._onPreload('{$iModuleName}', '{$iActionName}')</script>

