{iScheme name=boxlight3 title="Rejestracja nowego użytkownika" id=registerform}

{capture assign=url}{iURL module=userprofile action=register}{/capture}
{iScheme name=form action=""}
	{iScheme name=form_section}	
		{iScheme name=form_field_empty id=info}
			{html_image file="$iImageDir/adduser.gif" id=user_icon}
			<p>
				Proces rejestracji wymaga podania tylko kilku najbardziej podstawowych informacji.<br/>
				Bardziej zaawansowane opcje profilu dostępne są już po zarejestrowaniu.
			</p>
		{/iScheme}
	{/iScheme}
	
	{iScheme name=form_section}
		{iScheme name=form_field_empty}
			Objaśnienia poszczególnych pól:<br/>
			<ul>
				<li>Login - dowolnie obrana nazwa użytkownika o długości od 3 do 32 znaków.<br/>
				Sugerowana składnia: <i>imię.nazwisko</i>. Należy pamiętać, że dany login może już być zajęty.</li>
				<li>Hasło - dowolnie obrane hasło o długości od 6 do 32 znaków.</li>
				<li>Powtórz hasło - potwierdzenia hasła (dla uniknięcia błędów występujących przy wprowadzaniu).</li>
				<li>E-Mail - adres poczty elektronicznej, służący do kontaktu z użytkownikiem. Prosimy uważnie wypełnić to pole, jako że na wprowadzony tutaj adres wysyłana zostanie prośba o potwierdzenie rejestracji, a także ewentualne wiadomości serwisu, odzyskane hasła itp.</li>
				<li>Powtórz e-mail - potwierdzenia adresu poczty elektronicznej (dla uniknięcia błędów występujących przy wprowadzaniu).</li>
			</ul>
		{/iScheme}
	{/iScheme}

	{iScheme name=form_section}
		{iScheme name=form_field_empty}
			Prosimy o dokładne przeczytanie formularza przed jego wysłaniem.<br/>
			W razie jakichkolwiek problemów lub pytań prosimy o kontakt z <b>{mailto address="admin@egie.pl" text="administratorem" encode=hex}</b> egie.pl.<br/><br/>
			<b>Na podany w formularzu adres e-mail zostaną wysłane końcowe instrukcje i potwierdzenie rejestracji.</b>
		{/iScheme}
		<br/>
		{iScheme name=form_field_empty}
			{html_image file="/www/images/warning.gif"}&nbsp;&nbsp;&nbsp;&nbsp;Pola wymagane	
		{/iScheme}
	{/iScheme}

	{iScheme name=form_section}	
		{iScheme name=form_field fieldName=handle type=text label="Login" maxlength=32 required=true}{/iScheme}
		{iScheme name=form_field fieldName=passwd type=password label="Hasło" maxlength=32 required=true}{/iScheme}
		{iScheme name=form_field fieldName=passwd_confirm type=password label="Powtórz hasło" maxlength=32 required=true}{/iScheme}
		{iScheme name=form_field fieldName=email type=text label="E-Mail" maxlength=255 required=true}{/iScheme}
		{iScheme name=form_field fieldName=email_confirm type=text label="Powtórz e-mail" maxlength=255 required=true}{/iScheme}
		{iScheme name=form_field_labeled}
			{iInput type=checkbox name=agree checked=true}
			Oświadczam, iż zapoznałem(am) się z <a href="{iURL module=library action=privacy}">Polityką Prywatności</a> portalu egie.pl i w pełni ją akceptuję.
		{/iScheme}
		{iScheme name=form_buttons}{/iScheme}
	{/iScheme}
{/iScheme}

{/iScheme}
