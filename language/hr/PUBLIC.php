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
$LNG['password_lenght_error']		= 'Lozinka treba imati barem 4 znakova!<br>';
$LNG['user_field_no_alphanumeric']	= 'Molimo unesite korisnicko ime samo alfanumerickim znakovima!<br>';
$LNG['user_field_no_space']		= 'Polje za korisnicko ime nemože ostati prazno!<br>';
$LNG['planet_field_no_alphanumeric']	= 'Unesite ime planeti samo alfanumerickim znakovima!<br>';
$LNG['planet_field_no_space']		= 'Polje za ime planete nemože ostati prazno!<br>';
$LNG['terms_and_conditions']		= 'Morate prihvatiti <a href="index.php?page=agb">Uslovi i Odredbe</a> i <a href="index.php?page=rules>Pravila</a> hvala!<br>';
$LNG['user_already_exists']		= 'Korisnicko ime je vec zauzeto!<br>';
$LNG['mail_already_exists']		= 'E-mail adresa je vec u uporabi!<br>';
$LNG['wrong_captcha']				= 'Pogresan sigurnosni kod!<br>';
$LNG['different_passwords']		= 'Upisali ste dvije razlicite lozinke!<br>';
$LNG['different_mails']			= 'Upisali ste dvije razlicite adrese!<br>';
$LNG['welcome_message_from']		= 'Administrator';
$LNG['welcome_message_sender']		= 'Administrator';
$LNG['welcome_message_subject']	= 'Dobrodosli';
$LNG['welcome_message_content']	= 'Dobrodosli na %s!<br>Prvo izgradite solarnu elektranu,jer energija je potrebna za kasniju proizvodnju sirovina. Kako ga izgraditi,lijevi klik u izborniku na "zgrade".Zatim izgraditi cetvrtu zgradu od vrha.Sada imate energije, možete poceti graditi rudnike. Vratite se na meni izgradnju i izgradite rudnik metala,pa opet rudnik kristala. Da bi mogli graditi brodove trebate imati prvo izgradeno brodogradilista.sto je potrebno za izgradnju to cete naci u lijevom izborniku tehnologije.Sybaron zim želi vam puno zabave u istraživanju svemira!';
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
$LNG['rules_overview']				= "Rules";
$LNG['rules']						= array(
	"Accounts"					=> "Each player is allowed to control a single account. Each account is entitled to be played by a single player at a time, account sitting being the only exception.
Account sitting entitles a given player to have his account watched over under the following regulations:

- Am admin must be informed before the sitting takes place, by opening a ticket.
- No Fleet movements are allowed while the account is being sat unless an attack that may raid or crash the account is incoming, in which case you may save your fleet(s) by deploying or transporting to a planet or to a moon owned by the account being sat. You may not ninja an incoming attack in cases where you would need to move a fleet for it.
- An account may only be sat for a maximum period of 48 continuous hours (admin permission needs to be obtained in cases where a time extension is needed).
The sitter may, on the account being sat and while the sitting period lasts:

- Spend Resources on buildings or researches.
- Fleetsave any ship that imminently endangered by an incoming attacking fleet, only with a deployment or transport mission to one of the accounts own planets.
- Place an account into vacation mode.

The sitter may not:

- Transport resources, neither between planets/moons of the account being sat, nor to any other planet/moon.
- Spend Resources on defensive structures or ships.
- Sit an account if he sat another one within the previous 7 days.
- Sit an account that was sat within the previous 7 days.
- Remove an account from vacation mode.",


	"Pushing"					=> "It is not allowed for any account to obtain unfair profit out of a lower ranked account in a matter of resources.
This includes but is not limited to:

- Resources sent from a lower ranked account to a higher ranked one with nothing tangible in return.
- A player crashing his fleet into a higher ranked one for the higher ranked one to keep the Debris Field, and thus profiting from it.
- Loans that are not returned within 48 hours.
- Trades in which the higher ranked player does not return the resources within 48 hours.
- Players answering to a higher ranked player extortion by paying resources.
- Trades that mean an unfair profit to the higher ranked player by falling outside the following range of ratios:

3:2:1 Where each unit of deuterium is worth 2 units of crystal or 3 units of metal.

2:1:1 Where each unit of deuterium is worth 1 unit of crystal or 2 units of metal.
",

	"Bashing"					=> "It is not allowed to attack any given planet or moon owned by a player over 6 times in a single 24 hours period.

Bashing is only allowed when your Alliance is at war with another Alliance. The war must be announced in the forum and both leaders must agree to the terms.",

	
	"Bugusing"					=> "Using a bug for anyones profit intentionally or not reporting a bug intentionally is strictly forbidden.",


	"Real life threats"	=> "Implying that you are going to locate and harm another player, is forbidden.",

	"Spam"			=> "Any situation intended to saturate a players interface through any method is forbidden. This includes but is not limited to:

- Personal Messages spam
- Probes spam
- Overview spam",

  "Wars"                    => "After the Leaders of the alliances both agree to the war, it is officially on. And will continue until one of the alliances cancels it. To officially cancel the war they need to cancel the war pact from in-game, and announce it in the thread they started initially.
While the war is on, the bashing rule between the alliances involved does not count. Meaning any members belonging to the alliances in said war can be attack an infinite amount of times with out punishment.
If either alliance gives up and cancels the war, the bashing rule will take effect again, and any members breaking it after the war has ended with be punished with a 1 day ban, More if the degree of attack is extremely high.

If the opposing alliance has a fleet in flight. And the war is canceled before they arrive. They will NOT be punished for that attack. But any fleet sent after the war cancellation will count toward the bashing rule.


For New Wars one of the leaders need to create a new thread in the war/diplomacy section.
There they can set any specific rules or terms, they want for the war. Any rules set in place, and are agreed to by the opposing alliance must be fallowed, and must not contradict any rules set here.",                          

);

$LNG['rules_info1']				= "";
$LNG['rules_info2']				= "To complement this, the <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">T&C</a> are considered and followed!</font>";


//AGB

$LNG['agb_overview']				= "Terms and Conditions";
$LNG['agb']						= array(
	"Service content"				=> array( 
		"The recognition of the Policies are necessary prerequisite to be able to participate in the game.
They apply to all offers on the part of operators, including the Forum and other Game-content.",
		
		"The service is free.
Thus there are no claims to the availability, delivery, functionality, or damages.
Furthermore, the player has no claims to restore, account should have been adversely treated.",
	),

	"Membership"				=> array(
		"By logging on in the game and / or the Forum membership will start in the game.",
		
		"Which begins with the declaration Membership may be terminated on the part of the member by deleting the account or by letter of an administrator.
The erasure of data for technical reasons can not be made immediately.",
		
		"Terminated by the operator No user has any right to participate in tenders of the operator.
The operator reserves the right to delete accounts.
The decision to delete an account is solely and exclusively to the operator and administrator and operator.
Any legal claim to a membership is excluded.",
		
		"All rights remain with the operator.",
	),

	"Contents / Responsibility"	=> "For the content of the various game-communications capabilities, users are responsible. Pornographic, racist, abusive or otherwise violates applicable law contrary content outside the responsibility of the operator.
Violations can lead to immediate cancellation or revocation.",

	"Prohibited procedures"			=> array(
		"The user is not authorized to use hardware / software or other substances or mechanisms associated with the web site, which can interfere with the function and the game.
The user may not continue to take any action that may cause undue stress or increased technical capacity.
The user is not allowed to manipulate content generated by the operator or interfere in any way with the game.",
		
		"Any type of bot, script or other automated features are prohibited.
The game can be played only in the browser. Even its functions should not be used to gain an advantage in the game.
Thus, no advertising shall be blocked. The decision of when a software is beneficial for the players, lies solely with the operator / with the administrators / operators.",
		
	
	),

	"Restrictions on Use"		=> array(
		"A player may only use each one account per universe, so-called \ Multinationals \ are not allowed and will be deleted without warning can / will be locked.
The decision of when there is a \ multi \ lies solely with the operator / administrators / operators.",
		
		"Particulars shall be governed by the rules.",
		
		"Lockouts can permanently at the discretion of the operator or temporary.
Similarly, closures may extend to one or all play areas.
The decision will be suspended when and how long a player who is only with the operator / with the administrators / operators.",
	),

	"Privacy"					=> array(
		"The operator reserves the right to store data of the players in order to monitor compliance with the rules, terms of use and applicable law.
Filed all required and submitted by the player or his / her account information.
These (IPs are associated with periods of use and usage, the email address given during registration and other data.
In the forum, made there in the profile are stored.",
		
		"This data will be released under certain circumstances to carry out statutory duties to clerks and other authorized persons.
Furthermore, data can (if need be issued) under certain circumstances to third parties.",
		
		"The user can object to the storage of personal data at any time. An appeal is a termination right.",
	),

	"Rights of the operator of the Accounts"	=> array(
		"All accounts and all the virtual objects remain in the possession and ownership of the operator.
The player does not obtain ownership and other rights to any account or parts.
All rights remain with the operator.
A transfer of exploitation or other rights to the user will take place at any time.",
		
		"Unauthorized sale, use, copy, distribute, reproduce or otherwise violate the rights (eg on account) of the operator will be reported to authorities and prosecuted.
Expressly permitted is the free, permanent transfer of the account and the actions of their own resources in the universe, unless and except as permitted by the rules.",
	),

	"Liability"	=> "The operator of each universe is not liable for any damages.
A liability is excluded except for damage caused by intent or gross negligence and all damage to life and health.
In this regard, is expressly pointed out that computer games can pose significant health risks.
Damages are not within the meaning of the operator.",

	"Changes to Terms"	=> "The operator reserves the right to modify these terms at any time or extend.
A change or addition will be published at least one week before the entry in Forum.",
);

//Facebook Connect

$LNG['fb_perm']                = 'Pristup zabranjen. %s možete se prijaviti sa svojim Facebook korisnickim racunom. \n možete se prijaviti bez Facebook racuna!';

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