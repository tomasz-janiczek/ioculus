<p id="title">Struktura sieci eGIE</p>

<div id="description_default">
	Wybierz element schematu i kliknij na nim, by zobaczyć opis danego elementu
</div>

<div id="scheme">
	<div id="block1" class="block" title="asdasd">
		<div>
			Gmina funkcjonująca w Sieci e-GIE na podstawie zestandaryzowanego porozumienia zawartego z Siecią, wykorzystująca Sieć do wspomagania rozwoju gminnego konkurencyjnego rynku usług infrastrukturalnych,  w tym do tworzenia warunków na rzecz aktywizacji zawodowej absolwentów wyższych uczelni zamieszkujących gminę (na rzecz ich pozostania w gminie i podejmowania przez nich działalności innowacyjnej).
		</div>
	</div>
	<div id="block2" class="block">
		<div>
			Podmiot gospodarczy działający bez koncesji (w środowisku całkowicie konkurencyjnym) zapewniający obniżkę kosztów usług infrastrukturalnych w gminie poprzez wykorzystanie usług/produktów e-GIE. Podstawą działalności Integratora e-GIE są umowy komercyjne z operatorami branżowymi zapewniające trójstronne korzyści, mianowicie nabywcom usług, operatorom branżowym i samym Integratorom. Źródłem korzyści jest wykorzystanie efektów koordynacyjnego, oszczędnościowego i synergicznego użytkowania wszystkich rodzajów infrastruktury technicznej w gminie, należącej do różnych operatorów branżowych (elektroenergetyka, gazownictwo, ciepłownictwo, dostawa wody, infrastruktura na rzecz ochrony środowiska, e-infrastruktura).
		</div>
	</div>
	<div id="block3" class="block">
		<div>
			Rdzeń platformy umożliwający skuteczną realizację idei sieci e-Gmina, Infrastruktura i Energetyka. Dzieli się logicznie na dwa komponenty:
			<ul>
			    <li>Portal internetowy, powszechnie dostępny i stanowiący punkt styku, kontaktu pomiędzy e-GIE a internautami</li>
			    <li>Intranet (sieć korporacyjna), zamknięta i dostępną tylko dla wybranych członków, korzystających z narzędzi i aplikacji sieciowych e-GIE</li>
			</ul>
		</div>
	</div>
	<div id="block4" class="block">
		<div>
			Osoba lub przedsiębiorstwo prowadzące działalność (na zasadzie franchisingu), wykorzystujące do tego celu narzędzia, systemy 					biznesowe, produkty/usługi e-GIE oraz logo e-GIE dostarczone przez Sieć e-GIE. Deweloper e-GIE prowadzi działalność na terenie gminy, związku gmin lub części gminy. Szczególnym przypadkiem jest Deweloper instytucjonalny e-GIE.
		</div>
	</div>
	<div id="block5" class="block">
		<div>
			Operator działający na podstawie koncesji przewidzianej prawem, udzielonej przez państwo lub samorząd, zapewniający usługi infrastrukturalne należące do segmentu użyteczności publicznej. Także dostawca (usług infrastrukturalnych) z urzędu, jeśli takiego ustanawia prawo (w szczególności dotyczy to dostaw energii elektrycznej).
		</div>
	</div>
	<div id="block6" class="block">
		<div>
			Użytkownicy portalu eGIE, którzy mogą, acz nie muszą być jednocześnie klientami indywidualnymi sieci.
		</div>
	</div>
</div>

{iScheme name=boxlight3 title="Struktura sieci eGIE" id=description}
	Wybierz element schematu i kliknij na nim, by zobaczyć opis danego elementu
{/iScheme}

{iScheme name=bar type=long text="eGIE - co to takiego?"}
{/iScheme}

<div id="col1">
	{iScheme name=boxlight3 title=$article[1].title dot=true}
		{$article[1].content}
	{/iScheme}
</div>

<div id="col2">
	{iScheme name=boxgreen title=$article[0].title dot=true}
		{iScheme name=layout1 image="/www/images/illustration_4.jpg"}
			{$article[0].content}
		{/iScheme}
	{/iScheme}

	{iScheme name=boxlight3 dot=false title="Więcej informacji o eGIE"}
		{section name=i loop=$newses}
			{capture assign=url}{iURL module=$iModuleName action=show id=$newses[i].id}{/capture}
			{iScheme name=layout4 title=$newses[i].title|wordwrap:50 link=$url author=$newses[i].handle date=$newses[i].date|date_format:"%d.%m.%Y"}
				{$newses[i].content|truncate:500}
			{/iScheme}
		{/section}
	{/iScheme}
</div>