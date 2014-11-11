Object.extend(Core, {
	tableID : 'table',
	events : {
		'#delete_selected a:click' : function(element, evt)
		{
			var ids = Core.getScheme('xtable').getSelected(Core.tableID);
			
			if (!ids) {
				alert('Nie wybrano żadnych pozycji');
				Event.stop(evt);
				return;
			}

			if (!confirm('Jesteś pewien, że chcesz usunąć wybrane uprawnienia?')) {
				Event.stop(evt);
				return;
			}
			
			element.href += '&id=' + ids;
		}
	}
});