<?php

setlocale(LC_ALL, 'it_IT', 'italian'); // http://msdn.microsoft.com/en-us/library/39cwe7zf%28vs.71%29.aspx
setlocale(LC_NUMERIC, 'C');

//SERVER GENERALS

$LNG['dir']         	= 'ltr';
$LNG['week_day']			= array('Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab');
$LNG['months']		= array('Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'giu', 'lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic');
$LNG['js_tdformat']	= '[M] [D] [d] [H]:[i]:[s]';
$LNG['php_timeformat']	= 'H:i:s';
$LNG['php_dateformat']	= 'd. M Y';
$LNG['php_tdformat']	= 'd. M Y, H:i:s';

//Note for the translators, use the phpBB Translation file (LANG/common.php) instead of your own translations

$LNG['timezones']		= array(
	'-12'	=> '[UTC - 12] Islanda balcanica',
	'-11'	=> '[UTC - 11] Isole Midway, Niue, Samoa, Samoa Americana',
	'-10'	=> '[UTC - 10] Polinesia francese, Hawaii, Isole aleutine, Alaska',
	'-9.5'	=> '[UTC - 9:30] Polinesia francese (Isole Marchesi)',
	'-9'	=> '[UTC - 9] Alaska e Polinesia francese (Isole Gambieri)',
	'-8'	=> '[UTC - 8] Canada britannico, Messico, Stati uniti',
	'-7'	=> '[UTC - 7] Canada, Messico, Stati uniti, Texas',
	'-6'	=> '[UTC - 6] Guatemala, Honduras, Nicaragua, Stati uniti, Ecuador, Costa rica',
	'-5'	=> '[UTC - 5] Canada, Colombia, Giamaica, Ecuador, Cuba, Peru, Stati uniti',
	'-4.5'	=> '[UTC - 4:30] Venezuela',
	'-4'	=> '[UTC - 4] Anguilla, Argentina, Aruba, Bolivia, Cile, Porto rico, Paraguay, Matrinica, Isole vergini',
	'-3.5'	=> '[UTC - 3:30] Canada (Terranova)',
	'-3'	=> '[UTC - 3] Argentina, Bahamas, Brasile, Groenlandia, Uruguay, Suriname',
	'-2'	=> '[UTC - 2] Bermuda, Brasile, Regno unito',
	'-1'	=> '[UTC - 1] Capo verde, Azzorre',
	'0'		=> '[UTC] Canarie, Gambia, Ghana, Guinea, Irlanda, Islanda, Marocco, Portogallo, Regno unito',
	'1'		=> '[UTC + 1] Italia, Croazia, Germania, Madrid, Belgio, Danimarca, Polonia, Serbia, Norvegia',
	'2'		=> '[UTC + 2] Bielorussia, Romania, Sudafrica, Zambia, Israele, Libia, Cipro, Moldavia',
	'3'		=> '[UTC + 3] Arabia saudita, Comore, Etiopia, Uganda, Somalia, Tanzania',
	'3.5'	=> '[UTC + 3:30] Iran',
	'4'		=> '[UTC + 4] Georgia, Mauritius, Oman, Reunion, Russia, Seychelles',
	'4.5'	=> '[UTC + 4:30] Afghanistan',
	'5'		=> '[UTC + 5] Armenia, Azerbaijan, Kazakistan, Maldivie, Russia, Tagikistan',
	'5.5'	=> '[UTC + 5:30] India, Sri lanka',
	'5.75'	=> '[UTC + 5:45] Nepal',
	'6'		=> '[UTC + 6] Bangladesh, Bhutan, Kazakistan, Russia',
	'6.5'	=> '[UTC + 6:30] Isole cocos, Myanmar',
	'7'		=> '[UTC + 7] Cambogia, Indonesia, Isola del natale, Laos, Russia, Vietnam',
	'8'		=> '[UTC + 8] Australia, Brunei, Cina, Filippine, Malesia, Russia, Singapore, Taiwan',
	'8.75'	=> '[UTC + 8:45] Australia occidentale',
	'9'		=> '[UTC + 9] Corea del nord, Corea del sud, Giappone, Indonesia, Palau, Russia',
	'9.5'	=> '[UTC + 9:30] Australia (Galles)',
	'10'	=> '[UTC + 10] Australia, Guam, Isole cook, Papua nuova guinea, Russia',
	'10.5'	=> '[UTC + 10:30] Australia',
	'11'	=> '[UTC + 11] Isole salomone, Nuova celedonia, Russia, Vanuatu',
	'11.5'	=> '[UTC + 11:30] Isole norfolk',
	'12'	=> '[UTC + 12] Figi, Isola waka, Isole marshall, Nauru, Nuova zelanda, Polo sud, Tuvalu',
	'12.75'	=> '[UTC + 12:45] Nuova zelanda',
	'13'	=> '[UTC + 13] Kiribati, Tonga',
	'14'	=> '[UTC + 14] Islanda',
);