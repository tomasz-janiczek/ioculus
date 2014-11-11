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
						<p><span class="cap">P</span>OLITECHNIKA <span class="cap">Ś</span>LĄSKA W <span class="cap">G</span>LIWICACH</p>
						<p><span class="cap">V</span>ATTENFALL <span class="cap">D</span>ISTRIBUTION <span class="cap">P</span>OLAND</p>
						<p><span class="cap">ABC</span> <span class="cap">S</span>YSTEM <span class="cap">C</span>ONSULTING SP. Z O.O.</p>
						<p><span class="cap">S</span>EKCJA <span class="cap">E</span>NERGETYKI <span class="cap">O</span>DDZIAŁU <span class="cap">G</span>LIWICKIEGO <span class="cap">SEP</span></p>
					</td>
				</tr>
				<tr>
					<td id="library_sep_invite">
						<span class="cap">Z</span>APRASZAJĄ NA SEMINARIUM PT.
					</td>
				</tr>
				<tr>
					<td id="library_sep_title">
						<span class="cap1">"N</span>OWOCZESNA ENERGETYKA I E-<span class="cap1">G</span>MINA<br/>
						<span id="library_sep_title_row2">- POŁĄCZENIE PRZYSZŁOŚCI"</span><br/>
						<span id="library_sep_title_row3">26.10.2006 GIERAŁTOWICE</span>
					</td>
				</tr>
				<tr>
					<td id="library_sep_plan">
						{capture assign=url}{iURL module=$iModuleName action=sepregister}{/capture}
						{iScheme name=form action=$url}
							{iScheme name=form_section}
								{iScheme name=form_field_empty class=library_sep_form_text} 
									<p>Dziękujemy za dokonanie rejestracji.</p>
									<p>Na adres podany w formularzu rejestracyjnym został właśnie wysłany e-mail z prośbą o potwierdzenie uczestnictwa w seminarium.</p>
									<p><b>[ Redakcja sep.egie.pl ]</b></p>
									<a href="{iURL module=$iModuleName action=sep}">{html_image file="/www/images/button_ok.gif"}</a>
								{/iScheme}
							{/iScheme}
					{/iScheme}
					</td>
				</tr>
			</table>
		</td>
		
		<td id="library_sep_col2">
			{iScheme name=boxblue title="Goście specjalni" id=library_sep_guests class=box}
				{iScheme name=content11}
				<ul>
					<li>
						Michał Czarski<br/>
						<span>Marszałek Województwa Śląskiego</span>
					</li>
					<li>
						Genowefa Grabowska<br/>
						<span>Eurodeputowana</span>
					</li>
					<li>
						Jerzy M. Szymura<br/>
						<span>Senator RP</span>
					</li>
					<li>
						Jadwiga Rudnicka<br/>
						<span>Senator RP</span>
					</li>
					<li>
						Aleksander Chłopek<br/>
						<span>Poseł RP</span>
					</li>
					<li>
						Andrzej Gałażewski<br/>
						<span>Poseł RP</span>
					</li>
					<li>
						Krystyna Szumilas<br/>
						<span>Posłanka RP</span>
					</li>
				</ul>
				{/iScheme}
			{/iScheme}

			{iScheme name=boxblue title="Komitet honorowy" id=library_sep_honor class=box}
				{iScheme name=content11}
				<ul>
					<li>
						Prof. Wojciech Zieliński<br/>
						<span>Rektor Politechniki Śląskiej w Gliwicach</span>
					</li>
					<li>
						Prof. Lesław Topór-Kamiński<br/>
						<span>Dziekan Wydziału Elektrycznego Politechniki Śląskiej w Gliwicach</span>
					</li>
					<li>
						Prezes Piotr L. Kołodziej<br/>
						<span>Vattenfall Distribution Poland</span>
					</li>
					<li>
						Prof. Jerzy Barglik<br/>
						<span>Prezes Stowarzyszenia Elektryków Polskich</span>
					</li>
					<li>
						Prof. Kazimierz Gierlotka<br/>
						<span>Prezes Oddziału Gliwickiego Stowarzyszenia Elektryków Polskich</span>
					</li>
				</ul>
				{/iScheme}				
			{/iScheme}

			{iScheme name=boxsilver title="Komitet organizacyjny" id=library_sep_organizers class=box}
				{iScheme name=content11}
				<ul>
					<li>
						prof. Jan Popczyk<br/>
						<span>Politechnika Śląska w Gliwicach</span>
					</li>
					<li>
						dr inż. Joachim Bargiel<br/>
						<span>wójt gminy Gierałtowice</span>
					</li>
					<li>		
						mgr inż. Wiesław Matulka<br/>
						<span>Energopomiar Elektryka</span>
					</li>
					<li>
						mgr inż. Albin Trybus<br/>
						<span>Przewodniczący Sekcji Energetyki O. Gliwickiego SEP</span>
					</li>
					<li>
						mgr inż. Andrzej S. Grabowski<br/>
						<span>Wiceprzewodniczący Sekcji Energetyki O. Gliwickiego SEP</span>
					</li>
					<li>
						mgr inż. Zbigniew Waliczek<br/>
						<span>ABC System Consulting sp. z o.o.</span>
					</li>
				</ul>
				{/iScheme}
			{/iScheme}

			{iScheme name=boxsilver title="Dane kontaktowe" id=library_sep_info class=box}
			<p>
				<b>Stowarzyszenie Elektryków Polskich</b><br/><br/>
				Oddział Gliwicki<br/>
				ul. Górnych Wałów 25<br/>
				44–100 Gliwice<br/>
				NIP: 526-000-09-79<br/><br/>
				tel. (032) 231 14 30<br/>
				fax. (032) 231 28 76<br/><br/>
				E-Mail: {mailto address="biuro@sep.gliwice.pl" text="biuro@sep.gliwice.pl" encode="javascript"}<br/>
				WWW: <a href="http://www.sep.gliwice.pl">www.sep.gliwice.pl</a>
			</p>
			{/iScheme}

		</td>
	</tr>
</table>
