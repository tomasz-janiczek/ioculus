			{iScheme name=boxlight4 id=library_studium_main_prev title="Formularz rejestracyjny"}
						{capture assign=url}{iURL module=$iModuleName action=studiumregister}{/capture}
						{iScheme name=form action=$url formName=studium}

							{iScheme name=form_section}
								{iScheme name=form_field_empty class=library_sep_form_text}
									Prosimy o dokładne przeczytanie formularza przed jego wysłaniem.<br/>
									W razie jakichkolwiek problemów lub pytań prosimy o kontakt z {mailto address="boguslaw.szewc@egie.pl" text="<b>redaktorem serwisu</b>" encode=javascript_charcode} studium.egie.pl.<br/><br/>
									{html_image file="/www/images/warning.gif"}&nbsp;&nbsp;&nbsp;&nbsp;Pola wymagane
								{/iScheme}
							{/iScheme}

							{iScheme name=form_section}
								{iScheme name=form_field type=labeledText label="Specjalizacja"}
									{iInput type=radio name=studium_specialization value="Rynek energii" checked="checked"}<b>Rynek energii</b><br/>
									{iInput type=radio name=studium_specialization value="Audyt energetyczny"}<b>Audyt energetyczny</b><br/>
									{iInput type=radio name=studium_specialization value="Energetyka rozproszona i e-infrastruktura w gminach"}<b>Energetyka rozproszona<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;i e-infrastruktura w gminach</b><br/>
								{/iScheme}
							{/iScheme}

							{iScheme name=form_section}	
								{iScheme name=form_field fieldName=name type=text label="Imię" maxlength=32 required=true}{/iScheme}
								{iScheme name=form_field fieldName=lastname type=text label="Nazwisko" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=father_name type=text label="Imię ojca" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=birth_date type=text label="Data urodzenia" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=birth_location type=text label="Miejsce urodzenia" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=address type=text label="Adres" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=city type=text label="Miasto" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=phone type=text label="Telefon" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=email type=text label="E-Mail" maxlength=64 required=true}{/iScheme}
							{/iScheme}
							
							{iScheme name=form_section}
								{iScheme name=form_field fieldName=position type=text label="Tytuł naukowy / zawodowy" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=graduation_date type=text label="Data ukończenia studiów" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=university_name type=text label="Nazwa uczelni" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=faculty type=text label="Wydział" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=specialization type=text label="Specjalność" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=graduation_number type=text label="Numer dyplomu" maxlength=64 required=true}{/iScheme}
							{/iScheme}

							{iScheme name=form_section}
								{iScheme name=form_field_empty required=true}
									Osoby zatrudnione winny wspisywać w pola dotyczące zakładu zatrudnienia pełne dane swojej firmy.<br/>
									Osoby bezrobotne nie muszą wypełniać wspomnianych pól i mogą je pozostawić puste.
								{/iScheme}
							{/iScheme}

							{iScheme name=form_section}
								{iScheme name=form_field fieldName=company_name type=text label="Nazwa zakładu pracy" maxlength=64}{/iScheme}
								{iScheme name=form_field fieldName=company_address type=text label="Adres" maxlength=64}{/iScheme}
								{iScheme name=form_field fieldName=company_city type=text label="Miasto" maxlength=64}{/iScheme}
								{iScheme name=form_field fieldName=company_phone type=text label="Telefon" maxlength=64}{/iScheme}
								{iScheme name=form_field fieldName=company_fax type=text label="Fax" maxlength=64}{/iScheme}
								{iScheme name=form_field fieldName=company_nip type=text label="NIP" maxlength=64}{/iScheme}
							{/iScheme}

							{iScheme name=form_section}
								{iScheme name=form_field fieldName=career_path type=textarea label="Stanowiska zajmowane w okresie ostatnich dwóch lat" maxlength=255}
								{/iScheme}
							{/iScheme}

							{iScheme name=form_section}
								{iScheme name=form_field_empty}
									Czy kandydat zamierza korzystać z:<br/>
									{iInput type=checkbox name=will_use_food}
									wyżywienia w stołówce studenckiej (obiady - piątki)<br/>
									{iInput type=checkbox name=will_use_hotel}
									noclegów w Hotelu Politechniki Śląskiej<br/>
								{/iScheme}
							{/iScheme}

							{iScheme name=form_section}
								{iScheme name=form_field fieldName=notes type=textarea label="Inne uwagi" maxlength=255}
								{/iScheme}
							{/iScheme}

							{iScheme name=form_section}
								{iScheme name=form_field_empty}
									{iInput type=checkbox name=agree checked=true}
									Tak, zapoznałem się z <a href="{iURL module=library action=privacy}">Polityką Prywatności</a> portalu egie.pl i w pełni ją akceptuję.
								{/iScheme}
								{iScheme name=form_field_empty}
									<b>Na podany w formularzu adres e-mail zostaną wysłane końcowe instrukcje i potwierdzenie rejestracji.</b><br/>
								{/iScheme}
							{/iScheme}

							{iScheme name=form_section}
								{iScheme name=form_buttons form=studium}
								{/iScheme}
							{/iScheme}
							
						{/iScheme}
	{/iScheme}