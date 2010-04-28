<?php

//general
$lang['index']				= 'Index';
$lang['register']			= 'Registrieren';
$lang['forum']				= 'Forum';
$lang['send']				= 'Absenden';
$lang['menu_index']			= 'IndeX'; 	 
$lang['menu_news']			= 'News';	 
$lang['menu_rules']			= 'Regeln'; 
$lang['menu_agb']			= 'AGB'; 
$lang['menu_pranger']		= 'Pranger';	 
$lang['menu_top100']		= 'Hall of Fame';	 
$lang['menu_disclamer']		= 'Impressum';	 
	 
/* ------------------------------------------------------------------------------------------ */

//index.php
//case lostpassword
$lang['mail_not_exist'] 		= 'Die angegebende E-Mail Adresse existiert nicht!';
$lang['mail_title']				= 'Neues Passwort';
$lang['mail_text']				= 'Dein neuen Passwort ist: ';
$lang['mail_sended']			= 'Dein Passwort wurde erfolgreich gesendet!';
$lang['mail_sended_fail']		= 'E-Mail konnte nicht gesendet werden.!';
$lang['server_infos']			= array(
	"Ein Weltraum-Strategiespiel in Echtzeit.",
	"Spiele zusammen mit hunderten Users.",
	"Kein Download, es wird nur ein Standardbrowser benötigt.",
	"Kostenlose Registrierung",
);

//case default
$lang['login_error']			= 'Falscher Benutzername/Passwort! <br><a href="index.php">Zurück</a>';
$lang['screenshots']			= 'Screenshots';
$lang['universe']				= 'Universum';
$lang['chose_a_uni']			= 'Wähle ein Universum';

/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$lang['lost_pass_title']		= 'Passwort wiederherstellen';
$lang['retrieve_pass']			= 'Wiederherstellen';
$lang['email']					= 'E-Mail Adresse';

//index_body.tpl
$lang['user']					= 'User';
$lang['pass']					= 'Passwort';
$lang['remember_pass']			= 'Auto-Login';
$lang['lostpassword']			= 'Passwort vergessen?';
$lang['welcome_to']				= 'Willkommen bei';
$lang['server_description']		= '<strong>%s</strong> ist ein <strong>Weltraum strategie Spiel mit hunderten Spielern</strong> die erdumgreifend <strong>gleichzeitig</strong> versuchen der/die Beste zu werden. Alles was ihr zum spielen braucht ist ein standart Webbrowser.';
$lang['server_register']		= 'Registrieren sie sich Jetzt!';
$lang['server_message']			= 'Registriere dich jetzt und erlebe eine neue spannende im Welt von';
$lang['login']					= 'Login';
$lang['disclamer']				= 'Impressum';
$lang['login_info']				= 'Mit dem Login akzeptiere ich die <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1\');" style="cursor:pointer;">Regeln</a> und die <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1\');" style="cursor:pointer;">AGB`s</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$lang['register_closed']			= 'Registration geschlossen!';
$lang['register_at']				= 'Registriert bei ';
$lang['reg_mail_message_pass']		= 'Noch ein Schritt zur Aktivierung Ihres Usernamen';
$lang['reg_mail_reg_done']			= 'Willkommen bei %s!';
$lang['invalid_mail_adress']		= 'Ungültige E-mail Adresse!<br>';
$lang['empty_user_field']			= 'Bitte alle Felder ausfüllen!<br>';
$lang['password_lenght_error']		= 'Das Passwort muss mindestens 4 Zeichen lang sein!<br>';
$lang['user_field_no_alphanumeric']	= 'Bitte beim Username nur alphanumerische Zeichen eingeben!<br>';
$lang['user_field_no_space']		= 'Bitte beim Username keine Leerzeichen eingeben!<br>';
$lang['terms_and_conditions']		= 'Sie müssen die <a href="index.php?page=agb">AGB</a> und <a href="index.php?page=rules>Regeln</a> aktzeptieren!<br>';
$lang['user_already_exists']		= 'Der Username ist bereits vergeben!<br>';
$lang['mail_already_exists']		= 'Die E-mail Adresse ist bereits in Benutzung!<br>';
$lang['wrong_captcha']				= 'Sicherheitscode falsch!<br>';
$lang['different_passwords']		= 'Sie haben 2 unterschiedliche Passwörter eingegeben!<br>';
$lang['different_mails']			= 'Sie haben 2 unterschiedliche E-Mail Adressen!<br>';
$lang['welcome_message_from']		= 'Administrator';
$lang['welcome_message_sender']		= 'Administrator';
$lang['welcome_message_subject']	= 'Wilkommenen';
$lang['welcome_message_content']	= 'Wilkommen beim %s!<br>Baue zuerst ein Solarkraftwerk, denn Energie wird für die spätere Rohstoffproduktion benötigt. Um diese zu bauen, klicke links im Menu auf "Gebäude". Danach baue das 4. Gebäude von oben. Da du nun Energie hast, kannst du anfangen Minen zu bauen. Gehe dazu wieder im Menü auf Gebäude und baue eine Metallmine, danach wieder eine Kristallmine. Um Schiffe bauen zu können musst du zuerst eine Raumschiffswerft gebaut haben. Was dafür benötigt wird findest du links im Menüpunkt Technologie. Das Team wünscht dir viel Spaß beim Erkunden des Universums!';
$lang['newpass_smtp_email_error']	= '<br><br>Ein Fehler trat auf. Dein Passwort ist: ';
$lang['reg_completed']				= 'Danke für ihre Anmeldung! Sie erhalten eine E-Mail mit einem aktivierungs Link.';

//registry_form.tpl
$lang['server_message_reg']			= 'Registriere dich jetzt und werde ein Teil von';
$lang['register_at_reg']			= 'Registriert bei';
$lang['uni_reg']					= 'Universum';
$lang['user_reg']					= 'User';
$lang['pass_reg']					= 'Passwort';
$lang['pass2_reg']					= 'Passwort wiederhohlen';
$lang['email_reg']					= 'E-mail Adresse';
$lang['email2_reg']					= 'E-mail Adresse wiederhohlen';
$lang['register_now']				= 'Registrieren!';
$lang['captcha_reg']				= 'Sicherheitsfrage';
$lang['accept_terms_and_conditions']= 'Bitte <a onclick="ajax(\'?page=rules&amp;\'+\'getajax=1\');" style="cursor:pointer;">Regeln</a> und <a onclick="ajax(\'?page=agb&amp;\'+\'getajax=1\');" style="cursor:pointer;">AGB`s</a> aktzeptieren';
$lang['captcha_reload']				= 'Neuladen';
$lang['captcha_help']				= 'Hilfe';
$lang['captcha_get_image']			= 'Lade Bild-CAPTCHA';
$lang['captcha_reload']				= 'Neues CAPTCHA';
$lang['captcha_get_audio']			= 'Lade Sound-CAPTCHA';

//registry_closed.tpl
$lang['info']						= 'Informationen';
$lang['reg_closed']					= 'Die Registrierung ist geschlossen';

//Rules
$lang['rules_overview']				= "Regelwerk";
$lang['rules']						= array(
	"Accounts"					=> "Der Besitzer eines Accounts ist immer der Inhaber der festen E-mail Adresse. Ein Account darf ausschließlich alleine gespielt werden. 
	Eine Ausnahme bildet nur das Sitten. Sollte es notwendig werden, dass der Account eines Anderen überwacht oder in den Urlaubsmodus gesetzt werden muss, 
	so ist der zuständige Operator vorher zu informieren und dessen Genehmigung einzuholen. Für kurzfristiges Sitten unter 12 Stunden reicht eine Meldung an den Operator. 
	Beim Sitten sind sämtliche Flottenbewegungen verboten, lediglich das Saven der Flotte auf Koordinaten des Gesitteten und das Verbauen der Rohstoffe auf dem Planeten, auf dem sie liegen, ist erlaubt. 
	Ein Account darf für höchstens 72h gesittet werden. Bei Ausnahmen muss die Erlaubniss eines Operators vorliegen.
	Die Weitergabe eines Accounts darf max. alle 3 Monate und ausschliesslich unentgeltlich erfolgen. 
	Ausnamhen beim Operator melden.",

	"Multiaccounts"				=> "Der Besitzer eines Accounts ist immer der Inhaber der festen E-mail Adresse. Ein Account darf ausschließlich alleine gespielt werden. 
	Eine Ausnahme bildet nur das Sitten. Sollte es notwendig werden, dass der Account eines Anderen überwacht oder in den Urlaubsmodus gesetzt werden muss, 
	so ist der zuständige Operator vorher zu informieren und dessen Genehmigung einzuholen. Für kurzfristiges Sitten unter 12 Stunden reicht eine Meldung an den Operator. 
	Beim Sitten sind sämtliche Flottenbewegungen verboten, lediglich das Saven der Flotte auf Koordinaten des Gesitteten und das Verbauen der Rohstoffe auf dem Planeten, auf dem sie liegen, ist erlaubt. 
	Ein Account darf für höchstens 72h gesittet werden. Bei Ausnahmen muss die Erlaubniss eines Operators vorliegen.
	Die Weitergabe eines Accounts darf max. alle 3 Monate und ausschliesslich unentgeltlich erfolgen. 
	Ausnamhen beim Operator melden.",

	"Pushen"					=> "Pushen ist grundsätzlich verboten. Als Pushing werden alle Ressourcen-Lieferungen ohne angemessene Gegenleistung von punktschwächeren Accounts an punktstärkere Accounts gesehen. 
	Ausnahmen müssen im Vorfeld vom Operator genehmigt werden. Eine fehlende Genehmigung kann eine Sperre wegen Pushens nach sich ziehen.
	Ein Handel muss innerhalb 24 Stunden abgeschlossen oder bei einem Operator angemeldet sein.",

	"Bashen"					=> "Mehr als 5 Angriffe innerhalb von 24 Stunden auf den gleichen Planeten zählen als Bashen und sind verboten - der Mond zählt als eigenständiger Planet. Angriffe mit Spiosonden oder Interplanetarraketen werden dabei nicht gezählt.
	Die Bashregel gilt ausschließlich für aktive Spieler. Befinden sich die Parteien im Krieg, so sind weitere Angriffe erlaubt. Der Krieg muss mindestens 24 Stunden vor weiteren Angriffen im Forum erklärt werden (im Thema der Ankündigung müssen beide Allianzen bzw. der Name des kriegserklärenden Einzelspielers in korrekter Schreibweise genannt werden). Eine Kriegserklärung kann ausschließlich an Allianzen gerichtet werden, wobei die Kriegserklärung durch eine Allianz oder eine Einzelperson erfolgen kann. 
	Eine Annahme des Krieges ist nicht erforderlich. Kriege, die offensichtlich nur der massiven Umgehung der Bashregel dienen, sind verboten. Dies zu beurteilen obliegt den zuständigen Moderatoren und Operatoren.",

	"Irak-Angriffe"             => "Es sind nur 3 Irak-Angriffe pro 24 Stunden erlaubt. Die Anzahl der Raketen pro Angriff ist unabhängig.",
	
	"Bugusing"					=> "Bugs und/oder Fehler in der Programmierung auszunutzen ist verboten. Erkannte Bugs sollten so schnell wie möglich per Post im Bugforum, IRC, Email oder ICQ gemeldet werden. Cheaten ist auch verboten.",

	"Sprache im Spiel"			=> "In allen entsprechenden Universen ist Deutsch/Englisch die offizielle Sprache im Spiel. Verstöße können mit einer Sperrung des Accounts geahndet werden. Fremdsprachliche Ingame- Nachrichten/ Allypages können unter Vorbehalt zu einer Sperrung des Accounts führen.",

	"Bedrohungen/Beleidigungen"	=> "RL Erpressungen und -Bedrohungen führen zum Ausschluß aus einem oder allen Titan Space Bereichen.
	Als Real-Life-Erpressungen und -bedrohungen werden Ingamenachrichten, Forenbeiträge, IRC-Dialoge in öffentlichen Channels und ICQ-Dialoge gewertet, die eindeutige Absichten signalisieren eine Person ausfindig zu machen und ihr oder einer nahestehenden dritten Person Schaden zuzufügen.",

	"Spam und Erotik"			=> "Spammen und Fremdwerbung ist verboten.Jeweilige Form von Erotik und Pornografischen Darstellungen ist verboten. Und wird mit einer Universums weiten und Lebenslangen Sperrung geandet!",

	"Die Regeln"	=> "Die Regeln können sich ändern und jeder User ist verpflichtet sich ständig über den Stand zu Informieren !",

);

$lang['rules_info1']				= "Es wird aber im <a href=\"%s\" target=\"_blank\">Forum</a> und über die Startseite im Game darüber Informiert ...";
$lang['rules_info2']				= "Als Ergänzung hierzu sind die <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">AGB</a> zu beachten und einzuhalten !</font>";


//AGB

$lang['agb_overview']				= "Allgemeine Geschäftsbedingungen";
$lang['agb']						= array(
	"Leistungsinhalte"				=> array( 
		"Die Anerkennung der AGBS sind nötige Voraussetzung, um am Spiel teilnehmen zu können.
		Sie gelten für alle Angebote seitens der Betreiber, einschließlich des Forums und anderer spielbezogener Inhalte.",
		
		"Das Angebot ist kostenlos.
		Somit bestehen keinerlei Ansprüche auf Verfügbarkeit, Bereitstellung, Funktionalität oder Schadensersatz.
		Weiterhin hat der Spieler keinerlei Ansprüche auf Wiederherstellung, sollte sein Account nachteilig behandelt worden sein.",
	),

	"Mitgliedschaft"				=> array(
		"Mit erfolgter Anmeldung im Spiel- und/oder im Forum beginnt die Mitgliedschaft im jeweiligen Spiel.",
		
		"Die mit der Anmeldung beginnende Mitgliedschaft kann jederzeit von Seiten des Mitglieds mit Löschung des Accounts oder durch Anschreiben eines Administrators beendet werden.
		Eine Löschung der Daten kann aus technischen Gründen nicht sofort erfolgen.",
		
		"Beendigung durch den Betreiber Kein Nutzer hat einen Anspruch auf die Teilnahme an Angeboten des Betreibers.
		Der Betreiber behält sich das Recht vor, Accounts zu löschen.
		Die Entscheidung über die Löschung von Nutzeraccounts obliegt einzig und allein dem Betreiber sowie den Administratoren und Operator.
		Jedweder Rechtsanspruch auf eine Mitgliedschaft ist ausgeschlossen.",
		
		"Sämtliche Rechte verbleiben beim Betreiber.",
	),

	"Inhalte/Verantwortlichkeit"	=> "Für den Inhalt der verschiedenen spielbezogenen Kommunikationsmöglichkeiten sind die Nutzer selbst verantwortlich. Pornographische, rassistische, beleidigende oder auf sonstige Weise gegen geltendes Recht verstoßende Inhalte liegen nicht in der Verantwortung des Betreibers.
	Verstöße können zur sofortigen Löschung oder Sperrung führen.
	Die Löschung solcher Inhalte erfolgt schnellstmöglich, kann jedoch aus technischen und/oder persönlichen Gründen verzögert werden.",

	"Verbotene Eingriffe"			=> array(
		"Der Nutzer ist nicht berechtigt, Hardware/Software oder sonstige Materien oder Mechanismen in Verbindung mit der Website zu verwenden, die die Funktion und den Spielablauf stören können.
		Der Nutzer darf weiterhin keine Maßnahmen ergreifen, die eine unzumutbare oder verstärkte Belastung der technischen Kapazitäten zur Folge haben können.
		Es ist dem Nutzer nicht gestattet, vom Betreiber generierte Inhalte zu manipulieren oder in sonstiger Weise störend in das Spiel einzugreifen.",
		
		"Jede Art von Bot, Script oder sonstige Automatisierungsfunktionen sind verboten.
		Das Spiel darf nur im Browser gespielt werden. Selbst seine Funktionen dürfen nicht genutzt werden um sich einen Spielvorteil zu verschaffen.
		Somit darf auch keine Werbung geblockt werden. Die Entscheidung, wann eine Software für den Spieler vorteilhaft ist, liegt einzig beim Betreiber/ bei den Administratoren/Operatoren.",
		
		"Ein automatisiertes öffnen des Accounts, unabhängig davon, ob dabei die Startseite angezeigt wird oder nicht, ist nicht erlaubt.",
	),

	"Nutzungsbeschränkung"		=> array(
		"Ein Spieler darf nur jeweils einen Account pro Universum nutzen, so genannte \"Multis\" sind nicht erlaubt und können ohne Warnung gelöscht/gesperrt werden.
		Die Entscheidung, wann ein \"Multi\" vorliegt, liegt einzig beim Betreiber/Administratoren/Operatoren.",
		
		"Näheres bestimmt sich nach den Spielregeln.",
		
		"Sperrungen können nach Ermessen des Betreibers dauerhaft oder temporär sein.
		Ebenso können sich Sperrungen auf einen oder alle Spielbereiche erstrecken.
		Die Entscheidung, wann und wie lange ein Spieler gesperrt wird, liegt einzig beim Betreiber/ bei den Administratoren/Operatoren.",
	),

	"Datenschutz"					=> array(
		"Der Betreiber behält sich das Recht vor, Daten der Spieler zu speichern, um die Einhaltung der Regeln, der AGB sowie geltenden Rechts zu überwachen.
		Gespeichert werden alle benötigten und vom Spieler oder seinem Account abgegebenen Daten.
		Hierzu gehören (IPs in Verbindung mit Nutzungszeiten und Nutzungsart, die bei der Anmeldung angegebene Email Adresse und weitere Daten.
		Im Forum werden die dort im Profil gemachten Angaben gespeichert.",
		
		"Diese Daten werden unter Umständen zur Wahrnehmung gesetzlicher Pflichten an Handlungsgehilfen und sonstige Berechtigte herausgegeben.
		Weiterhin können Daten (wenn notwendig) unter Umständen an Dritte herausgegeben werden.",
		
		"Der Nutzer kann der Speicherung seiner personenbezogenen Daten jederzeit widersprechen. Ein Widerspruch kommt einer Kündigung gleich.",
	),

	"Rechte des Betreibers an den Accounts"	=> array(
		"Alle Accounts und alle virtuellen Gegenstände bleiben im Besitz und Eigentum des Betreibers.
		Der Spieler erwirbt kein Eigentum und auch sonst keinerlei Rechte am Account oder an Teilen.
		Sämtliche Rechte verbleiben beim Betreiber.
		Eine übertragung von Verwertungs- oder sonstigen Rechten auf den Nutzer findet zu keinem Zeitpunkt statt.",
		
		"Unerlaubte Veräußerung, Verwertung, Kopie, Verbreitung, Vervielfältigung oder anderweitige Verletzung der Rechte (z.B. am Account) des Betreibers werden dem geltenden Recht entsprechend verfolgt.
		Ausdrücklich gestattet ist die unentgeltliche, endgültige Weitergabe des Accounts sowie das Handeln von Ressourcen im eigenen Universum, sofern und soweit es die Regeln zulassen.",
	),

	"Haftung"	=> "Der Betreiber eines jeden Universums übernimmt keine Haftung für etwaige Schäden.
	Eine Haftung ist ausgeschlossen mit Ausnahme von Schäden, die durch Vorsatz und grobe Fahrlässigkeit entstehen sowie sämtlichen Schäden an Leben und Gesundheit.
	Diesbezüglich wird ausdrücklich darauf hingewiesen, dass Computerspiele erhebliche Gesundheitsrisiken bergen können.
	Schäden sind nicht im Sinne des Betreibers.",

	"Änderung der Nutzungsbedingungen"	=> "Der Betreiber behält sich das Recht vor, diese Nutzungsbedingungen jederzeit zu ändern oder zu erweitern.
	Eine änderung oder Ergänzung wird mindestens eine Woche vor Inkrafttreten im Forum veröffentlicht.",
);

//Facebook Connect

$lang['fb_perm']				= 'Du hast ein Zugriff verboten. %s braucht alle Rechte, damit du dich mit deinem Facebook Account einloggen kannst.\nAlternativ kannst du dich ohne Facebook-Account anmelden!';

//NEWS

$lang['news_overview']			= "News";
$lang['news_from']				= "Am %s von %s";
$lang['news_does_not_exist']	= "Keine News vorhanden!";

//Impressum

$lang['disclamer']				= "Haftungsausschluss";
$lang['disclamer_name']			= "Name";
$lang['disclamer_adress']		= "Adresse";
$lang['disclamer_tel']			= "Telefon:";
$lang['disclamer_email']		= "E-Mail Adresse";
?>