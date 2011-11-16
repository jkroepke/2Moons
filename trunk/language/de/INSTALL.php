<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
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
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.5 (2011-07-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

$LNG['continue']			= 'Weiter';

$LNG['menu_intro']			= 'Intro';
$LNG['menu_install']		= 'Installieren';
$LNG['menu_license']		= 'Lizenz';

$LNG['title_install']		= 'Installer';

$LNG['intro_lang']			= 'Sprache';
$LNG['intro_instal']		= 'Zur Installation';
$LNG['intro_welcome']		= 'Herzlich Willkommen beim 2Moons!';
$LNG['intro_text']			= '2Moons ist eines der besten Klone von OGame.<br>2Moons ist die neueste und stabilste XNova Version je entwickelt wurde. 2Moons glänzt durch Stabilität, Flexibilität, Dynamik, Qualität und Benutzerfreundlichkeit. Wir hoffen immer besser zu sein als ihre Erwartungen.<br><br>Das Installations-System führt Sie durch die Installation, oder Upgrade auf einer vorherigen Version auf die neueste ein. Jede Frage, ein Problem zögern Sie bitte nicht, unsere Entwicklung und Unterstützung zu ersuchen.<br><br>2Moons ist ein OpenSource-Projekt und ist under GNU GPL v3 lizenziert. Zur Lizenz klicken Sie bitte im Menu auf die entsprechenden Menüpunkt.<br><br>Bevor die Installation gestartet werden kann, wird vorher ein kleiner Test durchgeführt, ob sie die Mindestanforderungen unterstützen.';

$LNG['licence_head']		= 'Lizenzbestimmungen';
$LNG['licence_desc']		= 'Bitte lesen Sie die folgenden Lizenzbestimmungen. Verwenden Sie die Bildlaufleiste, um das gesamte Dokument anzuzeigen.';
$LNG['licence_accept']		= 'Akzeptieren Sie sämtliche Bedingungen der Lizenzbestimmungen? Sie können die Software nur installieren, wenn Sie die Lizenzbestimmungen akzeptieren.';
$LNG['licence_need_accept']	= 'Um mit der Installation fortfahren zu können, müssen Sie die Lizenzbestimmungen akzeptieren.';

$LNG['req_head']			= 'Benötigte Systemvoraussetzungen';
$LNG['req_desc']			= 'Die Systemvoraussetzungen, die 2Moons benötigt. Sollte eine Vorrausetztung nicht erfühlt sein, wir 2Moons nicht auf Ihrem Server ohne einschränkungen laufen.';
$LNG['reg_yes']				= 'Ja';
$LNG['reg_no']				= 'Nein';
$LNG['reg_found']			= 'Gefunden';
$LNG['reg_not_found']		= 'Nicht Gefunden';
$LNG['reg_writable']		= 'Beschreibar';
$LNG['reg_not_writable']	= 'Nicht Beschreibar';
$LNG['reg_file']			= 'Datei &raquo;%s&laquo; beschreibbar?';
$LNG['reg_dir']				= 'Ordner &raquo;%s&laquo; beschreibbar?';
$LNG['req_php_need']		= 'Installierte Version der Skriptsprache &raquo;PHP&laquo;';
$LNG['req_php_need_desc']	= 'PHP ist die Serverseitige Sprache, in der 2Moons geschreiben ist. Damit 2Moons ohne Einschränkungen funktioniert, wird die PHP Version 5.2.5 vorrausgesetzt.';
$LNG['reg_gd_need']			= 'Installierte Version der Grafikbearbeitungs-Bibliothek &raquo;gdlib&laquo;';
$LNG['reg_gd_desc']			= 'Grafikbearbeitungs-Bibliothek &raquo;gdlib&laquo; ist für die dynamische Generierung von Bildern zuständig. Ohne sie werden einige Funktionalitäten der Software nicht funktionieren.';
$LNG['reg_mysqli_active']	= 'Unterstützung der &raquo;MySQLi&laquo; Extension';
$LNG['reg_mysqli_desc']		= 'Die &raquo;MySQLi&laquo; Erweiterung ist der Nachfolger der MySQL Extension. Sie wird benötigt, um eine Verbindung zur Datenbank herzustellen.';
$LNG['reg_json_need']		= 'Erweiterung &raquo;JSON&laquo; verfügbar?';
$LNG['reg_iniset_need']		= 'Funktion &raquo;ini_set&laquo; vorhanden?';
$LNG['reg_global_need']		= 'register_globals deaktiviert?';
$LNG['req_ftp_head']		= 'Eingabe der Zugangsdaten für FTP';
$LNG['req_ftp_desc']		= 'Geben Sie Ihre FTP Daten ein, damit 2Moons automatisch die Probleme beheben kann. Alternativ können Sie auch manuell die Schreibrechte vergeben.';
$LNG['req_ftp_host']		= 'Hostname';
$LNG['req_ftp_username']	= 'Benutzername';
$LNG['req_ftp_password']	= 'Kennwort';
$LNG['req_ftp_dir']			= 'Installationspfad zu 2Moons';
$LNG['req_ftp_send']		= 'Absenden';
$LNG['req_ftp_error_data']	= 'Mit den angegebenen Zugangsdaten konnte keine Verbindung zu einem FTP-Server hergestellt werden.';
$LNG['req_ftp_error_dir']	= 'Das eingegebene Verzeichnis ist ungültig.';

$LNG['step1_head']			= 'Datenbankzugang konfigurieren';
$LNG['step1_desc']			= 'Die Daten der Software werden in einer MySQL Datenbank gespeichert. Bitte geben Sie die Zugangsdaten für diese Datenbank an!';
$LNG['step1_mysql_server']	= 'Hostname';
$LNG['step1_mysql_port']	= 'Port:';
$LNG['step1_mysql_dbuser']	= 'Benutzername';
$LNG['step1_mysql_dbpass']	= 'Kennwort:';
$LNG['step1_mysql_dbname']	= 'Datenbankname:';
$LNG['step1_mysql_prefix']	= 'Tabellenprefix:';

$LNG['step2_prefix_invalid']= 'Der DB-Prefix daruf nur alphanumerische Zeichen und Unterstriche enthalten.';
$LNG['step2_db_connet_ok']	= 'Verbindung zur Datenbank erfolgreich...';
$LNG['step2_db_create_ok']	= 'Datenbank Tabellen erfolgreich erstellt....';
$LNG['step2_db_error']		= 'Fehler beim erstellen der Datenbank-Tabellen:\n%s';
$LNG['step2_db_con_fail']	= 'Keine Verbindung der Datenbank.\n %s';
$LNG['step2_conf_op_fail']	= 'config.php ist nicht beschreibar!';
$LNG['step2_conf_create']	= 'config.php erfolgreich erstellt...';

$LNG['step3_create_admin']	= 'Erstellung einer Adminkontos';
$LNG['step3_admin_name']	= 'Administrator Username:';
$LNG['step3_admin_pass']	= 'Administrator Passwort:';
$LNG['step3_admin_mail']	= 'Administrator E-Mail Adresse:';

$LNG['step4_need_fields']	= 'Sie müssen alle Felder ausfüllen!';

$LNG['sql_universe']		= 'Universum';
$LNG['sql_close_reason']	= 'Game ist zurzeit geschlossen';
$LNG['sql_welcome']			= 'Herzlich Willkommen zu ';

?>