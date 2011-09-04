<?php

setlocale(LC_ALL, 'si_SL', 'slovenian'); // http://msdn.microsoft.com/en-us/library/39cwe7zf%28vs.71%29.aspx
setlocale(LC_NUMERIC, 'C');

//SERVER GENERALS

$LNG['js_days']								= array('Ned', 'Pon', 'Tor', 'Sre', 'Čet', 'Pet', 'Sob');
$LNG['js_month']							= array('Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec');

$LNG['Metal']								= 'Metal';
$LNG['Crystal']								= 'Kristal';
$LNG['Deuterium']							= 'Deuterium';
$LNG['Darkmatter']							= 'Črna materija';
$LNG['Energy']								= 'Energija';
$LNG['Messages']							= 'Sporočila';
$LNG['write_message']						= 'Ustvari novo sporočilo';

$LNG['ready']								= 'Pripravljeno';
$LNG['show_planetmenu']						= 'Pokaži / Skrij';

$LNG['type_mission'][1]  					= 'Napad';
$LNG['type_mission'][2]  					= 'Združen napad';
$LNG['type_mission'][3]  					= 'Transport';
$LNG['type_mission'][4]  					= 'Napotitev';
$LNG['type_mission'][5]  					= 'Drži položaj';
$LNG['type_mission'][6]  					= 'Vohuni';
$LNG['type_mission'][7]  					= 'Kolonizacija';
$LNG['type_mission'][8]  					= 'Recikliraj ruševine';
$LNG['type_mission'][9]  					= 'Uniči';
$LNG['type_mission'][11]  					= 'Preiskava ČM';
$LNG['type_mission'][15] 					= 'Ekspedicija';

$LNG['user_level'] = array (
	'0' => 'Igralec',
	'1' => 'Moderator',
	'2' => 'Operater',
	'3' => 'Administrator',
);

// GAME.PHP
$LNG['see_you_soon']						= 'Hvala, da ste igrali';
$LNG['page_doesnt_exist']					= 'Zahtevana stran ne obstaja';


//----------------------------------------------------------------------------//
//TOPNAV
$LNG['tn_vacation_mode']					= 'Ste v stanju čas dopusta ';
$LNG['tn_delete_mode']						= 'Vaš račun %s bo izbrisan!';

//----------------------------------------------------------------------------//
//LEFT MENU
$LNG['lm_overview']							= 'Pregled';
$LNG['lm_galaxy']							= 'Galaksija';
$LNG['lm_empire']							= 'Imperij';
$LNG['lm_fleet']							= 'Flota';
$LNG['lm_buildings']						= 'Zgradbe';
$LNG['lm_research']							= 'Raziskave';
$LNG['lm_shipshard']						= 'Ladjedelnica';
$LNG['lm_defenses']							= 'Obramba';
$LNG['lm_resources']						= 'Surovine';
$LNG['lm_fleettrader']						= 'Trgovec z floto';
$LNG['lm_officiers']						= 'Oficirji in ČM';
$LNG['lm_trader']							= 'Trgovec';
$LNG['lm_technology']						= 'Tehnologija';
$LNG['lm_messages']							= 'Sporočila';
$LNG['lm_alliance']							= 'Aliansa';
$LNG['lm_buddylist']						= 'Prijatelji';
$LNG['lm_notes']							= 'Beležke';
$LNG['lm_statistics']						= 'Statistika';
$LNG['lm_search']							= 'Išči';
$LNG['lm_options']							= 'Možnosti';
$LNG['lm_banned']							= 'Banned';
$LNG['lm_contact']							= 'kontakt';
$LNG['lm_forums']							= 'Forum';
$LNG['lm_logout']							= 'Izpis';
$LNG['lm_administration']					= 'Administracija';
$LNG['lm_game_speed']						= 'Igra';
$LNG['lm_fleet_speed']						= 'Flota';
$LNG['lm_resources_speed']					= 'Surovine';
$LNG['lm_queue']							= 'Liste';
$LNG['lm_topkb']							= 'Top lista';
$LNG['lm_faq']								= 'Priročnik - FAQ';
$LNG['lm_records']							= 'Dvorana slavnih';
$LNG['lm_chat']								= 'Pogovor';
$LNG['lm_support']							= 'Podporna kartica';
$LNG['lm_rules']							= 'Pravila';
$LNG['lm_battlesim']						= "Bojni simulator";

//----------------------------------------------------------------------------//
//OVERVIEW

$LNG['ov_newname_alphanum']					= 'Ime planeta mora biti sestavljena samo iz alfanumeričnih znakov.';
$LNG['ov_newname_no_space']					= 'Ime planeta ne more vsebovati presledkov.';
$LNG['ov_planet_abandoned']					= 'Planet opuščen!';
$LNG['ov_principal_planet_cant_abanone']	= 'Ne morate opustiti glavnega planeta!';
$LNG['ov_abandon_planet_not_possible']		= 'Ne morate opustiti planeta, ki je aktiven!';
$LNG['ov_wrong_pass']						= 'Napačno geslo. Poskusite znova!';
$LNG['ov_have_new_message']					= 'Novo sporočilo [1]';
$LNG['ov_have_new_messages']				= 'Nova sporočila [%d]';
$LNG['ov_planetmenu']						= 'Meni planeta';
$LNG['ov_free']								= 'Free';
$LNG['ov_news']								= 'Novice';
$LNG['ov_place']							= 'Place';
$LNG['ov_of']								= 'od';
$LNG['ov_planet']							= 'Planet';
$LNG['ov_server_time']						= 'Čas strežnika ';
$LNG['ov_events']							= 'Dogodki';
$LNG['ov_diameter']							= 'Premer';
$LNG['ov_distance_unit']					= 'km';
$LNG['ov_temperature']						= 'Temperatura';
$LNG['ov_aprox']							= 'Približno';
$LNG['ov_temp_unit']						= '&deg;C';
$LNG['ov_to']								= 'do';
$LNG['ov_position']							= 'Pozicija';
$LNG['ov_points']							= 'Točke';
$LNG['ov_security_request']					= 'Varnostno vprašanje';
$LNG['ov_security_confirm']					= 'Prosim potrdite, da planet';
$LNG['ov_password']							= 'Geslo';
$LNG['ov_delete_planet']					= 'Odstrani planet';
$LNG['ov_planet_rename']					= 'Preimenuj';
$LNG['ov_rename_label']						= 'Novo ime';
$LNG['ov_fields']							= 'Polja';
$LNG['ov_developed_fields']                = 'Razvita polja';
$LNG['ov_max_developed_fields']				= 'maks. razvitih polj';
$LNG['ov_fleet']							= 'flota';
$LNG['ov_admins_online']					= 'Admini(Online):';
$LNG['ov_no_admins_online']					= 'Trenutno, noben prijavljen!';
$LNG['ov_userbanner']						= 'Trak statistike uporabnika';
$LNG['ov_userrank_info']					= '%s (%s <a href="game.php?page=statistics&amp;range=%d">%d</a> %s %s)';
$LNG['ov_teamspeak_not_online']				= 'Strežnik trenutno ni na voljo. Prosimo za razumevanje.';
$LNG['ov_teamspeak']						= 'Teamspeak';
$LNG['ov_teamspeak_v2']						= '<a href="teamspeak://%s:%s?nickname=%s" title="Teamspeak Connect">Connect</a> &bull; Online: %d/%d &bull; Channels: %d &bull; Traffic ges.: %s MB';
$LNG['ov_teamspeak_v3']						= '<a href="ts3server://%s?port=%d&amp;nickname=%s&amp;password=%s" title="Teamspeak Connect">Connect</a>&nbsp;&bull;&nbsp;Online: %d/%d &bull; Channels: %d &bull; Traffic ges.: %s MB';
$LNG['ov_closed']							= 'Igra je trenutno deaktivirana! ';
$LNG['ov_reflink']							= 'Reflink';
//----------------------------------------------------------------------------//
//GALAXY

$LNG['gl_no_deuterium_to_view_galaxy']		= 'Nimate dovolj deuteriuma!';
$LNG['gl_legend']							= 'Legenda';
$LNG['gl_strong_player']					= 'Močan igralec';
$LNG['gl_week_player']						= 'Šibak igralec';
$LNG['gl_vacation']							= 'Čas dopusta';
$LNG['gl_banned']							= 'Ban';
$LNG['gl_inactive_seven']					= '7 dni neaktiven';
$LNG['gl_inactive_twentyeight']				= '28 dni neaktiven';
$LNG['gl_s']								= 'S';
$LNG['gl_w']								= 'W';
$LNG['gl_v']								= 'V';
$LNG['gl_b']								= 'B';
$LNG['gl_i']								= 'i';
$LNG['gl_I']								= 'I';
$LNG['gl_populed_planets']					= '%d naseljenih planetov';
$LNG['gl_out_space']						= 'Razišči rob tega sistema';
$LNG['gl_avaible_missiles']					= 'Rakete';
$LNG['gl_fleets']							= 'Sloti flot';
$LNG['gl_avaible_grecyclers']				= 'Mega-Reciklerji';
$LNG['gl_avaible_recyclers']				= 'Reciklerji';
$LNG['gl_avaible_spyprobes']				= 'Vohunske sonde';
$LNG['gl_missil_launch']					= 'Raketni napad';
$LNG['gl_missil_to_launch']					= 'Rakete [<b>%d</b>]:';
$LNG['gl_all_defenses']						= 'Vse';
$LNG['gl_objective']						= 'Cilj';
$LNG['gl_missil_launch_action']				= 'Potrdi';
$LNG['gl_galaxy']							= 'Galaksija';
$LNG['gl_solar_system']						= 'Sistem';
$LNG['gl_show']								= 'Pokaži';
$LNG['gl_pos']								= 'Poz';
$LNG['gl_planet']							= 'Planet';
$LNG['gl_name_activity']					= 'Ime (Aktivnost)';
$LNG['gl_moon']								= 'Luna';
$LNG['gl_debris']							= 'Ruševine';
$LNG['gl_player_estate']					= 'Igralci (Status)';
$LNG['gl_alliance']							= 'Alliansa';
$LNG['gl_actions']							= 'Dejanje';
$LNG['gl_spy']								= 'Vohuni';
$LNG['gl_buddy_request']					= 'Prošnja prijateljstva';
$LNG['gl_missile_attack']					= 'Raketni napad';
$LNG['gl_with']								= ' z ';
$LNG['gl_member']							= '%d člani';
$LNG['gl_member_add']						= '%d član';
$LNG['gl_alliance_page']					= 'Stran allianse';
$LNG['gl_see_on_stats']						= 'Statistika';
$LNG['gl_alliance_web_page']				= 'Alliansa domov';
$LNG['gl_debris_field']						= 'Polje ruševin';
$LNG['gl_collect']							= 'Zbiraj';
$LNG['gl_resources']						= 'Surovine';
$LNG['gl_features']							= 'Lastnosti';
$LNG['gl_diameter']							= 'Premer';
$LNG['gl_temperature']						= 'Temperatura';
$LNG['gl_phalanx']							= 'Phalanx';
$LNG['gl_planet_destroyed']					= 'Uničen planet';
$LNG['gl_playercard']						= 'Kartica igralca';
$LNG['gl_player']							= 'Igralec';
$LNG['gl_in_the_rank']						= 'Igralec %s ima rank %d';
$LNG['gl_activity']                         = '(*)';
$LNG['gl_activity_inactive']                = '(%d min)';
$LNG['gl_ajax_status_ok']                   = 'Končano';
$LNG['gl_ajax_status_fail']                	= 'Napaka';
$LNG['gl_free_desc'] 						= 'Nenaseljen planet, kolonizirajte ga preden ga kdo drug!';
$LNG['gl_free'] 							= 'Prost';
$LNG['gl_yes'] 								= 'Da';
$LNG['gl_no'] 								= 'Ne';
$LNG['gl_points'] 							= 'Točke';
$LNG['gl_player']							= 'Igralec';
$LNG['gl_to']								= 'do';

//----------------------------------------------------------------------------//
//PHALANX
$LNG['px_no_deuterium']						= 'Nimate dovolj deuteriuma!';
$LNG['px_scan_position']					= 'Skeniraj pozicijo';
$LNG['px_fleet_movement']					= 'Trenutni premiki flot';
$LNG['px_no_fleet']							= 'Ni premikov flot.';
$LNG['px_out_of_range']						= 'Ven z dosega';

//----------------------------------------------------------------------------//
//EMPIRE
$LNG['iv_imperium_title']					= 'Pregled imperija';
$LNG['iv_planet']							= 'Planet';
$LNG['iv_name']								= 'Ime';
$LNG['iv_coords']							= 'Koordinati';
$LNG['iv_fields']							= 'Polja';
$LNG['iv_resources']						= 'Surovine';
$LNG['iv_buildings']						= 'Zgradbe';
$LNG['iv_technology']						= 'Raziskave';
$LNG['iv_ships']							= 'Ladje';
$LNG['iv_defenses']							= 'Obramba';

//----------------------------------------------------------------------------//
//FLEET - FLEET1 - FLEET2 - FLEET3 - FLEETACS - FLEETSHORTCUTS
$LNG['fl_returning']						= 'Flota na planetu';
$LNG['fl_onway']							= 'Flota do planeta';
$LNG['fl_r']								= '(R)';
$LNG['fl_a']								= '(A)';
$LNG['fl_send_back']						= 'Nazaj';
$LNG['fl_acs']								= 'ACS';
$LNG['fl_no_more_slots']					= 'Vsi sloti flote so porabljeni';
$LNG['fl_speed_title']						= 'Hitrost: ';
$LNG['fl_continue']							= 'nadaljuj';
$LNG['fl_no_ships']							= 'Nobena ladja ni na voljo';
$LNG['fl_remove_all_ships']					= 'Nobena ladja';
$LNG['fl_select_all_ships']					= 'Vse ladje';
$LNG['fl_fleets']							= 'Flote';
$LNG['fl_expeditions']						= 'Ekspedicije';
$LNG['fl_number']							= 'ID';
$LNG['fl_mission']							= 'Missija';
$LNG['fl_ammount']							= 'Ladje (total)';
$LNG['fl_beginning']						= 'Start';
$LNG['fl_departure']						= 'Prihod (tarča)';
$LNG['fl_destiny']							= 'Usoda';
$LNG['fl_objective']						= 'Cilj';
$LNG['fl_arrival']							= 'Prihod (nazaj)';
$LNG['fl_info_detail']						= 'Fleet-Details';
$LNG['fl_order']							= 'Ukaži';
$LNG['fl_new_mission_title']				= 'Nov ukaz: izberi floto';
$LNG['fl_ship_type']						= 'Tip ladje';
$LNG['fl_ship_available']					= 'Na voljo';
$LNG['fl_planet']							= 'Planet';
$LNG['fl_debris']							= 'Ruševine';
$LNG['fl_moon']								= 'Luna';
$LNG['fl_planet_shortcut']					= '(P)';
$LNG['fl_debris_shortcut']					= '(D)';
$LNG['fl_moon_shortcut']					= '(M)';
$LNG['fl_no_shortcuts']						= 'Na voljo ni bližnjic';
$LNG['fl_anonymous']						= 'Anonimen';
$LNG['fl_shortcut_add_title']				= 'Ime [Galaksija/Sistem/Planet]';
$LNG['fl_shortcut_name']					= 'Ime';
$LNG['fl_shortcut_galaxy']					= 'Galaksija';
$LNG['fl_shortcut_solar_system']			= 'Sistem';
$LNG['fl_clean']							= 'Ponastavi';
$LNG['fl_register_shorcut']					= 'Ustvari';
$LNG['fl_shortcuts']						= 'Bližnjice';
$LNG['fl_reset_shortcut']					= 'Ponastavi';
$LNG['fl_dlte_shortcut']					= 'Odstrani';
$LNG['fl_back']								= 'Nazaj';
$LNG['fl_shortcut_add']						= 'Dodaj';
$LNG['fl_shortcut_edition']					= 'Uredi: ';
$LNG['fl_no_colony']						= 'Ni prisotnih kolonij';
$LNG['fl_send_fleet']						= 'Pošlji floto';
$LNG['fl_fleet_speed']						= 'Hitrost';
$LNG['fl_distance']							= 'Dolžina (Svetlobna leta)';
$LNG['fl_flying_time']						= 'Čas leta (eno smer)';
$LNG['fl_flying_arrival']					= 'Prihod na cilj';
$LNG['fl_flying_return']					= 'Vrnitev';
$LNG['fl_fuel_consumption']					= 'Poraba goriva';
$LNG['fl_max_speed']						= 'Hitrost leta';
$LNG['fl_cargo_capacity']					= 'Kapaciteta tovora';
$LNG['fl_shortcut']							= 'Bljižnice';
$LNG['fl_shortcut_add_edit']				= '(Ustvary / Spremeni)';
$LNG['fl_my_planets']						= 'Moji planeti';
$LNG['fl_acs_title']						= 'Skupni napadi';
$LNG['fl_hold_time']						= 'Hold time';
$LNG['fl_resources']						= 'Surovine';
$LNG['fl_max']								= 'max';
$LNG['fl_hours']							= 'Ur(s)';
$LNG['fl_resources_left']					= 'Preostane';
$LNG['fl_all_resources']					= 'Maksimalna naložitev surovin';
$LNG['fl_empty_target']						= 'Na voljo ni nobena misija (Ali planet obstaja?)';
$LNG['fl_expedition_alert_message']			= 'Opozorilo! Ekspedicije so nevarne misije. Lahko izgubite ladje!';
$LNG['fl_dm_alert_message']					= 'Previdno, če je %s %s bilo najdeno je flota uničena!';
$LNG['fl_vacation_mode_active']				= 'Ste v stanju dopusta';
$LNG['fl_expedition_tech_required']			= 'Potrebna je astrofizika!';
$LNG['fl_expedition_fleets_limit']			= 'Omejitev ekspedicijskih flot dosežena!';
$LNG['fl_week_player']						= 'Igralec je zelo šibak!';
$LNG['fl_strong_player']					= 'Igralec je zelo močan!';
$LNG['fl_in_vacation_player']				= 'Igralec je v stanju dopusta';
$LNG['fl_no_slots']							= 'Sloti niso na volji!';
$LNG['fl_empty_transport']					= 'Ne morate transportirati nič surovin!';
$LNG['fl_planet_populed']					= 'Planet je zaseden!';
$LNG['fl_no_same_alliance']					= 'Ogralec ciljnega planeta mora biti v vaši aliansi ali pa na seznamu prijateljev.!';
$LNG['fl_not_ally_deposit']					= 'Ni Zavezniškega skladišča';
$LNG['fl_deploy_only_your_planets']			= 'Flote lahko napotite samo z svojih planetov!';
$LNG['fl_no_enought_deuterium']				= 'Nimate dovolj %s na voljo. Primanjkuje vam %s %s!';
$LNG['fl_no_enought_cargo_capacity']		= 'Nimate dovolj prostora za tovor:';
$LNG['fl_admins_cannot_be_attacked']		= 'Ne morate napadati Administratorjev';
$LNG['fl_fleet_sended']						= 'Flota poslana';
$LNG['fl_from']								= 'Od';
$LNG['fl_arrival_time']						= 'Prihod na cilj';
$LNG['fl_return_time']						= 'Vrnitev';
$LNG['fl_fleet']							= 'Flota';
$LNG['fl_player']							= 'Igralec ';
$LNG['fl_add_to_attack']					= ' je bil povabljen.';
$LNG['fl_dont_exist']						= ' ne obstaja.';
$LNG['fl_acs_invitation_message']			= ' vas vabi k sodelovanju skupnega napada.';
$LNG['fl_acs_invitation_title']				= 'Vabilo za skupni napad';
$LNG['fl_sac_of_fleet']						= 'Flota za skupni napad';
$LNG['fl_modify_sac_name']					= 'Spremenite ime skupnega napada';
$LNG['fl_members_invited']					= 'Člani povabljeni';
$LNG['fl_invite_members']					= 'Povabi druge člane';
$LNG['fl_simulate']							= 'Simuliraj';
$LNG['fl_bonus']							= 'Bonus';
$LNG['fl_bonus_attack']						= 'Napad';
$LNG['fl_bonus_defensive']					= 'Obramba';
$LNG['fl_bonus_shield']						= 'Ščit';
$LNG['fl_no_empty_derbis']					= 'Na tem območju ni ruševin! ';
$LNG['fl_acs_newname_alphanum']				= 'Ime lahko samo vsebuje alfanumerične znake. ';
$LNG['fl_acs_change']						= 'Spreminjam';
$LNG['fl_acs_change_name']					= 'Vnesite novo ime';
$LNG['fl_error_not_avalible']				= 'Planetu trenutno ni mogoče ustreči!';
$LNG['fl_error_empty_derbis']				= 'Rušvin ni na voljo!';
$LNG['fl_error_no_moon']					= 'Luna ni prisotna!';
$LNG['fl_error_same_planet']				= 'Start in cilj sta na enakem planetu!';

//----------------------------------------------------------------------------//
//BUILDINGS - RESEARCH - SHIPYARD - DEFENSES
$LNG['bd_dismantle']						= 'Zruši';
$LNG['bd_interrupt']						= 'Začasno ustavi';
$LNG['bd_cancel']							= 'Prekliči';
$LNG['bd_working']							= 'Zasedeno';
$LNG['bd_build']							= 'Zgradi';
$LNG['bd_build_next_level']					= 'Nadgradi na stopnjo ';
$LNG['bd_tech']                             = 'Raziskave';
$LNG['bd_tech_next_level']                  = 'Razišči stopnjo ';
$LNG['bd_add_to_list']						= 'Dodaj na listo gradnje';
$LNG['bd_no_more_fields']					= 'Ni več prostora na planetu!';
$LNG['bd_remaining']						= 'Preostane še:';
$LNG['bd_lab_required']						= 'Najprej morate zgraditi laboratorij!';
$LNG['bd_building_lab']						= 'Laboratorij se trenutno nadgrajuje!';
$LNG['bd_max_lvl']							= '(Maks. stopnja: %s)';
$LNG['bd_lvl']								= 'Stopnja';
$LNG['bd_research']							= 'Raziskave';
$LNG['bd_shipyard_required']				= 'Najprej morate zgraditi ladjedelnico!';
$LNG['bd_building_shipyard']				= 'Tovarna nanorobotov in/ali ladjedelnica se nadgrajuje!';
$LNG['bd_available']						= 'Na voljo: ';
$LNG['bd_build_ships']						= 'Zgradi';
$LNG['bd_protection_shield_only_one']		= 'Zgradi se lahko samo en!';
$LNG['bd_build_defenses']					= 'Zgradi';
$LNG['bd_actual_production']				= 'Trenutno v proizvodnji:';
$LNG['bd_completed']						= 'Dokončano';
$LNG['bd_operating']						= 'In progress';
$LNG['bd_continue']							= 'Nadaljuje';
$LNG['bd_price_for_destroy']				= 'Stroški za rušenje:';
$LNG['bd_ready']							= 'Pripravljeno';
$LNG['bd_finished']							= 'Dokončano';
$LNG['bd_maxlevel']							= 'Maksimalna stopnja';
$LNG['bd_on']								= 'on';
$LNG['bd_max_builds']						= 'Maksimalno naročilo gradnje [%d]';
$LNG['bd_next_level']						= 'Naslednja stopnja:';
$LNG['bd_need_engine']						= 'Zahteva  <font color="#FF0000">%s</font> %s more';
$LNG['bd_more_engine']						= 'Proizvede <font color="#00FF00">%s</font> %s more';
$LNG['bd_jump_gate_action']					= 'Odskoči';
$LNG['bd_cancel_warning']					= 'Preklic povrne samo 60% surovin!';
$LNG['bd_cancel_send']						= 'Izbrano - Izbriši';
$LNG['bd_destroy_time'] 					= 'Čas';
$LNG['bd_max_ships']                        = 'Maks';
$LNG['bd_max_ships_long']                   = 'Maksimalno enot';
$LNG['sys_notenough_money'] 				= 'Na %s <a href="?page=buildings&amp;cp=%d&amp;re=0">[%d:%d:%d]</a> ste imeli premalo surovin za gradnjo %s. <br> V tistem času ste imeli, %s %s , %s %s in %s %s. <br> Potrebovali pa ste %s %s , %s %s in %s %s.';
$LNG['sys_nomore_level'] 					= 'Zrušiti hočete stavbo, ki je nimate več( %s ).';
$LNG['sys_buildlist'] 						= 'Seznam gradnje';
$LNG['sys_techlist'] 						= 'Seznam raziskav';
$LNG['sys_buildlist_fail'] 					= 'Gradnja ni mogoča';

//----------------------------------------------------------------------------//
//RESOURCES
$LNG['rs_amount']							= 'Količina';
$LNG['rs_lvl']								= 'Stopnja';
$LNG['rs_production_on_planet']				= 'Proizvodnja surovin na planetu "%s"';
$LNG['rs_basic_income']						= 'Osnovna proizvodnja';
$LNG['rs_storage_capacity']					= 'Zmogljivost skladišča';
$LNG['rs_calculate']						= 'izračunaj';
$LNG['rs_sum']								= 'Skupaj:';
$LNG['rs_daily']							= 'Surovin na dan:';
$LNG['rs_weekly']							= 'Surovin na tedenk:';
$LNG['rs_ress_bonus']						= 'Bonus(Oficir/Bonus ČM):';

//----------------------------------------------------------------------------//
//OFFICIERS
$LNG['of_recruit']							= 'Najemi';
$LNG['of_max_lvl']							= 'Maks. stopnja';
$LNG['of_offi']								= 'Oficirji';
$LNG['of_lvl']								= 'Stopnja';
$LNG['of_dm_trade']							= '%s - Banka';
$LNG['of_still']							= 'še vedno';
$LNG['of_active']							= 'aktiven';
$LNG['of_update']							= 'Podaljšaj';

//----------------------------------------------------------------------------//
//TRADER
$LNG['tr_empty_darkmatter']					= 'Nimate dovolj %s!';
$LNG['tr_cost_dm_trader']					= 'Provizija prodaje znaša %s %s!';
$LNG['tr_only_positive_numbers']			= 'Vnesite samo pozitivne številke!';
$LNG['tr_not_enought_metal']				= 'Nezadostna količina Metala.';
$LNG['tr_not_enought_crystal']				= 'Nezadostna količina Kristala.';
$LNG['tr_not_enought_deuterium']			= 'Nezadostna količina Deuteriuma';
$LNG['tr_exchange_done']					= 'Izmenjava uspešna';
$LNG['tr_call_trader']						= 'Kontaktiraj trgovca';
$LNG['tr_call_trader_who_buys']				= 'Kontaktiraj trgovca, ki kupi';
$LNG['tr_call_trader_submit']				= 'Kontaktiraj trgovca';
$LNG['tr_exchange_quota']					= 'Menjalno razmerje je 2/1/0.5';
$LNG['tr_sell']						= 'Prodaj';
$LNG['tr_resource']							= 'Surovina';
$LNG['tr_amount']							= 'Količina';
$LNG['tr_quota_exchange']					= 'Menjalno razmerje';
$LNG['tr_exchange']							= 'Izmenjaj';

//----------------------------------------------------------------------------//
//TECHTREE
$LNG['tt_requirements']						= 'Zahteve';
$LNG['tt_lvl']								= 'Stopnja ';

//----------------------------------------------------------------------------//
//INFOS
$LNG['in_jump_gate_done']					= 'Odskočna vrata so bila uporabljena. Znova lahko odskočite čez: ';
$LNG['in_jump_gate_error_data']				= 'Napaka, podatki za odskok so nepravilni!';
$LNG['in_jump_gate_not_ready_target']		= 'Odskočna vrata na ciljni luni niso pripravljena. Pripravljena bodo v ';
$LNG['in_jump_gate_doesnt_have_one']		= 'Na luni nimate odskočnih vrat!';
$LNG['in_jump_gate_already_used']			= 'Odskočna vrata so bila uporabljena. Čas za polnitev energije: ';
$LNG['in_jump_gate_available']				= 'Na voljo';
$LNG['in_rf_again']    						= 'Rapidfire proti';
$LNG['in_rf_from']     						= 'Rapidfire od';
$LNG['in_level']       						= 'Stopnja';
$LNG['in_prod_p_hour'] 						= 'proizvodnja/uro';
$LNG['in_difference']  						= 'Razlika';
$LNG['in_used_energy'] 						= 'Poraba energije';
$LNG['in_prod_energy'] 						= 'Proizvodnja energije';
$LNG['in_used_deuter']						= 'Poraba deuteriuma';
$LNG['in_range']       						= 'Razpon senzorja';
$LNG['in_title_head']  						= 'Informacije o';
$LNG['in_name']        						= 'Ime';
$LNG['in_struct_pt']   						= 'Celovitost strukture';
$LNG['in_shield_pt']   						= 'Moč ščita';
$LNG['in_attack_pt']   						= 'Moč napada';
$LNG['in_capacity']    						= 'Kapaciteta tovora';
$LNG['in_units']       						= 'enot';
$LNG['in_base_speed'] 						= 'Osnovna hitrost';
$LNG['in_consumption'] 						= 'Poraba goriva (Deuterium)';
$LNG['in_jump_gate_start_moon']				= 'Odskočna luna';
$LNG['in_jump_gate_finish_moon']			= 'Priskočna luna';
$LNG['in_jump_gate_select_ships']			= 'Uporabi odskočna vrata: število ladij';
$LNG['in_jump_gate_wait_time']				= 'Naslednja možna uporaba: ';
$LNG['in_jump_gate_jump']					= 'Odskoči';
$LNG['in_destroy']     						= 'Zruši:';
$LNG['in_needed']      						= 'Zahteve';
$LNG['in_dest_durati'] 						= 'Trajanje rušitve';
$LNG['in_missilestype']   					= 'Tip raket';
$LNG['in_missilesamount']    				= 'Število raket na voljo';

//----------------------------------------------------------------------------//
//MESSAGES
$LNG['mg_type'][0]    						= 'Vohunska poročila';
$LNG['mg_type'][1]    						= 'Sporočila igralcev';
$LNG['mg_type'][2]   						= 'Sporočila alianse';
$LNG['mg_type'][3]    						= 'Poročila o bitkah';
$LNG['mg_type'][4]    						= 'Sporočila od sistema';
$LNG['mg_type'][5]    						= 'Poročila o transportih';
$LNG['mg_type'][15]   						= 'Poročila o ekspedicijah';
$LNG['mg_type'][50]							= 'Novice igre';
$LNG['mg_type'][99]   						= 'Poročila o gradnji';
$LNG['mg_type'][100]						= 'Prikaži vsa sporočila';
$LNG['mg_type'][999]						= 'Poslano';
$LNG['mg_no_subject']						= 'Ni zadeve';
$LNG['mg_no_text']							= 'Brez besedila';
$LNG['mg_msg_sended']						= 'Sporočilo poslano!';
$LNG['mg_delete_marked']					= 'Izbriši označena sporočila';
$LNG['mg_delete_type_all']					= 'Izbriši vsa sporočila istega tipa';
$LNG['mg_delete_unmarked']					= 'Izbriši vsa neoznačena sporočila';
$LNG['mg_delete_all']						= 'Izbriši vsa sporočila';
$LNG['mg_show_only_header_spy_reports']		= 'Pokaži samo naslove vohunskih poročil';
$LNG['mg_action']							= 'Ukrep';
$LNG['mg_date']								= 'Datum';
$LNG['mg_from']								= 'Od';
$LNG['mg_to']								= 'Za';
$LNG['mg_subject']							= 'Zadeva';
$LNG['mg_confirm_delete']					= 'Potrdi';
$LNG['mg_message_title']					= 'Sporočilo';
$LNG['mg_message_type']						= 'Tip sporočila';
$LNG['mg_total']							= 'Vse';
$LNG['mg_game_operators']					= 'Operaterji igre';
$LNG['mg_error']							= 'Prejemnika ni bilo mogoče najti!';
$LNG['mg_overview']							= 'Pregled';
$LNG['mg_send_new']							= 'Novo';
$LNG['mg_send_to']							= 'Prejemnik';
$LNG['mg_message']							= 'Sporočilo';
$LNG['mg_characters']						= 'Characters';
$LNG['mg_send']								= 'Pošlji';
$LNG['mg_game_message']						= 'Sporočilo igre';
$LNG['mg_message_send']						= 'Sporočilo poslano!';
$LNG['mg_empty_text']						= 'Vnesite besedilo';
$LNG['mg_answer_to']						= 'Odgovori:';

//----------------------------------------------------------------------------//
//ALLIANCE

$LNG['al_not_exists']                       = 'Aliansa ne obstaja.';
$LNG['al_newname_alphanum']					= 'Ime aliance in datum lahko samo vsebujeta alfanumerične znake.';
$LNG['al_newname_no_space']					= 'Ime alianse in datum ne smeta vsebovati presledkov.';
$LNG['al_description_message'] 				= 'Podrobnosti alianse';
$LNG['al_web_text']							= 'Spletna stran alianse';
$LNG['al_request'] 							= 'Prijava';
$LNG['al_click_to_send_request'] 			= 'Kliknite tukaj, da pošljete vašo prijavo aliansi.';
$LNG['al_tag_required'] 					= 'Manjka tag alianse.';
$LNG['al_name_required'] 					= 'Manjka ime alianse.';
$LNG['al_already_exists'] 					= 'Aliansa %s že obstaja.';
$LNG['al_created'] 							= 'Aliansa %s je bila ustvarjena!';
$LNG['al_continue'] 						= 'Naprej';
$LNG['al_alliance_closed'] 					= 'Ta aliansa ne sprejema novih članov.';
$LNG['al_request_confirmation_message']		= 'Zahtevek je bil poslan. <br><a href="?page=alliance">back</a>';
$LNG['al_default_request_text']				= 'Aliansa nima primera prijavnega sporočila.';
$LNG['al_write_request'] 					= 'Napišite zahtevek aliansi %s';
$LNG['al_request_deleted'] 					= 'Izbrisali ste zahtevek. <br> Lahko ustvarite svojo ali pa se pridružite drugi.';
$LNG['al_request_wait_message'] 			= 'Zahtevek aliansi %s ste že poslali<br>';
$LNG['al_delete_request'] 					= 'Izbriši zahtevek';
$LNG['al_founder_cant_leave_alliance'] 		= 'Ustanovitelj ne more zapustiti alianse.';
$LNG['al_leave_sucess'] 					= 'Uspešno ste zapustili alianso %s.';
$LNG['al_do_you_really_want_to_go_out'] 	= 'Ali res želite zapustiti alianso %s ?';
$LNG['al_go_out_yes'] 						= 'Da';
$LNG['al_go_out_no'] 						= 'Ne';
$LNG['al_close_ally'] 						= 'Ali se res želite odreči aliansi?';
$LNG['al_kick_player']						= 'Ali ste prepričani, da hočete odstraniti igralca %s z alianse?';
$LNG['al_circular_sended'] 					= "Krožno sporočilo je poslano.\nSporočilo bodo dobili naslednji igralci:";
$LNG['al_all_players'] 						= 'Vsi igralci';
$LNG['al_no_ranks_defined'] 				= 'Ranki še niso bili definirani.'; 
$LNG['al_request_text']						= 'Prijavno besedilo';
$LNG['al_inside_text']						= 'Interno besedilo';
$LNG['al_outside_text']						= 'Javno besedilo';
$LNG['al_transfer_alliance']				= 'Prenesi alianso';
$LNG['al_disolve_alliance']					= 'Razkropi alianso';
$LNG['al_founder_rank_text']				= 'Ustanovitelj';
$LNG['al_new_member_rank_text']				= 'Nov član';
$LNG['al_acept_request']					= 'Sprejmi';
$LNG['al_you_was_acceted']					= 'Sprejeti ste bili v ';
$LNG['al_hi_the_alliance']					= 'Pozdravljeni!<br>Aliansa <b>';
$LNG['al_has_accepted']						= '</b> je sprejela vaš zahtevek.<br>Sporočilo ustanovitelja: <br>';
$LNG['al_decline_request']					= 'Zavrni';
$LNG['al_you_was_declined']					= 'Bili ste zavrjeni v ';
$LNG['al_has_declined']						= '</b> aliansa je zavrnila vaš zahtevek!<br>Sporočilo ustanovitelja: <br>';
$LNG['al_no_requests']						= 'Ni zahtevkov';
$LNG['al_request_from']						= 'Zahtevek od "%s"';
$LNG['al_no_request_pending']				= 'Trenutno je %d zahtevkov (a)';
$LNG['al_name']								= 'Ime';
$LNG['al_new_name']							= 'Novo ime (3-30 znakov):';
$LNG['al_tag']								= 'Tag';
$LNG['al_new_tag']							= 'Nov tag (3-8 znakov):';
$LNG['al_user_list']						= 'Seznam članov';
$LNG['al_users_list']						= 'Seznam članov (igralcev: %d)';
$LNG['al_manage_alliance']					= 'Upravljanje alianse';
$LNG['al_send_circular_message']			= 'Pošlji krožno sporočilo';
$LNG['al_circular_front_text']				= 'Igralec %s je napisal:';
$LNG['al_new_requests']						= '%d novih prošenj';
$LNG['al_goto_chat']						= 'Pojdi na klepet alianse';
$LNG['al_save']								= 'Shrani';
$LNG['al_dlte']								= 'Izbriši';
$LNG['al_rank_name']						= 'Ime ranka';
$LNG['al_ok']								= 'OK';
$LNG['al_num']								= 'ID';
$LNG['al_member']							= 'Ime';
$LNG['al_request_from_user']				= 'Prijava igralca';
$LNG['al_message']							= 'Sporočilo';
$LNG['al_position']							= 'Rank';
$LNG['al_points']							= 'Točke';
$LNG['al_coords']							= 'Pozicija';
$LNG['al_member_since']						= 'Se je pridružil';
$LNG['al_estate']							= 'Online';
$LNG['al_back']								= 'Nazaj';
$LNG['al_actions']							= 'Dejanja';
$LNG['al_change_title']						= 'Spremeni';
$LNG['al_the_alliance']						= 'alianse';
$LNG['al_change_submit']					= 'Spremeni';
$LNG['al_reply_to_request']					= 'Odgovori na zahtevek';
$LNG['al_reason']							= 'Razlog';
$LNG['al_characters']						= 'Znaki';
$LNG['al_request_list']						= 'Seznam zahtevkov';
$LNG['al_candidate']						= 'Ime';
$LNG['al_request_date']						= 'Datum';
$LNG['al_transfer_alliance']				= 'Prenesi vodstvo alianse.';
$LNG['al_transfer_to']						= 'Prenos na';
$LNG['al_transfer_submit']					= 'Potrdi';
$LNG['al_ally_information']					= 'Informacije alianse';
$LNG['al_ally_info_tag']					= 'Tag';
$LNG['al_ally_info_name']					= 'Ime';
$LNG['al_ally_info_members']				= 'Člani';
$LNG['al_your_request_title']				= 'Vaš zahtevek';
$LNG['al_applyform_send']					= 'Pošlji';
$LNG['al_applyform_reload']					= 'Osveži';
$LNG['al_circular_send_ciruclar']			= 'Pošlji krožno sporočilo';
$LNG['al_circular_alliance']               = 'Aliansa ';
$LNG['al_receiver']							= 'Prejemnik';
$LNG['al_circular_send_submit']				= 'Pošlji';
$LNG['al_circular_reset']					= 'Ponastavi';
$LNG['al_alliance']							= 'Alianse ';
$LNG['al_alliance_make']					= 'Ustanovite svojo alianso';
$LNG['al_alliance_search']					= 'Išči alianse';
$LNG['al_your_ally']						= 'Vaša aliansa';
$LNG['al_rank']								= 'Rank';
$LNG['al_web_site']							= 'Spletna stran';
$LNG['al_inside_section']					= 'Interni del';
$LNG['al_make_alliance']					= 'Najdene alianse';
$LNG['al_make_ally_tag_required']			= 'Tag alianse (3-8 znakov)';
$LNG['al_make_ally_name_required']			= 'Ime alianse (3-30 znakov)';
$LNG['al_make_submit']						= 'Najdeno';
$LNG['al_find_alliances']					= 'Išči alianse';
$LNG['al_find_text']						= 'Išči';
$LNG['al_find_no_alliances']				= 'Ne najdem alians!';
$LNG['al_find_submit']						= 'Išči';
$LNG['al_manage_ranks']						= 'Upravljanje rankov';
$LNG['al_manage_members']					= 'Upravljanje članov';
$LNG['al_manage_change_tag']				= 'Spremeni tag alianse';
$LNG['al_manage_change_name']				= 'Spremeni ime alianse';
$LNG['al_texts']							= 'Upravljanje besedil';
$LNG['al_manage_options']					= 'Možnosti';
$LNG['al_manage_image']						= 'Logo alianse';
$LNG['al_manage_requests']					= 'Zahtevki';
$LNG['al_manage_diplo']                    	= 'Diplomacija alianse';
$LNG['al_requests_not_allowed']				= 'Prijave niso možne (aliansa zaprta)';
$LNG['al_requests_allowed']					= 'Prijave so možne (aliansa odprta)';
$LNG['al_manage_founder_rank']				= 'Rank ustanovitelja';
$LNG['al_configura_ranks']					= 'Konfiguriraj ranke';
$LNG['al_create_new_rank']					= 'Ustvari nov rank';
$LNG['al_rank_name']						= 'Ime';
$LNG['al_create']							= 'Ustvari';
$LNG['al_legend']							= 'Opis dovoljenj';
$LNG['al_legend_disolve_alliance']			= 'Razkropi alianso';
$LNG['al_legend_kick_users']				= 'Odstrani člana';
$LNG['al_legend_see_requests']				= 'Pokaži zahtevke';
$LNG['al_legend_see_users_list']			= 'Pokaži seznam članov';
$LNG['al_legend_check_requests']			= 'Postopki zahtevkov';
$LNG['al_legend_admin_alliance']			= 'Upravljaj alianso';
$LNG['al_legend_see_connected_users']		= 'Pokaži online status na seznamu članov';
$LNG['al_legend_create_circular']			= 'Napiši krožno sporočilo';
$LNG['al_legend_right_hand']				= 'Desna roka (potreben za prenos ustanovitelja alianse)';
$LNG['al_requests']							= 'Zahtevki';
$LNG['al_circular_message']					= 'Krožno sporočilo';
$LNG['al_leave_alliance']					= 'Zapusti alianso';
$LNG['al_Gesamtk']     						= 'Bitke';
$LNG['al_Erfolg']       					= 'Možnosti bitke';
$LNG['al_Siege']        					= 'Zmaga';
$LNG['al_Drawp']        					= 'Neodločeno';
$LNG['al_Loosi']        					= 'Izgubil';
$LNG['al_KGesamt']      					= 'Vse bitke';
$LNG['al_Allyquote']    					= 'Statistika bitk člana';
$LNG['al_Quote']        					= 'Stopnja zmag';
$LNG['al_unitsshut']    					= 'Uničene enote';
$LNG['al_unitsloos']    					= 'Izgubljene enote';
$LNG['al_tfmetall']     					= 'Skupaj ruševin metala';
$LNG['al_tfkristall']   					= 'Skupaj ruševin kristala';
$LNG['al_view_stats']						= 'Javna statistika bitk?';
$LNG['al_view_diplo']                      	= 'Javna diplomacija?';
$LNG['al_memberlist_min']					= 'min';
$LNG['al_memberlist_on']					= 'Online';
$LNG['al_memberlist_off']					= 'Offline';
$LNG['al_diplo']                            = 'Diplomacija';
$LNG['al_diplo_level'][0]                   = 'Wing';
$LNG['al_diplo_level'][1]                   = 'Aliansa ';
$LNG['al_diplo_level'][2]                   = 'Trgovna aliansa';
$LNG['al_diplo_level'][3]                   = 'Ne-agresiven pakt';
$LNG['al_diplo_level'][4]                   = 'Vojna';
$LNG['al_diplo_no_entry']                   = '- Pakt ne obstaja -';
$LNG['al_diplo_no_accept']                  = '- Ni zahtevkov na voljo -';
$LNG['al_diplo_accept']                    	= 'Prihodni zahtevki';
$LNG['al_diplo_accept_send']                = 'Odhodni zahtevki';
$LNG['al_diplo_create']                    	= 'Ustvari nov pakt.';
$LNG['al_diplo_create_done']                = 'Pakt uspešno ustvarjen.';
$LNG['al_diplo_ally']                       = 'Aliansa';
$LNG['al_diplo_level_des']                  = 'Tip pakta';
$LNG['al_diplo_text']                       = 'Vprašanje/utemeljitev';
$LNG['al_diplo_accept_yes']                	= 'Pakt sklenjen.';
$LNG['al_diplo_accept_yes_mes']            	= 'Pakt %s je bil sklenjen med aliansama %s in %s!';
$LNG['al_diplo_accept_yes_confirm']			= 'Ali želite sprejeti nov pakt?';
$LNG['al_diplo_accept_no']                  = 'Pakt zavrnjen.';
$LNG['al_diplo_accept_no_mes']              = 'Pakt %s med aliansama %s in %s je bil zavrnjen!';
$LNG['al_diplo_accept_no_confirm']			= 'Ali res želite zarniti pakt? ';
$LNG['al_diplo_delete']                    	= 'Odpravi pakt.';
$LNG['al_diplo_delete_mes']                	= 'Pakt %s med aliansama %s in %s  je bil odpravljen!';
$LNG['al_diplo_confirm_delete']           	= 'Ali res želite odstraniti ta pakt?';
$LNG['al_diplo_ground']                    	= 'Razlog:';
$LNG['al_diplo_ask']                        = 'Zahteva pakta';
$LNG['al_diplo_ask_mes']                    = 'Obstaja zahteva pakta (%s) aliansa %s in %s.<br>Aliansa: %s';
$LNG['al_diplo_war']                        = 'Izjava o vojni';
$LNG['al_diplo_war_mes']                    = 'The alliance %s has the alliance %s just this one %s explain. <br>Grounds:<br>%s<br><br>Information: The war is valid in 24 hours. The bash is regulate dropped only after the 24 hours. <br>You find further information into this one <a href="index.php?page=rules" target="_blank">Rules</a>.';
$LNG['al_leave_ally']						= 'Ali res želite zapustiti alianso?';
$LNG['al_default_leader_name']				= 'Vodja';

//----------------------------------------------------------------------------//
//BUDDY
$LNG['bu_request_exists']					= 'Zahtevek za tega igralca je že poslan!';
$LNG['bu_cannot_request_yourself']			= 'Ne morate sami sebi poslati zahtevka za prijateljstvo';
$LNG['bu_request_message']					= 'Zahtevek';
$LNG['bu_player']							= 'Igralec';
$LNG['bu_request_text']						= 'Besedilo zahtevka';
$LNG['bu_characters']						= 'Znaki';
$LNG['bu_back']								= 'Nazaj';
$LNG['bu_send']								= 'Pošlji';
$LNG['bu_cancel_request']					= 'Prekliči zahtevek';
$LNG['bu_accept']							= 'Sprejmi';
$LNG['bu_decline']							= 'Zavrni';
$LNG['bu_connected']						= 'Povezan';
$LNG['bu_minutes']							= ' min';
$LNG['bu_disconnected']						= 'Offline';
$LNG['bu_online']							= 'Online';
$LNG['bu_buddy_list']						= 'Seznam prijateljev';
$LNG['bu_requests']							= 'AZahtevki';
$LNG['bu_alliance']							= 'Aliansa';
$LNG['bu_coords']							= 'Koordinati';
$LNG['bu_text']								= 'Besedilo';
$LNG['bu_action']							= 'Ukrep';
$LNG['bu_my_requests']						= 'Moji zahtevki';
$LNG['bu_partners']							= 'Prijatelji';
$LNG['bu_delete']							= 'Izbriši';
$LNG['bu_no_request']						= 'Ni zahtevkov!';
$LNG['bu_no_buddys']						= 'Nobenih prijateljev za zdaj!';
$LNG['bu_request_send']						= 'Zahtevek poslan!';

//----------------------------------------------------------------------------//
//NOTES
$LNG['nt_important']						= 'Pomembno';
$LNG['nt_normal']							= 'Normalno';
$LNG['nt_unimportant']						= 'Nepomembno';
$LNG['nt_create_note']						= 'Ustvari beležko';
$LNG['nt_you_dont_have_notes']				= 'Ni beležk na voljo';
$LNG['nt_notes']							= 'Beležke';
$LNG['nt_create_new_note']					= 'Ustvari novo beležko';
$LNG['nt_edit_note']						= 'Uredi beležko';
$LNG['nt_date_note']						= 'Datum';
$LNG['nt_subject_note']						= 'Zadeva';
$LNG['nt_size_note']						= 'Velikost';
$LNG['nt_dlte_note']						= 'Izbriši';
$LNG['nt_priority']							= 'Prioriteta';
$LNG['nt_note']								= 'Opomba';
$LNG['nt_characters']						= 'Znaki';
$LNG['nt_back']								= 'Nazaj';
$LNG['nt_reset']							= 'Ponastavit';
$LNG['nt_save']								= 'Shrani';
$LNG['nt_no_title']							= 'Brez naslova';
$LNG['nt_no_text']							= 'Brez besedila';

//----------------------------------------------------------------------------//
//STATISTICS
$LNG['st_player']							= 'Igralec';
$LNG['st_alliance']							= 'Aliansa';
$LNG['st_points']							= 'Točke';
$LNG['st_fleets']							= 'Flota';
$LNG['st_researh']							= 'Raziskave';
$LNG['st_buildings']						= 'Zgradbe';
$LNG['st_defenses']							= 'Obramba';
$LNG['st_position']							= 'Rank';
$LNG['st_members']							= 'Član';
$LNG['st_per_member']						= 'Na člana';
$LNG['st_statistics']						= 'Statistika';
$LNG['st_updated']							= 'Posodobljeno';
$LNG['st_show']								= 'Pokaži';
$LNG['st_per']								= 'na';
$LNG['st_in_the_positions']					= 'V rankih';
$LNG['st_write_message']					= 'Zasebno sporočilo';

//----------------------------------------------------------------------------//
//SEARCH
$LNG['sh_tag']								= 'Tag';
$LNG['sh_name']								= 'Ime';
$LNG['sh_members']							= 'Član';
$LNG['sh_points']							= 'Točk';
$LNG['sh_search_in_the_universe']			= 'Išči v vesolju';
$LNG['sh_player_name']						= 'Ime igralca';
$LNG['sh_planet_name']						= 'Ime planeta';
$LNG['sh_alliance_tag']						= 'Tag alianse';
$LNG['sh_alliance_name']					= 'Ime alianse';
$LNG['sh_search']							= 'Išči';
$LNG['sh_write_message']					= 'Zasebno sporočilo';
$LNG['sh_buddy_request']					= 'Zahtevek za prijateljstvo';
$LNG['sh_alliance']							= 'Aliansa';
$LNG['sh_planet']							= 'Planet';
$LNG['sh_coords']							= 'Pozicija';
$LNG['sh_position']							= 'Rank';

//----------------------------------------------------------------------------//
//OPTIONS
$LNG['op_cant_activate_vacation_mode']		= 'Časa dopusta ni mogoče aktivirati, če gradite zgradbe ali premikate flote.';
$LNG['op_password_changed']					= 'Geslo je bilo uspešno spremenjeno<br><a href="index.php" target="_top">back</a>';
$LNG['op_username_changed']					= 'Uporabniško ime je bilo uspešno spremenjeno<br><a href="index.php" target="_top">Back</a>';
$LNG['op_options_changed']					= 'Spremembe so bile uspešno shranjene.<br><a href="game.php?page=options">Back</a>';
$LNG['op_vacation_mode_active_message']		= 'Čas dopusta je vklopljen. Mora biti vklopljen vsaj do: ';
$LNG['op_end_vacation_mode']				= 'Izklopi čas dopusta';
$LNG['op_save_changes']						= 'Shrani spremembe';
$LNG['op_admin_title_options']				= 'Možnosti administratorjev';
$LNG['op_admin_planets_protection']			= 'Zaščita planetov administratorjev';
$LNG['op_user_data']						= 'Podatki uporabnika';
$LNG['op_username']							= 'Uporabniško ime';
$LNG['op_old_pass']							= 'Staro geslo';
$LNG['op_new_pass']							= 'Novo geslo (min. 8 znakov)';
$LNG['op_repeat_new_pass']					= 'Novo geslo (ponovno)';
$LNG['op_email_adress']						= 'E-poštni naslov';
$LNG['op_permanent_email_adress']			= 'Stalen e-poštni naslov';
$LNG['op_general_settings']					= 'Osnovne nastavitve';
$LNG['op_sort_planets_by']					= 'Razvrsti planete po:';
$LNG['op_sort_kind']						= 'Razvrščanje:';
$LNG['op_lang']								= 'Jezik';
$LNG['op_skin_example']						= 'Pot do oblik (z.B. C:/SG/skins/)';
$LNG['op_show_skin']						= 'Prikaži obliko';
$LNG['op_deactivate_ipcheck']				= 'Deaktiviraj preverjanje IP';
$LNG['op_galaxy_settings']					= 'Nastavitve pogleda galaksije';
$LNG['op_spy_probes_number']				= 'Število vohunskih sond';
$LNG['op_toolt_data']						= 'Pokaži namig za:';
$LNG['op_seconds']							= 'Sekund';
$LNG['op_max_fleets_messages']				= 'Maks. sporočil flot';
$LNG['op_show_planetmenu']					= 'Meni prikaza planetov';
$LNG['op_shortcut']							= 'Bližnjica';
$LNG['op_show']								= 'Pokaži';
$LNG['op_spy']								= 'Vohuni';
$LNG['op_write_message']					= 'Napiši sporočilo';
$LNG['op_add_to_buddy_list']				= 'Dodaj kot prijatelja';
$LNG['op_missile_attack']					= 'Raketni napad';
$LNG['op_send_report']						= 'Pošlji poročilo';
$LNG['op_vacation_delete_mode']				= 'Čas dopusta / Izbriši račun';
$LNG['op_activate_vacation_mode']			= 'Aktiviraj čas dopusta';
$LNG['op_dlte_account']						= 'Izbriši račun';
$LNG['op_email_adress_descrip']				= 'Svoj e-poštni naslov lahko spremenite kadarkoli. Po sedmih dneh brez spremembe se naslov nastavi kot stalen.';
$LNG['op_deactivate_ipcheck_descrip']		= 'IP check pomeni, da boš avtomatsko izpisan v primeru, da se tvoj IP naslov spremeni ali pa se v isti račun vpišeta 2 igralca. Deaktivacija je na lastno odgovornost!';
$LNG['op_spy_probes_number_descrip']		= 'Število vohunskih sond, ki jih pošljete na eno vohunjenje s klikom na planet v meniju galaksije.';
$LNG['op_activate_vacation_mode_descrip']	= 'Čas dopusta te varuje, ko si dlje časa odsoten. Aktiviran je lahko samo če se nič ne gradi (flota, zgradbe, obramba) in nič ne raziskuje ter nobena flota ni na poti. Ko ga aktiviraš si zaščiten pred napadi. Vendar pa bodo napadi, ki so bili poslani pred aktivacijo, izvršeni. Med časom dopusta je vsa proizvodnja izključena in se mora spet ročno vključiti na 100%, ko prideš nazaj. Čas dopusta traja najmanj 2 dni in se ne more predčasno izključiti.';
$LNG['op_dlte_account_descrip']				= 'Če kliknete tu, bo vaš račun avtomatsko izbrisan po 7 dneh.';
$LNG['op_need_pass_mail']					= 'Če želiti spremeniti vaš e-poštni naslov, morate vnesti geslo!';
$LNG['op_not_vaild_mail']					= 'E-poštni naslov ni veljaven!';
$LNG['op_change_mail_exist']				= 'E-poštni naslov %s je že v uporabi!';
$LNG['op_sort_normal']						= 'Čas ustanovitve';
$LNG['op_sort_koords']						= 'Po koordniatih';
$LNG['op_sort_abc']							= 'Po abecedi';
$LNG['op_sort_up']							= 'Naraščujoče';
$LNG['op_sort_down']						= 'Padajoče';
$LNG['op_user_name_no_alphanumeric']		= 'Uporabniško ime lahko samo vsebuje alfanumerične znake!';
$LNG['op_change_name_pro_week']				= 'Uporabniško ime lahko spremenite samo 1x na teden';
$LNG['op_change_name_exist']				= 'Uporabnik %s že obstaja';
$LNG['op_active_build_messages']			= 'Omogoči sporočila gradnje';
$LNG['op_small_storage']                    = 'Skrajšaj prikaz skladišča';

//----------------------------------------------------------------------------//
//BANNED
$LNG['bn_no_players_banned']				= 'Ni bannanih igralcev';
$LNG['bn_exists']							= 'Vsi ';
$LNG['bn_players_banned']					= ' igralcev bannanih';
$LNG['bn_players_banned_list']				= 'Seznam bannanih igralcev';
$LNG['bn_player']							= 'Igralec';
$LNG['bn_reason']							= 'Razlog';
$LNG['bn_from']								= 'Od';
$LNG['bn_until']							= 'Do';
$LNG['bn_by']								= 'Od';
$LNG['bn_writemail']						= 'Pošlji %s';

//----------------------------------------------------------------------------//
//class.CheckSession.php

$LNG['css_account_banned_message']			= 'Vaš račun je bannan!';
$LNG['css_account_banned_expire']			= 'Bannani ste do %s <br><a href="./index.php?page=pranger">Banlist</a>';
$LNG['css_goto_homeside']					= '<a href="./index.php">Domov</a>';
$LNG['css_server_maintrace']				= 'Vzdrževanje strežnika.<br><br>Igra trenutno ni na voljo.<br><br>Razlog: %s';

//----------------------------------------------------------------------------//
//class.debug.php
$LNG['cdg_mysql_not_available']				= 'Povezave do baze podatkov ni mogoče vzpostaviti.<br>ŽPoskusite znova pozneje.<br><br>Hvala za razumevanje.';
$LNG['cdg_error_message']					= 'Napaka. Obrnite se na administratorja sistema. Št. napake: ';
$LNG['cdg_fatal_error']						= 'USODNA NAPAKA';

//----------------------------------------------------------------------------//
//class.FlyingFleetsTable.php

$LNG['cff_no_fleet_data']					= 'Ni podatkov o ladji';
$LNG['cff_acs_fleet']						= 'Acs flota';
$LNG['cff_fleet_own']						= 'Flota';
$LNG['cff_fleet_target']					= 'Flote';
$LNG['cff_mission_acs']						= '%s z %s %s %s je dosegla %s %s %s. Misija: %s';
$LNG['cff_mission_own_0']					= 'Ena izmed vaših %s from %s %s %s je dosegla %s %s %s. Misija: %s';
$LNG['cff_mission_own_1']					= 'Ena izmed vaših %s se vrača z %s %s %s nazaj na %s %s %s. Misija: %s';
$LNG['cff_mission_own_2']					= 'Ena izmed vaših %s z %s %s %s je v orbiti %s %s %s. Misija: %s';
$LNG['cff_mission_own_mip']					= 'Raketni napad (%d) z %s %s %s na %s %s %s.';
$LNG['cff_mission_own_expo_0']				= 'Ena izmed vaših %s z %s %s %s je dosegla pozicijo %s. Misija: %s';
$LNG['cff_mission_own_expo_1']				= 'Ena izmed vaših %s se je vrnila s pozicije %s nazaj na %s %s %s. Misija: %s';
$LNG['cff_mission_own_expo_2']				= 'Ena izmed vaših %s z %s %s %s je na eksediciji na poziciji %s. Misija: %s';
$LNG['cff_mission_own_recy_0']				= 'Ena izmed vaših %s z %s %s %s je dosegla ruševine %s. Misija: %s';
$LNG['cff_mission_own_recy_1']				= 'Ena izmed vaših %s se vrača z ruševin %s nazaj na planet %s %s %s. Misija: %s';
$LNG['cff_mission_target_bad']				= 'Sovražna %s od igralca %s z %s %s %s je dosegla %s %s %s. Misija: %s';
$LNG['cff_mission_target_good']				= 'Sovražna %s od igralca %s z %s %s %s je dosegla %s %s %s. Misija: %s';
$LNG['cff_mission_target_stay']				= 'Prijazna %s od igralca %s z %s %s %s je v orbiti %s %s %s. Misija: %s';
$LNG['cff_mission_target_mip']				= 'Raketni napad (%d) igralca %s z %s %s %s na %s %s %s.';

//----------------------------------------------------------------------------//
// EXTRA LANGUAGE FUNCTIONS
$LNG['fcm_planet']							= 'Planet';
$LNG['fcm_moon']							= 'Luna';
$LNG['fcm_info']							= 'Informacije';
$LNG['fcp_colony']							= 'Kolonija';
$LNG['fgp_require']							= 'Zahteve: ';
$LNG['fgf_time']							= 'Trajanje gradnje: ';
$LNG['sys_module_inactive']        	 		= 'Modul neaktiven';
$LNG['sys_refferal_from']        	 		= 'Sistem';
$LNG['sys_refferal_title']        	 		= 'Bonus za igralce %s';
$LNG['sys_refferal_text']					= 'Igralci %s, ki ste jih vi povabili so pridobili %s Točk.<br><br>Pridobili ste aktivne igralce, dobite %s %s';


//----------------------------------------------------------------------------//
// CombatReport.php
$LNG['cr_lost_contact']						= 'Kontakt z floto je bil izgubljen. ';
$LNG['cr_first_round']						= '(Flota je bila uničena v prvem krogu.) ';
$LNG['cr_type']								= 'Tp';
$LNG['cr_total']							= 'Skupaj';
$LNG['cr_weapons']							= 'Orožja';
$LNG['cr_shields']							= 'Sčit';
$LNG['cr_armor']							= 'Oklep';
$LNG['cr_destroyed']						= 'Uničene!';

//----------------------------------------------------------------------------//
// FleetAjax.php
$LNG['fa_not_enough_probes']				= 'Nobena sonda ni na voljo';
$LNG['fa_galaxy_not_exist']					= 'Zahtevana galaksija ne obstaja';
$LNG['fa_system_not_exist']					= 'Zahtevan sistem ne obstaja';
$LNG['fa_planet_not_exist']					= 'Zahtevan planet ne obstaja';
$LNG['fa_not_enough_fuel']					= 'Nimate dovolj deuteriuma';
$LNG['fa_no_more_slots']					= 'Ni dovolj slotov za floto';
$LNG['fa_no_recyclers']						= 'Noben recikler ni na voljo';
$LNG['fa_no_fleetroom']						= 'Ni dovolj prostora za gorivo';
$LNG['fa_mission_not_available']			= 'Misija ni na voljo';
$LNG['fa_no_spios']							= 'Nobena sonda ni na voljo';
$LNG['fa_vacation_mode']					= 'Igralec je v stanju dopusta';
$LNG['fa_week_player']						= 'Igralec je prešibak';
$LNG['fa_strong_player']					= 'Igralec je premočan';
$LNG['fa_not_spy_yourself']					= 'Ne morate vohuniti sebe!';
$LNG['fa_not_attack_yourself']				= 'Ne morate napasti sebe';
$LNG['fa_action_not_allowed']				= 'Dejanje ni možno';
$LNG['fa_vacation_mode_current']			= 'Napaka, ste v času dopusta';
$LNG['fa_sending']							= 'Poslano';

//----------------------------------------------------------------------------//
// MissilesAjax.php
$LNG['ma_silo_level']						= 'Potrebno je izstrelišče 4. stopnje!';
$LNG['ma_impulse_drive_required']			= 'Potreben je impulzni pogon';
$LNG['ma_not_send_other_galaxy']			= 'Ne morate poslati raket v drugo galaksijo. ';
$LNG['ma_planet_doesnt_exists']				= 'Planet ne obstaja. ';
$LNG['ma_wrong_target']						= 'Napačna tarča';
$LNG['ma_no_missiles']						= 'Ni raket';
$LNG['ma_add_missile_number']				= 'Vpišite število raket! ';
$LNG['ma_misil_launcher']					= 'Raketnik';
$LNG['ma_small_laser']						= 'Lahki laser';
$LNG['ma_big_laser']						= 'Težek laser';
$LNG['ma_gauss_canyon']						= 'Gaussov top';
$LNG['ma_ionic_canyon']						= 'Ionski top';
$LNG['ma_buster_canyon']					= 'Plazemski top';
$LNG['ma_small_protection_shield']			= 'Majhen ščit';
$LNG['ma_big_protection_shield']			= 'Velik ščit';
$LNG['ma_all']								= 'Vse';
$LNG['ma_missiles_sended']					= ' Rakete so izstreljene. Ciljni objekti: ';

//----------------------------------------------------------------------------//
// topkb.php
$LNG['tkb_top']                  			= 'Top lista';
$LNG['tkb_gratz']                  			= 'Celotna ekipa čestita top stotim igracev';
$LNG['tkb_platz']                  			= 'Mesto';
$LNG['tkb_owners']             				= 'Udeleženci';
$LNG['tkb_datum']                  			= 'Datum';
$LNG['tkb_units']             				= 'Enote';
$LNG['tkb_legende']               		 	= '<b>Legenda: </b>';
$LNG['tkb_gewinner']              		 	= '<b>-Zmagovalec-</b>';
$LNG['tkb_verlierer']              			= '<b>-Poraženec-</b>';
$LNG['tkb_unentschieden']         			= '<b>-Neodločeno- </b>';
$LNG['tkb_missing']              		  	= '<br>Pogrešan v akciji: uporabniški račun ne obstaja več.';

//----------------------------------------------------------------------------//
// playercard.php
$LNG['pl_overview']  						= 'Kartica igralca';
$LNG['pl_name'] 							= 'Uporabniško ime';
$LNG['pl_homeplanet'] 						= 'Glavni planet';
$LNG['pl_ally']     						= 'Aliansa';
$LNG['pl_message']    						= 'Sporočilo';
$LNG['pl_buddy']        					= 'Zahteva za prijateljstvo';
$LNG['pl_points']      						= 'Točk';
$LNG['pl_range']         					= 'Rank';
$LNG['pl_builds']     						= 'Zgradbe';
$LNG['pl_tech']    							= 'Raziskave';
$LNG['pl_fleet']       						= 'Flota';
$LNG['pl_def']         						= 'Obramba';
$LNG['pl_total']       						= 'Skupaj';
$LNG['pl_fightstats'] 						= 'Statistika bitk';
$LNG['pl_fights']     						= 'Bitke';
$LNG['pl_fprocent']       					= 'Fight quota ';
$LNG['pl_fightwon']  						= 'Zmagal';
$LNG['pl_fightdraw']  						= 'Neodločeno';
$LNG['pl_fightlose']  						= 'Izgubil';
$LNG['pl_totalfight']      					= 'Skupaj bitk';
$LNG['pl_destroy']    						= '%s uničenih';
$LNG['pl_unitsshot']    					= 'Enot uničenih';
$LNG['pl_unitslose']    					= 'Enot izgubljenih';
$LNG['pl_dermetal']    						= 'Recikliran Metal';
$LNG['pl_dercrystal']   					= 'Recikliran Kristal';
$LNG['pl_etc']   							= 'Sporočilo';

//----------------------------------------------------------------------------//
// Support

$LNG['supp_header'] 						= 'Podpora';
$LNG['supp_header_g'] 						= 'Podporna kartica';
$LNG['ticket_id'] 							= 'ID Kartice';
$LNG['subject'] 							= 'Zadeva';
$LNG['status'] 								= 'Status';
$LNG['ticket_posted'] 						= 'Kartica poslana';
$LNG['ticket_new'] 							= 'Nova kartica';
$LNG['input_text'] 							= 'Vnos:';
$LNG['answer_new'] 							= 'Odgovor:';
$LNG['text'] 								= 'Podrobnosti';
$LNG['message_a'] 							= 'Status sporočila:';
$LNG['sendit_a'] 							= 'Vaše sporočilo je bilo poslano. Počakajte na odgovor. ';
$LNG['message_t'] 							= 'Status kartice: ';
$LNG['supp_send'] 							= 'Pošlji';
$LNG['sendit_t'] 							= 'Vaša kartica je bila poslana. Počakajte na odgovor.';
$LNG['close_t'] 							= 'Kartica je zaprta. ';
$LNG['sendit_error'] 						= 'Napaka:';
$LNG['sendit_error_msg'] 					= 'Nekaj ste pozabili vtipkati! ';
$LNG['supp_admin_system'] 					= 'Podporna stran adminov';
$LNG['close_ticket'] 						= 'Zapri kartico';
$LNG['open_ticket'] 						= 'Odpri kartico';
$LNG['player'] 								= 'Ime igralcev';
$LNG['supp_ticket_close']					= 'Kartica zaprta';
$LNG['supp_close'] 							= 'Zaprto';
$LNG['supp_open'] 							= 'Odprto';
$LNG['supp_admin_answer'] 					= 'Odgovor admina';
$LNG['supp_player_answer'] 					= 'Odgovor igralca';
$LNG['supp_player_write'] 					= '%s je napisal %s';

//----------------------------------------------------------------------------//
// Rekorde 

$LNG['rec_build']  							= 'Zgradbe';
$LNG['rec_specb']							= 'Posebne zgradbe';
$LNG['rec_playe']  							= 'Igralec';
$LNG['rec_defes']  							= 'Obramba';
$LNG['rec_fleet']  							= 'Ladje';
$LNG['rec_techn']  							= 'Raziskave';
$LNG['rec_level']  							= 'Stopnja';
$LNG['rec_nbre']   							= 'Število';
$LNG['rec_rien']   							= '-';
$LNG['rec_last_update_on']   				= 'Zadnja posodobitev: %s';


//----------------------------------------------------------------------------//
// BattleSimulator

$LNG['bs_derbis_raport']					= "Potrebujete %s %s ali %s %s za ruševine na poziciji";
$LNG['bs_steal_raport']						= "Potrebujete %s %s ali %s %s za %s %s plena na planetu.";
$LNG['bs_names']							= "Ime ladje/obrambe";
$LNG['bs_atter']							= "Napadalec";
$LNG['bs_deffer']							= "Branilec";
$LNG['bs_steal']							= "Surovine (Branilec):";
$LNG['bs_techno']							= "Tehnologija";
$LNG['bs_send']								= "Izračunaj";
$LNG['bs_cancel']							= "Ponastavi";
$LNG['bs_wait']								= "Počakajte 10 sekund za naslednjo simulacijo";
$LNG['bs_acs_slot']							= 'ACS-Slot';
$LNG['bs_add_acs_slot']						= 'Dodaj ACS-Slot';

//----------------------------------------------------------------------------//
// Fleettrader
$LNG['ft_head']								= 'Trgovec z floto';
$LNG['ft_count']							= 'Število';
$LNG['ft_max']								= 'Maks';
$LNG['ft_total']							= 'Skupaj';
$LNG['ft_charge']							= 'Provizija trgovca';
$LNG['ft_absenden']							= 'Potrdi';
$LNG['ft_empty']							= 'Nimate ničesar da bi lahko izmenjali!';

//----------------------------------------------------------------------------//
// Logout
$LNG['lo_title']						= 'Izpis uspešen! Se kmalu spet vidimo :)';
$LNG['lo_logout']						= 'Seja se je končala';
$LNG['lo_redirect']						= 'Preusmeritev';
$LNG['lo_notify']						= 'Preusmerjeni boste v <span id="seconds"> 5 </span> s';
$LNG['lo_continue']						= 'Kliknite tukaj če vas ne preusmeri avtomtsko.';

?>