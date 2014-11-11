Object.extend(Core, {
	events : {
		'#contact_id:change' : function(element)
		{
			Core.onContactSelect(element);
		},
		
		'#contact_getvcard:click' : function(element)
		{
			Core.onGetVCardClick(element);
		},

		'#contact_button_reset:click' : function(element)
		{
			document.forms.contact_form.reset();
		},

		'#contact_button_send:click' : function(element)
		{
			document.forms.contact_form.submit();
		}
	},
	
	loadDataError : function(request)
	{
		$('contact_data').innerHTML = 'Wystąpił błąd - artykuł nie może zostać załadowany';
	},

	loadDataOK : function(request)
	{
		$('contact_data').innerHTML = request.responseText;
	},

	loadData : function(user_id)
	{
		$('contact_data').innerHTML = 'Ładuję informacje, proszę czekać...';
		Core.ajaxRequest(Core.module, Core.action, {id : user_id}, Core.loadDataError, Core.loadDataOK);
	},

	onContactSelect : function(element)
	{
		Core.loadData(element.value);
	},

	onGetVCardClick : function(msg)
	{
		var value = $F('contact_id');
		if (value > 0) document.location.replace(Core.iURL(Core.module, 'downloadvcard', {id : value}));
		else alert('Aby pobrać wizytówkę w formacie vCard, wybierz najpierw interesujący Cię kontakt');
	}
});
