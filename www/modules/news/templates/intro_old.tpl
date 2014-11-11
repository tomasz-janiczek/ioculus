<div>
	<div class="column1">
	</div>

	<div class="column2">
	</div>

	<div class="column3">
	</div>	
</div>


<!--	
		<td id="main_col1">
			{iScheme name=boxlight3 title="Konwersatorium \"Energetyka przyszłości\"" class="main_conv"}
				<a href="{iURL module=library action=conversatory}" class="underline">
					<p>{html_image file="/www/images/illustration_26.jpg" style="float:left;margin-right:10px;padding:5px;border:1px solid #eeeeee;"}
					<b>Pole wymiany wiedzy i poglądów o przyszłości energetyki w zakresie technologii oraz uwarunkowań ekonomicznych, prawnych i socjologicznych.</b>
					</p>
					<p class="ind">
					Zapraszamy wszystkich, którzy interesują się przyszłością energetyki, do udziału w interaktywnym przedsięwzięciu, które nazwaliśmy <i>„Konwersatorium ‘Energetyka przyszłości’”</i>
					</p>
				</a>
			{/iScheme}

			<table id="main_col1_row1">
				<tr>
					<td id="main_col1_row1_td1">
						{iScheme name="boxlight3" title="Bieżące" id="main_problemy"}
							<ul>
							{section loop=$problems name=i}
								<li class="underline"><a href="{iURL module=library action=main id=$problems[i].id}">{$problems[i].title|truncate:45}</a></li>
							{/section}
							</ul> 
							<a href="{iURL module=library action=main}">{html_image file="/www/images/read_more_blue.gif"}</a>
						{/iScheme}
					</td>
					<td  id="main_col1_row1_td2">
						{iScheme name="boxlight3" title="Zapraszamy do podserwisów" id="main_promo"}
							<div>
								<a href="http://studenci.egie.pl" class="underline">
								<ul>
									<li>
										<b>Serwis "studenci.egie.pl"<br/></b>
										<p>
											Witryna wspomagająca dydaktycznie studentów, ułatwiająca kontakt z pracodawcami, a także umożliwiająca praktyczną realizację autorskich koncepcji biznesowych.
										</p>
									</li>
								</ul>
								</a>
							</div>
							<div>
								<a href="http://studium.egie.pl" class="underline">
								<ul>
									<li>
										<b>"Rynek energii. Audyt energetyczny. Energetyka rozproszona i e-Infrastruktura<br/>
										w gminach"</b><br/>
										<p>
											Studium Podyplomowe Politechniki Śląskiej.
										</p>
									</li>
								</ul>
								</a>
							</div>
						{/iScheme}
					</td>
				</tr>
			</table>
			
			{iScheme name="boxlight3" title="Rozwiązania dla Gmin, Deweloperów, Klientów ..." id="main_solutions"}
				{capture assign=link}{iURL module=library action=offer}{/capture}
				{iScheme name=content1 schemeName=boxlight3 image="/www/images/illustration_2.jpg" array=false}
					<ul class="news_main_solutions_ul">
						<li class="first">
							<b>Rozwiązania dla gmin</b><br/>
							<a href="{iURL module=library action=offer for=community}" class="underline">
							Jeśli jesteś zainteresowany promocją swojej gminy w kraju, jej rozwojem i współpracą z przedsiębiorstwami, w szczególności energetycznymi
							</a>
						</li>
						<li>
							<b>Rozwiązania dla deweloperów</b><br/>
							<a href="{iURL module=library action=offer for=developer}" class="underline">
							Jeśli zarządzasz firmą i chcesz wkroczyć na nowe rynki, lub znacznie obniżyć koszty swojej działalności
							</a>
						</li>
						<li><b>Rozwiązania dla klientów</b><br/>
						Jeśli interesuje Cię szybki, wygodny i atrakcyjny cenowo zakup produktu lub usługi
						</li>
					</ul>
				{/iScheme}
			{/iScheme}

			<a href="{iURL module=user action=registerform}">
			{iScheme name=bar text="Dołącz do eGIE, zarejestruj się za darmo!" id="main_register_button"}
			{/iScheme}
			</a>

			{iScheme name="boxlight3" title="Studenci, Doktoranci, Absolwenci 2006" id="main_edu_solutions"}
				{capture assign=link}{iURL module=library action=offer type=2}{/capture}
				{iScheme name=content1 schemeName=boxlight3 image="/www/images/illustration_3.jpg" array=false}
					<ul class="news_main_solutions_ul">
						<li class="first"><b>Rozwiązania dla studentów</b><br/>
							<a href="{iURL module=library action=students}" class="underline">
							Jeśli studiujesz, chcesz zdobyć staż i praktykę, przygotować się do przyszłej, własnej działalności gospodarczej, lub sprzedać swoje pomysły
							</a>
						</li>
						<li><b>Rozwiązania dla doktorantów</b><br/>
						Jeśli szukasz rzetelnego źródła informacji, ekspertów w danej branży, lub pragniesz wdrożyć komercyjnie opracowane przez siebie rozwiązania
						</li>
						<li><b>Rozwiązania dla absolwentów</b><br/>
						Jeśli skończyłeś lub właśnie kończysz studia, szukasz interesującej pracy i możliwości szybkiego dostosowania się do rynku
						</li>
					</ul>
				{/iScheme}
			{/iScheme}

			{iScheme name=boxlight4 title="Wydarzenia" id=main_news}
				{section name="i" loop=$newses}
					{capture assign=link}{iURL module=library action=main id=$newses[i].id}{/capture}
					{iScheme name=content2 title=$newses[i].title|wordwrap:50:"<br/>" content=$newses[i].content link=$link date=$newses[i].date|date_format:"%d.%m.%Y" author=$newses[i].handle}
					{/iScheme}
				{/section}
			{/iScheme}

		</td>
		
		<td id="main_col2">
		</td>

		<td id="main_col3">
			{if !$iUserLoggedIn}		
				{iScheme name="boxyellow" title="Logowanie" id="main_login"}
					{iScheme name="login"}{/iScheme}
				{/iScheme}
			{else}
				{iScheme name="boxyellow" title=$fullname id="main_login"}
					{iScheme name="content10"}
						Witaj w sieci <b>eGIE</b>!<br/><br/>
						<b>Wybierz opcję</b><br/>
						<ul>
						{if $accessAdminPanel}
						<li><a href="{iURL module=sysmodman action=adminpanel}" title="Panel administracyjny">Panel administracyjny</a></li>
						{/if}

						{if $accessProjectManager}
						<li><a href="{iURL module=phpeasyproject action=login}" title="Menadżer projektów">Menadżer projektów</a></li>
						{/if}
												
						<li>{mailto address="redakcja@egie.pl" text="Zadaj pytanie (pomoc)" encode="hex"}</li>
						<li>{mailto address="admin@egie.pl" text="Poinformuj o problemie" encode="hex"}</li>
						{if $accessProfile}
						<li><a href="{iURL module=userprofile action=editform id=$iUser->getProperty('perm_user_id')}" title="Profil użytkownika">Profil użytkownika</a></li>
						{/if}
						<li><a href="{iURL module=user action=logout}" title="Wyloguj">Wyloguj</a></li>
						</ul>

					{/iScheme}
				{/iScheme}
			{/if}

			{iScheme name="boxblue" title="Gminy" id="main_gminy"}
				<table>
				<tr><td id="main_gminy_td1">
					<ul>
						<li><a href="javascript:sitePopUp('http://www.kleszczow.pl')">Gmina Kleszczów</a></li>
						<li><a href="javascript:sitePopUp('http://www.zagorz.net')">Gmina Zagórz</a></li>
						<li><a href="javascript:sitePopUp('http://www.gieraltowice.pl')">Gmina Gierałtowice</a></li>
						<li><a href="javascript:sitePopUp('http://www.strzelceopolskie.pl')">Gmina Strzelce Opolskie</a></li>
					</ul>
				</td></tr>
				<tr><td id="main_gminy_td2">
				</td></tr>
				</table>
			{/iScheme}

			{iScheme name="boxblue" title="Deweloperzy" id="main_deweloperzy"}
				<table>
				<tr><td id="main_deweloperzy_td1">
					<ul>
						<li><a href="javascript:sitePopUp('http://www.kleszczow.egie.com.pl')">ARR Arreks S.A.</a></li>
						<li><a href="javascript:sitePopUp('http://www.zut.zagorz.net')">ZUT Sp. z o.o.</a></li>
						<li><a href="javascript:sitePopUp('http://www.esp-uslugi.com.pl')">ESP Usługi</a></li>
						<li><a href="javascript:sitePopUp('http://www.megaterm.com.pl')">Megaterm S.A.</a></li>
						<li><a href="javascript:sitePopUp('http://www.eljotelectronic.republika.pl')">ELJOT Electronic</a></li>
					</ul>
				</td></tr>
				<tr><td id="main_deweloperzy_td2">
				</td></tr>
				</table>
			{/iScheme}

			{iScheme name="boxsilver" title="Dane teleadresowe" id="main_contact"}
				{iScheme name="content5"}
				{/iScheme}
			{/iScheme}

			{iScheme name="boxsilver" title="Nasi partnerzy" id="main_partners"}
				<a href="javascript:sitePopUp('http://www.seo.org.pl')">{html_image file="$iImageDir/intro/seo.gif"}</a>
				<a href="javascript:sitePopUp('http://www.snwes.pl')">{html_image file="$iImageDir/intro/snwes.gif" class="logo"}</a>
			{/iScheme}
		</td>
	</tr>
</table>

-->