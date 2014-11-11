Object.extend(Core, {
	tableID : 'table',
	events : {
		'#cacheall a:click' : function(element, evt)
		{
			if (!confirm("Jesteś pewien, że chcesz zapisać wszystkie moduły w pamięci podręcznej?\n" +
					    "W zależności od liczy modułów i stopnia ich skomplikowania może to potrwać od kilku sekund do nawet kilku minut.")) {
				Event.stop(evt);
				return;
			}
		},

		'#uncacheall a:click' : function(element, evt)
		{
			if (!confirm("Jesteś pewien, że chcesz usunąć wszystkie moduły z pamięci podręcznej?\n")) {
				Event.stop(evt);
				return;
			}
		}
	}
});