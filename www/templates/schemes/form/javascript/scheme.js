schemeForm = new iScheme();
Object.extend(schemeForm, {
	name : 'form',
	events : {
		'input:focus, textarea:focus' : function(element)
		{
			schemeForm.oldInputColor = Element.getStyle(element, 'borderColor');
			Element.setStyle(element, {borderColor : '#555555'});
		},

		'input:blur, textarea:blur' : function(element)
		{
			Element.setStyle(element, {borderColor : schemeForm.oldInputColor});
		}
	},
	
	oldInputColor : null,

	getAllForms : function()
	{
		var schemes = document.getElementsByClassName('scheme_form');
		var forms = new Array();
		
		for (var i = 0;i < schemes.length;i++) 
		{
			var list = schemes[i].getElementsByTagName('form');
			for (var j = 0;j < list.length;j++) forms.push(list[i]);
		}
		
		return forms;
	},

	getFormAreas : function(form)
	{
		return document.getElementsByClassName('scheme_form_section', form);
	},

	getAreaLabels : function(area)
	{
		return document.getElementsByTagName('label', area);
	},

	onLoad : function(core)
	{
		
		var forms = this.getAllForms();
		
		// Change the cell width to the width of the label element
		for (var i = 0;i < forms.length;i++)
		{
			var areas = this.getFormAreas(forms[i]);
			for (var j = 0;j < areas.length;j++)
			{
				var labels = this.getAreaLabels(areas[j]);
				for (var k = 0;k < labels.length;k++)
				{
					var newWidth = Element.getStyle(labels[k], 'width');
					if (newWidth) Element.setStyle(labels[k].parentNode, {width : newWidth});
				}
			}
		}
	}
});

Core.registerScheme(schemeForm);