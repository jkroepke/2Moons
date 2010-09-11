<?php

//general
$LNG['index']				= 'Index';
$LNG['register']			= 'Registriraj se';
$LNG['forum']				= 'Forum';
$LNG['send']				= 'Posalji';
$LNG['menu_index']			= 'Pocetna'; 	 
$LNG['menu_news']			= 'Novosti';	 
$LNG['menu_rules']			= 'Pravila'; 
$LNG['menu_agb']			= 'Uslovi i Odredbe'; 
$LNG['menu_pranger']		= 'Banirani';
$LNG['menu_top100']		= 'HoF';	 
$LNG['menu_disclamer']		= 'Kontakt';	 
	 
/* ------------------------------------------------------------------------------------------ */

//index.php
//case lostpassword
$LNG['mail_not_exist'] 		= 'E-mail adresa ne postoji!';
$LNG['mail_title']				= 'Nova lozinka';
$LNG['mail_text']				= 'Vasa nova lozinka je: ';
$LNG['mail_sended']			= 'Vasa lozinka je uspjesno poslana!';
$LNG['mail_sended_fail']		= 'Greska sa slanjem E-maila.!';
$LNG['server_infos']			= array(
	"Strateska igra u stvarnom vremenu.",
	"Igrajte zajedno sa stotinama korisnika.",
	"Bez preuzimanja,zahtijeva samo standardni preglednik.",
	"Besplatna registracija",
);

//case default
$LNG['login_error']			= 'Pogresno korisnicko ime / lozinka! <br><a href="index.php">Nazad</a>';
$LNG['screenshots']			= 'Screenshots';
$LNG['universe']				= 'Univerzum';
$LNG['chose_a_uni']			= 'Izaberi univerzum';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title']		= 'Spasi lozinku';
$LNG['retrieve_pass']			= 'Vrati';
$LNG['email']					= 'E-mail Adresa';

//index_body.tpl
$LNG['user']					= 'Korisnik';
$LNG['pass']					= 'Lozinka';
$LNG['remember_pass']			= 'Auto-Prijava';
$LNG['lostpassword']			= 'Zaboravili ste lozinku?';
$LNG['welcome_to']				= 'Dobrodosli na';
$LNG['server_description']		= '<strong>%s</strong> je svemirska igra strategij sa stotinama igraca istovremeno pokusaj biti najbolji.Sve sto trebate za igranje je standardni web preglednik (FireFox se preporucuje).';
$LNG['server_register']		= 'Molimo registrirajte se sada!';
$LNG['server_message']			= 'Prijavite se sada i iskusite novi i uzbudljivi svijet';
$LNG['login']					= 'Prijava';
$LNG['disclamer']				= 'Kontakt';
$LNG['login_info']				= 'Prijavom prihvacam <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Pravila</a> i <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Uslove i Odredbe</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed']			= 'Registracija je zavrsila!';
$LNG['register_at']				= 'Registrirani u ';
$LNG['reg_mail_message_pass']		= 'Jos jedan korak da aktivirate svoje korisnicko ime';
$LNG['reg_mail_reg_done']			= 'Dobrodosli na %s!';
$LNG['invalid_mail_adress']		= 'Pogresna e-mail adresa!<br>';
$LNG['empty_user_field']			= 'Molimo Vas da ispunite sva polja!<br>';
$LNG['password_lenght_error']		= 'Lozinka treba imati vise od 4 znakova!<br>';
$LNG['user_field_no_alphanumeric']	= 'Molimo unesite korisnicko ime samo alfanumerickim znakovima!<br>';
$LNG['user_field_no_space']		= 'Polje za korisnicko ime nemoze ostati prazno!<br>';
$LNG['planet_field_no_alphanumeric']	= 'Unesite ime planeti samo alfanumerickim znakovima!<br>';
$LNG['planet_field_no_space']		= 'Polje za ime planete nemoze ostati prazno!<br>';
$LNG['terms_and_conditions']		= 'Morate prihvatiti <a href="index.php?page=agb">Uslovi i Odredbe</a> i <a href="index.php?page=rules>Pravila</a> hvala!<br>';
$LNG['user_already_exists']		= 'Korisnicko ime je vec zauzeto!<br>';
$LNG['mail_already_exists']		= 'E-mail adresa je vec u uporabi!<br>';
$LNG['wrong_captcha']				= 'Pogresan sigurnosni kod!<br>';
$LNG['different_passwords']		= 'Upisali ste dvije razlicite lozinke!<br>';
$LNG['different_mails']			= 'Upisali ste dvije razlicite adrese!<br>';
$LNG['welcome_message_from']		= 'Administrator';
$LNG['welcome_message_sender']		= 'Administrator';
$LNG['welcome_message_subject']	= 'Dobrodosli';
$LNG['welcome_message_content']	= 'Dobrodosli na %s!<br>Prvo izgradite solarnu elektranu,jer energija je potrebna za kasniju proizvodnju sirovina. Kako ga izgraditi,lijevi klik u izborniku na "zgrade".Zatim izgraditi cetvrtu zgradu od vrha.Sada imate energije, mozete poceti graditi rudnike. Vratite se na meni izgradnju i izgradite rudnik metala,pa opet rudnik kristala. Da bi mogli graditi brodove trebate imati prvo izgradeno brodogradilista.sto je potrebno za izgradnju to cete naci u lijevom izborniku tehnologije.Sybaron tim zeli vam puno zabave u istrazivanju svemira!';
$LNG['newpass_smtp_email_error']	= '<br><br>Doslo je do pogreske. Vasa lozinka je: ';
$LNG['reg_completed']				= 'Hvala Vam na registraciji! Primit cete e-mail s aktivacijskim linkom.';

//registry_form.tpl
$LNG['server_message_reg']			= 'Registriraj se sada i postani dio svemira';
$LNG['register_at_reg']			= 'Registrirani u';
$LNG['uni_reg']					= 'Univerzum';
$LNG['user_reg']					= 'Korisnik';
$LNG['pass_reg']					= 'Lozinka';
$LNG['pass2_reg']					= 'Potvrdite lozinku';
$LNG['email_reg']					= 'E-mail Adresa';
$LNG['email2_reg']					= 'Potvrdite E-mail Adresu';
$LNG['planet_reg']					= 'Ime za glavnu planetu';
$LNG['lang_reg']					= 'Jezik';
$LNG['register_now']				= 'Registriraj me!';
$LNG['captcha_reg']				= 'Sigurnosno pitanje';
$LNG['accept_terms_and_conditions']= 'Privacam <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Pravila</a> i <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1&amp;\'+\'lang=%1$s\');" style="cursor:pointer;">Uslove i Odredbe</a>';
$LNG['captcha_reload']				= 'Ucitaj ponovo';
$LNG['captcha_help']				= 'Pomoc';
$LNG['captcha_get_image']			= 'Ucitaj Bild-CAPTCHA';
$LNG['captcha_reload']				= 'New CAPTCHA';
$LNG['captcha_get_audio']			= 'Ucitaj zvucnu-CAPTCHA';
$LNG['user_active']                = 'Korisnik %s je aktiviran!';

//registry_closed.tpl
$LNG['info']						= 'Informacije';
$LNG['reg_closed']					= 'Registracija je zavrsila';

//Rules
$LNG['rules_overview']				= "Pravila";
$LNG['rules']						= array(
	"Racuni"					=> "Cuvanje racuna je dozvoljeno samo pod sljedecim uvjetima:

    * Svaki se racun moze cuvati najduze 48 sati
    * Morate obavjestiti Administratora o cuvanju
    * Kada se cuva racun, dozvoljeno je koristiti resurse samo lokalno, znaci ono sto je na planeti mozete trositi na gradnju ili unaprijedivanje gradevina. Nije dozvoljeno transportirati resurse izmedu planeta (mjeseca) onome tko cuva racun
    * Prije sljedeceg cuvanja, vlasnik se MORA ponovo ulogirati. Isti igraci nemogu stalno cuvati iste racune (znaci ako ste danas cuvali nekome racun, sljedeci put to mora raditi netko drugi)
    * Kada se vlasnik ponovo ulogira, mora proci minimalno 7 dana do mogucnosti za novo cuvanje koje nesmije napraviti osoba koja je zadnja cuvala racun
    * Nakon sto je cuvaru istekao period cuvanja, on sljedecih 7 dana nesmije cuvati nijedan drugi racun 

Nije dozvoljeno

    * Nikakvo pokretanje flote nije dozvoljeno dok se cuva racun, jedino je dozvoljen Fleetsave, ali samo ako je netko napao dok je cuvan racun. Fleetsave je dozvoljen samo na vlasnikove planete ili mjesece
    * Od trenutka kada je najavljno cuvanje, samo se cuvar smije logirati, ako se ulogira vlasnik, smatra se da je cuvanje zavrseno
    * Nije dozvoljeno da vise igraca cuva jedan racun tijekom perioda cuvanja.
    * Slanje resursa ili napadanje samog sebe za vrijeme cuanja tudeg accounta rezultirati ce trajnim banom.
    * Aktivno koristenje cuvanog racuna (spijuniranje i/ili falangiranje) rezultirati ce brisanjem racuna ",


	"Pushing"					=> "    *  Pushing je zabranjen i za njega ide trajni ban.
    * Kada nize rangirani igrac salje resurse vise rangiranom igracu
    * Takoder kada slabije rangirani igrac salje resurse vise rangiranom pod ucjenom napada
    * Kada neocekivano primite resurse od nize rangiranog igraca, ne mozete ih zadrzati, vec ih morate vratiti
    * Posudba nije dozvoljena
    * Trgovina mora biti zavrsena unutar 48 sati.
	*Trgovina je sljedecem omjeru.3:2:1 gdje svaka jedinica deuterija vrijedi 2 jedinice kristala i 3 jedinice metala.2:1:1 gdje svaka jedinica deuterija vrijedi 1 jedinicu kristala i 2 jedinice metala.",

	"Bashing"					=> "Maksimalno je dozvoljeno po 6 napada na svaku od planeta ili mjeseca istog igraca u roku od 24 sata.

Bashing je dozvoljen kada su 2 Saveza u ratu.Rat mora biti objavljena na forumu i oba lidera moraju pristati na uvjete.",

	
	"Bugusing"					=> "Iskoristavanja bugova nije dozvoljeno.",


	"Prijetnje u stvarnom zivotu"	=> "Bilo kakva prijetnja koja je povezana sa stvarnim zivotom biti ce najstroze sankcionirana.",

	"Spam i uvrede"			=> "Spam, uvrede, nacionalizam, politika nisu dozvoljeni
Politicki provokativni nickovi ili imena saveza nisu dozvoljeni
Moralno opasni, pornografski, nacionalno uvrijedljivi, politicki ustrojeni nickovi, savezna imena, slike saveza, postovi i provokacije nisu dozvoljene.
Igra ne sluzi kao politicka platforma!!! Tim uzima sebi za pravo da odlucuje nad svakom slucaju",

  "Ratovi"                    => "Savez moze objaviti rat drugom savezu tako da stavi post objave u vec ranije odredeno mjesto u diplomaciji na forumu. Suradnistvo izmedu saveza ili saveza i igraca je moguce ali ne treba biti posebno objavljeno.

Rat znaci da se igraci mogu napadati bez bojazni da ce dobiti ban za bashing.

Nakon 12 sati od objave rata se ukida pravilo o bashingu, time dopustajuci da se upozore svi igraci o ratu.

Ako jedan igrac napusti savez, rat se vise ne odnosi na njega i stupaju na snagu normalna pravila o bashingu.",                          

);

$LNG['rules_info1']				= "";
$LNG['rules_info2']				= "Kako bi upotpunili ovaj <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">Uslovi i odredbe</a> are considered and followed!</font>";


//AGB

$LNG['agb_overview']				= "Uslovi i odredbe";
$LNG['agb']						= array(
	"Usluga sadrzaja"				=> array( 
		"Ovo je nuzan preduvjet da bi mogli sudjelovati u igri.
On se primjenjuje na forum i igru. ",

"Usluga je besplatna.
Stoga ne postoje prava na dostupnost, dostavu, funkcionalnost, odnosno povrat nastale stete.
Nadalje, igrac nema prava na povrat racuna ako je prekrsio uslove i odredbe.",
	),

	"Clanstvo"				=> array(
		"Registriranjem u igru ili na forum pocinje clanstvo. ",

"Clanstvo moze prestati brisanjem racuna ili pismom administratora.
Brisanje podataka iz tehnickih razloga ne mogu napraviti odmah. ",

"Prekinut od strane Administratora korisnici nemaju pravo sudjelovanja u natjecajima za operatora.
Administrator zadrzava pravo brisanja racuna.
Odluka za brisanje racuna je samo i iskljucivo na administratoru.",
	),

	"Sadrzaj / Odgovornost"	=> "Za razni ostali sadrzaj, korisnici su sami odgovorni. Pornografski, rasisticki, uvredljiv ili neki drugi nacin koji krsi vazeci zakon u suprotnosti sadrzaja izvan su odgovornosti administratora.
Krsenje moze dovesti do brisanja racuna.",

	"Zabranjeni postupci"			=> array(
		"Korisnik nije ovlasten koristiti hardware / software ili druge tvari ili mehanizme povezane s web-stranicom, sto moze utjecati na funkciju i igru.
Korisnik ne moze nastaviti poduzimati nikakve radnje koje mogu uzrokovati stres ili nepotrebno povecanu tehnicku sposobnost.
Korisnik ne smije manipulirati sadrzajem generiran od strane operatora ili na bilo koji nacin mijesati istog u igru.",
		
		"Bilo koja vrsta bot,skripte ili drugih automatiziranih obiljezja su zabranjena.
Igra se moze igrati samo u pregledniku. Cak i njegove funkcija ne bi trebalo koristiti da dobijete prednost u igri.
Dakle,reklama ce biti blokirana. Odluka kada je softver koristan za igrace i smije li se koristiti,lezi iskljucivo na odluci administratora .",
		
	
	),

	"Ogranicenja koristenja"		=> array(
		"Igrac moze koristiti samo jedan racun po svemiru, takozvani \ Multiaccount \ nije dozvoljen te ce biti izbrisani bez upozorenja.
Odluka kada postoji \ multi \ lezi iskljucivo na odluci administratora (igranje sa iste IP).",
		
		"Pojedinosti ce se voditi prema pravilima.",
		
		"Lockouts opciju moze trajno ili po vlastitom nahodenju privremeno ili stalno napraviti jedino administrator.
Slicno tome,lockouts moze se prosiriti na jednu ili sva raspoloziva podrucja u igri.
Odluka ce biti obustavljena kada i koliko dugo treba za provjeru igraca od strane administratora
Napomena,administrator moze pojedinom igracu zabraniti pristup npr.pregledu galaksije idr.",
	),

	"Privatnost"					=> array(
		"Administrator zadrzava pravo za pohranu podataka od igraca kako bi se pratilo pridrzavanje pravila, uvjete koristenja i mjerodavno pravo.
Varalica sve potrebne i podnesena od strane igraca ili njegov racun.
Ovi (IP povezane s razdobljima uporabe i koristenja, e-mail adresu dati tijekom registracije i drugih podataka.
Na forumu i u profilu su pohranjene. "

"Ovi podaci ce biti iskoristeni pod odredenim okolnostima za provodenje zakonom propisane duznosti sluzbenika i drugih ovlastenih osoba.
Nadalje, podaci se mogu (ako treba izdati) pod odredenim okolnostima trecim osobama. "

"Korisnici mogu prigovoriti pohrani osobnih podataka u bilo koje vrijeme. zalba je prestanak ovih prava.",
	),

	"Prava administratorskog racuna"	=> array(
		"Svi racuni i sve virtualne objekte ostaju u posjedu i vlasnistvu administratora.
Igrac ne stjece vlasnistvo i druga prava na bilo koji racun ili dijelove.
Sva prava ostaju s administratorom.
Prijenos eksploatacije ili drugih prava na korisnika ce se odrzati u bilo koje vrijeme.",
		
		"Neovlastena prodaja, koristenje, kopiranje, distribuiranje, reproduciranje ili na drugi nacin krsenje prava (npr. na racunu) od administratora ce biti prijavljeni vlastima na procesuiranje.
Dozvoljena je sve sto je dopusteno u pravilima.",
	),

	"Odgovornost"	=> "Administrator nije odgovoran za bilo kakvu stetu.
Odgovornost je iskljucena, osim za stete uzrokovane namjerom ili grubom nepaznjom i sve stete za zivot i zdravlje.
U tom smislu, izricito je naglasio da racunalne igre mogu predstavljati znacajan rizik za zdravlje.
stete nisu u smislu od strane administratora.",

	"Izmjene Uvjeta"	=> "Administrator zadrzava pravo izmjene ovih uvjeta u bilo koje vrijeme ili produljenje.
Osim toga promijene  ce biti objavljene najkasnije tjedan dana prije stupanja na forumu.",
);

//Facebook Connect

$LNG['fb_perm']                = 'Pristup zabranjen. %s mozete se prijaviti sa svojim Facebook korisnickim racunom. \n mozete se prijaviti bez Facebook racuna!';

//NEWS

$LNG['news_overview']			= "Novosti";
$LNG['news_from']				= "Na %s po %s";
$LNG['news_does_not_exist']	= "Nema novosti!";

//Impressum

$LNG['disclamer']				= "Disclaimer";
$LNG['disclamer_name']			= "Name";
$LNG['disclamer_adress']		= "Address";
$LNG['disclamer_tel']			= "Phone:";
$LNG['disclamer_email']		= "E-mail Address";

// Translated into Croatian by Seiteki . All rights reversed (C) 2010

?>