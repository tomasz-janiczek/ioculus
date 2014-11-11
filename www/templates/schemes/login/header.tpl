<tr><td>
	<span></span>
	<form name="loginform" method="post" action="{iURL module=user action=login}">
		{iInput type=text name="login" label="Login"}
		{iInput type=password name="password" label="Hasło"}
		<p>{iInput type=checkbox name=remember}Zapamiętaj mnie</p>
		{iInput type="image" src="/www/images/button_login.gif"}
		<p id="scheme_login_line1">Nie masz konta? <a href="{iURL module=user action=registerform}">Zarejestruj się!</a></p>
		<p>A może <a href="{iURL module=user action=resetpasswordform}">zapomniałeś hasła</a>?</p>
	</form>
