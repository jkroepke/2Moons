<?php

//Traduzione eseguita da Malware del sito http://2moons.freedost.com, la community italiana di 2moons.
//Se hai domande, dubbi o vuoi segnalare scorrettezze, sei pregato di farlo usando il nostro forum. Grazie

setlocale(LC_ALL, 'it_IT', 'italian'); // http://msdn.microsoft.com/en-us/library/39cwe7zf%28vs.71%29.aspx
setlocale(LC_NUMERIC, 'C');

//SERVER GENERALS

$LNG['js_days']								= array('Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab');
$LNG['js_month']							= array('Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'giu', 'lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic');

$LNG['Metal']								= 'Metallo';
$LNG['Crystal']								= 'Cristallo';
$LNG['Deuterium']							= 'Deuterio';
$LNG['Darkmatter']							= 'Materia oscura';
$LNG['Energy']								= 'Energia';
$LNG['Messages']							= 'Messagi';
$LNG['write_message']						= 'Scrivi un messaggio';

$LNG['ready']								= 'Leggi';
$LNG['show_planetmenu']						= 'Mostra / Nascondi';

$LNG['type_mission'][1]  					= 'Attacco';
$LNG['type_mission'][2]  					= 'Attacco ACS';
$LNG['type_mission'][3]  					= 'Trasporto';
$LNG['type_mission'][4]  					= 'Schiera';
$LNG['type_mission'][5]  					= 'Difendi pianeta';
$LNG['type_mission'][6]  					= 'Spia';
$LNG['type_mission'][7]  					= 'Colonizza';
$LNG['type_mission'][8]  					= 'Recicla';
$LNG['type_mission'][9]  					= 'Distruggi';
$LNG['type_mission'][11]  					= 'Ricerca MO';
$LNG['type_mission'][15] 					= 'Spedizione';

$LNG['user_level'] = array (
	'0' => 'Giocatore',
	'1' => 'Moderatore',
	'2' => 'Operatore',
	'3' => 'Amministratore',
);

// GAME.PHP
$LNG['see_you_soon']						= 'Grazie per aver giocato';
$LNG['page_doesnt_exist']					= 'Pagina non trovata';


//----------------------------------------------------------------------------//
//TOPNAV
$LNG['tn_vacation_mode']					= 'Sei in modalit&agrave vacanza ';
$LNG['tn_delete_mode']						= 'Il tuo account %s sta per essere cancellato!';

//----------------------------------------------------------------------------//
//LEFT MENU
$LNG['lm_overview']							= 'Riepilogo';
$LNG['lm_galaxy']							= 'Galassia';
$LNG['lm_empire']							= 'Impero';
$LNG['lm_fleet']							= 'Flotta';
$LNG['lm_buildings']						= 'Costruzioni';
$LNG['lm_research']							= 'Ricerca';
$LNG['lm_shipshard']						= 'Cantiere navale';
$LNG['lm_defenses']							= 'Difesa';
$LNG['lm_resources']						= 'Risorse';
$LNG['lm_fleettrader']						= 'Commerciante';
$LNG['lm_officiers']						= 'Officiali';
$LNG['lm_trader']							= 'Mercante';
$LNG['lm_technology']						= 'Albero tecnologico';
$LNG['lm_messages']							= 'Messaggi';
$LNG['lm_alliance']							= 'Alleanza';
$LNG['lm_buddylist']						= 'Lista di costruzioni';
$LNG['lm_notes']							= 'Note';
$LNG['lm_statistics']						= 'Classifica';
$LNG['lm_search']							= 'Cerca';
$LNG['lm_options']							= 'Opzioni';
$LNG['lm_banned']							= 'Bannati';
$LNG['lm_contact']							= 'Contatti';
$LNG['lm_forums']							= 'Forum';
$LNG['lm_logout']							= 'Logout';
$LNG['lm_administration']					= 'Amministrazione';
$LNG['lm_game_speed']						= 'Gioco';
$LNG['lm_fleet_speed']						= 'Flotta';
$LNG['lm_resources_speed']					= 'Risorse';
$LNG['lm_queue']							= 'Coda';
$LNG['lm_topkb']							= 'Hall of Fame';
$LNG['lm_faq']								= 'Guida iniziale';
$LNG['lm_records']							= 'Record';
$LNG['lm_chat']								= 'Chat';
$LNG['lm_support']							= 'Support Ticket';
$LNG['lm_rules']							= 'Regolamento';
$LNG['lm_battlesim']						= "Simulatore di battaglie";

//----------------------------------------------------------------------------//
//OVERVIEW

$LNG['ov_newname_alphanum']					= 'Il nome del pianeta deve contenere solo caratteri alfanumerici.';
$LNG['ov_newname_no_space']					= 'Il nome del pianeta non deve contenere spazi.';
$LNG['ov_planet_abandoned']					= 'Pianeta abbandonato!';
$LNG['ov_principal_planet_cant_abanone']	= 'Non puoi abbandonare il pianeta madre!';
$LNG['ov_abandon_planet_not_possible']		= 'Non puoi abbandonare il pianeta mentre &egrave attivo!';
$LNG['ov_wrong_pass']						= 'Password errata. Riprova!';
$LNG['ov_have_new_message']					= 'Nuovo messaggio [1]';
$LNG['ov_have_new_messages']				= 'Nuovi Messaggi [%d]';
$LNG['ov_planetmenu']						= 'Menu del pianeta';
$LNG['ov_free']								= 'Libero';
$LNG['ov_news']								= 'News';
$LNG['ov_place']							= 'Posto';
$LNG['ov_of']								= 'del';
$LNG['ov_planet']							= 'Pianeta';
$LNG['ov_server_time']						= 'Orario del server ';
$LNG['ov_events']							= 'Eventi';
$LNG['ov_diameter']							= 'Diametro';
$LNG['ov_distance_unit']					= 'km';
$LNG['ov_temperature']						= 'Temperatura';
$LNG['ov_aprox']							= 'Circa';
$LNG['ov_temp_unit']						= '&deg;C';
$LNG['ov_to']								= 'a';
$LNG['ov_position']							= 'Posizione';
$LNG['ov_points']							= 'Punti';
$LNG['ov_security_request']					= 'Domanda di sicurezza';
$LNG['ov_security_confirm']					= 'Per favore conferma la tua scelta';
$LNG['ov_password']							= 'Password';
$LNG['ov_delete_planet']					= 'Abbandona pianeta';
$LNG['ov_planet_rename']					= 'Rinonima';
$LNG['ov_rename_label']						= 'Nuovo nome';
$LNG['ov_fields']							= 'Campi';
$LNG['ov_developed_fields']                = 'Campi sviluppati';
$LNG['ov_max_developed_fields']				= 'max. campi sviluppati';
$LNG['ov_fleet']							= 'flotta';
$LNG['ov_admins_online']					= 'Amministratori(Online):';
$LNG['ov_no_admins_online']					= 'Attualmente, nessuno online!';
$LNG['ov_userbanner']						= 'Banner statistiche utente';
$LNG['ov_userrank_info']					= '%s (%s <a href="game.php?page=statistics&amp;range=%d">%d</a> %s %s)';
$LNG['ov_teamspeak_not_online']				= 'Il server &egrave attualmente offline. Ci scusiamo per il disagio.';
$LNG['ov_teamspeak']						= 'Teamspeak';
$LNG['ov_teamspeak_v2']						= '<a href="teamspeak://%s:%s?nickname=%s" title="Teamspeak Connect">Connect</a> &bull; Online: %d/%d &bull; Channels: %d &bull; Traffic ges.: %s MB';
$LNG['ov_teamspeak_v3']						= '<a href="ts3server://%s?port=%d&amp;nickname=%s&amp;password=%s" title="Teamspeak Connect">Connect</a>&nbsp;&bull;&nbsp;Online: %d/%d &bull; Channels: %d &bull; Traffic ges.: %s MB';
$LNG['ov_closed']							= 'Gioco temporaneamente disattivato! ';
$LNG['ov_reflink']							= 'Link amico';
//----------------------------------------------------------------------------//
//GALAXY

$LNG['gl_no_deuterium_to_view_galaxy']		= 'Non hai abbastanza deuterio!';
$LNG['gl_legend']							= 'Legenda';
$LNG['gl_strong_player']					= 'Giocatore forte';
$LNG['gl_week_player']						= 'Giocatore debole';
$LNG['gl_vacation']							= 'Modalit&agrave vacanza';
$LNG['gl_banned']							= 'Bannato';
$LNG['gl_inactive_seven']					= 'Inattivo da 7 giorni';
$LNG['gl_inactive_twentyeight']				= 'Inattivo da 28 giorno';
$LNG['gl_s']								= 'S';
$LNG['gl_w']								= 'W';
$LNG['gl_v']								= 'V';
$LNG['gl_b']								= 'B';
$LNG['gl_i']								= 'i';
$LNG['gl_I']								= 'I';
$LNG['gl_populed_planets']					= '%d Pianeta disabitato';
$LNG['gl_out_space']						= 'Esplora il resto del sistema';
$LNG['gl_avaible_missiles']					= 'Missili';
$LNG['gl_fleets']							= 'Slot disponibili';
$LNG['gl_avaible_grecyclers']				= 'Mega riciclatrici';
$LNG['gl_avaible_recyclers']				= 'Riciclatrici';
$LNG['gl_avaible_spyprobes']				= 'Sonde spie';
$LNG['gl_missil_launch']					= 'Attacco missilistico';
$LNG['gl_missil_to_launch']					= 'Missili [<b>%d</b>]:';
$LNG['gl_all_defenses']						= 'Tutto';
$LNG['gl_objective']						= 'Obiettivo';
$LNG['gl_missil_launch_action']				= 'Invia';
$LNG['gl_galaxy']							= 'Galassia';
$LNG['gl_solar_system']						= 'Sistema';
$LNG['gl_show']								= 'Mostra';
$LNG['gl_pos']								= 'Pos';
$LNG['gl_planet']							= 'Pianeta';
$LNG['gl_name_activity']					= 'Nome (Attivit&agrave)';
$LNG['gl_moon']								= 'Luna';
$LNG['gl_debris']							= 'Detriti';
$LNG['gl_player_estate']					= 'Giocatori (Stato)';
$LNG['gl_alliance']							= 'Alleanza';
$LNG['gl_actions']							= 'Azione';
$LNG['gl_spy']								= 'Spia';
$LNG['gl_buddy_request']					= 'Richiesta di amicizia';
$LNG['gl_missile_attack']					= 'Attacco missilistico';
$LNG['gl_with']								= ' con ';
$LNG['gl_member']							= '%d Utenti';
$LNG['gl_member_add']						= '%d Utente';
$LNG['gl_alliance_page']					= 'Pagina dell\'alleanza';
$LNG['gl_see_on_stats']						= 'Classifica';
$LNG['gl_alliance_web_page']				= 'Pagina dell\alleanza';
$LNG['gl_debris_field']						= 'Debris Field';
$LNG['gl_collect']							= 'Campo detriti';
$LNG['gl_resources']						= 'Risorse';
$LNG['gl_features']							= 'Caratteristiche';
$LNG['gl_diameter']							= 'Diametro';
$LNG['gl_temperature']						= 'Temperatura';
$LNG['gl_phalanx']							= 'Falange';
$LNG['gl_planet_destroyed']					= 'Pianeta distrutto';
$LNG['gl_playercard']						= 'Carta del giocatore';
$LNG['gl_player']							= 'Giocatore';
$LNG['gl_in_the_rank']						= 'Giocatore %s in posizione %d';
$LNG['gl_activity']                         = '(*)';
$LNG['gl_activity_inactive']                = '(%d min)';
$LNG['gl_ajax_status_ok']                   = 'Eseguito';
$LNG['gl_ajax_status_fail']                	= 'Errore';
$LNG['gl_free_desc'] 						= 'Pianeta disabitato! Colonizzare qui prima che qualcun\'altor lo faccia!';
$LNG['gl_free'] 							= 'Libero';
$LNG['gl_yes'] 								= 'Si';
$LNG['gl_no'] 								= 'No';
$LNG['gl_points'] 							= 'Punti';
$LNG['gl_player']							= 'Giocatore';
$LNG['gl_to']								= 'a';

//----------------------------------------------------------------------------//
//PHALANX
$LNG['px_no_deuterium']						= 'Non hai abbastanza deuterio!';
$LNG['px_scan_position']					= 'Scan della posizione';
$LNG['px_fleet_movement']					= 'Movimenti della flotta attuali';
$LNG['px_no_fleet']							= 'Nessun movimento di flotta.';
$LNG['px_out_of_range']						= 'Fuori portata';

//----------------------------------------------------------------------------//
//EMPIRE
$LNG['iv_imperium_title']					= 'Riepilogo dell\'impero';
$LNG['iv_planet']							= 'Pianeta';
$LNG['iv_name']								= 'Nome';
$LNG['iv_coords']							= 'Coordinate';
$LNG['iv_fields']							= 'Campo';
$LNG['iv_resources']						= 'Risorse';
$LNG['iv_buildings']						= 'Costruziono';
$LNG['iv_technology']						= 'Ricerche';
$LNG['iv_ships']							= 'Navi';
$LNG['iv_defenses']							= 'Difesa';

//----------------------------------------------------------------------------//
//FLEET - FLEET1 - FLEET2 - FLEET3 - FLEETACS - FLEETSHORTCUTS
$LNG['fl_returning']						= 'Flotte nel pianeta';
$LNG['fl_onway']							= 'Flotte a pianeta';
$LNG['fl_r']								= '(R)';
$LNG['fl_a']								= '(A)';
$LNG['fl_send_back']						= 'Indietro';
$LNG['fl_acs']								= 'ACS';
$LNG['fl_no_more_slots']					= 'Tutti gli slot flotta sono usati';
$LNG['fl_speed_title']						= 'Velocit&agrave: ';
$LNG['fl_continue']							= 'continua';
$LNG['fl_no_ships']							= 'Nessuna nave disponibile';
$LNG['fl_remove_all_ships']					= 'Nessuna nave';
$LNG['fl_select_all_ships']					= 'Tutte le navi';
$LNG['fl_fleets']							= 'Flotte';
$LNG['fl_expeditions']						= 'Spediziono';
$LNG['fl_number']							= 'ID';
$LNG['fl_mission']							= 'Missione';
$LNG['fl_ammount']							= 'Navi (totali)';
$LNG['fl_beginning']						= 'Start';
$LNG['fl_departure']						= 'Arrivo (obiettivo)';
$LNG['fl_destiny']							= 'Destinazione';
$LNG['fl_objective']						= 'Obiettivo';
$LNG['fl_arrival']							= 'Arrivo (ritorno)';
$LNG['fl_info_detail']						= 'Dettagli della flotta';
$LNG['fl_order']							= 'Ordina';
$LNG['fl_new_mission_title']				= 'Nuovo ordine: seleziona flotta';
$LNG['fl_ship_type']						= 'Tipo di nave';
$LNG['fl_ship_available']					= 'Disponibile';
$LNG['fl_planet']							= 'Pianeta';
$LNG['fl_debris']							= 'Detriti';
$LNG['fl_moon']								= 'Luna';
$LNG['fl_planet_shortcut']					= '(P)';
$LNG['fl_debris_shortcut']					= '(D)';
$LNG['fl_moon_shortcut']					= '(M)';
$LNG['fl_no_shortcuts']						= 'Nessuna scorciatoia dispobile';
$LNG['fl_anonymous']						= 'Anonimo';
$LNG['fl_shortcut_add_title']				= 'None [Galassia/Sistema/Pianeta]';
$LNG['fl_shortcut_name']					= 'Nome';
$LNG['fl_shortcut_galaxy']					= 'Galassia';
$LNG['fl_shortcut_solar_system']			= 'Sistema';
$LNG['fl_clean']							= 'Resetta';
$LNG['fl_register_shorcut']					= 'Crea';
$LNG['fl_shortcuts']						= 'Scorciatoie';
$LNG['fl_reset_shortcut']					= 'Resetta';
$LNG['fl_dlte_shortcut']					= 'Cancella';
$LNG['fl_back']								= 'Ritorno';
$LNG['fl_shortcut_add']						= 'Aggiungi';
$LNG['fl_shortcut_edition']					= 'Modifica: ';
$LNG['fl_no_colony']						= 'Nessuna colonia presente';
$LNG['fl_send_fleet']						= 'Invia flotta';
$LNG['fl_fleet_speed']						= 'Velocit&agrave';
$LNG['fl_distance']							= 'Distanza (Anniluce)';
$LNG['fl_flying_time']						= 'Tempo di volo (one andata)';
$LNG['fl_flying_arrival']					= 'Arrivo all\'obiettivo';
$LNG['fl_flying_return']					= 'Arrivo all\'origine';
$LNG['fl_fuel_consumption']					= 'Consumo di carburante';
$LNG['fl_max_speed']						= 'Velocit&agrave flotta';
$LNG['fl_cargo_capacity']					= 'Capacit&agrave dei cargo';
$LNG['fl_shortcut']							= 'Scorciatoia';
$LNG['fl_shortcut_add_edit']				= '(Crea / Modifica)';
$LNG['fl_my_planets']						= 'Miei pianeti';
$LNG['fl_acs_title']						= 'Attacco ACS';
$LNG['fl_hold_time']						= 'Tempo di schieramento';
$LNG['fl_resources']						= 'Risorse';
$LNG['fl_max']								= 'max';
$LNG['fl_hours']							= 'Ora/e';
$LNG['fl_resources_left']					= 'Rimanente';
$LNG['fl_all_resources']					= 'Massimo carico delle risorse';
$LNG['fl_empty_target']						= 'Nessuna missione disponibile (esiste il pianeta?)';
$LNG['fl_expedition_alert_message']			= 'Attenzione! Le spedizioni sono pericolose, potresti perdere la flotta!';
$LNG['fl_dm_alert_message']					= 'Per sicurezza, se nel %s %s &egrave trovata, la flotta &egrave distrutta!';
$LNG['fl_vacation_mode_active']				= 'Sei in modalit&agrave vacanza';
$LNG['fl_expedition_tech_required']			= 'Tecnologia astrofisica necessaria!';
$LNG['fl_expedition_fleets_limit']			= 'Limite di flotte in spedizione raggiunto!';
$LNG['fl_week_player']						= 'Il giocatore &egrave troppo debole!';
$LNG['fl_strong_player']					= 'Il giocatore &egrave troppo forte!';
$LNG['fl_in_vacation_player']				= 'Giocatore in modalit&agrave vacanza';
$LNG['fl_no_slots']							= 'Nessun slot disponibile!';
$LNG['fl_empty_transport']					= 'Non puoi trasportare 0 risorse!';
$LNG['fl_planet_populed']					= 'Questo pianeta &egrave occupato!';
$LNG['fl_no_same_alliance']					= 'Il player in obiettivo è un tuo alleato o un tuo amico!';
$LNG['fl_not_ally_deposit']					= 'No deposito di alleanza';
$LNG['fl_deploy_only_your_planets']			= 'Puoi schierare flotte soltanto in un tuo pianeta!';
$LNG['fl_no_enought_deuterium']				= 'non hai abbastanza %s disponibile. You ti manca %s %s!';
$LNG['fl_no_enought_cargo_capacity']		= 'Non hai abbastanza spazio disponibile nei cargo:';
$LNG['fl_admins_cannot_be_attacked']		= 'Non puoi attaccare un\'amministratore';
$LNG['fl_fleet_sended']						= 'Flotta inviata';
$LNG['fl_from']								= 'Da';
$LNG['fl_arrival_time']						= 'Tempo di arrivo';
$LNG['fl_return_time']						= 'Tempo di ritorno';
$LNG['fl_fleet']							= 'Flotta';
$LNG['fl_player']							= 'Il giocatore ';
$LNG['fl_add_to_attack']					= ' è stato invitato.';
$LNG['fl_dont_exist']						= ' non esiste.';
$LNG['fl_acs_invitation_message']			= ' ti ha invitato a partecipare in un attacco federale ACS.';
$LNG['fl_acs_invitation_title']				= 'Invito per un ACS';
$LNG['fl_sac_of_fleet']						= 'Flotta ACS';
$LNG['fl_modify_sac_name']					= 'Cambia nome dell\'acs';
$LNG['fl_members_invited']					= 'Giocatori invitati';
$LNG['fl_invite_members']					= 'Invita altri giocatori';
$LNG['fl_simulate']							= 'Simulazione';
$LNG['fl_bonus']							= 'Bonus ricerca';
$LNG['fl_bonus_attack']						= 'Attacco';
$LNG['fl_bonus_defensive']					= 'Defensiva';
$LNG['fl_bonus_shield']						= 'Scudo';
$LNG['fl_no_empty_derbis']					= 'Campo detriti non trovato! ';
$LNG['fl_acs_newname_alphanum']				= 'Il nome pu&ograve consistere solo in caratteri alfanumerici. ';
$LNG['fl_acs_change']						= 'Cambia';
$LNG['fl_acs_change_name']					= 'Loro hanno cambiato nome';
$LNG['fl_error_not_avalible']				= 'Il pianeta non può essere servito!';
$LNG['fl_error_empty_derbis']				= 'Nessun campo detriti disponibile!';
$LNG['fl_error_no_moon']					= 'Luna non trovata!';
$LNG['fl_error_same_planet']				= 'L\'origine e l\'obiettivo sono lo stesso pianeta!';

//----------------------------------------------------------------------------//
//BUILDINGS - RESEARCH - SHIPYARD - DEFENSES
$LNG['bd_dismantle']						= 'Smantella';
$LNG['bd_interrupt']						= 'Interrompi';
$LNG['bd_cancel']							= 'cancella';
$LNG['bd_working']							= 'Lavorando';
$LNG['bd_build']							= 'Costruzione';
$LNG['bd_build_next_level']					= 'Amplia al livello ';
$LNG['bd_tech']                             = 'Ricerca';
$LNG['bd_tech_next_level']                  = 'Ricerca il livello ';
$LNG['bd_add_to_list']						= 'Aggiungi alla coda ';
$LNG['bd_no_more_fields']					= 'Spazi del pianeta finiti!';
$LNG['bd_remaining']						= 'Rimanente:';
$LNG['bd_lab_required']						= 'Devi prima costruire un laboratorio di ricerca!';
$LNG['bd_building_lab']						= 'Laboratorio di ricerca in apliamento!';
$LNG['bd_max_lvl']							= '(Max. Livello: %s)';
$LNG['bd_lvl']								= 'Livello';
$LNG['bd_research']							= 'Ricerca';
$LNG['bd_shipyard_required']				= 'Devi prima costruire il cantiere navale!';
$LNG['bd_building_shipyard']				= 'Fabbrica dei naniti o cantiere navale in ampliamento!';
$LNG['bd_available']						= 'Disponibile: ';
$LNG['bd_build_ships']						= 'Costruzioni';
$LNG['bd_protection_shield_only_one']		= 'Soltanto uno pu&ograve essere costruito!';
$LNG['bd_build_defenses']					= 'Costruziono';
$LNG['bd_actual_production']				= 'Posizione attuale:';
$LNG['bd_completed']						= 'Completato';
$LNG['bd_operating']						= 'In corso';
$LNG['bd_continue']							= 'Continua';
$LNG['bd_price_for_destroy']				= 'Costo per distruggere:';
$LNG['bd_ready']							= 'Pronto';
$LNG['bd_finished']							= 'Finito';
$LNG['bd_maxlevel']							= 'Livello massimo';
$LNG['bd_on']								= 'on';
$LNG['bd_max_builds']						= 'Ordini di costruzioni massimi [%d]';
$LNG['bd_next_level']						= 'Prossimo livello:';
$LNG['bd_need_engine']						= 'Richiede  <font color="#FF0000">%s</font> %s in pi&ugrave';
$LNG['bd_more_engine']						= 'Produce <font color="#00FF00">%s</font> %s ni pi&ugrave';
$LNG['bd_jump_gate_action']					= 'Salta in';
$LNG['bd_cancel_warning']					= 'Lo smantellamento restituisce il 60% delle risorse!';
$LNG['bd_cancel_send']						= 'Cancella - Selezionato';
$LNG['bd_destroy_time'] 					= 'Tempo';
$LNG['bd_max_ships']                        = 'Max';
$LNG['bd_max_ships_long']                   = 'Massime unit&agrave costruibili';
$LNG['sys_notenough_money'] 				= 'In %s <a href="?page=buildings&amp;cp=%d&amp;re=0">[%d:%d:%d]</a> hai insufficenti risorse per costruire %s. <br> Ora hai, %s %s , %s %s and %s %s. <br> tuttavia è necessario %s %s , %s %s and %s %s.';
$LNG['sys_nomore_level'] 					= 'Stai provando a distruggere un edificio inesistente( %s ).';
$LNG['sys_buildlist'] 						= 'Coda di costruzioni';
$LNG['sys_techlist'] 						= 'Lista di ricerche';
$LNG['sys_buildlist_fail'] 					= 'Lista di costruzioni fallita';

//----------------------------------------------------------------------------//
//RESOURCES
$LNG['rs_amount']							= 'Quantit/agrave';
$LNG['rs_lvl']								= 'livello';
$LNG['rs_production_on_planet']				= 'Risorse prodotte nel paineta "%s"';
$LNG['rs_basic_income']						= 'Produzione di base';
$LNG['rs_storage_capacity']					= 'Capacità di immagazzinamento';
$LNG['rs_calculate']						= 'calcola';
$LNG['rs_sum']								= 'Totale:';
$LNG['rs_daily']							= 'Risorse per giorno:';
$LNG['rs_weekly']							= 'Risorse per settimana:';
$LNG['rs_ress_bonus']						= 'Bonus(Officiali-Materia oscura):';

//----------------------------------------------------------------------------//
//OFFICIERS
$LNG['of_recruit']							= 'Recluta';
$LNG['of_max_lvl']							= 'Max. Livello';
$LNG['of_offi']								= 'Officiali';
$LNG['of_lvl']								= 'Livello';
$LNG['of_dm_trade']							= '%s - Store';
$LNG['of_still']							= 'still';
$LNG['of_active']							= 'attiva';
$LNG['of_update']							= 'aggiorna';

//----------------------------------------------------------------------------//
//TRADER
$LNG['tr_empty_darkmatter']					= 'Non hai abbastanza %s!';
$LNG['tr_cost_dm_trader']					= 'Costo commerciante %s %s!';
$LNG['tr_only_positive_numbers']			= 'Solo numeri positivi!';
$LNG['tr_not_enought_metal']				= 'Metallo insufficente.';
$LNG['tr_not_enought_crystal']				= 'Cristallo insufficente.';
$LNG['tr_not_enought_deuterium']			= 'Deuterio insufficente';
$LNG['tr_exchange_done']					= 'Scambio eseguito con successo';
$LNG['tr_call_trader']						= 'Contatta commerciante';
$LNG['tr_call_trader_who_buys']				= 'Contatta il commerciante che acquista';
$LNG['tr_call_trader_submit']				= 'Contatta il commerciante subito';
$LNG['tr_exchange_quota']					= 'Il tasso di scambio &egrave 2/1/0.5';
$LNG['tr_sell_metal']						= 'Vendi metallo';
$LNG['tr_sell_crystal']						= 'Vendi cristallo';
$LNG['tr_sell_deuterium']					= 'Vendi deuterio';
$LNG['tr_resource']							= 'Risorsa';
$LNG['tr_amount']							= 'Quantit&agrave';
$LNG['tr_quota_exchange']					= 'Tasso di scambio';
$LNG['tr_exchange']							= 'Scambia';

//----------------------------------------------------------------------------//
//TECHTREE
$LNG['tt_requirements']						= 'Requisiti';
$LNG['tt_lvl']								= 'Livello ';

//----------------------------------------------------------------------------//
//INFOS
$LNG['in_jump_gate_done']					= 'The jump gate was used, the next jump can be made in: ';
$LNG['in_jump_gate_error_data']				= 'Errore, dati per il salto incorretti!';
$LNG['in_jump_gate_not_ready_target']		= 'The jump gate is not ready on the finish moon, will be ready in ';
$LNG['in_jump_gate_doesnt_have_one']		= 'You have no jump gate on the moon!';
$LNG['in_jump_gate_already_used']			= 'The jump gate was used, time to recharge its energy: ';
$LNG['in_jump_gate_available']				= 'available';
$LNG['in_rf_again']    						= 'Fuoco rapido contro';
$LNG['in_rf_from']     						= 'Fuoco rapido da';
$LNG['in_level']       						= 'Livello';
$LNG['in_prod_p_hour'] 						= 'produzione/all\'ora';
$LNG['in_difference']  						= 'Differenza';
$LNG['in_used_energy'] 						= 'Consumo d\'energia';
$LNG['in_prod_energy'] 						= 'Produzione d\'energia';
$LNG['in_used_deuter']						= 'Consumo di deuterio';
$LNG['in_range']       						= 'Campo portata del sensore';
$LNG['in_title_head']  						= 'Informazioni di';
$LNG['in_name']        						= 'Nome';
$LNG['in_struct_pt']   						= 'Integrità strutturale';
$LNG['in_shield_pt']   						= 'Forza dello scudo';
$LNG['in_attack_pt']   						= 'Attacco dello scudo';
$LNG['in_capacity']    						= 'Capacità deicargo';
$LNG['in_units']       						= 'unit&agrave';
$LNG['in_base_speed'] 						= 'Velocità base';
$LNG['in_consumption'] 						= 'Consumo di carburante (Deuterio)';
$LNG['in_jump_gate_start_moon']				= 'Comincia luna';
$LNG['in_jump_gate_finish_moon']			= 'Finisci luna';
$LNG['in_jump_gate_select_ships']			= 'Use Jump Gate: numero di navi';
$LNG['in_jump_gate_wait_time']				= 'Nuovo uso possibile: ';
$LNG['in_jump_gate_jump']					= 'Salta';
$LNG['in_destroy']     						= 'Distruggi:';
$LNG['in_needed']      						= 'Requisiti';
$LNG['in_dest_durati'] 						= 'Tempo di distruzione';
$LNG['in_missilestype']   					= 'Tipo di missili';
$LNG['in_missilesamount']    				= 'Quantità di missili disponibili';

//----------------------------------------------------------------------------//
//MESSAGES
$LNG['mg_type'][0]    						= 'Report di spionaggi';
$LNG['mg_type'][1]    						= 'Messaggi dai giocatori';
$LNG['mg_type'][2]   						= 'Messaggi circolari dell\'alleanza';
$LNG['mg_type'][3]    						= 'Rapporti di combattimento';
$LNG['mg_type'][4]    						= 'Messaggi di sistema';
$LNG['mg_type'][5]    						= 'Report di trasporti';
$LNG['mg_type'][15]   						= 'Report di spedizioni';
$LNG['mg_type'][50]							= 'News di gioco';
$LNG['mg_type'][99]   						= 'Rapporti di costruzione';
$LNG['mg_type'][100]						= 'Guarda tutti i messaggi';
$LNG['mg_type'][999]						= 'In uscita';
$LNG['mg_no_subject']						= 'Nessun soggetto';
$LNG['mg_no_text']							= 'Nessun testo';
$LNG['mg_msg_sended']						= 'Messaggio inviato!';
$LNG['mg_delete_marked']					= 'Cancella messaggi selezionati';
$LNG['mg_delete_type_all']					= 'Cancella tutti i messaggi di questo tipo';
$LNG['mg_delete_unmarked']					= 'Cancella tutti i messaggi non selezionati';
$LNG['mg_delete_all']						= 'Cancella tutti i messaggi';
$LNG['mg_show_only_header_spy_reports']		= 'Mostra solo le intestazioni dei rapporti di spionaggio';
$LNG['mg_action']							= 'Azione';
$LNG['mg_date']								= 'Data';
$LNG['mg_from']								= 'da';
$LNG['mg_to']								= 'a';
$LNG['mg_subject']							= 'soggetto';
$LNG['mg_confirm_delete']					= 'Conferma';
$LNG['mg_message_title']					= 'Messagi';
$LNG['mg_message_type']						= 'Tipo di messaggio';
$LNG['mg_total']							= 'Totale';
$LNG['mg_game_operators']					= 'Game operators';
$LNG['mg_error']							= 'Destinatario non trovato!';
$LNG['mg_overview']							= 'Riepilogo';
$LNG['mg_send_new']							= 'Scrivi un messaggio';
$LNG['mg_send_to']							= 'Destinatario';
$LNG['mg_message']							= 'Messaggio';
$LNG['mg_characters']						= 'Caratteri';
$LNG['mg_send']								= 'Invia';
$LNG['mg_game_message']						= 'Messaggi di sistema';
$LNG['mg_message_send']						= 'Messaggio inviato!';
$LNG['mg_empty_text']						= 'Inserisci il testo';
$LNG['mg_answer_to']						= 'Rispondi a:';

//----------------------------------------------------------------------------//
//ALLIANCE

$LNG['al_not_exists']                       = 'L\'alleanza non esiste.';
$LNG['al_newname_alphanum']					= 'Il nome dell\'alleanza e la data possono essere costituiti solo da caratteri alfanumerici.';
$LNG['al_newname_no_space']					= 'Il nome dell\'alleanza e la data non possono contenere spazi.';
$LNG['al_description_message'] 				= 'Messaggio di descrizione dell\'alleanza';
$LNG['al_web_text']							= 'Homepage dell\'alleanza';
$LNG['al_request'] 							= 'Richiesta';
$LNG['al_click_to_send_request'] 			= 'Clicca qui per far richiesta all\'alleanza.';
$LNG['al_tag_required'] 					= 'Tag dell\'alleanza mancante.';
$LNG['al_name_required'] 					= 'Nome dell\'alleanza mancante.';
$LNG['al_already_exists'] 					= 'L\'alleanza %s è già esistente.';
$LNG['al_created'] 							= 'L\'alleanza %s &egrave stata creata!';
$LNG['al_continue'] 						= 'continua';
$LNG['al_alliance_closed'] 					= 'Questa alleanza è chiusa e non acectta nuovi giocatori.';
$LNG['al_request_confirmation_message']		= 'L\'alleanza ricever&agrave la richiesta di entrata. <br><a href="?page=alliance">indietro</a>';
$LNG['al_default_request_text']				= 'I leaders dell\'alleanza non hanno impostato nessun messaggio predefinito o l\'alleanza non ha requisiti.';
$LNG['al_write_request'] 					= 'Scrivi un messaggio per la richiesta all\'alleanza %s';
$LNG['al_request_deleted'] 					= 'Hai eliminao la richiesta. <br> Ora puoi creare o fare richiesta a un\'altra alleanza.';
$LNG['al_request_wait_message'] 			= 'Hai gi&agrave richiesto l\'entrata nell\'alleanza %s <br>';
$LNG['al_delete_request'] 					= 'Elimina richiesta';
$LNG['al_founder_cant_leave_alliance'] 		= 'Il founder non pu&ograve abbandonare l\'alleanza.';
$LNG['al_leave_sucess'] 					= 'Hai lasciato l\'alleanza %s con successo.';
$LNG['al_do_you_really_want_to_go_out'] 	= 'Vuoi veramemte lasciare l\'alleanza %s ?';
$LNG['al_go_out_yes'] 						= 'Si';
$LNG['al_go_out_no'] 						= 'No';
$LNG['al_close_ally'] 						= 'Vuoi veramente sciogliere l\'alleanza?';
$LNG['al_kick_player']						= 'Vuoi veramente cacciare il giocatore %s dall\'alleanza?';
$LNG['al_circular_sended'] 					= "Messaggio circolare inviato. I segueni giocaotori riceveranno il messaggio:";
$LNG['al_all_players'] 						= 'Tutti i giocatori';
$LNG['al_no_ranks_defined'] 				= 'Nessun grado definito.'; 
$LNG['al_request_text']						= 'Testo di richiesta per entrare nell\'alleanza';
$LNG['al_inside_text']						= 'Pagina interna';
$LNG['al_outside_text']						= 'Pagina esterna';
$LNG['al_transfer_alliance']				= 'Trasferisci l\'alleanza';
$LNG['al_disolve_alliance']					= 'Sciogli l\'alleanza';
$LNG['al_founder_rank_text']				= 'Founder';
$LNG['al_new_member_rank_text']				= 'New entry';
$LNG['al_acept_request']					= 'Accetta';
$LNG['al_you_was_acceted']					= 'Hai accettato in ';
$LNG['al_hi_the_alliance']					= 'Ciao!<br>l\'alleanza <b>';
$LNG['al_has_accepted']						= '</b> ha accettato la tua richiesta.<br>Messaggio dal leader: <br>';
$LNG['al_decline_request']					= 'Rifiuta';
$LNG['al_you_was_declined']					= 'L\'alleanza  ';
$LNG['al_has_declined']						= '</b> ha rifiutato la tua richiesta!<br>Messaggio dal leader : <br>';
$LNG['al_no_requests']						= 'Nessuna richiesta';
$LNG['al_request_from']						= 'Richiesta da "%s"';
$LNG['al_no_request_pending']				= 'Sono presenti %d richieste';
$LNG['al_name']								= 'nome';
$LNG['al_new_name']							= 'Nuovo nome (3-30 caratteri):';
$LNG['al_tag']								= 'tag';
$LNG['al_new_tag']							= 'Nuovo tag (3-8 caratteri):';
$LNG['al_user_list']						= 'Lista dei membri';
$LNG['al_users_list']						= 'Lista dei membri (giocatore: %d)';
$LNG['al_manage_alliance']					= 'amministra alleanza';
$LNG['al_send_circular_message']			= 'Invia un messaggio circolare';
$LNG['al_circular_front_text']				= 'Il giocatore %s scrive il seguente messaggio ciroclare:';
$LNG['al_new_requests']						= '%d nuova/e richiesta/e';
$LNG['al_goto_chat']						= 'Vai alla chat dell\'alleanza';
$LNG['al_save']								= 'Salva';
$LNG['al_dlte']								= 'Cancella';
$LNG['al_rank_name']						= 'Nome del grado';
$LNG['al_ok']								= 'OK';
$LNG['al_num']								= 'ID';
$LNG['al_member']							= 'Nome';
$LNG['al_request_from_user']				= 'Richiesta dal giocatore';
$LNG['al_message']							= 'Messaggio';
$LNG['al_position']							= 'Grado';
$LNG['al_points']							= 'Punti';
$LNG['al_coords']							= 'Coordinate';
$LNG['al_member_since']						= 'In alelanza dal';
$LNG['al_estate']							= 'Online';
$LNG['al_back']								= 'Indietro';
$LNG['al_actions']							= 'Azioni';
$LNG['al_change_title']						= 'Cambia';
$LNG['al_the_alliance']						= 'dell\'alleanza';
$LNG['al_change_submit']					= 'Cambia';
$LNG['al_reply_to_request']					= 'Rispondi alla richiesta';
$LNG['al_reason']							= 'Motivo';
$LNG['al_characters']						= 'caratteri';
$LNG['al_request_list']						= 'Lista delle richieste';
$LNG['al_candidate']						= 'Nome';
$LNG['al_request_date']						= 'Data';
$LNG['al_transfer_alliance']				= 'Trasferisci l\'alleanza?';
$LNG['al_transfer_to']						= 'Trasferisci in';
$LNG['al_transfer_submit']					= 'Esegui';
$LNG['al_ally_information']					= 'Informazioni dell\'alleanza';
$LNG['al_ally_info_tag']					= 'Tag';
$LNG['al_ally_info_name']					= 'Nome';
$LNG['al_ally_info_members']				= 'Membri';
$LNG['al_your_request_title']				= 'La ua richiesta';
$LNG['al_applyform_send']					= 'invia';
$LNG['al_applyform_reload']					= 'Ricarica';
$LNG['al_circular_send_ciruclar']			= 'Invia un messaggio ciroclare';
$LNG['al_circular_alliance']               = 'Alleanza ';
$LNG['al_receiver']							= 'Destinatari';
$LNG['al_circular_send_submit']				= 'Invia';
$LNG['al_circular_reset']					= 'Reset';
$LNG['al_alliance']							= 'Alleanze ';
$LNG['al_alliance_make']					= 'Crea un\'alleanza';
$LNG['al_alliance_search']					= 'Cerca un\'alleanza';
$LNG['al_your_ally']						= 'La tua alleanza';
$LNG['al_rank']								= 'Grado';
$LNG['al_web_site']							= 'Homepage';
$LNG['al_inside_section']					= 'Pagina interna';
$LNG['al_make_alliance']					= 'Crea un\'alleanza';
$LNG['al_make_ally_tag_required']			= 'Tag dell\'alleanza (3-8 caratteri)';
$LNG['al_make_ally_name_required']			= 'Nome dell\'alleanza (3-30 caratteri)';
$LNG['al_make_submit']						= 'Crea';
$LNG['al_find_alliances']					= 'Cerca per alleanze';
$LNG['al_find_text']						= 'Cerca per';
$LNG['al_find_no_alliances']				= 'Alleanza non trovata!';
$LNG['al_find_submit']						= 'Cerca';
$LNG['al_manage_ranks']						= 'Amministra gradi';
$LNG['al_manage_members']					= 'Amministra membri';
$LNG['al_manage_change_tag']				= 'Cambia la tag dell\'alleanza';
$LNG['al_manage_change_name']				= 'Cambia il nome dell\'alleanza';
$LNG['al_texts']							= 'Amministra testo';
$LNG['al_manage_options']					= 'Opzioni';
$LNG['al_manage_image']						= 'Logo dell\'alleanza';
$LNG['al_manage_requests']					= 'Richieste';
$LNG['al_manage_diplo']                    	= 'Diplomazia dell\'alleanza';
$LNG['al_requests_not_allowed']				= 'non sono possibili(alleanza chiusa)';
$LNG['al_requests_allowed']					= 'sono possibili(alleanza aperta)';
$LNG['al_manage_founder_rank']				= 'Grado del founder';
$LNG['al_configura_ranks']					= 'Amministra gradi';
$LNG['al_create_new_rank']					= 'Crea un nuovo grado';
$LNG['al_rank_name']						= 'Nome';
$LNG['al_create']							= 'Crea';
$LNG['al_legend']							= 'Descrizione';
$LNG['al_legend_disolve_alliance']			= 'Sciogli l\'alleanza';
$LNG['al_legend_kick_users']				= 'Caccia membro';
$LNG['al_legend_see_requests']				= 'Mostra richieste';
$LNG['al_legend_see_users_list']			= 'Mostra la lista membri';
$LNG['al_legend_check_requests']			= 'Amministra le richieste';
$LNG['al_legend_admin_alliance']			= 'Amministra alleanza';
$LNG['al_legend_see_connected_users']		= 'Mostra gli utenti online';
$LNG['al_legend_create_circular']			= 'Scrivi un messaggio circolare';
$LNG['al_legend_right_hand']				= '"Mano destra" (necessario per trasferire il grado di founder)';
$LNG['al_requests']							= 'Richieste';
$LNG['al_circular_message']					= 'Messaggio circolare';
$LNG['al_leave_alliance']					= 'Lascia l\'alleanza';
$LNG['al_Gesamtk']     						= 'Statistiche';
$LNG['al_Erfolg']       					= 'Voli Odds';
$LNG['al_Siege']        					= 'Vincitore';
$LNG['al_Drawp']        					= 'Pareggio';
$LNG['al_Loosi']        					= 'Perdente';
$LNG['al_KGesamt']      					= 'Total fights';
$LNG['al_Allyquote']    					= 'Statistiche dell\'alleanza';
$LNG['al_Quote']        					= 'Vittoria offerta';
$LNG['al_unitsshut']    					= 'Unit&agrave distrutte';
$LNG['al_unitsloos']    					= 'Unit&agrave perse';
$LNG['al_tfmetall']     					= 'Detriti di metallo totali';
$LNG['al_tfkristall']   					= 'Detriti di cristallo totali';
$LNG['al_view_stats']						= 'Pubblicare i record delle battaglie in pubblico?';
$LNG['al_view_diplo']                      	= 'Pubblicare la diplomazia dell\'alleanza??';
$LNG['al_memberlist_min']					= 'min';
$LNG['al_memberlist_on']					= 'Online';
$LNG['al_memberlist_off']					= 'Offline';
$LNG['al_diplo']                            = 'Diplomaczia';
$LNG['al_diplo_level'][0]                   = 'Ala';
$LNG['al_diplo_level'][1]                   = 'Alleanza ';
$LNG['al_diplo_level'][2]                   = 'Commercio dell\'alleanza';
$LNG['al_diplo_level'][3]                   = 'Patto di non aggressione';
$LNG['al_diplo_level'][4]                   = 'Guerra';
$LNG['al_diplo_no_entry']                   = '- Nessun patto esistente -';
$LNG['al_diplo_no_accept']                  = '- Nessuna richiesta disponibile -';
$LNG['al_diplo_accept']                    	= 'Richieste ricevute';
$LNG['al_diplo_accept_send']                = 'Richieste inviate';
$LNG['al_diplo_create']                    	= 'Stipula un nuovo patto.';
$LNG['al_diplo_create_done']                = 'Patto creato con successo.';
$LNG['al_diplo_ally']                       = 'Alleanza ';
$LNG['al_diplo_level_des']                  = 'Arca dell\'alleanza';
$LNG['al_diplo_text']                       = 'Teso domanda/Giustificazione';
$LNG['al_diplo_accept_yes']                	= 'Patto firmato.';
$LNG['al_diplo_accept_yes_mes']            	= 'Il patto di %s è stato firmato tra le alleanze %s e %s!';
$LNG['al_diplo_accept_yes_confirm']			= 'Vuoi veramente accettare il patto?';
$LNG['al_diplo_accept_no']                  = 'Patto rifiutato.';
$LNG['al_diplo_accept_no_mes']              = 'Il patto di %s tra le alleanze %s e %s è stato rifiutato!';
$LNG['al_diplo_accept_no_confirm']			= 'Vuoi veramente eliminare il patto? ';
$LNG['al_diplo_delete']                    	= 'Abolisci patto.';
$LNG['al_diplo_delete_mes']                	= 'Il patto di %s tra le alleanze %s e %s  è stato abolito';
$LNG['al_diplo_confirm_delete']           	= 'Vuoi veramente cancellare il patto?';
$LNG['al_diplo_ground']                    	= 'Ragione:';
$LNG['al_diplo_ask']                        = 'Covenant Enquiry';
$LNG['al_diplo_ask_mes']                    = 'C\'&egrave una richiesta di patto (%s) tra le alleanze %s e %s.<br>l\'alleanza: %s';
$LNG['al_diplo_war']                        = 'Dichiarazione di guerra';
$LNG['al_diplo_war_mes']                    = 'L\'alleanza %s ha all\'alleanza %s solo questa %s spiegato. <br>Motivo:<br>%s<br><br>Informazioni: La guerra è valida tra 24 ore. Il bashing decade tra 24 ore. <br>Troverai maggiorni informaizoni nel <a href="index.php?page=rules" target="_blank">Regolamento</a>.';
$LNG['al_leave_ally']						= 'Sei sciuro di lasciare l\'alleanza?';
$LNG['al_default_leader_name']				= 'Leader';

//----------------------------------------------------------------------------//
//BUDDY
$LNG['bu_request_exists']					= 'E\' già esistente una richiesta per questo player!';
$LNG['bu_cannot_request_yourself']			= 'Non puoi chiedere a te stesso di diventare amico!';
$LNG['bu_request_message']					= 'Messaggio di richiesta';
$LNG['bu_player']							= 'Giocatore';
$LNG['bu_request_text']						= 'Messaggio di richiesta';
$LNG['bu_characters']						= 'Caratteri';
$LNG['bu_back']								= 'Indietro';
$LNG['bu_send']								= 'Invia';
$LNG['bu_cancel_request']					= 'Cancella richiesta';
$LNG['bu_accept']							= 'Accetta';
$LNG['bu_decline']							= 'Rifiuta';
$LNG['bu_connected']						= 'Connesso';
$LNG['bu_minutes']							= ' min';
$LNG['bu_disconnected']						= 'Offline';
$LNG['bu_online']							= 'Online';
$LNG['bu_buddy_list']						= 'Lista amici';
$LNG['bu_requests']							= 'Richieste';
$LNG['bu_alliance']							= 'Alleanza';
$LNG['bu_coords']							= 'Coordinate';
$LNG['bu_text']								= 'Testo';
$LNG['bu_action']							= 'Azione';
$LNG['bu_my_requests']						= 'Mie richieste';
$LNG['bu_partners']							= 'Amici';
$LNG['bu_delete']							= 'cancella';
$LNG['bu_no_request']						= 'nessuna richiesta!';
$LNG['bu_no_buddys']						= 'Nessun amico fin\'ora!';
$LNG['bu_request_send']						= 'Richiesta inviata!';

//----------------------------------------------------------------------------//
//NOTES
$LNG['nt_important']						= 'Importante';
$LNG['nt_normal']							= 'Normale';
$LNG['nt_unimportant']						= 'Irrilevante';
$LNG['nt_create_note']						= 'Crea nota';
$LNG['nt_you_dont_have_notes']				= 'Nessuna nota disponibile';
$LNG['nt_notes']							= 'Note';
$LNG['nt_create_new_note']					= 'Crea una nuova nota';
$LNG['nt_edit_note']						= 'Modifica nota';
$LNG['nt_date_note']						= 'Data';
$LNG['nt_subject_note']						= 'Soggetto';
$LNG['nt_size_note']						= 'Dimensione';
$LNG['nt_dlte_note']						= 'Elimina';
$LNG['nt_priority']							= 'Priorit&agrave';
$LNG['nt_note']								= 'Nota';
$LNG['nt_characters']						= 'caratteri';
$LNG['nt_back']								= 'Indietro';
$LNG['nt_reset']							= 'Reset';
$LNG['nt_save']								= 'Salva';
$LNG['nt_no_title']							= 'Nessun titolo';
$LNG['nt_no_text']							= 'Nessun testo disponibile';

//----------------------------------------------------------------------------//
//STATISTICS
$LNG['st_player']							= 'Giocatore';
$LNG['st_alliance']							= 'Alleanza';
$LNG['st_points']							= 'Punti';
$LNG['st_fleets']							= 'Flotta';
$LNG['st_researh']							= 'Ricerca';
$LNG['st_buildings']						= 'Costruzioni';
$LNG['st_defenses']							= 'Difesa';
$LNG['st_position']							= 'Posizione';
$LNG['st_members']							= 'Membri';
$LNG['st_per_member']						= 'Per membro';
$LNG['st_statistics']						= 'Classifica';
$LNG['st_updated']							= 'Aggiornato';
$LNG['st_show']								= 'Mostra';
$LNG['st_per']								= 'per';
$LNG['st_in_the_positions']					= 'in posizione';
$LNG['st_write_message']					= 'Messaggio privato';

//----------------------------------------------------------------------------//
//SEARCH
$LNG['sh_tag']								= 'Tag';
$LNG['sh_name']								= 'Nome';
$LNG['sh_members']							= 'Membri';
$LNG['sh_points']							= 'Punti';
$LNG['sh_search_in_the_universe']			= 'Cerca nell\'universo';
$LNG['sh_player_name']						= 'Nome del player';
$LNG['sh_planet_name']						= 'Nome del pianeta';
$LNG['sh_alliance_tag']						= 'tag dell\'alleanza';
$LNG['sh_alliance_name']					= 'Nome del1\'alleanza';
$LNG['sh_search']							= 'cerca';
$LNG['sh_write_message']					= 'Messaggio privato';
$LNG['sh_buddy_request']					= 'Richiesta d\'amicizia';
$LNG['sh_alliance']							= 'Alleanza';
$LNG['sh_planet']							= 'Pianeta';
$LNG['sh_coords']							= 'Coordinate';
$LNG['sh_position']							= 'Posizione';

//----------------------------------------------------------------------------//
//OPTIONS
$LNG['op_cant_activate_vacation_mode']		= 'Impossibile attivare la modalit&agrave vacanza: costruzioni in corso o flotte in movimeno.';
$LNG['op_password_changed']					= 'La password &egrave stata cambiata,<br><a href="index.php" target="_top">indietro</a>';
$LNG['op_username_changed']					= 'Usarname cambiato,<br><a href="index.php" target="_top">indietro</a>';
$LNG['op_options_changed']					= 'Cambiamenti salvati.<br><a href="game.php?page=options">Indietro</a>';
$LNG['op_vacation_mode_active_message']		= 'Modalità vacanza attivata. Non puoi disattivarla prima di: ';
$LNG['op_end_vacation_mode']				= 'FModalità vacanza terminata.';
$LNG['op_save_changes']						= 'Salva cambiamenti';
$LNG['op_admin_title_options']				= 'Opzioni disponibili per essere amministrate';
$LNG['op_admin_planets_protection']			= 'Protezione dei pianeti';
$LNG['op_user_data']						= 'Data dell\'utente';
$LNG['op_username']							= 'Username';
$LNG['op_old_pass']							= 'Password vecchia';
$LNG['op_new_pass']							= 'Nuova password (min. 8 caratteri)';
$LNG['op_repeat_new_pass']					= 'Nuova password (ripeti)';
$LNG['op_email_adress']						= 'Indirizzo e-mail';
$LNG['op_permanent_email_adress']			= 'Indirizzo e-mail permanente';
$LNG['op_general_settings']					= 'Opzioni generali';
$LNG['op_sort_planets_by']					= 'Ordina pianeti per:';
$LNG['op_sort_kind']						= 'Scegli sequenza:';
$LNG['op_lang']								= 'Lingua';
$LNG['op_skin_example']						= 'Skin path (z.B. C:/SG/skins/)';
$LNG['op_show_skin']						= 'Mostra skin';
$LNG['op_deactivate_ipcheck']				= 'Disattiva controllo IP';
$LNG['op_galaxy_settings']					= 'Opzioni di visualizzazione galassia';
$LNG['op_spy_probes_number']				= 'Numero di sonde spie predefinite';
$LNG['op_toolt_data']						= 'Tools d\'informazione';
$LNG['op_seconds']							= 'secondi';
$LNG['op_max_fleets_messages']				= 'Messaggi massimi di flotta';
$LNG['op_show_planetmenu']					= 'Menu di visualizzazione pianeta';
$LNG['op_shortcut']							= 'Scorciatoie';
$LNG['op_show']								= 'Mostra';
$LNG['op_spy']								= 'Spia';
$LNG['op_write_message']					= 'Scrivi un messaggio';
$LNG['op_add_to_buddy_list']				= 'Aggiungi alla lista amici';
$LNG['op_missile_attack']					= 'Attacco missilistico';
$LNG['op_send_report']						= 'Invia report';
$LNG['op_vacation_delete_mode']				= 'Modalit&agrave/Cancella account';
$LNG['op_activate_vacation_mode']			= 'Atttiva modalit&agrave vacanza';
$LNG['op_dlte_account']						= 'Cancella account';
$LNG['op_email_adress_descrip']				= 'Puoi cambiare indirizzo e-mail temporaneo. La nuova e-mail diventerà l\'email permanente dopo 7 giorni se non sono stati effettuati cambiamenti';
$LNG['op_deactivate_ipcheck_descrip']		= 'Il controllo IP significa che avviene automaticamente il logout quando l\'indirizzo IP cambia oppure si accede all\'account da due postazioni contemporaneamente. Disattivarlo è soltanto a tuo rischio. Se lo vuoi disattivare, contatta prima i Game Operator aprendo un ticket, onde evitare malintesi. Grazie !';
$LNG['op_spy_probes_number_descrip']		= 'Il numero predefinito di spie rappresenta il numero predefinito di spie che si inviano quando si invia una spiata a un pianeta dalla visuale galassia.';
$LNG['op_activate_vacation_mode_descrip']	= 'La modalit&agrave vacanza ti protegge nei periodi in cui non puoi connetterti. Pu&ograve essere attivata soltanto se non ci sono costruzioni, flotte o difesa in costruzioni, non ci sono ricerche attive, e non ci sono flotte in movimento. Quando %egrave attivata, tu sei protetta dagli attacchi. Gli attacchi inviati prima di attivarla, andranno a buon fine. Durante la modalit&agrave vacanza, le produzioni saranno portate a zero e per ricominciare a produrre bisogner&agrave riportare la produzione manualmente a 100& dalla schermata Risorse. prima di poterla disattuvare, devono passare minimo 2 giorni.';
$LNG['op_dlte_account_descrip']				= 'Se tu attivi questo box, il tuo account verr&agrave cancellato tra 7 giorni.';
$LNG['op_need_pass_mail']					= 'Per cambiare indirizzo e-mail, dovrai inserire la tua password!';
$LNG['op_not_vaild_mail']					= 'Hai inserito un\'e-mail non valida!';
$LNG['op_change_mail_exist']				= 'L\'email inserita %s &egrave gi&agrave in uso!';
$LNG['op_sort_normal']						= 'Ordine di creazione';
$LNG['op_sort_koords']						= 'Coordinate';
$LNG['op_sort_abc']							= 'Alpabetico';
$LNG['op_sort_up']							= 'Ascendente';
$LNG['op_sort_down']						= 'Descendente';
$LNG['op_user_name_no_alphanumeric']		= 'L\'usarbname pu&ograve contenere solo caratteri alfanumerici!';
$LNG['op_change_name_pro_week']				= 'Puoi cambiare usarname soltato una volta per settimana';
$LNG['op_change_name_exist']				= 'Il nome %s &egrave gi&agrave esistente';
$LNG['op_active_build_messages']			= 'News coda di costruzioni';
$LNG['op_small_storage']                    = 'Shorten storage numbers shown';

//----------------------------------------------------------------------------//
//BANNED
$LNG['bn_no_players_banned']				= 'Nessun giocatore bannato';
$LNG['bn_exists']							= 'Totale ';
$LNG['bn_players_banned']					= ' giocatori bannati';
$LNG['bn_players_banned_list']				= 'Lista dei giocatori bannati';
$LNG['bn_player']							= 'Giocatori';
$LNG['bn_reason']							= 'Ragione';
$LNG['bn_from']								= 'Dal';
$LNG['bn_until']							= 'Fino a';
$LNG['bn_by']								= 'Per';
$LNG['bn_writemail']						= 'Scrivi una mail a %s';

//----------------------------------------------------------------------------//
//class.CheckSession.php

$LNG['css_account_banned_message']			= 'Il tuo account è stato bannato! ';
$LNG['css_account_banned_expire']			= 'Sei stato bannato fino al %s <br><a href="./index.php?page=pranger">Lista dei ban</a>';
$LNG['css_goto_homeside']					= '<a href="./index.php">Pagina iniziale</a>';
$LNG['css_server_maintrace']				= 'Server Maintrace<br><br>Play unanimously at present. <br><br>Reason: %s';

//----------------------------------------------------------------------------//
//class.debug.php
$LNG['cdg_mysql_not_available']				= 'Connessione impossibile al database<br>Perfavore, riprova più tardi.<br><br>Ci scusiamo per il disagio.';
$LNG['cdg_error_message']					= 'Errore. Contatta l\'amministratore: ';
$LNG['cdg_fatal_error']						= 'FATAL ERROR';

//----------------------------------------------------------------------------//
//class.FlyingFleetsTable.php

$LNG['cff_no_fleet_data']					= 'Nessuna informazione delle navi';
$LNG['cff_acs_fleet']						= 'Flotta ACS';
$LNG['cff_fleet_own']						= 'Flotta';
$LNG['cff_fleet_target']					= 'Flotta';
$LNG['cff_mission_acs']						= 'A %s da %s %s %s raggiunto il %s %s %s. Missione: %s';
$LNG['cff_mission_own_0']					= 'Una delle tue %s da %s %s %s raggiunge il %s %s %s. Missione: %s';
$LNG['cff_mission_own_1']					= 'Una delle tue %s è in ritorno da %s %s %s indietro verso %s %s %s. Missione: %s';
$LNG['cff_mission_own_2']					= 'Una delle tue %s da %s %s %s è in orbita attorno a %s %s %s. Missione: %s';
$LNG['cff_mission_own_mip']					= 'Attacco missilistico (%d) da %s %s %s to %s %s %s.';
$LNG['cff_mission_own_expo_0']				= 'Una delle tue %s da %s %s %s raggiunge le coordinate %s. Missione: %s';
$LNG['cff_mission_own_expo_1']				= 'Una delle tue %s ritorna dalle coordinate %s indietro da %s %s %s. Missione: %s';
$LNG['cff_mission_own_expo_2']				= 'Una delle tue flotte %s da %s %s %s è in spedizione nelle coordinate %s. Missione: %s';
$LNG['cff_mission_own_recy_0']				= 'Una delle tue %s da %s %s %s raggiunge i detriti in %s. Missione: %s';
$LNG['cff_mission_own_recy_1']				= 'Una delle tue %s ritorna dai detriti %s indietro al pianeta %s %s %s. Missione: %s';
$LNG['cff_mission_target_bad']				= 'Una flotta ostile %s dal giocatore %s da %s %s %s raggiunge il %s %s %s. Missione: %s';
$LNG['cff_mission_target_good']				= 'Una flotta ostile %s dal giocatore %s da %s %s %s raggiunge il %s %s %s. Missione: %s';
$LNG['cff_mission_target_stay']				= 'Una flotta amica %s dal giocatore %s da %s %s %s è in orbita da %s %s %s. Missione: %s';
$LNG['cff_mission_target_mip']				= 'Attacco missilistico (%d) dal giocatore %s da %s %s %s in %s %s %s.';

//----------------------------------------------------------------------------//
// EXTRA LANGUAGE FUNCTIONS
$LNG['fcm_planet']							= 'Pianeta';
$LNG['fcm_moon']							= 'Luna';
$LNG['fcm_info']							= 'Informazione';
$LNG['fcp_colony']							= 'Colonia';
$LNG['fgp_require']							= 'Requisiti: ';
$LNG['fgf_time']							= 'Tempo di costruzione: ';
$LNG['sys_module_inactive']        	 		= 'Modulo inattivo';
$LNG['sys_refferal_from']        	 		= 'Sistema';
$LNG['sys_refferal_title']        	 		= 'Bonus per i giocatori %s';
$LNG['sys_refferal_text']					= 'I giocatori %s reclutati da te hanno ora raggiunto i punti.<br><br>Sei stato promosso a player attivo e hai ottenuto %s %s';


//----------------------------------------------------------------------------//
// CombatReport.php
$LNG['cr_lost_contact']						= 'Contatto perso con questa fltta. ';
$LNG['cr_first_round']						= '(Flotta distrutta al primo round) ';
$LNG['cr_type']								= 'Tipo';
$LNG['cr_total']							= 'Totale';
$LNG['cr_weapons']							= 'Armi';
$LNG['cr_shields']							= 'Scudo';
$LNG['cr_armor']							= 'Corrazza';
$LNG['cr_destroyed']						= 'Distrutto!';

//----------------------------------------------------------------------------//
// FleetAjax.php
$LNG['fa_not_enough_probes']				= 'Nessuna sonda disponibile';
$LNG['fa_galaxy_not_exist']					= 'Galassia inesistente';
$LNG['fa_system_not_exist']					= 'Sistema inesistente';
$LNG['fa_planet_not_exist']					= 'Pianeta inesistente';
$LNG['fa_not_enough_fuel']					= 'Non hai abbastanza carburante';
$LNG['fa_no_more_slots']					= 'Non hai abbastanza slot disponibili';
$LNG['fa_no_recyclers']						= 'Nessuna riciclatrice disponbiile';
$LNG['fa_no_fleetroom']						= 'Non hai abbsatzna cargo per il carburante';
$LNG['fa_mission_not_available']			= 'Missione non disponibile';
$LNG['fa_no_spios']							= 'Nessuna sonsa disponibile';
$LNG['fa_vacation_mode']					= 'Player selezionato in modalit&agrave vacanza';
$LNG['fa_week_player']						= 'Giocatore troppo debole';
$LNG['fa_strong_player']					= 'Giocatore troppo forte';
$LNG['fa_not_spy_yourself']					= 'Non puoi spiare te stesso!';
$LNG['fa_not_attack_yourself']				= 'Non puoi attaccare te stesso';
$LNG['fa_action_not_allowed']				= 'Azione non consentita';
$LNG['fa_vacation_mode_current']			= 'Sei in modalit&agrave vacanza';
$LNG['fa_sending']							= 'Invia';

//----------------------------------------------------------------------------//
// MissilesAjax.php
$LNG['ma_silo_level']						= 'Livello 4 del silo richiesto! ';
$LNG['ma_impulse_drive_required']			= 'Propulsore a impulso necessario';
$LNG['ma_not_send_other_galaxy']			= 'Non è possibile inviare razzi in un\'altra galassia. ';
$LNG['ma_planet_doesnt_exists']				= 'Pianeta inesistente. ';
$LNG['ma_wrong_target']						= 'Obiettivo sbagliato';
$LNG['ma_no_missiles']						= 'Nessun missile disponibilee';
$LNG['ma_add_missile_number']				= 'Aggiungi quantit/&agrave al missile! ';
$LNG['ma_misil_launcher']					= 'Lanciamissili';
$LNG['ma_small_laser']						= 'Laser leggero';
$LNG['ma_big_laser']						= 'Laser pesante';
$LNG['ma_gauss_canyon']						= 'Cannone gauss';
$LNG['ma_ionic_canyon']						= 'Cannone ionico';
$LNG['ma_buster_canyon']					= 'Cannone al plasma';
$LNG['ma_small_protection_shield']			= 'Cupola scudo';
$LNG['ma_big_protection_shield']			= 'Cupola scudo potenziata';
$LNG['ma_all']								= 'All';
$LNG['ma_missiles_sended']					= ' Missili distribuiti. Obiettivi: ';

//----------------------------------------------------------------------------//
// topkb.php
$LNG['tkb_top']                  			= 'Hall of Fame';
$LNG['tkb_gratz']                  			= 'L\'intero staff si congratula con i TOP 100 ';
$LNG['tkb_platz']                  			= 'Posto';
$LNG['tkb_owners']             				= 'Un coinvolto';
$LNG['tkb_datum']                  			= 'Data';
$LNG['tkb_units']             				= 'Unit&agrave';
$LNG['tkb_legende']               		 	= '<b>Legenda: </b>';
$LNG['tkb_gewinner']              		 	= '<b>-Vincitori-</b>';
$LNG['tkb_verlierer']              			= '<b>-Perdente-</b>';
$LNG['tkb_unentschieden']         			= '<b>-Both Weisses, undecided- </b>';
$LNG['tkb_missing']              		  	= '<br>Missione in azione: L\'account utente non esiste pi&ugrave.';

//----------------------------------------------------------------------------//
// playercard.php
$LNG['pl_overview']  						= 'Playercard';
$LNG['pl_name'] 							= 'Username';
$LNG['pl_homeplanet'] 						= 'Pianeta madre';
$LNG['pl_ally']     						= 'Alleanza';
$LNG['pl_message']    						= 'Messaggi';
$LNG['pl_buddy']        					= 'Amici';
$LNG['pl_points']      						= 'Punti';
$LNG['pl_range']         					= 'Grado';
$LNG['pl_builds']     						= 'Costruzioni';
$LNG['pl_tech']    							= 'Ricerche';
$LNG['pl_fleet']       						= 'Flotte';
$LNG['pl_def']         						= 'Difesa';
$LNG['pl_total']       						= 'Totale';
$LNG['pl_fightstats'] 						= 'Statiscitche di combattimento';
$LNG['pl_fights']     						= 'Combattimenti';
$LNG['pl_fprocent']       					= 'Quota di combattimenti ';
$LNG['pl_fightwon']  						= 'Vinti';
$LNG['pl_fightdraw']  						= 'Pareggiati';
$LNG['pl_fightlose']  						= 'Persi';
$LNG['pl_totalfight']      					= 'Totale combattimenti';
$LNG['pl_destroy']    						= '%s distrutte';
$LNG['pl_unitsshot']    					= 'Unit&agrave uccise';
$LNG['pl_unitslose']    					= 'Unit&agrave perse';
$LNG['pl_dermetal']    						= 'Metallo riciclato';
$LNG['pl_dercrystal']   					= 'Cristallo riciclato';
$LNG['pl_etc']   							= 'Ecc ';

//----------------------------------------------------------------------------//
// Support

$LNG['supp_header'] 						= 'Support system ';
$LNG['supp_header_g'] 						= 'Support Tickets';
$LNG['ticket_id'] 							= '#oggetto ';
$LNG['status'] 								= 'Stato';
$LNG['ticket_posted'] 						= 'ticket inviato';
$LNG['ticket_new'] 							= 'Nuovo Ticket';
$LNG['input_text'] 							= 'Testo:';
$LNG['answer_new'] 							= 'Nuova risposta:';
$LNG['text'] 								= 'Dettagli';
$LNG['message_a'] 							= 'Stato del messaggio:';
$LNG['sendit_a'] 							= 'Messaggio inserito. ';
$LNG['message_t'] 							= 'Stato del ticket: ';
$LNG['supp_send'] 							= 'Invia';
$LNG['sendit_t'] 							= 'Ticket inviato con successo. ';
$LNG['close_t'] 							= 'Il ticket &egrave stato chiuso. ';
$LNG['sendit_error'] 						= 'ERRORE:';
$LNG['sendit_error_msg'] 					= 'Devi compilare tutti i campi! ';
$LNG['supp_admin_system'] 					= 'Supporto del Pannello Admin';
$LNG['close_ticket'] 						= 'Chiudi ticket';
$LNG['open_ticket'] 						= 'Apri ticket';
$LNG['player'] 								= 'Nome dei giocatori';
$LNG['supp_ticket_close']					= 'Tick unanimously';
$LNG['supp_close'] 							= 'Chiuso';
$LNG['supp_open'] 							= 'Aperto';
$LNG['supp_admin_answer'] 					= 'Risposta dell\'amministratore data';
$LNG['supp_player_answer'] 					= 'Risposta del giocatore data';
$LNG['supp_player_write'] 					= '%s ha scritto %s';

//----------------------------------------------------------------------------//
// Rekorde 

$LNG['rec_build']  							= 'Costruzioni';
$LNG['rec_specb']							= 'Costruzioni speciali';
$LNG['rec_playe']  							= 'Giocatore';
$LNG['rec_defes']  							= 'Difesa';
$LNG['rec_fleet']  							= 'Navi';
$LNG['rec_techn']  							= 'Ricerca';
$LNG['rec_level']  							= 'Livello';
$LNG['rec_nbre']   							= 'Numero';
$LNG['rec_rien']   							= '-';
$LNG['rec_last_update_on']   				= 'Ultimo aggiornamento : %s';


//----------------------------------------------------------------------------//
// BattleSimulator

$LNG['bs_derbis_raport']					= "Sono necessari %s %s or %s %s per il campo detriti. ";
$LNG['bs_steal_raport']						= "Sono necessari %s %s o %s %s o %s %s per il bottino.";
$LNG['bs_names']							= "Nome della nave";
$LNG['bs_atter']							= "Attaccante";
$LNG['bs_deffer']							= "Difensore";
$LNG['bs_steal']							= "Materiali (Difensore):";
$LNG['bs_techno']							= "Tecnologia";
$LNG['bs_send']								= "Calcola";
$LNG['bs_cancel']							= "Reset";
$LNG['bs_wait']								= "Attendi la prossima simulazione per 10 secondi";
$LNG['bs_acs_slot']							= 'ACS-Slot';
$LNG['bs_add_acs_slot']						= 'Aggiungi ACS-Slot';

//----------------------------------------------------------------------------//
// Fleettrader
$LNG['ft_head']								= 'Commerciante';
$LNG['ft_count']							= 'Numero';
$LNG['ft_max']								= 'Max';
$LNG['ft_total']							= 'Totale';
$LNG['ft_charge']							= 'Commerciante gratuito';
$LNG['ft_absenden']							= 'Esegui';
$LNG['ft_empty']							= 'Non puoi usare il mercante!';

//----------------------------------------------------------------------------//
// Logout
$LNG['lo_title']						= 'Logout eseguito con successo! Grazie per aver giocato';
$LNG['lo_logout']						= 'Sessione chiusa';
$LNG['lo_redirect']						= 'Reindirizzamento';
$LNG['lo_notify']						= 'Verrai reindirizzato in <span id="seconds"> 5 </span> s';
$LNG['lo_continue']						= 'Clicca qui se non vuoi aspettare o se non vieni reindirizzato.';

?>