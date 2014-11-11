function library_loadService_onFailed(request)
{
	$('library_offer_content').innerHTML = 'Wystapil blad - produkt lub usluga nie moze zostac zaladowana';
}

function library_loadService_onResponse(request)
{
	$('library_offer_content').innerHTML = request.responseText;
}

function library_loadService(url)
{
	$('library_offer_content').innerHTML = 'Produkt lub usluga jest ladowana, prosze czekac...';
	
	var myAjax = new Ajax.Request(url, 
							{
							method: 'get', 
							parameters: 'mode=ajax', 
							onFailure: library_loadService_onFailed,
							onComplete: library_loadService_onResponse
							});
}
