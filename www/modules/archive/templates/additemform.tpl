		{capture assign=url}{iURL module=$iModuleName action=edititem id=$iActionArgs.id}{/capture}
		{iScheme name=form action=$url}
			{iScheme name=form_section}							
				{iScheme name=form_field fieldName=description type=text label=Opis" maxlength=255 value=$description}{/iScheme}
			{/iScheme}

			{iScheme name=form_section}				
				{iScheme name=form_field_empty}
					{iInput type=image src="/www/images/button_edit.gif"}
				{/iScheme}			
			{/iScheme}
			
		{/iScheme}
