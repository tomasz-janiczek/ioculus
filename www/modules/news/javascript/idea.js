function news_activateBox(obj)
{
	var name = obj.getAttribute('name');
	var title = obj.getAttribute('title');
	var description = document.getElementById('news_idea_scheme_description');
	var descriptionSpan = description.getElementsByTagName('span');
	var span = obj.getElementsByTagName('span');
	var text = '';
	
	descriptionSpan = descriptionSpan[0];
	
	if (span && span.length) text = span[0].innerHTML;
	else text = 'Przykro nam, ale aktualnie opis dla tego elementu nie istnieje.';
	
	if (!title) title = 'Element';
	
	obj.style.background = 'url("/www/images/egie_scheme_' + name + '.jpg")';
	description.innerHTML = '<b>' + title + '</b><br/>' + text;
}

function news_deactivateBox(obj)
{
	var description = document.getElementById('news_idea_scheme_description');
	var descriptionHelp = document.getElementById('news_idea_scheme_help');
	
	obj.style.background = 'none';
	description.innerHTML = descriptionHelp.innerHTML;
}