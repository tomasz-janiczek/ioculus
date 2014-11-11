var ol_textfont = "Verdana";
var ol_delay = 500;
var ol_wrap = 1;
var ol_bgclass = "ol_bgclass";
var ol_fgclass = "ol_fgclass";
var ol_captionfontclass = "ol_captionfontclass";
var ol_textfontclass = "ol_textfontclass";
var ol_closefontclass = "ol_closefontclass";

function sitePopUp(URL)
{
	window.open(URL, 'WWW', 'fullscreen=yes, menubar=yes, scrollbar=yes, resizable=yes, status=yes, location=yes');
}

function toolkitPopUp(URL)
{
    window.open(URL, 'Informacja', 'menubar=no, toolbar=no, location=no, scrollbars=yes, resizable=yes, status=no, width=300, height=400');
}

function galleryPopUp(URL)
{
    window.open(URL, 'Galeria', 'menubar=no, toolbar=no, location=no, scrollbars=yes, resizable=yes, status=no, width=740, height=480');
}

function siteGoTo(URL)
{
    window.location.replace(URL);
}

var iMenuId = '';

function iMenu_init(id)
{
	iMenuId = id;
	iMenu_onResize(true);
}

function iMenu_onResize()
{
	var position = Position.cumulativeOffset($(iMenuId));

	A_MENUS = [];
	MENU_POS[0]['block_left'] = position[0];
	MENU_POS[0]['block_top'] = position[1];
	
	new menu (MENU_ITEMS, MENU_POS);
}
