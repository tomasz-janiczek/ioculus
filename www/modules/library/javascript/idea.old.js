function library_activateBox(obj)
{
	var name = obj.getAttribute('name');
	var title = obj.getAttribute('title');
	var description = $('library_idea_scheme_description');
	var descriptionSpan = description.getElementsByTagName('span');
	var span = obj.getElementsByTagName('span');
	var text = '';
	
	descriptionSpan = descriptionSpan[0];
	
	if (span && span.length) text = span[0].innerHTML;
	else text = 'Przykro nam, ale aktualnie opis dla tego elementu nie istnieje.';
	
	if (title == null) title = 'Element';
	
	obj.style.background = 'url("/www/images/egie_scheme_' + name + '.jpg")';
	description.innerHTML = '<b>' + title + '</b><br/>' + text;
}

function library_deactivateBox(obj)
{
	obj.style.background = 'none';
	$('library_idea_scheme_description').innerHTML = $('library_idea_scheme_help').innerHTML;
}

// Preload images for the scheme

if (document.images)
{
	var i = 0;

	preload = new Image();
	images = new Array();
	
	images[0] = '/images/egie_scheme_gmina.jpg';
	images[1] = '/images/egie_scheme_audit.jpg';
	images[2] = '/images/egie_scheme_inf.jpg';
	images[3] = '/images/egie_scheme_int.jpg';
	images[4] = '/images/egie_scheme_dev.jpg';
	images[5] = '/images/egie_scheme_devinst.jpg';
	images[6] = '/images/egie_scheme_op.jpg';
	images[7] = '/images/egie_scheme_opinf.jpg';
	images[8] = '/images/egie_scheme_resell.jpg';

	for (i = 0;i < images.length; i++) preload.src = images[i];
}
