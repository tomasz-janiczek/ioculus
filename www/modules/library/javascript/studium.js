Object.extend(Core, {
	setContent : function(content, title)
	{
		var element = document.getElementsByClassName('scheme_boxlight4_td2', 'library_studium_main_prev')[0];
		element.innerHTML = content;
		
		element = document.getElementsByClassName('scheme_boxlight4_td1', 'library_studium_main_prev')[0];
		if (title) element.innerHTML = title;
		else element.innerHTML = '';
	},
	
	loadDataError : function(request)
	{
		$('library_studium_main_prev').getElementsByTagName('td')[0].innerHTML = 'Wystąpił błąd - artykuł nie może zostać załadowany';
	},

	loadDataOK : function(request)
	{
		Core.setContent(request.responseText);
	},

	loadData : function(url)
	{
		$('library_studium_main_prev').getElementsByTagName('td')[0].innerHTML = 'Artykuł jest ładowany, proszę czekać...';
		this.ajaxRequest('article', 'getpage', {id : url.toQueryParams().id, number : 1}, this.loadDataError, this.loadDataOK);
	},

	loadFormError : function(request)
	{
		$('library_studium_main_prev').getElementsByTagName('td')[0].innerHTML = 'Wystąpił błąd - formularz nie może zostać załadowany';
	},

	loadFormOK : function(request)
	{
		Core.setContent(request.responseText);
	},

	loadForm : function()
	{
		$('library_studium_main_prev').getElementsByTagName('td')[0].innerHTML = 'Formularz jest ładowany, proszę czekać...';
		this.ajaxRequest(this.module, 'studium_register_form', null, this.loadFormError, this.loadFormOK);
	}
});
