function compileAllCheckBoxes()
{
	var list = document.getElementsByTagName('input');
	var nameList = '';

	for(var i = 0;i < list.length; i++)
	{
		if (list[i].type == 'checkbox' && list[i].checked == true)
			nameList += (nameList.length ? ',' : '') + list[i].getAttribute('chkid');
	}
	
	alert('[' + nameList + ']');
}

function selectAllCheckBoxes(state)
{
	var list = document.getElementsByTagName('input');

	for(var i = 0;i < list.length; i++)
	{
		if (list[i].type == 'checkbox') list[i].checked = state;
	}
}