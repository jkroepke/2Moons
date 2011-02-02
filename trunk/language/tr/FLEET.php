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

$ LNG ['Metal'] = 'metal'; 
$ LNG ['Kristal'] = 'kristal'; 
$ LNG ['deuterium'] = 'deuterium'; 
$ = 'Dark Matter' ['Dark Matter'] LNG; 
$ LNG ['Enerji'] = 'enerji'; 


//------------------------------------------------ ----------------------------// 
/ / SYSTEM 
$ LNG ['sys_attacker_lostunits'] = 'adam bir bütün var'; 
$ LNG ['sys_defender_lostunits'] = 'defans bir bütün var'; 
$ LNG ['sys_units'] = 'Birimleri kayıp'; 
$ LNG ['debree_field_1'] = 'Bu alan azından şimdi koordinatları'; 
$ LNG ['debree_field_2'] = '.'; 
$ LNG ['sys_moonproba'] = 'Bir Ay kökenli bir şans:'; 
$ LNG ['sys_moonbuilt'] = 'özgür metal ve kristal büyük miktarlarda çekmek ve formda bir uydu gezegen% [% d:% d:% d] etrafta'; 
$ LNG ['sys_attack_title'] = 'Aşağıdaki filolar birbirinden yüzü:'; 
$ LNG ['sys_attack_round'] = 'yuvarlak'; 
$ LNG ['sys_attack_attacker_pos'] = 'saldırgan'; 
$ LNG ['sys_attack_techologies'] = 'silah:% d%% Kalkanlar:% d%% Zırh:% d%%'; 
$ LNG ['sys_attack_defender_pos'] = 'savunucular'; 
$ LNG ['sys_ship_type'] = 'yazın'; 
$ LNG ['sys_ship_count'] = 'sayısı'; 
$ LNG ['sys_ship_weapon'] = 'silahlanma.'; 
$ LNG ['sys_ship_shield'] = 'kalkan'; 
$ LNG ['sys_ship_armour'] = 'zarf'; 
$ LNG ['sys_destroyed'] = 'Destroyed'; 
$ LNG ['fleet_attack_1'] = 'bir güç ile saldıran filo yangınları'; 
$ LNG ['fleet_attack_2'] = 'defans. Savunma kalkanları 'emer; 
$ LNG ['fleet_defs_1'] = 'bir güç ile savunma filo yangınları'; 
$ LNG ['fleet_defs_2'] = 'saldırgan' de. Saldırganlar kalkanlar 'emer; 
$ LNG ['zarar'] = 'zarar.'; 
$ LNG ['sys_attacker_won'] = 'saldırgan savaşı kazandı'; 
$ LNG ['sys_defender_won'] = 'defans savaşı kazandı'; 
= 'Savaş berabere biter' $ LNG ['sys_both_won']; 
$ LNG ['sys_stealed_ressources'] = 'O yakalar'; 
$ LNG ['sys_and'] = 've'; 
$ LNG ['sys_mess_tower'] = 'Flottenhauptquatier'; 
$ LNG ['sys_mess_attack_report'] = 'Battle Report'; 
$ LNG ['sys_spy_maretials'] = 'casus raporu'; 
$ LNG ['sys_spy_fleet'] = 'filo'; 
$ LNG ['sys_spy_defenses'] = 'Savunma'; 
$ LNG ['sys_mess_qg'] = 'istihbarat departmanı'; 
$ LNG ['sys_mess_spy_report_moon'] = '(ay)'; 
$ LNG ['sys_mess_spy_report'] = 'casus raporu'; 
$ LNG ['sys_mess_spy_lostproba'] = 'casusluk soruşturması imha olasılığıdır:% d%%';
$ LNG ['sys_mess_spy_control'] = 'gözetim'; 
$ LNG ['sys_mess_spy_activity'] = 'casusluk faaliyeti'; 
$ LNG ['sys_mess_spy_ennemyfleet'] = 'gezegenden bir düşman filosu'; 
$ LNG ['sys_mess_spy_seen_at'] = 'gezegeninizin civarında oldu'; 
$ LNG ['sys_mess_spy_seen_at2'] = 'görüldü'; 
$ LNG ['sys_mess_spy_destroyed'] = 'senin casusluk sonda </ font> yıkıldı <font color="red">!'; 
$ LNG ['sys_adress_planet'] = '[% s:% s:% s]'; 

$ LNG ['sys_stat_mess_stay'] = 'filo konuşlu'; 
$ LNG ['sys_stat_mess'] = 'Sizin Filo gezegene ulaştı ve% s% sağlayan% s,% s% s% s% s'; 

$ LNG ['sys_colo_mess_from'] = 'Kolonisierungsabteilung'; 
$ LNG ['sys_colo_mess_report'] = 'Kolonisierungsbericht'; 
$ LNG ['sys_colo_defaultname'] = 'koloni'; 

$ LNG ['sys_colo_arrival'] =''; 
$ LNG ['sys_colo_maxcolo'] = 'Lütfen filolarından biri% koordinatları ulaştı s. Eğer d gezegen fazla% olamaz, çünkü bir çözümün mümkün değil ".; 
$ LNG ['sys_colo_allisok'] = 'Lütfen filolarından biri% koordinatları ulaştı s. Yerleşimciler yeni gezegen kolonize başlar ".; 
$ LNG ['sys_colo_badpos'] senin filolarından biri% koordinatları ulaştı '= s. Burada, herhangi bir yerleşim seçenek bulundu, sizin yerleşimciler 'hayal kırıklığına döndü;. 
$ LNG ['sys_colo_notfree'] = 'Lütfen filolarından biri% koordinatları ulaştı s. koordinatları üzerinde onlar yerleşimciler geldi, onlar zaten bir kolonisi olduğunu buldu. Tamamen demoralize ve geri döndü. "; 

$ LNG ['sys_expe_report'] = "Expedition Raporu; 
$ LNG ['sys_recy_report'] = "geri dönüşüm raporu"; 
$ LNG ['sys_expe_blackholl_1'] = "Sizin filosu ve bir kara delik yerine kısmen tahrip edildi"; 
$ LNG ['sys_expe_blackholl_2'] = "Sizin filosu ve bir kara delik yerine tamamen imha edildi"; 
$ LNG ['sys_expe_found_goods'] = "Sizin araştırmacılar size <br>% sahip bir kaynak zengini gezegenlerin% s bulduk,% s% kaldırıldı s% s% s"; 
$ LNG ['sys_expe_found_ships'] = "Sizin bilim adamları yapabildin, mükemmel durumda <br> dağlarda bulunan uzay var:."; 
$ LNG ['sys_expe_back_home'] = "Size filo sefer yine zurükgekehrt biridir."; 
$ LNG ['sys_expe_found_ress_1_1'] = 'Sizin sefer ki bazı kaynaklar elde edilebilir küçük bir asteroit sürüsü tespit etti.'; 
$ LNG ['sys_expe_found_ress_1_2'] = 'izole bir gezegen üzerinde bazı kolayca erişilebilir kaynakları alanları bulmuş ve başarılı bir hammadde iyileşti.'; 
$ LNG ['sys_expe_found_ress_1_3'] = 'Sizin sefer uzun önce savaşın çok eski bir gemi batıkları rastladı. Bireysel bileşenlerini geri dönüşüm olabilir ve kurtarmak ".; 
$ LNG ['sys_expe_found_ress_1_4'] = 'sefer çok zehirli bir atmosfere sahip olan radyoaktif kirlenmiş asteroitler bulundu. Ancak, taramalar bu asteroid çok rohstoffhaltig olduğunu göstermiştir. Kullanarak otomatik drone mal 'maksimum kazanmak için çalışıyordu;. 
$ LNG ['sys_expe_found_ress_2_1'] = 'Sizin sefer bir, tam dolu, eski ama ıssız kargo konvoy bulundu. Bazı kaynaklar kaydedilmiş olabilir. "; 
$ LNG ['sys_expe_found_ress_2_2'] = 'kendi atmosferi ile küçük bir ayın üzerinde sizin sefer geniş doğal kaynaklar bulundu. Zemin ekipleri bu doğal hazineleri yükseltmek için buradayız. "; 
$ LNG ['sys_expe_found_ress_2_3'] = 'Biz sivil gemiler, çok ihtiyaç duyulan gıda ve ilaç küçük bir konvoy almış. Buna karşılık, biz yararlı kaynaklar bir bolluk aldı.; 
$ LNG ['sys_expe_found_ress_3_1'] = 'Sizin Expedition filo dev bir yabancı gemi batıkları ve keşif raporları. teknoloji ile ancak, ama hiçbir şey yapamadık, siz değerli hammadde kazanabileceğini olarak gemi bileşenlere ayrılmış oldu. "; 
$ LNG ['sys_expe_found_ress_3_2'] hammadde bilinmeyen bir gezegen ton içeren = 'Bir mineral kemer. Sefer filo 'tam depolama raporları!; 
$ LNG ['sys_expe_found_dm_1_1'] = 'sefer karanlık madde biraz yakalamak başardı ve korunmuş.'; 
$ LNG ['sys_expe_found_dm_1_2'] = 'Bizim sefer karanlık madde az miktarda taşınan bir hayalet gemi karşılaştı. orijinal ekip oldu ne biz, ama hiçbir ipucu bulabilirsiniz rağmen bizim teknisyenler, karanlık madde 'kurtarmak başardık. 
$ LNG ['sys_expe_found_dm_1_3'] = 'Bir kaç basit matematiksel hesaplamalar, karanlık maddenin küçük bir kapta karşılığında bizi bırakıp küçük bir gemiye bir garip uzaylı karşılaştı.'; 
$ LNG ['sys_expe_found_dm_1_4'] = 'Biz yabancı bir gemi kalıntısı bulduk. On board karanlık madde ile küçük bir kapta 'oldu!; 
$ = 'Sefer biraz garip sinyaller takip eder ve bir asteroid keşfettiler, karanlık maddenin küçük bir miktar çekirdek LNG [' sys_expe_found_dm_1_5 '] dahil edildi. Asteroid ve gemide getirildi araştırmacılar şimdi karanlık madde ', çıkarmak için çalışıyoruz. 
$ LNG ['sys_expe_found_dm_2_1'] = 'Bizim sefer benzersiz bir deneme başardı. Onlar ölmekte olan bir yıldız karanlık madde 'dan satın aldı. 
$ LNG ['sys_expe_found_dm_2_2'] = 'Bizim sefer garip bir spektral fenomen raporlar. Bu geminin kalkanlarının tasarruf enerji karanlık madde oluştuğunu, diğer şeyler arasında, yol açtı. Teknisyenlerimiz şimdi fenomen sürece bu karanlık madde ', korumak bile mümkün olduğunca devam, çalışıyorlar. 
$ LNG ['sys_expe_found_dm_2_3'] = 'Bizim sefer uzayda kontrolsüz muhtemelen uzun süre Hovers eski bir uzay istasyonu buldu. Istasyon kendisi, ama tamamen yararsız olduğunu da reaktörler birinde karanlık maddenin küçük bir miktar yatırılır. Mühendislerimiz ondan mümkün olduğunca kurtarmaya çalışıyorlar. "; 
$ LNG ['sys_expe_found_dm_3_1'] = 'kendiliğinden bir Hiperuzay bozulma karanlık maddenin büyük miktarda sağlamak için keşif olanak var'; 
= 'Bizim sefer özel bir tür ilk temas raporları LNG [' sys_expe_found_dm_3_2 '] görünüşte Legorianer kendisi bir enerji yaratık vardır $ sonra uçuyordu seferin gemileri gelişmemiş türler karar verdi yardım etmek biraz - onunla hayata bir kaptır gemide karanlık madde köprü "; 
$ LNG ['sys_expe_found_ships_1_1'] 'Biz bir önceki sefer kalıntısı vardır karşılaşılan =! yine virane flyingpoints 'bazı olsun eğer Teknisyenlerimiz bakın; 
$ LNG ['sys_expe_found_ships_1_2'] = 'Biz ıssız bir korsan üssü bulduk. hangar hala bazı eski gemiler vardır. Mühendislerimiz bazıları henüz kullanmaya olup olmadığını görmek için arıyor ".; 
$ LNG ['sys_expe_found_ships_1_3'] = 'Bizim sefer muhtemelen devam savaşlar neredeyse tamamen yıkılmış bir gezegen bulundu. yörüngesinde birçok batık sürdü. Teknisyenleri bazıları tamir etmeye. Biz de burada olanlar hakkında bilgi alabilirsiniz. "; 
$ LNG ['sys_expe_found_ships_1_4'] = 'Sizin sefer muhtemelen yaş için sol bir eski yıldız kale karşılaştı. Kalenin hangarda birkaç gemi bulundu. bazılarında tekrar yola çıkmaya eğer teknisyenleri görebilirsiniz. '; 
$ LNG ['sys_expe_found_ships_2_1'] = 'Biz Armada kalıntılarını bulduk. sefer filosunun mühendisi makul sağlam gemilere hemen gitti ve bu yeniden onarılmıştır deneyin. "; 
$ LNG ['sys_expe_found_ships_2_2'] = 'Bizim sefer eski bir, otomatik tersane üzerine geldi. Bazı gemiler ve üretim aşamasında hala bizim mühendislerimiz tersane için enerji kaynaklarını geri yüklemek için çalışıyoruz. "; 
$ LNG ['sys_expe_found_ships_3_1'] = 'Biz dev bir uzay gemisi mezarlığı bulduk. sefer filo Bazı teknisyenler geri operasyonu bir ya da diğer gemi almayı başardı. "; 
$ LNG ['sys_expe_found_ships_3_2'] = 'bir uygarlığın kalıntıları ile Biz bir gezegen keşfettiler. yörüngeye veya sadece bina hala bozulmamış görülebilir dev bir uzay istasyonu, From. Bizim teknisyenleri ve pilotların Bazı gemilerin bazıları 'kullanmak için orada park edilmiş olup olmadığını görmek için yüzeye gitti.; 
Zzzrrt Tanrım: $ LNG ['sys_expe_lost_fleet_1'] = 'Expedition From hala yalnızca aşağıdaki iletiyi kalır! Krrrzzzzt evet zrrrtrzt krgzzzz Krzzzzzzzztzzzz ...'; benziyor 
$ LNG ['sys_expe_lost_fleet_2'] = '. Bu sefer tarafından gönderilen son şey bazı inanılmaz iyi bir açık, kara deliğin yakın çekimler yapıldı hâlâ'; 
$ LNG ['sys_expe_lost_fleet_3'] = 'oldukça muhteşem patlama, bütün sefer yıkılan bir zincirleme reaksiyon yol kılavuz gemi kilit kırmak.'; 
$ LNG ['sys_expe_lost_fleet_4'] = 'sefer filo artık normal uzaya geri atlamak olduğunu. Bilim adamlarımız, ama yine de hala, ne olmuş olabilir şaşırtıcı olan filo sonsuza dek kaybetmiş gibi görünüyor. "; 
$ LNG ['sys_expe_time_fast_1'] sürücü güç ünitelerinin bobinlerde = 'beklenmedik bir geribildirim sefer dönüşü hızlandırılmış, bu yüzden beklenenden daha erken yaşta döner. Ilk göstergesi hiçbir şey rapor etmek heyecan verici olmasıdır. "; 
başarı ile - $ LNG ['sys_expe_time_fast_2'] = 'biraz cesur yeni komutan sipariş dönüş uçuş kısaltmak için kararsız bir kurt deliği aldı! Ancak, sefer kendisi hiçbir yeni bilgi getirdi. "; 
$ LNG ['sys_expe_time_fast_3'] = 'sektöründe belirli bir durum raporu değil Your Expedition okudu. Ancak, filo güneş rüzgar bir tatile koştu. Böylece, atlama oldukça hızlanmıştır. biraz daha erken Your sefer evine döner. "; 
$ LNG ['sys_expe_time_slow_1'] seferinin atlamada yanlış hesaplama yol tarayıcınızın = 'Ciddi bir kusur. Sadece filosunu, tamamen yanlış yerde bile yol indi sonra çok daha fazla zaman 'aldi.; 
$ LNG ['sys_expe_time_slow_2'] = 'bilinmeyen nedenlerden dolayı, sefer filo tamamen yanlış atlamak aşağı indi. Yaklaşık bir bir güneş kalbinde çıkıp olurdu. Neyse ki, bilinen bir sistem içinde sona erdi, ancak dönüş uzun başlangıçta düşünülenden daha sürebilir. "; 
$ LNG ['sys_expe_time_slow_3'] = 'yeni navigasyon modülünü bazı hatalar ile ama yine de iyi bir mücadele vardır. Sadece Expedition Filosu Atla filosunun atlama ay gezegenin başlamadan hemen sonra sona erdi, hatta tüm döteryum tüketildiği, yanlış yönde oldu. Biraz hayal kırıklığına uğramış, sefer şimdi darbe döndü. Böylece dönüş muhtemelen biraz gecikecektir. "; 
$ LNG ['sys_expe_time_slow_4'] = 'Sizin sefer artan parçacık fırtınaları ile bir sektör koştu. filo ve tüm gemiler için enerji depolama davet Bu ana sistemler düştü. Senin mekanik, ama en kötü engelleyebilir sefer şimdi bazı gecikmeli olarak geri döneceği ".; 
$ LNG ['sys_expe_time_slow_5'] = 'uyarı olmadan filo doğrudan atladı yabancı bir gemi ile çarpışması filonuzun Expedition kurşun gemi. Yabancı gemi ve patlayan kurşun gemiye zarar önemli idi. coarsest Onarım tamamlandıktan sonra bu haliyle, Expedition devam edilebilir, çünkü geri yolda gemi yapacak. "; 
$ LNG ['sys_expe_time_slow_6'] = 'bu kadar da geri hesaplamak için biraz zaman aldı seferinin atlama sahte bir kırmızı dev yıldız rüzgârı. Bu söyleniyor, Expedition şey yıldızlar arasındaki boşluğu dışarı geldi sektör vardı ".; 
$ LNG ['sys_expe_nothing_1'] = 'bazı antika dışında, bilinmeyen bir gezegenden küçük yaratıklar hiçbir şey onu gezi hakkında heyecan verici, keşif bataklık getiriyor.'; 
$ LNG ['sys_expe_nothing_2'] bir süpernova = 'Sizin Expedition güzel resimler yaptı. Gerçekten yeni bilgileri ancak, bu sefer getirmedi. Ama en iyi resim-Des-Evren rekabet iyi bir şans, bu yıl ".; 
$ LNG ['sys_expe_nothing_3'] = 'kısa bir süre felç navigasyon güneş sistemi ayrıldıktan sonra belirtilen garip bir bilgisayar virüsü. Bu sefer tüm filo her zaman çevrelerinde uçtu anlamına geliyordu. Gereksiz sefer özellikle başarılı olmadığını söylemek ".; 
$ LNG ['sys_expe_nothing_4'] saf enerji = 'bir yaşam sağlamıştır ekranlarda hipnotik desenleri bakarken gün boyunca bütün sefer üyeleri. Sonunda büyük bir bölümünü kafasında tekrar açık hale geldiğimde, sefer, ancak iptal edilecek akut sıkıntısı döteryum ', nedeniyle oldu. 
$ LNG ['sys_expe_nothing_5'] = 'Eh, artık o Sınıf 5 kırmızı anomalileri deniz sistemlerde sadece kaotik etkiler, fakat aynı zamanda ekip olarak büyük halüsinasyonlar nedeni değil biliyorum en azından. Daha bu sefer 'getirmedi;. 
$ LNG ['sys_expe_nothing_6'] = 'Bu sektör tarama umut verici bir başlangıca rağmen, biz boş ellerle geri maalesef vardır.'; 
$ LNG ['sys_expe_nothing_7'] = 'Belki bu uzak gezegende kaptan doğum günü kutlamak zorunda değilsiniz. Bir kötü sıtma revirde seferine eşlik mürettebat çoğunu zorlamıştır. Akut personeli sıkıntısı sefer başarısız anlamına geliyordu. "; 
$ LNG ['sys_expe_nothing_8'] = 'Sizin sefer uzay tanıdık geçersiz olan, kelimenin tam anlamıyla vardır. Hatta küçük bir asteroid ya da radyasyon veya parçacık, ya da bir şey bu heyecan verici keşif yapmış olur değildi ".; 
reaktör gemi yönetiminin $ LNG ['sys_expe_nothing_9'] = 'Bir hata neredeyse tüm seferi tahrip etti. Neyse ki, yetenekli fazla teknisyen ve kötü engelleyebilir. Ancak, onarım sefer eli boş döndü ki, çok zaman aldı. "; 
= $ LNG ['sys_expe_attack_1_1_1'] 'Birkaç çok umutsuz alan korsanlar gibi bizim sefer filo kaçırmak için çalıştı.'; 
$ LNG ['sys_expe_attack_1_1_2'] Bazı ilkel barbarlar bile gemi adı başlamak değil hak uzay, bize saldırıyorlar '=. Bombardıman ciddi boyutlara varsayarsak, biz yangın yanıt vermek zorunda kalıyorlar. "; 
$ LNG ['sys_expe_attack_1_1_3'] = 'Bazı çok sarhoş korsan radyo mesajları topladık. Biz saldırıya gibi görünüyor. "; 
$ LNG ['sys_expe_attack_1_1_4'] = 'Biz neyse ki çok sayıda olmayan bazı korsanlar, karşı kendimizi savunmak zorunda kaldı.'; 
$ LNG ['sys_expe_attack_1_1_5'] belli bir Tikarr Moa ve onun vahşi paketi filomuzun kayıtsız şartsız teslimiyet gerektirir = 'Bizim sefer filo raporlar. ciddi olsun, onlar bizim gemi iyi savunmak için biliyorum bulmak zorunda kalacaktır. "; 
$ LNG ['sys_expe_attack_1_2_1'] = 'Sizin Expedition Filo biraz boşluk korsanlarla kötü bir karşılaşma oldu.'; 
$ LNG ['sys_expe_attack_1_2_2'] = 'Bazı yıldızların pusuda olan, korsanlar gel! Bir savaş ne yazık ki kaçınılmaz oldu. "; 
seferi ardından yardım için $ LNG ['sys_expe_attack_1_2_3'] = 'çağrısı, kötü olduğu ortaya çıktı, bazı kötü niyetli yıldız Buccaneers eğer. Bir savaş kaçınılmaz oldu. "; 
$ LNG ['sys_expe_attack_1_3_1'] = 'toplanan sinyaller, diğer varlıklar tarafından değil kökenli ama gizli bir korsan üssü tarafından! Korsanlar özellikle hevesli değil kendi sektöründe varlığımızı vardı ".; 
$ = 'Sefer filo tanımlanamayan korsan gemisi ile şiddetli çatışmalar raporları' LNG ['sys_expe_attack_1_3_2']; 
$ LNG ['sys_expe_attack_2_1_1'] = 'Sizin Seferi filo bilinmeyen bir tür olan değil, çok dostu ilk temas vardı.'; 
$ LNG ['sys_expe_attack_2_1_2'] = 'Bazı tuhaf görünümlü gemi uyarı olmadan saldırmış, keşif filosu'; 
$ LNG ['sys_expe_attack_2_1_3'] = 'sefer bilinmeyen gemiler küçük bir grup tarafından saldırıya uğradı'; 
$ LNG ['sys_expe_attack_2_1_4'] bilinmeyen gemileriyle = 'sefer filo raporları başvurun. Telsiz mesajları, şifresi değil silahlarını aktif hale getirmek için yabancı gemiler görünüyor ".; 
$ LNG ['sys_expe_attack_2_2_1'] = 'bizim sefer saldıran bilinmeyen bir tür'; 
$ LNG ['sys_expe_attack_2_2_2'] = 'Sizin Expedition filo görünüşte şimdiye kadar bilinmeyen ancak son derece agresif ve savaşçı yabancı ırk topraklarının ihlal etmiştir.'; 
bizim sefer filosuna $ LNG ['sys_expe_attack_2_2_3'] = 'Bağlantı kısa vadede rahatsız etti. biz doğru son mesaj hakkında öğrendim kadarıyla, filo ağır ateş altında - saldırganların 'tespit edilememiştir;. 
$ LNG ['sys_expe_attack_2_3_1'] = 'Sizin sefer bir uzaylı istilası filo içine düşmüş ve ağır mücadele rapor'; 
$ LNG ['sys_expe_attack_2_3_2'] bilinmeyen kristal gemilerin = 'büyük bir oluşum bizim keşif filosu ile doğrudan bir çarpışma rotasında vardır. Belki en kötü düşünmek gerekir. "; 
$ LNG ['sys_expe_attackname_1'] = 'korsan'; 
$ LNG ['sys_expe_attackname_2'] = 'Yabancılar'; 
$ LNG ['sys_expe_back_home'] = 'filonuzun geri <br>% var seferi dan Zurükgekehrt% s,% s% s,% s% s%% getirdi s "ler..; 
$ LNG ['sys_expe_back_home_without_dm'] = 'Sizin filo tekrar seferinin zurükgekehrt olduğunu.'; 
$ LNG ['sys_expe_back_home_with_dm'] = '. Filonuzun Zurükgekehrt ve geri oluşturmuştur sefer <br> gefun temettü% s (% s) dan gemiler hala önlenebilecek% s <br> hurdaya ayrılmıştır ..'; 
$ LNG ['sys_mess_transport'] = 'Ulaştırma raporu'; 
$ LNG ['sys_tran_mess_owner'] senin filolarından biri gezegenin% s%%% s%% s% s% s ve sarf malzemeleri, s ulaştı s. '=; 
$ LNG ['sys_tran_mess_user'] = '% A huzurlu filosunun% s s% s%% s% s ve gereçleri,% s% s% s% s s'; 
$ LNG ['sys_mess_fleetback'] = 'filo dön'; 
$ LNG ['sys_tran_mess_back'] = 'Bir senin filolarının gezegen%% geri dönüyor etrafta.'; 
$ LNG ['sys_recy_gotten'] 'Sizin geridönüşümü s% s% s%% toplanan s var.' =; 
$ LNG ['sys_gain'] = 'Kar'; 
$ LNG ['sys_irak_subject'] = 'füze saldırısı'; 
$ LNG ['sys_irak_no_def'] = 'gezegen yok savunma var'; 
$ LNG ['sys_irak_no_att'] = 'Tüm füzeleri ele alındı.'; 
$ LNG ['sys_irak_def'] = '% için roket füze d ele alındı arası.'; 
$ LNG ['sys_irak_mess'] = 'gezegenlerarası (% d)% gezegen <br>% s damgalanır s'; 
$ LNG ['sys_gain'] = 'Kar'; 
$ LNG ['sys_fleet_won'] = 'saldırı%% s geri s gezegenin etrafında filolarından biri. '% S% s,% s% s% s% s ganimet var; 
$ LNG ['sys_perte_attaquant'] = 'kayıplar saldırganların'; 
$ LNG ['sys_perte_defenseur'] = 'kayıp Defans; 
$ LNG ['sys_debris'] = 'enkaz alanına'; 
$ = 'Aşağıdaki filolar her Moon Destruction diğer bakacak' LNG ['sys_destruc_title']; 
'Bir ayın imha Raporu' $ LNG ['sys_mess_destruc_report'] =; 

$ LNG ['sys_destruc_lune'] = 'Bir ayın olasılığı yok edilir:% d%%'; 
$ LNG ['sys_destruc_rip'] = 'filosunun kendini imha olasılığıdır:% d%%'; 
$ LNG ['sys_destruc_stop'] = 'defans başarılı Ay'ın imha engelledi.'; 
$ LNG ['sys_destruc_mess1'] = 'Ölüm Yıldız ay yaptıkları muazzam enerjileri açın.'; 
gezegenden $ LNG ['sys_destruc_mess'] = 'bir filo [% d:% d:% d] [:% d:% d% d]' de ay ulaştı ";. 
$ LNG ['sys_destruc_echec'] = 'deprem gezegen sallamayın. Ama bir şeyler ters gider: ölüm yıldız patlayabilir ve parçalar binlerce içine parçalanır. Şok dalgası <br> tüm filo ulaşır. "; 
$ LNG ['sys_destruc_reussi'] = '. Death Yıldız ışınları aya ulaşmak ve onu tüm ay yıkıldı <br> gözyaşı.'; 
$ LNG ['sys_destruc_null'] = 'Ölüm Yıldız potansiyellerini geliştirebilecekleri edemez ve ay yok değil <br> implode ..'; 


$ LNG ['fcp_colony'] = 'koloni'; 
$ LNG ['fl_simulate'] = 'Simülasyon'; 

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
?>