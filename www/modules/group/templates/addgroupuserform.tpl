{iScheme name=boxlight4 title="Nowy członek grupy"}
	{iScheme name=form action=$action}
		{iScheme name=form_section}
			{iScheme name=form_field type=labeledText label="Grupa"}
				{iInput type=select name=gid}
					{html_options options=$groups selected=$gid}
				</select>
			{/iScheme}
			{iScheme name=form_field type=labeledText label="Użytkownik"}
				{iInput type=select name=id}
					{html_options options=$users}
				</select>
			{/iScheme}
		{/iScheme}
		
		{iScheme name=form_section}			
			{iScheme name=form_buttons}{/iScheme}
		{/iScheme}
	{/iScheme}
{/iScheme}