<?php

//general
$LNG['index']				= 'Index';
$LNG['register']			= 'Registrirajte se';
$LNG['forum']				= 'Forum';
$LNG['send']				= 'Potrdi';
$LNG['menu_index']			= 'Domov'; 	 
$LNG['menu_news']			= 'Novice';	 
$LNG['menu_rules']			= 'Pravila'; 
$LNG['menu_agb']			= 'Pogoji uporabe'; 
$LNG['menu_pranger']		= 'Bannan';
$LNG['menu_top100']			= 'Dvorana slavnih';	 
$LNG['menu_disclamer']		= 'Kontakt';	  
$LNG['uni_closed']			= '(odjavlen)';
	 
/* ------------------------------------------------------------------------------------------ */

//index.php
//case lostpassword
$LNG['lost_empty']			= 'Izpolniti morate vsa polja!';
$LNG['lost_not_exists']		= 'Ni mogoče najti uporabnika s tem e-poštnim naslovom!';
$LNG['lost_mail_title']		= 'Novo geslo';
$LNG['mail_sended']				= 'Vaše geslo je bilo uspešno poslano!';
$LNG['server_infos']			= array(
	"Strateška vesoljska simulacija v realnem času.",
	"Igrajte skupaj z več sto uporabniki.",
	"Vse kar potrebujete za igro je brskalnik.",
	"Registracija je brezplačna",
);

//case default
$LNG['login_error_1']			= 'Napačno uporabniško ime/geslo!';
$LNG['login_error_2']			= 'Nekdo se je vpisal z drugega računalnika v vaš račun!';
$LNG['login_error_3']			= 'Vaša seja je potekla!';
$LNG['screenshots']				= 'Slike';
$LNG['universe']				= 'Vesolje';
$LNG['chose_a_uni']				= 'Izberite vesolje';
$LNG['universe']				= 'Vesolje';
$LNG['chose_a_uni']				= 'Izberite vesolje';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title']			= 'Pozabljeno geslo';

//index_body.tpl
$LNG['user']					= 'Uporabnik';
$LNG['pass']					= 'Geslo';
$LNG['remember_pass']			= 'Zapomni si me';
$LNG['lostpassword']			= 'Pozabljeno geslo?';
$LNG['welcome_to']				= 'Dobrodošli v';
$LNG['server_description']		= '<strong>%s</strong> je strateška vesoljska simulacija s tisoči igralcev po vsem svetu, ki tekmujejo med seboj simultano. Vse kar potrebuješ za igro je brskalnik.';
$LNG['server_register']			= 'Registrirajte se zdaj!';
$LNG['server_message']			= 'Prijavite se sedaj in izkusite nov svet';
$LNG['login']					= 'Prijava';
$LNG['disclamer']				= 'Kontakt';
$LNG['login_info']				= 'Z prijavo potrjujem, da sem prebral/a <a href="index.php?page=rules">Pravila</a> in <a href="index.php?page=agb">Pogoje uporabe</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed']				= 'Registracija zaprta!';
$LNG['register_at']					= 'Registriran ob ';
$LNG['reg_mail_message_pass']		= 'Še en korak, da aktivirate svoje uporabniško ime';
$LNG['reg_mail_reg_done']			= 'Dobrodošli v %s!';
$LNG['invalid_mail_adress']			= 'Neveljaven e-poštni naslov!';
$LNG['empty_user_field']			= 'Izpolniti morate vsa polja!';
$LNG['password_lenght_error']		= 'Geslo mora vsebovati vsaj 4 znake!';
$LNG['user_field_no_alphanumeric']	= 'Prosimo, uporabniško ime lahko vsebuje samo alfanumerične znake!';
$LNG['user_field_no_space']			= 'Prosimo, vnesite uporabniško ime brez presledkov!';
$LNG['planet_field_no']				= 'Vnesti morate ime planeta!';
$LNG['planet_field_no_alphanumeric']= 'Prosimo, ime planeta lahko vsebuje samo alfanumerične znake!';
$LNG['planet_field_no_space']		= 'Prosimo, vnesite ime planeta brez presledkov!';
$LNG['terms_and_conditions']		= 'Morate sprejeti <a href="index.php?page=agb">pogoje uporabe</a> in <a href="index.php?page=rules">pravila</a> akzeptieren!';
$LNG['user_already_exists']			= 'Uporabnik že obstaja!';
$LNG['mail_already_exists']			= 'E-poštni naslov je že v uporabi!';
$LNG['wrong_captcha']				= 'Varnostna koda je nepravilna!';
$LNG['different_passwords']			= 'Vnesli ste dve različni gesli!';
$LNG['different_mails']				= 'Vnesli ste dva različna e-poštna naslova!';
$LNG['welcome_message_from']		= 'Administrator';
$LNG['welcome_message_sender']		= 'Administrator';
$LNG['welcome_message_subject']		= 'Dobrodošli';
$LNG['welcome_message_content']		= 'Welcome to %s!<br>First build a solar power,because energy is needed for the subsequent production of raw materials. To build it, left click in the menu on "building". Then build the 4th Building from the top. There you have energy, you can begin to build mines. Go back to the menu on the building and build a metal mine, then again a crystal mine. In order to be able to build ships you need to have first built a shipyard. What is needed for that you find in the left menu technology. The team wishes you much fun exploring the universe!';
$LNG['newpass_smtp_email_error']	= '<br><br>Prišlo je do napake. Vaše geslo je: ';
$LNG['reg_completed']				= 'Zahvaljujemo se vam za registracijo! Prejeli boste e-pošto s povezavo za aktiviranje.';
$LNG['planet_already_exists']		= 'Koordinati planeta so že zasedeni! <br>';

//registry_form.tpl
$LNG['server_message_reg']			= 'Registrirajte se zdaj in postanite del';
$LNG['register_at_reg']				= 'Registriran ob';
$LNG['uni_reg']						= 'Vesolje';
$LNG['user_reg']					= 'Uporabniško ime';
$LNG['pass_reg']					= 'Geslo';
$LNG['pass2_reg']					= 'Potrdite geslo';
$LNG['email_reg']					= 'E-poštni naslov';
$LNG['email2_reg']					= 'Potrdite e-poštni naslov';
$LNG['planet_reg']					= 'Ime glavnega planeta';
$LNG['ref_reg']						= 'Povabi prijatelje';
$LNG['lang_reg']					= 'Jezik';
$LNG['register_now']				= 'Registriraj!';
$LNG['captcha_reg']					= 'Varnostno vprašanje';
$LNG['accept_terms_and_conditions']	= 'Sprejmem <a href="index.php?page=rules">Pravila</a> in <a href="index.php?page=agb">Pogoje uporabe</a>';
$LNG['captcha_reload']				= 'Osveži';
$LNG['captcha_help']				= 'Pomoč';
$LNG['captcha_get_image']			= 'Nalaganje slik-CAPTCHA';
$LNG['captcha_reload']				= 'Novo CAPTCHA';
$LNG['captcha_get_audio']			= 'Nalaganje zvoka-CAPTCHA';
$LNG['user_active']                	= 'Uporabnik %s se je aktiviral!';

//Rules
$LNG['rules_overview']				= "Pravila";
$LNG['rules']						= array(
	"Računi"					=> "Lastnik računa je vedno oseba, ki ima v lasti email naslov, ki je naveden na samem računu. Vsak račun je upravičen, da je lahko igran s strani ene osebe, čuvanje računa je lahko le kot izjema. Zamenjave računov v istem vesolju morajo biti storjene z asistenco GameOperatorja. 

 Podporo lahko contaktirate na sistemu podpornih kartic
 Po zamenjavi lastnika računa mora miniti mesec dni, preden lahko račun dobi novega lastnika. Po prejetju računa naj bi lastnik spremenil email v prvih 12 urah po zamenjavi.",

	"Multi Račun"					=> "Vsak igralec lahko igra en račun v vesolju.
 V primerih, ko sta dva ali več računov občasno ali permanentno igrani na istem omrežju (npr. šola, univerza, internetni kafe...) je zelo priporočeno, da o tem obvestite GameOperaterja. Kontaktirate ga lahko na preko podpore. 
 V teh primerih med računi ne sme biti kontakta s floto, ko so povezani na istem omrežju. Vsa podobna dejanja so pri tem prav tako prepovedana.",

	"Čuvanje računa"					=> "Čuvanje računa omogoča igralcu, da je njegov račun pažen. 
 GameOperator mora biti obveščen predno se čuvanje začne preko sistema podpore. 
 Račun je lahko čuvan največ 12 ur. 

 Kot konec čuvanja se bo štelo vpis lastnika. 
 Premiki flot so med čuvanjem prepovedani, edina izjema so prihajajoči napadi, ki lahko oropajo ali uničijo račun. V tem primeru lahko rešite floto s premikom ali transportom na planet ali luno, ki je v lasti čuvanega računa. Oseba, ki čuva račun, lahko porabi surovine za zgradbe ali raziskave, ne pa obrambo ali ladje. 
 Čuvanje računa je dovoljeno, le če v predhodnih 7 dneh račun ni bil čuvan.",

	"Bashing"					=> "Ni dovoljeno napadanje kateregakoli planeta ali lune, v lasti igralca, več kot 6 krat v roku 24 ur. 
 To pravilo velja tudi pri misiji uničevanja lune. 
 V posebno oblikovanih in na forumu objavljenimi vesolji je lahko pravilo bashinga preoblikovano ali opuščeno. 
 Napadanje s sondami ali medplanetarnimi raketami se ne šteje k bashing pravilu. Bashing je dovoljen le v primeru, ko je vasa aliansa v vojni z drugo alianso. Vojna mora biti objavljena v pravilni sekciji na forumu in mora biti v skladu z vsemi predpisanimi pravili foruma.",

	"Pushing"					=> "Proti pravilom je prejemanje nepravičnega profita v surovinah od nižje rangiranih igralcev. 
 Pushing so surovine poslane iz nižje rangiranega igralca višje rangiranemu brez protivrednostnega vračila in uničenje flote na višje rangiranemu igralcu, pri čemer on obdrži surovine. To sta le dva izmed mnogih primerov. Vsako trgovanje mora biti končano v roku 48 ur.
 Za vse izjemnosti (kot so ACS delitev, lov na glave, pomoč pri recikliranju...) mora biti o tem GameOperator obveščen preko sistema podpornih kartic",

	"Uporaba bugov / skript"					=> "Uporaba bug-a za lasten profit ali ne prijavljanje le-tega je strogo prepovedano. Uporaba programa kot vmesnika med igralcem in igro je strogo prepovedano. Vsaka druga oblika avtomatsko generiranih informacij, ki omogočajo prednosti igralcem in imajo dvomljive namene so prav tako prepovedane.",

	"Grožnje v resničnem življenju"					=> "Grožnje, da boste drugga igralca, člana ekipe, predstavnika GameForga ali katerikoli drugo osebo, ki je povezana s samo igro, izsledili in povzročili škodo so strogo prepovedane!",

	"Žalitve in spam"					=> "Kakršnakoli oblika žaljenja ali spamanja ni dovoljena.",

	"Jezik"					=> "Izdajalec igre si pridržuje pravico, da izključi igralce, ki niso sposobni govoriti matični jezik igre (v igri, na forumu ali na uradnih irc kanalih).",

	"Kršitve pravil"					=> "Vsako kršenje pravil bo kaznovano z opozorili, ki lahko vodijo do permenentnega zaklepa računa. Odgovoren GameOperator določi čas in trajanje kazni in je ob tem tudi kontaktna oseba za bane.",

	"Pogoji uporabe"					=> "Pogoji uporabe so povezani s temi pravili in morajo biti prav tako upoštevani.",

	"Sprememba pravil"					=> "Administrator ima pravico do uporabe izjem teh pravil. V posebnih primerih (npr. ob prireditvah) je mogoče spremeniti pravila igre ali jih začasno prenehati izvajati. Uporabniki bodo posebej obveščeni, ko in če bo do tega prišlo.",

);

$LNG['rules_info1']				= "Ostala obvestila so na <a href=\"%s\" target=\"_blank\">forumu</a> in na prvi strani igre.";
$LNG['rules_info2']				= "Kot dopolnilo k temu, je potrebno še upoštevati <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">pogoje uporabe</a>!</font>";


//AGB

$LNG['agb_overview']				= "Pogoji uporabe";
$LNG['agb']						= array(
	"Vsebina storitev"				=> array( 
		"Pogoji uporabe so nujni za sodelovanje v igri. Veljajo za vse ponudbe s strani operaterjev, vključno z forumi in ostalimi vsebinami povezanimi z igro.",
		
		"Storitev je brezplačna.
Tako, da ni nobenih zahtevkov za razpoložljivost, dostavo, funkcionalnost, ali škodo.
Igralcu ni potrebno denarno plačati za prijavo v strežnik in obnovitev svojega računa.",
	),

	"Članstvo"				=> array(
		"Z prijavo v igro ali forum boste avtomatsko postali član.",
		
		"Članstvo se lahko prekine s izbrisom računa z igre in foruma, ki lahko stori vsak član za sebe ali pa naredi administrator igre.
Izbris podatkov zaradi tehničnih razlogov ni mogoč takoj. Vsi podatki o uporabnikih se izbrišejo v roku sedmih dni.",
		
		"Uporabnik, ki je bil izključen iz članstva igre nima nobene pravice sodelovati ali pa ugovarjati operaterju.
Operater ima pravico do izbrisa kateregakoli računa.
Pravica do izbrisa računa imajo samo operaterji in administratorji same  igre in noben drug uporabnik.
Članstvo je prekinjeno z sklepom operaterja in administratorja.",
		
		"Vse pravice so zadržane pri operaterju.",
	),

	" Vsebina / Odgovornost"	=> "Za vsebine različnih komunikacijskih orodij igre so odgovorni uporabniki. Pornografija, rasistična in ostala vsebina, ki ne spada na forum ni dovoljena in operater ni odgovoren za njo.
Kršitve lahko vodijo k takojšnjemu bannu in izbrisu uporabnika.",

	"Prepovedani postopki"			=> array(
		"Uporabniku ni dovoljeno uporabljati kakršnih kolik zlonamernih programov in strojne opreme na internetni same igre, ki bi pomagala pri igri uporabnika ali pa za .
Uporabnik ne sme z različnimi pripomočki spravljati strežnik pod stres, ki presega tehnično zmogljivost strežnika.
Uporabniku ni dovoljeno manipuliranje vsebin, ki jih je ustvaril operater ali pa posegati v način delovanja igre.",
		
		"Kakršni koli boti, skripte, avtomatizirani programi in podobno so prepovedani .
Igra se lahko igra samo v brskalniku. Funkcije brskalnika se ne smejo uporabljati kot zlonamerni program za pridobivanje prednosti v igri.
Blokiranje oglasnih vsebin ne bo blokirano. Odločitev, če je vsebina koristna za igralce in ostale uporabnike je v rokah moderatorjev, operatorjev in administratorjev.",
		
	
	),

	"Omejitve uporabe"		=> array(
	"Vsak igralec lahko igra en račun v vesolju.
 V primerih, ko sta dva ali več računov občasno ali permanentno igrani na istem omrežju (npr. šola, univerza, internetni kafe...) je zelo priporočeno, da o tem obvestite Operaterja. Kontaktirate ga lahko  preko podpore. 
 V teh primerih med računi ne sme biti kontakta s floto, ko so povezani na istem omrežju. Vsa podobna dejanja so pri tem prav tako prepovedana. Če bo operater ugotovil primer multiračuna, se bodo ti računi zaklenili ali pa izbrisali.",
		
		"Kršitelji bodo kaznovani po pravilih.",
		
		"Operator lahko račune zaklene za kratek čas, ali pa za vedno, ter jih lahko izbriše.
Podobno se lahko tudi zgodi vsem igralcem v kateremkoli vesolju igre.
Kako dolgo bo uporabniški račun zaklenjen, in/ali izbrisan je odločitev moderatorjev, operatorjev in administratorjev.",
	),

	"Varstvo podatkov"					=> array(
		"Operater ima pravico do shranjevanja podatkov igralcev, da lahko nadzoruje izpolnjevanje in upoštevanje pravil in pogoje uporabe in z zakonom.
Vsa okenca pri registraciji novih uporabnikov morajo biti obvezno izpolnjena.
IP naslovi so povezani z obdobji uporabe, kakor tudi e-poštni naslovi, ki so bili vneseni med registracijo uporabnika. Spreminjanje e-poštnega naslova ali katerih koli drugig podatkov se bo preverjalo s naslovom IP.
V forumu igre so vaši podatki tudi shranjeni.",
		
		"Podatki bodo pod določenimi pogoji na voljo pooblaščenim osebam, da bodo lahko izpolnjevali svoje naloge..
Podatki so lahko (samo pod določenimi pogoji) na voljo pooblaščenim osebam.",
		
		"Uporabnik lahko zahteva uničenje njegovih podatkov kadarkoli, saj to je pravica vsakega uporabnika.",
	),

	"Pravice operaterja "	=> array(
		"Vsi računi in vitalni podatki so v lasti operaterja.
Igralec ne pridobi nobenega lastništva ali dela uporabniškega računa..
Vse pravice so pridržane operaterju.
Prenos ali odvzem pravic uporabnikom lahko naredimo kadarkoli.",
		
		"Nepooblaščeno kopiranje, izkoriščanje, prodaja in spreminjanje računov in podatkov, ki jih bo izvedil operater so prepovedana. Ob sumu na ta dejanja se lahko operaterja prijavi administratorju in sledila bo preiskava, ter kazen operaterju.
Dovoljen je prenos računa, in surovin v kateremkoli vesolju razen, če je to prepovedano v pravilih igre. Trgovanje z računi je tudi mogoče",
	),

	"Odgovornost operaterja"	=> "Operater vsakega vesolja ni odgovoren za nobeno škodo.
Odgovornost je izključna, razen za škodo, ki jo namenoma stori ali iz malomarnosti za vaše živlenje in zdravje.
V tem poudarku pomeni da lahko računalniške igre pomenijo veliko tveganje za.
Operater vam ne bo pošiljal odškodnine, če si boste z igro poškodovali katerikoli del telesa..",

	"Sprememba pogojev"	=> "Administrator ima pravico do uporabe izjem teh pogojev. V posebnih primerih (npr. ob prireditvah) je mogoče spremeniti pogoje uporabe  ali jih začasno prenehati izvajati. Uporabniki bodo posebej obveščeni, ko in če bo do tega prišlo.",

);

//Facebook Connect

$LNG['fb_perm']                	= 'Dostop prepovedan. %s potrebuje pravice, da se lahko prijavite z facebook računom.\n Lahko pa se prijavite v račun brez facebooka!';

//NEWS

$LNG['news_overview']			= "Novice";
$LNG['news_from']				= "On %s by %s";
$LNG['news_does_not_exist']		= "Ni novic na voljo!";

//Impressum

$LNG['disclamer']				= "<br>Izjava o omejitvi odgovornosti";
$LNG['disclamer_name']			= "Ime";
$LNG['disclamer_adress']		= "Naslov";
$LNG['disclamer_tel']			= "Telefon:";
$LNG['disclamer_email']			= "E-pošta";

// Translated into English by Languar . All rights reversed (C) 2010

?>