schemeBoxMenu = new iScheme();
Object.extend(schemeBoxMenu, {
	name : 'boxMenu',

	onLoad : function(core)
	{
		core.observe('.scheme_boxmenu_menu *', 'click', this.bind(this.onPageClick));
	},

	getContentElement : function(id)
	{
		var table = $(id);
		if (!table) return false;

		var ul = table.getElementsByTagName('ul');
		if (!ul) return false;
		
		return ul[0];
	},

	getItem : function(id, page_id)
	{
		var content = this.getContentElement(id);
		if (!content) return false;
		
		var items = content.getElementsByTagName('li');
		if (!items) return false;
		
		for (var i = 0;i < items.length;i++)
			if (parseInt(items[i].title) == page_id) return items[i];
			
		return false;
	},

	getPageNumber : function(id)
	{
		var content = this.getContentElement(id);
		if (!content) return false;
		else return content.title;
	},

	setContent : function(id, data)
	{
		var content = this.getContentElement(id);
		if (!content) return false;
		content.innerHTML = data;
		this.onLoad(Core);
		
		return true;
	},

	setSelectedPage : function(element)
	{
		if (element.parentNode.title)
		{
			var current_page = parseInt(element.parentNode.title);
			if (current_page > 0)
			{
				var oldElement = this.getItem(element.parentNode.parentNode, current_page);
				Element.setStyle(oldElement, {textDecoration : 'none'});
			}
		}

		Element.setStyle(element, {textDecoration : 'underline'});
		element.parentNode.title = element.title;
	},

	onAddPage : function(msg)
	{
		var src = Event.element(msg);
		var items = src.getElementsByTagName('li');
		var item = document.createElement('li');		
	
		item.title = parseInt(items[items.length - 1].getAttribute("title")) + 1;
		item.innerHTML = 'Strona ' + item.title;
	
		src.appendChild(item);
		this.onSetSelectedPage(src.parent, item.title);
	
		return false;
	},

	onDeletePage : function(msg)
	{
		var src = Event.element(msg);
		var items = src.getElementsByTagName('li');
		var id = this.onGetSelectedPage(src);
	
		for (var i = 0;i < items.length;i++)
		{
			if (items[i].title == id)
			{
				items[i].parent.removeChild(items[i]);
				for (var j = i;j < items.length;j++) items[j].title = parseInt(items[j].title) - 1;
				break;
			}
		}
	
		return false;
	},

	onPageClick : function(msg)
	{
		src = Event.element(msg);
		this.setSelectedPage(src);
		this.dispatchEvent('pageSelected', {id : src.title, source : src}, true);
	}
});

Core.registerScheme(schemeBoxMenu);
