function library_loadArticle_onFailed(request)
{
	$('library_main_prev_container').innerHTML = 'Wystąpił błąd - artykuł nie może zostać załadowany';
}

function library_loadArticle_onResponse(request)
{
	$('library_main_prev_container').innerHTML = request.responseText;
}

function library_loadArticle(url)
{
	var table = $('library_main_prev');
	table.getElementsByTagName('td')[0].innerHTML = 'Artykuł jest ładowany, proszę czekać...';
	
	var myAjax = new Ajax.Request(url, 
							{
							method: 'get', 
							parameters: 'mode=ajax', 
							onFailure: library_loadArticle_onFailed,
							onComplete: library_loadArticle_onResponse
							});
}

function library_setOption(obj)
{
	if (obj.value != '0') {
		if (obj.value.indexOf('delete') != -1 && confirm('Jesteś pewien, że chcesz usunąć ten artykuł?') == false) return;
		document.location.replace(obj.value);
	}
}
