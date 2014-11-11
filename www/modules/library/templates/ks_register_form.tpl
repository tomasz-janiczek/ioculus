{literal}
<!--[if IE]>
<style>
	#action td#library_sep_plan ul {
		margin-left:		10px;
		padding-left:		0px;
		padding-top:		10px;
		width:				97%;
	}
	
	#action td#library_sep_plan ul li {
		padding-left:		0px;
		margin-left:		20px;
	}
</style>
<![endif]-->
{/literal}

<table id="library_sep_layout">
	<tr>
		<td id="library_sep_col1">
			<table id="library_sep_col1_layout">
				<tr>
					<td id="library_sep_top_logo">
						<p><span class="cap">E</span>LEKTROWNIE <span class="cap">S</span>ZCZYTOWO-<span class="cap">P</span>OMPOWE S.A.</p>
						<p><span class="cap">S</span>TOWARZYSZENIE <span class="cap">E</span>NERGII <span class="cap">O</span>DNAWIALNEJ</p>
						<p><span class="cap">S</span>TOWARZYSZENIE <span class="cap">N</span>IEZALEŻNYCH <span class="cap">W</span>YTWÓRCÓW <span class="cap">E</span>NERGII <span class="cap">S</span>KOJARZONEJ</p>
						<p><span class="cap">ESP U</span>SŁUGI SP. Z O.O.</p>
					</td>
				</tr>
				<tr>
					<td id="library_sep_invite">
						<span class="cap">Z</span>APRASZAJĄ NA KONFERENCJĘ POD TYTUŁEM
					</td>
				</tr>
				<tr>
					<td id="library_sep_title">
						"<span class="cap1">E</span>NERGETYKA ROZPROSZONA SZANSĄ DLA<br/>
						<span id="library_sep_title_row1">ENERGETYKI ODNAWIALNEJ W POLSCE.</span><br/>
						<span class="cap1">N</span>OWOCZESNA ENERGETYKA ROZPROSZONA<br/>
						<span id="library_sep_title_row2">I INFRASTRUKTURA W E-GMINACH"</span><br/>
						<span id="library_sep_title_row3">20.10.2006 WARSZAWA, BUDYNEK EKOENERGOCENTRUM, UL. OGRODOWA 59A</span>
					</td>
				</tr>
				<tr>
					<td id="library_sep_plan">
						{capture assign=url}{iURL module=$iModuleName action=ksregister}{/capture}
						{iScheme name=form action=$url}
							{iScheme name=form_section}
								{iScheme name=form_field_empty class=library_sep_form_text}
									Warunkiem uczestnictwa w konferencji jest dokonanie wcześniejszej rejestracji, oraz potwierdzenie jej zgodnie z instrukcjami, które zostaną wysłane na podany w formularzu adres e-mail.<br/>
									Prośbę o potwierdzenie uczestnictwa w konferencji wysyłamy w ciągu najdalej <b>24 godzin</b> od otrzymania formularza zgłoszeniowego.
								{/iScheme}
							{/iScheme}

							{iScheme name=form_section}
								{iScheme name=form_field_empty}
									Prosimy o dokładne przeczytanie formularza przed jego wysłaniem i korzystanie z przycisku <b>"Sprawdź"</b>.<br/>
									W razie jakichkolwiek problemów lub pytań do dyspozycji Państwa pozostaje {mailto address="boguslaw.szewc@egie.pl" text="<b>redaktor serwisu</b>" encode=javascript_charcode} ks.egie.pl.
									<br/><br/>
									{html_image file="/www/images/warning.gif"}&nbsp;&nbsp;&nbsp;&nbsp;Pola wymagane
								{/iScheme}
							{/iScheme}

							{iScheme name=form_section}
								{iScheme name=form_field fieldName=name type=text label="Imię" maxlength=32 required=true}{/iScheme}
								{iScheme name=form_field fieldName=lastname type=text label="Nazwisko" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=email type=text label="E-Mail" maxlength=64 required=true}{/iScheme}
							{/iScheme}

							{iScheme name=form_section}							
								{iScheme name=form_field fieldName=company type=text label="Firma / Gmina" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=address type=text label="Adres" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=city type=text label="Miejscowość" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=phone type=text label="Telefon" maxlength=64 required=true}{/iScheme}
								{iScheme name=form_field fieldName=fax type=text label="Fax" maxlength=64}{/iScheme}								
								{iScheme name=form_field fieldName=notes type=textarea label="Uwagi" maxlength=255}{/iScheme}
							{/iScheme}

							{iScheme name=form_section}							
								{iScheme name=form_buttons}
								{/iScheme}
							{/iScheme}

						{/iScheme}
					</td>
				</tr>
				<tr>
					<td id="library_sep_bar">
						{iScheme name=bar text="Weź udział w konferencji!"}
						{/iScheme}
					</td>
				</tr>
			</table>
		</td>
		
		<td id="library_sep_col2">
			{iScheme name=boxblue title="Sponsor generalny" id=library_sep_guests class=box}
				{iScheme name=content11}
				<ul>
					<li>
						Elektrownie Szczytowo-Pompowe S.A.<br/>
						<a href="http://www.elsp.com.pl"><span>www.elsp.com.pl</span></a>
					</li>
				</ul>
				{/iScheme}
			{/iScheme}

			{iScheme name=boxblue title="Organizatorzy" id=library_sep_honor class=box}
				{iScheme name=content11}
				<ul>
					<li>
						Stowarzyszenie Energii Odnawialnej<br/>
						<a href="http://www.seo.org.pl"><span>Koordynator<br/>www.seo.org.pl</span></a>
					</li>
					<li>
						Stowarzyszenie Niezależnych Wytwórców Energii Skojarzonej<br/>
						<a href="http://www.snwes.pl"><span>Organizator ds. merytorycznych<br/>www.snwes.pl</span></a>
					</li>
					<li>
						ESP-Usługi<br/>
						<a href="http://www.esp-uslugi.com.pl"><span>Catering<br/>www.esp-uslugi.com.pl</span></a>
					</li>
				</ul>
				{/iScheme}				
			{/iScheme}

			{iScheme name=boxsilver title="Uczestnicy" id=library_sep_organizers class=box}
				{iScheme name=content11}
				<ul>
					<li>
						Członkowie Senackiej Komisji Gospodarki Narodowej <br/>
					</li>
					<li>
						Polskie Sieci Elektroenergetyczne S.A.<br/>
					</li>
					<li>
						Polskie Górnictwo Naftowe i Gazownictwo S.A.<br/>
					</li>
					<li>		
						Gmina Zagórz<br/>
					</li>
					<li>		
						Gmina Kleszczów<br/>
					</li>
					<li>		
						Gmina Gierałtowice<br/>
					</li>
					<li>		
						Związek Gmin Wiejskich<br/>
					</li>
					<li>		
						Związek Powiatów Polskich<br/>
					</li>
					<li>		
						Związek Miast Polskich<br/>
					</li>
					<li>		
						Gminy województwa wielkopolskiego<br/>
					</li>
					<li>		
						Polskie Elektrownie Gazowe Sp. z o.o.<br/>
					</li>
					<li>		
						Elektrownie Górnej Odry<br/>Sp. z o.o.<br/>
					</li>
					<li>		
						Bio–Energia ESP Sp. z o.o.<br/>
					</li>
					<li>		
						Elektrownia Wiatrowa Kamieńsk Sp. z o.o.<br/>
					</li>
					<li>		
						Energetyka Cieplna Opolszczyzny S.A.<br/>
					</li>
				</ul>
				{/iScheme}
			{/iScheme}

			{iScheme name=boxsilver title="Dane kontaktowe" id=library_sep_info class=box}
			<p>
				<b>Stowarzyszenie Energii Odnawialnej - koordynator</b><br/><br/>
				ul. Ogrodowa 59a<br/>
				00-876 Warszawa<br/><br/>
				tel. (022) 433 12 38<br/>
				fax. (022) 433 12 39<br/><br/>
				WWW: <a href="http://www.seo.org.pl">www.seo.org.pl</a>
			</p>
			{/iScheme}

		</td>
	</tr>
</table>
