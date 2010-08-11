<?php

//LANUAGES
$LNG['langs']    = array(
    'de' => 'Deutsch', 
    'en' => 'English', 
    'es' => 'Español', 
    'ru' => 'Русский', 
    'pt' => 'Português',
    'cn' => '简体中文',
    'hr' => 'Hrvatski',
);

//SERVER GENERALS
$LNG['Metal']								= 'Metal';
$LNG['Crystal']							= 'Kristal';
$LNG['Deuterium']							= 'Deuterij';
$LNG['Darkmatter']							= 'Crna Materija';
$LNG['Energy']								= 'Energija';
$LNG['Messages']							= 'Poruke';
$LNG['write_message']						= 'Pisi poruku';

$LNG['show_planetmenu']					= 'Pokazi / Sakrij';

$LNG['type_mission'][1]  					= 'Napad';
$LNG['type_mission'][2]  					= 'Grupni napad';
$LNG['type_mission'][3]  					= 'Transport';
$LNG['type_mission'][4]  					= 'Stacioniraj';
$LNG['type_mission'][5]  					= 'Parkiraj';
$LNG['type_mission'][6]  					= 'spijuniraj';
$LNG['type_mission'][7]  					= 'Koloniziraj';
$LNG['type_mission'][8]  					= 'Recikliraj';
$LNG['type_mission'][9]  					= 'Unisti';
$LNG['type_mission'][11]  					= 'Materiju potrazi';
$LNG['type_mission'][15] 					= 'Ekspedicija';

$LNG['user_level'] = array (
	'0' => 'Igrac',
	'1' => 'Moderator',
	'2' => 'Operator',
	'3' => 'Administrator',
);

// GAME.PHP
$LNG['see_you_soon']						= 'Hvala za igranje';
$LNG['page_doesnt_exist']					= 'Ova stranica ne postoji';


//----------------------------------------------------------------------------//
//TOPNAV
$LNG['tn_vacation_mode']					= 'U modusu odsustva si ';
$LNG['tn_delete_mode']						= 'Tvoj racun %s je stavljen na brisanje!';

//----------------------------------------------------------------------------//
//LEFT MENU
$LNG['lm_overview']						= 'Pregled';
$LNG['lm_galaxy']							= 'Galaksija';
$LNG['lm_empire']							= 'Carstvo';
$LNG['lm_fleet']							= 'Flota';
$LNG['lm_buildings']						= 'Zgrade';
$LNG['lm_research']						= 'Istrazivanje';
$LNG['lm_shipshard']						= 'Brodogradnja';
$LNG['lm_defenses']						= 'Obrana';
$LNG['lm_resources']						= 'Resursi';
$LNG['lm_officiers']						= 'Oficiri & Materija';
$LNG['lm_trader']							= 'Trgovac';
$LNG['lm_technology']						= 'Tehnologija';
$LNG['lm_messages']						= 'Poruke';
$LNG['lm_alliance']						= 'Savez';
$LNG['lm_buddylist']						= 'Prijatelji';
$LNG['lm_notes']							= 'Notes';
$LNG['lm_statistics']						= 'Statistika';
$LNG['lm_search']							= 'Trazi';
$LNG['lm_options']							= 'Postavke';
$LNG['lm_banned']							= 'Kaznjeni';
$LNG['lm_contact']							= 'kontakt';
$LNG['lm_forums']							= 'Forum';
$LNG['lm_logout']							= 'Odjava';
$LNG['lm_administration']					= 'Administracija';
$LNG['lm_game_speed']						= 'Igra';
$LNG['lm_fleet_speed']						= 'Flota';
$LNG['lm_resources_speed']					= 'Resursi';
$LNG['lm_queue']							= 'Redovi';
$LNG['lm_topkb']							= 'HoF';
$LNG['lm_faq']								= 'Vodic za pocetnike';
$LNG['lm_records']							= 'Rekordi';
$LNG['lm_chat']							= 'Chat';
$LNG['lm_support']							= 'Pitanja';
$LNG['lm_rules']							= 'Pravila';
$LNG['lm_battlesim']						= "Simulator Borbe";


//----------------------------------------------------------------------------//
//OVERVIEW

$LNG['ov_newname_alphanum']				= 'Ime planete mora se sastojati samo od alfanumerickih znakova.';
$LNG['ov_newname_no_space']				= 'Ime planete nemoze sadrzavati razmak.';
$LNG['ov_planet_abandoned']				= 'Planet upjesno napusten!';
$LNG['ov_principal_planet_cant_abanone']	= 'Ne mozete izbrisati Vas glavni planet!';
$LNG['ov_abandon_planet_not_possible']		= 'Kolonija se nemoze izbrisati ako ima aktivnosti flote prema njoj ili sa nje!';
$LNG['ov_wrong_pass']						= 'Pogresna lozinka.pokusaj ponovo!';
$LNG['ov_have_new_message']				= 'Imas novu poruku';
$LNG['ov_have_new_messages']				= 'Imas %d nova poruka';
$LNG['ov_planetmenu']						= 'Promjeni ime / Izbrisi';
$LNG['ov_free']							= 'Slobodno';
$LNG['ov_news']							= 'Novosti';
$LNG['ov_place']							= 'Mjesto';
$LNG['ov_of']								= 'od';
$LNG['ov_planet']							= 'Planeta';
$LNG['ov_server_time']						= 'Vrijeme servera ';
$LNG['ov_events']							= 'Zbivanja';
$LNG['ov_diameter']						= 'Promjer';
$LNG['ov_distance_unit']					= 'km';
$LNG['ov_temperature']						= 'Temperatura';
$LNG['ov_aprox']							= 'Priblizno';
$LNG['ov_temp_unit']						= '°C';
$LNG['ov_to']								= 'prema';
$LNG['ov_position']						= 'Pozicija';
$LNG['ov_points']							= 'Bodovi';
$LNG['ov_security_request']				= 'Sigurnosno pitanje';
$LNG['ov_security_confirm']				= 'Molimo potvrdite da se planet';
$LNG['ov_with_pass']						= 'obrise.';
$LNG['ov_password']						= 'Lozinka';
$LNG['ov_delete_planet']					= 'Obrisi planetu';
$LNG['ov_your_planet']						= 'Moja planeta';
$LNG['ov_coords']							= 'Pozicija';
$LNG['ov_abandon_planet']					= 'Srusi koloniju';
$LNG['ov_planet_name']						= 'Ime';
$LNG['ov_actions']							= 'Akcija';
$LNG['ov_planet_rename']					= 'Preimenuj';
$LNG['ov_planet_rename_action']			= 'Preimenuj';
$LNG['ov_fields']							= 'Polja';
$LNG['ov_developed_fields']                = 'Popunjenih polja';
$LNG['ov_max_developed_fields']			= 'max.dostupnih polja';
$LNG['ov_fleet']							= 'Flota';
$LNG['ov_admins_online']					= 'Admins(Online):';
$LNG['ov_no_admins_online']				= 'Trenutno nitko nije online!';
$LNG['ov_userbanner']						= 'Korisnik Statistika Banner(Azurira se svakih 24 sata)';
$LNG['ov_userrank_info']					= '%s (%s <a href="game.php?page=statistics&amp;range=%d">%d</a> %s %s)';
$LNG['ov_teamspeak_not_online']			= 'Server je trenutno nedostupan. Molimo vas za razumijevanje.';
$LNG['ov_teamspeak']						= 'Teamspeak';
$LNG['ov_teamspeak_v2']					= '<a href="teamspeak://%s:%s?nickname=%s" title="Teamspeak Connect">Connect</a> &bull; Online: %d/%d &bull; Channels: %d &bull; Traffic ges.: %s MB';
$LNG['ov_teamspeak_v3']					= '<a href="ts3server://%s?port=%d&amp;nickname=%s&amp;password=%s" title="Teamspeak Connect">Connect</a>&nbsp;&bull;&nbsp;Online: %d/%d &bull; Channels: %d &bull; Traffic ges.: %s MB';

//----------------------------------------------------------------------------//
//GALAXY
$LNG['gl_no_deuterium_to_view_galaxy']		= 'Nemas dovoljno deuterija!';
$LNG['gl_legend']							= 'Legenda';
$LNG['gl_strong_player']					= 'Jaki igrac';
$LNG['gl_week_player']						= 'Slab igrac';
$LNG['gl_vacation']						= 'Odmor';
$LNG['gl_banned']							= 'Kaznjen';
$LNG['gl_inactive_seven']					= '7 Dana inaktivan';
$LNG['gl_inactive_twentyeight']			= '28 Dana inaktivan';
$LNG['gl_s']								= 'J';
$LNG['gl_w']								= 'S';
$LNG['gl_v']								= 'O';
$LNG['gl_b']								= 'K';
$LNG['gl_i']								= 'i';
$LNG['gl_I']								= 'I';
$LNG['gl_populed_planets']					= '%d Planeta naseljeno';
$LNG['gl_out_space']						= 'Klikni tu za slanje ekspedicije';
$LNG['gl_avaible_missiles']				= 'Rakete';
$LNG['gl_fleets']							= 'Mjesta za flotu';
$LNG['gl_avaible_grecyclers']				= 'Giga Recikler';
$LNG['gl_avaible_recyclers']				= 'Recikler';
$LNG['gl_avaible_spyprobes']				= 'Sonda za spijunazu';
$LNG['gl_missil_launch']					= 'Napad raketama';
$LNG['gl_missil_to_launch']				= 'Broj raketa (<b>%d</b> ostalo):';
$LNG['gl_all_defenses']					= 'Sve';
$LNG['gl_objective']						= 'Cilj';
$LNG['gl_missil_launch_action']			= 'Poslati';
$LNG['gl_galaxy']							= 'Galaksija';
$LNG['gl_solar_system']					= 'Sistem';
$LNG['gl_show']							= 'Pokazi';
$LNG['gl_pos']								= 'Poz';
$LNG['gl_planet']							= 'Planeta';
$LNG['gl_name_activity']					= 'Ime (Aktivnost)';
$LNG['gl_moon']							= 'Mjesec';
$LNG['gl_debris']							= 'RU';
$LNG['gl_player_estate']					= 'Igrac (Status)';
$LNG['gl_alliance']						= 'Savez';
$LNG['gl_actions']							= 'Akcija';
$LNG['gl_spy']								= 'spijuniraj';
$LNG['gl_buddy_request']					= 'Zahtjev za prijateljstvo';
$LNG['gl_missile_attack']					= 'Napadni raketama';
$LNG['gl_with']							= ' sa ';
$LNG['gl_member']							= '%d clanovi';
$LNG['gl_member_add']						= '%d clan';
$LNG['gl_alliance_page']					= 'Stranica saveza';
$LNG['gl_see_on_stats']					= 'Statistika';
$LNG['gl_alliance_web_page']				= 'Web saveza';
$LNG['gl_debris_field']					= 'Rusevina';
$LNG['gl_collect']							= 'Sakupiti';
$LNG['gl_resources']						= 'Resursi';
$LNG['gl_features']						= 'Mogucnosti';
$LNG['gl_diameter']						= 'Promjer';
$LNG['gl_temperature']						= 'Temperatura';
$LNG['gl_phalanx']							= 'Falanga';
$LNG['gl_planet_destroyed']				= 'Unistena planeta';
$LNG['gl_playercard']						= 'Igrac INFO';
$LNG['gl_in_the_rank']						= 'Igrac %s Poredak je %d';
$LNG['gl_activity']                                            = '(*)';
$LNG['gl_activity_inactive']                                   = '(%d min)';
$LNG['gl_ajax_status_ok']                    = 'U redu';
$LNG['gl_ajax_status_fail']                = 'Greska';

//----------------------------------------------------------------------------//
//PHALANX
$LNG['px_no_deuterium']					= 'Nemas dovoljno deuterija!';
$LNG['px_scan_position']					= 'Pozicija skeniranja';
$LNG['px_fleet_movement']					= 'Trenutna flota u pokretu';
$LNG['px_no_fleet']						= 'Nema flote u pokretu.';

//----------------------------------------------------------------------------//
//EMPIRE
$LNG['iv_imperium_title']					= 'Pregled Carstva';
$LNG['iv_planet']							= 'Planeta';
$LNG['iv_name']							= 'Ime';
$LNG['iv_coords']							= 'Kordinate';
$LNG['iv_fields']							= 'Polja';
$LNG['iv_resources']						= 'Resursi';
$LNG['iv_buildings']						= 'Zgrade';
$LNG['iv_technology']						= 'Istrazivanja';
$LNG['iv_ships']							= 'Flota';
$LNG['iv_defenses']						= 'Obrana';

//----------------------------------------------------------------------------//
//FLEET - FLEET1 - FLEET2 - FLEET3 - FLEETACS - FLEETSHORTCUTS
$LNG['fl_returning']						= 'Flota sa planete';
$LNG['fl_onway']							= 'Flota prema planeti';
$LNG['fl_r']								= '(R)';
$LNG['fl_a']								= '(A)';
$LNG['fl_send_back']						= 'Nazad';
$LNG['fl_acs']								= 'AKS';
$LNG['fl_no_more_slots']					= 'Svi slotovi se koriste';
$LNG['fl_speed_title']						= 'Brzina: ';
$LNG['fl_continue']						= 'nastavi';
$LNG['fl_no_ships']						= 'Nema dostupnih brodova';
$LNG['fl_remove_all_ships']				= 'Nema brodova';
$LNG['fl_select_all_ships']				= 'Svi brodovi';
$LNG['fl_fleets']							= 'Flota';
$LNG['fl_expeditions']						= 'Ekspedicija';
$LNG['fl_number']							= 'ID';
$LNG['fl_mission']							= 'Misija';
$LNG['fl_ammount']							= 'Brodovi (ukupno)';
$LNG['fl_beginning']						= 'Start';
$LNG['fl_departure']						= 'Dolazak (meta)';
$LNG['fl_destiny']							= 'Destinacija';
$LNG['fl_objective']						= 'Cilj';
$LNG['fl_arrival']							= 'Dolazak (Nazad)';
$LNG['fl_info_detail']						= 'Detalji flote';
$LNG['fl_order']							= 'Zapovjed';
$LNG['fl_new_mission_title']				= 'Nova zapovjed:Odaberi flotu';
$LNG['fl_ship_type']						= 'Vrsta broda';
$LNG['fl_ship_available']					= 'Dostupno';
$LNG['fl_planet']							= 'Planeta';
$LNG['fl_debris']							= 'Rusevina';
$LNG['fl_moon']							= 'Mjesec';
$LNG['fl_planet_shortcut']					= '(P)';
$LNG['fl_debris_shortcut']					= '(R)';
$LNG['fl_moon_shortcut']					= '(M)';
$LNG['fl_no_shortcuts']					= 'Nema dostupnih precaca';
$LNG['fl_anonymous']						= 'Anoniman';
$LNG['fl_shortcut_add_title']				= 'Ime [Galaksija/Sistem/Planeta]';
$LNG['fl_shortcut_name']					= 'Ime';
$LNG['fl_shortcut_galaxy']					= 'Galaksija';
$LNG['fl_shortcut_solar_system']			= 'Sistem';
$LNG['fl_clean']							= 'Resetiraj';
$LNG['fl_register_shorcut']				= 'Kreiraj';
$LNG['fl_shortcuts']						= 'Precac';
$LNG['fl_reset_shortcut']					= 'Resetiraj';
$LNG['fl_dlte_shortcut']					= 'Izbrisi';
$LNG['fl_back']							= 'Nazad';
$LNG['fl_shortcut_add']					= 'Dodaj';
$LNG['fl_shortcut_edition']				= 'Uredi: ';
$LNG['fl_no_colony']						= 'Nema prisutne kolonije';
$LNG['fl_send_fleet']						= 'Posalji flotu';
$LNG['fl_fleet_speed']						= 'Brzina';
$LNG['fl_distance']						= 'Razdaljina';
$LNG['fl_flying_time']						= 'Trajanje (u jednom smjeru)';
$LNG['fl_fuel_consumption']				= 'Potrosnja goriva';
$LNG['fl_max_speed']						= 'Maksimalna brzina';
$LNG['fl_cargo_capacity']					= 'Kapacitet za teret';
$LNG['fl_shortcut']						= 'Precac';
$LNG['fl_shortcut_add_edit']				= '(Kreiraj / Izmjeni)';
$LNG['fl_my_planets']						= 'Moje Planete';
$LNG['fl_acs_title']						= 'Grupni Napad';
$LNG['fl_hold_time']						= 'Duljina parkiranja';
$LNG['fl_resources']						= 'Resursi';
$LNG['fl_max']								= 'max';
$LNG['fl_hours']							= 'Sat(i)';
$LNG['fl_resources_left']					= 'Ostatak';
$LNG['fl_all_resources']					= 'Max opterecenje sa resursima';
$LNG['fl_empty_target']					= 'Nema dostupnih misija (planeta postoji?)';
$LNG['fl_expedition_alert_message']		= 'UPOZORENJE! Ekspedicije su opasne misije, mozete izgubiti svoje brodove!';
$LNG['fl_dm_alert_message']				= 'Budite oprezni, ako ju %s %s pronade, flota je unistena!';
$LNG['fl_vacation_mode_active']			= 'Vi ste na odmoru';
$LNG['fl_expedition_tech_required']		= 'Potrebna tehnologija Astrofizika!';
$LNG['fl_expedition_fleets_limit']			= 'Dostupne flote za ekspediciju dosegle limit!';
$LNG['fl_week_player']						= 'Igrac je preslab!';
$LNG['fl_strong_player']					= 'Igrac je prejak!';
$LNG['fl_in_vacation_player']				= 'Igrac je modusu (Odmor)';
$LNG['fl_no_slots']						= 'Nema dostupnih slotova!';
$LNG['fl_empty_transport']					= 'Nemozes transportirati 0 resursa!';
$LNG['fl_planet_populed']					= 'Ovaj planet je vec zauzet!';
$LNG['fl_stay_not_on_enemy']				= 'Nemozes parkirati flotu na neprijateljsku planetu!';
$LNG['fl_not_ally_deposit']				= 'Nema Depo Saveza';
$LNG['fl_deploy_only_your_planets']		= 'Stacionirati flotu mozes samo na svoje planete!';
$LNG['fl_no_enought_deuterium']			= 'Nemas dovoljno %s dostupnog. nedostaje ti %s %s!';
$LNG['fl_no_enought_cargo_capacity']		= 'Nemas dovoljno prostora za utovar tereta:';
$LNG['fl_admins_cannot_be_attacked']		= 'Nemozes napasti Administratora';
$LNG['fl_fleet_sended']					= 'Posalji flotu';
$LNG['fl_from']							= 'Sa';
$LNG['fl_arrival_time']					= 'Vrijeme dolaska';
$LNG['fl_return_time']						= 'Vrijeme povratka';
$LNG['fl_fleet']							= 'Flota';
$LNG['fl_player']							= 'Igrac ';
$LNG['fl_add_to_attack']					= ' je pozvan.';
$LNG['fl_dont_exist']						= ' ne postoji.';
$LNG['fl_acs_invitation_message']			= ' poziva te za sudjelovanje u AKS-u.';
$LNG['fl_acs_invitation_title']			= 'Poziv za AKS';
$LNG['fl_sac_of_fleet']					= 'AKS flota';
$LNG['fl_modify_sac_name']					= 'Promjena naziva za AKS';
$LNG['fl_members_invited']					= 'Pozvani sudionici';
$LNG['fl_invite_members']					= 'Pozovi sudionike';
$LNG['fl_bonus']							= 'Bonus';
$LNG['fl_bonus_attack']					= 'Napad';
$LNG['fl_bonus_defensive']					= 'Obrana';
$LNG['fl_bonus_shield']					= 'stit';

//----------------------------------------------------------------------------//
//BUILDINGS - RESEARCH - SHIPYARD - DEFENSES
$LNG['bd_dismantle']						= 'Dekonstruirati';
$LNG['bd_interrupt']						= 'Pauza';
$LNG['bd_cancel']							= 'otkazi';
$LNG['bd_working']							= 'U procesu';
$LNG['bd_build']							= 'Izgradi';
$LNG['bd_build_next_level']				= 'Nadogradi level ';
$LNG['bd_add_to_list']						= 'Dodaj u produkcijski red';
$LNG['bd_no_more_fields']					= 'Nema vise praznih polja na planeti za gradnju!';
$LNG['bd_remaining']						= 'Trebas jos ovoliko resursa za izgradnju:';
$LNG['bd_lab_required']					= 'Moras prvo izgraditi Centar za istrazivanje!';
$LNG['bd_building_lab']					= 'Ne mozes istraziti kada se laboratorij gradi!';
$LNG['bd_max_lvl']							= '(Max. Level: %s)';
$LNG['bd_lvl']								= 'Level';
$LNG['bd_research']						= 'Istrazivanja';
$LNG['bd_shipyard_required']				= 'Moras prvo izgraditi Brodogradiliste!';
$LNG['bd_building_shipyard']				= 'Nemozes nista staviti da se gradi,ako su u izgradnji Brodogradiliste,Tvornica robota ili Naniti!';
$LNG['bd_available']						= 'Dostupno: ';
$LNG['bd_build_ships']						= 'Izgradi';
$LNG['bd_protection_shield_only_one']		= 'Kupola se moze graditi samo jedna!';
$LNG['bd_build_defenses']					= 'Izgradi';
$LNG['bd_actual_production']				= 'Trenutna proizvodnja:';
$LNG['bd_completed']						= 'Zavrseno';
$LNG['bd_operating']						= 'U toku';
$LNG['bd_continue']						= 'Nastavi';
$LNG['bd_ready']							= 'Zavrsen';
$LNG['bd_finished']						= 'Zavrseno';
$LNG['bd_maxlevel']						= 'Dosegnut maksimalni level';
$LNG['bd_on']								= 'on';
$LNG['bd_max_builds']						= 'Mozes max. %d Posalji narudzbe!';
$LNG['bd_next_level']						= 'Sljedeci Level:';
$LNG['bd_need_engine']						= 'Potrositi  <font color="#FF0000">%s</font> %s vise';
$LNG['bd_more_engine']						= 'Izradeno <font color="#00FF00">%s</font> %s vise';
$LNG['bd_jump_gate_action']				= 'Skoci na';
$LNG['bd_cancel_warning']					= 'Tijekom rusenja, samo 60% sredstava bit ce vraceni!';
$LNG['bd_cancel_send']						= 'Izbrisi - Izabrane';

//----------------------------------------------------------------------------//
//RESOURCES
$LNG['rs_amount']							= 'Kolicina';
$LNG['rs_lvl']								= 'level';
$LNG['rs_production_on_planet']			= 'Proizvodnja resursa na planeti "%s"';
$LNG['rs_basic_income']					= 'Osnovni prihod';
$LNG['rs_storage_capacity']				= 'Kapacitet spremnika';
$LNG['rs_calculate']						= 'izracunaj';
$LNG['rs_sum']								= 'Ukupno:';
$LNG['rs_daily']							= 'Resursa dnevno:';
$LNG['rs_weekly']							= 'Resursa tjedno:';
$LNG['rs_ress_bonus']						= 'Bonus(Oficiri/CM-Bonus):';

//----------------------------------------------------------------------------//
//OFFICIERS
$LNG['of_recruit']							= 'Regrutiraj';
$LNG['of_max_lvl']							= 'Max. Level';
$LNG['of_available_points']				= 'Dostupni bodovi:';
$LNG['of_points_per_thousand_darkmatter']	= '(1 bod za %d %s)';
$LNG['of_lvl']								= 'Level';
$LNG['of_dm_trade']						= '%s - Zaliha';
$LNG['of_still']							= 'jos';
$LNG['of_active']							= 'aktivan';
$LNG['of_update']							= 'azuriraj';

//----------------------------------------------------------------------------//
//TRADER
$LNG['tr_empty_darkmatter']				= 'Nemas dovoljno %s!';
$LNG['tr_cost_dm_trader']					= 'Iznos naknade za trgovca %s %s!';
$LNG['tr_only_positive_numbers']			= 'Mozete koristiti samo pozitivne brojeve!';
$LNG['tr_not_enought_metal']				= 'Nemas dovoljno metala.';
$LNG['tr_not_enought_crystal']				= 'Nemas dovoljno kristala.';
$LNG['tr_not_enought_deuterium']			= 'Nemas dovoljno deuterija';
$LNG['tr_exchange_done']					= 'Zamjena uspjesna';
$LNG['tr_call_trader']						= 'Pozovi trgovca';
$LNG['tr_call_trader_who_buys']			= 'Pozovi trgovca koji kupuje ';
$LNG['tr_call_trader_submit']				= 'Pozovi';
$LNG['tr_exchange_quota']					= 'Tecaj 2/1/0.5';
$LNG['tr_sell_metal']						= 'Prihod od prodaje metala';
$LNG['tr_sell_crystal']					= 'Prihod od prodaje kristala';
$LNG['tr_sell_deuterium']					= 'Prihod od prodaje deuterija';
$LNG['tr_resource']						= 'Resursi';
$LNG['tr_amount']							= 'Kolicina';
$LNG['tr_quota_exchange']					= 'Tecajna lista';
$LNG['tr_exchange']						= 'Razmjeni';

//----------------------------------------------------------------------------//
//TECHTREE
$LNG['tt_requirements']					= 'Zahtjevi';
$LNG['tt_lvl']								= 'level ';

//----------------------------------------------------------------------------//
//INFOS
$LNG['in_jump_gate_done']					= 'Odskocna vrata su koristena,sljedeci skok je moguc za: ';
$LNG['in_jump_gate_error_data']			= 'Greska,podaci za skok nisu ispravni!';
$LNG['in_jump_gate_not_ready_target']		= 'Vrata nisu spremna,bit ce spremna u ';
$LNG['in_jump_gate_doesnt_have_one']		= 'Nemas odskocna vrata na mjesecu!';
$LNG['in_jump_gate_already_used']			= 'Odskocna vrata koristena,vrijeme da se ponovo napune: ';
$LNG['in_jump_gate_available']				= 'dostupno';
$LNG['in_rf_again']    					= 'Rapidfire protiv';
$LNG['in_rf_from']     					= 'Rapidfire od';
$LNG['in_level']       					= 'Level';
$LNG['in_prod_p_hour'] 					= 'proizvodnja/sat';
$LNG['in_difference']  					= 'Razlika';
$LNG['in_used_energy'] 					= 'Potrosnja energije';
$LNG['in_prod_energy'] 					= 'Produkcija energije';
$LNG['in_used_deuter']						= 'Potrosnja deuterija';
$LNG['in_range']       					= 'Domet senzorfalange';
$LNG['in_title_head']  					= 'Informacije o';
$LNG['in_name']        					= 'Ime';
$LNG['in_struct_pt']   					= 'Strukturalni Integritet';
$LNG['in_shield_pt']   					= 'Snaga stita';
$LNG['in_attack_pt']   					= 'Snaga napada';
$LNG['in_capacity']    					= 'Kapacitet tereta';
$LNG['in_units']       					= 'jedinica';
$LNG['in_base_speed'] 						= 'Osnovna brzina';
$LNG['in_consumption'] 					= 'Potrosnja (Deuterij)';
$LNG['in_jump_gate_start_moon']			= 'Pocetni mjesec';
$LNG['in_jump_gate_finish_moon']			= 'Ciljni mjesec';
$LNG['in_jump_gate_select_ships']			= 'Koristi odskocna vrata: broj brodova';
$LNG['in_jump_gate_jump']					= 'Skoci';
$LNG['in_destroy']     					= 'Unisti:';
$LNG['in_needed']      					= 'Zahtjeva';
$LNG['in_dest_durati'] 					= 'Vrijeme unistavanja';

//----------------------------------------------------------------------------//
//MESSAGES

$LNG['mg_type'][0]    						= 'Izvjestaj spijunaze';
$LNG['mg_type'][1]    						= 'Poruke od igraca';
$LNG['mg_type'][2]   						= 'Poruke od saveza';
$LNG['mg_type'][3]    						= 'Izvjestaj borbe';
$LNG['mg_type'][4]    						= 'Sistemske poruke';
$LNG['mg_type'][5]    						= 'Izvjestaj transporta';
$LNG['mg_type'][15]   						= 'Izvjestaj ekspedicije';
$LNG['mg_type'][50]						= 'Poruka od igre';
$LNG['mg_type'][99]   						= 'Izvjestaj gradnje';
$LNG['mg_type'][100]						= 'Vidi sve poruke';
$LNG['mg_type'][999]						= 'Izlazne';
$LNG['mg_no_subject']						= 'Bez naslova';
$LNG['mg_no_text']							= 'Nema teksta';
$LNG['mg_msg_sended']						= 'Poruka poslana!';
$LNG['mg_delete_marked']					= 'Obrisi oznacene poruke';
$LNG['mg_delete_type_all']					= 'Obrisi sve poruke ove vrste';
$LNG['mg_delete_unmarked']					= 'Obrisi sve neoznacene poruke';
$LNG['mg_delete_all']						= 'Obrisi sve poruke';
$LNG['mg_show_only_header_spy_reports']	= 'prikazi samo djelomicna izvjesca spijunaze';
$LNG['mg_action']							= 'Akcija';
$LNG['mg_date']							= 'Datum';
$LNG['mg_from']							= 'od';
$LNG['mg_to']								= 'za';
$LNG['mg_subject']							= 'naslov';
$LNG['mg_confirm_delete']					= 'Potvrdi';
$LNG['mg_message_title']					= 'Poruka';
$LNG['mg_message_type']					= 'Vrsta poruke';
$LNG['mg_total']							= 'Ukupno';
$LNG['mg_game_operators']					= 'Operatori igre';
$LNG['mg_error']							= 'Primatelj nije pronaden!';
$LNG['mg_overview']						= 'Novosti Administratora';
$LNG['mg_send_new']						= 'Pisi poruku';
$LNG['mg_send_to']							= 'Primatelj';
$LNG['mg_message']							= 'Poruka';
$LNG['mg_characters']						= 'Znakovi';
$LNG['mg_send']							= 'Posalji';
$LNG['mg_game_message']					= 'Poruka od igre';

//----------------------------------------------------------------------------//
//ALLIANCE

$LNG['al_newname_alphanum']				= 'Ime saveza mora se sastojati samo od alfanumerickih znakove.';
$LNG['al_newname_no_space']				= 'Ime saveza nesmije sadrzavati razmak.';
$LNG['al_description_message'] 			= 'Opis saveza';
$LNG['al_web_text']						= 'Web saveza';
$LNG['al_request'] 						= 'Zahtjev';
$LNG['al_click_to_send_request'] 			= 'Kliknite ovdje da posaljete zahtjev za savez';
$LNG['al_tag_required'] 					= 'Nedostaje TAG saveza.';
$LNG['al_name_required'] 					= 'Nedostaje ime saveza.';
$LNG['al_already_exists'] 					= 'Savez %s vec postoji.';
$LNG['al_created'] 						= 'Savez %s kreiran!';
$LNG['al_continue'] 						= 'nastavi';
$LNG['al_alliance_closed'] 				= 'Ovaj savez ne prihvaca nove clanove.';
$LNG['al_request_confirmation_message']	= 'Zahtjev registriran.Primit cete poruku kada je Vasa prijava odobrena / odbijena. <br><a href="?page=alliance">nazad</a>';
$LNG['al_default_request_text']			= 'celnici saveza nisu postavili primjer aplikacije, odnosno nemaju pretenzije.';
$LNG['al_write_request'] 					= 'Napisite zahtjev za savez %s';
$LNG['al_request_deleted'] 				= 'Izbrisali ste zahtjev. <br> onda mozete stvoriti svoj vlastiti ili se pridruziti u drugi.';
$LNG['al_request_wait_message'] 			= 'Vec ste poslali zahtjev za savez %s <br>';
$LNG['al_delete_request'] 					= 'Izbrisi zahtjev';
$LNG['al_founder_cant_leave_alliance'] 	= 'Osnivac ne moze napustiti savez.';
$LNG['al_leave_sucess'] 					= 'Napustiti savez %s uspjesno.';
$LNG['al_do_you_really_want_to_go_out'] 	= 'zelite li zaista napustiti savez %s ?';
$LNG['al_go_out_yes'] 						= 'Da';
$LNG['al_go_out_no'] 						= 'Ne';
$LNG['al_close_ally'] 						= 'zelite stvarno raspustiti savez?';
$LNG['al_kick_player']						= 'zelite li zaista igraca %s izbaciti iz saveza?';
$LNG['al_circular_sended'] 				= "Posalji kruznu poruku,Slijedeci igraci ce dobiti kruznu poruku:";
$LNG['al_all_players'] 					= 'Svi igraci';
$LNG['al_no_ranks_defined'] 				= 'Nema definiranig rangova.'; 
$LNG['al_request_text']					= 'Tekst za zahtjev';
$LNG['al_inside_text']						= 'Unutarnji tekst';
$LNG['al_outside_text']					= 'Vanjski tekst';
$LNG['al_transfer_alliance']				= 'Prenesi savez';
$LNG['al_disolve_alliance']				= 'Raspustiti savez';
$LNG['al_founder_rank_text']				= 'Osnivac';
$LNG['al_new_member_rank_text']			= 'Novi clan';
$LNG['al_acept_request']					= 'Prihvati';
$LNG['al_you_was_acceted']					= 'Vi ste prihvaceni u ';
$LNG['al_hi_the_alliance']					= 'Bok!<br>savez <b>';
$LNG['al_has_accepted']					= '</b> je prihvatio vas zahtjev.<br>Poruka osnivaca: <br>';
$LNG['al_decline_request']					= 'Odbij';
$LNG['al_you_was_declined']				= 'Vi ste odbijeni ';
$LNG['al_has_declined']					= '</b> je odbio vas zahtjev!<br>Poruka osnivaca: <br>';
$LNG['al_no_requests']						= 'Nema zahtjeva';
$LNG['al_request_from']					= 'Zahtjev od "%s"';
$LNG['al_no_request_pending']				= 'Ima %d zahtjev (a)';
$LNG['al_name']							= 'ime';
$LNG['al_new_name']						= 'Novo ime (3-30 Znakova):';
$LNG['al_tag']								= 'tag';
$LNG['al_new_tag']							= 'Novi tag (3-8 Znakova):';
$LNG['al_user_list']						= 'Lista clanova';
$LNG['al_users_list']						= 'lista clanova (igraci: %d)';
$LNG['al_manage_alliance']					= 'upravljanje savezom';
$LNG['al_send_circular_message']			= 'posalji kruznu poruku';
$LNG['al_new_requests']					= '%d novo zahtjev/i';
$LNG['al_save']							= 'Spremi';
$LNG['al_dlte']							= 'Izbrisi';
$LNG['al_rank_name']						= 'Rank';
$LNG['al_ok']								= 'OK';
$LNG['al_num']								= 'ID';
$LNG['al_member']							= 'Ime';
$LNG['al_request_from_user']				= 'Zahtjev igraca';
$LNG['al_message']							= 'Poruka';
$LNG['al_position']						= 'Pozicija';
$LNG['al_points']							= 'Bodovi';
$LNG['al_coords']							= 'Kordinate';
$LNG['al_member_since']					= 'Pridruzen';
$LNG['al_estate']							= 'Online';
$LNG['al_back']							= 'Nazad';
$LNG['al_actions']							= 'Akcija';
$LNG['al_change_title']					= 'Promjeni';
$LNG['al_the_alliance']					= 'od saveza';
$LNG['al_change_submit']					= 'Promjeni';
$LNG['al_reply_to_request']				= 'Odgovori na zahtjev';
$LNG['al_reason']							= 'Razlog';
$LNG['al_characters']						= 'znakovi';
$LNG['al_request_list']					= 'Lista zahtjeva';
$LNG['al_candidate']						= 'Ime';
$LNG['al_request_date']					= 'Datum';
$LNG['al_transfer_alliance']				= 'Podnijeti ostavku / preuzeti ovaj savez?';
$LNG['al_transfer_to']						= 'Prijenos na';
$LNG['al_transfer_submit']					= 'Potvrdi';
$LNG['al_ally_information']				= 'Informacije saveza';
$LNG['al_ally_info_tag']					= 'Tag';
$LNG['al_ally_info_name']					= 'Ime';
$LNG['al_ally_info_members']				= 'clanovi';
$LNG['al_your_request_title']				= 'Tvoj zahtjev';
$LNG['al_applyform_send']					= 'Posalji';
$LNG['al_applyform_reload']				= 'Povrati';
$LNG['al_circular_send_ciruclar']			= 'Posalji kruznu poruku';
$LNG['al_circular_alliance']               = 'Savez ';
$LNG['al_receiver']						= 'Primatelj';
$LNG['al_circular_send_submit']			= 'Posalji';
$LNG['al_circular_reset']					= 'Resetiraj';
$LNG['al_alliance']						= 'Savez ';
$LNG['al_alliance_make']					= 'Napravi svoj savez';
$LNG['al_alliance_search']					= 'Trazi savez';
$LNG['al_your_ally']						= 'Tvoj savez';
$LNG['al_rank']							= 'Rank';
$LNG['al_web_site']						= 'Web saveza';
$LNG['al_inside_section']					= 'Unutarnji prostor';
$LNG['al_make_alliance']					= 'Napravi savez';
$LNG['al_make_ally_tag_required']			= 'TAG saveza (3-8 znakova)';
$LNG['al_make_ally_name_required']			= 'Ime saveza (3-30 znakova)';
$LNG['al_make_submit']						= 'napravi';
$LNG['al_find_alliances']					= 'Trazi savez';
$LNG['al_find_text']						= 'Trazi';
$LNG['al_find_no_alliances']				= 'Nema pronadenog saveza!';
$LNG['al_find_submit']						= 'Trazi';
$LNG['al_manage_ranks']					= 'Upravljanje rangovima';
$LNG['al_manage_members']					= 'Upravljanje clanovima';
$LNG['al_manage_change_tag']				= 'Promjeni tag saveza';
$LNG['al_manage_change_name']				= 'Promjeni ime saveza';
$LNG['al_texts']							= 'Tekst za upravljanje';
$LNG['al_manage_options']					= 'Postavke';
$LNG['al_manage_image']					= 'Logo saveza';
$LNG['al_manage_requests']					= 'Zahtjevi';
$LNG['al_manage_diplo']                    = 'Savez Diplomacija';
$LNG['al_requests_not_allowed']			= 'savez zatvoren';
$LNG['al_requests_allowed']				= 'savez otvoren';
$LNG['al_manage_founder_rank']				= 'Osnivacev rank';
$LNG['al_configura_ranks']					= 'Konfiguracija prava';
$LNG['al_create_new_rank']					= 'Kreiraj novi rank';
$LNG['al_rank_name']						= 'Ime';
$LNG['al_create']							= 'Kreiraj';
$LNG['al_legend']							= 'Opis prava';
$LNG['al_legend_disolve_alliance']			= 'Raspustiti savez';
$LNG['al_legend_kick_users']				= 'Izbaci clana';
$LNG['al_legend_see_requests']				= 'Vidjeti zahtjeve';
$LNG['al_legend_see_users_list']			= 'Vidjeti listu clanova';
$LNG['al_legend_check_requests']			= 'Pregledati zahtjeve';
$LNG['al_legend_admin_alliance']			= 'Upravljanje savezom';
$LNG['al_legend_see_connected_users']		= 'Vidjeti tko je online';
$LNG['al_legend_create_circular']			= 'Pisati kruznu poruku';
$LNG['al_legend_right_hand']				= 'Desna ruka (potreban za prijenos na osnivaca)';
$LNG['al_requests']						= 'Zahtjev';
$LNG['al_circular_message']				= 'Kruzna poruka';
$LNG['al_leave_alliance']					= 'Napusti savez';
$LNG['al_Gesamtk']     					= 'Borba';
$LNG['al_Erfolg']       					= 'Uspjesnost borbi';
$LNG['al_Siege']        					= 'Pobjeda';
$LNG['al_Drawp']        					= 'Nerjeseno';
$LNG['al_Loosi']        					= 'Izgubljeno';
$LNG['al_KGesamt']      					= 'Ukupno borbi';
$LNG['al_Allyquote']    					= 'Evidencija borbe';
$LNG['al_Quote']        					= 'Citat od pobjede';
$LNG['al_unitsshut']    					= 'Jedinica unisteno';
$LNG['al_unitsloos']    					= 'Jedinica izgubljeno';
$LNG['al_tfmetall']     					= 'Ukupno metala u rusevine';
$LNG['al_tfkristall']   					= 'Ukupno kristala u rusevine';
$LNG['al_view_stats']						= 'Rekord borbe dostupan javno?';
$LNG['al_view_diplo']                      = 'Javna diplomacija?';
$LNG['al_memberlist_min']					= 'min';
$LNG['al_memberlist_on']					= 'Online';
$LNG['al_memberlist_off']					= 'Offline';
$LNG['al_diplo']                            = 'Diplomacija';
$LNG['al_diplo_level'][0]                    = 'Wing';
$LNG['al_diplo_level'][1]                    = 'Savez ';
$LNG['al_diplo_level'][2]                    = 'Savez za trgovanje';
$LNG['al_diplo_level'][3]                    = 'Ugovor o nenapadanju';
$LNG['al_diplo_level'][4]                    = 'Rat';
$LNG['al_diplo_no_entry']                    = '- Ne postoji ugovor -';
$LNG['al_diplo_no_accept']                    = '- Ne postoji zahtjev -';
$LNG['al_diplo_accept']                    = 'Dolazni zahtjevi';
$LNG['al_diplo_accept_send']                = 'Odlazni zahtjevi';
$LNG['al_diplo_create']                    = 'Kreiraj novi ugovor.';
$LNG['al_diplo_create_done']                = 'Ugovor uspjesno kreiran.';
$LNG['al_diplo_ally']                        = 'Savez ';
$LNG['al_diplo_level_des']                    = 'Vrsta ugovora';
$LNG['al_diplo_text']                        = 'Tekst';
$LNG['al_diplo_accept_yes']                = 'Prijavite ugovor.';
$LNG['al_diplo_accept_yes_mes']            = 'Ugovor o %s je potpisan izmedu saveza %s i %s!';
$LNG['al_diplo_accept_no']                    = 'Ugovor odbijen.';
$LNG['al_diplo_accept_no_mes']                = 'Ugovor o %s izmedu saveza %s  %s je odbijen!';
$LNG['al_diplo_delete']                    = 'Ukinuti ugovor.';
$LNG['al_diplo_delete_mes']                = 'Ugovor o %s izmedu saveza %s i %s  je prekinut!';
$LNG['al_diplo_confirm_delete']            = 'zelis li stvarno izbrisati ovaj ugovor?';
$LNG['al_diplo_ground']                    = 'Razlog:';
$LNG['al_diplo_ask']                        = 'Ugovor';
$LNG['al_diplo_ask_mes']                    = 'Zahtjev za ugovorom (%s) za savez -> %s <- i -> %s <-. <br>Razlog: %s ';
$LNG['al_diplo_war']                        = 'Rat';
$LNG['al_diplo_war_mes']                    = 'Savez  -> %s <- i -> %s <-.<br>Razlog: %s <br><br>Informacije: celnici oba saveza trebaju se dogovoriti o ratu, otvoriti temu o ratu na forumu.Tek nakon sto su se celnici dogovorili,pravilo bashinga se eliminira izmedu dva saveza u ratu.';
$LNG['al_leave_ally']					= 'Stvarno zelis napustiti savez?';

//----------------------------------------------------------------------------//
//BUDDY
$LNG['bu_request_exists']					= 'Postoji zahtjev!';
$LNG['bu_cannot_request_yourself']			= 'Nemozes sam sebi poslati zahtjev';
$LNG['bu_request_message']					= 'Poruka';
$LNG['bu_player']							= 'Igrac';
$LNG['bu_request_text']					= 'Tekst';
$LNG['bu_characters']						= 'znakovi';
$LNG['bu_back']							= 'Nazad';
$LNG['bu_send']							= 'Posalji';
$LNG['bu_cancel_request']					= 'Ponisti zahtjev';
$LNG['bu_accept']							= 'Prihvati';
$LNG['bu_decline']							= 'Odbaci';
$LNG['bu_connected']						= 'Spojen';
$LNG['bu_minutes']							= ' min';
$LNG['bu_disconnected']					= 'Offline';
$LNG['bu_online']							= 'Online';
$LNG['bu_buddy_list']						= 'Lista prijatelja';
$LNG['bu_requests']						= 'Zahtjevi';
$LNG['bu_alliance']						= 'Savez';
$LNG['bu_coords']							= 'Kordinate';
$LNG['bu_text']							= 'Tekst';
$LNG['bu_action']							= 'Akcija';
$LNG['bu_my_requests']						= 'Moj zahtjev';
$LNG['bu_partners']						= 'Prijatelji';
$LNG['bu_delete']							= 'obrisi';
$LNG['bu_no_request']						= 'nema zahtjeva!';
$LNG['bu_no_buddys']						= 'nema prijatelja!';
$LNG['bu_request_send']					= 'Zahtjev poslan!';

//----------------------------------------------------------------------------//
//NOTES
$LNG['nt_important']						= 'Vazno';
$LNG['nt_normal']							= 'Normalno';
$LNG['nt_unimportant']						= 'Nevazno';
$LNG['nt_create_note']						= 'Stvori zapis';
$LNG['nt_you_dont_have_notes']				= 'Nema dostupnih zapisa';
$LNG['nt_notes']							= 'Zapis';
$LNG['nt_create_new_note']					= 'Stvori novi zapis';
$LNG['nt_edit_note']						= 'Uredi zapis';
$LNG['nt_date_note']						= 'Datum';
$LNG['nt_subject_note']					= 'Naslov';
$LNG['nt_size_note']						= 'Velicina';
$LNG['nt_dlte_note']						= 'Obrisi';
$LNG['nt_priority']						= 'Prioritet';
$LNG['nt_note']							= 'Obavijest';
$LNG['nt_characters']						= 'znakovi';
$LNG['nt_back']							= 'Nazad';
$LNG['nt_reset']							= 'Resetiraj';
$LNG['nt_save']							= 'Spremi';
$LNG['nt_no_title']						= 'Bez naslova';
$LNG['nt_no_text']							= 'Bez teksta';

//----------------------------------------------------------------------------//
//STATISTICS
$LNG['st_player']							= 'Igrac';
$LNG['st_alliance']						= 'Savez';
$LNG['st_points']							= 'Bodovi';
$LNG['st_fleets']							= 'Flota';
$LNG['st_researh']							= 'Istrazivanja';
$LNG['st_buildings']						= 'Zgrade';
$LNG['st_defenses']						= 'Obrana';
$LNG['st_position']						= 'Rang';
$LNG['st_members']							= 'clanova';
$LNG['st_per_member']						= 'Po clanu';
$LNG['st_statistics']						= 'Statistika';
$LNG['st_updated']							= 'Azuriranje';
$LNG['st_show']							= 'pokazi';
$LNG['st_per']								= 'po';
$LNG['st_in_the_positions']				= 'u rangu';

$LNG['st_write_message']					= 'Privatna poruka';

//----------------------------------------------------------------------------//
//SEARCH
$LNG['sh_tag']								= 'Tag';
$LNG['sh_name']							= 'Ime';
$LNG['sh_members']							= 'clan';
$LNG['sh_points']							= 'Bodovi';
$LNG['sh_searcg_in_the_universe']			= 'Pretrazi';
$LNG['sh_player_name']						= 'Ime igraca';
$LNG['sh_planet_name']						= 'Ime planete';
$LNG['sh_alliance_tag']					= 'Tag saveza';
$LNG['sh_alliance_name']					= 'Ime saveza';
$LNG['sh_search']							= 'trazi';
$LNG['sh_write_message']					= 'Privatna poruka';
$LNG['sh_buddy_request']					= 'Zahtjev za prijateljstvo';
$LNG['sh_alliance']						= 'Savez';
$LNG['sh_planet']							= 'Planeta';
$LNG['sh_coords']							= 'Pozicija';
$LNG['sh_position']						= 'Rang';


//----------------------------------------------------------------------------//
//OPTIONS
$LNG['op_cant_activate_vacation_mode']		= 'Ako se nesto gradi ili je flota u pokretu nemozes otici u mod za odmor.';
$LNG['op_password_changed']				= 'Lozinka je promjenjena<br><a href="index.php" target="_top">Nazad</a>';
$LNG['op_username_changed']				= 'Korisnicko ime promjenjeno<br><a href="index.php" target="_top">Nazad</a>';
$LNG['op_options_changed']					= 'Spremi promjene.<br><a href="game.php?page=options">Nazad</a>';
$LNG['op_vacation_mode_active_message']	= 'Mod za odmor je ukljucen. Moras biti na odmoru barem do: ';
$LNG['op_end_vacation_mode']				= 'Zavrsi odmor mode';
$LNG['op_save_changes']					= 'spremi promjene';
$LNG['op_admin_title_options']				= 'Opcije dostupne za upravljanje';
$LNG['op_admin_planets_protection']		= 'Zastita planete';
$LNG['op_user_data']						= 'Korisnicki podaci';
$LNG['op_username']						= 'Korisnicko ime';
$LNG['op_old_pass']						= 'Stara lozinka';
$LNG['op_new_pass']						= 'Nova lozinka (min. 8 znakova)';
$LNG['op_repeat_new_pass']					= 'Nova lozinka (ponovi)';
$LNG['op_email_adress']					= 'Email adresa';
$LNG['op_permanent_email_adress']			= 'Stalna Adresa';
$LNG['op_general_settings']				= 'Generalne Postavke';
$LNG['op_sort_planets_by']					= 'Sortiraj planete po:';
$LNG['op_sort_kind']						= 'Slijed:';
$LNG['op_skin_example']					= 'Skin (z.B. C:/2moons/skins/)';
$LNG['op_show_skin']						= 'Pokazi skin';
$LNG['op_deactivate_ipcheck']				= 'Onemoguci IP Check';
$LNG['op_galaxy_settings']					= 'Postavke za Galaksiju';
$LNG['op_spy_probes_number']				= 'Broj sondi za spijunazu';
$LNG['op_toolt_data']						= 'Informacije alata';
$LNG['op_seconds']							= 'sekunde';
$LNG['op_max_fleets_messages']				= 'Maksimalni broj poruka flote';
$LNG['op_show_planetmenu']					= 'Izbornik planeta';
$LNG['op_shortcut']						= 'Precac';
$LNG['op_show']							= 'Pokazi';
$LNG['op_spy']								= 'spijuniraj';
$LNG['op_write_message']					= 'Pisi poruku';
$LNG['op_add_to_buddy_list']				= 'Dodaj u prijatelje';
$LNG['op_missile_attack']					= 'Napad raketama';
$LNG['op_send_report']						= 'Posalji obavijest';
$LNG['op_vacation_delete_mode']			= 'Mod za odmor / Izbrisi racun';
$LNG['op_activate_vacation_mode']			= 'Ukljuci odmor';
$LNG['op_dlte_account']					= 'Izbrisi racun';
$LNG['op_email_adress_descrip']			= 'Mozes promjeniti E-mail adresu bilo kada,zadnje unesena nakon 7 dana postaje stalna.';
$LNG['op_deactivate_ipcheck_descrip']		= 'IP check znaci da se javlja sigurnosna odjava automatski kada se IP adresa promjeni ili dvije osobe koje su prijavljene na racun iz razlicitih IP adresa. Onemogucavanje IP check moze predstavljati sigurnosni rizik!';
$LNG['op_spy_probes_number_descrip']		= 'Broj spijunskih sondi koje se mogu poslati poslati izravno iz galaksije.';
$LNG['op_activate_vacation_mode_descrip']	= 'Odmor ce vas zastititi tijekom dugih izostanaka. To se moze aktivirati, ako se nista ne gradi (flota, zgrada, ili obrane), nista se neistrazuje, a nijedna od vase flote nije u letu. Nakon sto je aktiviran,zasticeni ste od napada. Napadi koji su vec poceli ce se provesti do kraja. Za vrijeme odmora, proizvodnja je postavljen na nulu i mora se rucno vratiti na 100% nakon odmora.Odmor traje najmanje 24 sata i moze se deaktivirati nakon tog vremena.';
$LNG['op_dlte_account_descrip']			= 'Ako oznacite ovu kucicu, vas racun ce biti automatski izbrisani nakon 7 dana.';
$LNG['op_sort_normal']						= 'Redoslijed stvaranja';
$LNG['op_sort_koords']						= 'Kordinate';
$LNG['op_sort_abc']						= 'Abeceda';
$LNG['op_sort_up']							= 'Uzlazni';
$LNG['op_sort_down']						= 'Silazni';
$LNG['op_user_name_no_alphanumeric']		= 'Molimo unesite korisnicko ime samo sa alfanumerickim znakovima!';
$LNG['op_change_name_pro_week']			= 'Mozete promijeniti svoje korisnicko ime samo 1x tjedno';
$LNG['op_change_name_exist']				= 'Ime %s vec postoji';
$LNG['op_active_build_messages']			= 'Novosti redoslijeda gradnje';
$LNG['op_small_storage']                    = 'Skratite prikaz brojeva od skladista';

//----------------------------------------------------------------------------//
//BANNED
$LNG['bn_no_players_banned']				= 'Nema kaznjenih igraca';
$LNG['bn_exists']							= 'Postojeci ';
$LNG['bn_players_banned']					= ' igrac/i kaznjen/i';
$LNG['bn_players_banned_list']				= 'Lista kaznjenih igraca';
$LNG['bn_player']							= 'Igrac';
$LNG['bn_reason']							= 'Razlog';
$LNG['bn_from']							= 'Od';
$LNG['bn_until']							= 'Do';
$LNG['bn_by']								= 'Kaznio';
$LNG['bn_writemail']						= 'Posalji mail %s';

//----------------------------------------------------------------------------//
//SYSTEM
$LNG['sys_attacker_lostunits'] 			= "Napadac je izgubio ukupno";
$LNG['sys_defender_lostunits'] 			= "Branitelj je izgubio ukupno";
$LNG['sys_units']							= "jedinica";
$LNG['debree_field_1'] 					= "U rusevini";
$LNG['debree_field_2']						= "pluta u orbiti planeta.";
$LNG['sys_moonproba'] 						= "Vjerojatnost za nastanak mjeseca je:";
$LNG['sys_moonbuilt'] 						= "Velike kolicine metala i kristala formiraju mjesec u orbiti planete %s [%d:%d:%d] !";
$LNG['sys_attack_title']    				= "Sukob flote ";
$LNG['sys_attack_round']					= "Runda";
$LNG['sys_attack_attacker_pos'] 			= "Napadac";
$LNG['sys_attack_techologies'] 			= 'Oruzje: %d %% stit: %d %% Oklop: %d %% ';
$LNG['sys_attack_defender_pos'] 			= "Branitelj";
$LNG['sys_ship_type'] 						= "Vrsta";
$LNG['sys_ship_count'] 					= "broj";
$LNG['sys_ship_weapon'] 					= "Oruzje";
$LNG['sys_ship_shield'] 					= "stit";
$LNG['sys_ship_armour'] 					= "Oklop";
$LNG['sys_destroyed'] 						= "Unisten";
$LNG['fleet_attack_1'] 					= "Napadacka flota puca ukupnom snagom od";
$LNG['fleet_attack_2']						= "na branitelja.Braniteljevi stitovi apsorbiraju";
$LNG['fleet_defs_1'] 						= "Braniteljeva flota puca ukupnom snagom od";
$LNG['fleet_defs_2']						= "na Napadaca.Napadacevi stitovi apsorbiraju";
$LNG['damage']								= "bodova stete.";
$LNG['sys_attacker_won'] 					= "Napadac je pobjedio u borbi";
$LNG['sys_defender_won'] 					= "Branitelj je pobjedio u borbi";
$LNG['sys_both_won'] 						= "Borba je zavrsila nerjeseno";
$LNG['sys_stealed_ressources'] 			= "opljackano";
$LNG['sys_and']							= "i";
$LNG['sys_mess_tower'] 					= "Kontrolni toranj";
$LNG['sys_mess_attack_report'] 			= "Izvjesce borbe";
$LNG['sys_spy_maretials'] 					= "Resursi";
$LNG['sys_spy_fleet'] 						= "Flota";
$LNG['sys_spy_defenses'] 					= "obrana";
$LNG['sys_mess_qg'] 						= "Glavno sjediste";
$LNG['sys_mess_spy_report_moon']			= "(Mjesec)";
$LNG['sys_mess_spy_report'] 				= "Izvjesce spijunaze";
$LNG['sys_mess_spy_lostproba'] 			= "Vjerojatnost otkrivanja sijunaze : %d %% ";
$LNG['sys_mess_spy_control'] 				= "Kontrola svemira";
$LNG['sys_mess_spy_activity'] 				= "Aktivnost spijunaze";
$LNG['sys_mess_spy_ennemyfleet'] 			= "Neprijateljska flote sa druge planete";
$LNG['sys_mess_spy_seen_at'] 				= "je videna u blizini tvoje planete";
$LNG['sys_mess_spy_seen_at2'] 				= 'mogucnost da vidi';
$LNG['sys_mess_spy_destroyed'] 			= '<font color="red">Vase sonde za spijunazu su unistene!</font>';
$LNG['sys_mess_attack_report_mess']		= '<a href="javascript:kb(\'%s\');"><center><font color="%s">%s %s</font></a><br><br><font color="%s">%s: %s</font> <font color="%s">%s: %s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font> %s:<font color="#f77542">%s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font><br></center>';
$LNG['sys_adress_planet'] 					= '[%s:%s:%s]';
$LNG['sys_stay_mess_goods'] 				= '%s : %s, %s : %s, %s : %s';
$LNG['sys_stay_mess_back']					= 'Jedna od tvojih flota stize na planetu ';
$LNG['sys_stay_mess_bend']					= 'i dostavlja: ';
$LNG['sys_colo_mess_from'] 				= "Kolonizacija";
$LNG['sys_colo_mess_report'] 				= "Izvjestaj o kolonizaciji";
$LNG['sys_colo_defaultname'] 				= "Kolonija";
$LNG['sys_colo_arrival'] 					= "Naseljenici su stigli na kordinate ";
$LNG['sys_colo_maxcolo'] 					= ", ali, na zalost, ne mogu kolonizirati,popunio si maksimalni broj kolonija ";
$LNG['sys_colo_allisok'] 					= ", 	naseljenici pocinju graditi novu koloniju.";
$LNG['sys_colo_badpos']  					= ", 	naseljenici su pronasli okruzenje pogodno za sirenje tvoga carstva";
$LNG['sys_colo_notfree'] 					= ", 	naseljenici su pronasli planet na tim kordinatama. Oni su prisiljeni vratiti se natrag potpuno demoralizirani ...";
$LNG['sys_colo_planet']  					= " planeta ";
$LNG['sys_expe_report'] 					= "Izvjestaj ekspedicije";
$LNG['sys_recy_report'] 					= "Izvjestaj recikliranja";
$LNG['sys_expe_blackholl_1'] 				= "Flota je usisana u crnu rupu i djelomicno unistena.";
$LNG['sys_expe_blackholl_2'] 				= "Flota je usisana u crnu rupu i cjela je unistena!";
$LNG['sys_expe_found_goods'] 				= "Vasi znastvenici su pronasli bogati planet sa resursima !<br>To je %s %s, %s %s i %s %s resursa";
$LNG['sys_expe_found_ships'] 				= "Istrazivaci su otkrili neke svemirske brodove u savrsenom stanju!.<br>: ";
$LNG['sys_expe_back_home'] 				= "Vasa ekspedicija se vratila u hangar.";
$LNG['sys_expe_found_ress_1_1']			= 'Vasa ekspedicije je otkrila mali asteroid,od kojeg se mogu dobiti resursi.';
$LNG['sys_expe_found_ress_1_2']			= 'Na udaljenom planetoidu pronadeni resursi,uspjesno su izvadeni.';
$LNG['sys_expe_found_ress_1_3']			= 'Vasa flota je pronasla ostatke brodova iz prijasnjih borbi,nesto resursa je spaseno.';
$LNG['sys_expe_found_ress_1_4']			= 'Ekspedicija je dosla na radioaktivni i vrlo otrovni asteroid.Ipak je ovaj asteroid bogat resursima.Koristenjem automatskih busilica pokusat ce dobiti nesto sirovina.';
$LNG['sys_expe_found_ress_2_1']			= 'Vasa ekspedicija je otkrili drevni,u potpunosti opterecen,ali pusti teretnjak.Neki resursi mogu biti spaseni.';
$LNG['sys_expe_found_ress_2_2']			= 'Na malom mjesecu s atmosferom pronadena su velika lezista mineralnih sirovina.Posada se spustila da pokupe prirodna blaga.';
$LNG['sys_expe_found_ress_2_3']			= 'Susreli smo mali konvoj civilnih brodova,potrebno im je hitno hranu i lijekovi.U zamjenu smo dobili mnogo korisnih resursa.';
$LNG['sys_expe_found_ress_3_1']			= 'Vasa ekspedicija otkrila je olupinu broda.Sa tehnologijom nisu mogli nista uciniti,ali se brod mogao rastaviti na dijelove,iz kojih su izvukli vrijedne sirovine.';
$LNG['sys_expe_found_ress_3_2']			= 'U mineralnom pojasu oko nepoznatog planeta nalazi se ogromna kolicina sirovina.Ekspedicijska flota je puna tereta!';
$LNG['sys_expe_found_dm_1_1']				= 'Ekspedicija je uspjela uhvatiti malo tamne tvari.';
$LNG['sys_expe_found_dm_1_2']				= 'Nasa ekspedicija je naisla na brod koji prevozi male kolicine tamne tvari.Iako nemozemo pronaci nikakav dokaz o tome sto se dogodilo posadi,nasi tehnicari su uzeli nesto tamne tvari.';
$LNG['sys_expe_found_dm_1_3']				= 'Naisli smo na neobicnog stranca,kojem su trebali matematicki izracuni,zauzvrat dobivamo tamnu tvar.';
$LNG['sys_expe_found_dm_1_4']				= 'Pronasli smo ostatke vanzemaljskog broda.Na brodu je bio mali kontejner sa tamnom tvari!';
$LNG['sys_expe_found_dm_1_5']				= 'Ekspedicija slijedi neke cudne signale i otkrila je asteroid.Asteroid je donesen na brod,a istrazivaci sada pokusavaju izvuci tamnu tvar.';
$LNG['sys_expe_found_dm_2_1']				= 'Nasa ekspedicija je uspjela jedinstveni eksperiment. Prikupili su tamne materije od umiranja zvijezde.';
$LNG['sys_expe_found_dm_2_2']				= 'Nasa ekspedicija naletila je puno cudnih pojava.To je dovelo da izmedu ostalog,brodski stitovi formiraju tamnu tvar.';
$LNG['sys_expe_found_dm_2_3']				= 'Nasa ekspedicija je pronasla drevnu svemirsku stanicu koja je lebdjela dugo vremena nekontrolirano kroz prostor. Stanica je potpuno beskorisna,u jednom od njenih reaktora pronasli smo male kolicine tamne tvari.';
$LNG['sys_expe_found_dm_3_1']				= 'Spontano Hyperspace izoblicenje omogucilo je ekspediciji kako bi se osigurale velike kolicine tamne tvari!';
$LNG['sys_expe_found_dm_3_2']				= 'Nasa ekspedicija zabiljezila je prvi susret s stvorenjem koji se zove Legorianer,On je odlucio da pomogne manje razvijenim vrstama,daje nam tamne tvari!';
$LNG['sys_expe_found_ships_1_1']			= 'Mi smo dosli po ostatke prethodne ekspedicije! Nasi tehnicari ce pogledati da li neke od olupina su u mogucnosti da se ponovno osposobe za letenje.';
$LNG['sys_expe_found_ships_1_2']			= 'Pronasli smo pustu pirat bazu. U hangaru su jos uvijek neki stari brodovi. Nasi tehnicari ce provjeriti da li smo jos uvijek u mogucnosti koristiti ih.';
$LNG['sys_expe_found_ships_1_3']			= 'Nasa ekspedicije pronasla je planet koji je vjerojatno bio unisten tijekom rata. U orbiti je nekoliko brodova. Tehnicari pokusavaju popraviti neke od njih.';
$LNG['sys_expe_found_ships_1_4']			= 'Pronasli smo tvrdavu,u hangaru su brodovi,tehnicari pokusavaju neke od njih popraviti. ';
$LNG['sys_expe_found_ships_2_1']			= 'Pronasli smo ostatke Armade,tehnicari pokusavaju osposobiti nekoliko brodova.';
$LNG['sys_expe_found_ships_2_2']			= 'Pronasli smo staro brodogradiliste sa netaknutim brodovima,tehnicari su uspjeli ponovo pokrenuti brodogradiliste.'; 
$LNG['sys_expe_found_ships_3_1']			= 'Nasli smo ogromno groblje brodova,tehnicari su uspjeli pokrenuti neke od njih.';
$LNG['sys_expe_found_ships_3_2']			= 'Pronasli smo planet sa ostacima civilizacije,piloti i tehnicari otisli su na planet vidjeti mogu li pokrenuti koji brod.';
$LNG['sys_expe_lost_fleet_1']				= 'Ekspedicijska poruka: Zzzrrt O Boze! Krrrzzzzt zrrrtrzt krgzzzz da izgleda kao Krzzzzzzzztzzzz ...';
$LNG['sys_expe_lost_fleet_2']				= 'Posljednja ekspedicija je naisla na ........ crnu rupu.';
$LNG['sys_expe_lost_fleet_3']				= 'Eksplozija u jezgri broda unistila je cjelu posadu ekspedicije.';
$LNG['sys_expe_lost_fleet_4']				= 'Flota nije uspjela napraviti vremenski skok,strucnjaci su zabrinuti,izgleda da ce svi brodovi biti unisteni.';
$LNG['sys_expe_time_fast_1']				= 'Nepredvidene anomalije oko motora naslucuju za brzi povratak flote sa ekspedicije.';
$LNG['sys_expe_time_fast_2']				= 'Novi zapovjednik je iskoristio staru crvotocinu za brzi povratak,ali dokazi o tome nisu zabiljezeni.';
$LNG['sys_expe_time_fast_3']				= 'Tijekom povratka flota je naletila na solarni vjetar,posada je sretna stici ce prije kuci.';
$LNG['sys_expe_time_slow_1']				= 'Neiskusni navigator,okrenuo je flotu u suprutnom smjeru od kuce,povratak se znantno produzio.';
$LNG['sys_expe_time_slow_2']				= 'Iskusavajuci novi svemirski skok,nesto je poslo naopako,povratak ekspedicije se neocekivano produzuje.';
$LNG['sys_expe_time_slow_3']				= 'Novi navigacijski sustav promasio je zadane kordinate,povratak kuci potrajat ce nesto duze,slabi smo sa deuterijem.';
$LNG['sys_expe_time_slow_4']				= 'Naletjeli smo na solarnu oluju,ostali smo bez pola pogona,mehanicari pokusavaju rijesiti problem,izgleda da ce povratak potrajat malo duze.';
$LNG['sys_expe_time_slow_5']				= 'Brod druge civilizacije izveo je vremenski skok,i prilikom testiranja sudarili se sa nasim brodom,ostecenja su velika,cekamo popravak broda da se mozemo kuci.';
$LNG['sys_expe_time_slow_6']				= 'Putem smo naisli na zanimljivu zvijezdu,novi lapetan je odlucio da malo skrenemo sa puta kako bi istrazili tog crvenog diva.';
$LNG['sys_expe_nothing_1'] 				= 'Osim par slika nekih cudnih mocvarnih bica posada nista drugo nije pronasla.';
$LNG['sys_expe_nothing_2'] 				= 'Posada je uspjela napraviti spektakularne slike supernove,imat cemo natjecanje za najbolju sliku godine.';
$LNG['sys_expe_nothing_3'] 				= 'Racunalni virus cjelu posadu je doveo u zabludu,prekasno smo ga otkrili,cjelo vrijeme vrtjeli smo se u krug,posada je razocarana.';
$LNG['sys_expe_nothing_4'] 				= 'Zbog greske na tanku,bili smo primorani vratiti se nazad,iscurilo nam je vise od pola deuterija.';
$LNG['sys_expe_nothing_5'] 				= 'Naisli smo na neku crvenu anomaliju,pola posade halucinira ostali su hipnotizirani.';
$LNG['sys_expe_nothing_6'] 				= 'Skenirali smo cjeli sektor,ali se vracamo praznih ruku.';
$LNG['sys_expe_nothing_7'] 				= 'Proslavom rodendana od clana posade,vecina je zavrsila u ambulanti zbog previse alkoholaekspedicija nije uspjela.';
$LNG['sys_expe_nothing_8'] 				= 'Istrazili smo valjda svaki kutak svemira,ali nismo pronasli nista.';
$LNG['sys_expe_nothing_9'] 				= 'Kvarom brodske jezgre,posada je imala pune ruke posla,zbog nedostatka vremena ekspedicija je odgodena.'; 	
$LNG['sys_expe_attack_1_1_1'] 				= 'U ocajnom prostoru,ocajni pirati pokusali su oteti clanove posade.';
$LNG['sys_expe_attack_1_1_2'] 				= 'Napadaju nas barbari sa svojim brodovima,sukob je neizbjezan.';
$LNG['sys_expe_attack_1_1_3'] 				= 'Zaprimili smo prijetece poruke od pijanih pirata,izgleda da je napad neizbjezan.';
$LNG['sys_expe_attack_1_1_4'] 				= 'Morali smo boriti protiv nekih pirata,srecom nisu brojniji od nas.';
$LNG['sys_expe_attack_1_1_5'] 				= 'Presrela nas je grupa razbojnika,zele da predamo nase brodove,morat cemo ih upoznati sa nasim naoruzanjem.';
$LNG['sys_expe_attack_1_2_1'] 				= 'Imali smo neugodan susret sa neraspolozenim piratima.';
$LNG['sys_expe_attack_1_2_2'] 				= 'Upali smo u piratsku zasjedu,borba je neizbjezna.';
$LNG['sys_expe_attack_1_2_3'] 				= 'Primili poziv za pomoc,bila je to lazna poruka pirata da nas namame u svoje podrucje,borba je neizbjezna.';
$LNG['sys_expe_attack_1_3_1'] 				= 'Prateci signal,dosli smo do piratske baze,kad su nas vidjeli nisu bas bili odusevljeni.';
$LNG['sys_expe_attack_1_3_2'] 				= 'Imali smo tesku borbu sa jos neidentificiranim piratima!';
$LNG['sys_expe_attack_2_1_1'] 				= 'Pronasli smo planet sa novom vrstom,u genima im je ratobornost.';
$LNG['sys_expe_attack_2_1_2'] 				= 'Napala nas neka skupina brodova bez upozerenja!';
$LNG['sys_expe_attack_2_1_3'] 				= 'Nasa skupina je napadnuta od male skupine nepoznatih brodova!';
$LNG['sys_expe_attack_2_1_4'] 				= 'Nepoznatom brodu poslali smo poruku,umjesto odgovora zasipali su nas paljbom.';
$LNG['sys_expe_attack_2_2_1'] 				= 'Nepoznata vrsta napada cjelu ekspedicijsku eskadrilu!';
$LNG['sys_expe_attack_2_2_2'] 				= 'Usli smo na podrucje pirata,napali nas bez upozorenja.';
$LNG['sys_expe_attack_2_2_3'] 				= 'Put za ekspediciju je prekinut paljbom nepoznatog broda sa odlicnim manevarskim sposobnostima.';
$LNG['sys_expe_attack_2_3_1'] 				= 'Posada je pod paljbom invazije pirata sa malenim i mnogobrojnim brodovima!';
$LNG['sys_expe_attack_2_3_2'] 				= 'Naletjeli smo na neku kristalnu kuglu,umjesto poruke zasuli su nas paljbom.';
$LNG['sys_expe_attackname_1']				= 'Pirati'; 	
$LNG['sys_expe_attackname_2'] 				= 'Alijeni'; 	
$LNG['sys_expe_back_home'] 				= 'Vasa ekspedicija se vratila u hangar.<br>Oni su donjeli %s %s, %s %s, %s %s i %s %s .';
$LNG['sys_expe_back_home_without_dm']		        = 'Vasa ekspedicija se vratila u hangar.';
$LNG['sys_expe_back_home_with_dm']			= 'Vasa ekspedicija se vratila u hangar.<br>Otkrili su %s(%s) deformirane posude.<br>moze biti spaseno.';
$LNG['sys_mess_transport'] 				= 'Izvjesce transporta';
$LNG['sys_tran_mess_owner']		 		= 'Jedna od tvoje flote stigla je na planetu %s %s ostavila je %s %s, %s %s i %s %s.';
$LNG['sys_tran_mess_user'] 		 		= 'Prijateljska flota %s %s stigla %s %s i dostavlja %s %s, %s %s i %s %s.';
$LNG['sys_mess_fleetback'] 				= 'Povratak flote';
$LNG['sys_tran_mess_back'] 				= 'Jedna tvoja flota vraca se nazad na planetu %s %s .';
$LNG['sys_recy_gotten'] 					= 'Vasi recikleri prikupili su %s %s i %s %s';
$LNG['sys_notenough_money'] 				= 'ONa vasem planetu %s <a href="./game.php?page=buildings&amp;cp=%d&amp;re=0">[%d:%d:%d]</a> Vi nemate dovoljno sredstava za izgradnju a %s . <br>Vi imate %s %s , %s %s i %s %s. <br>Troskovi izgradnje su %s %s , %s %s i %s %s.';
$LNG['sys_nomore_level'] 					= 'Mozete pokusati unistiti jednu zgradu koju vise netrebate( %s ).';
$LNG['sys_buildlist'] 						= 'Red proizvodnje';
$LNG['sys_buildlist_fail'] 				= 'Izgradnja nije moguca';
$LNG['sys_gain'] 				  			= 'Mogucnosti';
$LNG['sys_irak_subject'] 				  	= 'Napad raketa';
$LNG['sys_irak_no_def'] 				  	= 'Planet nema obrane';
$LNG['sys_irak_no_att'] 				  	= 'Sve vase rakete su presretnute.';
$LNG['sys_irak_def'] 					  	= '%d Raketa je presretnuto.';
$LNG['sys_irak_mess']						= 'Interplanetarna raketa (%d) od %s su na planeti %s <br><br>';
$LNG['sys_gain'] 				  			= 'Mogucnosti';
$LNG['sys_fleet_won'] 						= 'Jedna od vase flote se vraca iz napada sa planete %s %s. Opljackao si %s %s, %s %s i %s %s ';
$LNG['sys_perte_attaquant'] 				= 'Napadac izgubio';
$LNG['sys_perte_defenseur'] 				= 'Branitelj izgubio';
$LNG['sys_debris'] 						= 'Rusevina';
$LNG['sys_destruc_title']       		   	= 'sansa za unistenje mjeseca:';
$LNG['sys_mess_destruc_report']  		  	= 'Izvjesce: Unistavanje Mjeseca';
$LNG['sys_destruc_lune']          		 	= 'Vjerojatnost unistenja mjeseca: %d%% ';
$LNG['sys_destruc_rip']          			= '..';
$LNG['sys_destruc_stop']      			 	= 'Branitelj uspjesno blokirao unistenje mjeseca.';
$LNG['sys_destruc_mess1']       		   	= 'Zvijezda smrti ispaljuje gravitone prema mjesecu.';
$LNG['sys_destruc_mess']        		   	= 'Flota sa planete %s [%d:%d:%d] ide na mjesec [%d:%d:%d].';
$LNG['sys_destruc_echec']       		   	= 'Potresi potresaju mjesec,no nesto pode po zlu,zvijezda je eksplodirala i raspala se. <br>darni val doseze cijelu flotu.';
$LNG['sys_destruc_reussi']      		   	= 'Potresi su na povrsini Mjeseca, nakon nekog vremena mjesec ne podrzava vise i leti u komade, misije ostvarena,flota se vraca na pocetnu planetu.';
$LNG['sys_destruc_null']        		   	= 'Zvijezda smrti nije mogla razviti punu snagu.<br> Mjesec nije unisten.';
$LNG['sys_module_inactive']                = 'Modul onesposobljen';

//----------------------------------------------------------------------------//
//class.CheckSession.php
$LNG['ccs_multiple_users']					= 'Cookie Error! Netko je prijavljen na tvoj racun. Izbrisite kolacice i pokusajte ponovno. Ako se problem nastavi, obratite se administratoru.';
$LNG['ccs_other_user']						= 'Cookie Error! Izbrisite kolacice i pokusajte ponovno. Ako se problem nastavi, obratite se administratoru.<br> Error Code. 272';
$LNG['css_different_password']				= 'Cookie Error! Izbrisite kolacice i pokusajte ponovno. Ako se problem nastavi, obratite se administratoru.<br> Error Code. 273';
$LNG['css_account_banned_message']			= 'VAs KORISNIcKI RAAcUN JE KAzNJEN';
$LNG['css_account_banned_expire']			= 'Vi ste %s do!<br><a href="./index.php?page=pranger">Kaznjeni</a>';
$LNG['css_goto_homeside']					= '<a href="./index.php">Idite na pocetnu stranicu</a>';
$LNG['css_server_maintrace']				= 'Poruka servera<br><br>Igra je trenutno nedostupna.<br><br>razlog: %s';

//----------------------------------------------------------------------------//
//class.debug.php
$LNG['cdg_mysql_not_available']			= 'Nema veze na bazu podataka<br>Molimo navratite kasnije.<br><br>Molimo za razumijevanje';
$LNG['cdg_error_message']					= 'Greska, molimo kontaktirajte administratora. Pogreska broj.:';
$LNG['cdg_fatal_error']					= 'FATAL ERROR';

//----------------------------------------------------------------------------//
//class.FlyingFleetsTable.php

$LNG['cff_no_fleet_data']                    = 'Nema informacija flote';
$LNG['cff_aproaching']                        = 'Flota se sastoji od ';
$LNG['cff_ships']                            = ' Jedinica.';
$LNG['cff_from_the_planet']                = '';
$LNG['cff_from_the_moon']                    = 'mjesec ';
$LNG['cff_the_planet']                        = '  planetu ';
$LNG['cff_debris_field']                    = 'na rusevinu ';
$LNG['cff_to_the_moon']                    = 'na mjesec ';
$LNG['cff_the_position']                    = ' sa Pozicije ';
$LNG['cff_to_the_planet']                    = ' ';
$LNG['cff_the_moon']                        = ' na mjesec ';
$LNG['cff_from_planet']                    = '  planetu ';
$LNG['cff_from_debris_field']                = 'sa rusevine ';
$LNG['cff_from_the_moon']                    = 'sa mjeseca ';
$LNG['cff_from_position']                    = 'na poziciji ';
$LNG['cff_missile_attack']                    = 'Napad raketa';
$LNG['cff_from']                            = '  ';
$LNG['cff_to']                                = '  ';
$LNG['cff_one_of_your']                    = 'Jedna od tvojih ';
$LNG['cff_acs_fleet']						= 'AKS-Flota ';
$LNG['cff_a']                                = 'a ';
$LNG['cff_of']                                = '  ';
$LNG['cff_goes']                            = ' sa ';
$LNG['cff_toward']                            = ' ide na ';
$LNG['cff_back_to_the_planet']                = ' vraca se natrag na planetu ';
$LNG['cff_with_the_mission_of']            = '. Misija je: ';
$LNG['cff_to_explore']                        = ' istrazuje ';
$LNG['cff_comming_back']                    = '';
$LNG['cff_back']                            = 'Povratak';
$LNG['cff_to_destination']                    = 'Stigla do odredista';

//----------------------------------------------------------------------------//
// EXTRA LANGUAGE FUNCTIONS
$LNG['fcm_moon']							= 'mjesec';
$LNG['fcm_info']							= 'Informacije';
$LNG['fcp_colony']							= 'Colonija';
$LNG['fgp_require']						= 'Zahtjev: ';
$LNG['fgf_time']							= 'Vrijeme izgradnje: ';

//----------------------------------------------------------------------------//
// CombatReport.php
$LNG['cr_lost_contact']					= 'Kontakt je bio izgubljen u napadu flote.';
$LNG['cr_first_round']						= '(Flota je unistena u prvom krugu)';
$LNG['cr_type']							= 'Vrsta';
$LNG['cr_total']							= 'Ukupno';
$LNG['cr_weapons']							= 'Oruzje';
$LNG['cr_shields']							= 'Stit';
$LNG['cr_armor']							= 'Oklop';
$LNG['cr_destroyed']						= 'Unisten!';

//----------------------------------------------------------------------------//
// FleetAjax.php
$LNG['fa_not_enough_probes']				= 'Greska,nema sondi';
$LNG['fa_galaxy_not_exist']				= 'Greska galaksija ne postoji';
$LNG['fa_system_not_exist']				= 'Greska sistem ne postoji';
$LNG['fa_planet_not_exist']				= 'Greska planet ne postoji';
$LNG['fa_not_enough_fuel']					= 'Greska nemas dovoljno deuterija';
$LNG['fa_no_more_slots']					= 'Greska nema slobodnih slotova';
$LNG['fa_no_recyclers']					= 'Greska nema slobodnih reciklera';
$LNG['fa_no_fleetroom']					= 'Greska potrosnja deuterija je veca nego kapacitet prijevoza';
$LNG['fa_mission_not_available']			= 'Greska misija nije dostupna';
$LNG['fa_no_spios']						= 'Greska nema dostupnih sondi';
$LNG['fa_vacation_mode']					= 'Greska igrac je u modu za odmor';
$LNG['fa_week_player']						= 'Greska igrac je preslab';
$LNG['fa_strong_player']					= 'Greska igrac je prejak';
$LNG['fa_not_spy_yourself']				= 'Greska nemozes spijunirati sam sebe';
$LNG['fa_not_attack_yourself']				= 'Greska nemozes napasti sam sebe';
$LNG['fa_action_not_allowed']				= 'Greska akcija nije dozvoljena';
$LNG['fa_vacation_mode_current']			= 'Greska u modusu za odmor si';
$LNG['fa_sending']							= 'Posalji';

//----------------------------------------------------------------------------//
// MissilesAjax.php
$LNG['ma_silo_level']						= 'Trebate raketni silos razina 4!';
$LNG['ma_impulse_drive_required']			= 'Prvo trebas istraziti Impulsni pogon';
$LNG['ma_not_send_other_galaxy']			= 'Nemozes slati rakete u druge galaksije.';
$LNG['ma_planet_doesnt_exists']			= 'Planet ne postoji.';
$LNG['ma_wrong_target']					= 'Pogresna meta';
$LNG['ma_no_missiles']						= 'Nemas dostupnih Interplanetarnih raketa';
$LNG['ma_add_missile_number']				= 'Upisi koliko raketa zelis poslati u napad';
$LNG['ma_misil_launcher']					= 'Raketobacac';
$LNG['ma_small_laser']						= 'Mali laser';
$LNG['ma_big_laser']						= 'Veliki laser';
$LNG['ma_gauss_canyon']					= 'Gausov top';
$LNG['ma_ionic_canyon']					= 'Ionski top';
$LNG['ma_buster_canyon']					= 'Plazma top';
$LNG['ma_small_protection_shield']			= 'Mala kupola';
$LNG['ma_big_protection_shield']			= 'Velika kupola';
$LNG['ma_all']								= 'Sve';
$LNG['ma_missiles_sended']					= ' Interplanetarne rakete su poslane,Glavni cilj: ';

//----------------------------------------------------------------------------//
// topkb.php
$LNG['tkb_top']                  			= 'HoF';
$LNG['tkb_gratz']                  		= 'Top 100 najvecih bitaka 1na1';
$LNG['tkb_platz']                  		= 'Mjesto';
$LNG['tkb_owners']             			= 'Sudionici';
$LNG['tkb_datum']                  		= 'Datum';
$LNG['tkb_units']             				= 'Jedinica';
$LNG['tkb_legende']               		 	= '<b>Legenda: </b>';
$LNG['tkb_gewinner']              		 	= '<b>-Pobjednik-</b>';
$LNG['tkb_verlierer']              		= '<b>-Gubitnik-</b>';
$LNG['tkb_unentschieden']         			= '<b>-Nerjeseno- </b>';
$LNG['tkb_missing']              		  	= '<br>Nedostatak u akciji:Korisnicki racun vise ne postoji.';

//----------------------------------------------------------------------------//
// playercard.php
$LNG['pl_overview']  						= 'Igrac INFO';
$LNG['pl_name'] 							= 'Korisnik';
$LNG['pl_homeplanet'] 						= 'Glavna planeta';
$LNG['pl_ally']     						= 'Savez';
$LNG['pl_message']    						= 'Privatna poruka';
$LNG['pl_buddy']        					= 'posalji zahtjev';
$LNG['pl_points']      					= 'Bodovi';
$LNG['pl_range']         					= 'Rang';
$LNG['pl_builds']     						= 'Zgrade';
$LNG['pl_tech']    						= 'Istrazivanja';
$LNG['pl_fleet']       					= 'Flota';
$LNG['pl_def']         					= 'Obrana';
$LNG['pl_total']       					= 'Ukupno';
$LNG['pl_fightstats'] 						= 'Statistika borbi';
$LNG['pl_fights']     						= 'Borbe';
$LNG['pl_fprocent']       					= 'Uspjesnost';
$LNG['pl_fightwon']  						= 'Pobjeda';
$LNG['pl_fightdraw']  						= 'Nerjeseno';
$LNG['pl_fightlose']  						= 'Izgubljeno';
$LNG['pl_totalfight']      				= 'Ukupno borbi';
$LNG['pl_destroy']    						= '%s je bio ukljucen u sljedecim unistenjima';
$LNG['pl_unitsshot']    					= 'Jedinica unistio';
$LNG['pl_unitslose']    					= 'Jedinica izgubio';
$LNG['pl_dermetal']    					= 'Ukupno metala u rusevinu';
$LNG['pl_dercrystal']   					= 'Ukupno kristala u rusevinu';
$LNG['pl_etc']   							= 'Ostalo';

//----------------------------------------------------------------------------//
// Chat

$LNG['chat_title']                         = 'Chat';
$LNG['chat_ally_title']                    = 'Savez Chat';  

$LNG['chat_disc']                          = 'Chat';
$LNG['chat_message']                       = 'Poruka';
$LNG['chat_send']                          = 'Posalji';
$LNG['chat_admin']                       	= '<font color="red">Admin %s</font>';

//----------------------------------------------------------------------------//
// Support

$LNG['supp_header'] 						= 'Podrska tiketi';
$LNG['supp_header_g']                      = 'Zatvoreni tiketi';
$LNG['ticket_id'] 							= '#Tiket-ID';
$LNG['subject'] 							= 'naslov';
$LNG['status'] 							= 'Status';
$LNG['ticket_posted'] 						= 'Objavljeno:';
$LNG['ticket_new'] 						= 'Novi tiket';
$LNG['input_text'] 						= 'Opis problema:';
$LNG['answer_new'] 						= 'Tekst:';
$LNG['text'] 								= 'Detalji';
$LNG['message_a'] 							= 'Status poruke:';
$LNG['sendit_a'] 							= 'Mail je poslan.';
$LNG['message_t'] 							= 'Status tiketa:';
$LNG['sendit_t'] 							= 'Tiket zaprimljen.';
$LNG['close_t'] 							= 'Tiket zatvoren.';
$LNG['sendit_error'] 						= 'Greska:';
$LNG['sendit_error_msg'] 					= 'Niste ispunili sve podatke!';
$LNG['supp_admin_system'] 					= 'Incident Management System';
$LNG['close_ticket'] 						= 'Zatvori tiket';
$LNG['open_ticket']                        = 'Otvori tiket';
$LNG['player'] 							= 'Igrac';
$LNG['supp_ticket_close']					= 'Tiket zatvoren';
$LNG['supp_close'] 						= 'Zatvori';
$LNG['supp_open'] 							= 'Otvori';
$LNG['supp_admin_answer'] 					= 'Adminov odgovor';
$LNG['supp_player_answer'] 				= 'Igracev odgovor';

//----------------------------------------------------------------------------//
// Records

$LNG['rec_build']  						= 'Zgrade';
$LNG['rec_specb']							= 'Specijalne zgrade';
$LNG['rec_playe']  						= 'Igrac';
$LNG['rec_defes']  						= 'Obrana';
$LNG['rec_fleet']  						= 'Brodovi';
$LNG['rec_techn']  						= 'Istrazivanja';
$LNG['rec_level']  						= 'Level';
$LNG['rec_nbre']   						= 'Broj';
$LNG['rec_rien']   						= '-';
$LNG['rec_last_update_on']   				= 'Zadnje azuriranje : %s';


//----------------------------------------------------------------------------//
// BattleSimulator

$LNG['bs_derbis_raport']					= "Trebat ce ti %s %s za %s %s rusevinu.";
$LNG['bs_steal_raport']					= "Za pljacku trebate %s %s ili %s %s ili %s %s .";
$LNG['bs_names']							= "Brod";
$LNG['bs_atter']							= "Napadac";
$LNG['bs_deffer']							= "Branitelj";
$LNG['bs_steal']							= "Resursi(za opljackati):";
$LNG['bs_techno']							= "Tehnologije";
$LNG['bs_send']							= "Posalji";
$LNG['bs_cancel']							= "Resetiraj";
$LNG['bs_wait']							= "Molimo pricekajte 10 sekundi za sljedecu simulaciju";

// Translated into Croatian by Seiteki . All rights reversed (C) 2010

?>