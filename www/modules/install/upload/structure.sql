-- phpMyAdmin SQL Dump
-- version 2.6.2-Debian-3sarge1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Czas wygenerowania: 17 Sty 2007, 16:36
-- Wersja serwera: 4.1.11
-- Wersja PHP: 4.3.10-16
-- 
-- Baza danych: `ioculus`
-- 

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `_seq`
-- 

CREATE TABLE `_seq` (
  `sequence` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

-- 
-- Zrzut danych tabeli `_seq`
-- 

INSERT INTO `_seq` VALUES (100);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `archive`
-- 

CREATE TABLE `archive` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  `size` int(10) unsigned NOT NULL default '0',
  `max_size` int(10) unsigned NOT NULL default '0',
  `count` int(10) unsigned NOT NULL default '0',
  `max_count` int(10) unsigned NOT NULL default '0',
  `max_item_size` int(10) unsigned NOT NULL default '0',
  `type` varchar(255) NOT NULL default '',
  `compress` tinyint(1) NOT NULL default '0',
  `compress_format` varchar(8) NOT NULL default 'zip',
  `path` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`(16))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Zrzut danych tabeli `archive`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `archive_item`
-- 

CREATE TABLE `archive_item` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `archive_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `type` varchar(7) NOT NULL default '',
  `size` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `archive_id` (`archive_id`),
  KEY `name` (`name`(32))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Zrzut danych tabeli `archive_item`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `article`
-- 

CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `author_id` int(10) unsigned NOT NULL default '0',
  `description` text,
  `date` timestamp NULL default NULL,
  `content` mediumtext NOT NULL,
  `priority` tinyint(3) unsigned NOT NULL default '0',
  `mod_date` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  `mod_author_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `title` (`title`(32)),
  KEY `author_id` (`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

-- 
-- Zrzut danych tabeli `article`
-- 

INSERT INTO `article` VALUES (32, 'Seminarium SEP', 1, 'sdfasdfasdfas<br />					 		', '2006-12-29 10:12:17', ' 			    Zapraszamy do działu <a href="http://www.egie.pl/?m=library&amp;act=sep&amp;_ioculus=71b22d96e2fcb36031589a3a81bb5f4f" title="Seminarium SEP">Podstrony / Seminarium SEP</a> , lub pod adres <a href="http://sep.egie.pl/" title="sep.egie.pl">sep.egie.pl</a> , gdzie znaleźć można informacje na temat zbliżającego się seminarium Stowarzyszenia Elektryk&oacute;w Polskich o tytule <strong>&quot;Nowoczesna energetyka i e-Gmina - połączenie przyszłości&quot;.</strong>', 0, '2007-01-01 23:00:43', 1);
INSERT INTO `article` VALUES (43, 'Formularz zgłoszeniowy', 1, '	 					 	 					 Pr&oacute;ba mikrofonu	 					 		', '2006-12-30 05:12:26', '	 					 	 					 	 					 	 					  			Z dniem dzisiejszym do użytku publicznego podserwisu <strong><a href="http://studium.egie.pl/" title="studium.egie.pl">studium.egie.pl</a></strong> wchodzi elektroniczny formularz zgłoszeniowy, kt&oacute;ry umożliwi chętnym do wzięcia udziału w studium łatwą i szybką rejestrację. Formularz znajduje się <strong><a href="http://www.egie.pl/?m=library&amp;act=studium&amp;id=1&amp;_ioculus=71b22d96e2fcb36031589a3a81bb5f4f">tutaj</a></strong> 	 					 	 					 		', 0, '2007-01-10 19:45:23', 1);
INSERT INTO `article` VALUES (52, 'Ile kosztuje energia elektryczna?', 1, '<p> <strong>(Stanowisko Stowarzyszenia Niezależnych Wytw&oacute;rc&oacute;w Energii Skojarzonej)</strong></p><p>Karol Kraszewski, Jacek Kobus<br /> PEC Siedlce, Stowarzyszenie Niezależnych Wytw&oacute;rc&oacute;w Energii Skojarzonej </p>', '2007-01-01 11:01:25', '<p> <strong>(Stanowisko Stowarzyszenia Niezależnych Wytw&oacute;rc&oacute;w Energii Skojarzonej)</strong></p> <p>Karol Kraszewski, Jacek Kobus<br /> PEC Siedlce, Stowarzyszenie Niezależnych Wytw&oacute;rc&oacute;w Energii Skojarzonej </p> 	 					 ', 0, '2007-01-01 11:01:25', 1);
INSERT INTO `article` VALUES (74, 'Polityka Prywatności', 1, '	 					 	 					 	 					 	 					 	 					 	 					 	 					 	 					 Polityka prywatności portalu egie.pl	 					 ', '2007-01-10 08:01:50', '	 					 	 					 	 					 	 					 	 					 	 					 <ul><li><p><u><span style="font-weight: bold">Informacje og&oacute;lne</span></u><br />eGmina, Infrastruktura, Energetyka Sp. z o.o. (eGIE) zastrzega sobie prawo do wprowadzania zmian w Polityce Prywatności. Każdego klienta eGIE i użytkownika serwis&oacute;w oraz czasopism należących do eGIE obowiązuje aktualna Polityka Prywatności znajdująca się na stronie <a href="/?m=library&amp;act=privacy"><strong>Polityka Prywatności</strong></a> </p> <p> Jakiekolwiek wprowadzane zmiany nie wpływają na podstawową zasadę:<br /><strong>eGIE nie sprzedaje i nie udostępnia osobom trzecim danych personalnych czy adresowych klient&oacute;w/ użytkownik&oacute;w swoich serwis&oacute;w i czasopism.</strong>  </p> <p><u> Jeśli nie zgadzasz się z Polityką Prywatności, proszę nie odwiedzać serwis&oacute;w, nie prenumerować czasopism należących do eGIE oraz nie nabywać produkt&oacute;w i usług oferowanych przez eGIE.  </u></p></li><li><u><strong>Dane Osobowe</strong></u><br /> W czasie korzystania z serwis&oacute;w należących do eGIE możesz zostać poproszony o podanie niekt&oacute;rych swoich danych osobowych poprzez wypełnienie formularza lub w inny spos&oacute;b. Dane, o kt&oacute;re będziesz proszony, to w większości przypadk&oacute;w imię i adres e-mail. W przypadku formularzy zam&oacute;wień będziesz proszony o podanie pełnych danych osobowych.   <p> Wymagamy tylko tych danych, kt&oacute;re są niezbędne do działania serwisu. Niepodanie wymaganych danych zablokuje czynność, kt&oacute;rą te dane dotyczyły.  </p>  <p> Wszystkie osoby korzystające z portalu wyrażają jednocześnie zgodę na przetwarzanie przez eGIE (a także organizator&oacute;w, lub sponsor&oacute;w w przypadku konferencji i seminari&oacute;w) ich danych osobowych w celach marketingowych, w zakresie prowadzonej działalności gospodarczej, zgodnie z przepisami ustawy o ochronie danych osobowych z dnia 29 sierpnia 1997r. (Dz. U. z 2002r. Nr 101, poz. 926 z p&oacute;źn. zm.). </p> </li><li><u><strong>Subskrypcja bezpłatnych czasopism</strong></u><br />Zaprenumerowanie elektronicznych i bezpłatnych czasopism należących do eGIE wymaga podania w odpowiednim formularzu swojego imienia i adresu e-mail. Pola te są obowiązkowe.   <p> Uzyskane w ten spos&oacute;b dane są dodawane do listy mailingowej e-zinu. Adres e-mail jest niezbędny do tego, aby można było wysłać danemu czytelnikowi numer czasopisma. Imię pozwala eGIE zwracać się do czytelnik&oacute;w po imieniu.  </p> </li><li><u><strong>Zamawianie usług i produkt&oacute;w</strong></u><br />Zamawianie usług i produkt&oacute;w oferowanych przez eGIE wymaga podania w odpowiednim formularzu pełniejszych danych adresowych. Pola obowiązkowe są oznaczone.<br /><br /></li><li><u><strong>Niezapowiedziane Wiadomości</strong></u><br />eGIE zastrzega sobie prawo do wysyłania niezapowiedzianych wiadomości osobom, kt&oacute;rych dane kontaktowe posiada i kt&oacute;re zgodziły się z Polityką Prywatności.   <p> Pod pojęciem niezapowiedzianych wiadomości eGIE rozumie informacje odnoszące się bezpośrednio do jego serwis&oacute;w, czasopism, usług i produkt&oacute;w (np. zmiany, wewnętrzne promocje), niekomercyjne listy (np. życzenia, komentarze osobiste itp.) oraz informacje komercyjne, kt&oacute;rych rozsyłka została opłacona przez klient&oacute;w eGIE.  </p> <p> Podmioty zlecające komercyjne mailingi nie mają wglądu w dane kontaktowe os&oacute;b znajdujących się na listach adresowych eGIE.  </p> <p> Informacje komercyjne są filtrowane w stopniu w jakim jest to możliwe, ograniczana jest ich objętość i wysyłane są sporadycznie.  </p> </li><li><strong><u>Jawne Dane Osobowe</u><br /></strong>Dane osobowe podane na serwisach należących do eGIE przy okazji wysyłania komentarzy do artykuł&oacute;w, odpowiedzi na forum itp. są dostępne dla wszystkich odwiedzających strony zawierające te dane. eGIE nie ma możliwości zabezpieczenia Was przed osobami prywatnymi lub firmami, kt&oacute;re te dane wykorzystają do przesłania Wam nieokreślonych informacji. Dlatego dane te <strong>nie podlegają</strong> Polityce Prywatności.<br /><br />   </li><li><u><strong>Inne formularze</strong></u><br />Formularze znajdujące się gościnnie na serwisach należących do eGIE i dotyczące usług, produkt&oacute;w, serwis&oacute;w i czasopism nieobsługiwanych przez eGIE <strong>nie podlegają </strong>Polityce Prywatności.<br /><br />   </li><li><u><strong>Cookies (Ciasteczka)</strong></u><br />Niekt&oacute;re obszary serwis&oacute;w należących do eGIE mogą wykorzystywać cookies, czyli małe pliki tekstowe wysyłane do komputera internauty identyfikujące go w spos&oacute;b potrzebny do uproszczenia lub umorzenia danej operacji.   <p> Cookies są nieszkodliwe ani dla komputera ani dla jego użytkownika i jego danych. Warunkiem działania cookies jest ich akceptacja przez przeglądarkę i nie usuwanie ich z dysku.  </p> </li><li><u><strong>Partnerzy</strong></u><br />Polityka Prywatności <strong>nie dotyczy</strong> serwis&oacute;w i firm, kt&oacute;rych dane kontaktowe podane są w serwisach i czasopismach należących do eGIE.   <p style="text-align: center" align="center"> W przypadku pytań proszę pisać na adres: <br /><a href="mailto:redakcja@egie.pl">redakcja@egie.pl</a> </p> </li><li><u><strong>Wyłączenie Odpowiedzialności</strong></u><strong><br /></strong>Opinie wyrażone przez społeczność na forach eGIE, w komentarzach lub w inny spos&oacute;b nie są opiniami zespołu eGIE i przedsiębiorstwa eGmina, Infrastruktura, Energetyka Sp. z o.o. jako takiego.  <p> eGIE oraz jego redakcja nie bierze na siebie odpowiedzialności za zamieszczone reklamy. Kupujący powinien być ostrożny odpowiadając na reklamę, bądź wysyłając pieniądze. Wprawdzie przykładamy sporą wagę do tego, aby reklamodawcy, kt&oacute;rzy publikują tu swoje reklamy byli wiarygodni, ale nie możemy odpowiadać za ich czyny. Dane adresowe jak i szczeg&oacute;ły oferty każdego reklamodawcy można uznać za pewne tylko w momencie publikacji.  </p> </li></ul>', 0, '2007-01-10 20:51:47', 1);
INSERT INTO `article` VALUES (54, 'Bezpieczeństwo gazowe Polski', 1, 'Gazowy kryzys rosyjsko-ukraiński na przełomie roku zaowocował w Polsce kolejny raz rewią bezczelnego populizmu politycznego. Ale też kolejny raz sprawdziła się teza, od dawna głoszona przez autora tego artykułu, że każdy kryzys wywołany z pozycji...	 					 ', '2007-01-01 11:01:02', 'Gazowy kryzys rosyjsko-ukraiński na przełomie roku zaowocował w Polsce kolejny raz rewią bezczelnego populizmu politycznego. Ale też kolejny raz sprawdziła się teza, od dawna głoszona przez autora tego artykułu, że każdy kryzys wywołany z pozycji...	 					 	 					 ', 0, '2007-01-01 11:01:02', 1);
INSERT INTO `article` VALUES (56, 'Umowa ESCO w ciepłownictwie', 1, '<span><strong>1.1.  ESCO &ndash; Energy Saving Company lub Energy Service Company  </strong><br /> W wolnym tłumaczeniu, nazwa ta oznacza firmę oferującą kompleksowe profesjonalne usługi w zakresie szeroko pojętej energetyki, gwarantującą potencjalnym klientom oszczędności energii i zmniejszenie ponoszonych z jej tytułu koszt&oacute;w. Firmy tego typu realizują kompleksowe usługi w zakresie gospodarowania energią w oparciu o kontrakty wykonawcze (umowy ESCO) i z reguły udzielają gwarancji uzyskania oszczędności. Obecnie rozszerza się spos&oacute;b działania formuły ESCO na inne dziedziny życia związane z gospodarką komunalną i szeroko pojętymi usługami. </span>', '2007-01-01 11:01:57', '<span><strong>1.1.  ESCO &ndash; Energy Saving Company lub Energy Service Company  </strong><br /> W wolnym tłumaczeniu, nazwa ta oznacza firmę oferującą kompleksowe profesjonalne usługi w zakresie szeroko pojętej energetyki, gwarantującą potencjalnym klientom oszczędności energii i zmniejszenie ponoszonych z jej tytułu koszt&oacute;w. Firmy tego typu realizują kompleksowe usługi w zakresie gospodarowania energią w oparciu o kontrakty wykonawcze (umowy ESCO) i z reguły udzielają gwarancji uzyskania oszczędności. Obecnie rozszerza się spos&oacute;b działania formuły ESCO na inne dziedziny życia związane z gospodarką komunalną i szeroko pojętymi usługami. </span>	 					 ', 0, '2007-01-01 11:01:57', 1);
INSERT INTO `article` VALUES (58, 'Przeszłość, teraźniejszość i przyszłość polskiej elektroenergetyki', 1, '<span>Przypomnienie, co się stało w ciągu ostatnich 15 lat w elektroenergetyce pozwala lepiej zrozumieć, jakich błęd&oacute;w dobrze byłoby uniknąć od zaraz i jakich przemian nie da się zahamować w przyszłości. W szczeg&oacute;lności okres 1990-1995 pokazał, że decentralizacja elektroenergetyki (budowa nowych, samodzielnych przedsiębiorstw), choć bardzo trudna, uwolniła wielkie zasoby, kt&oacute;re wystarczyły na dryfowanie w kolejnych 10 latach. Systematyczny wzrost upolityczniania elektroenergetyki, kt&oacute;ry obserwowaliśmy po 1995 roku, i kt&oacute;rego pożywką była dobra sytuacja wynikająca z wcześniejszych reform, umożliwia siłom...</span>	 					 ', '2007-01-01 11:01:39', '<span>Przypomnienie, co się stało w ciągu ostatnich 15 lat w elektroenergetyce pozwala lepiej zrozumieć, jakich błęd&oacute;w dobrze byłoby uniknąć od zaraz i jakich przemian nie da się zahamować w przyszłości. W szczeg&oacute;lności okres 1990-1995 pokazał, że decentralizacja elektroenergetyki (budowa nowych, samodzielnych przedsiębiorstw), choć bardzo trudna, uwolniła wielkie zasoby, kt&oacute;re wystarczyły na dryfowanie w kolejnych 10 latach. Systematyczny wzrost upolityczniania elektroenergetyki, kt&oacute;ry obserwowaliśmy po 1995 roku, i kt&oacute;rego pożywką była dobra sytuacja wynikająca z wcześniejszych reform, umożliwia siłom...</span>	 					 ', 0, '2007-01-01 11:01:39', 1);
INSERT INTO `article` VALUES (60, 'UWAGI DO „PROGRAMU DLA ENERGETYKI” PRZEDSTAWIONEGO PRZEZ MINISTERSTWO GOSPODARKI DO SPOŁECZNEJ KONSULTACJI (datowanego: 2 marca 2006 )\r\n\r\nUwagi do „Progamu dla energetyki”', 1, '<span><p> <strong>UWAGI DO &bdquo;PROGRAMU DLA ENERGETYKI&rdquo; PRZEDSTAWIONEGO PRZEZ MINISTERSTWO GOSPODARKI DO SPOŁECZNEJ KONSULTACJI (datowanego: 2 marca 2006 )<br /> </strong> </p> <p> Diagnoza przedstawiona w Programie (brak konkurencji, zagrożenie związane ze wzrostem cen energii elektrycznej, zagrożenie wystąpienia deficytu mocy, zagrożenie niewykonalności zapis&oacute;w Traktatu Akcesyjnego w zakresie redukcji emisji SO2 i inne) &ndash; jest na og&oacute;ł prawidłowa.<br /> Proponowane w Programie rozwiązanie (konsolidacja pionowa, utworzenie dw&oacute;ch węglowych grup wytw&oacute;rczych PGE i PKE, posiadających łączny udział w rynku produkcji przekraczający 70 proc. i w rynku dostaw ponad 50 proc.) &ndash; jest (na wsp&oacute;łczesne uwarunkowania) błędne. Rzeczywisty cel Programu (jest to cel dw&oacute;ch dominujących już w Polsce przedsiębiorstw wytw&oacute;rczych: BOT oraz PKE) &ndash; celem tym jest przeprowadzenie... </p></span>	 					 ', '2007-01-01 11:01:24', '<span><p> <strong>UWAGI DO &bdquo;PROGRAMU DLA ENERGETYKI&rdquo; PRZEDSTAWIONEGO PRZEZ MINISTERSTWO GOSPODARKI DO SPOŁECZNEJ KONSULTACJI (datowanego: 2 marca 2006 )<br /> </strong> </p> <p> Diagnoza przedstawiona w Programie (brak konkurencji, zagrożenie związane ze wzrostem cen energii elektrycznej, zagrożenie wystąpienia deficytu mocy, zagrożenie niewykonalności zapis&oacute;w Traktatu Akcesyjnego w zakresie redukcji emisji SO2 i inne) &ndash; jest na og&oacute;ł prawidłowa.<br /> Proponowane w Programie rozwiązanie (konsolidacja pionowa, utworzenie dw&oacute;ch węglowych grup wytw&oacute;rczych PGE i PKE, posiadających łączny udział w rynku produkcji przekraczający 70 proc. i w rynku dostaw ponad 50 proc.) &ndash; jest (na wsp&oacute;łczesne uwarunkowania) błędne. Rzeczywisty cel Programu (jest to cel dw&oacute;ch dominujących już w Polsce przedsiębiorstw wytw&oacute;rczych: BOT oraz PKE) &ndash; celem tym jest przeprowadzenie... </p></span>	 					 ', 0, '2007-01-01 11:01:24', 1);
INSERT INTO `article` VALUES (70, 'Foobar', 1, 'asdasd<br />	 					 ', '2007-01-10 07:01:35', 'asdasd<br />	 					 ', 0, '2007-01-10 07:01:35', 1);
INSERT INTO `article` VALUES (93, 'Zadania i cele', 1, ' 			 					Sieć e-GIE realizuje swoje zadania z wykorzystaniem bazy teleinformatycznej, kt&oacute;rej podstawową właściwością jest stały rozw&oacute;j.	 					 ', '2007-01-14 07:01:52', ' 			 					Sieć e-GIE realizuje swoje zadania z wykorzystaniem bazy teleinformatycznej, kt&oacute;rej podstawową właściwością jest stały rozw&oacute;j. To umożliwia nam świadczenie wielu r&oacute;żnorodnych usług, kt&oacute;re mogą się okazać czynnikami szybkiego rozwoju społeczności w gminach na terenie Polski. Nasza działalność zapewni Państwu efektywny dostęp do informacji niezbędnych dla skutecznego prowadzenia działalności gospodarczej, spowoduje ułatwianie kontakt&oacute;w z administracją, zorganizowanie sprawniejszej opieki zdrowotnej i socjalnej, zwiększanie możliwości edukacyjnych/szkoleniowych. Innymi działaniami są doradztwo, ułatwienie podejmowania inicjatyw kulturalnych, organizacji rozrywki i wypoczynku.	 					 ', 0, '2007-01-14 07:01:52', 1);
INSERT INTO `article` VALUES (95, 'Uwarunkowania zewnętrzne', 1, '<em>&quot;Bez świadomości swych aktualnych uwarunkowań i ograniczeń swej przeszłości człowiek nie potrafi nadać kształtu przyszłości&quot; - E.Cassirer (1874-1945 r.)</em>	 					 ', '2007-01-14 07:01:32', '<em>&quot;Bez świadomości swych aktualnych uwarunkowań i ograniczeń swej przeszłości człowiek nie potrafi nadać kształtu przyszłości&quot; - E.Cassirer (1874-1945 r.)</em><br /> <br /> &nbsp;Wsp&oacute;łczesne przedsiębiorstwa infrastrukturalne, w tym r&oacute;wnież energetyczne, muszą w swoich strategiach rozwoju uwzględniać zmiany, kt&oacute;re zachodzą w otoczeniu tak szybko jak nigdy dotąd. Rozw&oacute;j nowych technologii, a przede wszystkim technologii informatycznych, chęć każdego z nas i społeczeństwa w całości, polepszenia sobie warunk&oacute;w bytowych, komfortu i bezpieczeństwa są motorem rozwoju produkt&oacute;w i usług rynkowych. Zmiany te wymuszają tworzenie ciągle nowych strategii przez przedsiębiorstwa. Dostosowanie swojej oferty pod względem jakości i ceny do oczekiwań klient&oacute;w, jednocześnie zaskoczenie klient&oacute;w propozycjami w pełni nowatorskimi, kreującymi rozw&oacute;j nowych rynk&oacute;w to...	 					 ', 0, '2007-01-14 07:01:32', 1);
INSERT INTO `article` VALUES (97, 'Obszar działania', 1, '<span> 																Działając w sieci nie ograniczamy swojej działalność do określonego obszaru, a wręcz przeciwnie, przezwyciężamy granice, o czym świadczą pierwsze implementacje oraz szerokie zainteresowanie przystąpieniem do wsp&oacute;łpracy w sieci e-GIE.</span>	 					 ', '2007-01-14 07:01:56', '<span> 																Działając w sieci nie ograniczamy swojej działalność do określonego obszaru, a wręcz przeciwnie, przezwyciężamy granice, o czym świadczą pierwsze implementacje oraz szerokie zainteresowanie przystąpieniem do wsp&oacute;łpracy w sieci e-GIE. Jako pierwsze w sieci znalazły się gminy: Gierałtowice (koło Gliwic), Kleszcz&oacute;w (z Kompleksem Energetycznym Bełchat&oacute;w na swoim terenie) i Zag&oacute;rz (w Bieszczadach). Wsp&oacute;łpraca w sieci e-GIE doprowadzi do rozpropagowania Państwa gmin, ale także wspomoże integrację całych region&oacute;w. <br /> Podkreślamy, że nasza działalność nie jest zależna od określonego środowiska zawodowego, a rozw&oacute;j usług i ich wdrażanie uzależniamy od potrzeb odbiorc&oacute;w, przez co w sieci nie ma zasadniczego znaczenia podział na ściśle zestandaryzowane usługi i produkty. <br /> Na obecnym etapie dążymy do skupiania rozproszonych podmiot&oacute;w, zbyt słabych do samodzielnego funkcjonowania na... 									</span>	 					 ', 0, '2007-01-14 07:01:56', 1);
INSERT INTO `article` VALUES (99, 'Stawiamy na najlepszych!', 1, '<span> 																Nasze działania są także szansą dla ambitnych, kreatywnych absolwent&oacute;w uczelni wyższych, kt&oacute;rzy chcą i potrafią realizować się w poszukiwaniu nowych rozwiązań dla innych. Dajemy szansę młodemu pokoleniu, kt&oacute;re nie boi się indywidualności i kreatywności.</span>', '2007-01-14 10:01:12', '<span> 																Nasze działania są także szansą dla ambitnych, kreatywnych absolwent&oacute;w uczelni wyższych, kt&oacute;rzy chcą i potrafią realizować się w poszukiwaniu nowych rozwiązań dla innych. Dajemy szansę młodemu pokoleniu, kt&oacute;re nie boi się indywidualności i kreatywności. System telepracy, kt&oacute;ry rozwijamy w sieci e-GIE, otwiera młodemu pokoleniu możliwości samozatrudnienia, redukując ryzyko wykorzystania &quot;słabych&quot; przez &quot;silnych&quot;, a jednocześnie zapewnia wiarygodność uczestnik&oacute;w, wysoką jakość usług i produkt&oacute;w oraz niski koszt związany z efektem mnożnikowym. <br /> Część zespołu e-GIE, w tym i ja, zadając sobie pytanie kończąc studia, jak przebrnąć przez &quot;gąszcz&quot; trudnego rynku pracy, znalazła rozwiązanie w przedsięwzięciu, jakim jest tworzenie i praca w sieci e-GIE. Zgodnie z powiedzeniem: &quot;Jeżeli lubisz to co robisz, to nigdy nie pracujesz!&quot; wsp&oacute;łpraca przy realizacji...</span>	 					 ', 0, '2007-01-14 10:01:12', 1);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `article_section`
-- 

CREATE TABLE `article_section` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` text,
  `type` tinyint(3) unsigned NOT NULL default '0',
  `image_id` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`(32)),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=93 ;

-- 
-- Zrzut danych tabeli `article_section`
-- 

INSERT INTO `article_section` VALUES (34, 'Teksty wewnętrzne', 'Artykuły dotyczące serwisu jako takiego', 3, NULL);
INSERT INTO `article_section` VALUES (20, 'Baza wiedzy', 'Artykuły należące do bazy wiedzy', 3, NULL);
INSERT INTO `article_section` VALUES (21, 'Strona główna', 'Aktualności na stronie głównej', 17, NULL);
INSERT INTO `article_section` VALUES (92, 'eGIE', 'Artykuły na temat eGIE', 3, NULL);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `article_section_articles`
-- 

CREATE TABLE `article_section_articles` (
  `section_id` int(10) unsigned NOT NULL default '0',
  `article_id` int(10) unsigned NOT NULL default '0',
  KEY `article_id` (`article_id`),
  KEY `section_id` (`section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Zrzut danych tabeli `article_section_articles`
-- 

INSERT INTO `article_section_articles` VALUES (21, 32);
INSERT INTO `article_section_articles` VALUES (34, 74);
INSERT INTO `article_section_articles` VALUES (21, 43);
INSERT INTO `article_section_articles` VALUES (20, 52);
INSERT INTO `article_section_articles` VALUES (20, 54);
INSERT INTO `article_section_articles` VALUES (20, 56);
INSERT INTO `article_section_articles` VALUES (20, 58);
INSERT INTO `article_section_articles` VALUES (20, 60);
INSERT INTO `article_section_articles` VALUES (21, 70);
INSERT INTO `article_section_articles` VALUES (92, 93);
INSERT INTO `article_section_articles` VALUES (92, 95);
INSERT INTO `article_section_articles` VALUES (92, 97);
INSERT INTO `article_section_articles` VALUES (92, 99);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `article_type`
-- 

CREATE TABLE `article_type` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`(32))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

-- 
-- Zrzut danych tabeli `article_type`
-- 

INSERT INTO `article_type` VALUES (3, 'Artykuł', 'Artykuł');
INSERT INTO `article_type` VALUES (17, 'News', 'Aktualności');
INSERT INTO `article_type` VALUES (19, 'Typ 3', 'Typ 3');
INSERT INTO `article_type` VALUES (45, 'Typ 4', 'Typ 4');
INSERT INTO `article_type` VALUES (46, 'Typ 5', 'Typ 5');

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `company`
-- 

CREATE TABLE `company` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `type` tinyint(3) unsigned NOT NULL default '0',
  `city` varchar(32) NOT NULL default '',
  `address` varchar(128) NOT NULL default '',
  `nip` varchar(32) NOT NULL default '',
  `email` varchar(64) NOT NULL default '',
  `phone` varchar(64) NOT NULL default '',
  `fax` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Zrzut danych tabeli `company`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `gallery`
-- 

CREATE TABLE `gallery` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `archive_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(32) NOT NULL default '',
  `size` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `archive_id` (`archive_id`),
  KEY `name` (`name`(16))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Zrzut danych tabeli `gallery`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `gallery_item`
-- 

CREATE TABLE `gallery_item` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `gallery_id` int(10) unsigned NOT NULL default '0',
  `archive_item_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`),
  KEY `gallery_id` (`gallery_id`),
  KEY `archive_item_id` (`archive_item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Zrzut danych tabeli `gallery_item`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_applications`
-- 

CREATE TABLE `liveuser_applications` (
  `application_id` int(11) NOT NULL default '0',
  `application_define_name` varchar(32) NOT NULL default '',
  UNIQUE KEY `applications_application_id_idx` (`application_id`),
  UNIQUE KEY `applications_define_name_i_idx` (`application_define_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Zrzut danych tabeli `liveuser_applications`
-- 

INSERT INTO `liveuser_applications` VALUES (1, 'ioculus');

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_applications_seq`
-- 

CREATE TABLE `liveuser_applications_seq` (
  `sequence` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Zrzut danych tabeli `liveuser_applications_seq`
-- 

INSERT INTO `liveuser_applications_seq` VALUES (1);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_area_admin_areas`
-- 

CREATE TABLE `liveuser_area_admin_areas` (
  `area_id` int(11) NOT NULL default '0',
  `perm_user_id` int(11) NOT NULL default '0',
  UNIQUE KEY `area_admin_areas_id_i_idx` (`area_id`,`perm_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Zrzut danych tabeli `liveuser_area_admin_areas`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_areas`
-- 

CREATE TABLE `liveuser_areas` (
  `area_id` int(11) NOT NULL default '0',
  `application_id` int(11) NOT NULL default '0',
  `area_define_name` varchar(32) NOT NULL default '',
  `area_description` varchar(255) NOT NULL default '',
  UNIQUE KEY `areas_area_id_idx` (`area_id`),
  UNIQUE KEY `areas_define_name_i_idx` (`application_id`,`area_define_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Zrzut danych tabeli `liveuser_areas`
-- 

INSERT INTO `liveuser_areas` VALUES (1, 1, 'article', 'Artykuły');
INSERT INTO `liveuser_areas` VALUES (2, 1, 'sysmodman', 'Zarządzanie modułami z poziomu WWW');
INSERT INTO `liveuser_areas` VALUES (3, 1, 'news', 'Moduł aktualności');
INSERT INTO `liveuser_areas` VALUES (4, 1, 'group', 'Zarządzanie grupami użytkowników');
INSERT INTO `liveuser_areas` VALUES (5, 1, 'right', 'Zarządzanie prawami użytkowników i grup');
INSERT INTO `liveuser_areas` VALUES (6, 1, 'profile', 'Profile użytkowników');
INSERT INTO `liveuser_areas` VALUES (7, 1, 'user', 'Zarządzanie użytkownikami');
INSERT INTO `liveuser_areas` VALUES (8, 1, 'sysmsg', 'Wiadomości systemowe i błędy');
INSERT INTO `liveuser_areas` VALUES (11, 1, 'archive', 'Pliki - upload, przechowywanie i zarządzanie');
INSERT INTO `liveuser_areas` VALUES (12, 1, 'adminpanel', 'Adds a simple administration panel');
INSERT INTO `liveuser_areas` VALUES (13, 1, 'library', 'Baza wiedzy');
INSERT INTO `liveuser_areas` VALUES (14, 1, 'company', 'Rejestr firm / deweloperów');
INSERT INTO `liveuser_areas` VALUES (15, 1, 'contact', '[Moduł kontakt] Formularz kontaktowy - egie.pl');
INSERT INTO `liveuser_areas` VALUES (16, 1, 'gallery', 'Galerie, przechowywanie grafik i zarządzanie');
INSERT INTO `liveuser_areas` VALUES (17, 1, 'install', 'Install iOculus sample application');
INSERT INTO `liveuser_areas` VALUES (18, 1, 'mailing', '[Moduł mailingu] Obsługa mailingu');
INSERT INTO `liveuser_areas` VALUES (19, 1, 'moodle', 'Moodle');
INSERT INTO `liveuser_areas` VALUES (20, 1, 'userprofile', 'Profile użytkowników');
INSERT INTO `liveuser_areas` VALUES (21, 1, 'vcard', 'Wsparcie dla VCard 2.1/3.0');

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_areas_seq`
-- 

CREATE TABLE `liveuser_areas_seq` (
  `sequence` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- 
-- Zrzut danych tabeli `liveuser_areas_seq`
-- 

INSERT INTO `liveuser_areas_seq` VALUES (21);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_group_subgroups`
-- 

CREATE TABLE `liveuser_group_subgroups` (
  `group_id` int(11) NOT NULL default '0',
  `subgroup_id` int(11) NOT NULL default '0',
  UNIQUE KEY `group_subgroups_id_i_idx` (`group_id`,`subgroup_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Zrzut danych tabeli `liveuser_group_subgroups`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_grouprights`
-- 

CREATE TABLE `liveuser_grouprights` (
  `group_id` int(11) NOT NULL default '0',
  `right_id` int(11) NOT NULL default '0',
  `right_level` int(11) NOT NULL default '3',
  UNIQUE KEY `grouprights_id_i_idx` (`group_id`,`right_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Zrzut danych tabeli `liveuser_grouprights`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_groups`
-- 

CREATE TABLE `liveuser_groups` (
  `group_id` int(11) NOT NULL default '0',
  `group_type` int(11) NOT NULL default '0',
  `group_define_name` varchar(32) NOT NULL default '',
  `group_description` varchar(255) NOT NULL default '',
  UNIQUE KEY `groups_group_id_idx` (`group_id`),
  UNIQUE KEY `groups_define_name_i_idx` (`group_define_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Zrzut danych tabeli `liveuser_groups`
-- 

INSERT INTO `liveuser_groups` VALUES (48, 0, 'group1', 'First group');
INSERT INTO `liveuser_groups` VALUES (49, 0, 'group2', 'Second group');
INSERT INTO `liveuser_groups` VALUES (50, 1, 'group3', 'Third group');
INSERT INTO `liveuser_groups` VALUES (51, 1, 'group4', 'Fourth group');
INSERT INTO `liveuser_groups` VALUES (52, 0, 'guest', 'Guest group');
INSERT INTO `liveuser_groups` VALUES (53, 0, 'admin', 'Administrator group');

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_groups_seq`
-- 

CREATE TABLE `liveuser_groups_seq` (
  `sequence` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

-- 
-- Zrzut danych tabeli `liveuser_groups_seq`
-- 

INSERT INTO `liveuser_groups_seq` VALUES (53);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_groupusers`
-- 

CREATE TABLE `liveuser_groupusers` (
  `perm_user_id` int(11) NOT NULL default '0',
  `group_id` int(11) NOT NULL default '0',
  UNIQUE KEY `groupusers_id_i_idx` (`perm_user_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Zrzut danych tabeli `liveuser_groupusers`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_perm_users`
-- 

CREATE TABLE `liveuser_perm_users` (
  `perm_user_id` int(11) NOT NULL default '0',
  `auth_user_id` varchar(32) NOT NULL default '',
  `auth_container_name` varchar(32) NOT NULL default '',
  `perm_type` int(11) NOT NULL default '0',
  UNIQUE KEY `perm_users_perm_user_id_idx` (`perm_user_id`),
  UNIQUE KEY `perm_users_auth_id_i_idx` (`auth_user_id`,`auth_container_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Zrzut danych tabeli `liveuser_perm_users`
-- 

INSERT INTO `liveuser_perm_users` VALUES (1, '1', 'DB_Local', 5);
INSERT INTO `liveuser_perm_users` VALUES (2, '2', 'DB_Local', 1);
INSERT INTO `liveuser_perm_users` VALUES (9, '9', 'DB_Local', 1);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_perm_users_seq`
-- 

CREATE TABLE `liveuser_perm_users_seq` (
  `sequence` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- Zrzut danych tabeli `liveuser_perm_users_seq`
-- 

INSERT INTO `liveuser_perm_users_seq` VALUES (9);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_right_implied`
-- 

CREATE TABLE `liveuser_right_implied` (
  `right_id` int(11) NOT NULL default '0',
  `implied_right_id` int(11) NOT NULL default '0',
  UNIQUE KEY `right_implied_id_i_idx` (`right_id`,`implied_right_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Zrzut danych tabeli `liveuser_right_implied`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_rights`
-- 

CREATE TABLE `liveuser_rights` (
  `right_id` int(11) NOT NULL default '0',
  `area_id` int(11) NOT NULL default '0',
  `right_define_name` varchar(32) NOT NULL default '',
  `has_implied` tinyint(1) default '1',
  `right_description` varchar(255) NOT NULL default '',
  UNIQUE KEY `rights_right_id_idx` (`right_id`),
  UNIQUE KEY `rights_define_name_i_idx` (`area_id`,`right_define_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Zrzut danych tabeli `liveuser_rights`
-- 

INSERT INTO `liveuser_rights` VALUES (1, 1, '*', 1, 'Full access to module article');
INSERT INTO `liveuser_rights` VALUES (2, 1, 'exists', 1, 'Access to action article::exists');
INSERT INTO `liveuser_rights` VALUES (3, 1, 'list', 1, 'Access to action article::list');
INSERT INTO `liveuser_rights` VALUES (4, 1, 'addform', 1, 'Access to action article::addform');
INSERT INTO `liveuser_rights` VALUES (5, 1, 'editform', 1, 'Access to action article::editform');
INSERT INTO `liveuser_rights` VALUES (6, 1, 'detailsform', 1, 'Access to action article::detailsform');
INSERT INTO `liveuser_rights` VALUES (7, 1, 'listasoptions', 1, 'Access to action article::listasoptions');
INSERT INTO `liveuser_rights` VALUES (8, 1, 'listasarray', 1, 'Access to action article::listasarray');
INSERT INTO `liveuser_rights` VALUES (9, 1, 'add', 1, 'Access to action article::add');
INSERT INTO `liveuser_rights` VALUES (10, 1, 'edit', 1, 'Access to action article::edit');
INSERT INTO `liveuser_rights` VALUES (11, 1, 'delete', 1, 'Access to action article::delete');
INSERT INTO `liveuser_rights` VALUES (12, 1, 'listsection', 1, 'Access to action article::listsection');
INSERT INTO `liveuser_rights` VALUES (13, 1, 'addsectionform', 1, 'Access to action article::addsectionform');
INSERT INTO `liveuser_rights` VALUES (14, 1, 'editsectionform', 1, 'Access to action article::editsectionform');
INSERT INTO `liveuser_rights` VALUES (15, 1, 'listsectionasoptions', 1, 'Access to action article::listsectionasoptions');
INSERT INTO `liveuser_rights` VALUES (16, 1, 'listsectionasarray', 1, 'Access to action article::listsectionasarray');
INSERT INTO `liveuser_rights` VALUES (17, 1, 'addsection', 1, 'Access to action article::addsection');
INSERT INTO `liveuser_rights` VALUES (185, 1, 'section_view_21', 1, 'Przeglądanie sekcji ''#21''');
INSERT INTO `liveuser_rights` VALUES (19, 1, 'deletesection', 1, 'Access to action article::deletesection');
INSERT INTO `liveuser_rights` VALUES (20, 1, 'sectionexists', 1, 'Access to action article::sectionexists');
INSERT INTO `liveuser_rights` VALUES (21, 1, 'listtype', 1, 'Access to action article::listtype');
INSERT INTO `liveuser_rights` VALUES (22, 1, 'addtypeform', 1, 'Access to action article::addtypeform');
INSERT INTO `liveuser_rights` VALUES (23, 1, 'edittypeform', 1, 'Access to action article::edittypeform');
INSERT INTO `liveuser_rights` VALUES (24, 1, 'addtype', 1, 'Access to action article::addtype');
INSERT INTO `liveuser_rights` VALUES (25, 1, 'edittype', 1, 'Access to action article::edittype');
INSERT INTO `liveuser_rights` VALUES (26, 1, 'deletetype', 1, 'Access to action article::deletetype');
INSERT INTO `liveuser_rights` VALUES (27, 1, 'gettypeid', 1, 'Access to action article::gettypeid');
INSERT INTO `liveuser_rights` VALUES (28, 1, 'selectform', 1, 'Access to action article::selectform');
INSERT INTO `liveuser_rights` VALUES (29, 1, 'selectfileform', 1, 'Access to action article::selectfileform');
INSERT INTO `liveuser_rights` VALUES (30, 1, 'updatesectionrights', 1, 'Access to action article::updatesectionrights');
INSERT INTO `liveuser_rights` VALUES (31, 1, 'getpagelist', 1, 'Access to action article::getpagelist');
INSERT INTO `liveuser_rights` VALUES (32, 1, 'getpage', 1, 'Access to action article::getpage');
INSERT INTO `liveuser_rights` VALUES (33, 1, 'addpage', 1, 'Access to action article::addpage');
INSERT INTO `liveuser_rights` VALUES (34, 1, 'insertpage', 1, 'Access to action article::insertpage');
INSERT INTO `liveuser_rights` VALUES (35, 1, 'editpage', 1, 'Access to action article::editpage');
INSERT INTO `liveuser_rights` VALUES (36, 1, 'deletepage', 1, 'Access to action article::deletepage');
INSERT INTO `liveuser_rights` VALUES (37, 1, 'merge', 1, 'Access to action article::merge');
INSERT INTO `liveuser_rights` VALUES (38, 0, 'section_view_7', 1, 'Przeglądanie sekcji ''#''');
INSERT INTO `liveuser_rights` VALUES (39, 0, 'section_view_8', 1, 'Przeglądanie sekcji ''#''');
INSERT INTO `liveuser_rights` VALUES (40, 0, 'section_view_9', 1, 'Przeglądanie sekcji ''#''');
INSERT INTO `liveuser_rights` VALUES (41, 0, 'section_view_10', 1, 'Przeglądanie sekcji ''#''');
INSERT INTO `liveuser_rights` VALUES (42, 0, 'section_view_11', 1, 'Przeglądanie sekcji ''#''');
INSERT INTO `liveuser_rights` VALUES (43, 0, 'section_view_12', 1, 'Przeglądanie sekcji ''#''');
INSERT INTO `liveuser_rights` VALUES (44, 0, 'section_view_13', 1, 'Przeglądanie sekcji ''#''');
INSERT INTO `liveuser_rights` VALUES (45, 2, '*', 1, 'Full access to module sysmodman');
INSERT INTO `liveuser_rights` VALUES (46, 2, 'list', 1, 'Access to action sysmodman::list');
INSERT INTO `liveuser_rights` VALUES (47, 2, 'addform', 1, 'Access to action sysmodman::addform');
INSERT INTO `liveuser_rights` VALUES (48, 2, 'add', 1, 'Access to action sysmodman::add');
INSERT INTO `liveuser_rights` VALUES (49, 2, 'unload', 1, 'Access to action sysmodman::unload');
INSERT INTO `liveuser_rights` VALUES (50, 2, 'details', 1, 'Access to action sysmodman::details');
INSERT INTO `liveuser_rights` VALUES (51, 2, 'actiondetails', 1, 'Access to action sysmodman::actiondetails');
INSERT INTO `liveuser_rights` VALUES (52, 2, 'validators', 1, 'Access to action sysmodman::validators');
INSERT INTO `liveuser_rights` VALUES (53, 2, 'modifiers', 1, 'Access to action sysmodman::modifiers');
INSERT INTO `liveuser_rights` VALUES (54, 2, 'adminpanel', 1, 'Access to action sysmodman::adminpanel');
INSERT INTO `liveuser_rights` VALUES (55, 2, 'validate', 1, 'Access to action sysmodman::validate');
INSERT INTO `liveuser_rights` VALUES (56, 2, 'clearcache', 1, 'Access to action sysmodman::clearcache');
INSERT INTO `liveuser_rights` VALUES (57, 2, 'regenerate', 1, 'Access to action sysmodman::regenerate');
INSERT INTO `liveuser_rights` VALUES (58, 2, 'clearobservers', 1, 'Access to action sysmodman::clearobservers');
INSERT INTO `liveuser_rights` VALUES (60, 5, '*', 1, 'Full access to module right');
INSERT INTO `liveuser_rights` VALUES (61, 5, 'listform', 1, 'Access to action right::listform');
INSERT INTO `liveuser_rights` VALUES (62, 5, 'addform', 1, 'Access to action right::addform');
INSERT INTO `liveuser_rights` VALUES (63, 5, 'editform', 1, 'Access to action right::editform');
INSERT INTO `liveuser_rights` VALUES (64, 5, 'add', 1, 'Access to action right::add');
INSERT INTO `liveuser_rights` VALUES (65, 5, 'edit', 1, 'Access to action right::edit');
INSERT INTO `liveuser_rights` VALUES (66, 5, 'delete', 1, 'Access to action right::delete');
INSERT INTO `liveuser_rights` VALUES (67, 5, 'list', 1, 'Access to action right::list');
INSERT INTO `liveuser_rights` VALUES (68, 5, 'exists', 1, 'Access to action right::exists');
INSERT INTO `liveuser_rights` VALUES (69, 5, 'addareaform', 1, 'Access to action right::addareaform');
INSERT INTO `liveuser_rights` VALUES (70, 5, 'editareaform', 1, 'Access to action right::editareaform');
INSERT INTO `liveuser_rights` VALUES (71, 5, 'areaexists', 1, 'Access to action right::areaexists');
INSERT INTO `liveuser_rights` VALUES (72, 5, 'listarea', 1, 'Access to action right::listarea');
INSERT INTO `liveuser_rights` VALUES (73, 5, 'addarea', 1, 'Access to action right::addarea');
INSERT INTO `liveuser_rights` VALUES (74, 5, 'editarea', 1, 'Access to action right::editarea');
INSERT INTO `liveuser_rights` VALUES (75, 5, 'deletearea', 1, 'Access to action right::deletearea');
INSERT INTO `liveuser_rights` VALUES (76, 5, 'listgroupform', 1, 'Access to action right::listgroupform');
INSERT INTO `liveuser_rights` VALUES (77, 5, 'listgroup', 1, 'Access to action right::listgroup');
INSERT INTO `liveuser_rights` VALUES (78, 5, 'addgrouprightform', 1, 'Access to action right::addgrouprightform');
INSERT INTO `liveuser_rights` VALUES (79, 5, 'addgroupright', 1, 'Access to action right::addgroupright');
INSERT INTO `liveuser_rights` VALUES (80, 5, 'deletegroupright', 1, 'Access to action right::deletegroupright');
INSERT INTO `liveuser_rights` VALUES (81, 5, 'listuserform', 1, 'Access to action right::listuserform');
INSERT INTO `liveuser_rights` VALUES (82, 5, 'listuser', 1, 'Access to action right::listuser');
INSERT INTO `liveuser_rights` VALUES (83, 5, 'adduserrightform', 1, 'Access to action right::adduserrightform');
INSERT INTO `liveuser_rights` VALUES (84, 5, 'adduserright', 1, 'Access to action right::adduserright');
INSERT INTO `liveuser_rights` VALUES (85, 5, 'deleteuserright', 1, 'Access to action right::deleteuserright');
INSERT INTO `liveuser_rights` VALUES (86, 5, 'rescan', 1, 'Access to action right::rescan');
INSERT INTO `liveuser_rights` VALUES (87, 4, '*', 1, 'Full access to module group');
INSERT INTO `liveuser_rights` VALUES (88, 4, 'listform', 1, 'Access to action group::listform');
INSERT INTO `liveuser_rights` VALUES (89, 4, 'addform', 1, 'Access to action group::addform');
INSERT INTO `liveuser_rights` VALUES (90, 4, 'editform', 1, 'Access to action group::editform');
INSERT INTO `liveuser_rights` VALUES (91, 4, 'getroles', 1, 'Access to action group::getroles');
INSERT INTO `liveuser_rights` VALUES (92, 4, 'list', 1, 'Access to action group::list');
INSERT INTO `liveuser_rights` VALUES (93, 4, 'details', 1, 'Access to action group::details');
INSERT INTO `liveuser_rights` VALUES (94, 4, 'add', 1, 'Access to action group::add');
INSERT INTO `liveuser_rights` VALUES (95, 4, 'edit', 1, 'Access to action group::edit');
INSERT INTO `liveuser_rights` VALUES (96, 4, 'delete', 1, 'Access to action group::delete');
INSERT INTO `liveuser_rights` VALUES (97, 4, 'exists', 1, 'Access to action group::exists');
INSERT INTO `liveuser_rights` VALUES (98, 4, 'addgroupuserform', 1, 'Access to action group::addgroupuserform');
INSERT INTO `liveuser_rights` VALUES (99, 4, 'getusergroups', 1, 'Access to action group::getusergroups');
INSERT INTO `liveuser_rights` VALUES (100, 4, 'listrights', 1, 'Access to action group::listrights');
INSERT INTO `liveuser_rights` VALUES (101, 4, 'addgroupuser', 1, 'Access to action group::addgroupuser');
INSERT INTO `liveuser_rights` VALUES (102, 4, 'deletegroupuser', 1, 'Access to action group::deletegroupuser');
INSERT INTO `liveuser_rights` VALUES (103, 3, '*', 1, 'Full access to module news');
INSERT INTO `liveuser_rights` VALUES (104, 3, 'listnewses', 1, 'Access to action news::listnewses');
INSERT INTO `liveuser_rights` VALUES (105, 3, 'intro', 1, 'Access to action news::intro');
INSERT INTO `liveuser_rights` VALUES (106, 3, 'list', 1, 'Access to action news::list');
INSERT INTO `liveuser_rights` VALUES (107, 3, 'addform', 1, 'Access to action news::addform');
INSERT INTO `liveuser_rights` VALUES (108, 3, 'details', 1, 'Access to action news::details');
INSERT INTO `liveuser_rights` VALUES (109, 3, 'delete', 1, 'Access to action news::delete');
INSERT INTO `liveuser_rights` VALUES (110, 3, 'editform', 1, 'Access to action news::editform');
INSERT INTO `liveuser_rights` VALUES (111, 3, 'add', 1, 'Access to action news::add');
INSERT INTO `liveuser_rights` VALUES (112, 3, 'edit', 1, 'Access to action news::edit');
INSERT INTO `liveuser_rights` VALUES (113, 6, '*', 1, 'Full access to module profile');
INSERT INTO `liveuser_rights` VALUES (114, 6, 'add', 1, 'Access to action profile::add');
INSERT INTO `liveuser_rights` VALUES (115, 6, 'edit', 1, 'Access to action profile::edit');
INSERT INTO `liveuser_rights` VALUES (116, 6, 'addmultiple', 1, 'Access to action profile::addmultiple');
INSERT INTO `liveuser_rights` VALUES (117, 6, 'editmultiple', 1, 'Access to action profile::editmultiple');
INSERT INTO `liveuser_rights` VALUES (118, 6, 'delete', 1, 'Access to action profile::delete');
INSERT INTO `liveuser_rights` VALUES (119, 6, 'deleteall', 1, 'Access to action profile::deleteall');
INSERT INTO `liveuser_rights` VALUES (120, 6, 'get', 1, 'Access to action profile::get');
INSERT INTO `liveuser_rights` VALUES (121, 6, 'getall', 1, 'Access to action profile::getall');
INSERT INTO `liveuser_rights` VALUES (122, 7, '*', 1, 'Full access to module user');
INSERT INTO `liveuser_rights` VALUES (123, 7, 'list', 1, 'Access to action user::list');
INSERT INTO `liveuser_rights` VALUES (124, 7, 'rules', 1, 'Access to action user::rules');
INSERT INTO `liveuser_rights` VALUES (125, 7, 'addform', 1, 'Access to action user::addform');
INSERT INTO `liveuser_rights` VALUES (126, 7, 'registerform', 1, 'Access to action user::registerform');
INSERT INTO `liveuser_rights` VALUES (127, 7, 'registerconfirm', 1, 'Access to action user::registerconfirm');
INSERT INTO `liveuser_rights` VALUES (128, 7, 'loginform', 1, 'Access to action user::loginform');
INSERT INTO `liveuser_rights` VALUES (129, 7, 'logout', 1, 'Access to action user::logout');
INSERT INTO `liveuser_rights` VALUES (130, 7, 'exists', 1, 'Access to action user::exists');
INSERT INTO `liveuser_rights` VALUES (131, 7, 'editform', 1, 'Access to action user::editform');
INSERT INTO `liveuser_rights` VALUES (132, 7, 'add', 1, 'Access to action user::add');
INSERT INTO `liveuser_rights` VALUES (133, 7, 'edit', 1, 'Access to action user::edit');
INSERT INTO `liveuser_rights` VALUES (134, 7, 'delete', 1, 'Access to action user::delete');
INSERT INTO `liveuser_rights` VALUES (135, 7, 'listasoptions', 1, 'Access to action user::listasoptions');
INSERT INTO `liveuser_rights` VALUES (136, 7, 'register', 1, 'Access to action user::register');
INSERT INTO `liveuser_rights` VALUES (137, 7, 'login', 1, 'Access to action user::login');
INSERT INTO `liveuser_rights` VALUES (138, 7, 'guestlogin', 1, 'Access to action user::guestlogin');
INSERT INTO `liveuser_rights` VALUES (139, 7, 'activate', 1, 'Access to action user::activate');
INSERT INTO `liveuser_rights` VALUES (140, 7, 'resetpassword', 1, 'Access to action user::resetpassword');
INSERT INTO `liveuser_rights` VALUES (141, 7, 'resetpasswordform', 1, 'Access to action user::resetpasswordform');
INSERT INTO `liveuser_rights` VALUES (142, 8, '*', 1, 'Full access to module sysmsg');
INSERT INTO `liveuser_rights` VALUES (143, 8, 'info', 1, 'Access to action sysmsg::info');
INSERT INTO `liveuser_rights` VALUES (144, 8, 'error', 1, 'Access to action sysmsg::error');
INSERT INTO `liveuser_rights` VALUES (145, 8, 'confirm', 1, 'Access to action sysmsg::confirm');
INSERT INTO `liveuser_rights` VALUES (146, 8, 'security', 1, 'Access to action sysmsg::security');
INSERT INTO `liveuser_rights` VALUES (148, 5, 'listareaform', 1, 'Access to action right::listareaform');
INSERT INTO `liveuser_rights` VALUES (149, 11, '*', 1, 'Full access to module archive');
INSERT INTO `liveuser_rights` VALUES (150, 11, 'list', 1, 'Access to action archive::list');
INSERT INTO `liveuser_rights` VALUES (151, 11, 'addform', 1, 'Access to action archive::addform');
INSERT INTO `liveuser_rights` VALUES (152, 11, 'editform', 1, 'Access to action archive::editform');
INSERT INTO `liveuser_rights` VALUES (153, 11, 'detailsform', 1, 'Access to action archive::detailsform');
INSERT INTO `liveuser_rights` VALUES (154, 11, 'exists', 1, 'Access to action archive::exists');
INSERT INTO `liveuser_rights` VALUES (155, 11, 'listasoptions', 1, 'Access to action archive::listasoptions');
INSERT INTO `liveuser_rights` VALUES (156, 11, 'listasarray', 1, 'Access to action archive::listasarray');
INSERT INTO `liveuser_rights` VALUES (157, 11, 'edititemform', 1, 'Access to action archive::edititemform');
INSERT INTO `liveuser_rights` VALUES (158, 11, 'add', 1, 'Access to action archive::add');
INSERT INTO `liveuser_rights` VALUES (159, 11, 'edit', 1, 'Access to action archive::edit');
INSERT INTO `liveuser_rights` VALUES (160, 11, 'delete', 1, 'Access to action archive::delete');
INSERT INTO `liveuser_rights` VALUES (161, 11, 'clear', 1, 'Access to action archive::clear');
INSERT INTO `liveuser_rights` VALUES (162, 11, 'rescan', 1, 'Access to action archive::rescan');
INSERT INTO `liveuser_rights` VALUES (163, 11, 'additemform', 1, 'Access to action archive::additemform');
INSERT INTO `liveuser_rights` VALUES (164, 11, 'additem', 1, 'Access to action archive::additem');
INSERT INTO `liveuser_rights` VALUES (165, 11, 'edititem', 1, 'Access to action archive::edititem');
INSERT INTO `liveuser_rights` VALUES (166, 11, 'deleteitem', 1, 'Access to action archive::deleteitem');
INSERT INTO `liveuser_rights` VALUES (167, 11, 'rescanitem', 1, 'Access to action archive::rescanitem');
INSERT INTO `liveuser_rights` VALUES (168, 11, 'showitem', 1, 'Access to action archive::showitem');
INSERT INTO `liveuser_rights` VALUES (169, 11, 'itemlist', 1, 'Access to action archive::itemlist');
INSERT INTO `liveuser_rights` VALUES (170, 11, 'path', 1, 'Access to action archive::path');
INSERT INTO `liveuser_rights` VALUES (171, 11, 'itemexists', 1, 'Access to action archive::itemexists');
INSERT INTO `liveuser_rights` VALUES (172, 11, 'validate', 1, 'Access to action archive::validate');
INSERT INTO `liveuser_rights` VALUES (173, 11, 'show', 1, 'Access to action archive::show');
INSERT INTO `liveuser_rights` VALUES (174, 11, 'download', 1, 'Access to action archive::download');
INSERT INTO `liveuser_rights` VALUES (175, 11, 'getpath', 1, 'Access to action archive::getpath');
INSERT INTO `liveuser_rights` VALUES (176, 11, 'getfullpath', 1, 'Access to action archive::getfullpath');
INSERT INTO `liveuser_rights` VALUES (177, 1, 'listsectionform', 1, 'Access to action article::listsectionform');
INSERT INTO `liveuser_rights` VALUES (178, 1, 'listtypeform', 1, 'Access to action article::listtypeform');
INSERT INTO `liveuser_rights` VALUES (179, 2, 'listform', 1, 'Access to action sysmodman::listform');
INSERT INTO `liveuser_rights` VALUES (180, 2, 'create', 1, 'Access to action sysmodman::create');
INSERT INTO `liveuser_rights` VALUES (186, 11, 'listform', 1, 'Access to action archive::listform');
INSERT INTO `liveuser_rights` VALUES (182, 1, 'section_view_16', 1, 'Przeglądanie sekcji ''#16''');
INSERT INTO `liveuser_rights` VALUES (183, 1, 'section_view_18', 1, 'Przeglądanie sekcji ''#18''');
INSERT INTO `liveuser_rights` VALUES (184, 1, 'section_view_20', 1, 'Przeglądanie sekcji ''#20''');
INSERT INTO `liveuser_rights` VALUES (187, 11, 'details', 1, 'Access to action archive::details');
INSERT INTO `liveuser_rights` VALUES (188, 11, 'listitemform', 1, 'Access to action archive::listitemform');
INSERT INTO `liveuser_rights` VALUES (189, 11, 'uploadform', 1, 'Access to action archive::uploadform');
INSERT INTO `liveuser_rights` VALUES (190, 11, 'itemdetails', 1, 'Access to action archive::itemdetails');
INSERT INTO `liveuser_rights` VALUES (191, 11, 'refresh', 1, 'Access to action archive::refresh');
INSERT INTO `liveuser_rights` VALUES (192, 11, 'upload', 1, 'Access to action archive::upload');
INSERT INTO `liveuser_rights` VALUES (193, 11, 'getitempath', 1, 'Access to action archive::getitempath');
INSERT INTO `liveuser_rights` VALUES (194, 1, 'listform', 1, 'Access to action article::listform');
INSERT INTO `liveuser_rights` VALUES (195, 1, 'editsection', 1, 'Access to action article::editsection');
INSERT INTO `liveuser_rights` VALUES (196, 1, 'listsectionarticles', 1, 'Access to action article::listsectionarticles');
INSERT INTO `liveuser_rights` VALUES (197, 1, 'addsectionarticle', 1, 'Access to action article::addsectionarticle');
INSERT INTO `liveuser_rights` VALUES (198, 1, 'deletesectionarticle', 1, 'Access to action article::deletesectionarticle');
INSERT INTO `liveuser_rights` VALUES (199, 1, 'sectionarticleexists', 1, 'Access to action article::sectionarticleexists');
INSERT INTO `liveuser_rights` VALUES (200, 1, 'section_view_34', 1, 'Przeglądanie sekcji ''#34''');
INSERT INTO `liveuser_rights` VALUES (201, 1, 'setpriority', 1, 'Access to action article::setpriority');
INSERT INTO `liveuser_rights` VALUES (202, 12, '*', 1, 'Full access to module adminpanel');
INSERT INTO `liveuser_rights` VALUES (203, 12, 'listform', 1, 'Access to action adminpanel::listform');
INSERT INTO `liveuser_rights` VALUES (204, 13, '*', 1, 'Full access to module library');
INSERT INTO `liveuser_rights` VALUES (205, 13, 'main', 1, 'Access to action library::main');
INSERT INTO `liveuser_rights` VALUES (206, 13, 'idea', 1, 'Access to action library::idea');
INSERT INTO `liveuser_rights` VALUES (207, 13, 'offer', 1, 'Access to action library::offer');
INSERT INTO `liveuser_rights` VALUES (208, 13, 'offerdev', 1, 'Access to action library::offerdev');
INSERT INTO `liveuser_rights` VALUES (209, 13, 'studium', 1, 'Access to action library::studium');
INSERT INTO `liveuser_rights` VALUES (210, 13, 'sep', 1, 'Access to action library::sep');
INSERT INTO `liveuser_rights` VALUES (211, 13, 'sep_register_form', 1, 'Access to action library::sep_register_form');
INSERT INTO `liveuser_rights` VALUES (212, 13, 'sepregister', 1, 'Access to action library::sepregister');
INSERT INTO `liveuser_rights` VALUES (213, 13, 'sendmail', 1, 'Access to action library::sendmail');
INSERT INTO `liveuser_rights` VALUES (214, 13, 'sepactivate', 1, 'Access to action library::sepactivate');
INSERT INTO `liveuser_rights` VALUES (215, 13, 'activate', 1, 'Access to action library::activate');
INSERT INTO `liveuser_rights` VALUES (216, 13, 'sep_ok_form', 1, 'Access to action library::sep_ok_form');
INSERT INTO `liveuser_rights` VALUES (217, 13, 'studium_register_form', 1, 'Access to action library::studium_register_form');
INSERT INTO `liveuser_rights` VALUES (218, 13, 'studiumregister', 1, 'Access to action library::studiumregister');
INSERT INTO `liveuser_rights` VALUES (219, 13, 'studiumxls', 1, 'Access to action library::studiumxls');
INSERT INTO `liveuser_rights` VALUES (220, 13, 'conversatory', 1, 'Access to action library::conversatory');
INSERT INTO `liveuser_rights` VALUES (221, 13, 'conversatory1', 1, 'Access to action library::conversatory1');
INSERT INTO `liveuser_rights` VALUES (222, 13, 'conversatory2', 1, 'Access to action library::conversatory2');
INSERT INTO `liveuser_rights` VALUES (223, 13, 'privacy', 1, 'Access to action library::privacy');
INSERT INTO `liveuser_rights` VALUES (224, 13, 'ks', 1, 'Access to action library::ks');
INSERT INTO `liveuser_rights` VALUES (225, 13, 'ks_register_form', 1, 'Access to action library::ks_register_form');
INSERT INTO `liveuser_rights` VALUES (226, 13, 'ksregister', 1, 'Access to action library::ksregister');
INSERT INTO `liveuser_rights` VALUES (227, 13, 'students', 1, 'Access to action library::students');
INSERT INTO `liveuser_rights` VALUES (228, 13, 'conversatory3', 1, 'Access to action library::conversatory3');
INSERT INTO `liveuser_rights` VALUES (229, 13, 'conversatory4', 1, 'Access to action library::conversatory4');
INSERT INTO `liveuser_rights` VALUES (230, 2, 'detailsform', 1, 'Access to action sysmodman::detailsform');
INSERT INTO `liveuser_rights` VALUES (231, 2, 'cache', 1, 'Access to action sysmodman::cache');
INSERT INTO `liveuser_rights` VALUES (232, 2, 'uncache', 1, 'Access to action sysmodman::uncache');
INSERT INTO `liveuser_rights` VALUES (233, 2, 'uncacheall', 1, 'Access to action sysmodman::uncacheall');
INSERT INTO `liveuser_rights` VALUES (234, 14, '*', 1, 'Full access to module company');
INSERT INTO `liveuser_rights` VALUES (235, 14, 'add', 1, 'Access to action company::add');
INSERT INTO `liveuser_rights` VALUES (236, 14, 'edit', 1, 'Access to action company::edit');
INSERT INTO `liveuser_rights` VALUES (237, 14, 'delete', 1, 'Access to action company::delete');
INSERT INTO `liveuser_rights` VALUES (238, 14, 'exists', 1, 'Access to action company::exists');
INSERT INTO `liveuser_rights` VALUES (239, 15, '*', 1, 'Full access to module contact');
INSERT INTO `liveuser_rights` VALUES (240, 15, 'showform', 1, 'Access to action contact::showform');
INSERT INTO `liveuser_rights` VALUES (241, 15, 'downloadvcard', 1, 'Access to action contact::downloadvcard');
INSERT INTO `liveuser_rights` VALUES (242, 15, 'send', 1, 'Access to action contact::send');
INSERT INTO `liveuser_rights` VALUES (243, 16, '*', 1, 'Full access to module gallery');
INSERT INTO `liveuser_rights` VALUES (244, 16, 'list', 1, 'Access to action gallery::list');
INSERT INTO `liveuser_rights` VALUES (245, 16, 'listform', 1, 'Access to action gallery::listform');
INSERT INTO `liveuser_rights` VALUES (246, 16, 'addform', 1, 'Access to action gallery::addform');
INSERT INTO `liveuser_rights` VALUES (247, 16, 'editform', 1, 'Access to action gallery::editform');
INSERT INTO `liveuser_rights` VALUES (248, 16, 'detailsform', 1, 'Access to action gallery::detailsform');
INSERT INTO `liveuser_rights` VALUES (249, 16, 'add', 1, 'Access to action gallery::add');
INSERT INTO `liveuser_rights` VALUES (250, 16, 'edit', 1, 'Access to action gallery::edit');
INSERT INTO `liveuser_rights` VALUES (251, 16, 'delete', 1, 'Access to action gallery::delete');
INSERT INTO `liveuser_rights` VALUES (252, 16, 'exists', 1, 'Access to action gallery::exists');
INSERT INTO `liveuser_rights` VALUES (253, 16, 'additemform', 1, 'Access to action gallery::additemform');
INSERT INTO `liveuser_rights` VALUES (254, 16, 'additem', 1, 'Access to action gallery::additem');
INSERT INTO `liveuser_rights` VALUES (255, 16, 'deleteitem', 1, 'Access to action gallery::deleteitem');
INSERT INTO `liveuser_rights` VALUES (256, 16, 'showitem', 1, 'Access to action gallery::showitem');
INSERT INTO `liveuser_rights` VALUES (257, 16, 'regenerate', 1, 'Access to action gallery::regenerate');
INSERT INTO `liveuser_rights` VALUES (258, 16, 'clear', 1, 'Access to action gallery::clear');
INSERT INTO `liveuser_rights` VALUES (259, 16, 'listitem', 1, 'Access to action gallery::listitem');
INSERT INTO `liveuser_rights` VALUES (260, 16, 'path', 1, 'Access to action gallery::path');
INSERT INTO `liveuser_rights` VALUES (261, 16, 'itemexists', 1, 'Access to action gallery::itemexists');
INSERT INTO `liveuser_rights` VALUES (262, 16, 'validate', 1, 'Access to action gallery::validate');
INSERT INTO `liveuser_rights` VALUES (263, 16, 'show', 1, 'Access to action gallery::show');
INSERT INTO `liveuser_rights` VALUES (264, 16, 'imanager', 1, 'Access to action gallery::imanager');
INSERT INTO `liveuser_rights` VALUES (265, 17, '*', 1, 'Full access to module install');
INSERT INTO `liveuser_rights` VALUES (266, 17, 'step1', 1, 'Access to action install::step1');
INSERT INTO `liveuser_rights` VALUES (267, 17, 'step2', 1, 'Access to action install::step2');
INSERT INTO `liveuser_rights` VALUES (268, 17, 'step3', 1, 'Access to action install::step3');
INSERT INTO `liveuser_rights` VALUES (269, 18, '*', 1, 'Full access to module mailing');
INSERT INTO `liveuser_rights` VALUES (270, 18, 'newmail', 1, 'Access to action mailing::newmail');
INSERT INTO `liveuser_rights` VALUES (271, 18, 'send', 1, 'Access to action mailing::send');
INSERT INTO `liveuser_rights` VALUES (272, 18, 'sendtemplate', 1, 'Access to action mailing::sendtemplate');
INSERT INTO `liveuser_rights` VALUES (273, 18, 'sendpersonalizedtemplate', 1, 'Access to action mailing::sendpersonalizedtemplate');
INSERT INTO `liveuser_rights` VALUES (274, 19, '*', 1, 'Full access to module moodle');
INSERT INTO `liveuser_rights` VALUES (275, 19, 'adduser', 1, 'Access to action moodle::adduser');
INSERT INTO `liveuser_rights` VALUES (276, 2, 'cacheall', 1, 'Access to action sysmodman::cacheall');
INSERT INTO `liveuser_rights` VALUES (277, 7, 'listform', 1, 'Access to action user::listform');
INSERT INTO `liveuser_rights` VALUES (278, 20, '*', 1, 'Full access to module userprofile');
INSERT INTO `liveuser_rights` VALUES (279, 20, 'editform', 1, 'Access to action userprofile::editform');
INSERT INTO `liveuser_rights` VALUES (280, 20, 'edit', 1, 'Access to action userprofile::edit');
INSERT INTO `liveuser_rights` VALUES (281, 20, 'get', 1, 'Access to action userprofile::get');
INSERT INTO `liveuser_rights` VALUES (282, 20, 'register', 1, 'Access to action userprofile::register');
INSERT INTO `liveuser_rights` VALUES (283, 20, 'activate', 1, 'Access to action userprofile::activate');
INSERT INTO `liveuser_rights` VALUES (284, 20, 'resetpassword', 1, 'Access to action userprofile::resetpassword');
INSERT INTO `liveuser_rights` VALUES (285, 21, '*', 1, 'Full access to module vcard');
INSERT INTO `liveuser_rights` VALUES (286, 21, 'build', 1, 'Access to action vcard::build');
INSERT INTO `liveuser_rights` VALUES (287, 21, 'buildforuser', 1, 'Access to action vcard::buildforuser');
INSERT INTO `liveuser_rights` VALUES (288, 21, 'downloadvcard', 1, 'Access to action vcard::downloadvcard');
INSERT INTO `liveuser_rights` VALUES (289, 2, 'actiondetailsform', 1, 'Access to action sysmodman::actiondetailsform');
INSERT INTO `liveuser_rights` VALUES (290, 1, 'section_view_92', 1, 'Przeglądanie sekcji ''#92''');
INSERT INTO `liveuser_rights` VALUES (291, 1, 'get', 1, 'Access to action article::get');
INSERT INTO `liveuser_rights` VALUES (292, 13, 'show', 1, 'Access to action library::show');

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_rights_seq`
-- 

CREATE TABLE `liveuser_rights_seq` (
  `sequence` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=293 ;

-- 
-- Zrzut danych tabeli `liveuser_rights_seq`
-- 

INSERT INTO `liveuser_rights_seq` VALUES (292);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_translations`
-- 

CREATE TABLE `liveuser_translations` (
  `translation_id` int(11) NOT NULL default '0',
  `section_id` int(11) NOT NULL default '0',
  `section_type` int(11) NOT NULL default '0',
  `language_id` varchar(32) NOT NULL default '',
  `name` varchar(32) NOT NULL default '',
  `description` varchar(255) default NULL,
  UNIQUE KEY `translations_translation_id_idx` (`translation_id`),
  UNIQUE KEY `translations_translation_i_idx` (`section_id`,`section_type`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Zrzut danych tabeli `liveuser_translations`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_translations_seq`
-- 

CREATE TABLE `liveuser_translations_seq` (
  `sequence` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Zrzut danych tabeli `liveuser_translations_seq`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_userrights`
-- 

CREATE TABLE `liveuser_userrights` (
  `perm_user_id` int(11) NOT NULL default '0',
  `right_id` int(11) NOT NULL default '0',
  `right_level` int(11) NOT NULL default '3',
  UNIQUE KEY `userrights_id_i_idx` (`perm_user_id`,`right_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Zrzut danych tabeli `liveuser_userrights`
-- 

INSERT INTO `liveuser_userrights` VALUES (2, 1, 3);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_users`
-- 

CREATE TABLE `liveuser_users` (
  `authUserId` varchar(32) NOT NULL default '',
  `handle` varchar(32) NOT NULL default '',
  `passwd` varchar(32) NOT NULL default '',
  `lastLogin` datetime default '1970-01-01 00:00:00',
  `isActive` tinyint(1) default '1',
  `owner_user_id` int(11) default '0',
  `owner_group_id` int(11) default '0',
  UNIQUE KEY `users_authUserId_idx` (`authUserId`),
  UNIQUE KEY `users_unique_i_idx` (`handle`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Zrzut danych tabeli `liveuser_users`
-- 

INSERT INTO `liveuser_users` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2007-01-17 14:56:34', 1, 0, 0);
INSERT INTO `liveuser_users` VALUES ('2', 'guest', '084e0343a0486ff05530df6c705c8bb4', '1970-01-01 00:00:00', 1, 0, 0);
INSERT INTO `liveuser_users` VALUES ('9', 'User4', '6b908b785fdba05a6446347dae08d8c5', '1970-01-01 00:00:00', 1, 0, 0);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `liveuser_users_seq`
-- 

CREATE TABLE `liveuser_users_seq` (
  `sequence` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- Zrzut danych tabeli `liveuser_users_seq`
-- 

INSERT INTO `liveuser_users_seq` VALUES (9);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `news`
-- 

CREATE TABLE `news` (
  `id` int(11) NOT NULL auto_increment,
  `date` date NOT NULL default '0000-00-00',
  `author` varchar(32) NOT NULL default '',
  `title` varchar(48) NOT NULL default '',
  `content` text NOT NULL,
  `gallery_item_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`,`author`(8),`date`),
  KEY `author` (`author`(8)),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Zrzut danych tabeli `news`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `profile`
-- 

CREATE TABLE `profile` (
  `user_id` varchar(255) NOT NULL default '',
  `pref_id` varchar(32) NOT NULL default '',
  `pref_value` longtext NOT NULL,
  PRIMARY KEY  (`user_id`,`pref_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Zrzut danych tabeli `profile`
-- 

INSERT INTO `profile` VALUES ('9', 'email', 's:13:"User666@o2.pl";');
INSERT INTO `profile` VALUES ('1', 'email', 's:13:"admin@egie.pl";');
INSERT INTO `profile` VALUES ('1', 'name', 's:5:"admin";');
INSERT INTO `profile` VALUES ('1', 'position', 's:13:"Administrator";');
