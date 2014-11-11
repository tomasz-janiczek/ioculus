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

<table id="library_layout">
	<tr>
		<td id="library_col1">
			{iScheme name=panel id="library_nav" title="Nawigacja" module=$iModuleName action=conversatory1 content=$chapters}
			{/iScheme}

			{iScheme name=boxyellow title="Spotkania konwersatorium" id="library_meetings"}
				<ul>
					<li>
						<a href="{iURL module=$iModuleName action=conversatory3}">
							Spotkanie pierwsze<br/>
							<span>9 listopad 2006</span>
						</a>
					</li>
					<li class="current">
						<a href="{iURL module=$iModuleName action=conversatory4}">
							Spotkanie drugie<br/>
							<span>7 grudzień 2006</span>
						</a>
					</li>
				</ul>
				<p>Aby uzyskać bliższe informacje na temat danego spotkania konwersatorium, proszę kliknąć na wybranej pozycji.</p>
			{/iScheme}

			{iScheme name=boxsilver title="Ostatnio dodane" id="library_newest"}
				<ul>
					{foreach from=$newest item=title key=id}
					<li>
						<a href="{iURL module=$iModuleName action=conversatory2 id=$id}" title="{$title}">{$title}</a>
					</li>
					{/foreach}
				</ul>
			{/iScheme}

			{iScheme name=boxblue title="Najczęściej czytane" id="library_topart"}
				<ul>
					{foreach from=$topart item=title key=id}
					<li>
						<a href="{iURL module=$iModuleName action=conversatory2 id=$id}" title="{$title}">{$title}</a>
					</li>
					{/foreach}
				</ul>
			{/iScheme}
		</td>

		<td id="library_col2">
		</td>

		<td id="library_col3">
			<div id="conv_logo">
				<div class="conv_logo_text1">
					<span>K</span>ONWERSATORIUM
				</div>
				<div class="conv_logo_text2">
					"<span>E</span>NERGETYKA <span>P</span>RZYSZŁOŚCI"
				</div>
				<div class="conv_logo_text3">
					PLATFORMA WYMIANY WIEDZY I POGLĄDÓW O PRZYSZŁOŚCI ENERGETYKI
				</div>
				<div class="conv_text1">
					Zapraszamy wszystkich, którzy interesują się przyszłością energetyki, do udziału w interaktywnym przedsięwzięciu, które nazwaliśmy <b>„Konwersatorium ‘Energetyka przyszłości’”</b>. Przewidujemy wstępnie – bo rozwój konwersatorium może podpowiedzieć niejedną modyfikację – poniżej opisane i rozwinięte zakresy tematyczne.
                    <br/>
<!--                    <a href="{iURL module=$iModuleName action=conversatory3}"><p style="text-align:center;font-weight:bold;font-size:14px">Pierwsze spotkanie Konwersatorium</p></a> -->
				</div>
			</div>

			{iScheme name=boxlight4 title="Technologie energetyczne" class="conv_block"}
				<table class="conv_block_desc"><tr>
					<td class="conv_icon">
						{html_image file="$iImageDir/conv1.gif"}<br/>
					</td>
					<td>
						<b>Technologie energetyczne</b> w kontekście uniwersalizacji technologii dla elektroenergetyki, ciepłownictwa i transportu, w kontekście komercjalizacji technologii znajdujących się na etapie projektów demonstracyjnych oraz w kontekście nowych odkryć i nowych koncepcji.<br/><a href="{iURL module=$iModuleName action=conversatory1 id=129}"><span class="conv_more">[ więcej... ]</span></a>
					</td>
				</tr></table>
			{/iScheme}

			{iScheme name=boxlight4 title="Agroenergetyka" class="conv_block"}
				<table class="conv_block_desc"><tr>
					<td class="conv_icon">
						{html_image file="$iImageDir/conv2.gif"}<br/>
					</td>
					<td>
						<b>Agroenergetyka</b> w kontekście rozwoju biotechnologii, transformacji rolnictwa żywnościowego w energetyczne, tzn. wygaszania Wspólnej Polityki Rolnej i budowania nowego segmentu bezpieczeństwa energetycznego, logistyki agroenergetyki, a także technologii zgazowywania biomasy.<br/><a href="{iURL module=$iModuleName action=conversatory1 id=130}"><span class="conv_more">[ więcej... ]</span></a>
					</td>
				</tr></table>
			{/iScheme}

			{iScheme name=boxlight4 title="Ryzyko inwestycyjne" class="conv_block"}
				<table class="conv_block_desc"><tr>
					<td class="conv_icon">
						{html_image file="$iImageDir/conv3.gif"}<br/>
					</td>
					<td>
						<b>Ryzyko inwestycyjne</b> w kontekście globalizacji, prognoz technologicznych, kosztów projektów demonstracyjnych oraz ryzyk: politycznego i regulacyjnego.<br/><a href="{iURL module=$iModuleName action=conversatory1 id=160}"><span class="conv_more">[ więcej... ]</span></a>
					</td>
				</tr></table>
			{/iScheme}

			{iScheme name=boxlight4 title="Prawo" class="conv_block"}
				<table class="conv_block_desc"><tr>
					<td class="conv_icon">
						{html_image file="$iImageDir/conv4.gif"}<br/>
					</td>
					<td>
						<b>Prawo</b> w kontekście ryzyka inwestycyjnego, alokacji uprawnień do emisji CO2 oraz wymagań środowiska ogólnie, a także w kontekście strategii podatkowych.<br/><a href="{iURL module=$iModuleName action=conversatory1 id=161}"><span class="conv_more">[ więcej... ]</span></a>
					</td>
				</tr></table>
			{/iScheme}

			{iScheme name=boxlight4 title="Socjologia przemian" class="conv_block"}
				<table class="conv_block_desc"><tr>
					<td class="conv_icon">
						{html_image file="$iImageDir/conv5.gif"}<br/>
					</td>
					<td>
						<b>Socjologia przemian</b> w sektorach energetycznych, tzn. w górnictwie, elektroenergetyce, gazownictwie, ciepłownictwie i w sektorze paliw płynnych oraz na wsi, w kontekście restrukturyzacji sektorów energetycznych, rozwoju energetyki rozproszonej i rozwoju agroenergetyki oraz w kontekście budowy nowych społeczności lokalnych.<br/><a href="{iURL module=$iModuleName action=conversatory1 id=162}"><span class="conv_more">[ więcej... ]</span></a>
					</td>
				</tr></table>
			{/iScheme}
			
			<div class="conv_click">
				Jeżeli jesteś zainteresowany tym, co na temat ‘Energetyki przyszłości’ myślą inni, kliknij na odpowiedni dział.
			</div>
			
			{iScheme name=bar id=library_bar}
				<div>Podziel się z innymi swoją wiedzą!</div>
			{/iScheme}

			{iScheme name=boxlight4 noicon=true id="library_text2"}
				<div class="conv_text1">
					Zapraszamy do zamieszczenia na portalu <b>egie.pl</b> swoich opinii, artykułów, informacji itp. z zakresu objętego <b>„Konwersatorium”</b>. Dostarczone pod adresem {mailto address="redakcja@egie.pl" text="redakcja@egie.pl" encode=javascript} materiały włączymy (po ewentualnej obróbce redakcyjnej) do naszego wspólnego dorobku publikowanego w ramach <b>„Konwersatorium”</b>
				</div>
			{/iScheme}

		</td>
	</tr>
</table>
