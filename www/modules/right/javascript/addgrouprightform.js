Object.extend(Core, {
	dragDropObj : null,
	events : {
		'select:change' : function(element)
		{
			Core.loadRights(element.value);
		},

		'#right_button_add:click' : function(element)
		{
			Core.fillGroup();
		},
		
		'#right_button_remove:click' : function(element)
		{
			Core.clearGroup();
		}
	},

	onLoad : function()
	{
		var group = document.getElementsByClassName('scheme_boxlight3_td2', 'right_col1');
		group[0].id = 'right_list_block';

		group = document.getElementsByClassName('scheme_boxlight3_td2', 'right_col2');
		group[0].id = 'right_group_block';
				
		Core.dadAddElements();
	},

	dadAddElements : function()
	{
		var rights = document.getElementsByClassName('right_list_block_item');
		if (!rights) return;
		
		if (this.dragDropObj) delete this.dragDropObj;
		
		this.dragDropObj = new DHTMLSuite_dragDrop;
		this.dragDropObj.addTarget('right_group_block', 'Core.onGroupDrop');
		this.dragDropObj.addTarget('right_list_block', 'Core.onListDrop');
		
		for (var i = 0;i < rights.length;i++)
		{
			this.dragDropObj.addSource(rights[i].id, true);
		}
		
		this.dragDropObj.setSlide(true);
		this.dragDropObj.init();
	},

	clearGroup : function()
	{
		var rights = document.getElementsByClassName('right_list_block_item', 'right_group_block');
		if (!rights) return;
		
		list = $('right_list_block');
		for (var i = 0;i < rights.length;i++) list.appendChild(rights[i]);
	},

	fillGroup : function()
	{
		var rights = document.getElementsByClassName('right_list_block_item', 'right_list_block');
		if (!rights) return;
		
		list = $('right_group_block');
		for (var i = 0;i < rights.length;i++) list.appendChild(rights[i]);
	},

	addRightError : function(request)
	{
		alert('Wystapil blad, przydzielanie praw nie zostalo ukonczone');
	},

	onGroupDrop : function(itemId, dstId, x, y)
	{
		var el = $(itemId);

		$(dstId).appendChild(el);
		
		action = this.action.replace('form', '');
		
		this.ajaxRequest(this.module, action, {id : this.args.id, rid : el.title}, this.addRightError.bind(this));
		Element.setStyle(el, {'color' : 'blue'});
	},

	onListDrop : function(itemId, dstId, x, y)
	{
		var el = $(itemId);

		$(dstId).appendChild(el);
		
		if (this.action.indexOf('user') > 0) action = 'deleteuserright';
		else if (this.action.indexOf('group') > 0) action = 'deletegroupright';
		else alert('Błąd. Nieznana akcja ' + this.action);
		
		this.ajaxRequest(this.module, action, {id : this.args.id, rid : el.title}, this.addRightError.bind(this));		
	},

	loadRightsError : function(request)
	{
		alert('Błąd!');
	},

	loadRightsOK : function(request)
	{
		$('right_list_block').innerHTML = request.responseText;
		Core.dadAddElements();
	},

	loadRights : function(area_id)
	{
		params = {id : this.args.id, area_id : area_id};
		
		alert($H(params).toQueryString());
		
		this.ajaxRequest(this.module, this.action, params, this.loadRightsError.bind(this), this.loadRightsOK.bind(this));
	},
});
