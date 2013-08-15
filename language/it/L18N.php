<?php
/*
* Tradotto in italiano da XxidroxX
* Repository: https://github.com/XxidroxX/2moons-it
* Supporto: http://aesma.it
*/
setlocale(LC_ALL, 'it_IT', 'italian'); // http://msdn.microsoft.com/en-us/library/39cwe7zf%28vs.71%29.aspx
setlocale(LC_NUMERIC, 'C');

//SERVER GENERALS
$LNG['dir']             = 'ltr';
$LNG['week_day']    	= array('Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab'); # Parte con domenica!
$LNG['months']	        = array('Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic');
$LNG['js_tdformat']	    = '[M] [D] [d] [H]:[i]:[s]';
$LNG['php_timeformat']	= 'H:i:s';
$LNG['php_dateformat']	= 'd. M Y';
$LNG['php_tdformat']	= 'd. M Y, H:i:s';
$LNG['short_day']	    = 'd';
$LNG['short_hour']	    = 'h';
$LNG['short_minute']	= 'm';
$LNG['short_second']	= 's';

//Note for the translators, use the phpBB Translation file (LANG/common.php) instead of your own translations

$LNG['timezones']	= array(
    '-12' => '[UTC -12] Isola Baker',
    '-11' => '[UTC -11] Samoa, Isole Midway',
    '-10' => '[UTC -10] Hawaii, Tahiti',
    '-9.5' => '[UTC -9:30] Isole Marchesi',
    '-9' => '[UTC -9] Alaska',
    '-8' => '[UTC -8] Costa del Pacifico',
    '-7' => '[UTC -7] USA centro-occidentali',
    '-6' => '[UTC -6] Città del Messico, USA centro-orientali',
    '-5' => '[UTC -5] Costa dell’Atlantico, Brasile occidentale, Cuba',
    '-4.5' => '[UTC -4:30] Venezuela',
    '-4' => '[UTC -4] Brasile centrale, Barbados, Bolivia, Cile',
    '-3.5' => '[UTC -3:30] Terranova',
    '-3' => '[UTC -3] Argentina, Brasile orientale, Uruguay',
    '-2' => '[UTC -2] Bermuda',
    '-1' => '[UTC -1] Isole Azzorre, Capo Verde',
    '0' => '[UTC] Europa occidentale, Regno Unito (GMT)',
    '1' => '[UTC +1] Europa centrale, Italia',
    '2' => '[UTC +2] Europa orientale, Grecia',
    '3' => '[UTC +3] Mosca, Arabia Saudita',
    '3.5' => '[UTC +3:30] Iran',
    '4' => '[UTC +4] Emirati Arabi Uniti',
    '4.5' => '[UTC +4:30] Afghanistan',
    '5' => '[UTC +5] Pakistan, Maldive',
    '5.5' => '[UTC +5:30] India, Sri Lanka',
    '5.75' => '[UTC +5:45] Nepal',
    '6' => '[UTC +6] Bangladesh',
    '6.5' => '[UTC +6:30] Myanmar',
    '7' => '[UTC +7] Indonesia occidentale, Thailandia, Vietnam',
    '8' => '[UTC +8] Cina, Hong Kong, Singapore, Taiwan, Perth',
    '9' => '[UTC +9] Giappone, Corea, Indonesia orientale',
    '9.5' => '[UTC +9:30] Adelaide',
    '10' => '[UTC +10] Sydney, Papua Nuova Guinea',
    '10.5' => '[UTC +10:30] Isola Lord Howe',
    '11' => '[UTC +11] Isole Salomone, Nuova Caledonia',
    '11.5' => '[UTC +11:30] Isole Norfolk',
    '12' => '[UTC +12] Nuova Zelanda, Figi',
    '12.75' => '[UTC +12:45] Isole Chatham',
    '13' => '[UTC +13] Tonga',
    '14' => '[UTC +14] Isole della linea'
);