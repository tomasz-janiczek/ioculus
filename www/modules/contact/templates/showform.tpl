{iScheme name=boxlight3 title=Kontakt}
	{capture assign=url}{iURL module=$iModuleName action=send}{/capture}
	{iScheme name=form action=$url enctype="multipart/form-data"}

		{iScheme name=form_section}
			{iScheme name=form_field_labeled label=""}
				{iInput type=select name=contact_id id=contact_id}
					<option value="0">Kontakt ogólny</option>
					{html_options options=$users}
				</select>
			{/iScheme}

			{iScheme name=form_field_labeled label="Dane kontaktowe"}
				{iIncludeTemplate file="$iTemplateDir/ajax/showform.tpl"}
			{/iScheme}
		
			{iScheme name=form_field_labeled id=vcard_button}
				{html_image file="$iImageDir/button_get_vcard.gif" class="library_contact_button_get_vcard" id="contact_getvcard"}							
			{/iScheme}
		{/iScheme}

		{iScheme name=form_section}
			{iScheme name=form_field label="Imię i nazwisko" fieldName=fullname required=true}
			{/iScheme}

			{iScheme name=form_field_labeled label="" required=true}
				<input type="radio" name="type" value="firma" class="myRadio" checked="checked"/>firma
				<input type="radio" name="type" value="gmina" class="myRadio" />gmina
				<input type="radio" name="type" value="osoba prywatna" class="myRadio" />osoba prywatna
			{/iScheme}

			{iScheme name=form_field label="Nazwa firmy / gminy" fieldName=company}
			{/iScheme}

			{iScheme name=form_field label="Numer telefonu" fieldName=phone required=true}
			{/iScheme}

			{iScheme name=form_field label="Fax" fieldName=fax}
			{/iScheme}

			{iScheme name=form_field label="E-Mail" fieldName=email}
			{/iScheme}

			{iScheme name=form_field type="labeledText" label="Załącz vCard"}
			{iInput type=file name=vcard}
			<p>Akceptowane są tylko pliki wizytówkowe <a href="http://pl.wikipedia.org/wiki/Vcard">vCard</a>.<br/>
				Aby dodać załącznik o dowolnym formacie, użyj pola "Załącz plik"
			</p>
			{/iScheme}
		{/iScheme}

		{iScheme name=form_section}
			{iScheme name=form_field label="Temat" fieldName=title required=true}
			{/iScheme}
			{iScheme name=form_field type=textarea label="Treść" required=true}
			{/iScheme}
			{iScheme name=form_field_labeled label="Załącz plik"}
				{iInput type=file name=attach}
				<p>Rozmiar załącznika nie może przekraczać 1 MB</p>
			{/iScheme}

			{capture assign=required}{html_image file="$iImageDir/warning.gif"}{/capture}
			{iScheme name=form_field_labeled label=$required}
				<b>Pola wymagane</b>
			{/iScheme}
		{/iScheme}

		{iScheme name=form_section}					
			{iScheme name=form_buttons}
			{/iScheme}
		{/iScheme}

	{/iScheme}
{/iScheme}