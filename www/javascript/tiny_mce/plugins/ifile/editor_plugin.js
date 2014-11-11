tinyMCE.importPluginLanguagePack('ifile', 'en,pl');

// Plucin static class
var TinyMCE_ifilePlugin = {
	getInfo : function() {
		return {
			longname : 'ifile',
			author : 'MixMan',
			authorurl : '',
			infourl : '',
			version : '1.0'
		};
	},

	initInstance : function(inst) {
	},

	/**
	 * Returns the HTML contents of the ifile control.
	 */
	getControlHTML : function(cn) {
		switch (cn) {
			case "ifile":
				return tinyMCE.getButtonHTML(cn, 'lang_ifile_desc', '{$pluginurl}/images/ifile.gif', 'mceifile');
		}

		return "";
	},

	/**
	 * Executes the mceEmotion command.
	 */
	execCommand : function(editor_id, element, command, user_interface, value) {
		// Handle commands
		switch (command) {
			case "mceifile":
				galleryPopUp('index.php?m=article&act=selectfileform&editor_id=' + editor_id + '&mode=empty');
				return true;
		}

		// Pass to next handler in chain
		return false;
	}
};

// Register plugin
tinyMCE.addPlugin('ifile', TinyMCE_ifilePlugin);
