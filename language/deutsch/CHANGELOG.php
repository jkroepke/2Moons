<?php

$lang['Version']     = 'Version';
$lang['Description'] = 'Beschreibung';
$revision = '$Date$';
$version  = explode("-",substr($revision, 7, -35));

$lang['changelog']   = array(

'RC5.0b6' => 'ShadoX '.$version[2].'.'.$version[1].'.'.substr($version[0],2,2).'
- ADD: Neue Accountlisten im ACP
- ADD: Gigarecler on Galaxy
- FIX: Trader
- FIX: Galaxy
- FIX: Allianz Hack
- FIX: Font-FIX in overLIB
- DIV: Update Smarty to 3.0b8
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',
'RC5.0b5' => 'ShadoX 06.03.10
- FIX: Attack
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',
'RC5.0b4' => 'ShadoX 01.03.10
- ADD: Plugin-System v0.4 (Green @ XG Proyecto)
- ADD: Neu StatBuilder
- FIX: AKS
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',

'RC5.0b3' => 'ShadoX 23.02.10
- ADD: DM BANK
- ADD: Koords werden nicht mehr in der HoF angezeigt.
- ADD: Update System BETA
- ADD: Admin in Statistiken ausblendbar
- ADD: jQuery UI 1.8rc2
- ADD: Neue Expedition
- FIX: Phalax &amp; Interplanetarrakten Reichweiten
- FIX: Urlaubsmodus fixed
- FIX: Haltende Flotten werden im Spiobericht dazugezählt.
- FIX: Anzeige der Canche der Mondzerstörung
- FIX: Admins in Rekorden
- FIX: Planetensuche
- FIX: Neues Kampfscript für Interplanetarraketeneinschläge
- DIV: Set DB Connection to UTF-8
- DIV: Userbanner wird nurnoch einmal ein Tag aktualisiert.
- DIV: Webseitenoptimierung(YSlow Grande: A/Score: 91)
- DIV: Add Headers für Browsercaching 
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
- DIV: Update jQuery to 1.4.2
',
'RC5.0b2' => 'ShadoX 20.02.10
- ADD: Accountlöschung w&auml;hrend des U-Modes
- ADD: UTF-8 Support for Names
- ADD: Kosten Dunkle Materie
- ADD: Some langs (not complete)
- FIX: Quere
- FIX: Gebäude Abreißen
- FIX: Allianzerstellung
- FIX: AKS in der Overview
- FIX: AKS-Hack
- FIX: AKS-Ressisverteilung
- FIX: Deuteriumberechung Planetentemperaturabhb&auml;nig
- FIX: Fusionkrafwerk: Bonus durch Energietechnik 
- FIX: Zeilenumbruch in Globalen Nachrichten fixed
- DIV: Update Smarty to 3.0b7
- DIV: UserStats Mod an AKS angepasst.
- DIV: Optimized Game Messages
- DIV: Rechtschreibfehler korrigiert
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',
'RC5.0b1' => 'ShadoX 02.02.10
- NEW: Search-Engine
- NEW: LOGIN
- NEW: Change Name to 2Moons
- ADD: Smarty-Template-Engine
- ADD: Forschungsmaximum in vars.php einstellbar
- ADD: fb-share
- ADD: Planetenliste
- ADD: Teampseak-Addon: Support für Teamspeak 3
- ADD: Max. Auftr&auml;ge in Fleet/Def einstellbar (Standart: 10)
- ADD: Cache for Records
- ADD: Realtime-Ressanzeige
- ADD: Optimize Hall of Fame DB
- ADD: Postausgang
- ADD: Abbruch Schiffswert
- FIX: Wirtschaftssystem
- FIX: Ress. - Page
- FIX: DM-Untersuchung
- FIX: Playercard
- FIX: Speicheranzeige in Rohstoffe
- FIX: Design
- FIX: Pranger
- FIX: Teamspeak-Overview
- FIX: Useramount
- FIX: Spioangebericht, -anzeige und -abwehr
- FIX: Allianz Chat
- FIX: TF-Entstehungs Bug bei Mondentstehung
- FIX: CheckPlanetUsedFields
- FIX: DeleteSelectedUser
- FIX: Moon TF
- FIX: Intergal. Forschungsnetzwerk
- FIX: Werte für den Verbrauch
- FIX: Error-Handler
- FIX: U-Mode &amp; Adminschutz - Iraks
- FIX: AKS-BUG in der SendFleetBack Funktion
- FIX: Flottenflugzeit
- FIX: CAPTCHA
- FIX: Bug bei Mond- und Planetzerstörung
- FIX: Reyclerrückkehr
- FIX: Kolonisierung: Mitgebrachte Ressis werden nun gutschreiben
- FIX: Flottenverbrauch
- FIX: SQL-Lücke in FleetAjax.php
- FIX: Planetenentfernung
- FIX: Diverse Flottencheats entfernt
- FIX: Magic TF`s
- FIX: ACP-fopen Error
- FIX: Opera Style Fix
- FIX: Mondzerstörung
- FIX: Module-Addon
- FIX: Support-Ticket
- FIX: DM Untersuchungs Mission
- FIX: Probleme mit der erstellung von Haputplaneten nach der mauellen Erstellung von Usern
- FIX: Allianzmemberanzahl in ainfo
- FIX: Noobschutz
- FIX: Moon Building
- FIX: Adminschutz
- FIX: Schiffebauen ohne Schiffswerft
- FIX: Anzeigefehler im KB Erstellung
- FIX: Passwort vergessen
- FIX: Passwort/Nichname &auml;ndern
- FIX: Umlaute in den Beschreibungen
- DIV: Neue Methode zum Aufruf von Fleethandler
- DIV: Neue Plantenbilder
- DIV: Flexibilit&auml;t für einfügen neue Geb&auml;ude erhöht
- DIV: Neue Formel für Speicherberechung
- DIV: Info im ACP, wenn FlyingFleetHandler einen Fehler hatte
- DIV: Useraktivierung per ACP
- DIV: Neue Formel für Solarsats, Deuterium, Planettemp und Felderanzahl
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
- DIV: Update jQuery to 1.4.1
',

'RC4.2' => 'ShadoX 06.12.09
- ADD: StatBanner
- ADD: Sycrogs robots.txt
- ADD: UserVaild-Funktion einstellbar
- FIX: News
- FIX: Offiziere
- FIX: Vaild-Maillink
- FIX: Retrun-Subject in Messages
- FIX: Global Adminmessage
- FIX: SQL Lücken in Notes
- FIX: NEWS
- FIX: Flotten Geschwindigkeit
- FIX: BeuteMath (by WOT-Game)
- FIX: GalxyMoonRow
- FIX: Mail
- FIX: Allianzinfo
- FIX: LostPassword
- FIX: Allianzr&auml;nge
- FIX: max. Expiditionen / max. Haltezeit
- FIX: Usernamenüberprüfung bei der Registration
- FIX: Registration close &amp; Game Close
- FIX: AdminChatPage
- FIX: Speicheranzeige in Rohstoffe korrigiert
- FIX: Galaxy Allyname Crash
- FIX: Statfunctions.php
- DIV: Mails über SMTP-Auth
- DIV: Chat-Class
- DIV: überarbeitung Installer
- DIV: Notes-Class
- DIV: Chat-Interval auf 10 Sekunden gesetzt
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',

'RC4.1' => 'ShadoX 23.11.09
- FIX: Moderration-ACP
- FIX: Userlöschung
- FIX: cronjob.php
- FIX: Mail-Funktion
- FIX: ACP-Topnav - Error
- FIX: UTF-8 im ACP
- FIX: Kleinere SQL-Lücken
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',

'RC4' => 'ShadoX 13.11.09
- ADD: Fleet/Def ins TF einstellbar
- ADD: Neue Funktion request_var, set_var und msg_handler
- ADD: Komplett überarbeitetes ACP (XGP 2.9.1)
- ADD: FlyingFleetHandler wird nicht mehr im Login aufgerufen
- ADD: FlyingFleetHandler wird nun nicht mehr 2x aufgerufen
- ADD: Neue Cronjob - "Engine"
- ADD: Verwendung von PHPMailer v5.1 Lite
- MOD: Datenbankverbindung nun mit mysqli
- MOD: AKS-Overview
- MOD: Neue Chat Engine based on jQuery
- MOD: Bauschleifennachrichten pro User abschaltbar
- MOD: Nutztung von mysqli::multi_query (5%)
- MOD: $_GET und $_POST durch request_var ersetzt (70%)
- MOD: Uservaris mit $db->sql_escape (mysqli_real_escape_string) verstzt (80%)
- MOD: Neue EMail-Klasse
- MOD: Bauzeit der aktuellen Forschung/des aktuellen Geb&auml;udes in der Titelleiste
- MOD: autoload - Funktion
- FIX: Zeilenumbrüche in Allianztexten
- FIX: Buddyliste
- FIX: Statistiken: Punkte up to 18.446.744.073.709.551.616 (Ja wei&szlig;, unnütz)
- FIX: Universumreset
- FIX: Spionageangriff
- FIX: SQL-Lücke in MissilesAjax.php
- FIX: Anonyme User können nicht ins Spiel kommen
- FIX: Planetenlöschung
- FIX: Ressourcen bei Forschungsabbruch
- FIX: Keine 10 Deu für eigene Gala mehr
- FIX: Planiliste im ACP
- FIX: (ID:01)-Bauen
- FIX: Geb&auml;ude mit Vorrausetztungen können nicht mehr ohne Vorraussetztung gebaut werden
- FIX: Hauptplanet hei&szlig;t nun standartm&auml;&szlig;ig Hauptplanet
- FIX: Attacklink bei Mondspionageberichten
- FIX: DM-Forschungsmission
- DIV: luna und galaxy Tabellen entfernt
- DIV: Komplett UTF-8 umgestellt
- DIV: Koords-Verliunkung zur Galaxie in Fleets
- DIV: Skinoptimierungen
- DIV: DB-Speichertyp für Geb&auml;ude und Forschung von int(11) auf TINYINT(3) unsigned ge&auml;ndert
- DIV: Anpassung an Internet Explorer (IE8) &amp; Opera
- DIV: Unnötige SQL-Abfragen(SELECT * FROM) ge&auml;ndert
- DIV: register_globals standartm&auml;ssig aus
- DIV: Alle Tabellen werden nun 1x pro Tag Aufger&auml;mt (OPTIMIZE TABLE)
- DIV: Seiten werden komprimiert an Client versendet
- DIV: Allianzpage nun mit switches gesteuert
- DIV: Performance Ingal. Netzwerk erhöht
- DIV: formatCR und calculateAttack in der FlyingFleetHandler nun integriert
- DIV: Neue Registration (XNova-Reloaded 0.1)
- DIV: Neue Nachrichtenverwaltung (XNova-Reloaded 0.1)
- DIV: Neue Baulisten (XNova-Reloaded 0.1)
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',
'RC3' => 'ShadoX 18.10.09
- ADD: AGB
- ADD: Rules
- ADD: Vaild E-Mail Funktion
- ADD: Datenbank-Backup
- ADD: Datenbank-Port ausw&auml;hlbar
- MOD: Datenbank Optimirungen
- FIX: Allianzr&auml;nge
- FIX: Allianzname &auml;ndern
- FIX: Aliianztag &auml;ndern
- FIX: Mehr als 2.147.483.647 Einheiten transportierbar
- FIX: statbuilder.php
- FIX: Userlöschung
- FIX: Beute beim Angriff
- FIX: DM Fund bei Expedition
- DIV: Alte Steal und Wirtschaftsysteme wieder eingefügt
- DIV: Neuer EMail-Text fü vergessendes Passwort
- DIV: Sicherheit im Game erhöht
- DIV: W3C Vaild (Login)
- DIV: Diverse Anpassungen am Game
',
'RC2' => 'ShadoX 13.10.09
- MOD: Lotterie
- MOD: TS-Overview Mod
- MOD: Mindestbauzeit einstellbar
- MOD: Captcha-Mod powerd by reCAPTCHA.net
- MOD: News in der Overview/auf der Startseite
- MOD: Hall of Fame + Allianzstatistik + Playercard
- MOD: Neue Planeten-, Mond- und Spielerlisten im ACP
- MOD: 4 Neue Schiffe(Evolution Transporter, Gigarecyler, Intergal. Materiensammler, Sternenzerstörer)
- MOD: Neue Def (Gravitationskannone)
- MOD: Neue Mission zur DM-Bergung
- MOD: Neues Wirtschaftssystem
- MOD: Module
- MOD: Supportsystem
- MOD: Rekorde
- FIX: Mondgrö&szlig;e wird richtig berechnet
- FIX: Korrekte Stealberechnung beim Angriff
- FIX: Sichheitslücke in der Allianzseite
- FIX: Flotten kommen bei zerstörten Mond auf den Planet wieder
- DIV: Neuer Standartskin: Darkness&sup2;
- DIV: Game zu 100% in Deutsche übersetzt (danke an Sycrog für das übersetzte ACP)
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
- DIV: Anzeige der Admins, die zurzeit online sind


Based on XG Proyect 2.8 on 11.10.09
',
);
?>