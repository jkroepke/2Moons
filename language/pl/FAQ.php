<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */


$LNG['faq_overview']	= "FAQ";
 
$LNG['questions']					= array();
$LNG['questions'][1]['category']	= 'Wskazówki dla początkujących';
$LNG['questions'][1][1]['title']	= 'Część 1';
$LNG['questions'][1][1]['body']		= <<<BODY
<p>Ta część samouczka opisuje głównie budynki . Wyjaśnia, co należy budować na początku i na co są one potrzebne. Aby zbudować udane imperium, ważne jest, by budować budynki w określonej kolejności. </p>
<h3>Elektrownia słoneczna:</h3>
<p>W celu wytwarzania surowców tak bardzo potrzebnych twojemu rozwijającemu się imperium, pierwsze co musisz zrobić to zbudować elektrownie. Produkuje ona energię która jest potrzebna do produkcji zasobów przez kopalnie. Ilość energii możesz sprawdzić w zakładce zasoby. Dowiesz się tam ile produkujesz, a jakie są twoje potrzeby.</p>
<h3>Kopalnia metalu:</h3>
<p>Metal jest jednym z trzech zasobów wydobywalnych w grze. Jest najszybciej i najtaniej produkowany, ale że jest używany do budowy praktycznie wszystkiego na planecie, rozwój tej kopalni jest wskazany! W początkowym etapie gry warto by poziom kopalni metalu był o kilka lvl wyższy.</p>
<h3>Kopalnia kryształu i ekstraktor deuterium:</h3>
<p>KKryształ również jest bardzo ważnym elementem do budowy budynków, statków czy odkrywania nowych technologii. Jego wydobycie jest znacząco mniejsze, dlatego jedna jednostka kryształu odpowiada dwóm jednostkom metalu. Deuterium to głównie paliwo dla floty, jest również wymagany podczas prowadzenia ważnych badań. Jego wydobycie jest również znacząco mniejsze w stosunku do metalu jak i kryształu!.</p>
BODY;
$LNG['questions'][1][2]['title']	= 'Część 2';
$LNG['questions'][1][2]['body']		= <<<BODY
<p>Podczas rozbudowy swojego imperium będziesz zmuszony do konkurowania lub też współpracy w innymi graczami. Przyda się do tego zaawansowana technologia, jak również rozbudowana stocznia byś mógł tworzyć flotę godną twojego imperium, jak i obronę. Więcej informacji znajdziesz tutaj:</p>
<h3>Stocznia:</h3>
<p>Wszystkie statki czy też elementy obrony buduje się w stoczni. Na samym początku musisz zacząć od jej zbudowania. Wszelkich informacji jakie będą Ci potrzebne odnośnie zapotrzebowania na technologię, która jest wymagana do budowy zaawansowanych jednostek dostarczy Ci zakładka technologia. Rozbudowana stoczni wpływa również na szybkość budowy czy to jednostek czy też obrony.</p>
<h3>Laboratorium badawcze:</h3>
<p>Budynek ten służy do przeprowadzenia badań na twoich planetach. Są one wymagane do budowy zaawansowanych budynków, jak również mogą poprawić pracę dotychczasowych. Poprzez rozbudowę laboratorium badawczego zwiększysz nie tylko szybkość badań ale również będziesz mógł odkryć bardziej zaawansowane technologie.</p>
<h3>Fabryka robotów:</h3>
<p>Fabryka robotów to jeden z ważniejszych budynków. Dzięki jego rozbudowie przyśpiesza budowa innych budynków na planecie!.</p>
BODY;
$LNG['questions'][1][3]['title']	= 'Część 3';
$LNG['questions'][1][3]['body']		= <<<BODY
<p>W tej części dowiesz się krótko jak bronić własną planetę i jak zarządzać własną flotą. Znajdziesz tutaj również informacje przydatne podczas interakcji z innymi graczami</p>
<h3>Galaktyka:</h3>
<p>Galaktykę przeglądasz w celu lokalizacji innych graczy jak i np. w celu poszukiwania złomu. Znajdziesz tam również szczegółowe informacje o sąsiedztwie planet innych graczy, możesz też wysyłać bezpośrednio z podglądu galaktyki niektóre akcje floty. Np akcję szpieguj gracza, jeśli masz zbudowane sondy szpiegowskie, czy też wysyłać wiadomości do innych graczy..</p>
<h3>Floty:</h3>
<p>Floty możesz wysyłać bezpośrednio z przeglądu galaktyki, czy też z zakładki flota. Najpierw wybierasz ilość z dostępnych jednostek, potem ustawiasz cel(podajesz koordynaty które znajdziesz w galaktyka) i ustawiasz szybkość z jaką ma się poruszać flota. Musisz wybrać również rodzaj akcji jaką ma przeprowadzić flota, poczynając od stacjonuj a na zbieraniu złomu kończąc.</p>
<h3>Obrona:</h3>
<p>By móc bronić swoją planetę tuż po zbudowaniu stoczni będziesz miał możliwość budowy obrony stacjonarnej. Daje ona ochronę przed atakami innych graczy, jak również broni planetę gdy twoja flota jest na innej. W przeciwieństwie do floty, gdy zbudujesz obronę i zostanie ona zniszczona w trakcie walki, to po walce ma 70% szans na to że zostanie reaktywowana.</p>
BODY;

$LNG['questions'][2]['category']	= 'Informacje zaawansowane';
$LNG['questions'][2][1]['title']	= 'Rajdy';
$LNG['questions'][2][1]['body']		= <<<BODY
<h3>Raiden:</h3>
<p>Termin którego możemy użyć opisując ataki na innych graczy
Rajdy można podzielić na kilka typów:</p>
<ul>
	<li>Farmienie</li>
	<li>Polowanie na flotę</li>
	<li>Pola zniszczeń</li>
	<li>Przechwytywanie </li>
</ul>
<h3>Farmienie:</h3>
<p>Najprostszy sposób zdobycia zasobów, wykonywany tak często jak to tylko możliwe<br>
Polega na wyszukiwaniu słabych planet w naszym pobliżu(najlepiej graczy nie aktywnych, lub mało aktywnych). Wyszukujemy planety na których nie ma obrony, lub jeśli jest to jest na tyle mała że nie przyniesie nam strat, lub starty będą minimalne. Innymi słowy musisz atakować to na czym najwięcej zarobisz jak najmniej tracąc</p>
<h3>Polowanie na flotę:</h3>
<p>Dla bardziej zaawansowanych.<br>
Polowanie na wrogie floty.<br>
Najbardziej emocjonująca część gry, czyli polowanie na flotę przeciwnika. Czego potrzebujesz, sporej dawki szczęścia, jeszcze więcej czasu bo do najłatwiejszych zadań to nie należy. Nie oceniona może również okazać się falanga, a jeśli przeciwnik jest silniejszy to wsparcie przyjaciół z sojuszu. Gdy uda Ci się już zniszczyć wrogą flotę, to przychodzi czas na zebranie pola zniszczeń ze złomowania. I tutaj musisz pamiętać o tym że takie pole zniszczeń może Ci ktoś podkraść. Najważniejszą częścią złomowania jest koordynacja ataku floty jak i zbierania złomu, jeśli robisz AKS to bardzo ważną rzeczą jest współpraca graczy.</p>
<h3>Pola zniszczeń:</h3>
<p>Najbardziej wygodnia metoda zdobywania zasobów, jak również najbardziej znienawidzona jeśli dojdzie do kradzieży pola zniszczeń
Pola zniszczeń z floty nie należą do nikogo, więc każdy może je zebrać. Dlatego kradzież pola zniszczeń to duży problem..</p>
<h3>Przechwytywanie</h3>
<p>Najważniejsze zadanie to zbudować flotę i zniszczyć flotę przeciwnika. Nie zawsze jest łatwo zniszczyć czyjąś flotę, powiedział bym nawet że najczęściej jest trudno, a jeśli polujemy na dobrego gracza, wtedy polowanie może być bardzo wymagające. Złapać flotę możesz jeśli leci z misją transportuj, lub atakuj. Jednak są misje, podczas których flot nie da się złapać w żaden sposób</p>
<ul>
	<li><p>Jeśli masz księżyc, a na nim falangę to przechwycenie obcej floty robi się dużo łatwiejsze. Wtedy wybierasz planetę i ją skanujesz, jeśli dostrzeżesz aktywne floty na tej planecie to musisz zdecydować czy opłaca Ci się atak. Jeśli tak to czas by zdobyć kilka potrzebnych ci danych. Musisz zwrócić uwagę jak długo flota leci, kiedy doleci do celu, czy będzie wracać. A to znaczy że musisz również znać szczegóły technologiczne przeciwnika( poziom rozwoju silników najwolniejszej jednostki, zdobędziesz je wysyłając sondy szpiegowskie z misja szpieguj), wtedy możesz za pomocą kalkulatora wyliczyć dokładny czas nie tylko przybycia do celu, ale również powrotu. Bardzo przydatny może się okazać zegarek z budzikiem, nie tylko do ocenienia o której godzinie flota dotrze.</p>
	<p>Gdy już wiesz o której flota się zjawi na planecie, czy też księżycu musisz wysłać swoją flotę tak, by dotarła do celu 2-5 sekund po flocie przeciwnika.(Jeśli przeciwnik dobry, to 5 sekund może się okazać zbyt dużą różnicą i zdąży uciec.) Kolejne co musisz zrobić to wysłać odpowiednią ilość recyklerów by zebrać złom. Powinny się zjawić maksymalnie kilka sekund po ataku, w przeciwnym wypadku ktoś może Ci skraść pole zniszczeń !</p></li>
	<li>Jedną z form polowania może być również zastawianie pułapek. Zostawiając flotę słabszą niż mamy w rzeczywistości(flotę dosyłamy z innej planety tak by była 10 sekund przed atakiem), lub tęż korzystanie z aks i łączenia flot tuż przed atakiem(misja zostań). Trzeba uważać by się samemu na coś takiego nie naciąć, ale również samemu to wykorzystywać. Dlatego zawsze warto pilnować swojego ataku by móc zawrócić jeśli sytuacja ulegnie zmianie.</li>
	<li><p>Jeśli przeciwnik nasz wykonuje trik z flotą którą wysyła z misją stacjonuj, a potem ją zawraca to takiej floty nie widać na falandze. Ale i tak można ją przechwycić. Kluczem zawsze jest dokładne studiowanie przeciwnika, musisz poznać jego przyzwyczajenia. Np jeśli flotę zawrócił kilka minut przed dotarciem do celu, a ty wiesz dokładnie ile leciała flota w tę stronę to możesz łatwo policzyć o której będzie u celu i ją przechwycić. Jeśli przeciwnik korzysta z księżyców zawsze możesz księżyc zniszczyć wtedy flota będzie skierowana automatycznie na planetę i będzie widoczna w falandze. Do niszczenia księżyców służy misja niszcz. 

Jak widać sposobów na przechwycenie floty przeciwnika jest wiele, wymienione tutaj to tylko kawałek góry, więcej dowiesz się rozmawiając z ludźmi czy też przeglądając forum..</li></ul>
BODY;

$LNG['questions'][2][2]['title']	= 'Fleet save czyli bezpieczeństwo floty';
$LNG['questions'][2][2]['body']		= <<<BODY
<h3>Jak mogę się chronić</h3>
<p>Czasem wystarczy duża obrona by odstraszyć potęcjalnego atakującego, zbyt duża ilość obrony może go przyciągnąć tym bardziej jeśli obrona zostaje również w jakiejś części przekształcona w pole zniszczeń.</p>
<p>Ponadto w grze istnieją również rakiety między planetarne, które bardzo dobrze sprawują się w niszczeniu obrony, zatem jeśli mamy sporą obronę na planecie, warto do niej dobudować kilka - lub też kilkanaście anty-rakiet.</p>
<p>Potężna flota - nadaje się doskonale do obrony naszej planety, do tego ma możliwość ucieczki jeśli leci przeciwko nam silniejszy przeciwnik. Niestety potężna flota działa odstraszająco na słabszych graczy, ale zachęcająco na tych mocniejszych. Również dzięki możliwości AKS może się zdarzyć że kilku mniejszych, słabszych graczy po połączeniu swoich flot będzie miało flotę dużo mocniejszą od Ciebie! </p>
<p>Najlepszą obroną przed atakiem, to nie pozwolenie by zdobyto informacje o tym jakie i ile jednostek posiadasz, jak również zasobów! Gdy nie ma Cie przed komputerem wykorzystaj swoją flotę do tego by załadować zasoby i wysłać na inną swoją planetę z odpowiednio ustawioną prękością. Ale uwaga musisz pamiętać o falandze, a to znaczy że najczęsciej najlepszym wyjściem jest odbiór osbisty floty, tak by można ja było zawrócić.</p>
<h3>Najlepszą metodą obrony są odpowiednie fleet save</h3>
<p>Fleet save to kluczowy element w rozwoju twojego imperium, ale wielu graczy o nim nie wie, lub zapomina. Istnieje wiele sposobów na to by zabezpieczyć swoją flotę jak i zasoby. Jedne są mniej bezpieczne, inne bardziej, ale na pewno warto ich używać. Oto kilka z nich.<br>
Pierwszą </p>
<p>Pierwszą metodą zabezpieczenia floty jak i zasobów na czas naszej nie obecności w grze, to misja "stacjonuj - z zawróceniem jej nim doleci do celu". Czyli jeśli wiesz że nie będzie Cię w grze 4h np. to wysyłasz całą flotę razem z załadowanymi zasobami z taką prędkością by doleciała do celu po tych 4 godzinach. Logując się sprawdzasz czy jej dolot jest bezpieczny, jeśli tak to możesz jej pozwolić dolecieć do celu, ale jeśli nie to wtedy klikasz zawróć. Pamiętaj, im więcej czasu masz na zawrócenie floty, tym trudniej będzie ją przechwycić gdy będzie wracała. Jeśli flotę zawrócisz np. 30 sekund przed doleceniem do celu, a osoba która na Ciebie poluje zauważy to na falandze, to wiedząc ile czasu trwał lot w jedną stronę bardzo łatwo może wyliczyć o której twoja flota wróci i przechwycić ją w takim momencie gdy nie będziesz w stanie z nią uciec! Flotę możesz wysłać na planetę lub też na pole zniszczeń czy też księżyc.</p>
<p>Najpewniejszą misją dającą praktycznie nie możliwość przechwycenia twojej floty jest misja stacjonuj między księżycami (księżyca nie można skanować falangą!). Oczywiście zawsze istnieje możliwość iż ktoś nam księżyc zniszczy by przechwycić tą flotę, ale taka opcja jest mało prawdopodobna!</p>
BODY;

$LNG['questions'][2][2]['title']	= 'Wspólna walka - AKS';
$LNG['questions'][2][2]['body']		= <<<BODY
<h3>Atakowanie AKS</h3>
<p>Jak wiadomo można atakować wspólnie, by to zrobić musisz wysłać flotę z misją atakuj. Potem wchodzisz w zakładkę floty, pod przyciskiem zawróć masz przycisk acs, a tam możliwość zmiany nazwy ataku, jak również zapraszanie innych do acs by dołączyli. Zaprasza osoba która rozpoczyna atak, i to ona wysyła zaproszenia ! Do ataku możesz zaprosić maksymalnie 5 graczy, łączenie w jednym ataku acs może być dołączone 16 flot, i to jest maksimum. Floty automatycznie dostosują prędkość do najwolniejszej floty biorącej udział w ataku, ale, istnieje ograniczenie w możliwości spowolnienia floty do 30% czasu lotu. A to znaczy że jeśli wyślesz flotę i przykładowo będzie ona mieć 100 minut do celu, to najwolniejsza flota może mieć maksymalnie 130min do celu! Więc jeśli kolejna osoba chcąca dołączyć to tego ataku będzie miał czas dolotu mniejszy od 100 minut to nie będzie mogła do takiego ataku dołączyć!<br>
<b>Uwaga:</b> jeśli jedna z flot zostanie zawrócona to reszta poleci dalej!!</p>
<h3>Obrona  AKS</h3>
<p>Tak samo jak i atakować można wspólnie, to można również się bronić wspólnie celem czy to obrony, czy też zasadzki lub najprościej celem minimalizacji strat. Widząc że leci na ciebie atak możesz poprosić albo kogoś z listy twoich znajomych by podesłał Ci flotę, lub kogoś z sojuszu. Ważne jednak byś na planecie na którą ma zostać wysłana flota miał zbudowany depozyt sojuszniczy. W innym wypadku nie będzie możliwe wysłanie floty na twoją planetę z misją zostań! Jeśli kogoś prosisz o wsparcie ważne by postarać się o to by flota sojusznika pojawiła się kilka sekund przed atakiem, w innym wypadku atakujący gracz sprawdzając siły na planecie, może stwierdzić że atak mu się nie opłaca i lepiej wycofać swoje jednostki..</p>
<h3>Zapotrzebowanie na deuterium w czasie postoju na obcej planecie (1h postoju to ilość jednostek :</h3>
<p>Mały transporter: 5<br>
Duży transporter: 5<br>
Lekki myśliwiec: 2<br>
Ciężki myśliwiec: 7<br>
Krążownik: 30<br>
Pancernik: 50<br>
Kolonizator: 100<br>
Recykler: 30<br>
Sonda szpiegowska: 1/10<br>
Bombowiec: 100<br>
Niszczyciel: 100<br>
Gwiazda śmierci: 1/10</p>
BODY;

$LNG['questions'][2][3]['title']	= 'Księżyce';
$LNG['questions'][2][3]['body']		= <<<BODY
<p>By powstał księżyc musi w trakcie walki powstać pole zniszczeń z minimalną ilością jednostek, czyli 100 000. Każde następne 100 000 jest przeliczone na 1% szansy na powstanie księżyca, aż do osiągnięcia maksymalnie 20% szansy na księżyc ! Jeśli pole zniszczeń jest znacząco większe wpływa to tylko na średnicę księżyca, ale nie modyfikuje maksymalnej szansy na powstanie go!</p>
<h3>Ogólnie</h3>
<p>Na jedną planetę przypada tylko 1 księżyc. Możesz oczywiście zmienić nazwę księżyca. Na księżycu by móc budować musisz zbudować najpierw bazę księżycową, to najważniejszy budynek bo zwiększa ilość pól do zabudowy</p>
<h3>Księżycowa próba</h3>
<p>Jako księżycową próbę uważa się celowo wysłaną flotę składającą się np z lekkich myśliwców w ilości 1667( co daje dokładnie 20% szansy) na silnie bronioną planetę. Dlaczego LM ? dlatego że są tanie, ale również stosunkowo łatwo je zniszczyć. Oczywiście możesz użyć innych jednostek w innych ilościach i może to wyjść taniej lub drożej. Księżyc nigdy nie będzie większy niż średnica 8944km.</p>
<h3>Budownictwo</h3>
<p>Budowę na księżycu powinieneś zacząć od zbudowania bazy księżycowej, która da Ci dodatkowe pola pod budowę. Ponieważ pola do zabudowy na księżycu są bardzo cenne, i co chwilę trzeba stawiać bazę księżycową nie warto tam budować czegoś co nie jest absolutnie zbędne, typu magazyny, stocznia itp.<br>
Najważniejsze budynki na księżycu:</p>
<ul><li><p><b>Baza księżycowa</b><br>Najważniejszy budynek na księżycu, każdy poziom rozbudowy daje Ci 2 dodatkowe pola do zabudowy.</p></li>
<li><p><b>Falanga</b><br>Falanga służy do szpiegowania aktywnych flot na planetach w jej zasięgu. Każdy poziom zwiększa zasięg falangi. Falanga nie może szpiegować księżyców a tylko planety!</p></li>
<li><p><b>Teleporter</b><br>Służy do natychmiastowego przesyłania floty z jednego księżyca na drugi. Musisz mieć conajmniej 2 księżyce by móc go używać. Nie możesz w ten sposób transportować zasobów, tylko floty wojenne. Każde użycie wymaga ponownego naładowania się i trwa określoną ilość czasu!</p></li></ul>
<h3>Zniszczenie księżyca</h3>
<p>Księżyc można zniszczyć za pomocą gwiazdy śmierci, to jedyna jednostka mogąca tego dokonać.</p>
<p>W misjach wybierz misję zniszcz, i wyślij gwiazdy do pracy. Po zniszczeniu księżyca nie zostaje pole zniszczeń</p>

BODY;

$LNG['questions'][2][4]['title']	= 'Sojusz';
$LNG['questions'][2][4]['body']		= <<<BODY
<h3>Jak mogę założyć sojusz?</h3>
<p>By założyć sojusz musisz się udać do zakładki sojusze w menu. Potem klikasz załóż sojusz, podajesz nazwę i tag sojuszu. Gotowe<br>
Pamiętaj że w nazwach nie możesz używać znaków specjalnych<br>
<h3>Menu zarządzania sojuszem</h3>
<p>Wszystkie działania związane z istnieniem sojuszu ustawiasz w panelu zarządzania sojuszem. Dotyczy to rang w sojuszu, wiadomości, przykładowych podań czy też polityki z innymi sojuszami. Ważne by osoba która zarządza sojuszem miałą zacięcie dyplomatyczne które pomaga nie tylko podczas wojen, ale również podczas szukania innych sojuszników, paktowania z innymi sojuszami itd.<br>

BODY;

// Translated into Polish by Sirgomo . All rights reversed (C) 2012