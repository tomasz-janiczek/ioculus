{iScheme name=form action=$action enctype="multipart/form-data"}
	{iScheme name=tabpane}
		{iScheme name=tabpane_page title="Dane podstawowe"}
			{iScheme name=form_section}
				{iScheme name=form_field type=select fieldName=sectionid label=Sekcja required=true}		
					{html_options options=$sections selected=$section_id|default:$iArgs.id}
					</select>
				{/iScheme}
				{iScheme name=form_field type=text fieldName=title label=Tytuł value=$article.title maxlength=255 required=true}
				{/iScheme}
				
				{iScheme name=tinymce}
					{iScheme name=form_field type=textarea fieldName=description label="Opis" value=$article.description}
					{/iScheme}
				{/iScheme}

				{iScheme name=form_buttons}
				{/iScheme}
			{/iScheme}
		{/iScheme}

		{iScheme name=tabpane_page title="Treść artykułu"}
			{iScheme name=form_section}
				{iScheme name=tinymce}
					{iScheme name=form_field type=textarea fieldName=content label="Treść" value=$article.content required=true}
					{/iScheme}
				{/iScheme}					
			{/iScheme}
		{/iScheme}

		{iScheme name=tabpane_page title="Ilustracja"}
		{/iScheme}

		{iScheme name=tabpane_page title="Załączniki"}
		{/iScheme}
	{/iScheme}
{/iScheme}
