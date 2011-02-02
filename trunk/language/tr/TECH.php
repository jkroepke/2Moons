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
SAVAŞ RAPORLARI İÇİN / / KISA ADI 
$ LNG ['tech_rc'] = array ( 
202 => 'Küçük Nakliye Gemisi', 
203 => 'Büyük Nakliye Gemisi', 
204 => 'Light Fighter' 
205 => 'Ağır Avcı' 
206 => 'kruvazör' 
207 => 'savaş', 
208 => 'koloni gemisi' 
209 => 'Recycler' 
210 => 'casus sonda' 
211 => 'bombacı' 
212 => 'uydu güneş' 
213 => 'imha' 
214 => 'Ölüm Yıldızı' 
215 => 'savaş gemisi' 
216 => 'Lune Noire' 
217 => 'Evo. Taşıma ' 
218 => 'Avatar' 
219 => 'Gigarecycler' 
220 => 'Inter. DM-koleksiyon, 

401 => 'roketatar' 
402 => 'Işık Lazer' 
403 => 'Ağır Lazer' 
404 => 'Gaußkanone' 
405 => 'ion silah' 
406 => 'Plazma Gun' 
407 => 'Küçük Kalkan Kubbesi' 
408 => 'Büyük Kalkan Kubbesi' 
409 => 'Dev Kalkan Kubbesi' 
410 => 'Gravitonenkanone' 
411 => 'yörünge savunma platformu' 
); 



$ LNG ['teknoloji'] = array ( 
  0 => 'tasarım', 
  1 => 'Metal madencilik', 
  2 => 'Crystal Mine' 
  3 => 'Deuteriumsynthetisierer' 
  4 => 'Güneş Enerjisi Santrali' 
  6 => 'techno kubbe' 
 12 => 'nükleer santral' 
 14 => 'robot fabrikası' 
 15 => 'Nanit Fabrikası' 
 21 => 'Tersane' 
 22 => 'hafıza metal', 
 23 => 'kristal hafıza', 
 24 => 'Döteryum Tank' 
 31 => 'laboratuvar' 
 33 => 'Eski Terra' 
 34 => 'İttifak Depot' 
 44 => 'füze silosu' 


 40 => 'binalar moon' 
 41 => 'taban taban' 
 42 => 'Sensorenphalax' 
 43 => 'Jumpgate' 
/ / Teknolojileri 
100 => 'araştırma', 
106 => 'Spy Aygıtları' 
108 => 'bilgisayar teknolojisi', 
109 => 'silah' 
110 => 'kalkan teknoloji' 
111 => 'Zırh' 
113 => 'Enerji Teknolojileri ", 
114 => 'Hiperuzay Tekniği' 
115 => 'içten yanmalı motor' 
117 => 'Darbe Drive' 
118 => 'Hyperdrive' 
120 => 'lazer teknolojisi', 
121 => 'iyon teknolojisi " 
122 => 'plazma teknolojisi', 
123 => 'Galaksiler arası araştırma ağı' 
124 => 'astrofizik' 
131 => 'üretim maksimizasyonu metal', 
132 => 'üretim maksimizasyonu kristal' 
133 => 'üretim maksimizasyonu döteryum' 
199 => 'Gravitasyon' 

200 => 'Gemiler', 
202 => 'Küçük Nakliye Gemisi', 
203 => 'Büyük Nakliye Gemisi', 
204 => 'Light Fighter' 
205 => 'Ağır Avcı' 
206 => 'kruvazör' 
207 => 'savaş', 
208 => 'koloni gemisi' 
209 => 'Recycler' 
210 => 'casus sonda' 
211 => 'bombacı' 
212 => 'uydu güneş' 
213 => 'imha' 
214 => 'Ölüm Yıldızı' 
215 => 'savaş gemisi' 
216 => 'Lune Noire' 
217 => 'Evrim Transporter', 
218 => 'Avatar' 
219 => 'Gigarecycler' 
220 => 'Intergalactic madde D. koleksiyon 

400 => 'savunma', 
401 => 'roketatar' 
402 => 'Işık Lazer' 
403 => 'Ağır Lazer' 
404 => 'Gaußkanone' 
405 => 'ion silah' 
406 => 'Plazma Gun' 
407 => 'Küçük Kalkan Kubbesi' 
408 => 'Büyük Kalkan Kubbesi' 
409 => 'Dev Kalkan Kubbesi' 
410 => 'Gravitonkanone' 
411 => 'yörünge savunma platformu' 

502 => 'önleme' 
503 => 'gezegenlerarası' 

600 => 'subay' 
601 => 'jeolog' 
602 => 'Amiral' 
603 => 'mühendis', 
604 => 'teknokrat' 
605 => 'tasarımcı' 
606 => 'bilim adamları', 
607 => 'iskele' 
608 => 'Savunma' 
609 => 'bin' 
610 => 'casus' 
611 => 'Komutan' 
612 => 'imha' 
613 => "Genel", 
614 => 'fatihi', 
615 => 'Imperator' 

700 => 'silah optimizasyonu', 
701 => 'plaka optimizasyonu', 
702 => 'Baukoordinierung' 
703 => 'kaynak optimizasyonu', 
704 => 'güç optimizasyonu', 
705 => 'araştırma optimizasyonu', 
706 => 'filo koordinasyon', 
); 

$ LNG ['res'] ['açıklama'] = array ( 
1 => 'bina ve gemi destek yapıları yapımı için hammadde ana tedarikçileri.' 
2 => 'elektronik bileşenler ve alaşımlar için hammadde ana tedarikçileri.' 
3 => 'bir gezegenin düşük döteryum içeriği su mahrum.' 
4 => 'güneş enerjisi santralleri güneş ışığından enerji üretir. Bazı binaların işletilmesine ilişkin enerji gerektirir. ' 
6 => 'Eğer seviye% 8 başına araştırma süresini kısaltmak için.' 
12 => 'nükleer santral çubuklar döteryum yapılmıştır yakıt enerji gelmektedir.' 
14 => 'robot fabrikaları gezegenin altyapısının yapımında kullanılan vasıfsız işçiler mevcut sağlamak. Her seviyede binaların genişleme hızını artırır. ' 
15 => 'Takımları robotik dar taç giyme. Her adım binalar, gemiler ve savunma inşaat yarıya indirir. " 
21 => 'gezegen bahçesinde gemi ve savunma her türlü inşa edilir.' 
22 => 'ham metal cevherleri için depolama tesisi onlar işlenmeden önce.' 
23 => 'işlenmemiş kristal için site o işlenmeden önce.' 
24 => 'yeni alınan döteryum büyük depolama tankları.' 
31> 'yeni teknolojileri keşfetmek amacıyla bir araştırma istasyonu operasyon gereklidir.' = 
33 => 'kullanılabilir alan gezegen üzerinde yükseltilmiştir. Terraformer' 
34 => 'İttifak Depo savunma ve yörüngede yardımcı dostu filolarından yakıt ile sunulur imkanı sunuyor.' 
41 => 'Ay bir ay üssü yerleşim önce kurulmuş olmalıdır, bu nedenle, hiç bir atmosfere sahiptir.' 
42 => "sensör dizisi filo hareketlerini izlemenize olanak sağlar. Yüksek seviye, falanks daha değişir. ' 
43 => 'dev sıçrama kapıları, evreni, zaman kaybı olmadan bile büyük filolar göndermek edebiliyoruz vericiler bulunuyor.' 
44 => 'füze siloları roket depolanması için kullanılır.' 

106 => 'Bu teknik, diğer gezegenler ve uyduları hakkında bilgi alabilirsiniz.' 
108 => 'bilgisayar kapasitesinin artmasıyla birlikte daha fazla filoları komut olabilir. Bilgisayar teknolojisinin her aşamasında tek filosunun sayısını artırır. ' 
109 => 'silah teknolojisi daha etkili silah sistemleri yapar. silah teknolojisi her düzeyi değerinin% 10 adet silah gücü artırır. ' 
110> 'Shield gemi ve savunma daha verimli kalkanlar yapar =. kalkan teknoloji her düzeyi değerinin% 10 kalkanlar verimliliğini arttırır. ' 
111 => 'Özel alaşımlar uzay zırh her zaman daha iyi yapmak. zırh etkinliği dolayısıyla seviye başına% 10 oranında artış olabilir. ' 
113 => 'enerjinin farklı komutu birçok yeni teknolojiler için gereklidir.' 
114 => '4 entegrasyonu ve 5 Boyut, daha ekonomik ve verimli sürücü yeni bir tür, keşfetmek için artık mümkün. ' 
115 => 'Bu motorların geliştirilmesi, ama daha hızlı bir gemi yapar, her aşamada, değerinin ancak% 10 hızını artırır.' 
117 => 'darbe motor Rükstossprinzip dayanmaktadır. Bu motorların geliştirilmesi, ama daha hızlı bir gemi yapar, her aşamada, değerinin sadece% 20 hızını artırır. ' 
118 => 'bir gemi etrafında uzay eğrileri. Bu motorların geliştirilmesi, ama daha hızlı bir gemi yapar, her aşamada, değerin sadece% 30 hızını artırır. ' 
120 => 'bir nesneye hasar çarptığında ışığı odaklayarak harap bir ışın üreten By.' 
hızlandırılmış iyonlarının 121 => 'Gerçekten ölümcül yönlü kiriş. Bu ölçülemez sonuçları ile darbe üzerine bir nesneye yönlendirilir. ' 
122 => 'iyonları, ancak yüksek enerjili plazma hızlandırır iyon teknolojisi, diğer bir gelişme. Bu bir nesne çarpıcı üzerinde yıkıcı bir etkiye sahiptir. ' 
123 => 'farklı gezegenlerden araştırmacıların her zaman bir gezegenin laboratuvarları azaltmada yardımcı laboratuvar araştırma aşamasının bağlantısı üzerinden birbirleri ile bu ağ üzerinden haberleşirler.' 
124 => 'astrofizik diğer bulgular daha fazla gemi bulunuyor olabilir, laboratuvarlar inşa sağlar. Bu geniş sefer keşfedilmemiş alanlarda mümkündür. alanı daha da kolonizasyon daha fazla ilerleme izin verin. Bu teknolojinin her iki adım için başka bir gezegen harnessed olabilir. ' 
131 => '% 2 metal madeni üretimini artırın' 
132 => '% 2 oranında kristal madenin üretimini artırın' 
133 => '% 2 Deuteriumsynthetisierer üretimini artırın' 
199 => 'Gravitonpartikeln, gemiler hatta aylar yok edilebilir inşa edilecek yapay bir yerçekimi alanını, yoğunlaştırılmış bir yük piyasaya sürerek.' 

202 => 'küçük van hammadde hızla başka bir gezegene taşınabilmektedir çok yönlü bir gemidir.' 
203 => 'küçük van gelişmesi ve daha geniş bir yükleme kapasitesi daha da geliştirilmesi sayesinde daha hızlı küçük van den seyahat sürücü olabilir.' 
204 => 'hafif avcı hemen hemen her gezegende bulunan çok yönlü bir gemi. Maliyeti yüksek değil, kalkan gücü ve pil kapasitesi çok düşüktür. ' 
205 => 'hafif zırhlı savaşçı gelişimi daha iyi ve yüksek saldırı gücüne sahiptir.' 
206 => 'zırhlı kruvazör ağır avcı kadar güçlü neredeyse üç kat daha fazla ateş gücü çift var. Onlar da çok hızlıdır. ' 
207 => 'savaş gemileri genellikle filosunun belkemiğini oluşturmaktadır. Ağır silahlar, yüksek hızlı ve büyük kargo uzay onları ciddi rakip olmak için. ' 
208 => 'uzaylı gezegenler bu gemi ile kolonize olabilir.' 
209 => 'çöp enkaz alanından hammadde alabilirsiniz.' 
210 => 'casusluk probları filoları ve gezegenler üzerinde uzun mesafelerde veri sağlayan küçük ve çevik uçağı vardır.' 
211 => 'bombacı özel bir gezegenin savunma yok etmek için tasarlanmıştır.' 
212 => 'Solar uydular yüksek sabit yörüngede bulunan güneş pilleri basit platformlar vardır. Onlar güneş ışığı toplamak ve yer istasyonu için bir lazer verin. ' 
213 => 'Kral destroyer savaş gemileri arasında yer alıyor.' 
214 => 'Ölüm yıldızı yıkıcı gücü bulunmamaktadır ve o tek bir gemi Monde yok edebilir.' 
215 => 'savaş gemisi düşman filolarının durdurma uzmanlaşmıştır.' 
216 => 'popüler Ölüm Yıldızı olan halefi biraz daha hızlı ve daha güçlü. " 
217 => 'büyük van daha da geliştirilmesi durumunda. O daha fazla yük kapasitesi ve daha hızlı uçuyor. ' 
218 => 'mutlak kötü durum senaryosu, ama çok yavaş. " 
219 => 'dev bir Weltraumrecycleanlage ve hiper-hızlı.' 
220 => 'Bu onun aya toplamak için araştırma karanlık madde yıl sonra Mölich gemi bu.' 

401 => 'Roketatar basit ama savunma maliyetidir.' 
402 => 'fotonlar ile bir hedefin yoğun bombardımanı, bir ölçüde daha fazla zarar etkisi geleneksel balistik silah daha elde edilebilir.' 
403 => 'ağır lazer, lazer ışığının dar mantıksal gelişme.' 
404 => 'elektrik devasa çaba varan hızlarda Gaußkanone tonluk mermiler.' 
405 => 'ion silah kalkan dengeleri bozdu ve elektronik hasarlı hedef üzerinde iyonların bir şaft fırlatır.' 
406 => 'plazma silahlar bir güneş parlaması ücretsiz güç koymak ve yıkıcı etkilerini, hatta destroyer excel.' 
407 => 'Küçük kalkan kubbesi enerji büyük miktarda absorbe bir alan ile tüm gezegeni çevreleyen.' 
408 => 'sipariş saldırıları durdurmak için çok daha fazla enerji kullanabilir Küçük Kalkan Kubbesi geliştirilmesi.' 
409 => 'büyük kalkan kubbesi evrimi levha tekniği taçlandıran, bu sırada başka bir Schildkupeln daha saldırılarını durdurmak için çok daha fazla enerji kullanabilir.' 
410 => 'yerçekimi kuvveti üzerinde araştırma yıl sonra, küçük konsantre Gravitionfelder ve onlar düşmana çekebilirsiniz üreten bir Graviationkanone geliştirmek için araştırmacılar Gelug olduğunu.' 
411 'bir taşınmaz savunma platformu> var =. O ve doğrudan diske sahip gezegenin istikrarlı bir yörüngede Graviton tarafından düzenlenmektedir. Bu sürecin başlangıç enerji düzeyi yüksek gerektirir. ' 

502 => 'füze gezegenlerarası saldıran yok etmek.' 
503 => 'gezegenlerarası karşı savunma yok.' 

700 => '%' de gemi ve saldırı savunma değerini artırın%% s. Bonus geçicidir. ' 
701 => '%' de gemi ve savunma nominal değerleri artış%% s. Bonus geçicidir. ' 
% Için binalar için 702 => 'azaltır inşaat süresi% s%. Bonus geçicidir. ' 
Göre% 703 => 'artırır kaynak üretim%% s. Bonus geçicidir. ' 
% De 704 => 'artırır enerji üretiminin%% s. Bonus geçicidir. ' 
Göre% 705 => 'Cuts araştırma süresi%% s. Bonus geçicidir. ' 
706 => '% tarafından uçuş süresi% s% kısaltır. Bonus geçicidir. ' 
); 


/ / ------------------------------------------------ -------------------------------------------------- -------- 
/ / Mine binalar 
$ LNG ['bilgi'] [1] ['name'] = 'Metal Madencilik'; 
bina ve gemi destek yapıları yapımı için hammadde $ LNG ['bilgi'] [1] ['açıklama'] = 'ana tedarikçilerinden. Metal en ucuz mal, ama diğerlerinden daha fazla ihtiyaç olacak. Metal az enerji üretmek için gerekli. Mayın kaldırılır, daha derin daha bunlar. en gezegenler günü, metal büyük bir derinlikte olduğunu, bu derin madenler daha metaller, üretim artışları çıkartılmaktadır olabilir. Aynı zamanda büyük metal madeni daha fazla enerji için kullanılabilir yapılmalıdır.; 
$ LNG ['bilgi'] [2] ['name'] = 'Kristal Mine'; 
$ LNG ['bilgi'] [2] ['açıklama'] hassas elektronik için gerekli olan minerallerden = 'Yapı. aynı alaşımları ', gerekli mineralleri işlenmiş beri İhtiyacınız olan tek şey, daha fazla. 
$ LNG ['bilgi'] [3] ['name'] = 'Deuteriumsynthetisierer'; 
$ LNG ['bilgi'] [3] ['açıklama'] = 'Döteryum ağır hidrojen olduğunu. Bu nedenle, madenler, deniz altındaki en büyük hisse senetlerine benzer. synthesizer gelişimi de bu döteryum-derin yataklarının geliştirilmesi için sağlar. Döteryum, 'tarama galaksi içine bir göz için ve sensör dizisi, gemiler için yakıt olarak hemen hemen tüm araştırma kullanılır. 

/ / ------------------------------------------------ -------------------------------------------------- -------- 
/ / Enerji binalar 
$ LNG ['bilgi'] [4] ['name'] = 'Güneş Enerjisi Santrali'; 
$ LNG ['bilgi'] [4] ['açıklama'] = 'mayın için güç kaynağı sağlamak ve büyük güneş santrali olan esastır sentezleme için. Bitkiler genişletilir, daha büyük bir yüzey alanı elektrik enerjisine ışık enerjisine dönüştürmek fotovoltaik hücreler ile kaplıdır. Güneş enerjisi santralleri gezegen güneş enerjili duvarın temelini oluşturur; 
$ LNG ['bilgi'] [12] ['name'] = 'nükleer santral'; 
$ LNG ['bilgi'] [12] ['açıklama'] = 'split atomları güneş enerjisi santrali daha fazla enerji oluşturmak olacak nükleer santral, ama daha inşaat pahalıdır.'; 

/ / ------------------------------------------------ -------------------------------------------------- -------- 
/ / Bina 
$ LNG ['bilgi'] [6] ['name'] = 'TechoDome'; 
$ LNG ['bilgi'] [6] ['açıklama'] = 'giderek zaman alan araştırma nedeniyle, galaksiler arası araştırma ağlarının iyi beyinler katıldı ve techno kubbe geliştirdi. % 8 'ile araştırma süresini azaltır; 
$ LNG ['bilgi'] [14] ['name'] = 'Robot Fabrikası'; 
$ LNG ['bilgi'] [14] ['açıklama'] = 'robot fabrikaları gezegenin altyapısının inşası için kullanılabilir vasıfsız işçiler mevcut sağlamak. Her seviyede binaların genişleme hızını artırır.; 
$ LNG ['bilgi'] [15] ['name'] = 'Nanit Fabrikası'; 
$ LNG ['bilgi'] [15] ['açıklama'] = 'Nanit robot doruk noktasıdır. Nanites kayıt başarılara imza bağlanarak olan nanometre büyüklüğünde robotlar vardır. Bir zamanlar neredeyse her alanda verimliliği artırmak, araştırdım. Nanit her adımda, binalar, gemiler ve savunma inşaat yarıya ".; 
$ LNG ['bilgi'] [21] ['name'] = 'Tersane'; 
$ LNG ['bilgi'] [21] ['açıklama'] = 'gemi ve savunma her türlü inşa gezegen tersane. Büyük o daha hızlı ve daha büyük gemiler ve daha gelişmiş savunma sistemleri inşa edilecek vardır. . Işçilerin daha hızlı çalışması için "yardımcı olmak için oluşturulmuş bir Nanit minik robotlar montaj ile; 
$ LNG ['bilgi'] [22] ['name'] = 'bellek metal'; 
$ LNG ['bilgi'] [22] ['açıklama'] = 'Büyük bozulmuş metal cevheri deposu. Büyük bellek, daha fazla metal içinde saklanabilir. kamp doluysa, hiçbir metal 'mayınlı;. 
$ LNG ['bilgi'] [23] ['name'] = 'Kristal Depolama'; 
$ LNG ['bilgi'] [23] ['açıklama'] = 'hala ham kristal bu büyük depolarda saklanır. Büyük stok, daha kristal içinde saklanabilir. kristal depo dolu ise, başka bir kristal 'mayınlı;. 
$ LNG ['bilgi'] [24] ['name'] = 'döteryum bellek'; 
$ LNG ['bilgi'] [24] ['açıklama'] yeni alınan döteryum of = 'büyük depolama tankları. Bu kampların uzay limanlarının yakınında çoğunlukla bulunabilir. Büyük olurlarsa olsunlar, daha döteryum onları saklanabilir. onlar dolu durumunda döteryum daha düşer. "; 
$ LNG ['bilgi'] [31] ['name'] = 'laboratuvar'; 
$ LNG ['bilgi'] [31] ['açıklama'] = ', bir araştırma istasyonu gerekli işlemi yeni teknolojileri keşfetmek için. Bir araştırma istasyonu inşaat aşamasında yeni bir teknoloji keşfedilmeyi ne kadar hızlı eleştiriyor. Laboratuvar düzeyi daha yüksek, daha yeni teknolojiler araştırılmaktadır. Araştırma, gezegen üzerinde yapılır eğer amacıyla, kısa sürede bir sonuca mümkün olduğunca araştırma getirmek için, bu araştırma istasyonu ve diğer gezegenlerde otomatik olarak tüm araştırma gönderildi ve böylece artık mevcuttur. bir teknoloji kez keşfedilmeyi sonra, araştırmacılar kendi gezegenine geri dönmek ve onlarla bu bilgiyi getirmek. Böylece tüm gezegenlerde teknolojisini kullanabilirsiniz.; 
$ LNG ['bilgi'] [33] ['name'] = 'Eski Terra'; 
$ Gezegenler, koloniler ve daha önemli için sınırlı habitat soru artan genişleme ile LNG ['bilgi'] [33] ['açıklama'] = '. bina ve inşaat gibi geleneksel yöntemler giderek yetersiz olduğunu kanıtladı. Terraforming: yüksek enerjili fizikçiler ve mühendisler Nano küçük bir grup nihayet çözüm bulundu. enerji tüketimi büyük miktarlarda altında, eski Terra tüm bölgeler ve hatta kıtalar ekilebilir olun. Bu binada sürekli toprak tutarlı kalitesini sağlayan özel tasarlanmış nanites üretiyoruz. Bir kez inşa Terraformer tekrar yıkılıyor değil ".; 
$ LNG ['bilgi'] [34] ['name'] = 'İttifak deposu'; 
$ LNG ['bilgi'] [34] ['açıklama'] = 'İttifak Depo savunma ve yörüngede yardımcı dostu filolarından olasılığı yakıt ile sunulur sunuyor. ittifak portföylerinin her gelişmişlik düzeyi için döteryum 10,000 birim saat başına yörüngede filosuna sağlanacak gönderilebilir. "; 


/ / ------------------------------------------------ -------------------------------------------------- -------- 
/ / Ay bina 
$ LNG ['bilgi'] [41] ['name'] = 'Ay üssü'; 
$ = 'Ay bir atmosfere sahiptir LNG [' bilgi '] [41] [' açıklama '] Bu nedenle, bir ay üssü yerleşim önce kurulmuş olmalıdır. Bu gerekli hava, yerçekimi ve ısı sağlar. Ay üssü düzeyi, daha yüksek bir biyosfer birlikte verilen alandır. Pro Space: Seviye 3 alanlar ayın maksimum boyut inşa edilebilir. Bu olabilir (Mondes/1000 çapı) ^ 2, kendisini bir kez yapılmış bir alan kaplar Ay üssü her aşamasında, ay üssü tekrar yıkılıyor değildir ".; 
$ LNG ['bilgi'] [42] ['name'] = 'sensör dizisi'; 
$ LNG ['bilgi'] [42] ['açıklama'] = 'yüksek çözünürlüklü sensörü falanks üzerinde radyasyon olayın tam spektrum tarama. Yüksek performanslı bilgisayarlar ve küçük enerji dalgalanmaları birleştirmek ve böylece uzak gezegenlere gemi hareketleri konusunda bilgi sahibi. Aya döteryum (5.000) şeklinde kullanılabilir enerji yapılmalıdır tarayın. tıklama 1 '- Bu sensör aralığı (falanks seviyesinde) ^ 2 bir düşman gezegende galaksi ve menü değişiklikler moon tarafından tarar. 
$ LNG ['bilgi'] [43] ['name'] = 'Jumpgate'; 
$ = 'Büyük bir atlama kapıları, evreni, zaman kaybı olmadan bile büyük filolar göndermek edebiliyoruz vericileridir LNG [' bilgi '] [43] [' açıklama ']. Bu vericilerden kapıları aksi ısınmaya çünkü hiçbir döteryum, ancak, iki atlar bir saat arasında geçmesi gereken tüketir. Ayrıca, kaynakların içine mümkün değildir. Tüm süreç, bir derece yüksek teknoloji gerektiriyor '. 
$ LNG ['bilgi'] [44] ['name'] = 'füze silosu'; 
$ LNG ['bilgi'] [44] ['açıklama'] = 'füze siloları roket depolanması için kullanılır. Pro-yükseltilmiş seviyesi, daha Gezegenlerarası beş veya on füze saklayabilirsiniz. iki Abfrangraketen olduğu kadar alanı bir gezegenlerarası gerekir. roketler Farklı türleri kombine edilebilir. "; 

/ / ------------------------------------------------ -------------------------------------------------- -------- 
/ / Araştırma 
$ LNG ['bilgi'] [106] ['name'] = 'Spy Aygıtları'; 
$ LNG ['bilgi'] [106] ['açıklama'] = 'yeni ve daha etkili sensörler araştırmalar öncelikle casus teknoloji fırsatları. Yüksek teknoloji, daha fazla bilgi çevresiyle olaylar hakkında kullanıcıya kullanılabilir geliştirilmiştir. probları için, kendi fark ve rakibin casusluk kritik seviyeleri. Daha fazla kişinin kendi casus teknolojisi, içerdiği bilgi ve araştırılmış daha küçük bir casusluk içinde ortaya çıkarmak olacaktır şans. Daha sonda sen de keşif riskini artırırken siz, rakibinin öğrenebilirler daha ayrıntılı gönderin. Casus teknoloji de yabancı filolarının takibi geliştirir. Sadece kendi zeka düzeyi çok önemlidir. seviyeden itibaren 2 saf saldırı mesajı saldıran gemilerin toplam sayısına ek olarak gösterilir. Seviyesi 4 YTL, tek saldıran gemilerin doğa ve toplam sayısı ve seviyesi 8 farklı gemi tipleri sayısını tam olarak görür. Bu kurban filo ve / veya savunma veya yığdı olup olmadığı hakkında bilgi verir, çünkü bu tekniğin Raider esastır. Bu nedenle, bu teknik çok erken incelenmelidir. küçük vanlar soruşturma Tercihen hemen sonra ".; 
$ LNG ['bilgi'] [108] ['name'] = 'bilgisayar teknolojisi'; 
$ LNG ['bilgi'] [108] ['açıklama'] = 'mevcut bilgisayar kapasitesinin uzantılı Bilgisayar mühendisliği ilgilenmektedir. Giderek daha güçlü ve verimli bilgisayar sistemleri geliştirilmiştir. Işlem gücü olan bilgisayar da artmış oluyor süreçlerini hızlı ve yükselmeye devam ediyor. bilgisayar kapasitesinin artmasıyla birlikte daha fazla filoları aynı zamanda komut olabilir. Bilgisayar teknolojisinin her aşamasında tek filosunun sayısını artırır. Daha sen, aynı zamanda filoları gönderebilirsiniz daha Raiden olabilir ve daha fazla kaynak götürebilir. daha sonra da aynı anda daha fazla filoları göndermek çünkü Tabii ki bu teknoloji markaları kullanarak. Bu nedenle, bilgisayar teknolojisi uzak oyun boyunca sürekli olarak yapılmaktadır. "; 
$ LNG ['bilgi'] [109] ['name'] = 'silah'; 
$ LNG ['bilgi'] [109] ['açıklama'] = 'silah teknolojisi özellikle mevcut silahların daha da geliştirilmesi ile ilgilidir. Bu özellikle ve donatmak için tam da bu enerji kanala daha fazla enerji ile, değeri mevcut sistemlerin yerleştirilir. Böylece, silah sistemleri daha verimli ve silah daha fazla zarar yok. silah teknolojisi her düzeyi değerinin% 10 adet silah gücünü artırır. Silah teknolojisi daha sonra kendi birimleri rekabetçi tutmak için önemlidir. Bu nedenle, sürekli olarak tüm oyun boyunca geliştirilmelidir. "; 
$ LNG ['bilgi'] [110] ['name'] = 'kalkan teknoloji'; 
LNG ['bilgi'] [110] ['açıklama'] = 'Her zaman yeni olasılıklar keşif Shield fırsatlar, kalkanlar daha fazla enerji sağlamak için $ ve onları daha verimli ve esnek olun. Her düzeyde Bu artış değerinin% 10 kalkanlar verimliliğini araştırdı ".; 
$ LNG ['bilgi'] [111] ['name'] = 'Raumschiffpanzerrung'; 
$ LNG ['bilgi'] [111] ['açıklama'] = 'Özel alaşımlar uzay zırh her zaman daha iyi yapmak. özel radyasyon uzay gemisi moleküler yapısı değişiklikleri ve iyi okudu alaşım seviyesine getirdi kez zor bir alaşım bulunur. zırh etkinliği artırılacak değerinin% 10 düzeyinde başına böyledir.; 
$ LNG ['bilgi'] [113] ['name'] = 'Enerji Teknolojileri'; 
$ LNG ['bilgi'] [113] ['açıklama'] = 'güç mühendisliği birçok yeni teknolojiler için gerekli olan enerji kontrol sistemleri ve enerji depolama, gelişimi ile ilgilidir.'; 
$ LNG ['bilgi'] [114] ['name'] = 'Hiperuzay Tekniği'; 
$ LNG ['bilgi'] [114] ['açıklama'] 4 of = 'entegrasyon ve 5 Boyut, artık daha ekonomik ve verimli sürücü yeni bir tür, keşfetmek mümkündür. "; 
$ LNG ['bilgi'] [115] ['name'] = 'içten yanmalı motor'; 
$ LNG ['bilgi'] [115] ['açıklama'] = 'içten yanmalı motorların rebound antik ilkesine dayanmaktadır. Isıl işlem görmüş materyal savruluyor ve ters yönde gemi götürmek. Bu motorların verimliliği oldukça düşük, ancak ucuz ve güvenilir ve az bakım gerektirir. Ayrıca, az yer tüketmek ve tekrar ve tekrar bulunacak küçük damarları özellikle bu nedenle vardır. yanmalı motorlarda herhangi bir alan vakıf olduğu için, onlar en kısa sürede mutlaka araştırılmalıdır. Bu motorların gelişimi daha hızlı seviye başına değerinin% 10 oranında aşağıdaki gemiler yapar: Küçük ve büyük vanlar, hafif avcı, geridönüşümü ve casusluk probları ';. 
$ LNG ['bilgi'] [117] ['name'] = 'Darbe Motor'; 
$ LNG ['bilgi'] [117] ['açıklama'] = 'darbe motor Rükstossprinzip, enerji kullanımı nükleer füzyon için sonuçları bir atık ürün olarak büyük ölçüde jet kitle dayanmaktadır. Ayrıca, daha kitlesel enjekte edilir. Bu motorların gelişimi daha hızlı başına adım değerinin% 20 oranında aşağıdaki gemiler yapar: bombacıları, kruvazör, ağır avcı, ve koloni gemileri. sahne başına Gezegenlerarası uçan devam edebilirsiniz. "; 
$ LNG ['bilgi'] [118] ['name'] = 'Hiperuzay sürücü'; 
$ = 'A Raumzeitverkrümmung çok hızlı bir şekilde uzun mesafelerde seyahat edebilirsiniz odası, bir geminin çevresinde sıkıştırılmış LNG [' bilgi '] [118] [' açıklama ']. Yüksek Hiperuzay sürücü, geliştirilen uzay, sıkıştırma yüksek mademki (kruvazörünün, savaş gemileri, destroyer ve ölüm yıldız) onlarla donatılmış gemilerin hızı% 30 artarak her seviyede. Gereksinimleri: Hiperuzay Tekniği (seviye 3) Araştırma Laboratuvarı (seviye 7) ';. 
$ LNG ['bilgi'] [120] ['name'] = 'Lazer Teknolojisi'; 
$ LNG ['bilgi'] [120] ['açıklama'] = 'lazer (radyasyon kaynaklı emisyon tarafından ışık amplifikasyonu) tutarlı bir ışık yoğun, yüksek enerjili ışın üretirler. Bu cihazların alan deniz zırh sayesinde zahmetsizce kesilmiş ağır lazer silah optik bilgisayarlara uygulama birçok alanda bulabilirsiniz. Lazer teknolojisi silah teknolojilerine daha fazla araştırma için önemli bir temeldir. Önkoşul: Araştırma Laboratuvarı (seviye 1) Enerji Teknolojisi (düzey 2) ';. 
$ LNG ['bilgi'] [121] ['name'] = 'iyon teknolojisi'; 
$ LNG ['bilgi'] [121] ['açıklama'] hızlandırılmış iyonlarının = 'Gerçekten ölümcül yönlü kiriş. Hızlandırılmış iyonlar bir nesne büyük zarar 'darbe bağlıdır;. 
$ LNG ['bilgi'] [122] ['name'] = 'Plazma teknolojisi'; 
$ LNG ['bilgi'] [122] ['açıklama'] = 'iyonları, ancak yüksek enerjili plazma hızlandırır iyon teknolojisi, diğer bir gelişme. Yüksek enerjili plazma bir nesne çarpıcı üzerinde yıkıcı bir etkiye sahiptir. "; 
$ LNG ['bilgi'] [123] ['name'] = 'Galaksiler arası araştırma ağı'; 
$ LNG ['bilgi'] [123] ['açıklama'] farklı gezegenlerden = 'araştırmacı birbirleri ile bu ağ üzerinden haberleşirler. Profesyonel seviyede araştırma, bir araştırma laboratuvarı ağında olduğunu. Her zaman yeterince sizi lider tarafından yaklaşan bağımsız araştırma için geliştirilmiş olmalıdır laboratuvar ağı en üst düzeyde dazugeschaltet.Das laboratuvarlarında olabilir. tüm katılımcı laboratuvarların geliştirilmesi aşamalarında birlikte galaksiler arası araştırma ağı sayılır ".; 
$ LNG ['bilgi'] [124] ['name'] = 'astrofizik'; 
$ LNG ['bilgi'] [124] ['açıklama'] astrofizik = 'Diğer bulgular daha fazla gemi bulunuyor olabilir, laboratuvarlar inşa sağlar. Bu geniş sefer keşfedilmemiş alanlarda mümkündür. alanı daha da kolonizasyon daha fazla ilerleme izin verin. Bu teknolojinin her iki adım için başka bir gezegen harnessed olabilir. "; 
$ LNG ['bilgi'] [131] ['name'] = 'üretim maksimizasyonu metal'; 
$ LNG ['bilgi'] [131] ['açıklama'] = '% 2 metal madeni üretimini artırın'; 
$ LNG ['bilgi'] [132] ['name'] = 'üretim maksimizasyonu kristal'; 
$ LNG ['bilgi'] [132] ['açıklama'] = '% 2 oranında kristal madenin üretimini artırın'; 
$ LNG ['bilgi'] [133] ['name'] = 'üretim maksimizasyonu döteryum'; 
$ LNG ['bilgi'] [133] ['açıklama'] = '% 2 Deuteriumsynthetisierer üretimini artırın'; 
$ LNG ['bilgi'] [199] ['name'] = 'Gravitasyon'; 
$ LNG ['bilgi'] [199] ['açıklama'] = 'A Graviton hiçbir kütle ve çekim kuvveti belirler ücret, bir parçacık olduğunu.