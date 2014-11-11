Object.extend(Core, {
	events :
	{
		'.underline:mouseover' : function(el)
		{
			Element.setStyle(el, {'textDecoration' : 'underline'});
		},
	
		'.underline:mouseout' : function(el)
		{
			Element.setStyle(el, {'textDecoration' : 'none'});
		}	
	}
});
