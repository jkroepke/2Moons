<? Php 

/ ** 
 * 2Moons 
 * Copyright (C) 2011 Slaver 
 * 
 * Bu program ücretsiz bir yazılımdır: Siz ve / dağıtabilir veya değiştirme 
 * Bu gibi tarafından yayınlanan GNU Genel Kamu Lisansı koşulları altında 
 * Free Software Foundation, ya lisansın 3 versiyonuna veya 
 * (Senin tercihine göre) sonraki herhangi bir sürümü. 
 * 
 * Bu program, yararlı olacağı ümidiyle dağıtılmaktadır 
 * Ama hiçbir GARANTİSİ YOKTUR; bile dolaylı hiçbir garanti olmaksızın 
 * UYGUNLUĞU ya BİR AMACA. bak 
 Daha fazla bilgi için * GNU General Public License. 
 * 
 Eğer GNU Genel Kamu Lisansının bir kopyasını almış olmalısınız * 
 * Bu program ile birlikte. Eğer değilse, <http://www.gnu.org/licenses/> bakın. 
 * 
 * @ Paket 2Moons 
 * @ Yazar Slaver <slaver7@gmail.com> 
 * @ Copyright 2009 Lucky <douglas@crockford.com> (XGProyecto) 
 * @ Copyright 2011 <slaver7@gmail.com> Slaver (Fork/2Moons) 
 * @ Lisansı GNU GPLv3 Lisans http://www.gnu.org/licenses/gpl.html 
 * @ Version 1.3 (2011/01/21) 
 * @ Link http://code.google.com/p/2moons/ 
 * / 

/ / SERVER GENERALLERİM 
$ LNG ['Metal'] = 'metal'; 
$ LNG ['Kristal'] = 'kristal'; 
$ LNG ['deuterium'] = 'deuterium'; 
$ = 'Dark Matter' ['Dark Matter'] LNG; 
$ LNG ['Enerji'] = 'enerji'; 
$ LNG ['mesaj'] = 'haber'; 
= 'Bir mesaj yazın' $ LNG ['write_message']; 

$ LNG ['hazır'] = 'Hazır'; 
$ LNG ['show_planetmenu'] = 'Göster / Gizle'; 

$ LNG ['type_mission'] [1] = 'Attack'; 
$ LNG ['type_mission'] [2] = Derneği saldırı '; 
$ LNG ['type_mission'] [3] = 'Ulaştırma'; 
$ LNG ['type_mission'] [4] = 'yer seçimi'; 
$ LNG ['type_mission'] = 'tut' [5]; 
$ LNG ['type_mission'] [6] = 'casusluk'; 
$ LNG ['type_mission'] [7] 'kolonize' =; 
$ LNG ['type_mission'] [8] = 'aşağılayıcı'; 
$ LNG ['type_mission'] [9] = 'yok'; 
$ LNG ['type_mission'] [11] = 'DM soruşturma'; 
$ LNG ['type_mission'] [15] = 'Sefer'; 

$ LNG ['user_level'] = array ( 
'0 '=>' Kullanıcılar ', 
'1 '=>' Moderatör ' 
'2 '=>' Operatör ' 
'3 '=>' Yönetici ', 
); 

/ / Game.php 
$ LNG ['see_you_soon'] = 'oynamak için teşekkür ederiz'; 
$ LNG ['page_doesnt_exist'] = 'yok istenen sayfa'; 


//------------------------------------------------ ----------------------------// 
/ / TopNav 
$ LNG ['tn_vacation_mode'] = 'Bu tatil modu vardır; 
$ LNG ['tn_delete_mode'] = '%, biz otomatik olarak silinir hesabınızda s'; 

//------------------------------------------------ ----------------------------// 
/ / MENU SOL 
$ LNG ['lm_overview'] = 'özet'; 
$ LNG ['lm_galaxy'] = 'Galaksi'; 
$ LNG ['lm_empire'] = 'imparatorluk'; 
$ LNG ['lm_fleet'] = 'filo'; 
$ LNG ['lm_buildings'] = 'bina'; 
$ LNG ['lm_research'] = 'Araştırma'; 
$ LNG ['lm_shipshard'] = 'tersane'; 
$ LNG ['lm_defenses'] = 'Savunma'; 
$ LNG ['lm_resources'] = 'ham'; 
$ LNG ['lm_officiers'] = 'memurları'; 
$ LNG ['lm_trader'] = 'Satıcı'; 
$ LNG ['lm_fleettrader'] = 'kırıcı'; 
$ LNG ['lm_technology'] = 'teknoloji'; 
$ LNG ['lm_messages'] = 'haber'; 
$ LNG ['lm_alliance'] = 'İttifak'; 
$ LNG ['lm_buddylist'] = 'Arkadaş Listesi'; 
$ LNG ['lm_notes'] = 'notlar'; 
$ LNG ['lm_statistics'] = 'İstatistik'; 
$ LNG ['lm_search'] = 'Arama'; 
$ LNG ['lm_options'] = 'ayarlar'; 
$ LNG ['lm_banned'] = 'boyunduruk'; 
$ LNG ['lm_contact'] = 'İletişim'; 
$ LNG ['lm_forums'] = 'Forum'; 
$ LNG ['lm_logout'] = 'Çıkış'; 
$ LNG ['lm_administration'] = 'Yönetim'; 
$ LNG ['lm_game_speed'] = 'Oyun'; 
$ LNG ['lm_fleet_speed'] = 'filo'; 
$ LNG ['lm_resources_speed'] = 'ham'; 
$ LNG ['lm_queue'] = 'kuyruk'; 
$ LNG ['lm_topkb'] of Fame = 'Hall; 
$ LNG ['lm_faq'] = 'Sıkça Sorulan Sorular'; 
$ LNG ['lm_records'] = 'Kayıt'; 
$ LNG ['lm_chat'] = 'chat'; 
$ LNG ['lm_support'] = 'Destek'; 
$ LNG ['lm_rules'] = 'Kurallar'; 
$ LNG ['lm_battlesim'] = "savaş simülatörü"; 

//------------------------------------------------ ----------------------------// 
/ / GENEL 

$ LNG ['ov_newname_alphanum'] = 'gezegen adı sadece alfanümerik karakterler içerebilir.'; 
$ LNG ['ov_newname_no_space'] = 'gezegen ismi boşluk içeremez.'; 
$ LNG ['ov_planet_abandoned'] = 'Planet başarıyla vazgeçilerek'; 
$ LNG ['ov_principal_planet_cant_abanone'] = 'Sen kendi gezegen silemezsiniz'; 
$ LNG ['ov_abandon_planet_not_possible'] = 'filo faaliyetlerine ya da koloni arasında gerçekleşecek eğer silinemez koloni'; 
$ LNG ['ov_wrong_pass'] = 'Yanlış parola. Tekrar deneyin "; 
$ LNG ['ov_have_new_message'] = 'Yeni bir mesajınız var'; 
$ LNG ['ov_have_new_messages'] = '% d yeni mesajınız var'; 
$ LNG ['ov_planetmenu'] = 'Adı Değiştir / Kaldır'; 
$ LNG ['ov_free'] = 'ücretsiz'; 
$ LNG ['ov_news'] = 'Haberler'; 
$ LNG ['ov_place'] = 'Ders'; 
$ LNG ['ov_of'] = 'dan'; 
$ LNG ['ov_planet'] = 'Planet'; 
$ LNG ['ov_server_time'] = 'Sunucu Zaman'; 
$ LNG ['ov_events'] = 'olaylar'; 
$ LNG ['ov_diameter'] = 'çapa'; 
$ LNG ['ov_distance_unit'] = 'km'; 
$ LNG ['ov_temperature'] = 'sıcaklık'; 
$ LNG ['ov_aprox'] = 'ca 'Dan; 
$ LNG ['ov_temp_unit'] = 'C'; 
$ LNG ['ov_to'] = 'için'; 
$ LNG ['ov_position'] = 'Konum'; 
$ LNG ['ov_points'] = 'puan'; 
$ LNG ['ov_security_request'] = 'gizli soru'; 
$ LNG ['ov_security_confirm'] = 'onaylayın bu gezegen'; 
'Vazgeçmek istiyorum.' $ LNG ['ov_with_pass'] =; 
$ LNG ['ov_password'] = 'şifre'; 
$ LNG ['ov_delete_planet'] = 'pes'; 
$ LNG ['ov_your_planet'] = 'Sizin Planet'; 
$ LNG ['ov_coords'] = 'Konum'; 
$ LNG ['ov_abandon_planet'] = 'vazgeçmek koloni'; 
$ LNG ['ov_planet_name'] = 'Adı'; 
$ LNG ['ov_actions'] = 'Eylemler'; 
$ LNG ['ov_planet_rename'] = 'Yeni isim ver'; 
$ LNG ['ov_planet_rename_action'] = 'Yeni isim ver'; 
$ LNG ['ov_fields'] = 'Fields'; 
$ LNG ['ov_developed_fields'] = 'tarla'; 
$ LNG ['ov_max_developed_fields'] = 'max. COS 'alanlar'; 
$ LNG ['ov_fleet'] = 'filoları'; 
$ LNG ['ov_admins_online'] = 'Yöneticiler (Online):'; 
$ LNG ['ov_no_admins_online'] = 'Şu an hiçbir üye online!'; 
$ LNG ['ov_userbanner'] = 'İstatistik afiş'; 
$ LNG ['ov_userrank_info'] = '% s (d <a href="game.php?page=statistics&range=%d"> </ a>% s% s% s%)'; 
$ LNG ['ov_teamspeak_not_online'] = 'TeamSpeak sunucusu şu anda ulaşılamıyor. Biz anlayış isteyin. "; 
$ LNG ['ov_teamspeak'] = 'Teamspeak'; 
d% d /%: $ LNG ['ov_teamspeak_v2'] = '<a href="teamspeak://%s:%s?nickname=%s" Connect"> </ a> • Online Connect title="Teamspeak • Kanallar:% d • Trafik toplam:% MB 's;. 
$ LNG ['ov_teamspeak_v3'] = '<a href="ts3server://%s?port=%d&nickname=%s&password=%s" Connect"> bağlayın title="Teamspeak </ a> . • Online:% d /% d • Kanallar:% d • Trafik toplam:% 'MB; 
$ LNG ['ov_closed'] = 'oyun şu anda devre dışı'; 
//------------------------------------------------ ----------------------------// 
/ / GALAXY 

$ LNG ['gl_no_deuterium_to_view_galaxy'] = 'Yeterince döteryum var'; 
$ LNG ['gl_legend'] = 'Legend'; 
$ LNG ['gl_strong_player'] = 'Güçlü Oyuncu'; 
$ LNG ['gl_week_player'] = 'Kötü Oyuncu'; 
$ LNG ['gl_vacation'] = 'tatil modunda'; 
$ LNG ['gl_banned'] = 'Kilitli'; 
$ LNG ['gl_inactive_seven'] = '7 gün inaktif '; 
$ LNG ['gl_inactive_twentyeight'] = '28 gün inaktif '; 
$ = 'S' ['GL_S'] LNG; 
$ LNG ['gl_w'] = 'n'; 
$ LNG ['gl_v'] = 'u'; 
$ LNG ['gl_b'] = 'g'; 
$ LNG ['gl_i'] = 'i'; 
$ LNG ['gl_I'] = 'I'; 
$ LNG ['gl_populed_planets'] = '% d yaşadığı gezegen'; 
$ LNG ['gl_out_space'] = 'evrenin çokluk'; 
$ LNG ['gl_avaible_missiles'] = 'gezegenlerarası'; 
$ LNG ['gl_fleets'] = 'filo yuvası'; 
$ LNG ['gl_avaible_grecyclers'] = 'Gigarecycler'; 
$ LNG ['gl_avaible_recyclers'] = 'geri dönüşüm'; 
$ LNG ['gl_avaible_spyprobes'] = 'casus sonda'; 
$ LNG ['gl_missil_launch'] = 'füze saldırısı'; 
$ LNG ['gl_missil_to_launch'] = 'füze sayısı (d </ b> sol <b>%):'; 
$ LNG ['gl_all_defenses'] = 'Tüm'; 
$ LNG ['gl_objective'] = 'birincil hedefi'; 
$ LNG ['gl_missil_launch_action'] = 'Gönder'; 
$ LNG ['gl_galaxy'] = 'Galaksi'; 
$ LNG ['gl_solar_system'] = 'Sistem'; 
$ LNG ['gl_show'] = 'Ekran'; 
$ LNG ['gl_pos'] = 'Pos'; 
$ LNG ['gl_planet'] = 'Planet'; 
$ LNG ['gl_name_activity'] = 'Ad (faaliyet)'; 
$ LNG ['gl_moon'] = 'ay'; 
$ LNG ['gl_debris'] = 'TF'; 
$ LNG ['gl_player_estate'] = 'Kullanıcılar (durum)'; 
$ LNG ['gl_alliance'] = 'İttifak'; 
$ LNG ['gl_actions'] = 'eylem'; 
$ = 'Casusluk' LNG ['gl_spy']; 
$ LNG ['gl_buddy_request'] = 'Arkadaş Listesi İstek'; 
$ LNG ['gl_missile_attack'] = 'füze saldırısı'; 
$ LNG ['gl_with'] = 'ile'; 
$ LNG ['gl_member'] = '% d üyeleri "; 
$ LNG ['gl_member_add'] = '% d Üyesi "; 
$ LNG ['gl_alliance_page'] = 'İttifak tarafı'; 
$ LNG ['gl_see_on_stats'] = 'İstatistik'; 
$ LNG ['gl_alliance_web_page'] = 'İttifak Ana Sayfa'; 
$ LNG ['gl_debris_field'] = 'enkaz alanına'; 
$ LNG ['gl_collect'] = 'aşağılayıcı'; 
$ LNG ['gl_resources'] = 'ham'; 
$ LNG ['gl_features'] = 'Properties'; 
$ LNG ['gl_diameter'] = 'çapa'; 
$ LNG ['gl_temperature'] = 'sıcaklık'; 
$ LNG ['gl_phalanx'] = 'Phalanx'; 
$ LNG ['gl_planet_destroyed'] = 'Destroyed Planet'; 
$ LNG ['gl_playercard'] = 'Oyuncu Kart'; 
$ LNG ['gl_player'] = 'Oyuncu'; 
$ LNG ['gl_in_the_rank'] = 'Oyuncu% konum% d' de s '; 
$ LNG ['gl_activity'] ='(*)'; 
$ LNG ['gl_activity_inactive'] = '(% d dakika)'; 
$ LNG ['gl_ajax_status_ok'] = 'Bitti'; 
$ LNG ['gl_ajax_status_fail'] = 'Hata'; 
$ LNG ['gl_free_desc'] = 'büyük bir ıssız gezegen. Burada ', yeni bir koloni Wahre ideal bir yerdir. 
$ LNG ['gl_free'] = 'ücretsiz'; 
$ LNG ['gl_yes'] = 'Evet'; 
$ LNG ['gl_no'] = 'Hayır'; 
$ LNG ['GL_POINTS'] = 'puan'; 
$ LNG ['gl_player'] = 'Oyuncu'; 
$ LNG ['gl_to'] = 'için'; 

//------------------------------------------------ ----------------------------// 
/ / Phalanx 
$ LNG ['px_no_deuterium'] = 'Yeterince döteryum var'; 
$ LNG ['px_scan_position'] = 'tarama pozisyonu'; 
$ LNG ['px_fleet_movement'] = 'Mevcut filo hareketleri'; 
$ LNG ['px_no_fleet'] 'Hayır Filo hareketleri var.' =; 
$ LNG ['px_out_of_range'] = 'Aralık Dışı'; 

//------------------------------------------------ ----------------------------// 
/ / EMPIRE 
$ LNG ['iv_imperium_title'] = 'imparatorluk Bakış'; 
$ LNG ['iv_planet'] = 'Planet'; 
$ LNG ['iv_name'] = 'Adı'; 
$ LNG ['iv_coords'] = 'koordine'; 
$ LNG ['iv_fields'] = 'Fields'; 
$ LNG ['iv_resources'] = 'ham'; 
$ LNG ['iv_buildings'] = 'bina'; 
$ LNG ['iv_technology'] = 'araştırma'; 
$ LNG ['iv_ships'] = 'gemi'; 
$ LNG ['iv_defenses'] = 'Savunma'; 

//------------------------------------------------ ----------------------------// 
/ / FİLO - FLEET1 - FLEET2 - FLEET3 - FLEETACS - FİLO KISAYOLLAR 
$ LNG ['fl_returning'] = 'Planet filo'; 
$ LNG ['fl_onway'] = 'Gezegen filo'; 
$ LNG ['fl_r'] = '(R)'; 
$ LNG ['fl_a'] = '(A)'; 
$ LNG ['fl_send_back'] = 'geri dön'; 
$ LNG ['fl_acs'] = 'Birliği'; 
$ LNG ['fl_no_more_slots'] = 'mevcutların daha fazla yuva'; 
$ LNG ['fl_speed_title'] = 'Hızlı'; 
$ LNG ['fl_continue'] = 'Next'; 
$ LNG ['fl_no_ships'] = 'Hayır gemileri mevcut'; 
$ LNG ['fl_remove_all_ships'] = 'Hayır gemi; 
$ LNG ['fl_select_all_ships'] = 'Tüm gemi; 
$ LNG ['fl_fleets'] = 'filo'; 
$ LNG ['fl_expeditions'] = 'seferler'; 
$ LNG ['fl_number'] = 'ID'; 
$ LNG ['fl_mission'] = 'Sipariş'; 
$ LNG ['fl_ammount'] = 'sayısı'; 
$ LNG ['fl_beginning'] = 'Start'; 
$ LNG ['fl_departure'] = 'varış (hedef)'; 
$ LNG ['fl_destiny'] = 'Hedef'; 
$ LNG ['fl_objective'] = 'geri dön'; 
$ LNG ['fl_arrival'] = 'varış (Geri)'; 
$ LNG ['fl_info_detail'] = 'filoları bilgi'; 
$ LNG ['fl_order'] = 'Komut'; 
$ LNG ['fl_new_mission_title'] = 'Yeni İş: Fleet seçin'; 
$ = 'Gemi Tipi' LNG ['fl_ship_type']; 
$ LNG ['fl_ship_available'] = 'Uygun'; 
$ LNG ['fl_planet'] = 'Planet'; 
$ LNG ['fl_debris'] = 'enkaz alanına'; 
$ LNG ['fl_moon'] = 'ay'; 
$ LNG ['fl_planet_shortcut'] = '(P)'; 
$ LNG ['fl_debris_shortcut'] = '(D)'; 
$ LNG ['fl_moon_shortcut'] = '(M)'; 
$ LNG ['fl_no_shortcuts'] = 'Hayır kısayollar var'; 
$ LNG ['fl_anonymous'] = 'İsimsiz'; 
$ LNG ['fl_shortcut_add_title'] = 'isim [Galaxy / Sistem / Planet]'; 
$ LNG ['fl_shortcut_name'] = 'Adı'; 
$ LNG ['fl_shortcut_galaxy'] = 'Galaksi'; 
$ LNG ['fl_shortcut_solar_system'] = 'Sistem'; 
$ LNG ['fl_clean'] = 'sıfırlamak'; 
$ LNG ['fl_register_shorcut'] = 'oluştur'; 
$ LNG ['fl_shortcuts'] = 'Kestirme'; 
$ LNG ['fl_reset_shortcut'] = 'Reset'; 
$ LNG ['fl_dlte_shortcut'] = 'Sil'; 
$ LNG ['fl_back'] = 'geri dön'; 
$ LNG ['fl_shortcut_add'] = 'a'; 
$ LNG ['fl_shortcut_edition'] = 'kısayol düzenle'; 
$ LNG ['fl_no_colony'] = 'Hayır kolonileri var'; 
$ LNG ['fl_send_fleet'] = 'filo gemisi'; 
$ LNG ['fl_fleet_speed'] = 'Hızlı'; 
$ LNG ['fl_distance'] = 'mesafe'; 
$ LNG ['fl_flying_time'] = 'süresi (tek yön)'; 
$ LNG ['fl_flying_arrival'] = 'Arrival'; 
$ LNG ['fl_flying_return'] = 'dön'; 
$ LNG ['fl_fuel_consumption'] = 'yakıt tüketimi'; 
$ LNG ['fl_max_speed'] = 'Maksimum Hız'; 
$ LNG ['fl_cargo_capacity'] = 'kargo kapasitesi'; 
$ LNG ['fl_shortcut'] = 'Kısayol'; 
$ LNG ['fl_shortcut_add_edit'] = '(oluştur / değiştir)'; 
$ LNG ['fl_my_planets'] = 'My Planet'; 
$ LNG ['fl_acs_title'] = 'Birlik saldırıları'; 
$ LNG ['fl_hold_time'] = 'tutma süresi'; 
$ LNG ['fl_resources'] = 'ham'; 
$ LNG ['fl_max'] = 'max'; 
$ LNG ['fl_hours'] = 'saat (ler)'; 
$ = 'Kalan' LNG ['fl_resources_left']; 
$ LNG ['fl_all_resources'] = 'Maksimum yükleme hammadde'; 
$ LNG ['fl_empty_target'] = 'Hayır misyonları mevcut (Planet kullanılabilir?)'; 
$ LNG ['fl_expedition_alert_message'] = 'Uyarı sefer, onlar sefer onların bütün filo kaybedebilir aşağı beraberinde getirmektedir'; 
$ = 'Dikkatli olun,%% s içinde bulunduğunu, filoları yok' LNG ['fl_dm_alert_message']; 
$ LNG ['fl_vacation_mode_active'] = 'Bu tatil modu vardır; 
$ LNG ['fl_expedition_tech_required'] = 'Bu gerekli teknoloji Gezileri var'; 
$ LNG ['fl_expedition_fleets_limit'] = 'Daha fazla sefer başlayamaz'; 
$ LNG ['fl_week_player'] = 'Oyuncu onlar için çok zayıf'; 
$ LNG ['fl_strong_player'] = 'oyuncu onlar için çok güçlü'; 
$ LNG ['fl_in_vacation_player "] =' oyuncu tatil modu açık; 
$ LNG ['fl_no_slots'] = 'No more yuvası mevcut'; 
$ LNG ['fl_empty_transport'] = 'Yüklenen Hayır mal'; 
$ LNG ['fl_planet_populed'] = 'Planet yerleşti'; 
'Oyuncuların ittifak veya arkadaş listesinde olmalıdır hedef gezegenden vardır!' $ LNG ['fl_no_same_alliance'] =; 
$ LNG ['fl_not_ally_deposit'] = 'hedef hiçbir Allianzdepo olduğunu'; 
= 'Sadece kendi gezegende filoları dağıtabilir' $ LNG ['fl_deploy_only_your_planets']; 
$ LNG ['fl_no_enought_deuterium'] = 'Yeterince% yok bulunamadı var. Onlar eksikliği s!%% s '; 
$ LNG ['fl_no_enought_cargo_capacity'] = 'Yeterli kargo alanı yok:'; 
$ LNG ['fl_admins_cannot_be_attacked'] = 'Sen Yöneticiler saldırı olamaz'; 
$ LNG ['fl_fleet_sended'] = 'filo gönderdi'; 
$ LNG ['fl_from'] = 'Kimden'; 
$ LNG ['fl_arrival_time'] = 'varış saati'; 
$ LNG ['fl_return_time'] = 'dönüş süresi'; 
$ LNG ['fl_fleet'] = 'filo'; 
$ LNG ['fl_player'] = 'Oyuncu'; 
$ LNG ['fl_add_to_attack'] = 'davet edildi.'; 
$ LNG ['fl_dont_exist'] = 'mevcut değil.'; 
$ LNG ['fl_acs_invitation_message'] = 'bir AKS davet ediyor.'; 
$ LNG ['fl_acs_invitation_title'] = 'AKS davetiye'; 
$ LNG ['fl_sac_of_fleet'] = 'filo AKS'; 
$ LNG ['fl_modify_sac_name'] = 'AKS-adı'; 
$ LNG ['fl_members_invited'] = 'Davet'; 
$ LNG ['fl_invite_members'] = 'Davet'; 
$ LNG ['fl_simulate'] = 'Simülasyon'; 
$ LNG ['fl_bonus'] = 'bonus'; 
$ LNG ['fl_bonus_attack'] = 'Angiff'; 
$ LNG ['fl_bonus_defensive'] = 'Savunma'; 
$ LNG ['fl_bonus_shield'] = 'zırh'; 
= 'Enkaz alanı yok' $ LNG ['fl_no_empty_derbis']; 
$ LNG ['fl_acs_newname_alphanum'] = 'adı sadece alfanümerik karakterler içerebilir.'; 
$ LNG ['fl_acs_change'] = 'Değiştir'; 
$ LNG ['fl_acs_change_name'] = 'Yeni bir isim girin'; 
$ LNG ['fl_error_not_avalible'] = 'Bu koordinatları değil bir gezegen'; 
$ LNG ['fl_error_empty_derbis'] = 'Hayır Trümerfeld mevcut'; 
'Hiçbir moon!' $ LNG ['fl_error_no_moon'] =; 
$ LNG ['fl_error_same_planet'] = 'başlangıç ve bitiş aynı gezegen vardır'; 

//------------------------------------------------ ----------------------------// 
/ / BİNALARI - ARAŞTIRMA - TERSANE - Savunma 
$ LNG ['bd_dismantle'] = 'gözyaşı'; 
$ LNG ['bd_interrupt'] = 'Durdur'; 
$ LNG ['bd_cancel'] = 'İptal'; 
$ LNG ['bd_working'] = 'çalışanlar'; 
$ LNG ['bd_build'] = 'Bina'; 
$ LNG ['bd_build_next_level'] = 'Seviye Kaldır'; 
$ LNG ['bd_add_to_list'] = 'kuyruk oluşturmak ekle'; 
= 'Planet genişletmek' $ LNG ['bd_no_more_fields']; 
$ LNG ['bd_remaining'] = 'kaynakların eksikliği:'; 
$ LNG ['bd_lab_required'] = 'Önce gezegende bir araştırma laboratuvarı inşa gerek'; 
$ LNG ['bd_building_lab'] = 'araştırma laboratuvarında genişletilmiş olan'; 
$ LNG ['bd_max_lvl'] = '(Max Level:% s)'; 
$ LNG ['bd_lvl'] = 'seviye'; 
$ LNG ['bd_research'] = 'Araştırma'; 
$ LNG ['bd_shipyard_required'] = 'Bu gezegen binasında ilk tersane gerek'; 
$ LNG ['bd_building_shipyard'] = 'Nanit veya Tersanesi şu anda geçiyor'; 
$ LNG ['bd_available'] = 'Uygun'; 
$ LNG ['bd_build_ships'] = 'Gönder'; 
$ LNG ['bd_protection_shield_only_one'] = 'Sadece kubbe bina da kalkan'; 
$ LNG ['bd_build_defenses'] = 'Gönder'; 
$ LNG ['bd_actual_production'] = 'Mevcut Üretim:'; 
$ LNG ['bd_completed'] = 'Hazır'; 
$ LNG ['bd_operating'] = 'çalışıyor'; 
$ LNG ['bd_continue'] = 'Next'; 
$ LNG ['bd_price_for_destroy'] = 'yıkım maliyeti:'; 
$ LNG ['bd_ready'] = 'Hazır'; 
$ LNG ['bd_finished'] = 'Hazır'; 
$ LNG ['bd_maxlevel'] = 'ulaştı Maksimum seviye'; 
$ LNG ['bd_on'] = 'on'; 
$ LNG ['bd_max_builds'] = 'Sen max olabilir. % D gemi siparişleri "; 
$ LNG ['bd_next_level'] = 'Next Level'; 
$ LNG ['bd_need_engine'] = 'Tüketir style="color:#FF0000">% </ span>% daha s <span'; 
$ LNG ['bd_more_engine'] = 'Üretilmiş <span style="color:#00FF00">% </ span>% daha s'; 
$ LNG ['bd_jump_gate_action'] = 'atlama'; 
$ LNG ['bd_cancel_warning'] = 'Önleyici Ressis sadece% 60'ı geri'; 
$ LNG ['bd_cancel_send'] = 'Seçilen - Sil'; 
$ LNG ['bd_destroy_time'] = 'süre'; 
değil </ a> 'Sen Planet <a href="?page=buildings&cp=%d&re=0">% zorunda = $ LNG [' sys_notenough_money '] [:% d% d% d] s % inşasına başlamak için yeterli kaynaklara sahip s. <br>% s% s,% s% s% s% var s. inşaat <br>% maliyeti% s,% s% s% s% s '; 
$ LNG ['sys_nomore_level'] = 'Ne artık sahip bir bina (% s) yok etmeye çalışıyorlar.'; 
$ LNG ['sys_buildlist'] = 'kuyruk oluşturmak'; 
$ LNG ['sys_buildlist_fail'] = 'inşa edemez'; 

//------------------------------------------------ ----------------------------// 
/ / KAYNAKLARI 
$ LNG ['rs_amount'] = 'sayısı'; 
$ LNG ['rs_lvl'] = 'seviye'; 
$ LNG ['rs_production_on_planet'] = 'emtia gezegen üzerinde "% s"'; 
$ LNG ['rs_basic_income'] = 'Temel Gelir'; 
$ LNG ['rs_storage_capacity'] = 'kamp'; 
$ LNG ['rs_calculate'] = 'hesaplama'; 
$ LNG ['rs_sum'] = 'Toplam'; 
$ LNG ['rs_daily'] = 'Her gün'; 
$ LNG ['rs_weekly'] = 'Haftada'; 
$ LNG ['rs_ress_bonus'] = 'Bonus (subay / DM-Bonus):'; 

//------------------------------------------------ ----------------------------// 
/ / Officiers 
$ LNG ['of_recruit'] = 'satın alma'; 
$ LNG ['of_max_lvl'] = 'Max Seviye '; 
$ LNG ['of_available_points'] = 'Mevcut puan:'; 
$ LNG ['of_points_per_thousand_darkmatter'] = '(% d% s başına 1 puan)'; 
$ LNG ['of_lvl'] = 'Seviye'; 
$ LNG ['of_dm_trade'] = '% s - Bank'; 
$ LNG ['of_still'] = 'bile'; 
$ LNG ['of_active'] = 'aktif'; 
$ LNG ['of_update'] = 'Yenile'; 

//------------------------------------------------ ----------------------------// 
/ / BORSA 
$ LNG ['tr_empty_darkmatter'] = 'Yeterince% s yok'; 
$ LNG ['tr_cost_dm_trader'] = 'satıcı ücretleri s!%% s'; 
$ LNG ['tr_only_positive_numbers'] 'numaraları sadece positve girin' =; 
$ LNG ['tr_not_enought_metal'] = 'Sen bol metal var.'; 
$ LNG ['tr_not_enought_crystal'] = 'Yeterince kristal var.'; 
$ LNG ['tr_not_enought_deuterium'] = 'Yeterince döteryum var.'; 
$ LNG ['tr_exchange_done'] = 'Başarıyla dönüştürülür'; 
$ LNG ['tr_call_trader'] = 'Bir satıcı için çağrı'; 
$ LNG ['tr_call_trader_who_buys'] = 'Aşağıdaki satın bir satıcı Çağrı'; 
$ LNG ['tr_call_trader_submit'] = 'satıcı aramalar'; 
= 'Ticaret fiyat 2/1/0.5 olan' $ LNG ['tr_exchange_quota']; 
$ LNG ['tr_sell_metal'] = 'metal' ile değiştirin '; 
$ LNG ['tr_sell_crystal'] = 'kristal karşı değiştirin'; 
$ LNG ['tr_sell_deuterium'] = 'döteryum ile değiştirin'; 
$ LNG ['tr_resource'] = 'ham'; 
$ LNG ['tr_amount'] = 'Miktar'; 
$ LNG ['tr_quota_exchange'] = 'ticaret fiyat'; 
$ LNG ['tr_exchange'] = 'Değiştir'; 

//------------------------------------------------ ----------------------------// 
/ / Techtree 
$ LNG ['tt_requirements'] = 'Gerekli'; 
$ LNG ['tt_lvl'] = 'seviye'; 

//------------------------------------------------ ----------------------------// 
/ / BİLGİ 
$ LNG ['in_jump_gate_done'] = 'filoları başarıyla gönderildi. Eğer bir saat geri bu atlama kapısı kullanabilirsiniz: '; 
$ LNG ['in_jump_gate_error_data'] = 'hataları, veri yanlış'; 
$ LNG ['in_jump_gate_not_ready_target'] = 'Zielsprungtor henüz hazır değil'; 
$ LNG ['in_jump_gate_doesnt_have_one'] = 'Bir atlama kapısı yok'; 
$ LNG ['in_jump_gate_already_used'] = 'Bu atlama kapısı hazır değil'; 
$ LNG ['in_jump_gate_available'] = 'sayısı'; 
$ LNG ['in_rf_again'] = 'karşı Rapid Fire'; 
$ LNG ['in_rf_from'] = 'Rapid Fire'; 
$ LNG ['in_level'] = 'seviye'; 
$ LNG ['in_prod_p_hour'] = 'saat [karı] başına çıktı'; 
$ LNG ['in_difference'] = 'fark'; 
$ LNG ['in_used_energy'] = 'enerji'; 
$ LNG ['in_prod_energy'] = 'enerji'; 
$ LNG ['in_used_deuter'] = "Döteryum tüketim"; 
$ LNG ['IN_RANGE'] = 'sensörlerinin'; 
$ LNG ['in_title_head'] = 'bilgi'; 
$ = 'Adı' ['IN_NAME'] LNG; 
$ LNG ['in_struct_pt'] = 'yapısal puan'; 
$ LNG ['in_shield_pt'] = 'kalkan gücü'; 
$ LNG ['in_attack_pt'] = 'Attack Rate'; 
$ LNG ['in_capacity'] = 'taşıma kapasitesi'; 
$ LNG ['in_units'] = 'birim'; 
$ LNG ['in_base_speed'] = 'Hızlı'; 
$ LNG ['in_consumption'] = "Döteryum tüketim"; 
$ LNG ['in_jump_gate_start_moon'] = 'Ay üssü'; 
$ LNG ['in_jump_gate_finish_moon'] = 'Hedef Moon'; 
$ LNG ['in_jump_gate_select_ships'] = 'atlama kapısı kullanımı: sayısı gemi'; 
$ LNG ['in_jump_gate_wait_time'] = 'Sonraki mümkün kullanın:'; 
$ LNG ['in_jump_gate_jump'] = 'ücret'; 
$ LNG ['in_destroy'] = 'gözyaşı'; 
$ LNG ['in_needed'] = 'Gerekli'; 
$ LNG ['in_dest_durati'] = 'süre'; 

//------------------------------------------------ ----------------------------// 
/ / MESAJLAR 
$ LNG ['mg_type'] [0] = 'istihbarat raporu'; 
$ LNG ['mg_type'] [1] = 'Oyuncu Haberleri'; 
$ LNG ['mg_type'] [2] = 'İttifak haber'; 
$ LNG ['mg_type'] [3] = 'savaş kayıtları'; 
$ LNG ['mg_type'] [4] = 'Sistem mesaj'; 
$ LNG ['mg_type'] [5] = 'Ulaştırma Haberler'; 
$ LNG ['mg_type'] [15] = 'keşif raporları'; 
$ LNG ['mg_type'] [50] = 'Oyun Haberleri'; 
$ LNG ['mg_type'] [99] = 'Yapı kuyruk mesajları'; 
$ LNG ['mg_type'] [100] = 'Tüm mesajlar'; 
$ LNG ['mg_type'] [999] = 'Giden'; 
$ LNG ['mg_no_subject'] = 'Konu Yok'; 
$ LNG ['mg_no_text'] = 'Belirtilen Metin yok'; 
$ LNG ['mg_msg_sended'] = 'Mesaj gönderildi'; 
$ = 'Mesajları silmek için kontrol edin' LNG ['mg_delete_marked']; 
$ LNG ['mg_delete_type_all'] = 'Bu tür tüm mesajları silmek'; 
$ LNG ['mg_delete_unmarked'] = 'Not sil seçili mesajları'; 
$ LNG ['mg_delete_all'] = 'Tüm mesajları sil'; 
$ LNG ['mg_show_only_header_spy_reports'] = 'casusluk kısmen raporları'; 
$ LNG ['mg_action'] = 'Eylem'; 
$ LNG ['mg_date'] = 'tarih'; 
$ LNG ['mg_from'] = 'Kimden'; 
$ LNG ['mg_to'] = 'On'; 
$ LNG ['mg_subject'] = 'Konu'; 
$ LNG ['mg_confirm_delete'] = 'Sil'; 
$ LNG ['mg_message_title'] = 'haber'; 
$ LNG ['mg_message_type'] = 'Cins Mesaj'; 
$ LNG ['mg_total'] = 'Toplam'; 
$ LNG ['mg_game_operators'] = 'Oyunu Operatörleri'; 
$ LNG ['mg_error'] = 'alıcı bulunamadı'; 
$ LNG ['mg_overview'] = 'haber yönetimi'; 
$ LNG ['mg_send_new'] = 'bir mesaj'; 
$ LNG ['mg_send_to'] = 'alıcı'; 
$ LNG ['mg_message'] = 'Mesaj'; 
$ LNG ['mg_characters'] = 'karakteri'; 
$ LNG ['mg_send'] = 'Gönder'; 
$ LNG ['mg_game_message'] = 'Oyunu Mesaj'; 
'Gönderildi' $ LNG ['mg_message_send'] =; 
= 'Bir metni girin' $ LNG ['mg_empty_text']; 

//------------------------------------------------ ----------------------------// 
/ / İTTİFAKI 

$ LNG ['al_newname_alphanum'] = 'ittifak isim etiketi ve sadece alfasayısal karakterler kullanmanız gerekir.'; 
$ LNG ['al_newname_no_space'] = 'ittifak isim etiketi ve boşluk içermemelidir.'; 
$ LNG ['al_description_message'] = 'Aliianz hiçbir açıklama verilmiştir.'; 
$ LNG ['al_web_text'] = 'Ana'; 
$ LNG ['al_request'] = 'uygulama'; 
$ LNG ['al_click_to_send_request'] = 'İttifak uygulamak için buraya tıklayın'; 
$ LNG ['al_tag_required'] = 'Hiç belirtilen Allianztag var.'; 
$ LNG ['al_name_required'] 'Sen belirtilen hiçbir ittifak var.' =; 
$ LNG ['al_already_exists'] = '.% Zaten var ittifak var'; 
$ LNG ['al_created'] = '% İttifakı kuruldu s'; 
$ LNG ['al_continue'] = 'Next'; 
$ LNG ['al_alliance_closed'] = 'Bu ittifak yeni üye kabul etmiyor.'; 
$ LNG ['al_request_confirmation_message'] = 'uygulamasını bir ileti aldım gönderdi. <br> <a href="?page=alliance"> Geri </ a> '; 
$ LNG ['al_default_request_text'] = 'ittifak hiçbir metin bırakmıştır.'; 
$ LNG ['al_write_request'] = 'uygulamasını Allianz% s yazma'; 
$ LNG ['al_request_deleted'] = 'Bu iş sildiniz. <br> Artık kendi açabilir veya başka katılmak ".; 
$ LNG ['al_request_wait_message'] = 'Sen Allianz% için başvuruda bulunmuş s. <br> bir yanıt bekleyin veya iş sil ".; 
$ LNG ['al_delete_request'] = 'Sil Uygulama'; 
$ LNG ['al_founder_cant_leave_alliance'] = 'ittifak kurucusu sadece onları terk etmemelidir.'; 
$ LNG ['al_leave_sucess'] = '.% Ittifak sızan başarıyla s'; 
$ LNG ['al_do_you_really_want_to_go_out'] = 'Eğer gerçekten% s kaçmak mı'; 
$ LNG ['al_go_out_yes'] = 'Evet'; 
$ LNG ['al_go_out_no'] = 'Hayır'; 
$ LNG ['al_close_ally'] = 'gerçekten ittifak vazgeçmek mi'; 
$ LNG ['al_kick_player'] = 'gerçekten oyuncu% ittifak kaldırılır var mı'; 
$ LNG ['al_circular_sended'] = ". Gönderildi \ nArka posta gönderildi oyuncular şu:"; 
$ LNG ['al_all_players'] = 'Tüm oyuncular'; 
= 'Belirli bir sırada yer alıyor.' $ LNG ['al_no_ranks_defined']; 
$ LNG ['al_request_text'] = 'uygulaması metin'; 
$ LNG ['al_inside_text'] = 'İç metin'; 
$ LNG ['al_outside_text'] = 'harici metin'; 
$ LNG ['al_transfer_alliance'] = 'Allianz transfer'; 
$ LNG ['al_disolve_alliance'] = 'İttifak çözülür'; 
$ LNG ['al_founder_rank_text'] = 'kurucu'; 
$ LNG ['al_new_member_rank_text'] = 'acemi'; 
$ LNG ['al_acept_request'] = 'kabul'; 
$ LNG ['al_you_was_acceted'] = 'Sen dahil edilmiştir'; 
$ LNG ['al_hi_the_alliance'] = 'Merhaba <b> ittifak <br>'; 
LNG ['al_has_accepted'] = '</ b> uygulama <br> Gerekçe kabul etti: <br>.' $; 
$ LNG ['al_decline_request'] = 'Reddet'; 
$ LNG ['al_you_was_declined'] = 'Sen tarafından reddedilmiştir'; 
$ LNG ['al_has_declined'] = '</ b> uygulama <br> Gerekçe reddetti: <br>'; 
$ LNG ['al_no_requests'] = 'Hit'; 
$ LNG ['al_request_from'] = 'İstek "% s"'; 
$ LNG ['al_no_request_pending'] = 'vardır% d iş (ler)'; 
$ LNG ['al_name'] = 'İttifak Adı'; 
$ LNG ['al_new_name'] = 'Yeni İttifak adı (3-30 karakter):'; 
$ LNG ['al_tag'] = 'Allianztag'; 
$ LNG ['al_new_tag'] = 'Yeni İttifak gün (3-8 karakter):'; 
$ LNG ['al_user_list'] = 'Üye Listesi'; 
$ LNG ['al_users_list'] = 'üye listesi (oyuncu:% d)'; 
$ LNG ['al_manage_alliance'] = 'İttifak yönetmek'; 
$ LNG ['al_send_circular_message'] = 'dairesel posta yazmak'; 
$ LNG ['al_circular_front_text'] = '% oyuncu şu yazıyor s:'; 
$ LNG ['al_new_requests'] = '% d yeni iş (ler)'; 
$ LNG ['al_goto_chat'] = 'ittifak chat'; 
$ LNG ['al_save'] = 'kaydet'; 
$ LNG ['al_dlte'] = 'Sil'; 
$ LNG ['al_rank_name'] = 'Sıra Adı'; 
$ LNG ['al_ok'] = 'OK'; 
$ LNG ['al_num'] = 'ID'; 
$ LNG ['al_member'] = 'Adı'; 
$ LNG ['al_request_from_user'] = 'oyuncu uygulaması'; 
$ LNG ['al_message'] = 'Mesaj'; 
$ LNG ['al_position'] = 'Rank'; 
$ LNG ['al_points'] = 'puan'; 
$ LNG ['al_coords'] = 'Coords'; 
$ LNG ['al_member_since'] = 'Kayıt'; 
$ LNG ['al_estate'] = 'Online'; 
$ LNG ['al_back'] = 'geri dön'; 
$ LNG ['al_actions'] = 'Eylemler'; 
$ LNG ['al_change_title'] 'değişim' =; 
$ LNG ['al_the_alliance'] = 'İttifak'; 
$ LNG ['al_change_submit'] 'değişim' =; 
$ LNG ['al_reply_to_request'] = 'gerekçe'; 
$ LNG ['al_reason'] =''; 
$ LNG ['al_characters'] = 'karakteri'; 
$ LNG ['al_request_list'] = 'Uygulama Listesi'; 
$ LNG ['al_candidate'] = 'Adı'; 
$ LNG ['al_request_date'] = 'tarih'; 
$ LNG ['al_transfer_alliance'] = 'Allianz transfer'; 
$ LNG ['al_transfer_to'] = 'transfer'; 
$ LNG ['al_transfer_submit'] = 'Gönder'; 
$ LNG ['al_ally_information'] = 'ittifak ile ilgili bilgiler'; 
$ LNG ['al_ally_info_tag'] = 'Tag'; 
$ LNG ['al_ally_info_name'] = 'Adı'; 
$ LNG ['al_ally_info_members'] = 'Üyeler'; 
$ LNG ['al_your_request_title'] = 'uygulama'; 
$ LNG ['al_applyform_send'] = 'gönder'; 
$ LNG ['al_applyform_reload'] = 'yeniden'; 
$ LNG ['al_circular_send_ciruclar'] = 'dairesel posta yazmak'; 
$ LNG ['al_circular_alliance'] = 'İttifak'; 
$ LNG ['al_receiver'] = 'oyuncu'; 
$ LNG ['al_circular_send_submit'] = 'gönder'; 
$ LNG ['al_circular_reset'] = 'sıfırlamak'; 
$ LNG ['al_alliance'] = 'ittifak'; 
$ LNG ['al_alliance_make'] = 'Kendi ittifak oluşturmak'; 
$ LNG ['al_alliance_search'] = 'Arama İttifak'; 
$ LNG ['al_your_ally'] = 'Lütfen ittifak'; 
$ LNG ['al_rank'] = 'Rank'; 
$ LNG ['al_web_site'] = 'Ana'; 
$ LNG ['al_inside_section'] = 'İç alan'; 
$ LNG ['al_make_alliance'] = 'Bir ittifak kurmak'; 
$ LNG ['al_make_ally_tag_required'] = 'İttifak gün (3-8 karakter)'; 
$ LNG ['al_make_ally_name_required'] = 'İttifak adı (3-30 karakter)'; 
$ LNG ['al_make_submit'] = 'nedenleri'; 
$ LNG ['al_find_alliances'] = 'İttifak göz'; 
$ LNG ['al_find_text'] = 'arama'; 
'Hayır ittifak!' $ LNG ['al_find_no_alliances'] =; 
$ LNG ['al_find_submit'] = 'Arama'; 
$ LNG ['al_manage_ranks'] = 'saflarına yönetmek'; 
$ LNG = 'Üyeleri Yönet' ['al_manage_members']; 
$ LNG ['al_manage_change_tag'] = 'Allianztag değiştir'; 
$ LNG ['al_manage_change_name'] = 'Allianz adını değiştirmek'; 
$ LNG ['al_texts'] = 'Metin yönetimi'; 
$ LNG ['al_manage_options'] = 'Seçenekler'; 
$ LNG ['al_manage_image'] = 'İttifak logosu'; 
$ LNG ['al_manage_requests'] = 'uygulamalar'; 
$ LNG ['al_manage_diplo'] = 'ittifak diplomasi'; 
$ LNG ['al_requests_not_allowed'] = 'uygulamaları izin vermez'; 
$ LNG ['al_requests_allowed'] = 'uygulamalar izin'; 
$ LNG ['al_manage_founder_rank'] = 'kurucuları Adı'; 
$ LNG ['al_configura_ranks'] = 'hakları set'; 
$ LNG ['al_create_new_rank'] = 'Yeni rütbe'; 
$ LNG ['al_rank_name'] = 'Adı'; 
$ LNG ['al_create'] = 'oluştur'; 
$ LNG ['al_legend'] = 'Açıklama'; 
$ LNG ['al_legend_disolve_alliance'] = 'İttifak çözülür'; 
$ LNG ['al_legend_kick_users'] = 'kaldır üyelerinin; 
$ LNG ['al_legend_see_requests'] = 'görmek uygulamaları'; 
$ LNG ['al_legend_see_users_list'] = 'Üye bakınız'; 
$ LNG ['al_legend_check_requests'] = 'düzenleme uygulamaları'; 
$ LNG ['al_legend_admin_alliance'] = 'İttifak yönetmek'; 
$ LNG ['al_legend_see_connected_users'] = 'görmek için çevrimiçi durumu'; 
= 'Yuvarlak gözden kaybolur' $ LNG ['al_legend_create_circular']; 
$ LNG ['al_legend_right_hand'] = 'sağ'; 
$ LNG ['al_requests'] = 'uygulamalar'; 
$ LNG ['al_circular_message'] = 'dairesel mail'; 
= 'Bu ittifak bırakacağım' $ LNG ['al_leave_alliance']; 
$ LNG ['al_Gesamtk'] = 'kavgaları'; 
$ LNG ['al_Erfolg'] = 'mücadele oranları'; 
$ LNG ['al_Siege'] = 'zafer'; 
$ LNG ['al_Drawp'] = 'çizmek'; 
$ LNG ['al_Loosi'] = 'Lost'; 
$ LNG ['al_KGesamt'] = 'toplam mücadele'; 
$ LNG ['al_Allyquote'] = 'varlık Allymitglieder mücadele İstatistikleri'; 
$ LNG ['al_Quote'] = 'Siegqoute'; 
$ LNG ['al_unitsshut'] = 'Civatalı Birimleri'; 
$ LNG ['al_unitsloos'] = 'Birimleri Lost'; 
$ LNG ['al_tfmetall'] = 'Toplam yıkım metal'; 
$ LNG ['al_tfkristall'] = 'Toplam yıkım kristal'; 
$ LNG ['al_view_stats'] = 'mücadele ile ilgili istatistikler'; 
$ LNG ['al_view_diplo'] = 'kamu diplomasisi'; 
$ LNG ['al_memberlist_min'] = 'min'; 
$ LNG ['al_memberlist_on'] = 'Online'; 
$ LNG ['al_memberlist_off'] = 'Offline'; 
$ LNG ['al_diplo'] = 'diplomasi'; 
$ LNG ['al_diplo_level'] [0] = 'Kanat'; 
$ LNG ['al_diplo_level'] [1] = 'İttifak'; 
$ LNG ['al_diplo_level'] [2] = 'ticaret ittifak'; 
$ LNG ['al_diplo_level'] [3] = 'saldırmazlık paktı'; 
$ LNG ['al_diplo_level'] [4] = 'savaş'; 
$ LNG ['al_diplo_no_entry'] = 'değil - Bu Sözleşmeye -'; 
$ LNG ['al_diplo_no_accept'] = '- Hayır soruları mevcut -'; 
$ LNG ['al_diplo_accept'] = 'gelen istekleri'; 
$ LNG ['al_diplo_accept_send'] = 'Giden İstekleri'; 
$ LNG ['al_diplo_create'] = 'Yeni bir pakt oluşturma'; 
$ LNG ['al_diplo_create_done'] = 'paktı başarıyla oluşturuldu.'; 
$ LNG ['al_diplo_ally'] = 'İttifak'; 
$ LNG ['al_diplo_level_des'] = 'Sözleşmenin Sanat'; 
$ LNG ['al_diplo_text'] = 'metin talep / gerekçe'; 
$ LNG ['al_diplo_accept_yes'] = 'anlaşma' kapalı; 
$ LNG ['al_diplo_accept_yes_mes'] = 'kapalı s ittifaklar ve% s% arasında bir anlaşma (% s) vardı'; 
$ LNG ['al_diplo_accept_yes_confirm'] = 'Eğer gerçekten Sözleşmesi'nin kabul musunuz'; 
$ LNG ['al_diplo_accept_no'] = 'Misak-ı red'; 
$ LNG ['al_diplo_accept_no_mes'] = 'reddedildi ittifaklar% s ve% s arasında Paktı isteği (% s)'; 
$ LNG ['al_diplo_accept_no_confirm'] = 'Eğer gerçekten anlaşmayı reddetmek istiyor musunuz'; 
$ LNG ['al_diplo_delete'] = 'anlaşma yapılması'; 
$ LNG ['al_diplo_delete_mes'] 'ittifaklar% s ve% s arasında Paktı (% s) kaldırılmıştır' =; 
$ LNG ['al_diplo_confirm_delete'] = 'Eğer gerçekten Sözleşmeye silmek istiyor musunuz?'; 
$ LNG ['al_diplo_ground'] = 'Sebep:'; 
$ LNG ['al_diplo_ask'] = 'Paktı isteği'; 
$ LNG ['al_diplo_ask_mes'] = 'bir anlaşma isteği (% s)% s ve İttifak <br>% s. Sebep yok:% s'; 
$ LNG ['al_diplo_war'] = 'savaş ilanı'; 
. Savaşı 24 saat içinde geçerlidir. = '% Alliance İttifakı s LNG [' al_diplo_war_mes ']% s% sadece nedenleri <br> açıkladı <br>% S <br> bilgi var olan $ 24 saat sadece sonra Bashregel ortadan kaldırır. <br> Daha fazla bilgi için target="_blank"> kuralları </ a> '<a href="index.php?page=rules" bulmak;. 
$ LNG ['al_leave_ally'] = 'Eğer gerçekten ittifak bırakır mısın'; 

//------------------------------------------------ ----------------------------// 
/ / BUDDY 
$ LNG ['bu_request_exists'] = 'zaten Arkadaş Listesi oyuncular'; 
$ LNG ['bu_cannot_request_yourself'] = 'Sen Arkadaş Listesi kendinizi ekleyemezsiniz'; 
$ LNG ['bu_request_message'] = 'Soru Metin'; 
$ LNG ['bu_player'] = 'Oyuncu'; 
$ LNG ['bu_request_text'] = 'gerekçe'; 
$ LNG ['bu_characters'] = 'karakteri'; 
$ LNG ['bu_back'] = 'geri dön'; 
$ LNG ['bu_send'] = 'gönder'; 
$ LNG ['bu_cancel_request'] = 'Undo'; 
$ LNG ['bu_accept'] = 'kabul'; 
$ LNG ['bu_decline'] = 'Reddet'; 
$ LNG ['bu_connected'] = 'Online'; 
$ LNG ['bu_minutes'] = 'min'; 
$ LNG ['bu_disconnected'] = 'Offline'; 
$ LNG ['bu_online'] = 'Online'; 
$ LNG ['bu_buddy_list'] = 'Arkadaş Listesi'; 
$ LNG ['bu_requests'] = 'Sorular'; 
$ LNG ['bu_alliance'] = 'İttifak'; 
$ LNG ['bu_coords'] = 'koordine'; 
$ LNG ['bu_text'] = 'metin'; 
$ LNG ['bu_action'] = 'eylem'; 
$ LNG ['bu_my_requests'] = 'My istekleri'; 
$ LNG ['bu_partners'] = 'Arkadaşlar'; 
$ LNG ['bu_delete'] = 'Sil'; 
$ LNG ['bu_no_request'] = 'Hiç soru var'; 
$ LNG ['bu_no_buddys'] = 'bulunamadı Arkadaşları'; 
$ LNG ['bu_request_send'] = 'İstek Gönderildi'; 

//------------------------------------------------ ----------------------------// 
/ NOTLAR 
$ LNG ['nt_important'] = 'Wichitg'; 
$ LNG ['nt_normal'] = 'Normal'; 
$ LNG ['nt_unimportant'] = 'önemli değil'; 
$ LNG ['nt_create_note'] = 'oluştur'; 
$ LNG ['nt_you_dont_have_notes'] = 'Hayır notları mevcut'; 
$ LNG ['nt_notes'] = 'notlar'; 
$ LNG ['nt_create_new_note'] = 'Yeni bir not oluştur'; 
$ LNG ['nt_edit_note'] = 'Mesaj Düzenle'; 
$ LNG ['nt_date_note'] = 'tarih'; 
$ LNG ['nt_subject_note'] = 'Konu'; 
$ LNG ['nt_size_note'] = 'Boyutu'; 
$ LNG ['nt_dlte_note'] = 'Sil'; 
$ LNG ['nt_priority'] = 'öncelikli'; 
$ LNG ['nt_note'] = 'Mesaj'; 
$ LNG ['nt_characters'] = 'karakteri'; 
$ LNG ['nt_back'] = 'geri dön'; 
$ LNG ['nt_reset'] = 'Reset'; 
$ LNG ['nt_save'] = 'kaydet'; 
$ LNG ['nt_no_title'] = 'Başlık yok'; 
$ LNG ['nt_no_text'] = 'Metin yok'; 

//------------------------------------------------ ----------------------------// 
/ / İSTATİSTİKLERİ 
$ LNG ['st_player'] = 'Oyuncu'; 
$ LNG ['st_alliance'] = 'İttifak'; 
$ LNG ['ST_Point'] = 'puan'; 
$ LNG ['st_fleets'] = 'filo'; 
$ LNG ['st_researh'] = 'Araştırma'; 
$ LNG ['st_buildings'] = 'bina'; 
$ LNG ['st_defenses'] = 'Savunma'; 
$ LNG ['st_position'] = 'Rank'; 
$ LNG ['st_members'] = 'Üyeler'; 
'Üyesi başına' $ LNG ['st_per_member'] =; 
$ LNG ['st_statistics'] = 'İstatistik'; 
$ LNG ['st_updated'] = 'Güncelleme'; 
$ LNG ['st_show'] = 'Göster'; 
$ LNG ['st_per'] = 'dan'; 
$ LNG ['st_in_the_positions'] = 'pozisyonlar'; 
$ LNG ['st_write_message'] = 'Özel Mesaj'; 

//------------------------------------------------ ----------------------------// 
/ / ARAMA 
$ LNG ['sh_tag'] = 'Tag'; 
$ LNG ['sh_name'] = 'Adı'; 
$ LNG ['sh_members'] = 'Üyeler'; 
$ LNG ['sh_points'] = 'puan'; 
$ LNG ['sh_search_in_the_universe'] = 'evrende Ara'; 
$ LNG ['sh_player_name'] = 'Oyuncu'; 
$ LNG ['sh_planet_name'] = 'Planet'; 
$ LNG ['sh_alliance_tag'] = 'Birlik Günü'; 
$ LNG ['sh_alliance_name'] = 'İttifak Adı'; 
$ LNG ['sh_search'] = 'Arama'; 
$ LNG ['sh_write_message'] = 'Özel Mesaj'; 
$ LNG ['sh_buddy_request'] = 'Arkadaş Listesi İstek'; 
$ LNG ['sh_alliance'] = 'İttifak'; 
$ LNG ['sh_planet'] = 'Planet'; 
$ LNG ['sh_coords'] = 'koordine'; 
$ LNG ['sh_position'] = 'Rank'; 

//------------------------------------------------ ----------------------------// 
/ / SEÇENEKLER 
$ LNG ['op_cant_activate_vacation_mode'] = 'Bu tatil modunda bina ve inşaat filoları da olamaz.'; 
= $ LNG ['op_password_changed'] 'Şifre <br> <a href="index.php" değişti Geri </ a> target="_top">'; 
$ LNG ['op_username_changed'] = 'Kullanıcı adı <br> <a href="index.php" Geri </ a> target="_top"> değişti'; 
$ LNG ['op_options_changed'] = 'Ayarlar <br> <a href="game.php?page=options"> Geri </ a>.'; 
$ LNG ['op_vacation_mode_active_message'] = 'tatil modu etkin. en az kadar Tatil modu: '; 
$ LNG ['op_end_vacation_mode'] = 'tatil modundan çıkmak'; 
$ LNG ['op_save_changes'] = 'Ayarları Kaydet'; 
$ LNG ['op_admin_title_options'] = 'Yönetici seçenekleri'; 
'Yönetici aktif koruma' $ LNG ['op_admin_planets_protection'] =; 
$ LNG ['op_user_data'] = 'Kullanıcı'; 
$ LNG ['op_username'] = 'Kullanıcı Adı'; 
$ LNG ['op_old_pass'] = 'Eski parola'; 
$ LNG ['op_new_pass'] = 'Yeni şifre (min. 8 karakter)'; 
$ LNG ['op_repeat_new_pass'] = 'Yeni şifre (içi boş geri)'; 
$ LNG ['op_email_adress'] = 'E-posta adresi'; 
$ LNG ['op_permanent_email_adress'] = 'Kalıcı e-posta adresi:'; 
$ LNG ['op_general_settings'] = 'Genel Ayarlar'; 
$ LNG ['op_sort_planets_by'] = 'tarafından Planet sırala'; 
$ LNG ['op_sort_kind'] = 'Sıralama'; 
$ LNG ['op_lang'] = 'Dil'; 
$ LNG ['op_skin_example'] = 'grafik yolu (örn: C: / 2moons/skins /)'; 
'Skin Show' $ LNG ['op_show_skin'] =; 
$ LNG ['op_deactivate_ipcheck'] = 'IP off kontrol'; 
$ LNG ['op_galaxy_settings'] = 'galaksi görünüm ayarları'; 
$ LNG ['op_spy_probes_number'] = 'casusluk sonda sayısı'; 
$ LNG ['op_toolt_data'] için tooltip = 'göster; 
$ LNG ['op_seconds'] = 'saniye'; 
$ LNG ['op_max_fleets_messages'] = 'Maksimum Filo Haberleri'; 
'Görünüm menüsünden gezegenler' $ LNG ['op_show_planetmenu'] =; 
$ LNG ['op_shortcut'] = 'Kısayol'; 
$ LNG ['op_show'] = 'Göster'; 
$ = 'Casusluk' LNG ['op_spy']; 
$ LNG ['op_write_message'] = 'mesaj'; 
$ LNG ['op_add_to_buddy_list'] = 'Arkadaş Listeme Ekle'; 
$ LNG ['op_missile_attack'] = 'füze saldırısı'; 
$ LNG ['op_send_report'] = 'casusluk Raporu'; 
$ LNG ['op_vacation_delete_mode'] = 'tatil modunda / Sil hesap'; 
'Etkin tatil modunda' $ LNG ['op_activate_vacation_mode'] =; 
$ LNG ['op_dlte_account'] = 'Hesabı Sil'; 
$ LNG ['op_email_adress_descrip'] sizden = 'Bu mail adresi değişmiş olabilir her zaman. . Kalıcı bir adresi olarak tescil edilmiştir 'değiştirmeden 7 gün sonra; 
$ LNG ['op_deactivate_ipcheck_descrip'] IP değişmişse veya iki kişi aynı anda tek bir hesapta farklı IP'ler altında bağlı otomatik Sicherheitslogout alır = 'IP-kontrol anlamına gelir. IP bir güvenlik riski 'kontrol devre dışı bırakabilirsiniz!; 
'Galaxiemenu tarama her doğrudan gönderilen casus sonda sayısı var.' $ LNG ['op_spy_probes_number_descrip'] =; 
$ LNG ['op_activate_vacation_mode_descrip'] = 'tatil modunda uzun olmadığı dönemlerde onları korumaktır. Eğer bir şey inşa yalnızca ve araştırma değil, kendi filolarını yolda var etkinleştirebilirsiniz. Zaman üzerine, bu saldırı zaten altında, yeni saldırılardan korur, ancak devam etti. tatil modunda, üretim sıfıra ayarlanır ve manuel% 100 sıfırlamak tatil modunda sonuna kadar sahiptir. Tatil modunda tekrar devre dışı bırakabilirsiniz ancak o zaman, en az 2 gün sürer.; 
$ LNG ['op_dlte_account_descrip'] = 'Burada hack kullanıyor iseniz tamamen hesabınızın 7 gün sonra otomatik olarak silinecektir.'; 
$ LNG ['op_not_vaild_mail'] = 'Geçersiz bir e-posta adresi girdiniz'; 
$ LNG ['op_change_mail_exist'] = 'e-posta adresi% s vererek zaten kullanılıyor'; 
$ LNG ['op_sort_normal'] = 'yaratılış amacıyla'; 
$ LNG ['op_sort_koords'] = 'koordine'; 
$ LNG ['op_sort_abc'] = 'alfabe'; 
$ = 'Yükselen' LNG ['op_sort_up']; 
$ = 'Inen' LNG ['op_sort_down']; 
$ LNG ['op_user_name_no_alphanumeric'] = 'Lütfen bir kullanıcı adı sadece alfanümerik karakterler'; 
$ LNG ['op_change_name_pro_week'] = 'Sizin kullanıcı adınız sadece haftada 1x değiştirebilirsiniz'; 
$ LNG ['op_change_name_exist'] = 'adı% s zaten var'; 
$ LNG ['op_active_build_messages'] = 'Baulistennachrichten Akivi'; 
'Kısa's mağaza sayısını' $ LNG ['op_small_storage'] =; 

//------------------------------------------------ ----------------------------// 
/ / BANNED 
$ LNG ['bn_no_players_banned'] = 'Hiçbir Speared şu anda'; 
$ LNG ['bn_exists'] = 'varoluş'; 
$ LNG ['bn_players_banned'] = 'yasaklandı oyuncu'; 
$ LNG ['bn_players_banned_list'] = 'boyunduruk'; 
$ LNG ['bn_player'] = 'Oyuncu'; 
$ LNG ['bn_reason'] = 'Temel'; 
$ LNG ['bn_from'] = 'Kimden'; 
$ LNG ['bn_until'] = 'Up'; 
$ LNG ['bn_by'] = 'Kimden'; 
$ LNG ['bn_writemail'] = '% s e-posta'; 

//------------------------------------------------ ----------------------------// 
/ / Class.CheckSession.php 

$ LNG ['css_account_banned_message'] 'Hesabınız Speared olmuştur' =; 
$ LNG ['css_account_banned_expire'] = 'Sen ile% Speared olan <br> <a href="./index.php?page=pranger"> rezil etmek </ a>'; 
$ LNG ['css_goto_homeside'] = '<a href="./index.php"> Ana Sayfa </ a>'; 
$ LNG ['css_server_maintrace'] = 'Ana Server Trace <br> oyun şu anda <br> neden kapalı:% s.'; 

//------------------------------------------------ ----------------------------// 
/ / Class.debug.php 
$ LNG ['cdg_mysql_not_available'] = 'daha sonra tekrar deneyin <br> Verdiğimiz rahatsızlıktan dolayı özür dileriz <br> Lütfen veritabanı <br> bağlantı yok.'; 
$ LNG ['cdg_error_message'] = 'Hata, yöneticinize başvurun. Hata: '; 
$ LNG ['cdg_fatal_error'] = 'ÖLÜMCÜL HATA'; 

//------------------------------------------------ ----------------------------// 
/ / Class.FlyingFleetsTable.php 

$ LNG ['cff_no_fleet_data'] = 'Hayır gemi bilgi'; 
= 'Filo oluşan' $ LNG ['cff_aproaching']; 
$ LNG ['cff_ships'] = 'birimleri.'; 
$ LNG ['cff_from_the_planet'] = 'Planet'; 
$ LNG ['cff_from_the_moon'] = 'ay'; 
$ LNG ['cff_the_planet'] = 'gezegen'; 
$ LNG ['cff_debris_field'] = 'kalıntıları'; 
$ LNG ['cff_to_the_moon'] = 'ay'; 
$ LNG ['cff_the_position'] = 'Konum'; 
$ LNG ['cff_to_the_planet'] =''; 
$ LNG ['cff_the_moon'] = 'Moon'; 
$ LNG ['cff_from_planet'] = 'gezegen'; 
'Enkaz alanında' $ LNG ['cff_from_debris_field'] =; 
'Ay'a' $ LNG ['cff_from_the_moon'] =; 
$ LNG ['cff_from_position'] = 'pozisyonundan'; 
$ LNG ['cff_missile_attack'] = 'füze saldırısı'; 
$ LNG ['cff_from'] = 'dan'; 
$ LNG ['cff_to'] = 'on'; 
$ LNG ['cff_one_of_your'] = 'Bir almanın'; 
$ LNG ['cff_acs_fleet'] = 'Federasyonu filo'; 
$ LNG ['cff_a'] = 'A'; 
$ LNG ['cff_of'] = 'oyuncu'; 
$ LNG ['cff_goes'] = 'gezegenden'; 
$ LNG ['cff_toward'] = 'elde'; 
$ LNG ['cff_back_to_the_planet'] = 'gezegenin geri'; 
$ LNG ['cff_with_the_mission_of'] = '. Misyonumuz: '; 
$ LNG ['cff_to_explore'] = 'yörüngesi vardır'; 
$ LNG ['cff_comming_back'] = 'el'; 
$ LNG ['cff_back'] = 'Coming Back'; 
$ LNG ['cff_to_destination'] = 'hedefe Başlık'; 

//------------------------------------------------ ----------------------------// 
/ / EXTRA DİL İŞLEVLERİ 
$ LNG ['fcm_moon'] = 'ay'; 
$ LNG ['fcm_info'] = 'Bilgi'; 
$ LNG ['fcp_colony'] = 'koloni'; 
$ LNG ['fgp_require'] = 'Gerekli'; 
$ LNG ['fgf_time'] = 'İnşaat'; 
$ LNG ['sys_module_inactive'] = 'Modül özürlü'; 

//------------------------------------------------ ----------------------------// 
/ / CombatReport.php 
$ LNG ['cr_lost_contact'] = 'temas filoları ile kaybolur.'; 
$ LNG ['cr_first_round'] = '(filo 1 turda imha edildi)'; 
$ LNG ['cr_type'] = 'türü'; 
$ LNG ['cr_total'] = 'Toplam'; 
$ LNG ['cr_weapons'] = 'silah'; 
$ LNG ['cr_shields'] = 'etiket'; 
$ LNG ['cr_armor'] = 'zırh'; 
$ LNG ['cr_destroyed'] = 'Destroyed'; 

//------------------------------------------------ ----------------------------// 
/ / FleetAjax.php 
$ LNG ['fa_not_enough_probes'] = 'Hata hiçbir probları mevcut'; 
$ LNG ['fa_galaxy_not_exist'] = 'Hata, galaksi yok'; 
$ LNG ['fa_system_not_exist'] = 'hatası, sistem yok'; 
$ LNG ['fa_planet_not_exist'] = 'Hata, gezegen yok'; 
$ LNG ['fa_not_enough_fuel'] = 'Hata değil, yeterli döteryum mevcut'; 
$ LNG ['fa_no_more_slots'] = 'Hata hiçbir yuvası mevcut'; 
$ LNG ['fa_no_recyclers'] = 'Hata hiçbir çöp mevcut'; 
$ LNG ['fa_no_fleetroom'] = 'Hata, büyük taşıma kapasitesinden daha döteryum tüketimi'; 
$ LNG ['fa_mission_not_available'] = 'Hata, misyon mevcut değil'; 
$ LNG ['fa_no_spios'] = 'Hata hiçbir probları mevcut'; 
= 'Hata, oyuncu tatil modunda' $ LNG ['fa_vacation_mode']; 
= 'Hata, oyuncu güçsüz' $ LNG ['fa_week_player']; 
$ LNG ['fa_strong_player'] = 'Hata, oyuncu çok fazla'; 
$ LNG ['fa_not_spy_yourself'] = 'hata, sen kendini casus olamaz'; 
$ LNG ['fa_not_attack_yourself'] = 'hata, sen kendini saldırı olamaz'; 
$ LNG ['fa_action_not_allowed'] = 'Hata, Sistem Hatası'; 
$ LNG ['fa_vacation_mode_current'] = 'Hata, sen Urlaubsmdous bulunmaktadır'; 
$ LNG ['fa_sending'] = 'Gönderildi'; 

//------------------------------------------------ ----------------------------// 
/ / MissilesAjax.php 
$ LNG ['ma_silo_level'] = 'Sen füze silosu seviyesi 4 gerek'; 
$ LNG ['ma_impulse_drive_required'] = 'Önce Impulse Motor keşfetmek gerekir'; 
$ LNG ['ma_not_send_other_galaxy'] = 'Başka bir gökada içine roket gönderemezsiniz.'; 
$ LNG ['ma_planet_doesnt_exists'] = 'Planet yok.'; 
$ LNG ['ma_wrong_target'] = 'Hayır hedef'; 
$ LNG ['ma_no_missiles'] 'Sen hiç gezegenlerarası var' =; 
$ LNG ['ma_add_missile_number'] = 'Bir numara girmelisiniz'; 
$ LNG ['ma_misil_launcher'] = 'Roketatar'; 
$ LNG ['ma_small_laser'] = 'Işık Lazer'; 
$ LNG ['ma_big_laser'] = 'Ağır Lazer'; 
$ LNG ['ma_gauss_canyon'] = 'Gaußkanone'; 
$ LNG ['ma_ionic_canyon'] = 'iyon tabancası'; 
$ LNG ['ma_buster_canyon'] = 'Plazma Gun'; 
$ LNG ['ma_small_protection_shield'] = 'Küçük Kalkan Kubbesi'; 
$ LNG ['ma_big_protection_shield'] = 'Büyük Kalkan Kubbesi'; 
$ LNG ['ma_all'] = 'Tüm'; 
$ LNG ['ma_missiles_sended'] = 'gezegenlerarası gönderdi. Tahrip öğeler: '; 

//------------------------------------------------ ----------------------------// 
/ / Topkb.php 
$ LNG ['tkb_top'] of Fame = 'Hall; 
$ LNG ['tkb_gratz'] = 'tüm ekip Top 100 tebrik'; 
$ LNG ['tkb_platz'] = 'Ders'; 
$ LNG ['tkb_owners'] = 'Şirket'; 
$ LNG ['tkb_datum'] = 'tarih'; 
$ LNG ['tkb_units'] = 'Birimleri'; 
$ LNG ['tkb_legende'] = '<b> Yetkiler: </ b>'; 
$ LNG ['tkb_gewinner'] = '<b> kazanan </ b>'; 
$ LNG ['tkb_verlierer'] = '<b>-loser </ b>'; 
$ LNG ['tkb_unentschieden'] = '<b> Hem Weiss, beraberlik-</ b>'; 
$ LNG ['tkb_missing'] = 'in Action <br>: yok artık yok kullanıcı hesabı.'; 

//------------------------------------------------ ----------------------------// 
/ / Playercard.php 
$ LNG ['pl_overview'] = 'Oyuncu Kart'; 
$ LNG ['pl_name'] = 'Kullanıcı Adı'; 
$ LNG ['pl_homeplanet'] = 'gezegen'; 
$ LNG ['pl_ally'] = 'İttifak'; 
$ LNG ['pl_message'] = 'Özel Mesaj'; 
$ LNG ['pl_buddy'] = 'Arkadaş Sorgulama'; 
$ LNG ['pl_points'] = 'puan'; 
$ LNG ['pl_range'] = 'Rank'; 
$ LNG = 'yapı' ['pl_builds']; 
$ LNG ['pl_tech'] = 'Araştırma'; 
$ LNG ['pl_fleet'] = 'filo'; 
$ LNG ['pl_def'] = 'savunma'; 
$ LNG ['pl_total'] = 'Toplam'; 
$ LNG ['pl_fightstats'] = 'mücadele istatistikleri'; 
$ LNG ['pl_fights'] = 'kavgaları'; 
$ LNG ['pl_fprocent'] = 'mücadele oranları'; 
$ LNG ['pl_fightwon'] = 'zafer'; 
$ LNG ['pl_fightdraw'] = 'çizmek'; 
$ LNG ['pl_fightlose'] = 'Lost'; 
$ LNG ['pl_totalfight'] = 'toplam mücadele'; 
$ LNG ['pl_destroy'] = '% s co imha vardır'; 
$ LNG ['pl_unitsshot'] = 'Civatalı Birimleri'; 
$ LNG ['pl_unitslose'] = 'Birimleri Lost'; 
$ LNG ['pl_dermetal'] = 'toplam yıkım metal'; 
$ LNG ['pl_dercrystal'] = 'toplam yıkım kristal'; 
$ LNG ['pl_etc'] = 'İletişim'; 

//------------------------------------------------ ----------------------------// 
/ / Sohbet 

$ LNG ['chat_title'] = 'chat'; 
$ LNG ['chat_ally_title'] = 'İttifak chat'; 
$ LNG ['chat_bbcode'] = 'BB-kodu'; 
$ LNG ['chat_fontcolor'] = 'Yazı tipi rengi'; 

$ LNG ['chat_disc'] = 'chat'; 
$ LNG ['chat_message'] = 'Mesaj'; 
$ LNG ['chat_send'] = 'gönder'; 
$ LNG ['chat_admin'] = '<font color="red"> admin% </ font> s'; 
$ LNG ['chat_color_white'] = 'beyaz'; 
$ LNG ['chat_color_blue'] = 'blue'; 
$ LNG ['chat_color_yellow'] = 'sarı'; 
$ LNG ['chat_color_green'] = 'yeşil'; 
$ LNG ['chat_color_pink'] = 'Pink'; 
$ LNG ['chat_color_red'] = 'red'; 
$ LNG ['chat_color_orange'] = 'turuncu'; 

$ LNG ['chat_notext'] = 'bazı metni girin'; 
$ LNG ['chat_request_url'] = 'bize bir link verin lütfen:'; 
$ LNG ['chat_request_url_desc'] = 'bağlantı (isteğe bağlı) için bir açıklama girin:'; 

//------------------------------------------------ ----------------------------// 
/ / Destek 

$ LNG ['supp_header'] = 'destek sistemi'; 
$ LNG ['supp_header_g'] = 'Kapalı oda biletleri'; 
$ LNG ['ticket_id'] = '# Bilet-ID'; 
$ LNG ['konu'] = 'Konu'; 
$ LNG ['durum'] = 'Durum'; 
$ LNG ['ticket_posted'] = 'dan bilet'; 
$ LNG ['ticket_new'] = 'Yeni Bilet'; 
$ LNG ['input_text'] = 'Açıklama:'; 
$ LNG ['answer_new'] = 'bir yanıt vermek:'; 
$ LNG ['metin'] = 'Ayrıntılar'; 
$ LNG ['message_a'] = 'mesajı durumu:'; 
$ LNG ['sendit_a'] = 'mesajı yerleştirildi.'; 
$ LNG ['message_t'] = 'bilet durumu:'; 
$ LNG ['supp_send'] = 'Gönder'; 
$ LNG ['sendit_t'] = 'bilet girildi.'; 
$ LNG ['close_t'] = 'bilet kapatıldı.'; 
$ LNG ['sendit_error'] = 'Hata:'; 
$ LNG ['sendit_error_msg'] = 'Bir şey yazmayı unuttum'; 
$ LNG ['supp_admin_system'] = 'Destek-Yönetici Paneli'; 
$ LNG ['close_ticket'] = 'Bilet kapat'; 
$ LNG ['open_ticket'] = 'açık bilet'; 
$ LNG ['oyuncu'] = 'kullanıcı adı'; 
$ LNG ['supp_ticket_close'] = 'Bilet' kapalı; 
$ LNG ['supp_close'] = 'kapalı'; 
$ LNG ['supp_open'] = 'açık'; 
$ LNG ['supp_admin_answer'] = 'Yönetici-cevap'; 
$ LNG ['supp_player_answer'] = 'Oyuncu-cevap'; 

//------------------------------------------------ ----------------------------// 
/ / Records 

$ LNG ['rec_build'] = 'bina'; 
$ LNG ['rec_specb'] = 'Özel binalar'; 
$ LNG ['rec_playe'] = 'Oyuncu'; 
$ LNG ['rec_defes'] = 'Savunma'; 
$ LNG ['rec_fleet'] = 'gemi'; 
$ LNG ['rec_techn'] = 'Araştırma'; 
$ LNG ['rec_level'] = 'Seviye'; 
$ LNG ['rec_nbre'] = 'sayısı'; 
$ LNG ['rec_rien'] = '-'; 
$ LNG ['rec_last_update_on'] = 'Son güncelleme at:% s'; 


//------------------------------------------------ ----------------------------// 
/ / Battle simülatörü 

$ LNG ['bs_derbis_raport'] = '%% s veya% s% gerekli enkaz alanı için s vardır.'; 
$ LNG ['bs_steal_raport'] = 'ganimetlerle% gerekli s% s veya% s% s veya% s% s vardır.'; 
$ LNG ['bs_names'] = 'Gemi Adı'; 
$ LNG ['bs_atter'] = 'saldırgan'; 
$ LNG ['bs_deffer'] = 'savunucular'; 
$ LNG ['bs_steal'] = 'hammadde (Çelik için):'; 
$ LNG ['bs_techno'] = 'teknikleri'; 
$ LNG ['bs_send'] = 'Gönder'; 
$ LNG ['bs_cancel'] = 'Reset'; 
$ LNG ['bs_wait'] = 'Bir sonraki simülasyonu için 10 saniye bekleyin'; 

//------------------------------------------------ ----------------------------// 
/ / Filo Trader 

$ LNG ['ft_head'] = 'Hurda Handler'; 
$ LNG ['ft_count'] = 'sayısı'; 
$ LNG ['ft_max'] = 'max'; 
$ LNG ['ft_total'] = 'TOPLAM'; 
$ LNG ['ft_charge'] = 'satıcı ücreti'; 
$ LNG ['ft_absenden'] = 'Gönder'; 

//------------------------------------------------ ----------------------------// 
/ / Çıkış 
$ LNG ['lo_title'] = 'Çıkış başarılı! 'Görüşmek üzere; 
$ LNG ['lo_logout'] = 'oturum sona'; 
$ LNG ['lo_redirect'] = 'forward'; 
$ LNG ['lo_notify'] = 'Sen <span id="seconds"> 5 </ span> s yönlendirileceksiniz'; 
$ LNG = beklemeyelim için tıklayın ['lo_continue']; 


/ / Köle tarafından Almanca'ya tercüme edilmiştir. Tüm hakları (C) 2010 ters 

?