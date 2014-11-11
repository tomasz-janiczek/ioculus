{iScheme name=boxlight3 title="Wyślij plik"}
	{iScheme name=form action=$action enctype="multipart/form-data"}
		{iScheme name=form_section}
			{iScheme name=form_field_labeled label="Ścieżka do pliku"}
				{iInput type=file name=file}
			{/iScheme}
		{/iScheme}

		{iScheme name=form_section}
			{iScheme name=form_buttons}
			{/iScheme}
		{/iScheme}
	{/iScheme}
{/iScheme}
