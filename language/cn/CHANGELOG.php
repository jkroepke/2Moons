
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
 * @author Jan <slaver7@gmail.com>
 * @copyright 2011 Jan <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.3 (2013-05-19)
 * @info $Id: CHANGELOG.php 2632 2013-03-18 19:05:14Z slaver7 $
 * @link http://2moons.cc/
 */
 
$LNG['Version']     = 'Version';
$LNG['Description'] = 'Beschreibung';

$LNG['changelog']   = array(
'v1.7.3' => 'Jan 19.05.2013
- 0000461: [User errors] Inexplicable errors (Jan) - resolved.
- 0000459: [Admin Panal] Undefined variable: CONFIG (Jan) - resolved.
- 0000429: [Langauge] Custom lang keys dont work (Jan) - resolved.
- 0000437: [Admin Panal] Undefined variable: CONFIG (Jan) - resolved.
- 0000434: [Admin Panal] unexpected ',' in InactiveMailCronjob (Jan) - resolved.
- 0000415: [Langauge] mail error (Jan) - resolved.
- 0000427: [User errors] Chat fell (Jan) - resolved.
- 0000425: [User errors] Chat Bug (Jan) - resolved.
- 0000305: [User errors] Class \'Swift_SmtpTransport\' not found (Jan) - resolved.
- 0000388: [Spell iusses] Undefined offset: on trader (Jan) - resolved.
- 0000387: [Spell iusses] Spionageberechte zusammenfassen unter Einstellungen (Jan) - resolved.
- 0000363: [Admin Panal] Ticket with an empty subject (Jan) - resolved.
',
'v1.7.2' => 'Jan 18.03.2013
- 0000358: [Fleet missions] Recycler mit vollem Rohstoffspeicher inkl. viel Kristall, baut TF nicht ab und geht auf Lock (Jan) - resolved.
- 0000360: [Fleet missions] Wenn bei "Mission: Halten" Rohstoffe mitgenommen wird, werden diese dort abgeliefert und die Flotte behält diese Rohstoffe (Jan) - resolved.
- 0000371: [Admin Panal] Support ticket kann nicht geschrieben werden (FC92) - resolved.
- 0000373: [Admin Panal] Nachrichten im ACP in der Nachrichtenliste können nicht mehr gelesen werden. (Jan) - resolved.
- 0000375: [Fleet missions] Halten soll kein Allianzdepot voraussetzen (Jan) - resolved.
- 0000386: [Fleet missions] Mehrere Interplantrakten kosten für eine (FC92) - resolved.
- 0000390: [User errors] Facebook Login (Jan) - resolved.
- 0000395: [Admin Panal] Manual Update Points (Jan) - resolved.
- 0000397: [Fleet missions] Mindestflugzeit wird nicht bei der Anzeige beachtet (Jan) - resolved.
- 0000411: [Langauge] "active users" in German (Jan) - resolved.
- 0000416: [Admin Panal] MessageListe im ACP bei IE8 / IE9 wird nicht geöffnet, Error: \'console\' ist undefiniert (Jan) - resolved.
- 0000423: [Statistical] Error in der class.statbuilder.php / Ref 2627, In der Tabelle config wird users_amount = 0 gesetzt (Jan) - resolved.
',
'v1.7.1' => 'Jan 18.01.2013
- Fix possible SQL Injections.
',
'v1.7' => 'Jan 17.01.2013
- 0000327: [Feature request] allowPlanetPosition integrieren (FC92) - resolved.
- 0000316: [Feature request] List of alliances when concluding the contract (FC92) - resolved.
- 0000328: [Admin Panal] CleanerCronjob SQL error (FC92) - resolved.
- 0000330: [Admin Panal] Adding fleet (FC92) - resolved.
- 0000331: [Feature request] Duplication of information in the combat report (FC92) - resolved.
- 0000333: [Feature request] Contract of alliances (FC92) - resolved.
- 0000336: [Alliance] A lot of confusion in the language keys two types of contracts (war and secret alliance) (FC92) - resolved.
- 0000338: [Alliance] You can offer an infinite number of identical contracts from one alliance to one alliance (FC92) - resolved.
- 0000339: [User errors] Falsche DE email_inactive.txt Texte (FC92) - resolved.
- 0000312: [Feature request] Backup schedule (FC92) - resolved.
- 0000322: [Feature request] Button to add the rank (FC92) - resolved.
- 0000014: [Officier] Mixed up the description extraDM (Orion) - resolved.
- 0000016: [Time] The extra zero in ACP -> Online users (Orion) - resolved.
- 0000031: [User errors] Beim automatischen löschen eines Spieler der Mitglied in einer Ali ist, wird der kompletten Ali-Datensatz gelöscht! (Orion) - resolved.
- 0000039: [Installer] Installation Error (Jan) - resolved.
- 0000041: [Fleet missions] class.FlyingFleetsTable.php Ref 2306 verursacht undefined Index PM, kein Login mehr möglich. (Orion) - resolved.
- 0000065: [Alliance] Error when you enter in menu Alliance (Jan) - resolved.
- 0000072: [User errors] PHP Fatal error bei Ref 2349 (Orion) - resolved.
- 0000076: [Fleet missions] Flying fleets disappear (Jan) - resolved.
- 0000152: [User errors] PHPMailer Exception handling (Jan) - resolved.
- 0000164: [Statistical] int -> bigint (Jan) - resolved.
- 0000191: [Admin Panal] Default Installation Typo? (Jan) - resolved.
- 0000225: [Statistical] Bein Aufruf eines KB aus der Hall of Fame Error: Undefined variable: CombatReport / Ref 2491 (Jan) - resolved.
- 0000233: [Installer] Fix installer with new language class (Jan) - resolved.
- 0000234: [Installer] Unkown Config Key lang (Jan) - resolved.
- 0000236: [Langauge] Error in language class (Jan) - resolved.
- 0000315: [Eco system] DailyCronjob locks when using other table prefix (FC92) - resolved.
- 0000309: [Admin Panal] Reply to the ticket after it is closed (FC92) - resolved.
- 0000303: [Officier] Officer 610 (Jan) - resolved.
- 0000298: [Fleet missions] Treibstoffverbrauch bei Stationieren und Transport ist immer gleich! (Jan) - resolved.
- 0000319: [Alliance] Undefined variable: rankRow (FC92) - resolved.
- 0000320: [Alliance] Button to save the rank does not work (FC92) - resolved.
- 0000313: [Time] Incorrect time in the teleport (Jan) - resolved.
- 0000317: [Admin Panal] InactiveMailCronjob lock with PHP Fatal error: Cannot redeclare class Mail (Jan) - resolved.
- 0000176: [User errors] Undefined index: moonChance (Jan) - resolved.
- 0000321: [Alliance] In the ranks the picture is missing (Jan) - resolved.
- 0000323: [Feature request] HTML editor (Jan) - resolved.
- 0000311: [Fleet missions] Some fleet missions are not working (Jan) - resolved.
- 0000310: [Feature request] Dynamic the remaining flight time (Jan) - resolved.
- 0000308: [Admin Panal] Support system (Jan) - resolved.
- 0000304: [User errors] Settings - Number spy probe (Jan) - resolved.
- 0000300: [User errors] Bei Mondversuch erhalte ich bei bestimmten angriffen folgende fehlermeldung (Jan) - resolved.
- 0000307: [Langauge] ru/email/email_inactive.txt: failed to open stream (Jan) - resolved.
- 0000306: [User errors] SQL Error: Unknown column \'Array\' (Jan) - resolved.
- 0000231: [Feature request] The name of the object in the battle report. (Jan) - resolved.
- 0000105: [Feature request] Create a MySQL Backup solution (Jan) - resolved.
- 0000179: [Officier] ExtraDM 705 does not add energy (Jan) - resolved.
- 0000299: [Installer] Smarty error in installer (Jan) - resolved.
- 0000220: [Fleet missions] Jump Gates not allowing jumps (Jan) - resolved.
- 0000295: [User errors] Kein Login mit IE8 möglich, Error: "Undefined offset: 1" (Jan) - resolved.
- 0000296: [Admin Panal] ReferralCronjob BUG, PHP Fatal error: Call to a member function setDefault() (Jan) - resolved.
- 0000180: [Officier] rpg_espion not work (Jan) - resolved.
- 0000186: [Fleet missions] A lot of problems with fleet mission (Jan) - resolved.
- 0000197: [Cheat] The Phalanax shows deployment mission at origin planet (Jan) - resolved.
- 0000221: [Officier] Officer General ADDs fleet time (Jan) - resolved.
- 0000211: [Fleet missions] [FIX] Interplanetarraketen (Jan) - resolved.
- 0000206: [Feature request] 2 neue Variabeln für aktuelle Forschung & Schiffbau einbauen (Jan) - resolved.
- 0000223: [Alliance] Missing key in alliance home page (Jan) - resolved.
- 0000204: [Admin Panal] Teamspeak-Cronjob geht auf lock (Jan) - resolved.
- 0000192: [Admin Panal] Cronjob CleanerCronjob geht auf lock, inaktive User werde nicht gelöscht. (Jan) - resolved.
- 0000153: [Feature request] Block PMs (Jan) - resolved.
- 0000172: [Admin Panal] The page numbering does not fit on the screen (Jan) - resolved.
- 0000185: [Admin Panal] User Ban Panel (Jan) - resolved.
- 0000194: [Langauge] Typo in Vac Mod (Jan) - resolved.
- 0000198: [Feature request] Market (Jan) - resolved.
- 0000202: [Langauge] Delete Player confirmation text typo (Jan) - resolved.
- 0000219: [Admin Panal] Aktivierungs Probleme, nach der Registration (Jan) - resolved.
- 0000226: [Fleet missions] Expeditionen können nicht gestartet werden, FIX 187 nicht ganz vollständig ! (Jan) - resolved.
- 0000227: [Installer] Fix to installer (Jan) - resolved.
- 0000228: [Alliance] Bug in alliance manage rights (Jan) - resolved.
- 0000229: [Admin Panal] Bug in info page (Jan) - resolved.
- 0000230: [Alliance] Text wrong in alliance view member (Jan) - resolved.
- 0000232: [Eco system] Better buildings page (Jan) - resolved.
- 0000196: [Eco system] Different encoding across PHP scripts (not always UTF-8) (Jan) - resolved.
- 0000168: [User errors] Not work switcher pages (Jan) - resolved.
- 0000205: [Admin Panal] Infos aus der "Nachrichtenliste" können nicht geöffnet werden, Error [object Object] (Jan) - resolved.
- 0000184: [Fleet missions] DM Untersuchung (Jan) - resolved.
- 0000177: [Feature request] To loser comes abbreviated battle report (Jan) - resolved.
- 0000199: [Admin Panal] Admin Logs (Jan) - resolved.
- 0000210: [Admin Panal] Bei Erstellung von neuen Usern über ACP werden nicht alle Infotexte angezeigt. (Jan) - resolved.
- 0000216: [Fleet missions] Expeditionsnachrichten (Jan) - resolved.
- 0000203: [Admin Panal] News im ACP können nicht erstellt oder geändert werden. (Jan) - resolved.
- 0000208: [Feature request] Building queue Update (Jan) - resolved.
- 0000209: [Fleet missions] Verband kann nicht aktiviert werden (Jan) - resolved.
- 0000212: [Alliance] [FIX] Delete Alliance Rank (Jan) - resolved.
- 0000214: [Fleet missions] Rückkehrmeldungen enthalten falschen Planeten (Jan) - resolved.
- 0000217: [Admin Panal] ACP/ Uni Konfigurations seite (Jan) - resolved.
- 0000215: [Fleet missions] Meldung von Expedition bei finden von Schiffen anpassen (Jan) - resolved.
- 0000183: [Feature request] Händler Funtioniert nicht ganz (Jan) - resolved.
- 0000161: [Admin Panal] Cronjobs können nicht richtig gesetzt werden und werden nicht abgearbeitet. (Jan) - resolved.
- 0000189: [Fleet missions] Able to attack while in VMODE (Jan) - resolved.
- 0000173: [Langauge] Two identical language key in a file ADMIN.php (Jan) - resolved.
- 0000174: [User errors] Undefined index: lm_changelog (Jan) - resolved.
- 0000175: [Admin Panal] Cleaning the cache does not work correctly (Jan) - resolved.
- 0000170: [Admin Panal] File CUSTOM.php does not overwrite the values of language keys ADMIN.php (Jan) - resolved.
- 0000169: [Admin Panal] Wrong reduction in numbers (Jan) - resolved.
- 0000127: [Fleet missions] Recycling missions with max transported resources fail [with solution] (Jan) - closed.
TMOONS-22 - In admin panel issue
TMOONS-106 - Werte des Atomkraftwerks bei Bonus kopiert (Deuterium)
TMOONS-137 - Kein Login nach Update von Ref 2091 auf 2104 mehr möglich
TMOONS-154 - Login doesn&#39;t work
TMOONS-157 - Versatz und Fehler meldung bei Spionage
TMOONS-159 - Regestrierung geht nicht!!
TMOONS-161 - New versions errors!
TMOONS-163 - Koloniesieren
TMOONS-165 - Admin control panel, cannot create new player
TMOONS-166 - IPM does not work
TMOONS-169 - Konfiguration der Planeten in Galaxie
TMOONS-170 - It&#39;s imposible sen fleets
TMOONS-173 - Error in Flotten und in Technologie
TMOONS-174 - Undefined constant in index.php
TMOONS-176 - Undefined index: shipsNeed at game.php?page=galaxy
TMOONS-181 - Kristall Fehlt :)
TMOONS-188 - Statistik
TMOONS-189 - Händler fehler
TMOONS-190 - Die Aufgerufene Seite existiert nicht
TMOONS-191 - System 500 error
TMOONS-196 - Reports of failed construction
TMOONS-198 - Rohstoffe Produktion einstellen
TMOONS-199 - Händler 
TMOONS-205 - Die Aufgerufene Seite existiert nicht
TMOONS-206 - Technologie
TMOONS-207 - User über Admin erstellen
TMOONS-208 - Flotte verschicken
TMOONS-209 - install Fehler
TMOONS-211 - Gebäude Timer Overview
TMOONS-216 - Error beim Flottenversand
TMOONS-218 - Infos von Offizieren können nicht aufgerufen werden
TMOONS-219 - Error Account-Information aus ACP
TMOONS-223 - Fleet vanished
TMOONS-228 - Error log #2
TMOONS-235 - Date of block
TMOONS-236 - Vacation and flying fleet
TMOONS-238 - Error beim Aufruf der Galaxie über Koordinaten in Playercard / Siehe sceenshot 
TMOONS-239 - Keine Flottendaten beim Versand / NUR IE8 !
TMOONS-240 - Error in Flotten bei Mission Angriff 
TMOONS-245 - Händler kann nicht gerufen werden
TMOONS-246 - Support-Ticket kann weder gelöscht noch geschlossen werden.
TMOONS-247 - Error in Flotten bei Mission Transport und maximalen Rohstoffen
TMOONS-248 - Planetenauswahl zeigt immer ersten Planeten
TMOONS-249 - Hall of Fame wird nicht angezeigt
TMOONS-250 - Lösch-Icon /styles/resource/images/r1.png nicht vorhanden
TMOONS-251 - Double key
TMOONS-254 - anflug auf Mond nicht möglich
TMOONS-256 - User erstellen im Admin
TMOONS-257 - Planetmenu (PlanetAction)
TMOONS-258 - Error Allianz Rundmail
TMOONS-259 - Errormeldung Login Versuch wenn Game gesperrt 
TMOONS-260 - Schrotthändler, Schiffe werden nicht abgezogen, Ressourcenanzeige beim Schrotthändler falsch
TMOONS-261 - Error bei Abbruch einer Bauschleife im Baumenü bei mehr als einen Eintrag
TMOONS-263 - Error nach Sprachumstellung auf Russisch
TMOONS-264 - The doubling of the fleet
TMOONS-265 - Zeitzone kann im ACP nicht gespeicher/geändert werden
TMOONS-266 - Error Allianz-Chat
TMOONS-267 - Fleet-Points haben sich gigantisch vergrößert!
TMOONS-268 - Aktuelle 1.7. Version - Fehler bei der Installation
TMOONS-269 - Technologie trotz Erfüllung der Voraussetzungen, Farbanzeige rot
TMOONS-271 - Gamespeed wirkt sich nicht auf Enegie-Produktion aus
TMOONS-272 - Gebäude Produzieren nichts und lassen sich nicht ausbauen.
TMOONS-273 - Spionageberichte unformatiert 
TMOONS-274 - Ban-Panel Einträge werden nicht mehr gelöscht und Spielername und Adminname sind vertauscht
TMOONS-275 - Error bei Changelog-Anzeige !
TMOONS-276 - Doppelte Texte in Forschung
TMOONS-278 - Schrotthändler, Kristall und Deuterium wird nicht richtig verbucht
TMOONS-281 - Händler, Beträge werden falsch verbucht
TMOONS-282 - Error in Error.log
TMOONS-283 - Flotten, Verband, Error  - Die Aufgerufene Seite existiert nicht
TMOONS-284 - Spielername ändern in Einstellungen
TMOONS-285 - Error Planeten löschen im ACP
TMOONS-286 - Error bei Abbruch von aktiver Forschung bei mehreren Einträgen
TMOONS-287 - Error beim Auflösen einer Allianz
TMOONS-289 - Allianz, Bewerbungen -&gt; Die Bewerbung existiert nicht.
TMOONS-291 - Error bei Löschen einer Bauphase in Schiffswerft oder Verteidigung ohne Markierung eines Eintrags
TMOONS-292 - Manually update
TMOONS-294 - Lang keys change places
TMOONS-295 - Lang key in page.notes.default.tpl
TMOONS-296 - Shortcut name
TMOONS-299 - Error bei laufender Forschung wenn Wechsel auf Planeten wo diese Art der Forschung noch nicht vorhanden
TMOONS-300 - Schrotthändler Meldung immer &quot;erfolgreich umgetauscht&quot;
TMOONS-303 - Passwortänderung wird nicht gespeichert
TMOONS-304 - Gebäude Infos
TMOONS-305 - Flotten, Schiffe werden bei Angriff nicht verschickt
TMOONS-306 - Lang key in page.galaxy.default.tpl
TMOONS-307 - ExtraDM description
TMOONS-309 - Error.log in alpha 3
TMOONS-310 - Page does not exist
TMOONS-313 - Benötigte Ressourcen für Solarkraftwerk viel zu hoch.
TMOONS-314 - Error Undefined variable: RPLANET 
TMOONS-315 - Error.log gesammelte Einträge
TMOONS-316 - Im ACP bei &quot;Fliegende Flotten&quot; fehlerhafte Stationszeit
TMOONS-318 - topkb error
TMOONS-320 - Statistik update fehler
TMOONS-321 - Die unendlichen Weiten des Universums reisen
TMOONS-322 - Create Planet
TMOONS-323 - Angriff nicht möglich bei Revision 100
TMOONS-324 - Expedition
TMOONS-325 - Nach Angriff Metallmine auf Stufe 255
TMOONS-329 - Installation Fehler neuste Version
TMOONS-330 - SQL Fehler
TMOONS-332 - Flotten senden mit &quot;Max Rohstoffe&quot;
TMOONS-335 - .htaccess
TMOONS-336 - Fehlerhafte Energieberechnung bei Solarkraftwerk + Ingenieur
TMOONS-339 - Error, Reflink, HTML und BBCode, Undefined index
TMOONS-340 - Nach der Installation kommt ein fehler
TMOONS-341 - Fehler Useranmeldung
TMOONS-343 - Allianz auflösen geht nicht; Rev 128
TMOONS-345 - Cheat on the speed of the ships
TMOONS-348 - Error.log nach login
TMOONS-349 - SQL injection
TMOONS-352 - SQL Error: Unknown column &#39;s.user_id&#39; in &#39;on clause&#39;
TMOONS-353 - In Statistik ... /styles/theme/gow/img/m.gif  für Private Nachrichten nicht vorhanden
TMOONS-359 - Plane namen ändern
TMOONS-360 - ENABLE_INSTALL_TOOL
TMOONS-361 - Colorful background in ACP
TMOONS-363 - Installation Fehler
TMOONS-365 - Disabling modules
TMOONS-366 - Not used languages keys
TMOONS-367 - Page vertify - white screen
TMOONS-368 - New user from ACP
TMOONS-369 - Double &quot;name&quot;
TMOONS-370 - Untranslated word
TMOONS-372 - Language mistake
TMOONS-373 - Not displayed language key
TMOONS-374 - Keine schnellauswahl in der Galaxieansicht
TMOONS-375 - Changing the name of the planet
TMOONS-376 - Template of the curve
TMOONS-380 - Deleting messages by date
TMOONS-382 - Uni Export funkioniert nicht
TMOONS-385 - Cosmetic improvement in the language file
TMOONS-386 - The filter of name
TMOONS-387 - Advanced search in the ACP
TMOONS-388 - List of universes
TMOONS-389 - Resetting the universe
TMOONS-396 - Spieler löschen im Admin
TMOONS-401 - Produkltionsmaxiemierung (Forschung) funktioniert nicht
TMOONS-403 - Can&#39;t destroy buildings
TMOONS-404 - Fleet in overview page
TMOONS-405 - search page
TMOONS-406 - Problem beim rechte von Spieler ändern
TMOONS-407 - Return time the mission LeaveTMOONS-193 - Removing log_fleets
TMOONS-224 - Page multiips
TMOONS-230 - The intersection of the fleets
TMOONS-237 - Button 100% production
TMOONS-297 - Location shortcuts
TMOONS-298 - Exchange
TMOONS-308 - Banner
TMOONS-311 - Backup the database
TMOONS-312 - Pagination
TMOONS-331 - The overall result of the empire
TMOONS-354 - AKS module in ACP
TMOONS-356 - Information about the storage capacity
TMOONS-381 - ID sender message in the ACP
TMOONS-398 - Engine of shipsTMOONS-301 - Bei &quot;Passwort vergessen&quot; keine Info dass eMail-Versand durchgeführt worden ist.
TMOONS-346 - The doubling of the fleet',
'v1.6.1' => 'Jan 19.11.11
- 0000027: [Core] Phalanx (Slaver) - resolved.
- 0000071: [Core] The list of the moon for teleportation (Slaver) - resolved.
- 0000078: [Fleets (Missions)] Rev. 2074 Mission atack (Slaver) - resolved.
- 0000077: [Core] Rev. 2074 Phalnax (Slaver) - resolved.
- 0000079: [Design] Tooltip bei Server-Konfig und Uni-Konfig werden nicht mehr angezeigt (Slaver) - resolved.
- 0000076: [Fleets (Missions)] neue version 1.6 (Slaver) - resolved.
',
'v1.6' => 'Jan 17.11.11
- 0000075: [Login] Registrierungserror wenn im Planeten namen ein \' vorkommt (Slaver) - resolved.
- 0000069: [Core] Chance of destruction of the moon (Slaver) - resolved.
- 0000066: [Core] Registration (Slaver) - resolved.
- 0000054: [Core] Missions Rocket attack and to Destroy (Slaver) - resolved.
- 0000070: [Core] Ticket system (Slaver) - resolved.
- 0000068: [Core] Rev 2065 Error afeter update in class.template (Slaver) - resolved.
- 0000018: [Core] Speed of recyclers and spies (Slaver) - resolved.
- 0000062: [Login] Install fehler (Slaver) - resolved.
- 0000065: [Core] Attacks and a holiday mode (Slaver) - resolved.
- 0000067: [Core] Rev. 2062 Reset universum (Slaver) - resolved.
- 0000061: [Time (offset errors)] progresbar moves only 100 pixels (1% - 1 pixel) in the construction and research (Slaver) - resolved.
- 0000058: [Design] Fortschrittsbalken bei Forschung und Gebäude wird nur noch zu ca. 40% aufgebaut. (Slaver) - resolved.
- 0000064: [Login] Install doesn\'t work in 2060 SVN Version: FIX (Slaver) - resolved.
- 0000057: [Fleets (Missions)] Nobody can send one ship (Slaver) - resolved.
- 0000031: [Core] Search limit (Slaver) - resolved.
- 0000038: [Core] Resource bug (Slaver) - resolved.
- 0000044: [Core] Invalid argument supplied error in Game Updates Pages (Slaver) - resolved.
- 0000047: [Login] someone has logget in from another PC on your account every 2 minutes (Slaver) - resolved.
- 0000051: [Fleets (Missions)] Fatal error: class.FlyingFleetHandler.php on line 59 (Slaver) - resolved.
- 0000052: [Core] Shortcuts (Slaver) - resolved.
- 0000055: [Fleets (Missions)] Combat Report does not show moon building message (Slaver) - resolved.
- 0000045: [Design] Screenshots not shown by IE8/IE9 by FF it works (Slaver) - resolved.
- 0000050: [Core] Wrong redirect (Slaver) - resolved.
- 0000049: [Core] Encoding banner (Slaver) - resolved.
',
'v1.5' => 'Jan 18.09.11
- FIX: REMOTE FILE INCLUSION VULNERABILITY
- ADD: Timezone Support
- FIX: Fleetspeed Bonus
- FIX: Messafe Notfiy
- FIX: Hall of Fame Mulituniverse glitch
- FIX: delete messages in IE
- FIX: planetmenu cookie
- FIX: PHP errors in chatsystem
- FIX: Iusses with Special Char on alliance request 
- FIX: Fleettime, if acs mission was cancel
- FIX: clear planets after spy
- FIX: little template iusses
- FIX: SQL Error on FleetBack, if fleet is on a acs
- FIX: JS Error on Combat Raports
- FIX: Cron on statbuilder, who deletes raports
- FIX: Cross universe glitch on acs invations (StoNelHa) 
. FIX: Case 6 on Expedition 
- DIV: Sicherheit im Game erhöht
- DIV: rootID now in constants
- DIV: Added Suhosin detection 
- DIV: Updated Smarty & TS Libs
- DIV: Diverse Anpassungen am Game
- 0000024: [Login] On email activation users cann´t register (Slaver) - resolved.
- 0000046: [Core] referals in overview (Slaver) - resolved.
- 0000042: [Core] referrals name (Slaver) - resolved.
- 0000034: [Design] IE8 / IE9 changelog and menu-top.png not shown (Slaver) - resolved.
- 0000030: [Core] Phalanx not work after update, says error (Slaver) - resolved.
- 0000025: [Time (offset errors)] Timezone [not resolved 2030] (Slaver) - resolved.
- 0000035: [Core] after last update to 2043 (Slaver) - resolved.
- 0000037: [Fleets (Missions)] Flotten Hängen sich auf!! (Slaver) - resolved.
- 0000003: [EcoSystem] Time of building of the ships (Slaver) - resolved.
- 0000033: [Design] Rules werden auch in Deutsch nicht angezeigt (Slaver) - resolved.
- 0000013: [EcoSystem] Rev. 2033 (Slaver) - resolved.
- 0000029: [Core] After rev 2039 crash error on email (Slaver) - resolved.
- 0000001: [Core] Display error message, if register fails (Slaver) - resolved.
- 0000006: [Core] Error.log (Slaver) - resolved.
- 0000023: [Fleets (Missions)] Rev. 2037 Mission destruction (Slaver) - resolved.
- 0000021: [Core] Timezone (Slaver) - resolved.
- 0000019: [Core] Information ACP Page (Slaver) - resolved.
- 0000008: [Core] Research Always Refresh (Slaver) - resolved.
- 0000005: [Core] Rockets (Slaver) - resolved.
- 0000004: [Core] Free fields (Slaver) - resolved.
- 0000007: [Core] Free fields again (Slaver) - resolved.
- 0000015: [Core] Rev. 2033 Silo (Slaver) - resolved.
- 0000014: [Design] Anzeige von Energie bei IE8 defekt (Slaver) - resolved.
- 0000011: [Chat] Portuguese chat don´t work (Slaver) - resolved.
- 0000010: [EcoSystem] Demolish a level (Slaver) - closed.
',
'v1.4' => 'Jan 10.07.11
- ADD: FirePHP Log System
- ADD: Language selectable on Global Messages
- ADD: New Message System (includes old global message system like another XNova versions)
- ADD: {lang} Block for tpls. Directly access to langvars with {lang}varname{/lang}
- ADD: More dynamic for new languages
- FIX: Ressource Cheat
- FIX: Multiply Messages
- FIX: Forgotten password
- FIX: Defender bonus on combats
- FIX: Fixed Register on large Unis
- FIX: Redirect on Messages
- FIX: Unable to send recylers to vacation players
- FIX: Cencored coors on hall of frame know correctly
- FIX: Fixed not correct calculaton of DM extras on destruction
- FIX: Chat
- FIX: Fixed incorrect display of reycler fleets
- FIX: Fixed Servertime are not localize
- FIX: MaxElemens for shields &amp; missiles
- FIX: wrong padding for leftmenu
- FIX: Moduls after a fresh installation
- FIX: search
- FIX: Fixed Register on lange Unis
- FIX: cancel researches
- FIX: UTF8 names on fleet shortcuts
- FIX: galaxy messages
- FIX: Deactive modules are not visible on galaxy
- FIX: Multiply load cache files
- FIX: Wrong datatype for lage numbers
- FIX: Wrong Queue display, if 2 elements with same level in there
- FIX: Bypass module check on spy and recyle
- DIV: Refresh database design
- DIV: Old Popups for Playercard &amp; Messages
- DIV: Includes Smarty
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',
'v1.3.5' => 'Jan 11.06.11
- ADD: New ChatSystem
- ADD: New Popup UI
- ADD: Refferalsystem
- ADD: Destroy Rocket
- ADD: Wellformed URLs on Bulidsides
- ADD: Solarsat on Moon give now energy
- FIX: Correct Calculation of maximum amount rockets
- FIX: Division by Zero
- FIX: Wrong TotalUsercount, if a new User join the Game
- FIX: Shipyard Iusses, with BCMath is not avalible
- FIX: reCAPTCHA
- FIX: Incoming Recylcer Fleet, where display on overview &amp; phalanx
- FIX: Facebook Login
- FIX: Universe Import/Export
- FIX: Disapier Ships
- FIX: Short Names on Combat Reports
- FIX: Queues
- FIX: $_SESSION[&quot;uni&quot;] = 0, after leave Admin Panel
- FIX: Grap Debris from Fleetmenu
- DEL: Spanish &amp; French Language
- DIV: set correct favicon Metatag
- DIV: Moonsize Calculation
- DIV: Added Bonus Maxfields on Planets (AccountEditor)
- DIV: Added missed language keys
- DIV: Improved request_vars
- DIV: Rewrite LoginPage
- DIV: Improved Javascript Code
- DIV: MultiUniverse Support
- DIV: Rewrite UpdateSystem
- DIV: Change Copyright Header
- DIV: Rewrite Connect wit Facebook
- DIV: Update Smarty and jQuery
- DIV: Remove Soundmanager and overLIB Liberary
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',
'v1.3' => 'Jan 05.03.11
- ADD: MultiUniverse Support
- ADD: IPv6 Support
- ADD: Limit of max Colony
- ADD: Template Cache System
- ADD: Daily Cronjob for clear Cache
- ADD: Fleettrader
- ADD: SessionSystem
- ADD: AdminHack Protection
- ADD: FTP Service on Installer to solved the CHMOD Problems
- ADD: New Chat System
- ADD: Cyrillic Char support for UserBanner
- FIX: Facebook Connector
- FIX: ACS
- FIX: SQL Injections on FleetsShoutcuts
- FIX: XSS on Battlesim
- FIX: TF Iusses
- FIX: UpdateSystem
- FIX: Ressource Cheat
- FIX: Admin Attack
- FIX: SSL on IIS
- FIX: Admin on Records
- FIX: Noobprotection for Holding Mission
- FIX: BattleReports show correct Techs now
- FIX: ResetPage
- FIX: Updated Ressource on TargetPlanet on Attacks
- FIX: Fleetspeed Hack
- FIX: BuildTime Hack
- FIX: Cache System
- FIX: Moondestruction
- FIX: Teamspeak API for Teamspeak 3 Servers
- FIX: UpdateSystem dont donwload same Files now
- DIV: 2Moons not longer require safe_mode = off
- DIV: Change Copyright Header
- DIV: Max Buttons on Jumpgate
- DIV: OfficiersVars now on vars.php
- DIV: Fleet Ressoucres go up tp 18.446.744.073.709.551.616
- DIV: Allow Change Version on ACP
- DIV: Get Language via HTTP Header on Index
- DIV: Use Facebooks new Graph API now.
- DIV: Set new location for error.log
- DIV: Update TS³ Lib, Soundmanager, reCAPTCHA Lib, Smarty and jQuery (UI)
',
'v1.2' => 'Jan 04.10.10
- ADD: Set Max Fleets on ACS (Default: 16)
- ADD: New RightsSystem on ACP
- ADD: .htaccess Protection for some dirs
- FIX: Expedition
- FIX: Servertime at Overview
- FIX: Research Hack while Build ID:6 or 31
- FIX: Alliance Exit
- FIX: See not invited ACS
- FIX: overLIB Problems with Internet Explorer
- FIX: Multilanguages Iusses
- FIX: reCAPTCHA
- FIX: Admin Protection
- FIX: Moon Creation Explod
- FIX: Rights on Alliance
- FIX: Jumpgate
- FIX: Build Points
- FIX: Some HTML Errors
- FIX: Linebreaks on Alliance Rundmails
- FIX: UMode
- DIV: Update Langauges
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',
'v1.1' => 'Jan 31.08.10
- ADD: GoW Skin
- ADD: Mod Versions Control
- ADD: Cronjoboption für Banner
- ADD: Options for Loginmusic
- FIX: Anzeigefehler in Raports
- FIX: Ressoucre Hack
- FIX: Fleet Bugs
- DEL: Unused Pictures
- DIV: Optimized CSS
- DIV: Changed HTML Tree (Changed td.c to th / th to td)
- DIV: Update to HTML 5
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',
'v1.0' => 'Jan 07.08.10
- FIX: Global Messages
- FIX: Forgotten Password
- FIX: Gamereset
- FIX: Ressouce Glitch
- FIX: Accout Informationen
- FIX: Destroying Fleet after Fights
- FIX: User Activation on ACP
- FIX: Account delection
- FIX: Bonusspeed for small cargo
- FIX: Recycling Derbis
- FIX: Message delection on ACP
- FIX: Modules on English language
- FIX: UpdatePage
- FIX: class.ShowShipyardPage.php on line 43: Division by zero
- DIV: Limited Random on Dm Mission
- DIV: Changed System of Rapidfire
- DIV: Solved Problems with BattleSimulator
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',
'RC6' => 'Jan 28.07.10
- ADD: Russian Language (ssAAss &amp; InquisitorEA)
- ADD: Portuguese Language (morgado)
- ADD: Spanish Language (ZideN) ALPHA (!)
- FIX: UTF-8 Support for Buddy Requests
- FIX: Messages Notify
- FIX: Phalanx
- FIX: Installer
- FIX: Trümmerfeld bei Mondangriffen
- FIX: Trümmerfeldabbau
- FIX: Ressourcenberechnung bei Angriffen
- FIX: Mondzerstörung
- DIV: Neue Loginmusik
- DIV: Removeold Settings
- DIV: Recoding ACP
- DIV: Optimized CSS for Login
- DIV: zlib.output_compression wird statt ob_gzhandler genutzt
- DIV: Change Path for reCAPTCHA AJAX
- DIV: Remove old UGamla Functions
- DIV: Sicherheit im Game erhöht
- DIV: Include New Version of Soundmanager (2.96a.20100624)
- DIV: Update Smarty Engine
- DIV: Diverse Anpassungen am Game
',
'RC5.1' => 'Jan 23.06.10
- ADD: Für Halten muss man in der Ally/Buddy sein
- ADD: Name des HP bei der Reg.
- ADD: Passwort Abfrage bei Authlevel/Reset
- FIX: Flottenverluste
- FIX: AKW, wenn keine Deuterium vorhanden ist
- FIX: reCAPTCHA wird beim Direkt Link nicht geladen
- FIX: Englische VaildMail
- FIX: IRaks
- FIX: Langauge Select beim Registieren
- FIX: Koloniename
- FIX: UMode
- FIX: Admin Hack via Facebook
- FIX: Flottenrückkehr
- FIX: Nachrichten Transport
- FIX: Forschung
- FIX: Phalax
- FIX: Steal
- FIX: BuildQueue
- FIX: Install
- FIX: Forschungen
- DIV: Mienen auf 100% nach UMode
- DIV: Full MultiLangauge Support
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',
'RC5.0' => 'Jan 30.05.10
- ADD: Neue Schiffe
- ADD: Support Planet in System != 15
- ADD: Cookie für LoginMusik
- ADD: Check für verfügbare Missions in Fleet3
- ADD: Multi-Lang Installer
- ADD: Kampfsimulator
- ADD: bcmath for JS
- DEL: PluginSystem
- FIX: View Database Logindata, if connections problems to database.
- FIX: Dublicate Ressis Bug
- FIX: Bewerbungstext
- FIX: Support
- FIX: Mondzerstörung
- FIX: Flotten
- FIX: Gebäude Cheat
- FIX: Resource Bug
- FIX: Shipyard supports now Trillion \'Build per Row\'
- FIX: Darmatter Kosten bei Verteidigung
- FIX: Mood Löschung
- FIX: Intergal. Netzwerk
- FIX: class.FlyingFleetMissions.php on 1183:SQL Error (Duplicate entry \'Key\' for key \'rid\')
- FIX: Bauzeiten, wenn Gebäude nicht baubar war
- FIX: Gebäude mit 0 Sekunden Bauzeit
- FIX: Allianzstatistik
- FIX: SQL Injection in Notizen, Nachrichten un Fleet Shoutcuts
- FIX: Große TF`s
- FIX: Evo Trans. &amp; Gigarec.
- FIX: Große HoF KBs
- FIX: GebäudeCheat
- FIX: Statistiken Fehler bei neuen Spielern
- DIV: Use IE7-js for IE CSS Fixs
- DIV: Use Googles Host for jQuery JS
- DIV: Updatet TS 3 Lib
- DIV: Flottenquery vereinfacht
- DIV: Sicherheit im Game erhöht
- DIV: Leftmenu
- DIV: Diverse Anpassungen am Game
',

'RC5.0b8' => 'Jan 20.04.10
- FIX: Bann
- FIX: Unmarkierte Nachrichten Löschen
- FIX: Query log
- FIX: Steal
- FIX: Aktivitätstern
- FIX: Planetenerstellung im ACP
- FIX: Sprungtor
- FIX: Ress up to 9e132
- FIX: BBCodes
- FIX: Lost Ressis
- FIX: Install
- DIV: AddBuildingToQueue überarbeitet
- DIV: Sicherheit im Game erhöht
- DIV: min. Requieres PHP 5.2.6
- DIV: Diverse Anpassungen am Game
',

'RC5.0b7' => 'Jan 16.04.10
- ADD: Google Analytics Mod
- FIX: max Button, if thousend Sep is not "."
- FIX: Große Transporte
- FIX: Globale Nachrichten
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',

'RC5.0b6' => 'Jan 15.04.10
- ADD: Updated ACP (XG Proyecto 2.9.4)
- ADD: Facebook Connector Alpha
- ADD: Diplomatie-System
- ADD: Gigarecyler on Galaxy
- ADD: Ori. Platform, Spalteinreißer, Bahamut
- ADD: Händlergebühren
- ADD: Universität
- ADD: Konstanten für Mondentstehung
- ADD: Download Patch Files in ACP
- ADD: Locale Settings in Language File
- FIX: Trader
- FIX: Ressverlust bei hohen Zahlen.
- FIX: Galaxy
- FIX: Spioangeabwehr
- FIX: Aliianz Übergeben
- FIX: Minus-Werte bei NPC`s in Expeditions Kämpfen
- FIX: Allianz Hack
- FIX: UMode
- FIX: Sprungtor
- FIX: BuildQuere
- FIX: Aktivitäts Stern
- FIX: Playercard
- FIX: General
- FIX: AKS-Stealberechnung
- FIX: Negative Rückflugzeit bei AKS-Einheiten
- FIX: Rohstoffberechnung
- FIX: Zeit von Spionageberichten
- FIX: Allianzstatistiken
- FIX: Font-FIX in overLIB
- DIV: Updated ACP
- DIV: Update Smarty to 3.0b8
- DIV: Change Buildsystem für Gebäude/Flotten
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',
'RC5.0b5' => 'Jan 06.03.10
- FIX: Attack
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',
'RC5.0b4' => 'Jan 01.03.10
- ADD: Plugin-System v0.4 (Green @ XG Proyecto)
- ADD: Neu StatBuilder
- FIX: AKS
- DIV: Sicherheit im Game erhöht
- DIV: Diverse Anpassungen am Game
',

'RC5.0b3' => 'Jan 23.02.10
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
'RC5.0b2' => 'Jan 20.02.10
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
'RC5.0b1' => 'Jan 02.02.10
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

'RC4.2' => 'Jan 06.12.09
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

'RC4.1' => 'Jan 23.11.09
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

'RC4' => 'Jan 13.11.09
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
'RC3' => 'Jan 18.10.09
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
'RC2' => 'Jan 13.10.09
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