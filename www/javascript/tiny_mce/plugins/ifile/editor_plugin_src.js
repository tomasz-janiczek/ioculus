tinyMCE.importPluginLanguagePack('iarticle', 'en,pl');

// Plucin static class
var TinyMCE_iarticlePlugin = {
	getInfo : function() {
		return {
			longname : 'iarticle',
			author : 'MixMan',
			authorurl : '',
			infourl : '',
			version : '1.0'
		};
	},

	initInstance : function(inst) {
	},

	/**
	 * Returns the HTML contents of the iarticle control.
	 */
	getControlHTML : function(cn) {
		switch (cn) {
			case "iarticle":
				return tinyMCE.getButtonHTML(cn, 'lang_iarticle_desc', '{$pluginurl}/images/template.gif', 'mceIarticle');
		}

		return "";
	},

	/**
	 * Executes the mceEmotion command.
	 */
	execCommand : function(editor_id, element, command, user_interface, value) {
		// Handle commands
		switch (command) {
			case "mceIarticle":
				tinyMCE.openWindow(template, {editor_id : editor_id, inline : "yes"});

				return true;
		}

		// Pass to next handler in chain
		return false;
	}
};

// Register plugin
tinyMCE.addPlugin('iarticle', TinyMCE_iarticlePlugin);
