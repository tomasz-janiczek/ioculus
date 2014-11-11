	<div id="column1">
		{iScheme name=boxlight3 title="Konwersatorium \"Energetyka przyszłości\""}
			{iScheme name=layout1 image="/www/images/illustration_26.jpg"}
				<b>Pole wymiany wiedzy i poglądów o przyszłości energetyki w zakresie technologii oraz uwarunkowań ekonomicznych, prawnych i socjologicznych.</b>
				<br/>
				<br/>
				Zapraszamy wszystkich, którzy interesują się przyszłością energetyki, do udziału w interaktywnym przedsięwzięciu, które nazwaliśmy <i>„Konwersatorium ‘Energetyka przyszłości’”</i>
				{capture assign=url}{iURL module=library action=studium}{/capture}
				{iScheme name=readmore link=$url}
				{/iScheme}
			{/iScheme}
		{/iScheme}

		{iScheme name="boxlight3" title="Bieżące" id=actual}
			{iScheme name=layout2}
			{section loop=$problems name=i}
				<li><a href="{iURL module=library action=main id=$problems[i].id}">{$problems[i].title|truncate:75}</a></li>
			{/section}
			{/iScheme}

			{capture assign=url}{iURL module=library action=knowhow}{/capture}
			{iScheme name=readmore link=$url}
			{/iScheme}
		{/iScheme}

		{iScheme name="boxlight3" title="Oferta dla Gmin, Deweloperów, Klientów"}
			{capture assign=link}{iURL module=library action=offer}{/capture}
			{iScheme name=layout3 image="/www/images/illustration_2.jpg"}
					<li class="first">
						<b>Rozwiązania dla gmin</b><br/>
						<a href="{iURL module=library action=offer for=community}">
						Jeśli jesteś zainteresowany promocją swojej gminy w kraju, jej rozwojem i współpracą z przedsiębiorstwami, w szczególności energetycznymi
						</a>
					</li>
					<li>
						<b>Rozwiązania dla deweloperów</b><br/>
						<a href="{iURL module=library action=offer for=developer}">
						Jeśli zarządzasz firmą i chcesz wkroczyć na nowe rynki, lub znacznie obniżyć koszty swojej działalności
						</a>
					</li>
					<li><b>Rozwiązania dla klientów</b><br/>
					Jeśli interesuje Cię szybki, wygodny i atrakcyjny cenowo zakup produktu lub usługi
					</li>
			{/iScheme}
		{/iScheme}

		{capture assign=url}{iURL module=user action=registerform}{/capture}
		{iScheme name=bar text="Dołącz do eGIE, zarejestruj się za darmo!" link=$url}
		{/iScheme}

		{iScheme name="boxlight3" title="Oferta dla Studentów, Doktorantów, Absolwentów 2007"}
			{capture assign=link}{iURL module=library action=offer type=2}{/capture}
			{iScheme name=layout3 image="/www/images/illustration_3.jpg"}
				<li><b>Rozwiązania dla studentów</b><br/>
					<a href="{iURL module=library action=students}">
					Jeśli studiujesz, chcesz zdobyć staż i praktykę, przygotować się do przyszłej, własnej działalności gospodarczej, lub sprzedać swoje pomysły
					</a>
				</li>
				<li><b>Rozwiązania dla doktorantów</b><br/>
				Jeśli szukasz rzetelnego źródła informacji, ekspertów w danej branży, lub pragniesz wdrożyć komercyjnie opracowane przez siebie rozwiązania
				</li>
				<li><b>Rozwiązania dla absolwentów</b><br/>
				Jeśli skończyłeś lub właśnie kończysz studia, szukasz interesującej pracy i możliwości szybkiego dostosowania się do rynku
				</li>
			{/iScheme}
		{/iScheme}

		{iScheme name=boxlight3 title="Wydarzenia"}
			{section name="i" loop=$newses}
				{capture assign=url}{iURL module=library action=main id=$newses[i].id}{/capture}
				{iScheme name=layout4 title=$newses[i].title|wordwrap:50 link=$url author=$newses[i].handle date=$newses[i].date|date_format:"%d.%m.%Y"}
					{$newses[i].content|truncate:500}
				{/iScheme}
			{/section}
		{/iScheme}

	</div>

	<div id="column2">
	{if !$iUserLoggedIn}		
		{iScheme name=boxgreen title="Logowanie"}
		{/iScheme}
	{else}
		{iScheme name=boxgreen title=$fullname}
			Witaj w sieci <b>eGIE</b>!<br/><br/>
			<b>Wybierz opcję</b><br/>
			<ul>
			{if $accessAdminPanel}
			<li><a href="{iURL module=adminpanel}" title="Panel administracyjny">Panel administracyjny</a></li>
			{/if}
			<li>{mailto address="redakcja@egie.pl" text="Zadaj pytanie (pomoc)" encode=hex}</li>
			<li>{mailto address="admin@egie.pl" text="Poinformuj o problemie" encode=hex}</li>
			{if $accessProfile}
			<li><a href="{iURL module=userprofile action=editform id=$iUser->getProperty('perm_user_id')}" title="Profil użytkownika">Profil użytkownika</a></li>
			{/if}
			<li><a href="{iURL module=user action=logout}" title="Wyloguj">Wyloguj</a></li>
			</ul>
		{/iScheme}
	{/if}

		{iScheme name=boxblue title="Gminy"}
			<ul>
				<li><a href="http://www.kleszczow.pl">Gmina Kleszczów</a></li>
				<li><a href="http://www.zagorz.net">Gmina Zagórz</a></li>
				<li><a href="http://www.gieraltowice.pl">Gmina Gierałtowice</a></li>
				<li><a href="http://www.strzelceopolskie.pl">Gmina Strzelce Opolskie</a></li>
			</ul>
		{/iScheme}
				
		{iScheme name=boxblue title="Deweloperzy"}
			<ul>
				<li><a href="http://www.kleszczow.egie.com.pl">ARR Arreks S.A.</a></li>
				<li><a href="http://www.zut.zagorz.net">ZUT Sp. z o.o.</a></li>
				<li><a href="http://www.esp-uslugi.com.pl">ESP Usługi</a></li>
				<li><a href="http://www.megaterm.com.pl">Megaterm S.A.</a></li>
				<li><a href="http://www.eljotelectronic.republika.pl">ELJOT Electronic</a></li>
			</ul>
		{/iScheme}

		{iScheme name=boxlight3 id=partners title="Nasi partnerzy" dot=true}
			<a href="http://www.seo.org.pl">{html_image file="$iImageDir/intro/seo.gif"}</a>
			<a href="http://www.snwes.pl">{html_image file="$iImageDir/intro/snwes.gif"}</a>
		{/iScheme}

		{iScheme name=boxlight3 title="Dane teleadresowe" dot=true}
			{iScheme name=content5}
			{/iScheme}
		{/iScheme}
	</div>