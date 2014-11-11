{literal}
<!--[if IE]>
<style>
	#action #library_register td.scheme_boxyellow_td2 {
		padding-top:		15px;
	}	

	#action #library_register p {
		margin-bottom:		15px;
	}	
</style>
<![endif]-->
{/literal}

<table id="library_studium_main">
	<tr>
		<td id="library_studium_main_col1">
			{if !$iUserLoggedIn}
			{iScheme name=boxyellow title="Rejestracja" id=library_register}
				<p>
					Nie masz jeszcze konta?<br/>
					<a href="{iURL module=user action=registerform}">Zarejestruj się</a>, a uzyskasz dostęp do licznych materiałów, opracowań i informacji.<br/>
					Wystarczy kilka kliknięć!
				</p>
					<div id="library_register_button">
						<a href="{iURL module=$iModuleName action=$iActionName id=1}">
							<p>zarejestruj się!</p>
						</a>
					</div>
			{/iScheme}
			{/if}

			{iScheme name=boxsilver title="Skrypt" id="library_download"}
				{if $files}

				Profesor Jan Popczyk<br/>"Zarządzanie i ekonomika na rynkach usług infrastrukturalnych"<br/><br/>
				<table>
				{section name=i loop=$files}
					<tr>
						<td>{html_image file="$iImageDir/pdf.gif"}</td>
						<td><a href="{iURL module=archive action=download id=$files[i].id mode=empty}">{$files[i].description|truncate:60}</a></td>
					</tr>
				{/section}
				</table>
				
				{else}
				
				<table>
					<tr>
						<td>Aby uzyskać dostęp do skryptu profesora Jana Popczyka "Zarządzanie i ekonomika na rynkach usług infrastrukturalnych", prosimy najpierw zalogować się na <a href="{iURL module=news action=intro}">stronie głównej</a></td>
					</tr>
				</table>
				
				{/if}
			{/iScheme}

			{iScheme name=boxsilver title="Opracowania studenckie" id="library_download1"}
				{if $student_files}

				Opracowania studenckie, rok akademicki 2005/2006<br/><br/>
				<table>
				{section name=i loop=$student_files}
					<tr>
						<td>{html_image file="$iImageDir/pdf.gif"}</td>
						<td><a href="{iURL module=archive action=download id=$student_files[i].id mode=empty}">{$student_files[i].description|truncate:60}</a></td>
					</tr>
				{/section}
				</table>
				
				{else}
				
				<table>
					<tr>
						<td>Aby uzyskać dostęp do materiałów i opracowań studenckich, prosimy najpierw zalogować się na <a href="{iURL module=news action=intro}">stronie głównej</a></td>
					</tr>
				</table>
				
				{/if}
			{/iScheme}
		</td>

		<td id="library_studium_main_col2">
		</td>

		<td id="library_studium_main_col3">
			<span id="library_studium_main_prev_container">
				{if $iActionArgs.id}
					{iIncludeTemplate file="www/modules/library/templates/studium_register_form_ajax.tpl"}
				{else}
					{iScheme name=boxlight4 id=library_studium_main_prev noicon=true}
						<table id="library_intro">
							<tr>
								<td colspan="2" id="library_intro_title">
									<span>S</span>ERWIS <span>S</span>TUDENCI.EGIE.PL
								</td>
							</tr>
							<tr>
								<td id="library_intro_logo">
									{html_image file="$iImageDir/academic_cap.jpg" style="margin-top: 30px"}
								</td>
								<td id="library_intro_depart">
									<span class="big"><span>W</span>YDZIAŁ <span>E</span>LEKTRYCZNY</span><br/>
									<div>
									  <span>I</span>NSTYTUT <span>E</span>LEKTROENERGETYKI I <span>S</span>TEROWANIA <span>U</span>KŁADÓW<br/>
									  <span>I</span>NSTYTUT <span>M</span>ETROLOGII I <span>A</span>UTOMATYKI <span>E</span>LEKTROTECHNICZNEJ<br/>
								    </div>
									<span class="big"><span>W</span>YDZIAŁ <span>I</span>NŻYNIERII <span>Ś</span>RODOWISKA I <span>E</span>NERGETYKI</span><br/>
									<div>
									  <span>I</span>NSTYTUT <span>T</span>ECHNIKI <span>C</span>IEPLNEJ<br/>
									 </div>
								</td>
							</tr>
							<tr>
								<td colspan="2" id="library_intro_invite">
									<span>O</span>FERTA, CZYLI CO MAMY DLA CIEBIE, DROGI STUDENCIE?
								</td>
							</tr>
							<tr>
								<td colspan="2" id="library_intro_spec">
									<ul>
										<li><span>K</span>ONTAKT z <span>P</span>OTENCJALNYM <span>P</span>RACODAWCĄ</li>
										<li><span>K</span>ONTAKT z <span>P</span>OTENCJALNYM <span>I</span>NWESTOREM</li>
										<li><span>M</span>OŻLIWOŚĆ <span>P</span>UBLIKACJI <span>W</span>ŁASNYCH <span>A</span>RTYKUŁÓW I <span>P</span>OMYSŁÓW</li>
										<li><span>M</span>OŻLIWOŚĆ <span>D</span>O</span>ŁĄCZENIA <span>D</span>O <span>E</span>GIE</li>
										<li><span>M</span>OŻLIWOŚĆ <span>D</span>O</span>KSZTAŁCENIA <span>S</span>IĘ I <span>D</span>OSTOSOWANIA DO <span>A</span>KTUALNYCH <span>P</span>OTRZEB <span>R</span>YNKU <span>P</span>RACY</li>
									</ul>
								</td>
							</tr>
						</table>
					{/iScheme}
				{/if}
			</span>
			
			{iScheme name=bar id=library_register_bar}
				<div>Nie bój się niezależności!</div>
			{/iScheme}

			{iScheme name=boxlight4 title="Pigułka Pomysłów Studenta" class="art"}
				{html_image file="$iImageDir/image1.jpg"}
				<p>To baza opracowań studentów, którzy konsekwentnie zabrali się do pracy i stworzyli innowacyjne biznes plany, dzięki czemu mają szansę podjąć współpracę z Deweloperem eGIE zainteresowanym praktycznym wdrożeniem pomysłu.</p>
				<p>A może sam posiadasz wiedzę praktyczną i chciałbyś zostać Deweloperem? Czy wiesz, że właśnie tu i teraz, w eGIE, masz wielką szansę zacząć pracować na swój własny rachunek? Założyć własną firmę? Stać się niezależnym finansowo?</p>
				<p>Wyobraź sobie, że masz szanse przełożyć każdy pomysł na praktyczny biznes plan i zrealizować go, a następnie zebrać owoce swojej pracy.</p>
				<ul>
					<li>Czy chciałbyś być częścią tej grupy kreatywnych ludzi, którzy stali się wyśmienicie zarabiającymi Deweloperami?</li>
					<li>Czy wiesz jaką siłą jest pozyskanie partnerów, gdy nie masz wystarczających środków do realizacji Twojego pomysłu?</li>
					<li>A może po prostu chciałbyś się wypromować poprzez dobry projekt i zatrudnić u jednego z Deweloperów?</li>
				</ul>
				<p>Jeśli masz dość odwagi, by stać się kimś więcej, niż tylko kolejnym trybikiem w wielkich machinach przedsiębiorstw, jeśli Twoje ambicje sięgają wyżej i dalej i wiesz, że odpowiedź na któreś z powyższych pytań jest twierdząca...</p>
				<br/>
				<p class="art_link"><a href="{iURL module=contact}"><strong>SKONTAKTUJ SIĘ Z NAMI!</strong></a></p>
				<br/>
			{/iScheme}

			{if $news}
			{iScheme name=boxlight4 notitle=true}
				{section name="i" loop=$news}
					{capture assign=link}{iURL module=library action=main id=$news[i].id}{/capture}
					{iScheme name=content2 title=$news[i].title content=$news[i].description|truncate:500 image=$news[i].image link=$link date=$news[i].date|date_format:"%m-%d-%Y" author=$news[i].author}
					{/iScheme}
				{/section}
			{/iScheme}
			{/if}
		</td>
	</tr>
</table>
