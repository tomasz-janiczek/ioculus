schemeFormButtons = new iScheme();
Object.extend(schemeFormButtons, {
	name : 'formbuttons',
	events : {
		'.scheme_form_buttons_check:click' : function(element, evt)
		{
			Event.stop(evt);
			schemeFormButtons.checkForm(element.form);
		},

		'.scheme_form_buttons_clear:click' : function(element, evt)
		{
			Event.stop(evt);
			element.form.reset();
		},
		
		'.scheme_form_buttons_cancel:click' : function(element, evt)
		{
			Event.stop(evt);
			history.back();
		}
	},
	
	checkError : function(request)
	{
		alert('Wystąpił błąd - sprawdzenie formularza niemożliwe');
	},

	checkOK : function(request)
	{
		switch (request.responseText)
		{
		case '-1':
			alert('Nie można sprawdzić formularza - jego moduł lub akcja są niepoprawne (nie istnieją)');
			break;

		case '0':
			alert('Formularz został wypełniony poprawnie');
			break;

		default:
			var pattern = /^\{([^\}]*)\}([^$]*)$/;
			var matches = pattern.exec(request.responseText);
			if (matches)
			{
				var element = $(matches[1]);
				if (element != undefined) {
					var a_name = 'scheme_form_field_anchor_' + matches[1];
					var a = $(a_name);
				
					if (a == undefined) {
						a = document.createElement('a');
						a.name = a_name;
						a.id = a_name;
						element.parentNode.insertBefore(a, element);
					}
				
					Element.setStyle(element, {'borderColor' : 'red'});
					alert(matches[2]);
					
					document.location.hash = a_name;
				} else alert(matches[2]);
			} else alert("Wystąpił błąd. Odpowiedź serwera:\n" + request.responseText);
			break;
		}
	},

	checkForm : function(form)
	{
		var form_values = encodeURIComponent(Form.serialize(form));
		var url = form.action.unescapeHTML().split('?')[1].toQueryParams();
		var args = new Array();
		
		Core.ajaxRequest('sysmodman', 'validate', {'module' : url.m, 'action' : url.act, 'args' : form_values},
						 this.checkError, this.checkOK);
	}
});

Core.registerScheme(schemeFormButtons);