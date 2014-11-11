Object.extend(Core, {
	tableID : 'table',
	events : {
		'input.text.priority:keypress' : function(element, evt)
		{
			if(evt.keyCode == Event.KEY_RETURN) {
				var list = $A(document.getElementsByClassName('priority')), values = '';
				if (!list) return;
		
				list.each(function(input) {
					if (values != '') values += ',';
					values += input.id.substr(input.id.indexOf('_') + 1) + ':' + input.value;
				});

				Core.ajaxRequest(Core.module, 'setpriority', {id :values}, Core.onPriorityError, Core.onPriorityOK);
			}
		},
		
		'#delete_selected a:click' : function(element, evt)
		{
			var ids = Core.getScheme('xtable').getSelected(Core.tableID);
			
			if (!ids) {
				alert('Nie wybrano żadnych pozycji');
				Event.stop(evt);
				return;
			}

			if (!confirm('Jesteś pewien, że chcesz usunąć wybrane artykuły?')) {
				Event.stop(evt);
				return;
			}
			
			element.href += '&id=' + ids;
		}
	},
	
	onPriorityOK : function()
	{
		alert('Priorytet został zmieniony');
	},

	onPriorityError : function(request)
	{
		alert('Wystąpił błąd: ' + request.responseText);
	}
});
