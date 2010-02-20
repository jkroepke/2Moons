<?php

//SERVER GENERALS
$lang['Metal']								= 'Metal';
$lang['Crystal']							= 'Crystal';
$lang['Deuterium']							= 'Deuterium';
$lang['Darkmatter']							= 'Dark Matter';
$lang['Energy']								= 'Energy';
$lang['Messages']							= 'Messages';
$lang['write_message']						= 'Write Message';

$lang['type_mission'][1]  					= 'Attack';
$lang['type_mission'][2]  					= 'Groupal Attack';
$lang['type_mission'][3]  					= 'Transport';
$lang['type_mission'][4]  					= 'Deploy';
$lang['type_mission'][5]  					= 'Hold Position';
$lang['type_mission'][6]  					= 'Spy';
$lang['type_mission'][7]  					= 'Colonize';
$lang['type_mission'][8]  					= 'Recycle';
$lang['type_mission'][9]  					= 'Destroy';
$lang['type_mission'][15] 					= 'Expedition';

$lang['user_level'] = array (
	'0' => 'Player',
	'1' => 'Moderator',
	'2' => 'Operator',
	'3' => 'Administrator',
);

// GAME.PHP
$lang['see_you_soon']						= 'See you soon!';
$lang['page_doesnt_exist']					= 'The page you requested does not exist';

//SHORT NAMES FOR COMBAT REPORTS
$lang['tech_rc'] = array (
202 => "S. cargo",
203 => "L. cargo",
204 => "F. light",
205 => "F. heavy",
206 => "Cruiser",
207 => "Battleship",
208 => "Col. Ship",
209 => "Recycler",
210 => "Probes",
211 => "Bomber",
212 => "S. Satellite",
213 => "Destroyer",
214 => "Deathstar",
215 => "Battlecru.",
216 => "SuperNova",

401 => "Rocket L.",
402 => "Light L.",
403 => "Heavy L.",
404 => "Gauss C.",
405 => "Ion C.",
406 => "Plasma T.",
407 => "S. Dome",
408 => "L. Dome",
409 => 'P. Protector',
);

//----------------------------------------------------------------------------//
//TOPNAV
$lang['tn_vacation_mode']					= 'Vacation mode active until ';
$lang['tn_delete_mode']						= 'Your account is in erase mode. The same will be deleted the ';

//----------------------------------------------------------------------------//
//LEFT MENU
$lang['lm_overview']						= 'Overview';
$lang['lm_galaxy']							= 'Galaxy';
$lang['lm_empire']							= 'Empire';
$lang['lm_fleet']							= 'Fleet';
$lang['lm_buildings']						= 'Buildings';
$lang['lm_research']						= 'Research';
$lang['lm_shipshard']						= 'Shipyard';
$lang['lm_defenses']						= 'Defense';
$lang['lm_resources']						= 'Resources';
$lang['lm_officiers']						= 'Officers';
$lang['lm_trader']							= 'Merchant';
$lang['lm_technology']						= 'Technology';
$lang['lm_messages']						= 'Messages';
$lang['lm_alliance']						= 'Alliance';
$lang['lm_buddylist']						= 'Buddylist';
$lang['lm_notes']							= 'Notes';
$lang['lm_statistics']						= 'Statistics';
$lang['lm_search']							= 'Search';
$lang['lm_options']							= 'Options';
$lang['lm_banned']							= 'Banned';
$lang['lm_contact']							= 'Contact';
$lang['lm_forums']							= 'Forum';
$lang['lm_logout']							= 'Logout';
$lang['lm_administration']					= 'Administation';
$lang['lm_game_speed']						= 'Game';
$lang['lm_fleet_speed']						= 'Fleets';
$lang['lm_resources_speed']					= 'Resources';
$lang['lm_queues']							= 'Queues';
$lang['lm_topkb']							= 'Hall of Fame';

//----------------------------------------------------------------------------//
//OVERVIEW
$lang['ov_newname_error']					= 'You entered an illegal character. You can only enter alphanumeric characters.';
$lang['ov_planet_abandoned']				= 'Abandoned planet successfully';
$lang['ov_principal_planet_cant_abanone']	= 'You are not able to delete your main planet!';
$lang['ov_abandon_planet_not_possible']		= 'Kolonie nicht l&ouml;schbar, wenn Flottenaktivit&auml;ten zu oder von ihrer Kolonie stattfinden!';
$lang['ov_wrong_pass']						= 'Incorrect password, enter it again.';
$lang['ov_have_new_message']				= 'You have 1 new message';
$lang['ov_have_new_messages']				= 'You have %m new messages';
$lang['ov_free']							= 'Free';
$lang['ov_news']							= 'News';
$lang['ov_place']							= 'Rank';
$lang['ov_of']								= 'of';
$lang['ov_planet']							= 'Planet';
$lang['ov_server_time']						= 'Server time ';
$lang['ov_events']							= 'Events';
$lang['ov_diameter']						= 'Diameter';
$lang['ov_distance_unit']					= 'km';
$lang['ov_temperature']						= 'Temperature';
$lang['ov_aprox']							= 'approx.';
$lang['ov_temp_unit']						= '°C';
$lang['ov_to']								= 'to';
$lang['ov_position']						= 'Position';
$lang['ov_points']							= 'Points';
$lang['ov_security_request']				= 'Security query';
$lang['ov_security_confirm']				= 'Please confirm planet deletion.';
$lang['ov_with_pass']						= 'by entering your password';
$lang['ov_password']						= 'Password';
$lang['ov_delete_planet']					= 'Delete planet!';
$lang['ov_your_planet']						= 'Your planet';
$lang['ov_coords']							= 'Position';
$lang['ov_abandon_planet']					= 'abandon colony';
$lang['ov_planet_name']						= 'Name';
$lang['ov_actions']							= 'Functions';
$lang['ov_planet_rename']					= 'rename';
$lang['ov_planet_rename_action']			= 'rename';
$lang['ov_fields']							= 'fields';
$lang['ov_developed_fields']				= 'unused fields';
$lang['ov_abandon_planet_not_possible']		= 'It\'s not possible abandon a planet where are fleets moving';

//----------------------------------------------------------------------------//
//GALAXY
$lang['gl_no_deuterium_to_view_galaxy']		= 'You don\'t have enough deuterium!';
$lang['gl_legend']							= 'Legend';
$lang['gl_strong_player']					= 'stronger player';
$lang['gl_week_player']						= 'weaker player (newbie)';
$lang['gl_vacation']						= 'Vacation Mode';
$lang['gl_banned']							= 'banned';
$lang['gl_inactive_seven']					= '7 days inactive';
$lang['gl_inactive_twentyeight']			= '28 days inactive';
$lang['gl_s']								= 's';
$lang['gl_w']								= 'n';
$lang['gl_v']								= 'v';
$lang['gl_b']								= 'b';
$lang['gl_i']								= 'i';
$lang['gl_I']								= 'I';
$lang['gl_populed_planets']					= 'planets colonized';
$lang['gl_out_space']						= 'Outer Space';
$lang['gl_avaible_missiles']				= 'missiles available';
$lang['gl_fleets']							= 'fleets';
$lang['gl_avaible_recyclers']				= 'recyclers available';
$lang['gl_avaible_spyprobes']				= 'probes available';
$lang['gl_missil_launch']					= 'Missile Launch';
$lang['gl_missil_to_launch']				= 'Number of missiles (<b>%d</b> left):';
$lang['gl_all_defenses']					= 'All';
$lang['gl_objective']						= 'Objective';
$lang['gl_missil_launch_action']			= 'OK';
$lang['gl_galaxy']							= 'Galaxy';
$lang['gl_solar_system']					= 'System';
$lang['gl_show']							= 'Display';
$lang['gl_pos']								= 'Slot';
$lang['gl_planet']							= 'Planet';
$lang['gl_name_activity']					= 'Name (activity)';
$lang['gl_moon']							= 'Moon';
$lang['gl_debris']							= 'DF';
$lang['gl_player_estate']					= 'Player (status)';
$lang['gl_alliance']						= 'Alliance';
$lang['gl_actions']							= 'Actions';
$lang['gl_spy']								= 'Espionage';
$lang['gl_buddy_request']					= 'Buddy request';
$lang['gl_missile_attack']					= 'Missile attack';
$lang['gl_with']							= ' consisting of ';
$lang['gl_member']							= ' member';
$lang['gl_member_add']						= '(s)';
$lang['gl_alliance_page']					= 'Alliance Page';
$lang['gl_see_on_stats']					= 'Statistics';
$lang['gl_alliance_web_page']				= 'Alliance Homepage';
$lang['gl_debris_field']					= 'Debris field';
$lang['gl_collect']							= 'Harvest';
$lang['gl_resources']						= 'Resources';
$lang['gl_features']						= 'Features';
$lang['gl_diameter']						= 'Diameter';
$lang['gl_temperature']						= 'Temperature';
$lang['gl_phalanx']							= 'Phalanx';
$lang['gl_planet_destroyed']				= 'Planet destroyed';
$lang['gl_player']							= '';
$lang['gl_in_the_rank']						= ' ranked ';
$lang['gl_stat']							= 'Statistics';

//----------------------------------------------------------------------------//
//PHALANX
$lang['px_no_deuterium']					= 'You don\'t have enough deuterium!';
$lang['px_scan_position']					= 'Scan position';
$lang['px_fleet_movement']					= 'Current Fleet Movement';

//----------------------------------------------------------------------------//
//IMPERIUM
$lang['iv_imperium_title']					= 'Empire vision';
$lang['iv_planet']							= 'Planet';
$lang['iv_name']							= 'Name';
$lang['iv_coords']							= 'Coords';
$lang['iv_fields']							= 'Fields';
$lang['iv_resources']						= 'Resources';
$lang['iv_buildings']						= 'Buildings';
$lang['iv_technology']						= 'Technologies';
$lang['iv_ships']							= 'Ships';
$lang['iv_defenses']						= 'Defenses';

//----------------------------------------------------------------------------//
//FLEET - FLEET1 - FLEET2 - FLEET3 - FLEETACS - FLEETSHORTCUTS
$lang['fl_returning']						= 'Returning';
$lang['fl_onway']							= 'En camino';
$lang['fl_r']								= '(R)';
$lang['fl_a']								= '(A)';
$lang['fl_send_back']						= 'Back';
$lang['fl_acs']								= 'ACS';
$lang['fl_no_more_slots']					= 'All fleet slots are being used';
$lang['fl_speed_title']						= 'Speed: ';
$lang['fl_continue']						= 'continue';
$lang['fl_no_ships']						= 'There are no available ships';
$lang['fl_remove_all_ships']				= 'no ships';
$lang['fl_select_all_ships']				= 'all ships';
$lang['fl_fleets']							= 'Fleets';
$lang['fl_expeditions']						= 'Expeditions';
$lang['fl_number']							= 'ID';
$lang['fl_mission']							= 'Mission';
$lang['fl_ammount']							= 'Ships (total)';
$lang['fl_beginning']						= 'Beginning';
$lang['fl_departure']						= 'Departure';
$lang['fl_destiny']							= 'Destiny';
$lang['fl_objective']						= 'Objective';
$lang['fl_arrival']							= 'Arrival';
$lang['fl_order']							= 'Order';
$lang['fl_new_mission_title']				= 'Please select your ships for this mission:';
$lang['fl_ship_type']						= 'Ship Type';
$lang['fl_ship_available']					= 'Available';
$lang['fl_planet']							= 'Planet';
$lang['fl_debris']							= 'Debris';
$lang['fl_moon']							= 'Moon';
$lang['fl_planet_shortcut']					= '(P)';
$lang['fl_debris_shortcut']					= '(D)';
$lang['fl_moon_shortcut']					= '(M)';
$lang['fl_no_shortcuts']					= 'No shortcuts';
$lang['fl_anonymous']						= 'Anonymous';
$lang['fl_shortcut_add_title']				= 'Name [Galaxy / System / Planet]';
$lang['fl_shortcut_name']					= 'Name';
$lang['fl_shortcut_galaxy']					= 'Galaxy';
$lang['fl_shortcut_solar_system']			= 'Solar system';
$lang['fl_clean']							= 'Delete';
$lang['fl_register_shorcut']				= 'Register';
$lang['fl_shortcuts']						= 'Shortcuts';
$lang['fl_reset_shortcut']					= 'Reset';
$lang['fl_dlte_shortcut']					= 'Delete';
$lang['fl_back']							= 'Back';
$lang['fl_shortcut_add']					= 'Add';
$lang['fl_shortcut_edition']				= 'Edit: ';
$lang['fl_no_colony']						= 'No colonies';
$lang['fl_send_fleet']						= 'Send fleet';
$lang['fl_fleet_speed']						= 'Speed';
$lang['fl_distance']						= 'Distance';
$lang['fl_flying_time']						= 'Flying time';
$lang['fl_fuel_consumption']				= 'Fuel consumption';
$lang['fl_max_speed']						= 'Max. speed';
$lang['fl_cargo_capacity']					= 'Cargo capacity';
$lang['fl_shortcut']						= 'Shortcuts';
$lang['fl_shortcut_add_edit']				= '(Add / Edit)';
$lang['fl_my_planets']						= 'My planets';
$lang['fl_acs_title']						= 'Group attack';
$lang['fl_hold_time']						= 'Stay time';
$lang['fl_resources']						= 'Resources';
$lang['fl_max']								= 'max';
$lang['fl_resources_left']					= 'Resources left';
$lang['fl_all_resources']					= 'All resources';
$lang['fl_expedition_alert_message']		= 'Attention! Expeditions are dangerous missions, you can lose your ships!';
$lang['fl_vacation_mode_active']			= 'Vacation mode active';
$lang['fl_expedition_tech_required']		= 'Expedition tech required!';
$lang['fl_expedition_fleets_limit']			= 'Expedition flying fleets limite reached!';
$lang['fl_week_player']						= 'The player is very weak!';
$lang['fl_strong_player']					= 'The player is very strong!';
$lang['fl_in_vacation_player']				= '¡El jugador esta en modo vacaciones!';
$lang['fl_no_slots']						= 'No more slots available';
$lang['fl_empty_transport']					= 'You can not transport 0 resources';
$lang['fl_planet_populed']					= 'This planet is occupied!';
$lang['fl_stay_not_on_enemy']				= 'You can not park fleets on the enemy planets!';
$lang['fl_not_ally_deposit']				= 'No Alliance Depot';
$lang['fl_deploy_only_your_planets']		= 'You can only deploy fleets in your planets!';
$lang['fl_no_enought_deuterium']			= 'You have not enough deuterium. Deuterium Consumption: ';
$lang['fl_no_enought_cargo_capacity']		= 'You do not have enough cargo space! Available:';
$lang['fl_admins_cannot_be_attacked']		= 'Administrators and moderators of this game can not be attacked.';
$lang['fl_fleet_sended']					= 'Fleet sent';
$lang['fl_from']							= 'From';
$lang['fl_arrival_time']					= 'Arrival time';
$lang['fl_return_time']						= 'Return time';
$lang['fl_fleet']							= 'Fllet';
$lang['fl_player']							= 'The player ';
$lang['fl_add_to_attack']					= ' was added to the attack.';
$lang['fl_dont_exist']						= ' was not added to the attack.';
$lang['fl_acs_invitation_message']			= ' invites you to participate in a ACS.';
$lang['fl_acs_invitation_title']			= 'Invitation to acs';
$lang['fl_sac_of_fleet']					= 'ACS fleet';
$lang['fl_modify_sac_name']					= 'Change the name of the ACS';
$lang['fl_members_invited']					= 'Members invited';
$lang['fl_invite_members']					= 'Invite other members';

//----------------------------------------------------------------------------//
//BUILDINGS - RESEARCH - SHIPYARD - DEFENSES
$lang['bd_dismantle']						= 'Deconstruct';
$lang['bd_interrupt']						= 'Interrumpir';
$lang['bd_cancel']							= 'cancel';
$lang['bd_working']							= 'Working';
$lang['bd_build']							= 'build';
$lang['bd_build_next_level']				= 'upgrade level ';
$lang['bd_add_to_list']						= 'Add to list';
$lang['bd_no_more_fields']					= 'No more room on the planet';
$lang['bd_remaining']						= 'Remaining';
$lang['bd_lab_required']					= 'You need to build a research laboratory on this planet first!';
$lang['bd_building_lab']					= 'No se puede investigar cuando se esta ampliando el laboratorio';
$lang['bd_lvl']								= 'level';
$lang['bd_spy']								= ' spy';
$lang['bd_commander']						= ' commander';
$lang['bd_research']						= 'research';
$lang['bd_shipyard_required']				= 'You need to build a shipyard on this planet first!';
$lang['bd_building_shipyard']				= 'No puedes fabricar naves durante la ampliación del hangar';
$lang['bd_available']						= 'Available: ';
$lang['bd_build_ships']						= 'Build';
$lang['bd_protection_shield_only_one']		= 'The shield can be built only once!';
$lang['bd_build_defenses']					= 'Build';
$lang['bd_actual_production']				= 'Actual production:';
$lang['bd_completed']						= 'Completed';
$lang['bd_operating']						= '(Working)';
$lang['bd_continue']						= 'continue';
$lang['bd_ready']							= 'finished';
$lang['bd_finished']						= 'finished';

//----------------------------------------------------------------------------//
//RESOURCES
$lang['rs_amount']							= 'quantity';
$lang['rs_lvl']								= 'level';
$lang['rs_production_on_planet']			= 'Resource production on planet "%s"';
$lang['rs_basic_income']					= 'Basic Income';
$lang['rs_storage_capacity']				= 'Storage Capacity';
$lang['rs_calculate']						= 'calculate';
$lang['rs_sum']								= 'Total:';
$lang['rs_daily']							= 'Res per day:';
$lang['rs_weekly']							= 'Res per week:';

//----------------------------------------------------------------------------//
//OFFICIERS
$lang['of_recruit']							= 'Recruit';
$lang['of_max_lvl']							= 'Maximum level';
$lang['of_available_points']				= 'Available Points:';
$lang['of_points_per_thousand_darkmatter']	= '(1 point for every 1000 of dark matter)';
$lang['of_lvl']								= 'level';

//----------------------------------------------------------------------------//
//TRADER
$lang['tr_only_positive_numbers']			= 'You may only use positive numbers!';
$lang['tr_not_enought_metal']				= 'You do not have enough metal.';
$lang['tr_not_enought_crystal']				= 'You do not have enough crystal.';
$lang['tr_not_enought_deuterium']			= 'You do not have enough deuterium.';
$lang['tr_exchange_done']					= 'Exchange successful';
$lang['tr_call_trader']						= 'Call a dealer';
$lang['tr_call_trader_who_buys']			= 'Call a dealer who buy ';
$lang['tr_call_trader_submit']				= 'Call trader';
$lang['tr_exchange_quota']					= 'The exchange rate is 2/1/0.5';
$lang['tr_sell_metal']						= 'Sales of metal';
$lang['tr_sell_crystal']					= 'Sales of crystal';
$lang['tr_sell_deuterium']					= 'Sales of deuterium';
$lang['tr_resource']						= 'Resource';
$lang['tr_amount']							= 'Quantity';
$lang['tr_quota_exchange']					= 'Exchange rate';
$lang['tr_exchange']						= 'Swap';

//----------------------------------------------------------------------------//
//TECHTREE
$lang['tt_requirements']					= 'Requirements';
$lang['tt_lvl']								= 'level ';

$lang['tech'] = array(
0 => "Buildings",
1 => "Metal Mine",
2 => "Crystal Mine",
3 => "Deuterium Synthesizer",
4 => "Solar Plant",
12 => "Fusion Reactor",
14 => "Robotics Factory",
15 => "Nanite Factory",
21 => "Shipyard",
22 => "Metal Storage",
23 => "Crystal Storage",
24 => "Deuterium Tank",
31 => "Research Lab",
33 => "Terraformer",
34 => "Alliance Depot",
40 => "Lunar Buildings",
41 => "Lunar Base",
42 => "Sensor Phalanx",
43 => "Jump Gate",
44 => "Missile Silo",

100 => "Research",
106 => "Espionage Technology",
108 => "Computer Technology",
109 => "Weapons Technology",
110 => "Shielding Technology",
111 => "Armour Technology",
113 => "Energy Technology",
114 => "Hyperspace Technology",
115 => "Combustion Drive",
117 => "Impulse Drive",
118 => "Hyperspace Drive",
120 => "Laser Technology",
121 => "Ion Technology",
122 => "Plasma Technology",
123 => "Intergalactic Research Network",
124 => "Expedition Technology",
199 => "Graviton Technology",

200 => "Ships",
202 => "Small Cargo",
203 => "Large Cargo",
204 => "Light Fighter",
205 => "Heavy Fighter",
206 => "Cruiser",
207 => "Battleship",
208 => "Colony Ship",
209 => "Recycler",
210 => "Espionage Probe",
211 => "Bomber",
212 => "Solar Satellite",
213 => "Destroyer",
214 => "Deathstar",
215 => "Battlecruiser",
216 => 'SuperNova',

400 => "Defense",
401 => "Rocket Launcher",
402 => "Light Laser",
403 => "Heavy Laser",
404 => "Gauss Cannon",
405 => "Ion Cannon",
406 => "Plasma Turret",
407 => "Small Shield Dome",
408 => "Large Shield Dome",
409 => 'Planet Protector',
502 => "Anti-Ballistic Missiles",
503 => "Interplanetary Missiles",

600 => "Official",
601 => "Geologist",
602 => "Admiral",
603 => "Engineer",
604 => "Technocrat",
605 => "Constructor",
606 => "Scientific",
607 => "Storer",
608 => "Defender",
609 => "Protector",
610 => "Spy",
611 => "Commander",
612 => "Destroyer",
613 => "General",
614 => "Conqueror",
615 => "Emperor",
);

$lang['res']['descriptions'] = array(
1 => "Used in the extraction of metal ore, metal mines are of primary importance to all emerging and established empires.",
2 => "Crystals are the main resource used to build electronic circuits and form certain alloy compounds.",
3 => "Deuterium is used as fuel for spaceships and is harvested in the deep sea. Deuterium is a rare substance and is thus relatively expensive.",
4 => "Solar power plants absorb energy from solar radiation. All mines need energy to operate.",
12 => "Un reactor de fusión nuclear que produce un átomo de helio a partir de dos átomos de deuterio usando una presión extremadamente alta y una elevadísima temperatura.",
14 => "Robotic factories provide construction robots to aid in the construction of buildings. Each level increases the speed of the upgrade of buildings.",
15 => "",
21 => "El hangar es el lugar donde se construyen naves y estructuras de defensa planetaria.",
22 => "Provides storage for excess metal.",
23 => "Provides storage for excess crystal.",
24 => "Giant tanks for storing newly-extracted deuterium.",
31 => "A research lab is required in order to conduct research into new technologies.",
33 => "",
34 => "The alliance depot supplies fuel to friendly fleets in orbit helping with defense.",
41 => "",
42 => "",
43 => "",
44 => "El silo es un lugar de almacenamiento y lanzamiento de misiles planetarios.",

106 => "Usando esta tecnolog&iacute;a, puede obtenerse informaci&oacute;n sobre otros planetas.",
108 => "Cuanto m&aacute;s elevado sea el nivel de tecnolog&iacute;a de computaci&oacute;n, m&aacute;s flotas podr&aacute;s controlar simultaneamente. Cada nivel adicional de esta tecnologia, aumenta el numero de flotas en 1.",
109 => "Este tipo de tecnolog&iacute;a incrementa la eficiencia de tus sistemas de armamento. Cada mejora de la tecnolog&iacute;a militar a&ntilde;ade un 10% de potencia a la base de da&ntilde;o de cualquier arma disponible.",
110 => "La tecnolog&iacute;a de defensa se usa para generar un escudo de part&iacute;culas protectoras alrededor de tus estructuras.
Cada nivel de esta tecnolog&iacute;a aumenta el escudo efectivo en un 10% (basado en el nivel de una estructura dada).",
111 => "Las aleaciones altamente sofisticadas ayudan a incrementar el blindaje de una nave a&ntilde;adiendo el 10% de su fuerza en cada nivel a la fuerza base.",
113 => "Entendiendo la tecnolog&iacute;a de diferentes tipos de energ&iacute;a, muchas investigaciones nuevas y avanzadas pueden ser adaptadas. La tecnolog&iacute;a de energ&iacute;a es de gran importancia para un laboratorio de investigaci&oacute;n moderno.",
114 => "Incorporando la cuarta y quinta dimensi&oacute;n en la tecnolog&iacute;a de propulsi&oacute;n, se puede disponer de un nuevo tipo de motor; que es m&aacute;s eficiente y usa menos combustible que los convencionales.",
115 => "Ejecutar investigaciones en esta tecnolog&iacute;a proporciona motores de combusti&oacute;n siempre m&aacute;s rapido, aunque cada nivel aumenta solamente la velocidad en un 10% de la velocidad base de una nave dada.",
117 => "El sistema del motor de impulso se basa en el principio de la repulsi&oacute;n de part&iacute;culas. La materia repelida es basura generada por el reactor de fusi&oacute;n usado para proporcionar la energ&iacute;a necesaria para este tipo de motor de propulsi&oacute;n.",
118 => "Los motores de hiperespacio permiten entrar al mismo a trav&eacute;s de una ventana hiperespacial para reducir dr&aacute;sticamente el tiempo de viaje. El hiperespacio es un espacio alternativo con m&aacute;s de 3 dimensiones.",
120 => "La Tecnolog&iacute;a l&aacute;ser es un importante conocimiento; conduce a la luz monocrom&aacute;tica firmemente enfocada sobre un objetivo. El da&ntilde;o puede ser ligero o moderado dependiendo de la potencia del rayo...",
121 => "La Tecnolog&iacute;a i&oacute;nica enfoca un rayo de iones acelerados en un objetivo, lo que puede provocar un gran da&ntilde;o debido a su naturaleza de electrones cargados de energ&iacute;a.",
122 => "Las armas de plasma son incluso m&aacute;s peligrosas que cualquier otro sistema de armamento conocido, debido a la naturaleza agresiva del plasma.",
123 => "Los cient&iacute;ficos de tus planetas pueden comunicarse entre ellos a trav&eacute;s de esta red.",
124 => "Las naves son equipadas con equipo cientifico para tomar datos en largas expediciones.",
199 => "A trav&eacute;s del disparo de part&iacute;culas concentradas de gravit&oacute;n se genera un campo gravitacional artificial con suficiente potencia y poder de atracci&oacute;n para destruir no solo naves, sino lunas enteras.",

202 => "Las naves peque&ntilde;as de carga son naves muy &aacute;giles usadas para transportar recursos desde un planeta a otro",
203 => "La nave grande de carga es una versi&oacute;n avanzada de las naves peque&ntilde;as de carga, permitiendo as&iacute; una mayor capacidad de almacenamiento y velocidades m&aacute;s altas gracias a un mejor sistema de propulsi&oacute;n.",
204 => "El cazador ligero es una nave maniobrable que puedes encontrar en casi cualquier planeta. El coste no es particularmente alto, pero asimismo el escudo y la capacidad de carga son muy bajas.",
205 => "El cazador pesado es la evoluci&oacute;n logica del ligero, ofreciendo escudos reforzados y una mayor potencia de ataque.",
206 => "Los cruceros de combate tienen un escudo casi tres veces m&aacute;s fuerte que el de los cazadores pesados y m&aacute;s del doble de potencia de ataque. Su velocidad de desplazamiento est&aacute; tambi&eacute;n entre las m&aacute;s r&aacute;pidas jam&aacute;s vista. ",
207 => "Las naves de batalla son la espina dorsal de cualquier flota militar. Blindaje pesado, potentes sistemas de armamento y una alta velocidad de viaje, as&iacute; como una gran capacidad de carga hace de esta nave un duro rival contra el que luchar.",
208 => "Esta nave proporciona lo necesario para ir a donde ning&uacute;n hombre ha llegado antes y colonizar nuevos mundos.",
209 => "Los recicladores se usan para recolectar escombros flotando en el espacio para reciclarlos en recursos &uacute;tiles.",
210 => "Las sondas de espionaje son peque&ntilde;os droides no tripulados con un sistema de propulsi&oacute;n excepcionalmente r&aacute;pido usado para espiar en planetas enemigos.",
211 => "El Bombardero es una nave de prop&oacute;sito especial, desarrollado para atravesar las defensas planetarias m&aacute;s pesadas.",
212 => "Los sat&eacute;lites solares son simples sat&eacute;lites en &oacute;rbita equipados con c&eacute;lulas fotovoltaicas y transmisores para llevar la energ&iacute;a al planeta. Se transmite por este medio a la tierra usando un rayo l&aacute;ser especial.",
213 => "El destructor es la nave m&aacute;s pesada jam&aacute;s vista y posee un potencial de ataque sin precedentes.",
214 => "No hay nada tan grande y peligroso como una estrella de la muerte aproxim&aacute;ndose.",
215 => "El Acorazado es una nave altamente especializada en la intercepci&oacute;n de flotas hostiles.",
216 => "La SuperNova es la nave más poderosa nunca antes creada, con un gran poder ofensivo que ninguna nave podra resistir a su ataque.",

401 => "El lanzamisiles es un sistema de defensa sencillo, pero barato.",
402 => "Por medio de un rayo l&aacute;ser concentrado, se puede provocar m&aacute;s da&ntilde;o que con las armas bal&iacute;sticas normales.",
403 => "Los l&aacute;sers grandes posee una mejor salida de energ&iacute;a y una mayor integridad estructural que los l&aacute;sers peque&ntilde;os.",
404 => "Usando una inmensa aceleraci&oacute;n electromagn&eacute;tica, los ca&ntilde;ones gauss aceleran proyectiles pesados.",
405 => "Los ca&ntilde;ones i&oacute;nicos disparan rayos de iones altamente energ&eacute;ticos contra su objetivo, desestabilizando los escudos y destruyendo los componentes electr&oacute;nicos.",
406 => "Los ca&ntilde;ones de plasma liberan la energ&iacute;a de una peque&ntilde;a erupci&oacute;n solar en una bala de plasma. La energ&iacute;a destructiva es incluso superior a la del Destructor.",
407 => "La c&uacute;pula peque&ntilde;a de protecci&oacute;n cubre el planeta con un delgado campo protector que puede absorber inmensas cantidades de energ&iacute;a.",
408 => "La c&uacute;pula grande de protecci&oacute;n proviene de una tecnolog&iacute;a de defensa mejorada que absorbe incluso m&aacute;s energ&iacute;a antes de colapsarse.",
409 => "La maxima proteccion para los planetas",
502 => "Los misiles de intercepci&oacute;n destruyen los misiles interplanetarios.",
503 => "Los misiles interplanetarios destruyen los sistemas de defensa del enemigo.",

601 => 'Geologist is an expert in mining and astro crystallography. Attend their equipment in metallurgy and chemistry and is also responsible for interplanetary communications to optimize the use and refinement of raw material throughout the empire.<br><br><strong><font color="lime">+5% de producción. Nivel Máx. 20</font></strong>',
602 => 'The Admiral is an experienced veteran and a skillful strategist. The hardest battle is able to get an idea of the situation and contact their admirals subordinates. A wise emperor could rely on their help during the fighting.<br><br><strong><font color="lime">+5% escudo en naves. Nivel Máx. 20</font></strong>',
603 => 'The Engineer is a specialist in energy management. In peacetime, it increases the energy of all the colonies. In case of attack, ensuring the supply of energy to the cannons, and avoid a possible overload, leading to a reduction in defense lost battle.<br><br><strong><font color="lime">+5% de energia. Nivel Máx. 10</font></strong>',
604 => 'The guild is composed of technocrats authentic genius, and always find that dangerous edge where it all explode into a thousand pieces before they could find an explanation and technology rational. No normal human being ever try to decode the code of a technocrat, with its presence, the researchers modeled the rule.<br><br><strong><font color="lime">+5% velocidad de construcción de naves. Nivel Máx. 10</font></strong>',
605 => 'The constructor has altered their DNA, only one of these men can build an entire city in a short time.<br><br><strong><font color="lime">+10% de rapidez en la construcción de edificios. Nivel Máx. 3</font></strong>',
606 => 'Scientists are part of a guild to concurrent technocrats. They specialize in the improvement of technologies.<br><br><strong><font color="lime">+10% de rapidez en la investigacion. Nivel Máx. 3</font></strong>',
607 => 'Storage is part of the ancient brotherhood of the planet Hsac. His motto is to win the maximum, which is why we need huge storage space. Thus has developed a new storage technique.<br><br><strong><font color="lime">+50% de almacenamiento. Nivel Máx.2</font></strong>',
608 => 'The defender is a member of the imperial army. focus on your job allows you to build a formidable defense in a short period of time.<br><br><strong><font color="lime">+25% de rapidez en la construccion de defensas. Nivel Máx. 2</font></strong>',
609 => 'The guard is part of the imperial army and its goal is to develop technologies that improve the planetary defenses.<br><br><strong><font color="lime">Desbloquea la protección planetaria. Nivel Máx. 1</font></strong>',
610 => 'Spy is an enigmatic person. No one ever saw his true face, the only way would be killed.<br><br><strong><font color="lime">+5 niveles de espionaje. Nivel Máx. 2</font></strong>',
611 => 'The commander is part of the Imperial Army has mastered the art of managing fleets. Your brain can calculate the trajectories of a large number of fleets.<br><br><strong><font color="lime">+3 slots para flotas. Nivel Máx. 3</font></strong>',
612 => 'The destructor is a member of the imperial army without mercy. Slaughter everything that is on its way just for fun. It is currently developing a new method of producing the Death Star.<br><br><strong><font color="lime">2 estrellas al hacer 1. Nivel Máx. 1</font></strong>',
613 => 'The general is a person who has served for many years to the imperial army. manufacturers produce ships faster in its presence.<br><br><strong><font color="lime">+10% de rapidez en los hangares. Nivel Máx. 3</font></strong>',
614 => 'The conqueror is a member of the Army, it has the ability to navigate a particular type of ship that no one else could do or take off.<br><br><strong><font color="lime">Desbloquea la SuperNova. Nivel Máx. 1</font></strong>',
615 => 'The emperor placed under his command available to all officers in the empire, combining their skills to dominate the universe and to become an opponent almost Invensil.<br><br><strong><font color="lime">Desbloquea la destrucción planetaria. Nivel Máx. 1</font></strong>',
);

//----------------------------------------------------------------------------//
//INFOS
$lang['in_jump_gate_done']					= 'The jump gate was used, the next jump can be made in: ';
$lang['in_jump_gate_error_data']			= 'Error, data for the jump are not correct!';
$lang['in_jump_gate_not_ready_target']		= 'The jump gate is not ready on the finish moon, will be ready in ';
$lang['in_jump_gate_doesnt_have_one']		= 'You have no jump gate in the moon!';
$lang['in_jump_gate_already_used']			= 'The jump gate was used, time to recharge its energy: ';
$lang['in_jump_gate_available']				= 'available';
$lang['in_rf_again']    					= 'Rapidfire against';
$lang['in_rf_from']     					= 'Rapidfire from';
$lang['in_level']       					= 'Level';
$lang['in_prod_p_hour'] 					= 'production/hour';
$lang['in_difference']  					= 'Difference';
$lang['in_used_energy'] 					= 'Energy consumption';
$lang['in_prod_energy'] 					= 'Energy Production';
$lang['in_used_deuter']						= 'Deuterium consumption';
$lang['in_range']       					= 'Sensor range';
$lang['in_title_head']  					= 'Information of';
$lang['in_name']        					= 'Name';
$lang['in_struct_pt']   					= 'Structural Integrity';
$lang['in_shield_pt']   					= 'Shield Strength';
$lang['in_attack_pt']   					= 'Attack Strength';
$lang['in_capacity']    					= 'Cargo Capacity';
$lang['in_units']       					= 'units';
$lang['in_base_speed'] 						= 'Base speed';
$lang['in_consumption'] 					= 'Fuel usage (Deuterium)';
$lang['in_jump_gate_start_moon']			= 'Start moom';
$lang['in_jump_gate_finish_moon']			= 'Finish moon';
$lang['in_jump_gate_select_ships']			= 'Use Jump Gate: number of ships';
$lang['in_jump_gate_jump']					= 'Jump';
$lang['in_destroy']     					= 'Destroy:';
$lang['in_needed']      					= 'Requires';
$lang['in_dest_durati'] 					= 'Destruction time';

// -------------------------- MINES ------------------------------------------------------------------------------------------------------//
$lang['info'][1]['name']          			= "Metal Mine";
$lang['info'][1]['description']   			= "Metal is the primary resource used in the foundation of your Empire. At greater depths, the mines can produce more output of viable metal for use in the construction of buildings, ships, defense systems, and research. As the mines drill deeper, more energy is required for maximum production. As metal is the most abundant of all resources available, its value is considered to be the lowest of all resources for trading.";
$lang['info'][2]['name']          			= "Crystal Mine";
$lang['info'][2]['description']   			= "Crystals are the main resource used to build electronic circuits for computers and other electronic circuits and form certain alloy compounds for shields. Compared to the metal production process, the processing of raw crystalline structures into industrial crystals requires special processing. As such, more energy is required to process the raw crystal than needed for metal. Development of ships and buildings, and specialized research upgrades, require a certain quantity of crystals.";
$lang['info'][3]['name']          			= "Deuterium Synthesizer";
$lang['info'][3]['description']   			= "Deuterium is also called heavy hydrogen. It is a stable isotope of hydrogen with a natural abundance in the oceans of colonies of approximately one atom in 6500 of hydrogen (~154 PPM). Deuterium thus accounts for approximately 0.015% (on a weight basis, 0.030%) of all. Deuterium is processed by special synthesizers which can separate the water from the Deuterium using specially designed centrifuges. The upgrade of the synthesizer allows for increasing the amount of Deuterium deposits processed. Deuterium is used when carrying out sensor phalanx scans, viewing galaxies, as fuel for ships, and performing specialized research upgrades.";

// -------------------------- ENERGY ----------------------------------------------------------------------------------------------------//
$lang['info'][4]['name']          			= "Solar Plant";
$lang['info'][4]['description']   			= "Gigantic solar arrays are used to generate power for the mines and the deuterium synthesizer. As the solar plant is upgraded, the surface area of the photovoltaic cells covering the planet increases, resulting in a higher energy output across the power grids of your planet.";
$lang['info'][12]['name']         			= "Fusion Reactor";
$lang['info'][12]['description']  			= "In fusion power plants, hydrogen nuclei are fused into helium nuclei under enormous temperature and pressure, releasing tremendous amounts of energy. For each gram of Deuterium consumed, up to 41,32*10^-13 Joule of energy can be produced; with 1 g you are able to produce 172 MWh energy.<br><br>Larger reactor complexes use more deuterium and can produce more energy per hour. The energy effect could be increased by researching energy technology.<br><br>The energy production of the fusion plant is calculated like that:<br>30 * [Level Fusion Plant] * (1,05 + [Level Energy Technology] * 0,01) ^ [Level Fusion Plant]";

// -------------------------- BUILDINGS ----------------------------------------------------------------------------------------------------//
$lang['info'][14]['name']         			= "Robotics Factory";
$lang['info'][14]['description']  			= "The Robotics Factory primary goal is the production of State of the Art construction robots. Each upgrade to the robotics factory results in the production of faster robots, which is used to reduce the time needed to construct buildings.";
$lang['info'][15]['name']         			= "Nanite Factory";
$lang['info'][15]['description']  			= "A nanomachine, also called a nanite, is a mechanical or electromechanical device whose dimensions are measured in nanometers (millionths of a millimeter, or units of 10^-9 meter). The microscopic size of nanomachines translates into higher operational speed. This factory produces nanomachines that are the ultimate evolution in robotics technology. Once constructed, each upgrade significantly decreases production time for buildings, ships, and defensive structures.";
$lang['info'][21]['name']         			= "Shipyard";
$lang['info'][21]['description']  			= "The planetary shipyard is responsible for the construction of spacecraft and defensive mechanisms. As the shipyard is upgraded, it can produce a wider variety of vehicles at a much greater rate of speed. If a nanite factory is present on the planet, the speed at which ships are constructed is massively increased.";
$lang['info'][22]['name']         			= "Metal Storage";
$lang['info'][22]['description']  			= "This storage facility is used to store metal ore. Each level of upgrading increases the amount of metal ore that can be stored. If the storage capacity is exceeded, the metal mines are automatically shut down to prevent a catastrophic collapse in the metal mine shafts.";
$lang['info'][23]['name']         			= "Crystal Storage";
$lang['info'][23]['description']  			= "Raw crystal is stored in this building. With each level of upgrade, it increases the amount of crystal can be stored. Once the mines output exceeds the storage capacity, the crystal mines automatically shut down to prevent a collapse in the mines.";
$lang['info'][24]['name']         			= "Deuterium Tank";
$lang['info'][24]['description']  			= "The Deuterium tank is for storing newly-synthesized deuterium. Once it is processed by the synthesizer, it is piped into this tank for later use. With each upgrade of the tank, the total storage capacity is increased. Once the capacity is reached, the Deuterium Synthesizer is shut down to prevent the tanks rupture.";
$lang['info'][31]['name']         			= "Research Lab";
$lang['info'][31]['description']  			= "An essential part of any empire, Research Labs are where new technologies are discovered, and older technologies are improved upon. With each level of the Research Lab constructed, the speed in which new technologies are researched is increased, while also unlocking newer technologies to research. In order to conduct research as quickly as possible, research scientists are immediately dispatched to the colony to begin work and development. In this way, knowledge about new technologies can easily be disseminated throughout the empire.";
$lang['info'][33]['name']         			= "Terraformer";
$lang['info'][33]['description']  			= "With the ever increasing mining of a colony, a problem arose. How can we continue to operate at a planets capacity and still survive? The land is being mined out and the atmosphere is deteriorating. Mining a colony to capacity can not only destroy the planet, but may kill all life on it. Scientists working feverishly discovered a method of creating enormous land masses using nanomachines. The Terraformer was born.<br><br>Once built, the Terraformer cannot be torn down.";
$lang['info'][34]['name']         			= "Alliance Depot";
$lang['info'][34]['description']  			= "The alliance depot supplies fuel to friendly fleets in orbit helping with defense. For each upgrade level of the alliance depot, 10,000 units of deuterium per hour can be sent to an orbiting fleet.";
$lang['info'][41]['name']         			= "Lunar Base";
$lang['info'][41]['description']  			= "Since a moon has no atmosphere and is an extremely hostile environment, a lunar base must first be built before the moon can be developed. The Lunar Base provides oxygen, heating, and gravity to create a living environment for the colonists. With each level constructed, a larger living and development area is provided within the biosphere. With each level of the Lunar Base constructed, three fields are developed for other buildings. <br>Once built, the lunar base can not be torn down.";
$lang['info'][42]['name']         			= "Sensor Phalanx";
$lang['info'][42]['description']  			= "Utilizing high-resolution sensors, the Sensor Phalanx first scans the spectrum of light, composition of gases, and radiation emissions from a distant world and transmits the data to a supercomputer for processing. Once the information is obtained, the supercomputer compares changes in the spectrum, gas composition, and radiation emissions, to a base line chart of known changes of the spectrum created by various ship movements. The resulting data then displays activity of any fleet within the range of the phalanx. To prevent the supercomputer from overheating during the process, it is cooled by utilizing 5k of processed Deuterium. To use the Phalanx, click on any planet in the Galaxy View within your sensors range.";
$lang['info'][43]['name']         			= "Jump Gate";
$lang['info'][43]['description']  			= "A Jump Gate is a system of giant transceivers capable of sending even the largest fleets to a receiving Gate anywhere in the universe without loss of time. Utilizing technology similar to that of a Worm Hole to achieve the jump, deuterium is not required. A recharge period of one hour must pass between jumps to allow for regeneration. Transporting resources through the Gate is not possible.";
$lang['info'][44]['name']         			= "Missile Silo";
$lang['info'][44]['description']  			= "When Earth destroyed itself in a full scale nuclear exchange back in the 21st century, the technology needed to build such weapons still existed in the universe. Scientists all over the universe worried about the threat of a nuclear bombardment from a rogue leader. So it was decided to use the same technology as a deterrent from launching such a horrible attack.<br><br> Missile silos are used to construct, store and launch interplanetary and anti-ballistic missiles. With each level of the silo, five interplanetary missiles or ten anti-ballistic missiles can be stored. Storage of both Interplanetary missiles and Anti-Ballistic missiles in the same silo is allowed.";

// -------------------------- TECHNOLOGY ----------------------------------------------------------------------------------------------------//
$lang['info'][106]['name']        			= "Espionage Technology";
$lang['info'][106]['description'] 			= 'Espionage Technology is your intelligence gathering tool. This technology allows you to view your targets resources, fleets, buildings, and research levels using specially designed probes. Launched on your target, these probes transmit back to your planet an encrypted data file that is fed into a computer for processing. After processing, the information on your target is
then displayed for evaluation.<br><br> With Espionage Technology, the level of your technology to that of your target is critical. If your target has a higher level of Espionage Technology than you, you will need to launch more probes to gather all the information on your target. However this runs the great risk of detection by your target, resulting in the probes destruction. However, launching too few probes will result in missing information that is most critical, which could result in the total destruction of your fleet if an attack is launched.<br><br>At certain levels of Espionage Technology research, new attack warning systems are installed:<br><br>At Level <font color="#ff0000">2</font>, the total number of attacking ships will be displayed along with the simple attack warning.<br>At Level <font color="#ff0000">4</font>, the type of attacking ships along with the number of ships are displayed.
<br>At Level <font color="#ff0000">8</font>, the exact number of each type of ship launched is displayed.';
$lang['info'][108]['name']        			= "Computer Technology";
$lang['info'][108]['description'] 			= "Once launched on any mission, fleets are controlled primarily by a series of computers located on the originating planet. These massive computers calculate the exact time of arrival, controls course corrections as needed, calculates trajectories, and regulates flight speeds. <br><br>With each level researched, the flight computer is upgraded to allow an additional slot to be launched. Computer technology should be continuously developed throughout the building of your empire.";
$lang['info'][109]['name']        			= "Weapons Technology";
$lang['info'][109]['description'] 			= "Weapons Technology is a key research technology and is critical to your survival against enemy Empires. With each level of Weapons Technology researched, the weapons systems on ships and your defense mechanisms become increasingly more efficient. Each level increases the base strength of your weapons by 10% of the base value.";
$lang['info'][110]['name']        			= "Shielding Technology";
$lang['info'][110]['description'] 			= "With the invention of the magnetosphere generator, scientists learned that an artificial shield could be produced to protect the crew in space ships not only from the harsh solar radiation environment in deep space, but also provide protection from enemy fire during an attack. Once scientists finally perfected the technology, a magnetosphere generator was installed on all ships and defence systems. <br><br>As the technology is advanced to each level, the magnetosphere generator is upgraded which provides an additional 10% strength to the shields base value.";
$lang['info'][111]['name']        			= "Armour Technology";
$lang['info'][111]['description'] 			= "The environment of deep space is harsh. Pilots and crew on various missions not only faced intense solar radiation, they also faced the prospect of being hit by space debris, or destroyed by enemy fire in an attack. With the discovery of an aluminum-lithium titanium carbide alloy, which was found to be both light weight and durable, this afforded the crew a certain degree of protection. With each level of Armour Technology developed, a higher quality alloy is produced, which increases the armours strength by 10%.";
$lang['info'][113]['name']        			= "Energy Technology";
$lang['info'][113]['description'] 			= "As various researches were advancing, it was discovered that the current technology of energy distribution was not sufficient enough to begin certain specialized researches. With each upgrade of your Energy Technology, new researches can be conducted which unlocks development of more sophisticated ships and defenses.";
$lang['info'][114]['name']        			= "Hyperspace Technology";
$lang['info'][114]['description'] 			= 'In theory, the idea of hyperspace travel relies on the existence of a separate and adjacent dimension. When activated, a hyperspace drive shunts the starship into this other dimension, where it can cover vast distances in an amount of time greatly reduced from the time it would take in "normal" space. Once it reaches the point in hyperspace that corresponds to its destination in real space, it re-emerges.<br> Once a sufficient level of Hyperspace Technology is researched, the Hyperspace Drive is no longer just a theory.';
$lang['info'][115]['name']        			= "Combustion Drive";
$lang['info'][115]['description'] 			= "The Combustion Drive is the oldest of technologies, but is still in use. With the Combustion Drive, exhaust is formed from propellants carried within the ship prior to use. In a closed chamber, the pressures are equal in each direction and no acceleration occurs. If an opening is provided at the bottom of the chamber then the pressure is no longer opposed on that side. The remaining pressure gives a resultant thrust in the side opposite the opening, which propels the ship forward by expelling the exhaust rearwards at extreme high speed.<br> <br>With each level of the Combustion Drive developed, the speed of small and large cargo ships, light fighters, recyclers, and espionage probes are increased by 10%.";
$lang['info'][117]['name']        			= "Impulse Drive";
$lang['info'][117]['description'] 			= 'The impulse drive is essentially an augmented fusion rocket, usually consisting of a fusion reactor,an accelerator-generator, a driver coil assembly and a vectored thrust nozzle to direct the plasma exhaust. The fusion reaction generates a highly energized plasma. This plasma, ("electro-plasma") can be employed for propulsion, or can be diverted through the EPS to the power transfer grid, via EPS conduits, so as to supply other systems. The accelerated plasma is passed through the driver coils, thereby generating a subspace field which improves the propulsive effect. <br><br>With each level of the Impulse Drive developed, the speed of bombers, cruisers, heavy fighters, and colony ships are increased by 20% of the base value. Interplanetary missiles also travel farther with each level.';
$lang['info'][118]['name']        			= "Hyperspace Drive";
$lang['info'][118]['description'] 			= "With the advancement of Hyperspace Technology, the Hyperspace Drive was created. Hyperspace is an alternate region of space co-existing with our own universe which may be entered using an energy field or other device. The HyperSpace Drive utilizes this alternate region by distorting the space-time continuum, which results in speeds that exceed the speed of light (otherwise known as FTL travel). During FTL travel, time and space is warped to the point that results in a trip that would normally take 1000 light years to be completed, to be accomplished in about an hour. <br><br>With each level the Hyperspace Drive is developed, the speed of battleships, battlecruisers, destroyers, and deathstars are increased by 30%.";
$lang['info'][120]['name']        			= "Laser Technology";
$lang['info'][120]['description'] 			= "In physics, a laser is a device that emits light through a specific mechanism for which the term laser is an acronym: Light Amplification by Stimulated Emission of Radiation. Lasers have many uses to the empire, from upgrading computer communications systems to the creation of newer weapons and space ships.";
$lang['info'][121]['name']        			= "Ion Technology";
$lang['info'][121]['description'] 			= "Simply put, an ion is an atom or a group of atoms that has acquired a net electric charge by gaining or losing one or more electrons. Utilized in advanced weapons systems, a consentrated beam of Ions can cause considerable damage to objects that it strikes.";
$lang['info'][122]['name']        			= "Plasma Technology";
$lang['info'][122]['description'] 			= "In the universe, there exists four states of matter: solid, liquids, gas, and plasma. Being an advanced version of Ion technology, Plasma Technology expands on the destructive effect that Ion Technology delivered, and opens the door to create advanced weapons systems and ships. Plasma matter is created by superheating gas and compressing it with extreme high pressures to create a sphere of superheated plasma matter. The resulting plasma sphere causes considerable damage to the target in which the sphere is launched to.";
$lang['info'][123]['name']        			= "Intergalactic Research Network";
$lang['info'][123]['description'] 			= "This is your deep space network to communicate researches to your colonies. With the IRN, faster research times can be achieved by linking the highest level research labs equal to the level of the IRN developed. <br><br>In order to function, each colony must be able to conduct the research independently.";
$lang['info'][124]['name']        			= "Expedition Technology";
$lang['info'][124]['description'] 			= "The Expedition Technology includes several scan researches and allows you to equip different spaceships with research modules to explore uncharted regions of the universe. Those include a database and a fully functional mobile laboratory. <br><br>To assure the security of the expedition fleet during dangerous research situations, the research modules have their own energy supplies and energy field generators which creates a powerful force field around the research module during emergency situations.";
$lang['info'][199]['name']        			= "Graviton Technology";
$lang['info'][199]['description'] 			= "The graviton is an elementary particle that mediates the force of gravity in the framework of quantum field theory. The graviton must be massless (because the gravitational force has unlimited range) and must have a spin of 2 (because gravity is a second-rank tensor field). Graviton Technology is only used for one thing, for the construction of the fearsome DeathStar. <br><br>Out of all of the technologies to research, this one carries the most risk of detection during the phase of preparation.";

// -------------------------- SHIPS ----------------------------------------------------------------------------------------------------//
$lang['info'][202]['name']        			= "Small Cargo";
$lang['info'][202]['description'] 			= "The first ship built by any emperor, the small cargo is an agile resource moving ship that has a cargo capacity of 5,000 resource units. This multi-use ship not only has the ability to quickly transport resources between your colonies, but also accompanies larger fleets on raiding missions on enemy targets. [Ship refitted with Impulse Drives once reached level 5]";
$lang['info'][203]['name']        			= "Large Cargo";
$lang['info'][203]['description'] 			= "As time evolved, the raids on colonies resulted in larger and larger amounts of resources being captured. As a result, Small Cargos were being sent out in mass numbers to compensate for the larger captures. It was quickly learned that a new class of ship was needed to maximize resources captured in raids, yet also be cost effective. After much development, the Large Cargo was born.<br><br>To maximize the resources that can be stored in the holds, this ship has little in the way of weapons or armor. Thanks to the highly developed combustion engine installed, it serves as the most economical resource supplier between planets, and most effective in raids on hostile worlds.";
$lang['info'][204]['name']        			= "Light Fighter";
$lang['info'][204]['description'] 			= "This is the first fighting ship all emperors will build. The light fighter is an agile ship, but vulnerable by themselves. In mass numbers, they can become a great threat to any empire. They are the first to accompany small and large cargo to hostile planets with minor defenses.";
$lang['info'][205]['name']        			= "Heavy Fighter";
$lang['info'][205]['description'] 			= "In developing the heavy fighter, researchers reached a point at which conventional drives no longer provided sufficient performance. In order to move the ship optimally, the impulse drive was used for the first time. This increased the costs, but also opened new possibilities. By using this drive, there was more energy left for weapons and shields; in addition, high-quality materials were used for this new family of fighters. With these changes, the heavy fighter represents a new era in ship technology and is the basis for cruiser technology.<br><br>Slightly larger than the light fighter, the heavy fighter has thicker hulls, providing more protection, and stronger weaponry.";
$lang['info'][206]['name']        			= "Cruiser";
$lang['info'][206]['description'] 			= "With the development of the heavy laser and the ion cannon, light and heavy fighters encountered an alarmingly high number of defeats that increased with each raid. Despite many modifications, weapons strength and armour changes, it could not be increased fast enough to effectively counter these new defensive measures. Therefore, it was decided to build a new class of ship that combined more armor and more firepower. As a result of years of research and development, the Cruiser was born. <br><br>Cruisers are armored almost three times of that of the heavy fighters, and possess more than twice the firepower of any combat ship in existence. They also possess speeds that far surpassed any spacecraft ever made. For almost a century, cruisers dominated the universe. However, with the development of Gauss cannons and plasma turrets, their predominance ended. They are still used today against fighter groups, but not as predominantly as before.";
$lang['info'][207]['name']        			= "Battleship";
$lang['info'][207]['description'] 			= "Once it became apparent that the cruiser was losing ground to the increasing number of defense structures it was facing, and with the loss of ships on missions at unacceptable levels, it was decided to build a ship that could face those same type of defense structures with as little loss as possible. After extensive development, the Battleship was born. Built to withstand the largest of battles, the Battleship features large cargo spaces, heavy cannons, and high hyperdrive speed. Once developed, it eventually turned out to be the backbone of every raiding Emperors fleet.";
$lang['info'][208]['name']        			= "Colony Ship";
$lang['info'][208]['description'] 			= "In the 20th Century, Man decided to go for the stars. First, it was landing on the Moon. After that, a space station was built. Mars was colonized soon afterwards. It was soon determined that our growth depended on colonizing other worlds. Scientists and engineers all over the world gathered together to develop mans greatest achievement ever. The Colony Ship is born.<br><br>This ship is used to prepare a newly discovered planet for colonization. Once it arrives at the destination, the ship is instantly transformed into habital living space to assist in populating and mining the new world. 9 Planets maximum can be colonized.";
$lang['info'][209]['name']        			= "Recycler";
$lang['info'][209]['description'] 			= "As space battles became larger and more fierce, the resultant debris fields became too large to gather safely by conventional means. Normal transporters could not get close enough without receiving substantial damage. A solution was developed to this problem. The Recycler. <br><br>Thanks to the new shields and specially built equipment to gather wreckage, gathering debris no longer presented a danger. Each Recycler can gather 20,000 units of debris.";
$lang['info'][210]['name']       			= "Espionage Probe";
$lang['info'][210]['description'] 			= "Espionage probes are small, agile drones that provide data on fleets and planets. Fitted with specially designed engines, it allows them to cover vast distances in only a few minutes. Once in orbit around the target planet, they quickly collect data and transmit the report back via your Deep Space Network for evaluation. But there is a risk to the intelligent gathering aspect. During the time the report is transmitted back to your network, the signal can be detected by the target and the probes can be destroyed.";
$lang['info'][211]['name']        			= "Bomber";
$lang['info'][211]['description'] 			= "Over the centuries, as defenses were starting to get larger and more sophisticated, fleets were starting to be destroyed at an alarming rate. It was decided that a new ship was needed to break defenses to ensure maximum results. After years of research and development, the Bomber was created.<br><br>Using laser-guided targeting equipment and Plasma Bombs, the Bomber seeks out and destroys any defense mechanism it can find. As soon as the hyperspace drive is developed to Level 8, the Bomber is retrofitted with the hyperspace engine and can fly at higher speeds.";
$lang['info'][212]['name']        			= "Solar Satellite";
$lang['info'][212]['description'] 			= "It quickly became apparent that more energy was needed to power larger mines then could be produced by conventional ground based solar planets and fusion reactors. Scientists worked on the problem and discovered a method of transmitting electrical energy to the colony using specially designed satellites in geosynchronous orbit.<br><br> Solar Satellites gather solar energy and transmit it to a ground station using advanced laser technology. The efficiency of a solar satellite depends on the strength of the solar radiation it receives. In principle, energy production in orbits closer to the sun is greater than for planets in orbits distant from the sun. Since the satellites primary goal is the transmission of energy, they lack shielding and weapons capability, and because of this they are usually destroyed in large numbers in a major battle. However they do possess a small self-defense mechanism to defend itself in an espionage mission from an enemy empire if the mission is detected.";
$lang['info'][213]['name']        			= "Destroyer";
$lang['info'][213]['description'] 			= "The Destroyer is the result of years of work and development. With the development of Deathstars, it was decided that a class of ship was needed to defend against such a massive weapon.Thanks to its improved homing sensors, multi-phalanx Ion cannons, Gauss Cannons and Plasma Turrets, the Destroyer turned out to be one of the most fearsome ships created.<br><br>Because the destroyer is very large, its maneuverability is severely limited, which makes it more of a battle station than a fighting ship. The lack of maneuverability is made up for by its sheer firepower, but it also costs significant amounts of deuterium to build and operate.";
$lang['info'][214]['name']        			= "Deathstar";
$lang['info'][214]['description'] 			= "The Deathstar is the ultimate ship ever created. This moon sized ship is the only ship that can be seen with the naked eye on the ground. By the time you spot it, unfortunately, it is too late to do anything.<br><br> Armed with a gigantic graviton cannon, the most advanced weapons system ever created in the Universe, this massive ship has not only the capability of destroying entire fleets and defenses, but also has the capability of destroying entire moons. Only the most advanced empires have the capability to build a ship of this mammoth size.";
$lang['info'][215]['name']        			= "Battlecruiser";
$lang['info'][215]['description'] 			= "This ship is one of the most advanced fighting ships ever to be developed, and is particularly deadly when it comes to destroying attacking fleets. With its improved laser cannons on board and advanced Hyperspace engine, the Battlecruiser is a serious force to be dealt with in any attack.<br><br> Due to the ships design and its large weapons system, the cargo holds had to be cut, but this is compensated for by the lowered fuel consumption.";
$lang['info'][216]['name']        			= "Supernova";
$lang['info'][216]['description']        	= "";

// -------------------------- DEFENSES ----------------------------------------------------------------------------------------------------//
$lang['info'][401]['name']        			= "Rocket Launcher";
$lang['info'][401]['description'] 			= "Your first basic line of defense. These are simple ground based launch facilities that fire conventional warhead tipped missiles at attacking enemy targets. As they are cheap to construct and no research is required, they are well suited for defending raids, but lose effectiveness defending from larger scale attacks. Once you begin construction on more advanced defense weapons systems, Rocket Launchers become simple fodder to allow your more damaging weapons to inflict greater damage for a longer period of time.<br><br>After a battle, there is up to a 70 % chance that failed defensive facilities can be returned to use.";
$lang['info'][402]['name']        			= "Light Laser";
$lang['info'][402]['description'] 			= "As technology developed and more sophisticated ships were created, it was determined that a stronger line of defense was needed to counter the attacks. As Laser Technology advanced, a new weapon was designed to provide the next level of defense. Light Lasers are simple ground based weapons that utilize special targeting systems to track the enemy and fire a high intensity laser designed to cut through the hull of the target. In order to be kept cost effective, they were fitted with an improved shielding system, however the structural integrity is the same as that of the Rocket Launcher.<br><br> After a battle, there is up to a 70 % chance that failed defensive facilities can be returned to use.";
$lang['info'][403]['name']        			= "Heavy Laser";
$lang['info'][403]['description'] 			= "The Heavy Laser is a practical, improved version of the Light Laser. Being more balanced than the Light Laser with improved alloy composition, it utilizes stronger, more densely packed beams, and even better onboard targeting systems. <br><br> After a battle, there is up to a 70 % chance that failed defensive facilities can be returned to use.";
$lang['info'][404]['name']        			= "Gauss Cannon";
$lang['info'][404]['description'] 			= 'Far from being a science-fiction "weapon of tomorrow," the concept of a weapon using an electromagnetic impulse for propulsion originated as far back as the mid-to-late 1930s. Basically, the Gauss Cannon consists of a system of powerful electromagnets which fires a projectile by accelerating between a number of metal rails. Gauss Cannons fire high-density metal projectiles at extremely high velocity. <br><br>This weapon is so powerful when fired that it creates a sonic boom which is heard for miles, and the crew near the weapon must take special precautions due to the massive concussion effects generated.';
$lang['info'][405]['name']        			= "Ion Cannon";
$lang['info'][405]['description'] 			= "An ion cannon is a weapon that fires beams of ions (positively or negatively charged particles). The Ion Cannon is actually a type of Particle Cannon; only the particles used are ionized. Due to their electrical charges, they also have the potential to disable electronic devices, and anything else that has an electrical or similar power source, using a phenomena known as the the Electromagetic Pulse (EMP effect). Due to the cannons highly improved shielding system, this cannon provides improved protection for your larger, more destructive defense weapons.<br><br> After a battle, there is up to a 70 % chance that failed defensive facilities can be returned to use.";
$lang['info'][406]['name']        			= "Plasma Turret";
$lang['info'][406]['description'] 			= "One of the most advanced defense weapons systems ever developed, the Plasma Turret uses a large nuclear reactor fuel cell to power an electromagnetic accelerator that fires a pulse, or toroid, of plasma. During operation, the Plasma turret first locks on a target and begins the process of firing. A plasma sphere is created in the turrets core by super heating and compressing gases, stripping them of their ions. Once the gas is superheated, compressed, and a plasma sphere is created, it is then loaded into the electromagnetic accelerator which is energized. Once fully energized, the accelerator is activated, which results in the plasma sphere being launched at an extremely high rate of speed to the intended target. From the targets perspective, the approaching bluish ball of plasma is impressive, but once it strikes, it causes instant destruction.<br><br> Defensive facilities deactivate as soon as they are too heavily damaged. After a battle, there is up to a 70 % chance that failed defensive facilities can be returned to use.";
$lang['info'][407]['name']        			= "Small Shield Dome";
$lang['info'][407]['description'] 			= "Colonizing new worlds brought about a new danger, space debris. A large asteroid could easily wipe out the world and all inhabitants. Advancements in shielding technology provided scientists with a way to develop a shield to protect an entire planet not only from space debris but, as it was learned, from an enemy attack. By creating a large electromagnetic field around the planet, space debris that would normally have destroyed the planet was deflected, and attacks from enemy Empires were thwarted. The first generators were large and the shield provided moderate protection, but it was later discovered that small shields did not afford the protection from larger scale attacks. The small shield dome was the prelude to a stronger, more advanced planetary shielding system to come.<br><br> After a battle, there is up to a 70 % chance that failed defensive facilities can be returned to use.";
$lang['info'][408]['name']        			= "Large Shield Dome";
$lang['info'][408]['description'] 			= "The Large Shield Dome is the next step in the advancement of planetary shields, it is the result of years of work improving the Small Shield Dome. Built to withstand a larger barrage of enemy fire by providing a higher energized electromagnetic field, large domes provide a longer period of protection before collapsing.<br><br> After a battle, there is up to a 70 % chance that failed defensive facilities can be returned to use.";
$lang['info'][409]['name']        			= "Planet protector";
$lang['info'][409]['description'] 			= "The best and most advanced protection for your planet.";
$lang['info'][502]['name']        			= "Anti-Ballistic Missiles";
$lang['info'][502]['description'] 			= "Anti Ballistic Missiles (ABM) are your only line of defense when attacked by Interplanetary Missiles (IPM). When a launch of IPMs is detected, these missiles automatically arm, process a launch code in their flight computers, target the inbound IPM, and launch to intercept. During the flight, the target IPM is constantly tracked and course corrections are applied until the ABM reaches the target and destroys the attacking IPM. Each ABM destroys one incoming IPM. <br><br>Each level of your missile silo developed can store 10 ABMs, 5 IPMs, or a combination of both missile types.";
$lang['info'][503]['name']        			= "Interplanetary Missiles";
$lang['info'][503]['description'] 			= "Interplanetary Missiles (IPM) are your offensive weapon to destroy the defenses of your target. Using state of the art tracking technology, each missile targets a certain number of defenses for destruction. Tipped with an anti-matter bomb, they deliver a destructive force so severe that destroyed shields and defenses cannot be repaired. The only way to counter these missiles is with APMs.<br><br> Each level of your missile silo developed can store 10 ABMs, 5 IPMs, or a combination of both missile types.";

// -------------------------- OFFICIERS ----------------------------------------------------------------------------------------------------//
$lang['info'][601]['name']        			= "Geologist";
$lang['info'][601]['description'] 			= "Geologist is an expert in mining and astro crystallography. Attend their equipment in metallurgy and chemistry and is also responsible for interplanetary communications to optimize the use and refinement of raw material throughout the empire.";
$lang['info'][602]['name']        			= "Admiral";
$lang['info'][602]['description'] 			= "The Admiral is an experienced veteran and a skillful strategist. The hardest battle is able to get an idea of the situation and contact their admirals subordinates. A wise emperor could rely on their help during the fighting.";
$lang['info'][603]['name']        			= "Engineer";
$lang['info'][603]['description'] 			= "The Engineer is a specialist in energy management. In peacetime, it increases the energy of all the colonies. In case of attack, ensuring the supply of energy to the cannons, and avoid a possible overload, leading to a reduction in defense lost battle.";
$lang['info'][604]['name']        			= "Technocrat";
$lang['info'][604]['description'] 			= "The guild is composed of technocrats authentic genius, and always find that dangerous edge where it all explode into a thousand pieces before they could find an explanation and technology rational. No normal human being ever try to decode the code of a technocrat, with its presence, the researchers modeled the rule.";
$lang['info'][605]['name']        			= "Constructor";
$lang['info'][605]['description'] 			= "The constructor has altered their DNA, only one of these men can build an entire city in a short time.";
$lang['info'][606]['name']        			= "Scientific";
$lang['info'][606]['description'] 			= "Scientists are part of a guild to concurrent technocrats. They specialize in the improvement of technologies.";
$lang['info'][607]['name']        			= "Storer";
$lang['info'][607]['description'] 			= "Storage is part of the ancient brotherhood of the planet Hsac. His motto is to win the maximum, which is why we need huge storage space. Thus has developed a new storage technique.";
$lang['info'][608]['name']        			= "Defender";
$lang['info'][608]['description'] 			= "The defender is a member of the imperial army. focus on your job allows you to build a formidable defense in a short period of time.";
$lang['info'][609]['name']        			= "Protector";
$lang['info'][609]['description'] 			= "The guard is part of the imperial army and its goal is to develop technologies that improve the planetary defenses.";
$lang['info'][610]['name']        			= "Spy";
$lang['info'][610]['description'] 			= "Spy is an enigmatic person. No one ever saw his true face, the only way would be killed.";
$lang['info'][611]['name']        			= "Commander";
$lang['info'][611]['description'] 			= "The commander is part of the Imperial Army has mastered the art of managing fleets. Your brain can calculate the trajectories of a large number of fleets.";
$lang['info'][612]['name']        			= "Destroyer";
$lang['info'][612]['description'] 			= "The destructor is a member of the imperial army without mercy. Slaughter everything that is on its way just for fun. It is currently developing a new method of producing the Death Star.";
$lang['info'][613]['name']        			= "General";
$lang['info'][613]['description'] 			= "The general is a person who has served for many years to the imperial army. manufacturers produce ships faster in its presence.";
$lang['info'][614]['name']        			= "Conqueror";
$lang['info'][614]['description'] 			= "El Conquistador is a member of the Army, it has the ability to navigate a particular type of ship that no one else could do or take off.";
$lang['info'][615]['name']        			= "Emperor";
$lang['info'][615]['description'] 			= "The emperor placed under his command available to all officers in the empire, combining their skills to dominate the universe and to become an opponent almost Invensil.";

//----------------------------------------------------------------------------//
//MESSAGES
$lang['mg_type'][0]    						= 'Spy reports';
$lang['mg_type'][1]    						= 'Messages from players';
$lang['mg_type'][2]    						= 'Messages from ally';
$lang['mg_type'][3]    						= 'Battle reports';
$lang['mg_type'][4]    						= 'Collection reports';
$lang['mg_type'][5]    						= 'Transportation reports';
$lang['mg_type'][15]   						= 'Expedition reports';
$lang['mg_type'][99]   						= 'Construction reports';
$lang['mg_type'][100]  						= 'View all Messages';
$lang['mg_no_subject']						= 'No Subject';
$lang['mg_no_text']							= 'No message';
$lang['mg_msg_sended']						= 'Message sent';
$lang['mg_no_subject']						= 'No Subject';
$lang['mg_delete_marked']					= 'Delete marked messages';
$lang['mg_delete_unmarked']					= 'Delete all unmarked messages';
$lang['mg_delete_all']						= 'Delete all messages';
$lang['mg_show_only_header_spy_reports']	= 'show only partial espionage reports ';
$lang['mg_action']							= 'Action';
$lang['mg_date']							= 'Date';
$lang['mg_from']							= 'From';
$lang['mg_subject']							= 'Subject';
$lang['mg_confirm_delete']					= 'Confirm';
$lang['mg_message_title']					= 'Messages';
$lang['mg_message_type']					= 'Message type';
$lang['mg_total']							= 'Total';
$lang['mg_game_operators']					= 'Game operators';

//----------------------------------------------------------------------------//
//ALLIANCE
$lang['al_description_message']				= 'Alliance description message';
$lang['al_web_text']						= 'Alliance web site';
$lang['al_request']							= 'Application';
$lang['al_click_to_send_request']			= 'Click here to send your application to the alliance';
$lang['al_tag_required']					= 'Alliance tag missing';
$lang['al_name_required']					= 'Alliance name missing';
$lang['al_already_exists']					= 'The alliance %s already exists.';
$lang['al_created']							= 'The alliance %s was created';
$lang['al_continue']						= 'continue';
$lang['al_alliance_closed']					= 'This alliance does not support more members';
$lang['al_request_confirmation_message']	= 'Application registered. Will receive a message when your application is approved / rejected. <br><a href="game.php?page=alliance">back</a>';
$lang['al_default_request_text']			= 'The alliance leaders have not set an example of application, or have no pretensions.';
$lang['al_write_request']					= 'Write application to the alliance %s';
$lang['al_request_deleted']					= 'Your request to the alliance %s has been deleted. <br/> Now you can write a new application or create your own alliance.';
$lang['al_request_wait_message']			= 'You\'ve already sent a request to the alliance %s. <br/> Please wait until you receive a reply or delete this application.';
$lang['al_delete_request']					= 'Delete aplication';
$lang['al_founder_cant_leave_alliance']		= 'The founder can not abandon the alliance.';
$lang['al_leave_sucess']					= 'You leaver the alliance %s succesfully.';
$lang['al_do_you_really_want_to_go_out']	= 'Do you really want to leave the alliance %s?';
$lang['al_go_out_yes']						= 'Yes';
$lang['al_circular_sended']					= 'Circular message sended, Following players will receive your circular message:';
$lang['al_all_players']						= 'All players';
$lang['al_no_ranks_defined']				= 'No ranks defined';
$lang['al_request_text']					= 'Application text';
$lang['al_inside_text']						= 'Internal text';
$lang['al_outside_text']					= 'External text';
$lang['al_transfer_alliance']				= 'Transfer alliance';
$lang['al_disolve_alliance']				= 'Disolve alliance';
$lang['al_founder_rank_text']				= 'Founder';
$lang['al_new_member_rank_text']			= 'New member';
$lang['al_acept_request']					= 'Accept';
$lang['al_you_was_acceted']					= 'You was accepted in ';
$lang['al_hi_the_alliance']					= 'Hello!<br>The alliance <b>';
$lang['al_has_accepted']					= '</b> accept you aplication<br>Founder\'s Message: <br>';
$lang['al_decline_request']					= 'Reject';
$lang['al_you_was_declined']				= 'You were rejected in ';
$lang['al_has_declined']					= '</b> the alliance reject your aplication<br>Founder\'s Message: <br>';
$lang['al_no_requests']						= 'No requests';
$lang['al_request_from']					= '"%s\'s" request';
$lang['al_no_request_pending']				= 'There is %n application/s pending/s';
$lang['al_name']							= 'name';
$lang['al_new_name']						= 'New name';
$lang['al_tag']								= 'tag';
$lang['al_new_tag']							= 'New tag';
$lang['al_user_list']						= 'Member List';
$lang['al_manage_alliance']					= 'manage alliance';
$lang['al_send_circular_message']			= 'send circular message';
$lang['al_new_requests']					= 'new request/s';
$lang['al_save']							= 'Save';
$lang['al_dlte']							= 'Delete';
$lang['al_rank_name']						= 'Rank name';
$lang['al_ok']								= 'OK';
$lang['al_number_of_records']				= 'Total';
$lang['al_num']								= 'ID';
$lang['al_member']							= 'Name';
$lang['al_message']							= 'Message';
$lang['al_position']						= 'Rank';
$lang['al_points']							= 'Points';
$lang['al_coords']							= 'Coords';
$lang['al_member_since']					= 'Joined';
$lang['al_estate']							= 'Online';
$lang['al_back']							= 'Back';
$lang['al_actions']							= 'Actions';
$lang['al_change_title']					= 'Change';
$lang['al_the_alliance']					= 'of the alliance';
$lang['al_change_submit']					= 'Change';
$lang['al_reply_to_request']				= 'Reply to request';
$lang['al_reason']							= 'Reason';
$lang['al_characters']						= 'characters';
$lang['al_request_list']					= 'List of requests';
$lang['al_candidate']						= 'Candidate';
$lang['al_request_date']					= 'Date of application';
$lang['al_transfer_alliance']				= 'Resign/take over this alliance?';
$lang['al_transfer_to']						= 'Transfer to';
$lang['al_transfer_submit']					= 'Transfer';
$lang['al_ally_information']				= 'Alliance information';
$lang['al_ally_info_tag']					= 'Tag';
$lang['al_ally_info_name']					= 'Name';
$lang['al_ally_info_members']				= 'Members';
$lang['al_your_request_title']				= 'Your aplication';
$lang['al_applyform_send']					= 'Send';
$lang['al_applyform_reload']				= 'Reload';
$lang['al_circular_send_ciruclar']			= 'Send circular message';
$lang['al_receiver']						= 'Recipient';
$lang['al_circular_send_submit']			= 'Send';
$lang['al_circular_reset']					= 'Clean';
$lang['al_alliance']						= 'Alliances';
$lang['al_alliance_make']					= 'Found your own alliance';
$lang['al_alliance_search']					= 'Search for alliances';
$lang['al_your_ally']						= 'Your alliance';
$lang['al_rank']							= 'Your Rank';
$lang['al_web_site']						= 'Homepage';
$lang['al_inside_section']					= 'Internal Area';
$lang['al_make_alliance']					= 'Found alliances';
$lang['al_make_ally_tag_required']			= 'Alliance Tag (3-8 characters)';
$lang['al_make_ally_name_required']			= 'Alliance name (3-30 characters)';
$lang['al_make_submit']						= 'found';
$lang['al_find_alliances']					= 'Search for alliances';
$lang['al_find_text']						= 'Search for';
$lang['al_find_submit']						= 'search';
$lang['al_the_nexts_allys_was_founded']		= 'Following alliances were found:';
$lang['al_manage_ranks']					= 'Configure rights';
$lang['al_manage_members']					= 'manage members';
$lang['al_manage_change_tag']				= 'Change the tag of the alliance';
$lang['al_manage_change_name']				= 'Change the name of the alliance';
$lang['al_texts']							= 'Text Management';
$lang['al_manage_options']					= 'Options';
$lang['al_manage_image']					= 'Alliance logo';
$lang['al_manage_requests']					= 'Applications';
$lang['al_requests_not_allowed']			= 'aren\'t possible(alliance closed)';
$lang['al_requests_allowed']				= 'are possible(alliance open)';
$lang['al_manage_founder_rank']				= 'Founder rank';
$lang['al_configura_ranks']					= 'Configure Rights';
$lang['al_create_new_rank']					= 'Create New Rank';
$lang['al_rank_name']						= 'Rank name';
$lang['al_create']							= 'Create';
$lang['al_legend']							= 'Rights Description';
$lang['al_legend_disolve_alliance']			= 'Disband alliance';
$lang['al_legend_kick_users']				= 'Kick user';
$lang['al_legend_see_requests']				= 'Show applications';
$lang['al_legend_see_users_list']			= 'Show member list';
$lang['al_legend_check_requests']			= 'Process applications';
$lang['al_legend_admin_alliance']			= 'Manage Alliance';
$lang['al_legend_see_connected_users']		= 'Show online status in member list';
$lang['al_legend_create_circular']			= 'Write circular message';
$lang['al_legend_right_hand']				= '"Right Hand" (necessary to transfer founder rank)';
$lang['al_requests']						= 'Requests';
$lang['al_circular_message']				= 'Circular message';
$lang['al_leave_alliance']					= 'Leave this alliance';

//----------------------------------------------------------------------------//
//BUDDY
$lang['bu_request_exists']					= 'There is already an application to that player!';
$lang['bu_cannot_request_yourself']			= 'You can not ask you as a friend to yourself';
$lang['bu_request_message']					= 'Request message';
$lang['bu_player']							= 'Player';
$lang['bu_request_text']					= 'Application Text';
$lang['bu_characters']						= 'characters';
$lang['bu_back']							= 'Back';
$lang['bu_send']							= 'Send';
$lang['bu_cancel_request']					= 'Cancel Request';
$lang['bu_accept']							= 'Accept';
$lang['bu_decline']							= 'Reject';
$lang['bu_connected']						= 'Connected';
$lang['bu_fifteen_minutes']					= '15 minutes';
$lang['bu_disconnected']					= 'Disconnected';
$lang['bu_delete']							= 'Delete';
$lang['bu_buddy_list']						= 'Buddy list';
$lang['bu_requests']						= 'Applications';
$lang['bu_alliance']						= 'Alliance';
$lang['bu_coords']							= 'Coordinates';
$lang['bu_text']							= 'Text';
$lang['bu_action']							= 'Action';
$lang['bu_my_requests']						= 'My Requests';
$lang['bu_partners']						= 'Compañeros';
$lang['bu_estate']							= 'State';

//----------------------------------------------------------------------------//
//NOTES
$lang['nt_important']						= 'Important';
$lang['nt_normal']							= 'Normal';
$lang['nt_unimportant']						= 'Unimportant';
$lang['nt_create_note']						= 'Create note';
$lang['nt_edit_note']						= 'Edit note';
$lang['nt_you_dont_have_notes']				= 'no notes recorded';
$lang['nt_notes']							= 'Notes';
$lang['nt_create_new_note']					= 'Create a new note';
$lang['nt_date_note']						= 'Date';
$lang['nt_subject_note']					= 'Subject';
$lang['nt_size_note']						= 'Size';
$lang['nt_dlte_note']						= 'Delete';
$lang['nt_priority']						= 'Priority';
$lang['nt_note']							= 'Notice';
$lang['nt_characters']						= 'characters';
$lang['nt_back']							= 'Back';
$lang['nt_reset']							= 'Reestablecer';
$lang['nt_save']							= 'Save';

//----------------------------------------------------------------------------//
//STATISTICS
$lang['st_player']							= 'Player';
$lang['st_alliance']						= 'Alliance';
$lang['st_points']							= 'Points';
$lang['st_fleets']							= 'Fleet';
$lang['st_researh']							= 'Research';
$lang['st_buildings']						= 'Building';
$lang['st_defenses']						= 'Defense';
$lang['st_position']						= 'Rank';
$lang['st_members']							= 'Member';
$lang['st_per_member']						= 'Per Member';
$lang['st_statistics']						= 'Statistics';
$lang['st_updated']							= 'Updated';
$lang['st_show']							= 'show';
$lang['st_per']								= 'by';
$lang['st_in_the_positions']				= 'in ranks';

//----------------------------------------------------------------------------//
//SEARCH
$lang['sh_tag']								= 'Tag';
$lang['sh_name']							= 'Name';
$lang['sh_members']							= 'Member';
$lang['sh_points']							= 'Points';
$lang['sh_searcg_in_the_universe']			= 'Search Universe';
$lang['sh_player_name']						= 'Player Name';
$lang['sh_planet_name']						= 'Planet Name';
$lang['sh_alliance_tag']					= 'Alliance Tag';
$lang['sh_alliance_name']					= 'Alliance Name';
$lang['sh_search']							= 'search';
$lang['sh_buddy_request']					= 'Buddy request';
$lang['sh_alliance']						= 'Alliance';
$lang['sh_planet']							= 'Planet';
$lang['sh_coords']							= 'Position';
$lang['sh_position']						= 'Rank';

//----------------------------------------------------------------------------//
//OPTIONS
$lang['op_cant_activate_vacation_mode']		= 'If you\'re building or moving fleets will not be able to enter on vacation mode.';
$lang['op_password_changed']				= 'Password has been changed<br /><a href="index.php" target="_top">Back</a>';
$lang['op_username_changed']				= 'Username changed<br /><a href="index.php" target="_top">Back</a>';
$lang['op_options_changed']					= 'Changes saved.<br /><a href="game.php?page=options">Back</a>';
$lang['op_vacation_mode_active_message']	= 'The vacation mode is turned on. Have to be on vacation at least until: ';
$lang['op_end_vacation_mode']				= 'Finish vacation mode';
$lang['op_save_changes']					= 'save changes';
$lang['op_admin_title_options']				= 'Options available to management';
$lang['op_admin_planets_protection']		= 'Protection of planets';
$lang['op_user_data']						= 'User Data';
$lang['op_username']						= 'Username';
$lang['op_old_pass']						= 'Old password';
$lang['op_new_pass']						= 'New password (min. 8 characters)';
$lang['op_repeat_new_pass']					= 'New password (repeat)';
$lang['op_email_adress']					= 'Email address';
$lang['op_permanent_email_adress']			= 'Permanent Address';
$lang['op_general_settings']				= 'General Options';
$lang['op_sort_planets_by']					= 'Sort planets by:';
$lang['op_sort_kind']						= 'Assortment sequence:';
$lang['op_skin_example']					= 'Skin path (e.g. C:/ogame/skin/)<br> <a href="http://80.237.203.201/download/" target="_blank">download</a>';
$lang['op_show_skin']						= 'Display skin';
$lang['op_deactivate_ipcheck']				= 'Disable IP Check';
$lang['op_galaxy_settings']					= 'Galaxy View Options';
$lang['op_spy_probes_number']				= 'Number of espionage probes';
$lang['op_toolt_data']						= 'Information tools';
$lang['op_seconds']							= 'seconds';
$lang['op_max_fleets_messages']				= 'Maximum fleet messages';
$lang['op_show_ally_logo']					= 'Display ally logo';
$lang['op_shortcut']						= 'Shortcut';
$lang['op_show']							= 'Show';
$lang['op_spy']								= 'Spy';
$lang['op_write_message']					= 'Write message';
$lang['op_add_to_buddy_list']				= 'Add to buddylist';
$lang['op_missile_attack']					= 'Missile attack';
$lang['op_send_report']						= 'Send report';
$lang['op_vacation_delete_mode']			= 'Vacation mode / Delete account';
$lang['op_activate_vacation_mode']			= 'Enable vacation mode';
$lang['op_dlte_account']					= 'Delete account';
$lang['op_email_adress_descrip']			= 'You can change this email address at any time. This will be entered as a permanent address after 7 days without changes.';
$lang['op_deactivate_ipcheck_descrip']		= 'IP check means that a security logout occurs automatically when the IP changes or two people are logged into an account from different IPs. Disabling the IP check may represent a security risk!';
$lang['op_spy_probes_number_descrip']		= 'Number of espionage probes that can be sent directly from each scan in the Galaxy menu.';
$lang['op_activate_vacation_mode_descrip']	= 'Vacation mode will protect you during long absences. It can only be activated if nothing is being built (fleet, building, or defense), nothing is being researched, and none of your fleets are underway. Once it is activated, you are protected from new attacks. Attacks that have already started will be carried out. During vacation mode, production is set to zero and must be manually returned to 100 % after vacation mode ends. Vacation mode lasts a minimum of two days and can only be deactivated after this time.';
$lang['op_dlte_account_descrip']			= 'If you mark this box, your account will be deleted automatically after 7 days.';

//----------------------------------------------------------------------------//
//BANNED
$lang['bn_no_players_banned']				= 'No banned players';
$lang['bn_exists']							= 'Exists ';
$lang['bn_players_banned']					= ' player/s banned/s';
$lang['bn_players_banned_list']				= 'List of banned players';
$lang['bn_player']							= 'Player';
$lang['bn_reason']							= 'Reason';
$lang['bn_from']							= 'From';
$lang['bn_until']							= 'Until';
$lang['bn_by']								= 'By';

//----------------------------------------------------------------------------//
//SYSTEM
$lang['sys_attacker_lostunits'] 			= "The attacker has lost a total of";
$lang['sys_defender_lostunits'] 			= "The defender has lost a total of";
$lang['sys_units']							= "units";
$lang['debree_field_1'] 					= "A debris field";
$lang['debree_field_2']						= "floating in the orbit of the planet.";
$lang['sys_moonproba'] 						= "The probability that a moon emerge from the rubble is:";
$lang['sys_moonbuilt'] 						= "The huge amount of metal and glass are functioning and form a lunar satellite in orbit the planet %s [%d:%d:%d] !";
$lang['sys_attack_title']    				= "Fleets clash in ";
$lang['sys_attack_round']					= "Round";
$lang['sys_attack_attacker_pos'] 			= "Aggressor";
$lang['sys_attack_techologies'] 			= "Weapons: %d %% Shield: %d %% Armor: %d %% ";
$lang['sys_attack_defender_pos'] 			= "Defender";
$lang['sys_ship_type'] 						= "Type";
$lang['sys_ship_count'] 					= "Amount";
$lang['sys_ship_weapon'] 					= "Weapons";
$lang['sys_ship_shield'] 					= "Shield";
$lang['sys_ship_armour'] 					= "Armor";
$lang['sys_destroyed'] 						= "Destroyed";
$lang['fleet_attack_1'] 					= "The attacking fleet fires a total force of";
$lang['fleet_attack_2']						= "on the defender. The defender's shields absorb";
$lang['fleet_defs_1'] 						= "The defending fleet fires a total force of";
$lang['fleet_defs_2']						= "on the attacker. The attacker's shields absorb";
$lang['damage']								= "points of damage.";
$lang['sys_attacker_won'] 					= "The attacker has won the battle";
$lang['sys_defender_won'] 					= "The defender has won the battle";
$lang['sys_both_won'] 						= "The battle ended in a draw";
$lang['sys_stealed_ressources'] 			= "obtaining";
$lang['sys_and']							= "and";
$lang['sys_mess_tower'] 					= "Control Tower";
$lang['sys_mess_attack_report'] 			= "Battle Report";
$lang['sys_spy_maretials'] 					= "Resources";
$lang['sys_spy_fleet'] 						= "Fleet";
$lang['sys_spy_defenses'] 					= "Fenders";
$lang['sys_mess_qg'] 						= "Headquarters";
$lang['sys_mess_spy_report_moon']			= "(Moon)";
$lang['sys_mess_spy_report'] 				= "Report espionage";
$lang['sys_mess_spy_lostproba'] 			= "Probability of detection of the fleet of spy : %d %% ";
$lang['sys_mess_spy_control'] 				= "Space Control";
$lang['sys_mess_spy_activity'] 				= "Espionage activity";
$lang['sys_mess_spy_ennemyfleet'] 			= "An enemy fleet on the planet";
$lang['sys_mess_spy_seen_at'] 				= "was seen near your planet";
$lang['sys_mess_spy_destroyed'] 			= "Your fleet has been destroyed espionage";
$lang['sys_stay_mess_stay'] 				= "Parking Fleet";
$lang['sys_stay_mess_start'] 				= "your fleet arrives on the planet";
$lang['sys_stay_mess_end'] 					= " and offers the following resources : ";
$lang['sys_adress_planet'] 					= "[%s:%s:%s]";
$lang['sys_stay_mess_goods'] 				= "%s : %s, %s : %s, %s : %s";
$lang['sys_colo_mess_from'] 				= "Colonization";
$lang['sys_colo_mess_report'] 				= "Report of settlement";
$lang['sys_colo_defaultname'] 				= "Colony";
$lang['sys_colo_arrival'] 					= "The settlers arrived at cordenadas ";
$lang['sys_colo_maxcolo'] 					= ", but, unfortunately, can not colonize, can have no more ";
$lang['sys_colo_allisok'] 					= ", 	the settlers are beginning to build a new colony.";
$lang['sys_colo_badpos']  					= ", 	the settlers have found an environment conducive to the expansion of its empire. They decided to reverse totally disgusted ...";
$lang['sys_colo_notfree'] 					= ", 	settlers would not have found a planet with these details. They are forced to turn back completely demoralized ...";
$lang['sys_colo_planet']  					= " planet ";
$lang['sys_expe_report'] 					= "Report of expedition";
$lang['sys_recy_report'] 					= "Recycling Report";
$lang['sys_expe_blackholl_1'] 				= "The fleet was sucked into a black hole is partially destroyed.";
$lang['sys_expe_blackholl_2'] 				= "The fleet was sucked into a black hole, and was completely destroyed!";
$lang['sys_expe_nothing_1'] 				= "Your explorers took great photos. But resources have not found";
$lang['sys_expe_nothing_2'] 				= "Your scouts have spent the time in the selected area. But they have not found anything.";
$lang['sys_expe_found_goods'] 				= "The fleet has discovered an unmanned spacecraft! <br> His scouts have recovered %s de %s, %s de %s, %s de %s y %s de %s.";
$lang['sys_expe_found_ships'] 				= "Your scouts have found an abandoned squad, dominated it and come back. <br> Squadron:";
$lang['sys_expe_back_home'] 				= "Your expedition returned to the hangar.";
$lang['sys_mess_transport'] 				= "Transport Fleet";
$lang['sys_tran_mess_owner'] 				= "One of your fleet reaches %s %s and deliver their goods: %s de %s, %s de %s y %s of %s.";
$lang['sys_tran_mess_user']  				= "Found a fleet de% s% s% s coming in his libro% s% s% s units, units de% s% s% s% s units.";
$lang['sys_mess_fleetback'] 				= "Return of the fleet";
$lang['sys_tran_mess_back'] 				= "A fleet back to planet % s% s. The fleet does not give resources.";
$lang['sys_recy_gotten'] 					= "Your fleet arrived at the coordinates indicated and gatherers %s units %s and %s unitsof %s.";
$lang['sys_notenough_money'] 				= "You do not have enough resources to build a %s. You %s of %s, %s of %s and %s of %s and the cost of construction was %s of %s, %s of %s and %s of %s";
$lang['sys_nomore_level'] 					= "You try to destroy a building ( %s ).";
$lang['sys_buildlist'] 						= "List of building area";
$lang['sys_buildlist_fail'] 				= "Construcion impossible";
$lang['sys_gain'] 							= "Benefits";
$lang['sys_fleet_won'] 						= "One of your fleets returning from the planet %s %s and delivery %s of %s, %s of %s and %s of %s";
$lang['sys_perte_attaquant'] 				= "Forward Party";
$lang['sys_perte_defenseur'] 				= "Part Defender";
$lang['sys_debris'] 						= "Debris";
$lang['sys_destruc_title']    				= "Probability of kill moon %s :";
$lang['sys_mess_destruc_report'] 			= "Destruction Report";
$lang['sys_destruc_lune'] 					= "The probability of destroying the moon is: %d %% ";
$lang['sys_destruc_rip'] 					= "The probability that the stars of death are destroyed is: %d %% ";
$lang['sys_destruc_stop'] 					= "The defender has failed to stop the destruction of the moon";
$lang['sys_destruc_mess1'] 					= "The shooting death stars the graviton to the orbit of the moon";
$lang['sys_destruc_mess'] 					= "A fleet of the planet %s [%d:%d:%d] goes to the moon of the planet [%d:%d:%d]";
$lang['sys_destruc_echec'] 					= ". The tremors began to shake off the surface of the moon, but something goes wrong, the graviton in the stars of death also causes tremors and death stars fly to pieces.";
$lang['sys_destruc_reussi'] 				= ", The tremors began to shake off the surface of the moon, after a while the moon does not support more and fly to pieces, mission accomplished, the fleet returns to home planet.";
$lang['sys_destruc_null'] 					= ", The stars of death did not generate the power, the mission fails and the ships returned home.";

//----------------------------------------------------------------------------//
//class.CheckSession.php
$lang['ccs_multiple_users']					= 'Cookie error! There are several users with this name! You must delete your cookies. In case of problems contact the administrator.';
$lang['ccs_other_user']						= 'Cookie error! Your cookie does not match the user! You must delete your cookies. In case of problems contact the administrator';
$lang['css_different_password']				= 'Cookie error! Session error, must connect again! You must delete your cookies. In case of problems contact the administrator.';
$lang['css_account_banned_message']			= 'YOUR ACCOUNT HAS BEEN SUSPENDED';
$lang['css_account_banned_expire']			= 'Expiration:';

//----------------------------------------------------------------------------//
//class.debug.php
$lang['cdg_mysql_not_available']			= 'mySQL is not available at the moment...';
$lang['cdg_error_message']					= 'Error, please contact the administrator. Error n°:';
$lang['cdg_fatal_error']					= 'FATAL ERROR';

//----------------------------------------------------------------------------//
//class.FlyingFleetsTable.php
$lang['cff_no_fleet_data']					= 'No fleet data';
$lang['cff_aproaching']						= 'They approach ';
$lang['cff_ships']							= ' ships';
$lang['cff_from_the_planet']				= 'from the planet ';
$lang['cff_from_the_moon']					= 'from the moon ';
$lang['cff_the_planet']						= 'the planet ';
$lang['cff_debris_field']					= 'debris field ';
$lang['cff_to_the_moon']					= 'to the moon ';
$lang['cff_the_position']					= 'position ';
$lang['cff_to_the_planet']					= ' to planet ';
$lang['cff_the_moon']						= ' the moon ';
$lang['cff_from_planet']					= 'the planet ';
$lang['cff_from_debris_field']				= 'the debris field ';
$lang['cff_from_the_moon']					= 'of the moon ';
$lang['cff_from_position']					= 'position ';
$lang['cff_missile_attack']					= 'Missile attack';
$lang['cff_from']							= ' from ';
$lang['cff_to']								= ' to ';
$lang['cff_one_of_your']					= 'One of your ';
$lang['cff_a']								= 'One ';
$lang['cff_of']								= ' of ';
$lang['cff_goes']							= ' goes ';
$lang['cff_toward']							= ' toward ';
$lang['cff_with_the_mission_of']			= '. With the mission of: ';
$lang['cff_to_explore']						= ' to explore ';
$lang['cff_comming_back']					= ' back ';
$lang['cff_back']							= 'Comming back';
$lang['cff_to_destination']					= 'Heading to destination';

//----------------------------------------------------------------------------//
// EXTRA LANGUAGE FUNCTIONS
$lang['fcm_moon']							= 'Moon';
$lang['fcp_colony']							= 'Colony';
$lang['fgp_require']						= 'Requires: ';
$lang['fgf_time']							= 'Construction Time: ';

//----------------------------------------------------------------------------//
// CombatReport.php
$lang['cr_lost_contact']					= 'Contact was lost with the attacking fleet.';
$lang['cr_first_round']						= '(The fleet was destroyed in the first round)';
$lang['cr_type']							= 'Type';
$lang['cr_total']							= 'Total';
$lang['cr_weapons']							= 'Weapons';
$lang['cr_shields']							= 'Shields';
$lang['cr_armor']							= 'Armor';
$lang['cr_destroyed']						= 'Destroyed!';

//----------------------------------------------------------------------------//
// FleetAjax.php
$lang['fa_not_enough_probes']				= 'Error, no sufficient probes';
$lang['fa_galaxy_not_exist']				= 'Error, the galaxy does not exist';
$lang['fa_system_not_exist']				= 'Error, the system does not exist';
$lang['fa_planet_not_exist']				= 'Error, the planet does not exist';
$lang['fa_not_enough_fuel']					= 'Error, you do not have enough fuel';
$lang['fa_no_more_slots']					= 'Error, you have no more slots available fleet';
$lang['fa_no_recyclers']					= 'Error, recyclers are not available';
$lang['fa_mission_not_available']			= 'Error, the mission is not available';
$lang['fa_no_ships']						= 'Error, no available ships';
$lang['fa_vacation_mode']					= 'Error, the player is in vacation mode';
$lang['fa_week_player']						= 'Error, the player is too weak';
$lang['fa_strong_player']					= 'Error, the player is too strong';
$lang['fa_not_spy_yourself']				= 'Error, can not spy on yourself';
$lang['fa_not_attack_yourself']				= 'Error, can not attack yourself';
$lang['fa_action_not_allowed']				= 'Error, action not permitted';
$lang['fa_vacation_mode_current']			= 'Error, you are in vacation mode';
$lang['fa_sending']							= 'Sending';

//----------------------------------------------------------------------------//
// MissilesAjax.php
$lang['ma_silo_level']						= 'You must be at least level 4 silo';
$lang['ma_impulse_drive_required']			= 'You must investigate the Impulse Drive.';
$lang['ma_not_send_other_galaxy']			= 'You can not send missiles to another galaxy.';
$lang['ma_planet_doesnt_exists']			= 'The objective world does not exist.';
$lang['ma_cant_send']						= 'You can not send ';
$lang['ma_missile']							= ' missiles, have only ';
$lang['ma_wrong_target']					= 'Wrong Target';
$lang['ma_no_missiles']						= 'There are no available Interplanetary Missile';
$lang['ma_add_missile_number']				= 'Enter the number of missiles that you want to send';
$lang['ma_misil_launcher']					= 'Rocket Launcher';
$lang['ma_small_laser']						= 'Light Laser';
$lang['ma_big_laser']						= 'Heavy Laser';
$lang['ma_gauss_canyon']					= 'Gauss Cannon';
$lang['ma_ionic_canyon']					= 'Ion Cannon';
$lang['ma_buster_canyon']					= 'Plasma Turret';
$lang['ma_small_protection_shield']			= 'Small Shield Dome';
$lang['ma_big_protection_shield']			= 'Large Shield Dome';
$lang['ma_all']								= 'All';
$lang['ma_missiles_sended']					= ' interplanetary missiles were sent. Main objective: ';

//----------------------------------------------------------------------------//
// topkb.php
$lang['tkb_top']                  			= 'Hall of Fame';
$lang['tkb_gratz']                  		= 'Das ganze Team gratuliert den Top 100';
$lang['tkb_platz']                  		= 'Platz';
$lang['tkb_beteiligte']             		= 'Beteiligte';
$lang['tkb_datum']                  		= 'Datum';
$lang['tkb_units']             				= 'Units';
$lang['tkb_legende']               		 	= '<b>Legende: </b>';
$lang['tkb_gewinner']              		 	= '<b>-Gewinner-</b>';
$lang['tkb_verlierer']              		= '<b>-Verlierer-</b>';
$lang['tkb_unentschieden']         			= '<b>-Beide Weiss, unentschieden- </b>';
$lang['tkb_missing']              		  	= '<br>Missing in Action: Der Useraccount existiert nicht mehr.';

//----------------------------------------------------------------------------//
// playercard.php
$lang['playercard']  						= "Playercard";
$lang['usernamelang'] 						= "<b>Username: </b>";
$lang['Heimatplanet'] 						= "<b>Heimatplanet: </b>";
$lang['allylang']     						= "<b>Allianz: </b>";
$lang['PN']           						= "Private Nachricht";
$lang['BUDDY']        						= "Freundesanfrage stellen";
$lang['Punkte']      						= "<b>Punkte</b>";
$lang['Rank']         						= "<b>Rank</b>";
$lang['Gebaeude']     						= "Geb&auml;ude";
$lang['Forschung']    						= "Forschung";
$lang['Fleet']       						= "Flotte";
$lang['Defs']         						= "Defensive";
$lang['Gesamt']       						= "Gesamt";
$lang['Fightstats']   						= "Kampfstatistik";
$lang['Gesamtk']      						= "K&auml;mpfe";
$lang['Erfolg']       						= "Kampfquote";
$lang['Siege']        						= "Siege";
$lang['Drawp']        						= "Unentschieden";
$lang['Loosi']       						= "Verloren";
$lang['KGesamt']      						= "Gesamtk&auml;mpfe";
$lang['Zerstoert']    						= " war an folgenden Zerst&ouml;rungen beteiligt.";
$lang['unitsshut']    						= "Geschossene Units";
$lang['unitsloos']    						= "Verlorene Units";
$lang['tfmetall']    						= "Gesamt Tr&uuml;mmerfeld Metall";
$lang['tfkristall']   						= "Gesamt Tr&uuml;mmerfeld Kristall";

//----------------------------------------------------------------------------//
// Chat

$lang['chat_title']                         = 'Chat';
$lang['chat_ally_title']                    = 'Allianzchat';  

$lang['chat_disc']                          = "Chat";
$lang['chat_message']                       = "Message";
$lang['chat_send']                          = "Send";
$lang['chat_history']                       = "History";

//----------------------------------------------------------------------------//
// Support

$lang['supp_header'] 						= "Support-System";
$lang['ticket_id'] 							= "#Ticket-ID";
$lang['subject'] 							= "Betreff";
$lang['status'] 							= "Status";
$lang['ticket_posted'] 						= "Ticket vom";
$lang['ticket_new'] 						= "neues Ticket erstellen";
$lang['input_text'] 						= "Beischreibung:";
$lang['answer_new'] 						= "Eine Antwort schreiben:";
$lang['text'] 								= "Details";
$lang['message_a'] 							= "Status der Nachricht:";
$lang['sendit_a'] 							= "Nachricht wurde eingef&uuml;gt.";
$lang['message_t'] 							= "Status des Tickets:";
$lang['sendit_t'] 							= "Ticket wurde eingetragen.";
$lang['close_t'] 							= "Ticket wurde geschlossen.";
$lang['sendit_error'] 						= "Fehler:";
$lang['sendit_error_msg'] 					= "Du hast vergessen etwas einzutragen!";
$lang['supp_admin_system'] 					= "Support-Adminpanel";
$lang['close_ticket'] 						= "Ticket schlie&szlig;en";
$lang['player'] 							= "Spielernamen";

//----------------------------------------------------------------------------//
// Rekorde 

$lang['rec_title'] 							= "XNova Elite Rekord";
$lang['rec_build']  						= "Geb&auml;ude";
$lang['rec_specb']							= "Besondere Geb&auml;ude";
$lang['rec_playe']  						= "Spieler";
$lang['rec_defes']  						= "Verteidigung";
$lang['rec_fleet']  						= "Schiffe";
$lang['rec_techn']  						= "Forschung";
$lang['rec_level']  						= "Level";
$lang['rec_nbre']   						= "Anzahl";
$lang['rec_rien']   						= "-";
?>