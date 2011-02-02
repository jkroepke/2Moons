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

$ LNG ['devam'] = "Sonraki"; 

$ LNG ['menu_intro'] = "Giriş"; 
$ LNG ['menu_install'] = "Yükle"; 
$ LNG ['menu_license'] = "lisans"; 
$ LNG ['menu_convert'] = "Converter"; 

$ LNG ['intro_lang'] = "dil"; 
$ LNG ['intro_instal'] = "Kurulum"; 
$ LNG ['intro_welcome'] = "Hoşgeldiniz 2Moons için!"; 
$ LNG ['intro_text'] = "2Moons OGame. <br> 2Moons en iyi klon biri XNova şimdiye kadar üretilmiş. 2Moons kararlılık, esneklik, dinamizm, kalite ve kullanışlılık ile parlayan ve en kararlı son sürümü olduğunu. Umarız daha beklentilerinden daha olma. kurulum boyunca size rehberlik edecek ya da en geç bir önceki sürümüne yükseltme yükleme sistemi <br>. Herhangi bir soru, bir sorun bizim geliştirme ve destek başvurmaktan çekinmeyin. <br> 2Moons bir açık kaynak projesi olan ve GNU GPL v3 lisansı altında. Lisansı uygun menü menü için tıklayın. kurulumdan önce <br> küçük bir test önce başlamış olabilir Onlar minimum gereksinimleri destek olmadığı konusunda yapılan ".; 

$ LNG ['reg_yes'] = "Evet"; 
$ LNG ['reg_no'] = "Hayır"; 
$ = "Bulundu" LNG ['reg_found']; 
$ LNG ['reg_not_found'] = "Bulunamadı"; 
$ LNG ['reg_writable'] = "Yazılabilir"; 
$ LNG ['reg_not_writable'] = "Not Yazilabilir"; 
$ LNG ['reg_file'] = "dosya"; 
$ LNG ['reg_dir'] = "klasör"; 
$ LNG ['reg_gd_need'] = "TR-Lib var"; 
$ = LNG ['reg_mysqli_need'] "MySQLi mevcut"; 
$ LNG ['reg_json_need'] = 'JSON mevcut "; 
$ LNG ['reg_bcmath_need'] = "BCMath var"; 
$ LNG ['reg_iniset_need'] = "izin ini_set"; 
$ LNG ['req_php_need'] = "PHP sürümü (en az 5.2.5)"; 
$ = "Güvenli Mod aktif" LNG ['req_smode_active']; 
$ LNG ['req_ftp'] = "FTP"; 
$ LNG ['req_ftp_info'] = "sorunları çözmek için FTP bilgilerini girin."; 
$ LNG ['req_ftp_host'] = "FTP Host"; 
$ LNG ['req_ftp_username'] = "Kullanıcı Adı"; 
$ LNG ['req_ftp_password'] = "password"; 
$ LNG ['req_ftp_dir'] = "2Moons yolu"; 
$ LNG ['req_ftp_send'] = "Gönder"; 
$ LNG ['req_ftp_pass_info'] "Parolanız kayıtlı değildir"; 

$ LNG ['step1_notice_chmod'] = "emin olun config.php dosyasına \" olabilir, bu nedenle, Yazilabilir, "777 \; 
$ LNG ['step1_mysql_server'] = "MySQL veritabanı sunucusu: <br> Varsayılan: localhost"; 
$ LNG ['step1_mysql_port'] = "MySQL veritabanı sunucusu bağlantı noktası: <br> Varsayılan: 3306"; 
$ LNG ['step1_mysql_dbname'] = 'MySQL veritabanı adı: Ex ile <br>: Oyunu ";. 
$ LNG ['step1_mysql_dbuser'] = "MySQL DB User: <br> Ex: kök."; 
$ LNG ['step1_mysql_dbpass'] = "MySQL Veritabanı şifresi: Ex ile <br>: 12345."; 
$ LNG ['step1_mysql_prefix'] =; "MySQL-DB-Önek:: Ex ile <br> uni1_." 

başarılı bir veritabanına $ LNG ['step2_db_connet_ok'] = "..."; bağlantı 
$ LNG ['step2_db_create_ok'] = "Veritabanı tabloları başarıyla ...."; hazırlandı 
"Veritabanı tabloları oluşturulurken hata:% s" $ LNG ['step2_db_error'] =; 
$ LNG ['step2_db_con_fail'] = "Veritabanı <br>% bağlanmak için s. kurulamıyor"; 
$ LNG ['step2_conf_op_fail'] = "config.php 777 ayarlı değil"; 
$ LNG ['step2_conf_create'] = "config.php başarıyla oluşturuldu ..."; 

$ LNG ['step3_create_admin'] = '"Bir Yönetici hesabı oluşturun; 
$ LNG ['step3_admin_name'] = 'Yönetici Kullanıcı Adı: "; 
$ LNG ['step3_admin_pass'] = 'Yönetici Parolası: "; 
$ LNG ['step3_admin_mail'] = "Yönetici E-mail adresi:"; 


$ LNG ['step4_need_fields'] = "Tüm alanları doldurmak gerekir"; 


$ LNG ['convert_install'] = "ilk yoluyla 2Moons temiz bir kurulum yapmak"; 
$ LNG ['convert_version'] = "Mevcut sürümünü seçin:"; 
$ LNG ['convert_info'] = "Burada veritabanına eski verilerinizi girin"; 
$ LNG ['convert_submit'] = "Convert 2Moons için"; 
$ LNG ['convert_done'] = "İşlem başarıyla tamamlandı"; 


?>