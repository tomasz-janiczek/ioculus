function autofitWindow()
{
	if (!window.innerWidth) {
		window.resizeTo(document.images[0].width + 15, document.images[0].height + 35);
	} else {
		window.innerWidth = document.images[0].width + 15;
		window.innerHeight = document.images[0].height + 60;
	}
}
