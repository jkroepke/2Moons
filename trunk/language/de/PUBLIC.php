<?php

//general
$LNG['index']				= 'Index';
$LNG['register']			= 'Registrieren';
$LNG['forum']				= 'Forum';
$LNG['send']				= 'Absenden';
$LNG['menu_index']			= 'IndeX';
$LNG['menu_news']			= 'News';
$LNG['menu_rules']			= 'Regeln';
$LNG['menu_pranger']		= 'Pranger';
$LNG['menu_top100']			= 'Hall of Fame';
$LNG['menu_disclamer']		= 'Impressum';
$LNG['uni_closed']			= ' (closed)';

//index.php
//case lostpassword

$LNG['lost_empty']			= 'Du musst alle Felder ausfüllen!';
$LNG['lost_not_exists']		= 'Es konnte kein User in Verbindung mit dieser Mail Adresse gefunden werden!';
$LNG['lost_mail_title']		= 'Neues Passwort';
$LNG['mail_sended']			= 'Dein Passwort wurde an %s erfolgreich gesendet!';

//case default

$LNG['server_infos']			= array(
	"Ein Weltraum-Strategiespiel in Echtzeit.",
	"Spiele zusammen mit hunderten Usern.",
	"Kein Download, es wird nur ein Standardbrowser benötigt.",
	"Kostenlose Registrierung",
);

$LNG['login_error_1']		= 'Falscher Benutzername/Passwort!';
$LNG['login_error_2']		= 'Jemand hat sich von einem anderem PC in deinem Account eingeloggt!';
$LNG['login_error_3']		= 'Deine Session ist abgelaufen!';
$LNG['login_error_4']		= 'Es gab einen Fehler bei der externen Autorisierung, bitte versuche Sie es später noch einmal!';
$LNG['screenshots']			= 'Screenshots';
$LNG['universe']			= 'Universum';
$LNG['chose_a_uni']			= 'Wähle ein Universum';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title']			= 'Passwort wiederherstellen';

//index_body.tpl
$LNG['user']					= 'User';
$LNG['pass']					= 'Passwort';
$LNG['remember_pass']			= 'Auto-Login';
$LNG['lostpassword']			= 'Passwort vergessen?';
$LNG['welcome_to']				= 'Willkommen bei';
$LNG['server_description']		= '<strong>%s</strong> ist ein <strong>Weltraum-Strategiespiel mit hunderten Spielern</strong> die erdumgreifend <strong>gleichzeitig</strong> versuchen der/die Beste zu werden. Alles was ihr zum spielen braucht ist ein Standartwebbrowser.';
$LNG['server_register']			= 'Registrieren Sie sich Jetzt!';
$LNG['server_message']			= 'Registriere dich jetzt und erlebe eine neue, spannende Welt ';
$LNG['login']					= 'Login';
$LNG['disclamer']				= 'Impressum';
$LNG['login_info']				= 'Mit dem Login akzeptiere ich die <a href="index.php?page=rules">Regeln</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed']				= 'Registration geschlossen!';
$LNG['register_at']					= 'Registriert bei ';
$LNG['reg_mail_message_pass']		= 'Noch ein Schritt zur Aktivierung Ihres Usernamen';
$LNG['reg_mail_reg_done']			= 'Willkommen bei %s!';
$LNG['invalid_mail_adress']			= 'Ungültige E-mail Adresse!';
$LNG['empty_user_field']			= 'Sie müssen einen Usernamen eingeben!';
$LNG['password_lenght_error']		= 'Das Passwort muss mindestens 6 Zeichen lang sein!';
$LNG['user_field_specialchar']		= 'Im Username sind nur Zahlen, Buchstaben, Leerzeichen, _, -, . erlaubt!';
$LNG['planet_field_no']				= 'Sie müssen einen Planetennamen eingeben!';
$LNG['planet_field_specialchar']	= 'Im Planetennamen sind nur Zahlen, Buchstaben, Leerzeichen, _, -, . erlaubt!';
$LNG['terms_and_conditions']		= 'Sie müssen die Regeln akzeptieren!';
$LNG['user_already_exists']			= 'Der Username ist bereits vergeben!';
$LNG['mail_already_exists']			= 'Die E-mail Adresse ist bereits in Benutzung!';
$LNG['wrong_captcha']				= 'Sicherheitscode falsch!';
$LNG['different_passwords']			= 'Sie haben 2 unterschiedliche Passwörter eingegeben!';
$LNG['different_mails']				= 'Sie haben 2 unterschiedliche E-Mail Adressen angegeben!';
$LNG['welcome_message_from']		= 'Administrator';
$LNG['welcome_message_sender']		= 'Administrator';
$LNG['welcome_message_subject']		= 'Willkommen';
$LNG['welcome_message_content']		= 'Willkommen beim %s! Baue zuerst ein Solarkraftwerk, denn Energie wird für die spätere Rohstoffproduktion benötigt. Um diese zu bauen, klicke links im Menu auf "Gebäude". Danach baue das 4. Gebäude von oben. Da du nun Energie hast, kannst du anfangen Minen zu bauen. Gehe dazu wieder im Menü auf Gebäude und baue eine Metallmine, danach wieder eine Kristallmine. Um Schiffe bauen zu können musst du zuerst eine Raumschiffswerft gebaut haben. Was dafür benötigt wird findest du links im Menüpunkt Technologie. Das Team wünscht dir viel Spaß beim Erkunden des Universums!';
$LNG['reg_completed']				= 'Danke für ihre Anmeldung! Sie erhalten eine E-Mail mit einem aktivierungs Link.';
$LNG['planet_already_exists']		= 'Die Planetenposition ist bereits belegt!';

//registry_form.tpl
$LNG['server_message_reg']			= 'Registriere dich jetzt und werde ein Teil von';
$LNG['register_at_reg']				= 'Registriert bei';
$LNG['uni_reg']						= 'Universum';
$LNG['user_reg']					= 'User';
$LNG['pass_reg']					= 'Passwort';
$LNG['pass2_reg']					= 'Passwort wiederhohlen';
$LNG['email_reg']					= 'E-Mail Adresse';
$LNG['email2_reg']					= 'E-Mail Adresse wiederhohlen';
$LNG['planet_reg']					= 'Name des Hauptplaneten';
$LNG['ref_reg']						= 'Geworben von';
$LNG['lang_reg']					= 'Sprache';
$LNG['register_now']				= 'Registrieren!';
$LNG['captcha_reg']					= 'Sicherheitsfrage';
$LNG['accept_terms_and_conditions']	= 'Ich bin mit den <a href="index.php?page=rules">Regeln</a> einverstanden.';
$LNG['captcha_help']				= 'Hilfe';
$LNG['captcha_get_image']			= 'Lade Bild-CAPTCHA';
$LNG['captcha_reload']				= 'Neues CAPTCHA';
$LNG['captcha_get_audio']			= 'Lade Sound-CAPTCHA';
$LNG['user_active']					= 'User %s wurde aktiviert!';

//Rules
$LNG['rules_overview']				= "Regelwerk";
$LNG['rules_info1']					= "Es wird aber im <a href=\"%s\" target=\"_blank\">Forum</a> und über die Startseite im Game darüber Informiert ...";


//NEWS

$LNG['news_overview']				= "News";
$LNG['news_from']					= "Am %s von %s";
$LNG['news_does_not_exist']			= "Keine News vorhanden!";

//Impressum

$LNG['disclamer']					= "Haftungsausschluss";
$LNG['disclamer_name']				= "Name:";
$LNG['disclamer_adress']			= "Adresse:";
$LNG['disclamer_tel']				= "Telefon Nr.:";
$LNG['disclamer_email']				= "E-Mail Adresse:";
?>