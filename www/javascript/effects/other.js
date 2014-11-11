Effect.SlideUpAndDown = function(element) {
  element = $(element);
  if(Element.visible(element)) new Effect.SlideUp(element);
  else new Effect.SlideDown(element);
}
