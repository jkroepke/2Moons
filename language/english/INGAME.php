<?php

//LOCAL INFO
 
$lang['local_info'][0]                        = 'de_DE.UTF-8'; // Linux
$lang['local_info'][1]                        = 'de'; // Linux
$lang['local_info'][2]                        = 'DEU'; // Windows (http://msdn.microsoft.com/en-us/library/39cwe7zf%28vs.71%29.aspx)

//SERVER GENERALS
$lang['Metal']								= 'Metal';
$lang['Crystal']							= 'Crystal';
$lang['Deuterium']							= 'Deuterium';
$lang['Darkmatter']							= 'Dark matter';
$lang['Energy']								= 'Energy';
$lang['Messages']							= 'Messages';
$lang['write_message']						= 'Write a message';

$lang['show_planetmenu']					= 'Show / Hide';

$lang['type_mission'][1]  					= 'Attack';
$lang['type_mission'][2]  					= 'Association Attack';
$lang['type_mission'][3]  					= 'Transport';
$lang['type_mission'][4]  					= 'Deploy';
$lang['type_mission'][5]  					= 'Hold';
$lang['type_mission'][6]  					= 'Spy';
$lang['type_mission'][7]  					= 'Colonization';
$lang['type_mission'][8]  					= 'Recycle';
$lang['type_mission'][9]  					= 'Destroy';
$lang['type_mission'][11]  					= 'DM Investigation';
$lang['type_mission'][15] 					= 'Expedition';

$lang['user_level'] = array (
	'0' => 'Player',
	'1' => 'Moderator',
	'2' => 'Operator',
	'3' => 'Administrator',
);

// GAME.PHP
$lang['see_you_soon']						= 'Thanks for playing';
$lang['page_doesnt_exist']					= 'This page does not exist';


//----------------------------------------------------------------------------//
//TOPNAV
$lang['tn_vacation_mode']					= 'You are in vacation mode ';
$lang['tn_delete_mode']						= 'Your account %s is set to be deleted!';

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
$lang['lm_officiers']						= 'Officiers & DM-Store';
$lang['lm_trader']							= 'Trader';
$lang['lm_technology']						= 'Technology';
$lang['lm_messages']						= 'Messages';
$lang['lm_alliance']						= 'Alliance';
$lang['lm_buddylist']						= 'Buddylist';
$lang['lm_notes']							= 'Notes';
$lang['lm_statistics']						= 'Statistics';
$lang['lm_search']							= 'Search';
$lang['lm_options']							= 'Options';
$lang['lm_banned']							= 'Banned';
$lang['lm_contact']							= 'contact';
$lang['lm_forums']							= 'Forum';
$lang['lm_logout']							= 'Logout';
$lang['lm_administration']					= 'Administration';
$lang['lm_game_speed']						= 'Game';
$lang['lm_fleet_speed']						= 'Fleet';
$lang['lm_resources_speed']					= 'Resources';
$lang['lm_queue']							= 'Queues';
$lang['lm_topkb']							= 'Hall of Fame';
$lang['lm_faq']								= 'Beginners Guide';
$lang['lm_records']							= 'Records';
$lang['lm_chat']							= '<font size=2><font color="red">Chat';
$lang['lm_support']							= 'Support Ticket';
$lang['lm_rules']							= 'Rules';


//----------------------------------------------------------------------------//
//OVERVIEW

$lang['ov_newname_alphanum']				= 'The planets name must consist only of alphanumeric characters.';
$lang['ov_newname_no_space']				= 'The planets name can not contain spaces.';
$lang['ov_planet_abandoned']				= 'Planet successfully given up!';
$lang['ov_principal_planet_cant_abanone']	= 'You can not delete your main planet!';
$lang['ov_abandon_planet_not_possible']		= 'Colony not be deleted if the fleet activities take place to or from their colony!';
$lang['ov_wrong_pass']						= 'Wrong password. Try it again!';
$lang['ov_have_new_message']				= 'You have a new message';
$lang['ov_have_new_messages']				= 'You have %d new messages';
$lang['ov_planetmenu']						= 'Name Change / Delete';
$lang['ov_free']							= 'Free';
$lang['ov_news']							= 'News';
$lang['ov_place']							= 'Place';
$lang['ov_of']								= 'of';
$lang['ov_planet']							= 'Planet';
$lang['ov_server_time']						= 'Server time ';
$lang['ov_events']							= 'Events';
$lang['ov_diameter']						= 'Diameter';
$lang['ov_distance_unit']					= 'km';
$lang['ov_temperature']						= 'Temperature';
$lang['ov_aprox']							= 'Approximately';
$lang['ov_temp_unit']						= '°C';
$lang['ov_to']								= 'to';
$lang['ov_position']						= 'Position';
$lang['ov_points']							= 'Points';
$lang['ov_security_request']				= 'Security question';
$lang['ov_security_confirm']				= 'Please confirm that the planet';
$lang['ov_with_pass']						= 'want to give up.';
$lang['ov_password']						= 'Password';
$lang['ov_delete_planet']					= 'Delete planet';
$lang['ov_your_planet']						= 'Your planet';
$lang['ov_coords']							= 'Position';
$lang['ov_abandon_planet']					= 'Abandon colony';
$lang['ov_planet_name']						= 'Name';
$lang['ov_actions']							= 'Actions';
$lang['ov_planet_rename']					= 'Rename';
$lang['ov_planet_rename_action']			= 'Rename';
$lang['ov_fields']							= 'Fields';
$lang['ov_developed_fields']                = 'Developed fields';
$lang['ov_max_developed_fields']			= 'max. developed fields';
$lang['ov_fleet']							= 'Fleets';
$lang['ov_admins_online']					= 'Admins(Online):';
$lang['ov_no_admins_online']				= 'Currently, none online!';
$lang['ov_userbanner']						= 'User Statistics Banner';
$lang['ov_userrank_info']					= '%s (%s <a href="game.php?page=statistics&amp;range=%d">%d</a> %s %s)';
$lang['ov_teamspeak_not_online']			= 'Server is currently unreachable. We ask for your understanding.';
$lang['ov_teamspeak']						= 'Teamspeak';
$lang['ov_teamspeak_v2']					= '<a href="teamspeak://%s:%s?nickname=%s" title="Teamspeak Connect">Connect</a> &bull; Online: %d/%d &bull; Channels: %d &bull; Traffic ges.: %s MB';
$lang['ov_teamspeak_v3']					= '<a href="ts3server://%s?port=%d&amp;nickname=%s&amp;password=%s" title="Teamspeak Connect">Connect</a>&nbsp;&bull;&nbsp;Online: %d/%d &bull; Channels: %d &bull; Traffic ges.: %s MB &bull; Version: %s';

//----------------------------------------------------------------------------//
//GALAXY
$lang['gl_no_deuterium_to_view_galaxy']		= 'You do not have enough deuterium!';
$lang['gl_legend']							= 'Legend';
$lang['gl_strong_player']					= 'Strong player';
$lang['gl_week_player']						= 'Weak player';
$lang['gl_vacation']						= 'Vacation Mode';
$lang['gl_banned']							= 'Banned';
$lang['gl_inactive_seven']					= '7 Days inactive';
$lang['gl_inactive_twentyeight']			= '28 Days inactive';
$lang['gl_s']								= 'S';
$lang['gl_w']								= 'W';
$lang['gl_v']								= 'V';
$lang['gl_b']								= 'B';
$lang['gl_i']								= 'i';
$lang['gl_I']								= 'I';
$lang['gl_populed_planets']					= '%d Planet inhabited';
$lang['gl_out_space']						= 'The vastness of the universe';
$lang['gl_avaible_missiles']				= 'Missiles';
$lang['gl_fleets']							= 'Fleet Slots';
$lang['gl_avaible_grecyclers']				= 'Giga Recyclers';
$lang['gl_avaible_recyclers']				= 'Recyclers';
$lang['gl_avaible_spyprobes']				= 'Espionage Probes';
$lang['gl_missil_launch']					= 'Missile attack';
$lang['gl_missil_to_launch']				= 'Number of missiles (<b>%d</b> left):';
$lang['gl_all_defenses']					= 'All';
$lang['gl_objective']						= 'Objective';
$lang['gl_missil_launch_action']			= 'Submit';
$lang['gl_galaxy']							= 'Galaxy';
$lang['gl_solar_system']					= 'System';
$lang['gl_show']							= 'Display';
$lang['gl_pos']								= 'Pos';
$lang['gl_planet']							= 'Planet';
$lang['gl_name_activity']					= 'Name (Activity)';
$lang['gl_moon']							= 'Moon';
$lang['gl_debris']							= 'DF';
$lang['gl_player_estate']					= 'Players (Status)';
$lang['gl_alliance']						= 'Alliance';
$lang['gl_actions']							= 'Action';
$lang['gl_spy']								= 'Spy';
$lang['gl_buddy_request']					= 'Buddy request';
$lang['gl_missile_attack']					= 'Missile attack';
$lang['gl_with']							= ' with ';
$lang['gl_member']							= '%d Members';
$lang['gl_member_add']						= '%d Member';
$lang['gl_alliance_page']					= 'Alliance page';
$lang['gl_see_on_stats']					= 'Statistics';
$lang['gl_alliance_web_page']				= 'Alliance Home';
$lang['gl_debris_field']					= 'Debris field';
$lang['gl_collect']							= 'Collect';
$lang['gl_resources']						= 'Resources';
$lang['gl_features']						= 'Features';
$lang['gl_diameter']						= 'Diameter';
$lang['gl_temperature']						= 'Temperature';
$lang['gl_phalanx']							= 'Phalanx';
$lang['gl_planet_destroyed']				= 'Destroyed Planet';
$lang['gl_playercard']						= 'Playercard';
$lang['gl_in_the_rank']						= 'Player %s is Rank %d';
$lang['gl_activity']                                            = '(*)';
$lang['gl_activity_inactive']                                   = '(%d min)';
$lang['gl_ajax_status_ok']                    = 'Done';
$lang['gl_ajax_status_fail']                = 'Error';

//----------------------------------------------------------------------------//
//PHALANX
$lang['px_no_deuterium']					= 'You do not have enough deuterium!';
$lang['px_scan_position']					= 'Scan Position';
$lang['px_fleet_movement']					= 'Current fleet movements';
$lang['px_no_fleet']						= 'No fleet movements present.';

//----------------------------------------------------------------------------//
//EMPIRE
$lang['iv_imperium_title']					= 'Empire Overview';
$lang['iv_planet']							= 'Planet';
$lang['iv_name']							= 'Name';
$lang['iv_coords']							= 'Coordinates';
$lang['iv_fields']							= 'Fields';
$lang['iv_resources']						= 'Resources';
$lang['iv_buildings']						= 'Buildings';
$lang['iv_technology']						= 'Research';
$lang['iv_ships']							= 'Ships';
$lang['iv_defenses']						= 'Defense';

//----------------------------------------------------------------------------//
//FLEET - FLEET1 - FLEET2 - FLEET3 - FLEETACS - FLEETSHORTCUTS
$lang['fl_returning']						= 'Fleet on Planet';
$lang['fl_onway']							= 'Fleet to Planet';
$lang['fl_r']								= '(R)';
$lang['fl_a']								= '(A)';
$lang['fl_send_back']						= 'Back';
$lang['fl_acs']								= 'ACS';
$lang['fl_no_more_slots']					= 'All fleet slots are being used';
$lang['fl_speed_title']						= 'Speed: ';
$lang['fl_continue']						= 'continue';
$lang['fl_no_ships']						= 'There are no available ships';
$lang['fl_remove_all_ships']				= 'No ships';
$lang['fl_select_all_ships']				= 'All ships';
$lang['fl_fleets']							= 'Fleets';
$lang['fl_expeditions']						= 'Expeditions';
$lang['fl_number']							= 'ID';
$lang['fl_mission']							= 'Mission';
$lang['fl_ammount']							= 'Ships (total)';
$lang['fl_beginning']						= 'Start';
$lang['fl_departure']						= 'Arrival (target)';
$lang['fl_destiny']							= 'Destiny';
$lang['fl_objective']						= 'Objective';
$lang['fl_arrival']							= 'Arrival (Back)';
$lang['fl_info_detail']						= 'Fleet-Details';
$lang['fl_order']							= 'Order';
$lang['fl_new_mission_title']				= 'New Order: Select Fleet';
$lang['fl_ship_type']						= 'Ship Type';
$lang['fl_ship_available']					= 'Available';
$lang['fl_planet']							= 'Planet';
$lang['fl_debris']							= 'Debris';
$lang['fl_moon']							= 'Moon';
$lang['fl_planet_shortcut']					= '(P)';
$lang['fl_debris_shortcut']					= '(D)';
$lang['fl_moon_shortcut']					= '(M)';
$lang['fl_no_shortcuts']					= 'No shortcuts available';
$lang['fl_anonymous']						= 'Anonymous';
$lang['fl_shortcut_add_title']				= 'Name [Galaxy/System/Planet]';
$lang['fl_shortcut_name']					= 'Name';
$lang['fl_shortcut_galaxy']					= 'Galaxy';
$lang['fl_shortcut_solar_system']			= 'System';
$lang['fl_clean']							= 'Reset';
$lang['fl_register_shorcut']				= 'Create';
$lang['fl_shortcuts']						= 'Shortcuts';
$lang['fl_reset_shortcut']					= 'Reset';
$lang['fl_dlte_shortcut']					= 'Delete';
$lang['fl_back']							= 'Back';
$lang['fl_shortcut_add']					= 'Add';
$lang['fl_shortcut_edition']				= 'Edit: ';
$lang['fl_no_colony']						= 'No colonies present';
$lang['fl_send_fleet']						= 'Send Fleet';
$lang['fl_fleet_speed']						= 'Speed';
$lang['fl_distance']						= 'Distance';
$lang['fl_flying_time']						= 'Duration (one way)';
$lang['fl_fuel_consumption']				= 'Fuel consumption';
$lang['fl_max_speed']						= 'Maximum Speed';
$lang['fl_cargo_capacity']					= 'Cargo capacity';
$lang['fl_shortcut']						= 'Shortcut';
$lang['fl_shortcut_add_edit']				= '(Create / Modify)';
$lang['fl_my_planets']						= 'My Planet';
$lang['fl_acs_title']						= 'Association Attacks';
$lang['fl_hold_time']						= 'Hold time';
$lang['fl_resources']						= 'Resources';
$lang['fl_max']								= 'max';
$lang['fl_hours']							= 'Hour(s)';
$lang['fl_resources_left']					= 'Remaining';
$lang['fl_all_resources']					= 'Max Resource Load';
$lang['fl_empty_target']					= 'No missions available (planet exists?)';
$lang['fl_expedition_alert_message']		= 'Attention! Expeditions are dangerous missions, you can lose your ships!';
$lang['fl_dm_alert_message']				= 'Be careful, if in the %s %s was found, the fleet is destroyed!';
$lang['fl_vacation_mode_active']			= 'You are in vacation mode';
$lang['fl_expedition_tech_required']		= 'Astrophysics tech required!';
$lang['fl_expedition_fleets_limit']			= 'Expedition fleets limit reached!';
$lang['fl_week_player']						= 'The player is very weak!';
$lang['fl_strong_player']					= 'The player is very strong!';
$lang['fl_in_vacation_player']				= 'Player is in vacation mode';
$lang['fl_no_slots']						= 'Slots no longer available!';
$lang['fl_empty_transport']					= 'You can not transport 0 resources!';
$lang['fl_planet_populed']					= 'This planet is occupied!';
$lang['fl_stay_not_on_enemy']				= 'You can not park fleets on the enemy planets!';
$lang['fl_not_ally_deposit']				= 'No Alliance Depot';
$lang['fl_deploy_only_your_planets']		= 'You can only deploy fleets on your planets!';
$lang['fl_no_enought_deuterium']			= 'You do not have enough %s available. You lack %s %s!';
$lang['fl_no_enought_cargo_capacity']		= 'You do not have enough cargo space available:';
$lang['fl_admins_cannot_be_attacked']		= 'You can not attack Administrators';
$lang['fl_fleet_sended']					= 'Fleet sent';
$lang['fl_from']							= 'From';
$lang['fl_arrival_time']					= 'Arrival Time';
$lang['fl_return_time']						= 'Return time';
$lang['fl_fleet']							= 'Fleet';
$lang['fl_player']							= 'The player ';
$lang['fl_add_to_attack']					= ' was invited.';
$lang['fl_dont_exist']						= ' does not exist.';
$lang['fl_acs_invitation_message']			= ' invites you to participate in a ACS.';
$lang['fl_acs_invitation_title']			= 'Invitation to acs';
$lang['fl_sac_of_fleet']					= 'ACS fleet';
$lang['fl_modify_sac_name']					= 'Change the name of the ACS';
$lang['fl_members_invited']					= 'Members invited';
$lang['fl_invite_members']					= 'Invite other members';

//----------------------------------------------------------------------------//
//BUILDINGS - RESEARCH - SHIPYARD - DEFENSES
$lang['bd_dismantle']						= 'Deconstruct';
$lang['bd_interrupt']						= 'Pause';
$lang['bd_cancel']							= 'cancel';
$lang['bd_working']							= 'Working';
$lang['bd_build']							= 'Build';
$lang['bd_build_next_level']				= 'Upgrade to level ';
$lang['bd_add_to_list']						= 'Add to production queue';
$lang['bd_no_more_fields']					= 'No more room on the planet!';
$lang['bd_remaining']						= 'You need this much more to build:';
$lang['bd_lab_required']					= 'You need to build a research laboratory on this planet first!';
$lang['bd_building_lab']					= 'The research laboratory is be expanded!';
$lang['bd_max_lvl']							= '(Max. Level: %s)';
$lang['bd_lvl']								= 'Level';
$lang['bd_research']						= 'Research';
$lang['bd_shipyard_required']				= 'You need to build a shipyard on this planet first!';
$lang['bd_building_shipyard']				= 'The Nanite or shipyard is currently being developed!';
$lang['bd_available']						= 'Available: ';
$lang['bd_build_ships']						= 'Build';
$lang['bd_protection_shield_only_one']		= 'The shield can be built only once!';
$lang['bd_build_defenses']					= 'Build';
$lang['bd_actual_production']				= 'Actual production:';
$lang['bd_completed']						= 'Completed';
$lang['bd_operating']						= 'In progress';
$lang['bd_continue']						= 'Continue';
$lang['bd_ready']							= 'Finished';
$lang['bd_finished']						= 'Finished';
$lang['bd_maxlevel']						= 'Maximum level attained';
$lang['bd_on']								= 'on';
$lang['bd_max_builds']						= 'You can max. %d Send orders!';
$lang['bd_next_level']						= 'Next Level:';
$lang['bd_need_engine']						= 'Consume  <font color="#FF0000">%s</font> %s more';
$lang['bd_more_engine']						= 'Produced <font color="#00FF00">%s</font> %s more';
$lang['bd_jump_gate_action']				= 'Jump to';
$lang['bd_cancel_warning']					= 'During demolition, only 60% of Resources will be restored!';
$lang['bd_cancel_send']						= 'Delete - Selected';

//----------------------------------------------------------------------------//
//RESOURCES
$lang['rs_amount']							= 'Quantity';
$lang['rs_lvl']								= 'level';
$lang['rs_production_on_planet']			= 'Resource production on planet "%s"';
$lang['rs_basic_income']					= 'Basic Income';
$lang['rs_storage_capacity']				= 'Storage Capacity';
$lang['rs_calculate']						= 'calculate';
$lang['rs_sum']								= 'Total:';
$lang['rs_daily']							= 'Res per day:';
$lang['rs_weekly']							= 'Res per week:';
$lang['rs_ress_bonus']						= 'Bonus(Officer/DM-Bonus):';

//----------------------------------------------------------------------------//
//OFFICIERS
$lang['of_recruit']							= 'Recruit';
$lang['of_max_lvl']							= 'Max. Level';
$lang['of_available_points']				= 'Available Points:';
$lang['of_points_per_thousand_darkmatter']	= '(1 point for %d %s)';
$lang['of_lvl']								= 'Level';
$lang['of_dm_trade']						= '%s - Store';
$lang['of_still']							= 'still';
$lang['of_active']							= 'active';
$lang['of_update']							= 'update';

//----------------------------------------------------------------------------//
//TRADER
$lang['tr_empty_darkmatter']				= 'You do not have enough %s!';
$lang['tr_cost_dm_trader']					= 'The merchant fees amount to %s %s!';
$lang['tr_only_positive_numbers']			= 'You may only use positive numbers!';
$lang['tr_not_enought_metal']				= 'You do not have enough metal.';
$lang['tr_not_enought_crystal']				= 'You do not have enough crystal.';
$lang['tr_not_enought_deuterium']			= 'You do not have enough deuterium';
$lang['tr_exchange_done']					= 'Exchange successful';
$lang['tr_call_trader']						= 'Call a dealer';
$lang['tr_call_trader_who_buys']			= 'Call a dealer who buys ';
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

//----------------------------------------------------------------------------//
//INFOS
$lang['in_jump_gate_done']					= 'The jump gate was used, the next jump can be made in: ';
$lang['in_jump_gate_error_data']			= 'Error, data for the jump is not correct!';
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

//----------------------------------------------------------------------------//
//MESSAGES

$lang['mg_type'][0]    						= 'Spy reports';
$lang['mg_type'][1]    						= 'Messages from players';
$lang['mg_type'][2]   						= 'Messages from ally';
$lang['mg_type'][3]    						= 'Battle reports';
$lang['mg_type'][4]    						= 'System messages';
$lang['mg_type'][5]    						= 'Transportation reports';
$lang['mg_type'][15]   						= 'Expedition reports';
$lang['mg_type'][50]						= 'Game news';
$lang['mg_type'][99]   						= 'Construction reports';
$lang['mg_type'][100]						= 'View all Messages';
$lang['mg_type'][999]						= 'Outbox';
$lang['mg_no_subject']						= 'No subject';
$lang['mg_no_text']							= 'No text provided';
$lang['mg_msg_sended']						= 'Message sent!';
$lang['mg_delete_marked']					= 'Delete marked messages';
$lang['mg_delete_type_all']					= 'Delete all messages of this type';
$lang['mg_delete_unmarked']					= 'Delete all unmarked messages';
$lang['mg_delete_all']						= 'Delete all messages';
$lang['mg_show_only_header_spy_reports']	= 'show only partial espionage reports';
$lang['mg_action']							= 'Action';
$lang['mg_date']							= 'Date';
$lang['mg_from']							= 'from';
$lang['mg_to']								= 'to';
$lang['mg_subject']							= 'subject';
$lang['mg_confirm_delete']					= 'Confirm';
$lang['mg_message_title']					= 'Messages';
$lang['mg_message_type']					= 'Message type';
$lang['mg_total']							= 'Total';
$lang['mg_game_operators']					= 'Game operators';
$lang['mg_error']							= 'Recipient not found!';
$lang['mg_overview']						= 'News Administration';
$lang['mg_send_new']						= 'Write a message';
$lang['mg_send_to']							= 'Recipient';
$lang['mg_message']							= 'Message';
$lang['mg_characters']						= 'Characters';
$lang['mg_send']							= 'Send';
$lang['mg_game_message']					= 'Game Message';

//----------------------------------------------------------------------------//
//ALLIANCE

$lang['al_newname_alphanum']				= 'The Alliance name and date shall consist only of alphanumeric characters.';
$lang['al_newname_no_space']				= 'The Alliance name and date must not contain spaces.';
$lang['al_description_message'] 			= 'Alliance description message';
$lang['al_web_text']						= 'Alliance web site';
$lang['al_request'] 						= 'Application';
$lang['al_click_to_send_request'] 			= 'Click here to send your application to the alliance';
$lang['al_tag_required'] 					= 'Alliance tag missing.';
$lang['al_name_required'] 					= 'Alliance name missing.';
$lang['al_already_exists'] 					= 'The alliance %s already exists.';
$lang['al_created'] 						= 'The alliance %s was created!';
$lang['al_continue'] 						= 'continue';
$lang['al_alliance_closed'] 				= 'This alliance does not accept new members.';
$lang['al_request_confirmation_message']	= 'Application registered. You Will receive a message when your application is approved / rejected. <br><a href="?page=alliance">back</a>';
$lang['al_default_request_text']			= 'The alliance leaders have not set an example of application, or have no pretensions.';
$lang['al_write_request'] 					= 'Write application to the alliance %s';
$lang['al_request_deleted'] 				= 'You have deleted the application. <br> you can then create your own or join one other.';
$lang['al_request_wait_message'] 			= 'Youve already sent a request to the alliance %s <br>';
$lang['al_delete_request'] 					= 'Delete aplication';
$lang['al_founder_cant_leave_alliance'] 	= 'The founder can not abandon the alliance.';
$lang['al_leave_sucess'] 					= 'You leave the alliance %s succesfully.';
$lang['al_do_you_really_want_to_go_out'] 	= 'Do you really want to leave the alliance %s ?';
$lang['al_go_out_yes'] 						= 'Yes';
$lang['al_go_out_no'] 						= 'No';
$lang['al_close_ally'] 						= 'Do you really want to give up the alliance?';
$lang['al_kick_player']						= 'Do you really want the player %s removed from the alliance?';
$lang['al_circular_sended'] 				= "Circular message sended, Following players will receive your circular message:";
$lang['al_all_players'] 					= 'All players';
$lang['al_no_ranks_defined'] 				= 'No ranks defined.'; 
$lang['al_request_text']					= 'Application text';
$lang['al_inside_text']						= 'Internal text';
$lang['al_outside_text']					= 'External text';
$lang['al_transfer_alliance']				= 'Transfer alliance';
$lang['al_disolve_alliance']				= 'Disolve alliance';
$lang['al_founder_rank_text']				= 'Founder';
$lang['al_new_member_rank_text']			= 'New member';
$lang['al_acept_request']					= 'Accept';
$lang['al_you_was_acceted']					= 'You are accepted in ';
$lang['al_hi_the_alliance']					= 'Hello!<br>The alliance <b>';
$lang['al_has_accepted']					= '</b> has accepted your application.<br>Founders Message: <br>';
$lang['al_decline_request']					= 'Reject';
$lang['al_you_was_declined']				= 'You were rejected in ';
$lang['al_has_declined']					= '</b> the alliance reject your aplication!<br>Founders Message: <br>';
$lang['al_no_requests']						= 'No requests';
$lang['al_request_from']					= 'Request from "%s"';
$lang['al_no_request_pending']				= 'There are %d application (s)';
$lang['al_name']							= 'name';
$lang['al_new_name']						= 'New name (3-30 Characters):';
$lang['al_tag']								= 'tag';
$lang['al_new_tag']							= 'New tag (3-8 Characters):';
$lang['al_user_list']						= 'Member List';
$lang['al_users_list']						= 'member list (players: %d)';
$lang['al_manage_alliance']					= 'manage alliance';
$lang['al_send_circular_message']			= 'send circular message';
$lang['al_new_requests']					= '%d new request/s';
$lang['al_save']							= 'Save';
$lang['al_dlte']							= 'Delete';
$lang['al_rank_name']						= 'Rank name';
$lang['al_ok']								= 'OK';
$lang['al_num']								= 'ID';
$lang['al_member']							= 'Name';
$lang['al_request_from_user']				= 'Application of player';
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
$lang['al_candidate']						= 'Name';
$lang['al_request_date']					= 'Date';
$lang['al_transfer_alliance']				= 'Resign/take over this alliance?';
$lang['al_transfer_to']						= 'Transfer to';
$lang['al_transfer_submit']					= 'Submit';
$lang['al_ally_information']				= 'Alliance information';
$lang['al_ally_info_tag']					= 'Tag';
$lang['al_ally_info_name']					= 'Name';
$lang['al_ally_info_members']				= 'Members';
$lang['al_your_request_title']				= 'Your aplication';
$lang['al_applyform_send']					= 'Send';
$lang['al_applyform_reload']				= 'Reload';
$lang['al_circular_send_ciruclar']			= 'Send circular message';
$lang['al_circular_alliance']               = 'Alliance ';
$lang['al_receiver']						= 'Recipient';
$lang['al_circular_send_submit']			= 'Send';
$lang['al_circular_reset']					= 'Reset';
$lang['al_alliance']						= 'Alliances ';
$lang['al_alliance_make']					= 'Found your own alliance';
$lang['al_alliance_search']					= 'Search for alliances';
$lang['al_your_ally']						= 'Your alliance';
$lang['al_rank']							= 'Rank';
$lang['al_web_site']						= 'Homepage';
$lang['al_inside_section']					= 'Internal Area';
$lang['al_make_alliance']					= 'Found alliances';
$lang['al_make_ally_tag_required']			= 'Alliance Tag (3-8 characters)';
$lang['al_make_ally_name_required']			= 'Alliance name (3-30 characters)';
$lang['al_make_submit']						= 'found';
$lang['al_find_alliances']					= 'Search for alliances';
$lang['al_find_text']						= 'Search for';
$lang['al_find_no_alliances']				= 'Found no alliance!';
$lang['al_find_submit']						= 'Search';
$lang['al_manage_ranks']					= 'Manage Ranks';
$lang['al_manage_members']					= 'Manage Members';
$lang['al_manage_change_tag']				= 'Change the tag of the alliance';
$lang['al_manage_change_name']				= 'Change the name of the alliance';
$lang['al_texts']							= 'Text Management';
$lang['al_manage_options']					= 'Options';
$lang['al_manage_image']					= 'Alliance logo';
$lang['al_manage_requests']					= 'Applications';
$lang['al_manage_diplo']                    = 'Alliance Diplomacy';
$lang['al_requests_not_allowed']			= 'arent possible(alliance closed)';
$lang['al_requests_allowed']				= 'are possible(alliance open)';
$lang['al_manage_founder_rank']				= 'Founder rank';
$lang['al_configura_ranks']					= 'Configure Rights';
$lang['al_create_new_rank']					= 'Create New Rank';
$lang['al_rank_name']						= 'Name';
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
$lang['al_legend_right_hand']				= 'Right Hand (necessary to transfer founder rank)';
$lang['al_requests']						= 'Requests';
$lang['al_circular_message']				= 'Circular message';
$lang['al_leave_alliance']					= 'Leave this alliance';
$lang['al_Gesamtk']     					= 'Fights';
$lang['al_Erfolg']       					= 'Fight Odds';
$lang['al_Siege']        					= 'Win';
$lang['al_Drawp']        					= 'Draw';
$lang['al_Loosi']        					= 'Lost';
$lang['al_KGesamt']      					= 'Total fights';
$lang['al_Allyquote']    					= 'Fight records of ally member';
$lang['al_Quote']        					= 'Victory qoute';
$lang['al_unitsshut']    					= 'Units Kill';
$lang['al_unitsloos']    					= 'Units Lost';
$lang['al_tfmetall']     					= 'Total metal debris';
$lang['al_tfkristall']   					= 'Total Crystal debris';
$lang['al_view_stats']						= 'Battle record in public?';
$lang['al_view_diplo']                      = 'Public diplomacy?';
$lang['al_memberlist_min']					= 'min';
$lang['al_memberlist_on']					= 'Online';
$lang['al_memberlist_off']					= 'Offline';
$lang['al_diplo']                            = 'Diplomacy';
$lang['al_diplo_level'][0]                    = 'Wing';
$lang['al_diplo_level'][1]                    = 'Alliance ';
$lang['al_diplo_level'][2]                    = 'Trade Alliance';
$lang['al_diplo_level'][3]                    = 'Non aggression pact';
$lang['al_diplo_level'][4]                    = 'War';
$lang['al_diplo_no_entry']                    = '- No pact exists -';
$lang['al_diplo_no_accept']                    = '- No request available -';
$lang['al_diplo_accept']                    = 'Incoming requests';
$lang['al_diplo_accept_send']                = 'Outgoing requests';
$lang['al_diplo_create']                    = 'Create a new pact.';
$lang['al_diplo_create_done']                = 'Pact created successfully.';
$lang['al_diplo_ally']                        = 'Alliance ';
$lang['al_diplo_level_des']                    = 'Ark of the Covenant';
$lang['al_diplo_text']                        = 'Question Text/Justification';
$lang['al_diplo_accept_yes']                = 'Pact signed.';
$lang['al_diplo_accept_yes_mes']            = 'The pact of %s was signed between the alliances %s and %s!';
$lang['al_diplo_accept_no']                    = 'Pact rejected.';
$lang['al_diplo_accept_no_mes']                = 'The the pact of %s between the alliances %s and %s has been rejected!';
$lang['al_diplo_delete']                    = 'Abolish pact.';
$lang['al_diplo_delete_mes']                = 'The pact of %s between the alliances %s and %s  has been lifted!';
$lang['al_diplo_confirm_delete']            = 'Do you really want to delete the pact?';
$lang['al_diplo_ground']                    = 'Reason:';
$lang['al_diplo_ask']                        = 'Covenant Enquiry';
$lang['al_diplo_ask_mes']                    = 'There is a pact request of (%s) for the alliances -> %s <- and the -> %s <-. <br>Reason: %s <br> If receving you can accept or deny under Manage alliance then Alliance Diplomacy';
$lang['al_diplo_war']                        = 'Declaration of war';
$lang['al_diplo_war_mes']                    = 'War has been declared between the alliances  -> %s <- and -> %s <-.<br>Reason: %s <br><br>Information: Both Alliance leaders NEED to agree to the war in a post, started in the war section of the Forum. Only after both leaders make the agreement, is the rule of bashing eliminated between the two alliances at war. <br>Read the rules from left menu link or in the forum. You can click here to link to forum. <a href="http://darkogame.us/forum/viewforum.php?f=8" target="_blank"> War/Diplomacy</a>.';

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
$lang['bu_minutes']							= ' min';
$lang['bu_disconnected']					= 'Offline';
$lang['bu_online']							= 'Online';
$lang['bu_buddy_list']						= 'Buddy list';
$lang['bu_requests']						= 'Applications';
$lang['bu_alliance']						= 'Alliance';
$lang['bu_coords']							= 'Coordinates';
$lang['bu_text']							= 'Text';
$lang['bu_action']							= 'Action';
$lang['bu_my_requests']						= 'My Requests';
$lang['bu_partners']						= 'Buddys';
$lang['bu_delete']							= 'delete';
$lang['bu_no_request']						= 'no request!';
$lang['bu_no_buddys']						= 'No buddies so far!';
$lang['bu_request_send']					= 'Request Sent!';

//----------------------------------------------------------------------------//
//NOTES
$lang['nt_important']						= 'Important';
$lang['nt_normal']							= 'Normal';
$lang['nt_unimportant']						= 'Unimportant';
$lang['nt_create_note']						= 'Create note';
$lang['nt_you_dont_have_notes']				= 'No notes available';
$lang['nt_notes']							= 'Notes';
$lang['nt_create_new_note']					= 'Create a new note';
$lang['nt_edit_note']						= 'Edit Note';
$lang['nt_date_note']						= 'Date';
$lang['nt_subject_note']					= 'Subject';
$lang['nt_size_note']						= 'Size';
$lang['nt_dlte_note']						= 'Delete';
$lang['nt_priority']						= 'Priority';
$lang['nt_note']							= 'Notice';
$lang['nt_characters']						= 'characters';
$lang['nt_back']							= 'Back';
$lang['nt_reset']							= 'Reset';
$lang['nt_save']							= 'Save';
$lang['nt_no_title']						= 'No title';
$lang['nt_no_text']							= 'No Text';

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

$lang['st_write_message']					= 'Private Message';

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
$lang['sh_write_message']					= 'Private Message';
$lang['sh_buddy_request']					= 'Buddy request';
$lang['sh_alliance']						= 'Alliance';
$lang['sh_planet']							= 'Planet';
$lang['sh_coords']							= 'Position';
$lang['sh_position']						= 'Rank';


//----------------------------------------------------------------------------//
//OPTIONS
$lang['op_cant_activate_vacation_mode']		= 'If youre building or moving fleets will not be able to enter on vacation mode.';
$lang['op_password_changed']				= 'Password has been changed<br><a href="index.php" target="_top">back</a>';
$lang['op_username_changed']				= 'Username changed<br><a href="index.php" target="_top">Back</a>';
$lang['op_options_changed']					= 'Changes saved.<br><a href="game.php?page=options">Back</a>';
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
$lang['op_skin_example']					= 'Skin path (z.B. C:/2moons/skins/)';
$lang['op_show_skin']						= 'Display skin';
$lang['op_deactivate_ipcheck']				= 'Disable IP Check';
$lang['op_galaxy_settings']					= 'Galaxy View Options';
$lang['op_spy_probes_number']				= 'Number of espionage probes';
$lang['op_toolt_data']						= 'Information tools';
$lang['op_seconds']							= 'seconds';
$lang['op_max_fleets_messages']				= 'Maximum fleet messages';
$lang['op_show_planetmenu']					= 'Planet View menu';
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
$lang['op_sort_normal']						= 'Order of creation';
$lang['op_sort_koords']						= 'Coordinates';
$lang['op_sort_abc']						= 'Alphabet';
$lang['op_sort_up']							= 'Ascending';
$lang['op_sort_down']						= 'Descending';
$lang['op_user_name_no_alphanumeric']		= 'Please enter the username only alphanumeric characters!';
$lang['op_change_name_pro_week']			= 'Can you change your user name only 1x per week';
$lang['op_change_name_exist']				= 'The name %s already exists';
$lang['op_active_build_messages']			= 'Build queue news';
$lang['op_small_storage']                    = 'Shorten storage numbers shown';

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
$lang['bn_writemail']						= 'Mail to %s';

//----------------------------------------------------------------------------//
//SYSTEM
$lang['sys_attacker_lostunits'] 			= "The attacker has lost a total of";
$lang['sys_defender_lostunits'] 			= "The defender has lost a total of";
$lang['sys_units']							= "units";
$lang['debree_field_1'] 					= "A debris field";
$lang['debree_field_2']						= "floating in the orbit of the planet.";
$lang['sys_moonproba'] 						= "The probability that a moon emerge from the rubble is:";
$lang['sys_moonbuilt'] 						= "The huge amount of metal and crystal are functioning and form a lunar satellite in orbit around the planet %s [%d:%d:%d] !";
$lang['sys_attack_title']    				= "Fleets clash in ";
$lang['sys_attack_round']					= "Round";
$lang['sys_attack_attacker_pos'] 			= "Aggressor";
$lang['sys_attack_techologies'] 			= 'Weapons: %d %% Shields: %d %% Armor: %d %% ';
$lang['sys_attack_defender_pos'] 			= "Defender";
$lang['sys_ship_type'] 						= "Type";
$lang['sys_ship_count'] 					= "Amount";
$lang['sys_ship_weapon'] 					= "Weapons";
$lang['sys_ship_shield'] 					= "Shields";
$lang['sys_ship_armour'] 					= "Armor";
$lang['sys_destroyed'] 						= "Destroyed";
$lang['fleet_attack_1'] 					= "The attacking fleet fires a total force of";
$lang['fleet_attack_2']						= "on the defender. The defenders shields absorb";
$lang['fleet_defs_1'] 						= "The defending fleet fires a total force of";
$lang['fleet_defs_2']						= "on the attacker. The attackers shields absorb";
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
$lang['sys_spy_defenses'] 					= "defenses";
$lang['sys_mess_qg'] 						= "Headquarters";
$lang['sys_mess_spy_report_moon']			= "(Moon)";
$lang['sys_mess_spy_report'] 				= "Espionage Report";
$lang['sys_mess_spy_lostproba'] 			= "Probability of detection of spy : %d %% ";
$lang['sys_mess_spy_control'] 				= "Space Control";
$lang['sys_mess_spy_activity'] 				= "Espionage activity";
$lang['sys_mess_spy_ennemyfleet'] 			= "An enemy fleet on the planet";
$lang['sys_mess_spy_seen_at'] 				= "was seen near your planet";
$lang['sys_mess_spy_seen_at2'] 				= 'sighted';
$lang['sys_mess_spy_destroyed'] 			= '<font color="red">Your espionage probes were destroyed!</font>';
$lang['sys_mess_attack_report_mess']		= '<a href="javascript:kb(\'%s\');"><center><font color="%s">%s %s</font></a><br><br><font color="%s">%s: %s</font> <font color="%s">%s: %s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font> %s:<font color="#f77542">%s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font><br></center>';
$lang['sys_adress_planet'] 					= '[%s:%s:%s]';
$lang['sys_stay_mess_goods'] 				= '%s : %s, %s : %s, %s : %s';
$lang['sys_stay_mess_back']					= 'One of your fleets reached the Planet ';
$lang['sys_stay_mess_bend']					= 'it delivers: ';
$lang['sys_colo_mess_from'] 				= "Colonization";
$lang['sys_colo_mess_report'] 				= "Report of settlement";
$lang['sys_colo_defaultname'] 				= "Colony";
$lang['sys_colo_arrival'] 					= "The settlers arrived at coordinates ";
$lang['sys_colo_maxcolo'] 					= ", but, unfortunately, can not colonize, can have no more ";
$lang['sys_colo_allisok'] 					= ", 	the settlers are beginning to build a new colony.";
$lang['sys_colo_badpos']  					= ", 	the settlers have found an environment conducive to the expansion of its empire. They decided to reverse totally disgusted ...";
$lang['sys_colo_notfree'] 					= ", 	settlers would not have found a planet with these details. They are forced to turn back completely demoralized ...";
$lang['sys_colo_planet']  					= " planet ";
$lang['sys_expe_report'] 					= "Report of expedition";
$lang['sys_recy_report'] 					= "Recycling Report";
$lang['sys_expe_blackholl_1'] 				= "The fleet was sucked into a black hole is partially destroyed.";
$lang['sys_expe_blackholl_2'] 				= "The fleet was sucked into a black hole, and was completely destroyed!";
$lang['sys_expe_found_goods'] 				= "Your scientists have found a resource-rich planet !<br>It has %s %s, %s %s and %s %s mined";
$lang['sys_expe_found_ships'] 				= "Researchers have found some spaceships in perfect condition!.<br>: ";
$lang['sys_expe_back_home'] 				= "Your expedition returned to the hangar.";
$lang['sys_expe_found_ress_1_1']			= 'Your expedition has discovered a small swarm of asteroids, from which some resources can be obtained.';
$lang['sys_expe_found_ress_1_2']			= 'On a remote planetoid some easily accessible resources fields were found and successfully extracted raw materials.';
$lang['sys_expe_found_ress_1_3']			= 'Your expedition ran into a very old ship wreck from a long-past battle. Individual components could be recovered and recycled.';
$lang['sys_expe_found_ress_1_4']			= 'The expedition came across a radioactively contaminated and highly toxic atmosphere asteroids. However, scans showed that this asteroid is very rich in resources. Using automatic drones they tried to gain the raw materials.';
$lang['sys_expe_found_ress_2_1']			= 'Your expedition discovered an ancient, fully loaded, but deserted freighter convoy. Some resources could be salvaged.';
$lang['sys_expe_found_ress_2_2']			= 'On a small moon with an atmosphere at your own expedition found large mineral deposits. The ground crews are here to gather these natural treasures.';
$lang['sys_expe_found_ress_2_3']			= 'We have taken a small convoy of civilian vessels in need of urgent food and medicines. In exchange, we received a lot of useful resources.';
$lang['sys_expe_found_ress_3_1']			= 'Your expedition fleet reports the discovery of a giant alien ship wrecks. With the technology they were not able to do anything, but the ship could be broken down into its component parts, through which they could gain valuable raw materials.';
$lang['sys_expe_found_ress_3_2']			= 'A mineral belt around an unknown planet contained vast quantities of raw materials. The expedition fleet reports full cargo!';
$lang['sys_expe_found_dm_1_1']				= 'The expedition has managed to capture a bit of dark matter and preserved it.';
$lang['sys_expe_found_dm_1_2']				= 'Our expedition had encountered a ghost ship that transported a small amount of dark matter. Although we can find no evidence of what has happened to the original crew, our technicians we able to recover the dark matter.';
$lang['sys_expe_found_dm_1_3']				= 'We came upon a strange alien aboard a small ship, which left us in exchange for a few simple mathematical calculations, a small container of dark matter.';
$lang['sys_expe_found_dm_1_4']				= 'We have found the remains of an alien ship. On board was a small container of dark matter!';
$lang['sys_expe_found_dm_1_5']				= 'The expedition follows some strange signals and discovered an asteroid that has a core with a small amount of dark matter. The asteroid was brought on board and the researchers are now trying to extract the dark matter.';
$lang['sys_expe_found_dm_2_1']				= 'Our expedition has succeeded in a unique experiment. They gathered dark matter from a dying star.';
$lang['sys_expe_found_dm_2_2']				= 'Our expedition reports a strange spectral phenomenon. This led to, among other things, that the energy storage of the ships shields forming dark matter. Our engineers are now trying, as long as possible, yet the phenomenon persists to preserve much of this dark matter.';
$lang['sys_expe_found_dm_2_3']				= 'Our expedition has found an ancient space station that has hovered well for a long time uncontrollably through space. The station itself was completely useless, but camped in one of its reactors, a small amount of dark matter. Our engineers are trying to recover as much as possible.';
$lang['sys_expe_found_dm_3_1']				= 'A spontaneous hyperspace distortion has enabled your expedition to ensure a large amount of dark matter!';
$lang['sys_expe_found_dm_3_2']				= 'Our expedition reports first contact with an energy creature that called itself Legorianer, It decided to help out the less developed species, a little - it gave a container of materialized dark matter tel-ported it on board the bridge!';
$lang['sys_expe_found_ships_1_1']			= 'We have come across the remnants of a previous expedition! Our technicians will look at whether some of the wrecks are able to be airworthy again.';
$lang['sys_expe_found_ships_1_2']			= 'We found a deserted pirate base. In the hangar are still some old ships. Our technicians will check if we are still able to use them.';
$lang['sys_expe_found_ships_1_3']			= 'Our expedition found a planet that was probably destroyed by ongoing wars. In orbit were several shipwrecks. The technicians try to repair some of them. Perhaps then we can also obtain information about what has happened here.';
$lang['sys_expe_found_ships_1_4']			= 'Your expedition has encountered an old star fort, which has probably left for ages. In the hangar of the fortress a few vessels were found. The technicians will look at whether some of them can be repaired or not. ';
$lang['sys_expe_found_ships_2_1']			= 'We have found the remains of an Armada. The technicians of the expedition fleet have gone immediately to the semi-intact vessels and try to repair it again.';
$lang['sys_expe_found_ships_2_2']			= 'Our expedition came upon an old, automatic shipyard. Some ships are still in the production phase, and our engineers are trying to restore power to the yard.'; 
$lang['sys_expe_found_ships_3_1']			= 'We have found a giant spaceship graveyard. Some technicians of the expedition fleet have managed to take one or more ships back into operation.';
$lang['sys_expe_found_ships_3_2']			= 'We have discovered a planet with the remains of a civilization. In orbit is still a huge space station known to be the only building still intact. Some of our technicians and pilots have gone to the surface to see if some of the ships parked there are still able to be used.';
$lang['sys_expe_lost_fleet_1']				= 'Of the expedition, only the following radio message was left: Zzzrrt Oh God! Krrrzzzzt the zrrrtrzt yes krgzzzz looks like Krzzzzzzzztzzzz ...';
$lang['sys_expe_lost_fleet_2']				= 'The last thing that is sent by the expedition still had some incredibly good successful close-ups of an opening........ a black hole.';
$lang['sys_expe_lost_fleet_3']				= 'An energy core of the vessel rupture resulted in a chain reaction that destroyed in a quite spectacular explosion, the entire expedition.';
$lang['sys_expe_lost_fleet_4']				= 'The expedition fleet was not able to made the jump back into normal space. Our scientists are still puzzled as to what might have happened, but the fleet seems to be permanently lost.';
$lang['sys_expe_time_fast_1']				= 'An unforeseen feedback into the power coil of the drive units, accelerated the return of the expedition, and is now returning earlier than expected. First reported that she has nothing exciting to report, however.';
$lang['sys_expe_time_fast_2']				= 'The new commander took advantage of some unstable wormhole to shorten the return flight - with success! However, the expedition itself has brought no new evidence.';
$lang['sys_expe_time_fast_3']				= 'Your expedition does not return characteristics in the investigated sector. However, the fleet ran into a recess in the solar wind. Thus the jump was accelerated. Your Expedition now comes a little early to go home.';
$lang['sys_expe_time_slow_1']				= 'A bad blunder led to a miscalculation of the Navigator with the jump of the expedition. Not only is the fleet landed at a completely wrong place, even the way back then took much longer to complete.';
$lang['sys_expe_time_slow_2']				= 'For unknown reasons, the jump of the expedition fleet simply went wrong. Nearly would have come out in the heart of a sun. Luckily it landed in a known system, but the return will take longer than originally thought.';
$lang['sys_expe_time_slow_3']				= 'The new navigation module has probably yet to struggle with some bugs. Not only the trajectory of the expedition fleet went in totally the wrong direction, even all of the deuterium was consumed, which ended the jump of the fleet, just after the start of the lunar planet. A bit disappointed now, the expedition returns to home. This return is delayed, probably a little bit.';
$lang['sys_expe_time_slow_4']				= 'Your expedition ran into a sector with increasing particle storms. This overloaded the energy of the fleet and for all vessels, the major systems were lost. Your mechanic could prevent the worst, but the expedition is now back with some delay.';
$lang['sys_expe_time_slow_5']				= 'The command ship of your fleet Expedition collided with a foreign ship that jumped right in without any warning to the fleet. The alien ship exploded and the damage to the ships have been substantial. Once the repairs are complete, your ships will be on the way back, because in this state, the expedition could continue.';
$lang['sys_expe_time_slow_6']				= 'The stellar wind of a red giant distorted the leap of the expedition so much that it took some time to calculate the return. Apart from that  the sector in which the Expedition came out, is nothing but the emptiness between the stars.';
$lang['sys_expe_nothing_1'] 				= 'Apart from some strange, small creatures from an unknown swamp planet,  this expedition with nothing exciting about her trip.';
$lang['sys_expe_nothing_2'] 				= 'Your expedition has made beautiful images of a supernova. Really no new findings has  placed this expedition. But we have good chances on the best-picture-of-Universe contest this year.';
$lang['sys_expe_nothing_3'] 				= 'A strange computer virus presented briefly paralyzed the ship after leaving the solar system to navigate. This meant that the entire expedition fleet all the time flew in a circle. Needless to say, that the expedition was not very successful.';
$lang['sys_expe_nothing_4'] 				= 'A life of pure energy had all expedition members staring at the hypnotic patterns on the screens for days. When at last the majority had become clear again in the head, the expedition had an acute shortage of deuterium, and the mission had to be canceled.';
$lang['sys_expe_nothing_5'] 				= 'Well, at least we know now that have red anomalies in Class 5 is not the only chaotic effects on marine systems, but can also trigger massive hallucinations in the crew. Besides that not much became of this expedition.';
$lang['sys_expe_nothing_6'] 				= 'Despite the first promising scans of this sector, unfortunately, we come back empty-handed.';
$lang['sys_expe_nothing_7'] 				= 'Perhaps we ought not to celebrate the birthday of the Captains on this remote planet. A nasty jungle fever has accompanied much of the crew forcing them to the infirmary. Acute staff time meant that the expedition failed.';
$lang['sys_expe_nothing_8'] 				= 'Your expedition has, literally, made acquaintance with the emptiness of the universe. There was not even a small asteroid, or radiation, or particles, or anything that would have made this expedition exciting.';
$lang['sys_expe_nothing_9'] 				= 'A failure of the core reactor vessel had nearly destroyed the entire expedition. Fortunately, the engineers were more than capable and could prevent the worst. However, the repair took so much time, that the expedition returned empty-handed.'; 	
$lang['sys_expe_attack_1_1_1'] 				= 'A few apparently very desperate space pirates tried to hijack our expedition fleet.';
$lang['sys_expe_attack_1_1_2'] 				= 'Some primitve barbarians are attacking us with spaceships, which not even begin to name the spacecraft. If the bombardment assume serious proportions, we see the fire forced us to reply.';
$lang['sys_expe_attack_1_1_3'] 				= 'We have collected a few very drunken pirate radio messages. Apparently we are to be attacked.';
$lang['sys_expe_attack_1_1_4'] 				= 'We had to defend ourselves against some pirates, which fortunately were not too numerous.';
$lang['sys_expe_attack_1_1_5'] 				= 'Our expedition fleet reports that they encountered a certain Tikarr Moa and his wild pack, they demand the unconditional surrender our fleet. If they get serious, they will have to realize that our ships defend well.';
$lang['sys_expe_attack_1_2_1'] 				= 'Your expedition fleet had an unpleasant encounter with some space pirates.';
$lang['sys_expe_attack_1_2_2'] 				= 'We are in the ambush of some stars-Buccaneers fall! A battle was unfortunately inevitable.';
$lang['sys_expe_attack_1_2_3'] 				= 'The cry for help, followed by the expedition, turned out to be bad case of some malicious star-buccaneers. A fight was inevitable.';
$lang['sys_expe_attack_1_3_1'] 				= 'The collected signals originated not from Fremdwesen, but by a secret pirate base! The pirates were aware of our presence in their sector and not particularly enthusiastic.';
$lang['sys_expe_attack_1_3_2'] 				= 'The expedition fleet reports heavy fighting, with unidentified pirate ships!';
$lang['sys_expe_attack_2_1_1'] 				= 'Your expedition fleet had a not very friendly first contact with an unknown species.';
$lang['sys_expe_attack_2_1_2'] 				= 'Some strange looking ships have attacked without warning!';
$lang['sys_expe_attack_2_1_3'] 				= 'Our expedition was attacked by a small group of unknown ships!';
$lang['sys_expe_attack_2_1_4'] 				= 'The expedition fleet reported contact with unknown ships. The radio messages are not decoded, however it seems the foreign vessels activated their weapons.';
$lang['sys_expe_attack_2_2_1'] 				= 'An unknown species is attacking our expedition!';
$lang['sys_expe_attack_2_2_2'] 				= 'Your expedition fleet has apparently violated the territory of the hitherto an unknown but highly aggressive and war like alien race.';
$lang['sys_expe_attack_2_2_3'] 				= 'The link to our expedition fleet was disrupted. As far as we have learned about the last message correctly, the fleet is under heavy fire - the aggressors could not be identified.';
$lang['sys_expe_attack_2_3_1'] 				= 'Your expedition has been in an alien invasion fleet and reported heavy fighting!';
$lang['sys_expe_attack_2_3_2'] 				= 'A large association of crystalline vessels of unknown origin holds direct collision course with our expedition fleet. We now have to assume the worst.';
$lang['sys_expe_attackname_1']				= 'Pirates'; 	
$lang['sys_expe_attackname_2'] 				= 'Aliens'; 	
$lang['sys_expe_back_home'] 				= 'Your expedition returned to the hangar.<br>They have brought %s %s, %s %s, %s %s and %s %s .';
$lang['sys_expe_back_home_without_dm']		        = 'Your expedition returned to the hangar.';
$lang['sys_expe_back_home_with_dm']			= 'Your expedition returned to the hangar.<br>They found %s(%s) the deformed vessels were scrapped and.<br>the %s could be saved.';
$lang['sys_mess_transport'] 				= 'Transport report';
$lang['sys_tran_mess_owner']		 		= 'One of your fleets returned from the planet %s %s and droped off %s %s, %s %s and %s %s.';
$lang['sys_tran_mess_user'] 		 		= 'A peaceful fleet of %s %s reached %s %s and delivers %s %s, %s %s and %s %s.';
$lang['sys_mess_fleetback'] 				= 'Return of the fleet';
$lang['sys_tran_mess_back'] 				= 'One of your fleet returns back to the planet %s %s .';
$lang['sys_recy_gotten'] 					= 'Your recyclers have Collected %s %s and %s %s';
$lang['sys_notenough_money'] 				= 'On your planet %s <a href="./game.php?page=buildings&amp;cp=%d&amp;re=0">[%d:%d:%d]</a> You do not have enough resources to build a %s . <br>You have %s %s , %s %s and %s %s. <br>The construction costs this much %s %s , %s %s and %s %s.';
$lang['sys_nomore_level'] 					= 'You try to destroy a building, which you no longer possess( %s ).';
$lang['sys_buildlist'] 						= 'Production queue';
$lang['sys_buildlist_fail'] 				= 'Construction is not possible';
$lang['sys_gain'] 				  			= 'Benefits';
$lang['sys_irak_subject'] 				  	= 'Missile Impact';
$lang['sys_irak_no_def'] 				  	= 'The planet has no defense';
$lang['sys_irak_no_att'] 				  	= 'All your missiles were intercepted.';
$lang['sys_irak_def'] 					  	= '%d Rockets from your missiles were intercepted.';
$lang['sys_irak_mess']						= 'Interplanetary missiles (%d) from %s are on the planet %s <br><br>';
$lang['sys_gain'] 				  			= 'Benefits';
$lang['sys_fleet_won'] 						= 'One of your fleet returns from the attack on planet %s %s. You have captured %s %s, %s %s and %s %s ';
$lang['sys_perte_attaquant'] 				= 'Attacker Losses';
$lang['sys_perte_defenseur'] 				= 'Defender Losses';
$lang['sys_debris'] 						= 'Debris';
$lang['sys_destruc_title']       		   	= 'The following fleets face each other for the destruction of the moon:';
$lang['sys_mess_destruc_report']  		  	= 'Report: Destruction of the Moon';
$lang['sys_destruc_lune']          		 	= 'The probability of destruction of the moon is: %d%% ';
$lang['sys_destruc_rip']          			= '..';
$lang['sys_destruc_stop']      			 	= 'The defender has successfully blocked the moons destruction.';
$lang['sys_destruc_mess1']       		   	= 'The deathstars turn their energies to the moon.';
$lang['sys_destruc_mess']        		   	= 'A fleet from the planet %s [%d:%d:%d] reached the moon in [%d:%d:%d].';
$lang['sys_destruc_echec']       		   	= 'Earthquakes shake the moon. But something goes wrong: The death star explode and disintegrate into thousands of individual parts. <br>The shock wave reaches the entire fleet.';
$lang['sys_destruc_reussi']      		   	= '<br>The rays of the Death Stars reach the moon and shred it.<br>The entire moon was destroyed.<br> Mission successfully completed.<br> The fleet comes back.';
$lang['sys_destruc_null']        		   	= 'The Death Stars can not develop their full power and implode.<br> The moon is not destroyed.';
$lang['sys_module_inactive']                = 'Module disabled';

//----------------------------------------------------------------------------//
//class.CheckSession.php
$lang['ccs_multiple_users']					= 'Cookie Error! Someone has logged in to your account. Delete your cookies and try again. If the problem persists, contact the administrator.';
$lang['ccs_other_user']						= 'Cookie Error! Delete your cookies and try again. If the problem persists, contact the administrator.<br> Error Code. 272';
$lang['css_different_password']				= 'Cookie Error! Delete your cookies and try again. If the problem persists, contact the administrator.<br> Error Code. 273';
$lang['css_account_banned_message']			= 'YOUR ACCOUNT HAS BEEN SUSPENDED';
$lang['css_account_banned_expire']			= 'You are %s till!<br><a href="./index.php?page=pranger">Banned</a>';
$lang['css_goto_homeside']					= '<a href="./index.php">Go to the homepage</a>';
$lang['css_server_maintrace']				= 'Server Maintinace<br><br>Game is currently closed.<br><br>reason: %s';

//----------------------------------------------------------------------------//
//class.debug.php
$lang['cdg_mysql_not_available']			= 'No connection to the database<br>Please come back later.<br><br>We ask for understanding';
$lang['cdg_error_message']					= 'Error, please contact the administrator. Error Number.:';
$lang['cdg_fatal_error']					= 'FATAL ERROR';

//----------------------------------------------------------------------------//
//class.FlyingFleetsTable.php

$lang['cff_no_fleet_data']                    = 'No ship information';
$lang['cff_aproaching']                        = 'Fleet consists of ';
$lang['cff_ships']                            = ' Units.';
$lang['cff_from_the_planet']                = 'Planet ';
$lang['cff_from_the_moon']                    = 'moon ';
$lang['cff_the_planet']                        = 'the planet ';
$lang['cff_debris_field']                    = 'the debris ';
$lang['cff_to_the_moon']                    = 'the moon ';
$lang['cff_the_position']                    = 'Position ';
$lang['cff_to_the_planet']                    = ' ';
$lang['cff_the_moon']                        = ' the moon ';
$lang['cff_from_planet']                    = ' from the planet ';
$lang['cff_from_debris_field']                = 'from the debris field ';
$lang['cff_from_the_moon']                    = 'from the moon ';
$lang['cff_from_position']                    = 'from position ';
$lang['cff_missile_attack']                    = 'Missile attack';
$lang['cff_from']                            = ' from ';
$lang['cff_to']                                = ' to ';
$lang['cff_one_of_your']                    = 'One of your ';
$lang['cff_a']                                = 'a ';
$lang['cff_of']                                = ' of ';
$lang['cff_goes']                            = ' from ';
$lang['cff_toward']                            = ' goes toward ';
$lang['cff_back_to_the_planet']                = ' are returning back to your planet ';
$lang['cff_with_the_mission_of']            = '. With the mission of: ';
$lang['cff_to_explore']                        = ' to explore ';
$lang['cff_comming_back']                    = '';
$lang['cff_back']                            = 'Comming back';
$lang['cff_to_destination']                    = 'Heading to destination';

//----------------------------------------------------------------------------//
// EXTRA LANGUAGE FUNCTIONS
$lang['fcm_moon']							= 'moon';
$lang['fcm_info']							= 'Information';
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
$lang['fa_not_enough_probes']				= 'Error, no probes available';
$lang['fa_galaxy_not_exist']				= 'Error, Galaxy does not exist';
$lang['fa_system_not_exist']				= 'Error, system does not exist';
$lang['fa_planet_not_exist']				= 'Error, planet does not exist';
$lang['fa_not_enough_fuel']					= 'Error, not enough deuterium present';
$lang['fa_no_more_slots']					= 'Error, no slot available';
$lang['fa_no_recyclers']					= 'Error, No Recycler available';
$lang['fa_no_fleetroom']					= 'Error, deuterium consumption is greater then transport capacity';
$lang['fa_mission_not_available']			= 'Error, mission not available';
$lang['fa_no_spios']						= 'Error, no probes available';
$lang['fa_vacation_mode']					= 'Error, Player is in vacation mode';
$lang['fa_week_player']						= 'Error, Player is too weak';
$lang['fa_strong_player']					= 'Error, Player is too strong';
$lang['fa_not_spy_yourself']				= 'Error, you can not spy on yourself';
$lang['fa_not_attack_yourself']				= 'Error, you can not attack yourself';
$lang['fa_action_not_allowed']				= 'Error, action not allowed';
$lang['fa_vacation_mode_current']			= 'Error, they are in vacation mode';
$lang['fa_sending']							= 'Sending';

//----------------------------------------------------------------------------//
// MissilesAjax.php
$lang['ma_silo_level']						= 'You need missile silo level 4!';
$lang['ma_impulse_drive_required']			= 'You first need to explore the Impulse Engine';
$lang['ma_not_send_other_galaxy']			= 'You can not send rockets into another galaxy.';
$lang['ma_planet_doesnt_exists']			= 'Planet does not exist.';
$lang['ma_wrong_target']					= 'Wrong Target';
$lang['ma_no_missiles']						= 'There are no available Interplanetary Missiles';
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
$lang['ma_missiles_sended']					= ' Interplanetary missiles were sent. Main objective: ';

//----------------------------------------------------------------------------//
// topkb.php
$lang['tkb_top']                  			= 'Hall of Fame';
$lang['tkb_gratz']                  		= 'Top 100 biggest 1v1 battles';
$lang['tkb_platz']                  		= 'Place';
$lang['tkb_owners']             			= 'Participants';
$lang['tkb_datum']                  		= 'Date';
$lang['tkb_units']             				= 'Units';
$lang['tkb_legende']               		 	= '<b>Legend: </b>';
$lang['tkb_gewinner']              		 	= '<b>-Winner-</b>';
$lang['tkb_verlierer']              		= '<b>-Loser-</b>';
$lang['tkb_unentschieden']         			= '<b>-Tie- </b>';
$lang['tkb_missing']              		  	= '<br>Missing in Action: The user account does not exist anymore.';

//----------------------------------------------------------------------------//
// playercard.php
$lang['pl_overview']  						= 'Playercard';
$lang['pl_name'] 							= 'Username';
$lang['pl_homeplanet'] 						= 'Home Planet';
$lang['pl_ally']     						= 'Alliance';
$lang['pl_message']    						= 'Private Message';
$lang['pl_buddy']        					= 'buddy request';
$lang['pl_points']      					= 'Points';
$lang['pl_range']         					= 'Rank';
$lang['pl_builds']     						= 'Buildings';
$lang['pl_tech']    						= 'Research';
$lang['pl_fleet']       					= 'Fleet';
$lang['pl_def']         					= 'Defense';
$lang['pl_total']       					= 'Total';
$lang['pl_fightstats'] 						= 'Fight Stats';
$lang['pl_fights']     						= 'Fights';
$lang['pl_fprocent']       					= 'Fight Odds';
$lang['pl_fightwon']  						= 'Wins';
$lang['pl_fightdraw']  						= 'Draws';
$lang['pl_fightlose']  						= 'loses';
$lang['pl_totalfight']      				= 'Total fights';
$lang['pl_destroy']    						= '%s was involved in the following destruction';
$lang['pl_unitsshot']    					= 'Units Killed';
$lang['pl_unitslose']    					= 'Units Lost';
$lang['pl_dermetal']    					= 'Total metal debris field';
$lang['pl_dercrystal']   					= 'Total crystal debris field';
$lang['pl_etc']   							= 'Other';

//----------------------------------------------------------------------------//
// Chat

$lang['chat_title']                         = 'Chat';
$lang['chat_ally_title']                    = 'Alliance Chat';  

$lang['chat_disc']                          = 'Chat';
$lang['chat_message']                       = 'Message';
$lang['chat_send']                          = 'Send';
$lang['chat_admin']                       	= '<font color="red">Admin %s</font>';

//----------------------------------------------------------------------------//
// Support

$lang['supp_header'] 						= 'Support-System';
$lang['supp_header_g']                      = 'Closed tickets';
$lang['ticket_id'] 							= '#Ticket-ID';
$lang['subject'] 							= 'subject';
$lang['status'] 							= 'Status';
$lang['ticket_posted'] 						= 'Created on:';
$lang['ticket_new'] 						= 'New Ticket';
$lang['input_text'] 						= 'Description of incidence or problem:';
$lang['answer_new'] 						= 'Text Solution:';
$lang['text'] 								= 'Details';
$lang['message_a'] 							= 'Message Status:';
$lang['sendit_a'] 							= 'Mail has been sent.';
$lang['message_t'] 							= 'Status of Tickets:';
$lang['sendit_t'] 							= 'The ticket has been registered.';
$lang['close_t'] 							= 'The ticket has been closed.';
$lang['sendit_error'] 						= 'Error:';
$lang['sendit_error_msg'] 					= 'You have not filled in all data!';
$lang['supp_admin_system'] 					= 'Incident Management System';
$lang['close_ticket'] 						= 'Close Ticket';
$lang['open_ticket']                        = 'Open Ticket';
$lang['player'] 							= 'Player';
$lang['supp_ticket_close']					= 'Ticket closed';
$lang['supp_close'] 						= 'Closed';
$lang['supp_open'] 							= 'Open';
$lang['supp_admin_answer'] 					= 'Admin response';
$lang['supp_player_answer'] 				= 'Player-response';

//----------------------------------------------------------------------------//
// Records

$lang['rec_build']  						= 'Buildings';
$lang['rec_specb']							= 'Special buildings';
$lang['rec_playe']  						= 'Player';
$lang['rec_defes']  						= 'Defenses';
$lang['rec_fleet']  						= 'Ships';
$lang['rec_techn']  						= 'Research';
$lang['rec_level']  						= 'Level';
$lang['rec_nbre']   						= 'Number';
$lang['rec_rien']   						= '-';
$lang['rec_last_update_on']   				= 'Last update at : %s';

// Translated into English by Languar . All rights reversed (C) 2010

?>