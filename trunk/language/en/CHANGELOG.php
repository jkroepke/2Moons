<?php

$LNG['Version']     = 'Version';
$LNG['Description'] = 'Description';

$LNG['changelog']   = array(

'v1.3.5' => 'ShadoX 23.04.11
- ADD: New ChatSystem
- ADD: New Popup UI
- ADD: Refferalsystem
- ADD: Destroy Rocket
- FIX: Correct Calculation of maximum amount rockets
- FIX: Division by Zero
- FIX: Wrong TotalUsercount, if a new User join the Game
- FIX: Shipyard Iusses, with BCMath is not avalible
- FIX: reCAPTCHA
- FIX: Incoming Recylcer Fleet, where display on overview &amp; phalanx
- FIX: Facebook Login
- FIX: Universe Import/Export
- FIX: Disappear Ships
- FIX: Short Names on Combat Reports
- FIX: Queues
- FIX: $_SESSION["uni"] = 0, after leave Admin Panel
- FIX: Grap Debris from Fleetmenu
- DEL: Spanish &amp; French Language
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
- DIV: Increased security in the Game
- DIV: Various adjustments to the Game
',

'v1.3' => 'ShadoX 05.03.11
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

'v1.2' => 'ShadoX 14.09.10
- ADD: Set Max Fleets on ACS (Default: 16)
- ADD: New RightsSystem on ACP
- ADD: .htaccess Protection for some dirs
- FIX: Expedition
- FIX: Servertime at Overview
- FIX: Research Hack while Build ID:6 or 31
- FIX: Alliance Exit
- FIX: See not invited ACS
- FIX: OverLIB Problems with Internet Explorer
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
- DIV: Security increased in the Game
- DIV: Various adjustments to the Game
',

'v1.1' => 'ShadoX 31.08.10
- ADD: GoW skin
- ADD: Mod Version Control
- ADD: Cronjob option Banner
- ADD: Options for Login Music
- FIX: Error in raport
- FIX: Ressoucre Hack
- FIX: Fleet Bugs
- DEL: Unused Pictures
- DIV: Optimized CSS
- DIV: Changed HTML Tree (Changed td.c to th / th to td)
- DIV: Update to HTML 5
- DIV: Security increased in the Game
- DIV: Other adjustments to the Game
',

'v1.0' => 'ShadoX 07.08.10
- FIX: Global Messages
- FIX: Forgotten Password
- FIX: Game Reset
- FIX: Ressouce Glitch
- FIX: Accout information
- FIX: Destroying Fleet after Fights
- FIX: User Activation on ACP
- FIX: Delection Account
- FIX: Speed bonus for small cargo
- FIX: Recycling Derbi
- FIX: Message delection on ACP
- FIX: Modules on English language
- FIX: Update page
- FIX: class.ShowShipyardPage.php on line 43: Division by zero
- DIV: Limited Random on Dm Mission
- DIV: Changed System of Rapid Fire
- DIV: Solved problem with battle simulator
',

'RC6' => 'ShadoX 28.07.10
- ADD: Russian Language (ssAAss & InquisitorEA)
- ADD: Portuguese Language (morgado)
- ADD: Spanish Language (cides) ALPHA (!)
- FIX: UTF-8 support for Buddy Requests
- FIX: Message Notify
- FIX: Phalanx
- FIX: Installer
- FIX: Ruins by moon attack
- FIX: Debris field decay
- FIX: Resource Calculation in attacks
- FIX: Moon Destruction
- DIV: New Login Music
- DIV: Remove old Settings
- DIV: Recoding ACP
- DIV: CSS Optimized for Login
- DIV: Is used instead ob_gzhandler zlib.output_compression
- DIV: Change Path for reCAPTCHA AJAX
- DIV: Remove old UGamla Functions
- DIV: Security increased in the Game
- DIV: Include New Version of Sound Manager (2.96a.20100624)
- DIV: Update Smarty Engine
- DIV: Other adjustments to the Game
',

'RC5.1' => 'ShadoX 23.06.10
- ADD: For holding one must be in the Ally / Buddy
- ADD: Name of HP in the Reg
- ADD: Forgot your query at Authlevel / Reset
- FIX: Fleet losses
- FIX: Nuclear power, if no deuterium is present
- FIX: reCAPTCHA is the direct link does not load
- FIX: Mail validation
- FIX: Iraq
- FIX: Langauge Select the Regis animals
- FIX: Colony Name
- FIX: VMod
- FIX: Admin Hack via Facebook
- FIX: Fleet Return
- FIX: Message Transport
- FIX: Research
- FIX: Phalax
- FIX: Steal
- FIX: Build queue
- FIX: Install
- FIX: Research
- DIV: Mines on 100% after VMod
- DIV: Full multi langauge support
- DIV: Security increased in the Game
- DIV: Other adjustments to the Game
',

'RC5.0' => 'ShadoX 30.05.10
- ADD: New Boats
- ADD: Support planet in system = 15!
- ADD: Login cookie for music
- ADD: Check for availability of mission in Fleet3
- ADD: Multi-Lang Installer
- ADD: Combat Simulator
- ADD: Bcmath for JS
- DEL: Plugin system
- FIX: Database View Log Data, if connections to database problems.
- FIX: Bug Dublicate Ressis
- FIX: Application text
- FIX: Support
- FIX: Moon Destruction
- FIX: Fleet
- FIX: Building Cheat
- FIX: Bug Resource
- FIX: Now supports Shipyard trillion
- FIX: Darmatter costs of defense
- FIX: Mood deletion
- FIX: Integral. Network
- FIX: class.FlyingFleetMissions.php on 1183: SQL Error
- FIX: Build times, when building was unbuildable
- FIX: Building construction, with 0 seconds
- FIX: Allianz Statistics
- FIX: SQL Injection in notes, messages, un Fleet Shoutcuts
- FIX: Large TF
- FIX: Evo Trans & GigaRec.
- FIX: Large HoF KBs
- FIX: Building cheat
- FIX: Error statistics for new players
- DIV: Use IE7-js for IE CSS Fix
- DIV: Use Google host for jQuery JS
- DIV: Lib Updatet TS 3
- DIV: Query simplified fleet
- DIV: Security increased in the Game
- DIV: LeftMenu
- DIV: Other adjustments to the Game
',

'RC5.0b8' => 'ShadoX 20.04.10
- FIX: Ban
- FIX: Deleting messages Unlabeled
- FIX: Query log
- FIX: Steal
- FIX: Activity Star
- FIX: Planetary creation in ACP
- FIX: Jumpgate
- FIX: Ress up to 9e132
- FIX: BBCodes
- FIX: Lost Ressis
- FIX: Install
- DIV: AddBuildingToQueue revised
- DIV: Security increased in the Game
- DIV: min. Requiere PHP 5.2.6
- DIV: Other adjustments to the Game
',

'RC5.0b7' => 'ShadoX 16.04.10
- ADD: Google Analytics Mod
- FIX: Max button if thousend September is not "."
- FIX: Large transport
- FIX: Global news
- DIV: Security increased in the Game
- DIV: Other adjustments to the Game
',

'RC5.0b6' => 'ShadoX 15.04.10
- ADD: Updated ACP (XG Proyecto 2.9.4)
- ADD: Facebook Connector Alpha
- ADD: Diplomacy System
- ADD: Gigarecyler on Galaxy
- ADD: Ori. Platform sensational column, bahamut
- ADD: Dealer fees
- ADD: University
- ADD: Constants for moon formation
- ADD: Download patch files for ACP
- ADD: Locale settings in Language File
- FIX: Trader
- FIX: Ressourses loss at high speeds.
- FIX: Galaxy
- FIX: Spy report
- FIX: Aliiance Pass
- FIX: Negative values for NPCs in struggle Expeditions
- FIX: Alliance Hack
- FIX: VMod
- FIX: Jumpgate
- FIX: Build transverse
- FIX: Activity Star
- FIX: Player Card
- FIX: General
- FIX: AKS-Steal calculation
- FIX: Negative return flight time at ACS units
- FIX: Resource Calculation
- FIX: Time of spy reports
- FIX: Alliance Statistics
- FIX: Font-FIX in overLIB
- DIV: Updated ACP
- DIV: Update Smarty to 3.0b8
- DIV: Change build system for buildings / fleets
- DIV: Security increased in the Game
- DIV: Other adjustments to the Game
',

'RC5.0b5' => 'ShadoX 06.03.10
- FIX: Attack
- DIV: Security increased in the Game
- DIV: Other adjustments to the Game
',

'RC5.0b4' => 'ShadoX 01.03.10
- ADD: Plugin System v0.4 (Green @ XG Proyecto)
- ADD: New StatBuilder
- FIX: AKS
- DIV: Security increased in the Game
- DIV: Other adjustments to the Game
',

'RC5.0b3' => 'ShadoX 23.02.10
- ADD: DM bank
- ADD: Coords are no longer displayed in the HoF.
- ADD: Update system BETA
- ADD: Admin faded out in statistics
- ADD: jQuery UI 1.8rc2
- ADD: New Expedition
- FIX: Phalax Interplanetary & Ranges
- FIX: Vacation mode fixed
- FIX: Stop the end of fleets to be counted in spy report.
- FIX: Display of the Moon Destruction Canche
- FIX: Admins in records
- FIX: Planet search
- FIX: New campaign script for Interplanetary impacts
- DIV: Set DB Connection to UTF-8
- DIV: User banner is updated once a day.
- DIV: Website Optimization (YSlow Grande: A / Score: 91)
- DIV: Add header for browser caching
- DIV: Security increased in the Game
- DIV: Other adjustments to the Game
- DIV: Update to jQuery 1.4.2
',

'RC5.0b2' => 'ShadoX 20.02.10
- ADD: Account deletion during the U-mode
- ADD: UTF-8 support for Names
- ADD: Cost dark matter
- ADD: Some long (not complete)
- FIX: Transverse
- FIX: Building demolition
- FIX: Alliance Creation
- FIX: AKS in the Overview
- FIX: AKS-Hack
- FIX: AKS-Distributed Ressis
- FIX: Deuterium calculate, planet temperature
- FIX: Fusion Reactor: bonus from Power Engineering
- FIX: Fixed line wrapping in Global News
- DIV: Update Smarty to 3.0b7
- DIV: Mod user stat adapted to AKS.
- DIV: Optimized Game Messages
- DIV: Typos corrected
- DIV: Security increased in the Game
- DIV: Other adjustments to the Game
',

'RC5.0b1' => 'ShadoX 02.02.10
- NEW: Search-Engine
- NEW: LOGIN
- NEW: Change Name to 2Moons
- ADD: Smarty Template Engine
- ADD: Research in vars.php maximum adjust table
- ADD: FB-share
- ADD: Planet list
- ADD: Teampseak addon: Support Team Speak 3
- ADD: Max jobs in Fleet / Def set (default: 10)
- ADD: Cache for Records
- ADD: Real-Time Ressanzeige
- ADD: Optimize DB Hall of Fame
- ADD: Outbox
- ADD: Demolition Shipyard
- FIX: Economic system
- FIX: Ress - Page
- FIX: DM-study
- FIX: Player Card
- FIX: Memory display in commodities
- FIX: Design
- FIX: Pranger
- FIX: Teamspeak Overview
- FIX: Useramount
- FIX: Spy report, display and response
- FIX: Alliance Chat
- FIX: Bug in TF-genesis moon formation
- FIX: Check planet used fields
- FIX: DeleteSelectedUser
- FIX: Moon TF
- FIX: Integral. Research Network
- FIX: Values for consumption
- FIX: Error Handler
- FIX: U-Mode & Admin protection - Iraq
- FIX: AKS-BUG in the fleet sent back function
- FIX: Fleet flight time
- FIX: CAPTCHA
- FIX: Bug in moon and planetary destruction
- FIX: Recycler return
- FIX: Colonization: Brought Ressis will credit now
- FIX: Liquor consumption
- FIX: SQL gap in FleetAjax.php
- FIX: Planet Distance
- FIX: Various cheats fleet away
- FIX: Magic`s TF
- FIX: ACP-fopen error
- FIX: Opera Style Fix
- FIX: Moon Destruction
- FIX: Add-on modules
- FIX: Support Ticket
- FIX: DM-finding mission
- FIX: Problems with the creation of Home Planet Mauell after the creation of users
- FIX: Alliance members number in AINFO
- FIX: Noob
- FIX: Moon Building
- FIX: Admin Protection
- FIX: Building ships without Shipyard
- FIX: Errors in the preparation KB
- FIX: Forgot your password
- FIX: Change password Nick Name
- FIX: Umlauts in the description
- DIV: New method to call Fleet Handler
- DIV: New Plant Images
- DIV: Increased flexibility to add new building
- DIV: New formula for memory calculation
- DIV: Take the ACP, when flying fleet had an error handler
- DIV: User ACP activation by
- DIV: New formula for Solarsats, deuterium, and number of fields Planettemp
- DIV: Security increased in the Game
- DIV: Other adjustments to the Game
- DIV: Update to jQuery 1.4.1
',

'RC4.2' => 'ShadoX 06.12.09
- ADD: StatBanner
- ADD: Sycrogs robots.txt
- ADD: UserVaild feature set
- FIX: News
- FIX: Officers
- FIX: Vaild-mail Link
- FIX: Messages in return-Subject
- FIX: Global Admin Message
- FIX: SQL gaps in Notes
- FIX: NEWS
- FIX: Fleet speed
- FIX: BeuteMath (by WOT Game)
- FIX: GalaxyMoonRow
- FIX: Mail
- FIX: Alliance Info
- FIX: Lost password
- FIX: Alliance ranks
- FIX: max. Expeditions / max. Holding time
- FIX: User name check at the registration
- FIX: Registration close & Game Close
- FIX: Admin chat page
- FIX: Memory display corrected in commodities
- FIX: Crash Galaxy Allyname
- FIX: Statfunctions.php
- DIV: Mail via SMTP Auth
- DIV: Chat-Class
- DIV: Revision Installer
- DIV: Class Notes
- DIV: Chat Interval set to 10 seconds
- DIV: Security increased in the Game
- DIV: Other adjustments to the Game
',

'RC4.1' => 'ShadoX 23.11.09
- FIX: Moderation-ACP
- FIX: User deletion
- FIX: cronjob.php
- FIX: Mail function
- FIX: ACP-topnav - Error
- FIX: UTF-8 in the ACP
- FIX: Minor SQL vulnerabilities
- DIV: Security increased in the Game
- DIV: Other adjustments to the Game
',

'RC4' => 'ShadoX 13.11.09
- ADD: Fleet / Def to set TF
- ADD: New function request_var, set_var and msg_handler
- ADD: Completely revised ACP (XGP 2.9.1)
- ADD: Flying fleet handler is not called in the login
- ADD: Flying fleet handler is now no longer called 2x
- ADD: New cron job - "Engine"
- ADD: Using PHPMailer v5.1 Lite
- MOD: Database connection now with mysqli
- MOD: AKS-Overview
- MOD: New instant engine based on jQuery
- MOD: Bausch Leif messages a user can be switched off
- MOD: Nutztung of mysqli:: multi_query (5%)
- MOD: $_GET and $_POST replaced by request_var (70%)
- MOD: Uservaris with $ db-> sql_escape (mysqli_real_escape_string) verstzt (80%)
- MOD: New Email Class
- MOD: Construction of the current research / the current building in the title bar
- MOD: Autoload - Function
- FIX: Line breaks in texts Alliance
- FIX: Buddy List
- FIX: Statistics: Number of points up to 18,446,744,073,709,551,616 (Yes, white, useless)
- FIX: Reset universe
- FIX: Espionage attack
- FIX: SQL gap in MissilesAjax.php
- FIX: Anonymous users can not come into play
- FIX: Planetary extinction
- FIX: Resources for Research demolition
- FIX: No 10 Eng for his own gala more
- FIX: Planiliste in ACP
- FIX: (ID: 01)-Building
- FIX: Building with conditions can not be built without assume some
- FIX: Main Planet is now the main planet by default
- FIX: Attack Link to moon espionage reports
- FIX: DM-research mission
- DIV: Moons, galaxy and tables removed
- DIV: Fully converted UTF-8
- DIV: Coords-Linking in the Galaxy Fleets
- DIV: Skin optimization
- DIV: DB-storage type of building and research of int (11) on TINYINT (3) amended unsigned
- DIV: Adapting to Internet Explorer (IE8) & Opera
- DIV: Unnecessary SQL queries (SELECT * FROM) amended
- DIV: register_globals defaults from
- DIV: All tables are now cleaned up 1x per day (OPTIMIZE TABLE)
- DIV: Be compressed or sent to client
- DIV: Alliance Page now controlled by switches
- DIV: Performance Ingal. Network increases
- DIV: Integrated formatCR calculateAttack and flying in the fleet handler now
- DIV: New Registration (XNova Reloaded-0.1)
- DIV: New message management (XNova Reloaded-0.1)
- DIV: New build queue (XNova Reloaded-0.1)
- DIV: Security increased in the Game
- DIV: Various adjustments to the Game
',

'RC3' => 'ShadoX 18.10.09
- ADD: AGB
- ADD: Rules
- ADD: E-mail function validation
- ADD: Database backup
- ADD: Database port selectable
- MOD: Database optimizations
- FIX: Alliance ranks
- FIX: Alliance name change
- FIX: Alliance tag change
- FIX: More than 2,147,483,647 units transported
- FIX: statbuilder.php
- FIX: User deletion
- FIX: Prey during the attack
- FIX: DM Fund for Expedition
- DIV: Steal and old economies reinserted
- DIV: New email text for forgotten password
- DIV: Security increased in the Game
- DIV: W3C Valid (Login)
- DIV: Various adjustments to the Game
',

'RC2' => 'ShadoX 13.10.09
- MOD: Lottery
- MOD: TS-Overview Mod
- MOD: Minimum set of construction
- MOD: Captcha-Mod powered by reCAPTCHA.net
- MOD: News in the Overview / on the home page
- MOD: Hall of Fame + Stats + Player Card Alliance
- MOD: New planets, moon and players lists in the ACP
- MOD: 4 New Vessels (Evolution transporter Gigarecyler, Integral. matter collectors, star destroyer)
- MOD: New Defence (Gravity gun)
- MOD: New mission to rescue DM
- MOD: New economic system
- MOD: Module
- MOD: Supportsystem
- MOD: Records
- FIX: Moon size is calculated correctly
- FIX: Correct Stealberechnung in attack
- FIX: Vulnerability in the Alliance side
- FIX: Fleets are destroyed at the moon on the planet again
- DIV: New default Skin: Darkness&sup2;
- DIV: Game 100% translated in German (thanks to the translated Sycrog ACP)
- DIV: Security increased in the Game
- DIV: Various adjustments to the Game
- DIV: Show the admins who are currently online


Based on XG Proyect 2.8 on 11.10.09
',
);
?>