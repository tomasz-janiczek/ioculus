Object.extend(Core, {
	events : {
		'#add_page_button:click' : function(element)
		{
			if (!confirm('Jesteś pewien, że chcesz dodać nową stronę?')) return;
			Core.ajaxRequest('article', 'addpage', {id : Core.args.id, content : tinyMCE.getContent()}, Core.addArticlePageError,
				 			 Core.addArticlePageOK);
		},

		'#insert_page_button:click' : function(element)
		{
			var page_id = Core.getScheme('boxmenu').getPageNumber('pagelist');
		
			if (!confirm('Jesteś pewien, że chcesz wstawić nową stronę?')) return;
			Core.ajaxRequest('article', 'insertpage', {id : Core.args.id, number : page_id, content : tinyMCE.getContent()},
							 Core.insertArticlePageError, Core.insertArticlePageOK);
		},
		
		'#edit_page_button:click' : function(element)
		{
			var page_id = Core.getScheme('boxmenu').getPageNumber('pagelist');
		
			if (!confirm('Jesteś pewien, że chcesz zmodyfikować stronę numer ' + page_id + '?')) return;
			Core.ajaxRequest('article', 'editpage', {id : Core.args.id, number : page_id, content : tinyMCE.getContent()},
						 Core.editArticlePageError, Core.editArticlePageOK);
		},

		'#delete_page_button:click' : function(element)
		{
			var page_id = Core.getScheme('boxmenu').getPageNumber('pagelist');

			if (!confirm('Jesteś pewien, że chcesz usunąć aktualną stronę numer ' + page_id + '?')) return;
			Core.ajaxRequest('article', 'deletepage', {id : Core.args.id, number : page_id}, Core.deleteArticlePageError,
						 	 Core.deleteArticlePageOK);
		}
	},

	onLoad : function()
	{
		Core.schemeObserve('boxmenu', 'pageSelected', 'onPageSelected');
	},

	// ..:: loadArticleList ::..
	loadArticleListError : function(request)
	{
		$('section').innerHTML = '<option value="0">Wystąpił błąd - artykuł nie może zostać załadowany</option>';
	},

	loadArticleListOK : function(request)
	{
		$('solution_item_id').innerHTML = request.responseText;
	},

	loadArticleList : function(article_id)
	{
		$('solution_item_id').innerHTML = '<option value="0">Ładuję artykuły, proszę czekać...</option>';
		Core.ajaxRequest('article', 'list', {id : article_id}, Core.loadArticleListError, Core.loadArticleListOK);
	},

	// ..:: reloadPageList ::..
	reloadPageListError : function(request)
	{
		Core.getScheme('boxmenu').setContent('pagelist', '<li>Wystąpił błąd</li>');
	},

	reloadPageListOK : function(request)
	{
		Core.getScheme('boxmenu').setContent('pagelist', request.responseText);
	},

	reloadPageList : function()
	{
		Core.ajaxRequest('article', 'getpagelist', {id : this.args.id}, Core.reloadPageListError, Core.reloadPageListOK);
		Core.getScheme('boxmenu').getContentElement('pagelist').title = "0";
	},

	// ..:: loadArticlePage ::..
	loadArticlePageError : function(request)
	{
		tinyMCE.setContent('Wystąpił błąd - strona nie może zostać załadowana');
	},

	loadArticlePageOK : function(request)
	{
		tinyMCE.setContent(request.responseText);
	},

	loadArticlePage : function(page_id)
	{
		var msg = '<table style="height: 100%; width: 100%; text-align: center; vertical-align: center;"><tr><td style="font-weight: bold; font-size: 12px;"><img src="/www/modules/library/images/logo_egie.jpg" alt="eGIE"/><br/><br/>Strona numer #' + page_id + ' jest ładowana, proszę czekać...</td></tr></table>';
		
		tinyMCE.setContent(msg);
		Core.ajaxRequest('article', 'getpage', {id : Core.args.id, number : page_id}, Core.loadArticlePageError, Core.loadArticlePageOK);
	},

	// ..:: addArticlePage ::..
	addArticlePageError : function(request)
	{
		alert('Wystąpił błąd. Strona nie została zapisana.');
		Core.reloadPageList();
	},

	addArticlePageOK : function(request)
	{
		alert('Strona została zapisana.');
		Core.reloadPageList();
	},

	// ..:: insertArticlePage ::..
	insertArticlePageError : function(request)
	{
		alert('Wystąpił błąd. Strona nie została zapisana.');
		Core.reloadPageList();
	},

	insertArticlePageOK : function(request)
	{
		Core.reloadPageList();
	},

	// ..:: editArticlePage ::..
	editArticlePageError : function(request)
	{
		alert('Wystąpił błąd. Strona nie została zmodyfikowana.');
		alert(request.responseText);
	},

	editArticlePageOK : function(request)
	{
		alert('Strona została zmodyfikowana.');
	},

	// ..:: deleteArticlePage ::..
	deleteArticlePageError : function(request)
	{
		alert('Wystąpił błąd. Strona nie została usunięta.');
		Core.reloadPageList();
	},

	deleteArticlePageOK : function(request)
	{
		alert('Strona została usunięta.');
		Core.reloadPageList();
	},

	onPageSelected : function(msg)
	{
		Core.loadArticlePage(msg.event_data.data.id);
	}	
});
