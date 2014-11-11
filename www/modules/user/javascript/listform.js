Object.extend(Core, {
	tableID : 'table',
	events : {
		'#delete_selected a:click' : function(element, evt)
		{
			if (!confirm('Jesteś pewien, że chcesz usunąć wybranych użytkowników?')) {
				Event.stop(evt);
				return;
			}
			
			var ids = Core.getScheme('xtable').getSelected(Core.tableID);
			element.href += '&id=' + ids;
		}
	}
});