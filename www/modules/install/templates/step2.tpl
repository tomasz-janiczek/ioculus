{iScheme name=boxlight3 title="Database information"}
	{iScheme name=form action=$action}
		{iScheme name=form_section}
			{iScheme name=form_field label="Host (host:port)" fieldName=hostspec required=true}
			{/iScheme}

			{iScheme name=form_field label="Database" fieldName=database required=true}
			{/iScheme}

			{iScheme name=form_field label="Username" fieldName=username required=true}
			{/iScheme}

			{iScheme name=form_field type=password label="Password" fieldName=password required=true}
			{/iScheme}
		{/iScheme}

		{iScheme name=form_section}
			{iScheme name=form_buttons}
			{/iScheme}
		{/iScheme}
	
	{/iScheme}
{/iScheme}