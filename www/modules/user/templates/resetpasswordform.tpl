{iScheme name=boxlight3 title="Odzyskiwanie hasła"}
	{capture assign=url}{iURL module=userprofile action=resetpassword}{/capture}
	{iScheme name=form action=$url}
		{iScheme name=form_section}	
			{iScheme name=form_field_empty id=info}
				{html_image file="$iImageDir/security.gif" id=user_icon}
				<b>Proces odzyskiwania hasła wymaga podania loginu konta.</b>
				<br/>
				<br/>
				Jeśli login jest poprawny (istnieje taki użytkownik), system wygeneruje nowe, w pełni losowe hasło, które zostanie następnie przesłane na adres e-mail skojarzony z podanym kontem.
			{/iScheme}
		{/iScheme}

		{iScheme name=form_section}	
			{iScheme name=form_field fieldName=id type=text label="Login" maxlength=32 required=true}{/iScheme}
			{iScheme name=form_buttons form=studium}{/iScheme}
		{/iScheme}
	{/iScheme}
{/iScheme}
