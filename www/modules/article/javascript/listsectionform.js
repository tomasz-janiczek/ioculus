Object.extend(Core, {
	events : {
		'#select #types:change' : function(element)
		{
			var url = '';
			var params = $H({'m' : Core.module, 'act' : Core.action});
			if (element.value) params['type'] = element.value;

			url = '/?' +params.toQueryString();

			document.location.replace(url);
		}		
	}
});
