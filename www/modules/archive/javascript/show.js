function createGalleryTable(name, images, num, field)
{
	document.write('<p class="title">' + name + '</p>');
	document.write('<table class="galleryTable">');
	for (j = 0;j < images.length;j++) {
		document.write('<tr>');
		for (i = 0;i < num;i++) {
			document.write('<td><img src="' + images[j + i] + '" alt="" onClick="selectIcon(\'' + field + '\', \'' + images[j + i] + '\')"></td>');
		}
		document.write('</tr>');
		j += i;
	}
	document.write('</table>');
}

function selectIcon(fieldName, fileName)
{
	if (fieldName != '') {
		obj = window.opener.document.getElementById(fieldName);
		obj.value = fileName;
	}
	window.close();
}