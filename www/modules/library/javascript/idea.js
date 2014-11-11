Object.extend(Core, {
	events : {
		'.block:mouseover' : function(element)
		{
			Element.addClassName(element, 'block_over');
			var div = element.getElementsByTagName('div')[0];
			Core.setContent(div.innerHTML);
		},
		
		'.block:mouseout' : function(element)
		{
			Core.resetContent();
			Element.removeClassName(element, 'block_over');
		}
	},
	
	setContent : function(text)
	{
		var box = document.getElementsByClassName('scheme_boxlight3_body', 'description')[0];
		if (!box) return;
		box.innerHTML = text;
	},
	
	resetContent : function()
	{
		var box = document.getElementsByClassName('scheme_boxlight3_body', 'description')[0];
		if (!box) return;
		
		box.innerHTML = $('description_default').innerHTML;
	}
});
