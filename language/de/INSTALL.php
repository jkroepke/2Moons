<?php

/**
 *  2Moons
 *  Copyright (C) 2011 Jan Kröpke
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
 * @copyright 2009 Lucky
 * @copyright 2011 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.5 (2011-07-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

$LNG['back']					= 'Zurück';
$LNG['continue']				= 'Weiter';
$LNG['login']					= 'Login';

$LNG['menu_intro']				= 'Intro';
$LNG['menu_install']			= 'Installieren';
$LNG['menu_license']			= 'Lizenz';

$LNG['title_install']			= 'Installer';

$LNG['intro_lang']				= 'Sprache';
$LNG['intro_instal']			= 'Zur Installation';
$LNG['intro_welcome']			= 'Herzlich Willkommen beim 2Moons!';
$LNG['intro_text']				= '2Moons ist eines der besten Klone von OGame.<br>2Moons ist die neueste und stabilste XNova Version je entwickelt wurde. 2Moons glänzt durch Stabilität, Flexibilität, Dynamik, Qualität und Benutzerfreundlichkeit. Wir hoffen immer besser zu sein als ihre Erwartungen.<br><br>Das Installations-System führt Sie durch die Installation, oder Upgrade auf einer vorherigen Version auf die neueste ein. Jede Frage, ein Problem zögern Sie bitte nicht, unsere Entwicklung und Unterstützung zu ersuchen.<br><br>2Moons ist ein OpenSource-Projekt und ist under GNU GPL v3 lizenziert. Zur Lizenz klicken Sie bitte im Menu auf die entsprechenden Menüpunkt.<br><br>Bevor die Installation gestartet werden kann, wird vorher ein kleiner Test durchgeführt, ob sie die Mindestanforderungen unterstützen.';

$LNG['licence_head']			= 'Lizenzbestimmungen';
$LNG['licence_desc']			= 'Bitte lesen Sie die folgenden Lizenzbestimmungen. Verwenden Sie die Bildlaufleiste, um das gesamte Dokument anzuzeigen.';
$LNG['licence_accept']			= 'Akzeptieren Sie sämtliche Bedingungen der Lizenzbestimmungen? Sie können die Software nur installieren, wenn Sie die Lizenzbestimmungen akzeptieren.';
$LNG['licence_need_accept']		= 'Um mit der Installation fortfahren zu können, müssen Sie die Lizenzbestimmungen akzeptieren.';

$LNG['req_head']				= 'Benötigte Systemvoraussetzungen';
$LNG['req_desc']				= 'Bevor die Installation fortgesetzt werden kann, wird 2Moons einige Tests zu deiner Server-Konfiguration und deinen Dateien durchführen, um sicherzustellen, dass du 2Moons installieren und benutzen kannst. Bitte lies die Ergebnisse aufmerksam durch und fahre nicht weiter fort, bevor alle erforderlichen Tests bestanden sind. Falls du irgendeine der Funktionen, die unter den optionalen Modulen aufgeführt sind, nutzen möchtest, solltest du sicherstellen, dass die entsprechenden Tests auch bestanden werden.';
$LNG['reg_yes']					= 'Ja';
$LNG['reg_no']					= 'Nein';
$LNG['reg_found']				= 'Gefunden';
$LNG['reg_not_found']			= 'Nicht Gefunden';
$LNG['reg_writable']			= 'Beschreibbar';
$LNG['reg_not_writable']		= 'Nicht Beschreibbar';
$LNG['reg_file']				= 'Datei &raquo;%s&laquo; beschreibbar?';
$LNG['reg_dir']					= 'Ordner &raquo;%s&laquo; beschreibbar?';
$LNG['req_php_need']			= 'Installierte Version der Skriptsprache &raquo;PHP&laquo;';
$LNG['req_php_need_desc']		= '<strong>Voraussetzung</strong> — PHP ist die Serverseitige Sprache, in der 2Moons geschrieben ist. Damit 2Moons ohne Einschränkungen funktioniert, wird die PHP Version 5.2.5 vorrausgesetzt.';
$LNG['reg_gd_need']				= 'Installierte Version der Grafikbearbeitungs-Bibliothek &raquo;gdlib&laquo;';
$LNG['reg_gd_desc']				= '<strong>Optional</strong> — Grafikbearbeitungs-Bibliothek &raquo;gdlib&laquo; ist für die dynamische Generierung von Bildern zuständig. Ohne sie werden einige Funktionalitäten der Software nicht funktionieren.';
$LNG['reg_mysqli_active']		= 'Unterstützung der &raquo;MySQLi&laquo; Extension';
$LNG['reg_mysqli_desc']			= '<strong>Voraussetzung</strong> — Du musst Unterstützung für MySQLi in PHP bereitstellen. Falls keine Datenbank-Module als verfügbar angezeigt werden, solltest du deinen Webhosting-Provider kontaktieren oder die entsprechende PHP-Dokumentation zu Rate ziehen.';
$LNG['reg_json_need']			= 'Erweiterung &raquo;JSON&laquo; verfügbar?';
$LNG['reg_iniset_need']			= 'PHP-Funktion &raquo;ini_set&laquo; vorhanden?';
$LNG['reg_global_need']			= 'register_globals deaktiviert?';
$LNG['reg_global_desc']			= '2Moons wird auch funktionieren, wenn diese Einstellung aktiviert ist. Allerdings wird aus Sicherheitsgründen empfohlen, register_globals in der PHP-Installation zu deaktivieren, falls dies möglich ist.';
$LNG['req_ftp_head']			= 'Eingabe der Zugangsdaten für FTP';
$LNG['req_ftp_desc']			= 'Geben Sie Ihre FTP Daten ein, damit 2Moons automatisch die Probleme beheben kann. Alternativ können Sie auch manuell die Schreibrechte vergeben.';
$LNG['req_ftp_host']			= 'Hostname';
$LNG['req_ftp_username']		= 'Benutzername';
$LNG['req_ftp_password']		= 'Kennwort';
$LNG['req_ftp_dir']				= 'Installationspfad zu 2Moons';
$LNG['req_ftp_send']			= 'Absenden';
$LNG['req_ftp_error_data']		= 'Mit den angegebenen Zugangsdaten konnte keine Verbindung zu einem FTP-Server hergestellt werden.';
$LNG['req_ftp_error_dir']		= 'Das eingegebene Verzeichnis ist ungültig.';

$LNG['step1_head']				= 'Datenbankzugang konfigurieren';
$LNG['step1_desc']				= 'Nachdem nun festgestellt wurde, dass 2Moons auf deinem Server betrieben werden kann, musst du noch einige Informationen angeben. Wenn du nicht weißt, wie die Verbindungsdaten für deine Datenbank lauten, kontaktiere bitte als erstes deinen Webhosting-Provider oder wende dich an die 2Moons Support-Foren. Wenn du Daten eingibst, prüfe diese bitte sorgfältig, bevor du fortfährst.';
$LNG['step1_mysql_server']		= 'Datenbankserver-Hostname oder DSN';
$LNG['step1_mysql_port']		= 'Datenbankserver-Port';
$LNG['step1_mysql_dbuser']		= 'Datenbank-Benutzername';
$LNG['step1_mysql_dbpass']		= 'Datenbank-Passwort';
$LNG['step1_mysql_dbname']		= 'Name der Datenbank';
$LNG['step1_mysql_prefix']		= 'Tabellenprefix:';

$LNG['step2_prefix_invalid']	= 'Der DB-Prefix darf nur alphanumerische Zeichen und Unterstriche enthalten.';
$LNG['step2_db_error']			= 'Fehler beim Erstellen der Datenbank-Tabellen:';
$LNG['step2_db_no_dbname']		= 'Kein Datenbank-Name angegeben.';
$LNG['step2_db_too_long']		= 'Das angegebene Tabellen-Präfix ist zu lang. Die maximale Länge beträgt 36 Zeichen.';
$LNG['step2_db_con_fail']		= 'Es kann keine Verbindung zur Datenbank aufgebaut werden. Details stehen in unten angezeigter Fehlermeldung.';
$LNG['step2_conf_op_fail']		= 'config.php ist nicht beschreibbar!';
$LNG['step2_conf_create']		= 'config.php erfolgreich erstellt...';
$LNG['step2_db_done']			= 'Verbindung zur Datenbank war erfolgreich!';

$LNG['step3_head']				= 'Datenbank-Tabellen erstellen';
$LNG['step3_desc']				= 'Die von 2Moons genutzten Datenbank-Tabellen wurden nun erstellt und mit einigen Ausgangswerten gefüllt. Geh weiter zum nächsten Schritt, um die Installation von 2Moons abzuschließen.';

$LNG['step4_head']				= 'Administrator erstellen';
$LNG['step4_desc']				= 'Der Installationsassistent erstellt nun ein Administrator-Konto für Sie. Bitte geben Sie dazu einen Benutzernamen, eine E-Mail-Adresse und ein Kennwort ein.';
$LNG['step4_admin_name']		= 'Benutzername des Administrators:';
$LNG['step4_admin_name_desc']	= 'Bitte gib einen Benutzernamen mit einer Länge von 3 bis 20 Zeichen ein.';
$LNG['step4_admin_pass']		= 'Administrator-Passwort:';
$LNG['step4_admin_pass_desc']	= 'Bitte gib ein Passwort mit einer Länge von 6 bis 30 Zeichen ein.';
$LNG['step4_admin_mail']		= 'Kontakt-E-Mail-Adresse:';

$LNG['step6_head']				= 'Herzlichen Glückwunsch!';
$LNG['step6_desc']				= 'Du hast 2Moons erfolgreich installiert.';
$LNG['step6_info_head']			= 'Starte mit 2Moons durch!';
$LNG['step6_info_additional']	= 'Wenn du unten auf die Schaltfläche klickst, wirst du zu einem Formular im Administrations-Bereich weitergeleitet. Anschließend solltest du dir etwas Zeit nehmen, um die verfügbaren Optionen kennen zu lernen.<br/><br/><strong>Bitte lösche die Datei &raquo;includes/ENABLE_INSTALL_TOOL&laquo; oder nenne es um, bevor du dein Spiel benutzt. Solange diese Datei existiert, ist dein Spiel potenziell gefährdet!</strong>';

$LNG['sql_universe']			= 'Universum';
$LNG['sql_close_reason']		= 'Game ist zurzeit geschlossen';
$LNG['sql_welcome']				= 'Herzlich Willkommen zu 2Moons v';

?>