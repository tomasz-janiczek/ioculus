<tr><td>
	<table><tr>
	<td>
		<label for="imageUpload" id="imageLabel">Ilustracja</label>
		{iInput type=file name=image_file onChange="document.getElementById('image_gallery').value=''"}
	</td>
	<td>
		{capture assign=galleryURL}{iURL module=gallery action=show id=$iScheme.attr.galleryId mode=empty field=image_gallery}{/capture}
		{html_image file="/www/images/button_gallery.gif" class=scheme_imageselect_button onClick="galleryPopUp('$galleryURL')"}
		{iInput type=hidden name=image_gallery value=$iScheme.attr.default}
	</td>
	</tr></table>
