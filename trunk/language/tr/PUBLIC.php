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

/ / Genel 
$ LNG ['index'] = 'İçindekiler'; 
$ LNG ['kayıt'] = 'Kayıt Ol'; 
$ LNG ['forum'] = 'Forum'; 
$ LNG ['göndermek'] = 'Gönder'; 
$ LNG ['menu_index'] = 'İçindekiler'; 
$ LNG ['menu_news'] = 'Haberler'; 
$ LNG ['menu_rules'] = 'Kurallar'; 
$ LNG ['menu_agb'] = 'açısından'; 
$ LNG ['menu_pranger'] = 'boyunduruk'; 
$ LNG ['menu_top100'] of Fame = 'Hall; 
$ LNG ['menu_disclamer'] = 'Rehber'; 
$ LNG ['uni_closed'] = '(çevrimdışı)'; 

/ * ------------------------------------------------ / ------------------------------------------ * 

$ LNG ['music_off'] = 'Müzik: OFF'; 
$ LNG ['music_on'] = 'Müzik: ON'; 


/ / Index.php 
/ / Case şifre kaybetti 
'Mevcut değil e-posta adresi vererek' $ LNG ['mail_not_exist'] =; 
$ LNG ['mail_title'] = 'Yeni parola'; 
$ LNG ['mail_text'] = 'Yeni şifre:'; 
$ LNG ['mail_sended'] = 'Şifreniz e-posta adresinize gönderildi'; 
$ LNG ['mail_sended_fail'] = 'e-posta gönderilemedi.'; 
$ LNG ['server_infos'] = array ( 
"Gerçek zamanlı bir uzay strateji oyunu." 
"Yüzlerce kullanıcı ile birlikte oynayın." 
"Hayır indir, sadece standart bir tarayıcı gerektirir." 
"Ücretsiz kayıt" 
); 

/ / Case varsayılan 
$ LNG ['login_error_1'] = 'Yanlış kullanıcı adı / şifre'; 
$ LNG ['login_error_2'] = 'Birisi hesabınıza başka bir bilgisayardan oturum vardır'; 
$ LNG ['login_error_3'] 'Oturumunuz zaman aşımına uğradı' =; 
$ LNG ['ekran'] = 'Ekran'; 
$ LNG ['evren'] = 'evren'; 
$ LNG ['chose_a_uni'] = 'bir evren seçin'; 

/ * ------------------------------------------------ / ------------------------------------------ * 

/ / Lostpassword.tpl 
$ LNG ['lost_pass_title'] = 'Şifre'; 
$ LNG ['retrieve_pass'] = 'Geri Yükle'; 
$ LNG ['email'] = 'E-posta adresi'; 

/ / Index_body.tpl 
$ LNG ['user'] = 'Kullanıcı'; 
$ LNG ['pass'] = 'şifre'; 
$ LNG ['remember_pass'] = 'Otomatik Giriş'; 
$ LNG ['kayıp şifre'] = 'Şifre'; 
$ LNG ['welcome_to'] = 'Hoşgeldiniz'; 
= '<strong>% </ Strong> s $ LNG [' server_description '] olmak </ strong> iyi olarak çalışmakla </ strong> aynı zamanda erdumgreifend oyuncuların yüzlerce bir <strong> uzay strateji oyunu . Çalmak gereken standart bir Web tarayıcı ".; 
$ LNG ['server_register'] = 'Register Now'; 
$ LNG ['server_message'] = 'Şimdi kaydolun ve yeni, heyecan verici bir dünya tecrübesi'; 
$ LNG ['login'] = 'Giriş'; 
$ LNG ['Yasal Uyarı'] = 'Rehber'; 
$ LNG ['login_info'] =? Sayfa = kurallar & \ =% 1 $ s ve \ '+ \' lang '+ \' getajax = 1 'giriş ile ben <a onclick = "ajax (\ kabul' \ '); "style =" cursor: pointer; "> Kurallar </ a> ve <a onclick =" ajax (\' page = \ AGB ve '+ \' getajax = 1 & \ '+ \' lang =? % 1 $ s \ '); "style =" cursor: pointer; "> AGB's </ a>'; 

/ * ------------------------------------------------ / ------------------------------------------ * 

/ / Reg.php - Kayıt 
$ LNG ['register_closed'] = 'Kayıt kapalı'; 
$ LNG ['register_at'] = 'katılın'; 
$ LNG ['reg_mail_message_pass'] = 'için bir adım daha kullanıcı adınızı etkinleştirmek'; 
$ LNG ['reg_mail_reg_done'] '% s Hoşgeldiniz' =; 
$ LNG ['invalid_mail_adress'] = 'Geçersiz e-posta adresi <br>'; 
$ LNG ['empty_user_field'] = 'tüm alanları <br> doldurunuz'; 
$ LNG ['password_lenght_error'] = 'Şifre en az 6 karakter uzunluğunda <br> olmalıdır';
$ LNG ['user_field_no_alphanumeric'] = 'Lütfen bir kullanıcı adı sadece alfanümerik karakterler <br>'; 
$ LNG ['user_field_no_space'] = 'Kullanıcı adınızı <br> boşluk girin'; 
$ LNG ['planet_field_no_alphanumeric'] = 'Lütfen isim gezegen sadece alfanümerik karakterler <br>'; 
$ LNG ['planet_field_no_space'] = 'boşluk <br> ile gezegen girin'; 
$ LNG ['terms_and_conditions'] 'Sen <a href="index.php?page=agb"> Koşullar </ a> ve <a href="index.php?page=rules> kuralları </ a> gerekiyor = ! gururla '<br> kabul; 
$ LNG ['user_already_exists'] = 'kullanıcı adı zaten <br> alınır'; 
$ = 'E-posta adresini kullanabilirsiniz <br> zaten' LNG ['mail_already_exists']; 
$ LNG ['wrong_captcha'] = 'Yanlış güvenlik kodu <br>!'; 
$ LNG ['different_passwords'] = 'Bu iki farklı parola <br> girdi'; 
$ LNG ['different_mails'] = 'Sen 2 farklı e-posta adresleri <br> var'; 
$ LNG ['welcome_message_from'] = 'Yönetici'; 
$ LNG ['welcome_message_sender'] = 'Yönetici'; 
$ LNG ['welcome_message_subject'] = 'Hoşgeldiniz'; 
$ LNG ['welcome_message_content'] = '% Hoşgeldiniz s! <br> İlk Build bir güneş enerjisi santrali, enerji hammadde sonraki üretim için gerekli çünkü. Bunu inşa etmek için, "bina" menüsüne sol tıklayın. Daha sonra 4 kurmak Yukarıdaki Binası. Şimdi enerjiye sahip olduğundan, mayınların inşa etmeye başlayabilirsiniz. geri binasında menüsüne gidin ve bir metal maden kurmak, daha sonra tekrar kristal madeni. gemi inşa etmek için, bu nedenle ilk bir uzay gemisi tersane inşa olmalıdır. Ne anlık mesajlaşma teknolojisi linkleri bulabilirsiniz paspaslar vardır. Ekibi, evrenin keşfetmek çok eğlenceli dilek! "; 
$ LNG ['newpass_smtp_email_error'] = '<br> bir hata oluştu. Senin şifre: '; 
$ LNG ['reg_completed'] = 'Kayıt olduğunuz için teşekkür ederiz! Eğer bir etkinleştirme bağlantısı 'ile bir e-posta alacaksınız;. 
$ LNG ['planet_already_exists'] = 'gezegen konum zaten işgal <br> olduğunu'; 

/ / Registry_form.tpl 
$ LNG ['server_message_reg'] = 'Şimdi kaydolun ve bir parçasıyım'; 
$ LNG ['register_at_reg'] = 'katılın'; 
$ LNG ['uni_reg'] = 'evren'; 
$ LNG ['user_reg'] = 'Kullanıcı'; 
$ LNG ['pass_reg'] = 'şifre'; 
$ LNG ['pass2_reg'] = 'Şifre tekrar oyuk'; 
$ LNG ['email_reg'] = 'E-posta adresi'; 
$ LNG ['email2_reg'] = 'e-posta adresi yine içi boş'; 
$ LNG ['planet_reg'] = 'büyük gezegenlerin Adı'; 
$ LNG ['lang_reg'] = 'Dil'; 
$ LNG ['register_now'] = 'Kayıt Ol'; 
$ LNG ['captcha_reg'] = 'gizli soru'; 
$ LNG ['accept_terms_and_conditions'] = '<Lütfen onclick = "ajax (\'? Sayfa = kurallarına & \ & \ '+ \' lang '+ \' getajax = 1 =% 1 $ s \ ');" style = "cursor: pointer;"> Kurallar </ a> <a onclick = "ajax (\ + \ + \ 've \ getajax = 1' =% 1 $ s lang \ 'page = \ AGB &?' ) "style =" cursor: pointer; gururla> AGB `/ a> 's <kabul; 
$ LNG ['captcha_reload'] = 'yeniden'; 
$ LNG ['captcha_help'] = 'Yardım'; 
$ LNG ['captcha_get_image'] = 'image-captcha yükleniyor'; 
$ LNG ['captcha_reload'] = 'Yeni CAPTCHA'; 
$ LNG ['captcha_get_audio'] = 'Yük ses CAPTCHA'; 
$ LNG ['user_active'] = 'Kullanıcı% s devre dışı bırakıldı'; 

/ / Registry_closed.tpl 
$ LNG ['bilgi'] = 'Bilgi'; 
$ LNG ['reg_closed'] = 'Kayıt kapalı'; 

/ / Kurallar 
$ LNG ['rules_overview'] = "kurallar"; 
$ LNG ['kural'] = array ( 
"Hesaplar" => "Bir hesabın sahibi her firma e-posta adresinin sahibi. Hesap sadece tek başına oynadı olabilir. 
Tek istisna ahlaki olduğunu. başka bir monitör hesabı için gerekli ya da set tatil moduna haline mi gerekir 
yetkili operatör önceden haberdar olmalı ve onun onayını almanız. 12 saatin altında kısa vadeli alışkanlıkları için, bir mesaj operatör gider. 
tüm görgü filo hareketleri yasaklandı, sadece Saven üzerinde filo uygar koordinatlarını ve hangi onlar izin verilir yalan gezegendeki hammaddeler engelleyebilir. 
Hesap fazla 72h için oturdu olabilir. istisnalar dışında, bir operatör izni varsa. 
Bir hesabın geçen max olabilir. her 3 ayda bir ve sadece ücretsiz yapılır. 
Ausnamhen operatör giriş yapın. " 

"Çok hesapları" => "Her oyuncu için sadece evrenin başına bir hesap oynamak için izin verilir. Iki veya daha fazla hesap genellikle oynadı iseniz, zaman zaman veya sürekli aynı internet bağlantısı (örneğin, okullar, üniversiteler ve internet kafeler için), bu kadar yapmalısınız önceden bir yönetici bilgilendirmek. Bu gibi durumlarda, herhangi bir filo temas ilgili hesaplara yasak aynı Internet bağlantısını kullanırken. Benzer şekilde, diğer ortak yasak. " 

yasak => "hep bastırıyor. zayıf daha fazla hesap görüntülenen gelin yeterli dikkate almadan kaynak arzı tüm itme görülebileceği gibi" itme ". 
Istisnalar operatör tarafından önceden onaylanmalıdır. onay eksikliği güvenliği için bastırıyor için askıya alınmasına neden olabilir. 
Bir ticaret 24 saat içinde tamamlanması gerekir veya bir operatöre bildirilir. " 

bash aynı gezegende 24 saat içinde "Bash" => "En az beş saldırıları ve yasaktır - Ay bağımsız bir gezegen saldırıları Spiosonden gezegenlerarası ya da sayılır gibi olmak biridir .. 
Bashregel sadece aktif oyuncular için geçerlidir. bu nedenle daha fazla saldırılarına izin verir, savaş partiler var. forumda daha fazla saldırı söylemeden önce savaş en az 24 saat olmalıdır (konu var, hem ittifaklar duyuru, ya da savaş-açıklayıcı tek oyuncunun adını doğru yazım adlandırılmış olması). savaş beyanı sadece ittifak hitap edilebilir, Savaş ilanından bir ittifak veya tek bir kişi üzerinden gerçekleştirilebilir "dedi. 
Savaşın bir kabul gerekli değildir. Bashregel sadece bariz büyük kaçırma hizmet Savaşları yasaktır. Bu yargıç kolaylaştırıcı ve operatörlerin sorumluluğundadır. " 

"Irak krizi" => "24 saat başına sadece 1.000 izin Irak'ta saldırılar vardır. Saldırı başına füzelerin sayısı bağımsızdır." 

"Bugusing" => "programlama hataları ve / veya hata istismar yasaktır. Cheating de yasaktır. Algılandı böcek Bugforum, IRC, e-posta veya ICQ sonrası tarafından en kısa sürede rapor edilmelidir." 

"Dil oyunu" => "oyun Almanca / İngilizce resmi dil evrenler tüm olabilir. İhlaller yasağı cezası olabilir. Yabancı dil-oyunu haber / Allypages yasak tabi yol açar." 

"Tehditler / hakaret" => "RL gasp ve tehdit birinin dışlama veya tüm titanyum Uzay alanlarda yol açar. 
tehditler ve gerçek hayat şantaj olduğundan oyun içi mesajlar, forum, IRC kanalları ve kamu diyaloglar özel diyaloglar attı, benzersiz tasarımları bir kişiyi bulmak için ve sizin veya yakın bir üçüncü kişiye zarar vermek için sinyal. " 

"Spam ve erotik" => "erotik ve pornografik materyal Spam ve yabancı reklam verboten.Jeweilige form yasaktır. Geandet Ve evren geniş ve yaşam boyu blok!" 

"Kurallar" => "kurallar ve değişebilir, her kullanıcının sürekli ilerleme hakkında bilgi için gereklidir!" 

); 

$ LNG ['rules_info1'] = "Bu, ancak haberdar olan <a href=\"%s\" target=\"_blank\"> Forumu </ a> ve ana sayfada oyun ..."; hakkında 
$ LNG ['rules_info2'] = "Bu oldular tamamlayan <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\"> Koşullar </ a> </ font> "saygı gösterilmesini; 


/ / Şartlar ve Koşullar 

$ LNG ['agb_overview'] = "Şartlar"; 
$ LNG ['AGB'] = array ( 
Performans içerik "=> array ( 
"Politikaların tanıma oyununa katılmak için gerekli bir koşul vardır. 
Onlar Forumu ve diğer oyunla ilgili içerik dahil operatörleri, adına tüm teklifler için geçerlidir. " 

"Teklif ücretsizdir. 
Böylece, kullanılabilirlik, teslimat performansı veya zararlardan hiçbir gereksinimleri vardır. 
Ayrıca, oyuncu onun hesabını olumsuz tedavi olması gereken, kurtarma hakkına sahip değildir. " 
) 

"Üyelik" => array ( 
"Oyunda kayıt tamamlanması ve / veya forum üyeliğine ile maç başlayacaktır." 

"Herhangi bir zamanda kayıt üyeliği ile başlayan hesap silerek veya bir yönetici yazarak üye tarafından sona erdirilebilir. 
teknik nedenlerden dolayı bir veri silme, anlık değildir. " 

"Fesih operatör tarafından Hiçbir kullanıcı operatör teklif katılmak için herhangi bir hakkı vardır. 
Operatör rezervleri hesapları silme hakkı saklıdır. 
Bir hesabın iptal kararı operatör ve yönetici ve operatör ile maksadıyla kullanılmaktadır. 
üyelik için herhangi bir yasal talep hakkı bulunmamaktadır. " 

"Tüm hakları operatör ile kalır." 
) 

"Içerik / Sorumluluk" => "çeşitli oyun ile ilgili iletişimin içeriği kullanıcılar sorumludur. Pornografik, ırkçı, saldırgan ya da başka herhangi bir hukuk operatörün sorumluluğu dışında içeriğe karşı violative. 
Ihlalleri derhal iptal veya askıya alınmasına neden olabilir. 
Bu tür içeriklerin silinmesi, ancak en kısa sürede ve / veya kişisel nedenlerle teknik için gecikmiş olabilir. " 

"Yasak fiil" => array ( 
"Kullanıcı donanım / yazılım ve diğer maddelerin veya mekanizmalar işlev ve oyun engelleyebilir web sitesi ile ilgili kullanma yetkisi yoktur. 
Kullanıcı neden olabilir teknik kapasitenin mantıksız bir veya artan yük getirmektedir herhangi bir işlem devam edebilir. 
Kullanıcı veya operatör tarafından oluşturulan içerik işlemek için izin verilmez aksi takdirde oyun müdahale. " 

"Her türlü bot, script ya da diğer otomatik fonksiyonları yasaktır. 
Oyun tarayıcı sadece çalınabilir. Hatta onun fonksiyonlarını bir oyun avantaj sağlamak için kullanılmamalıdır. 
Böylece değil bloke reklamını yapmak olabilir. Bir yazılım oyuncu için avantajlı iken karar verme / operatörlerinin yöneticileri / ile sadece operatörüdür. " 

"Otomatik bir giriş sayfası görüntülenir olup olmadığını izin verilmiyor ne olursa olsun, hesap açmak." 
) 

"Kullanım limit" => array ( 
"Bir oyuncu sadece, evren için bir hesap kullanabilir denilen \" MULTIS \ "ve izin verilmez uyarı yapılmadan silinebilir veya bloke oldu. 
Bir \ mevcut "çok \" / operatörler / yöneticileri operatörü ile sadece yalan zaman karar vermek. " 

"Detayları kurallara tabi olacaktır." 

"Kilitler kalıcı olarak operatör veya geçici takdirine bağlıdır. 
Benzer şekilde, kilitler herhangi bir veya tüm alanlarda çeşitli oynayabilirsiniz. 
/ Yöneticileriyle / operatörler tek operatör olduğunu ne zaman ve ne kadar bir oyuncu bloke olur ve karar. " 
) 

"Gizlilik" => array ( 
"Operatör saklı düzen kurallarına, şartlarına ve yürürlükteki yasalara uygun izlenmesi için oyuncuların veri depolamak için doğru. 
Açılan tüm gerekli ve oyuncu ya da onun hesabını verileri sundu. 
Bu (kullanım ve doluluk, kayıt-posta adresinizi ve daha sırasında veri dönemlere ilişkin IP'leri içerir. 
profil veri var forumda saklanır. " 

"Bu veriler de katip ve diğer yararlanıcılar için yasal görevlerin performans için yayınlanır. 
Ayrıca, veri (gerekirse) da üçüncü kişilere yayınladı. " 

"Kullanıcı herhangi bir zamanda kendi kişisel verilerinin depolama itiraz edebilir. Bir fesih İtiraz aynıdır." 
) 

=> Array "gösterilebilir operatörün Hakları" ( 
"Tüm hesapları ve tüm sanal nesneler bulundurmak ve operatör süreli kalır. 
Oyuncu mülkiyeti ve herhangi bir hesabı veya parçaları diğer hak elde etmez. 
Tüm hakları operatör ile kalır. 
sömürü ya da kullanıcıya diğer haklar bir transfer her zaman gerçekleşecektir. " 

"Yetkisiz satışı, kullanımı, kopyalama, dağıtma, çoğaltma veya başka buna göre takibat yapılacaktır yasalara operatör yasal haklarını (örneğin hesabında gibi) ihlal etmek. 
Açıkça kuralları izin verdiği ölçüde hesapların serbest, son transfer ve kendi evrendeki kaynakların ticari ve izin verilir. " 
) 

"Sorumluluk" => "Her evrenin operatör hasarlardan sorumlu değildir. 
Bir sorumluluk kasıt veya ağır ihmal ve yaşamı ve sağlığı için tüm zarar verdiği zararlara dışında söz konusu değildir. 
Bu bakımdan, açıkça bilgisayar oyunlarının önemli sağlık riskleri oluşturabilir olduğu ortaya konmaktadır. 
Zarar operatör tarafından değildir. " 

=> "Operatörü saklı ya da herhangi bir zamanda bu şartları değiştirmek için genişletmek için sağ" Şartlar Değişim ". 
Bir değişiklik veya ilave Forum yayınlanan tarihten en az bir haftadır. " 
); 

/ / Facebook Connect 

$ LNG ['fb_perm'] = 'Bir erişim yasak var. % S, böylece Facebook Hesabı ile giriş yapabilirsiniz \ nAlternatively bir Facebook hesabı olmadan giriş yapabilir tüm haklara ihtiyacı vardır.!; 

/ / HABER 

$ LNG ['news_overview'] = "haber"; 
$ LNG ['news_from'] = '%% s "dan s On; 
$ LNG ['news_does_not_exist'] = "haber"; 

/ / Künye 

$ LNG ['Yasal Uyarı'] = "reddi"; 
$ LNG ['disclamer_name'] = ""; 
$ LNG ['disclamer_adress'] = ""; 
$ LNG ['disclamer_tel'] = ""; 
$ LNG ['disclamer_email'] = ""; 
?>