schemeTinyMCE = new iScheme();
Object.extend(schemeTinyMCE, {
	name : 'tinymce',
	includes : new Array("/www/javascript/tiny_mce/tiny_mce.js"),

	onPostload : function(module, action)
	{	
		var ids = '', schemes = document.getElementsByClassName('scheme_' + this.name);
		if (!schemes) return;

		schemes.each(function(scheme) {
				var areas = $A(scheme.getElementsByTagName('textarea'));
				if (areas) areas.each(function(area) {
					if (area.id) {
						if (ids) ids += ',';
						ids += area.id;
					}
				});
		});

		tinyMCE.init({
			mode : "exact",
			elements : ids,
			theme : "advanced",
			width : '96%',
			language : "pl",
			docs_language : "pl",
			plugins : "spellchecker,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,imanager",
			theme_advanced_toolbar_location : "top",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			theme_advanced_resize_horizontal : false,
			theme_advanced_toolbar_align : "left",
			theme_advanced_buttons2_add : "imanager,pastetext,pasteword,selectall",
			theme_advanced_buttons3_add : "separator,fontselect, fontsizeselect",
			plugin_insertdate_dateFormat : "%d-%m-%Y",
			plugin_insertdate_timeFormat : "%H:%M:%S",
			extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
			spellchecker_languages : "Polish=pl" 
		});
	}		
});

Core.registerScheme(schemeTinyMCE);