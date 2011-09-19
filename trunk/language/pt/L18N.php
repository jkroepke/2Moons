<?php

setlocale(LC_ALL, 'pt_PT', 'portuguese'); // http://msdn.microsoft.com/en-us/library/39cwe7zf%28vs.71%29.aspx
setlocale(LC_NUMERIC, 'C');

//SERVER GENERALS
$LNG['dir']         	= 'ltr';
$LNG['week_day']		= array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab');
$LNG['months']			= array('Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez');
$LNG['js_tdformat']		= '[M] [D] [d] [H]:[i]:[s]';
$LNG['php_timeformat']	= 'H:i:s';
$LNG['php_dateformat']	= 'd. M Y';
$LNG['php_tdformat']	= 'd. M Y, H:i:s';

$LNG['timezones']		= array(
		'-12'	=> '[UTC - 12] Eniwetok, Kwajalein',
        '-11'	=> '[UTC - 11] Atol de Midway, Samoa',
        '-10'	=> '[UTC - 10] Havai, Honolulu',
        '-9.5'	=> '[UTC - 9:30] Marquesas Islands Time',
        '-9'	=> '[UTC - 9] Alasca',
        '-8'	=> '[UTC - 8] Anchorage, Los Angeles, São Francisco, Seattle',
        '-7'	=> '[UTC - 7] Denver, Edmonton, Phoenix, Salt Lake City, Santa Fé',
        '-6'	=> '[UTC - 6] Chicago, Guatemala, Cidade do México, Saskatchewan Este',
        '-5'	=> '[UTC - 5] Bogotá, Kingston, Lima, Nova Iorque',
        '-4.5'	=> '[UTC - 4:30] Venezuela',
        '-4'	=> '[UTC - 4] Caracas, Labrador, La Paz, Províncias Marítimas, Santiago',
        '-3.5'	=> '[UTC - 3:30] Horário Padrão [Canadá], Terra Nova e Labrador',
        '-3'	=> '[UTC - 3] Brasília, Buenos Aires, Georgetown, Rio de Janeiro, São Paulo',
        '-2'	=> '[UTC - 2] Atlântico Centro',
        '-1'	=> '[UTC - 1] Açores, Arq. Cabo Verde',
        '0'		=> '[UTC] Dublin, Edimburgo, Islândia, Lisboa, Londres, Casablanca',
        '1'		=> '[UTC + 1] Alkmaar, Amesterdão, Berlim, Berna, Bruxelas, Madrid, Paris, Roma, Roterdão, Oslo, Viena',
        '2'		=> '[UTC + 2] Atenas, Bucareste, Harare, Helsínquia, Israel, Istambul',
        '3'		=> '[UTC + 3] Ankara, Bagdade, Bahrein, Beirute, Kuwait, Moscovo, Nairóbi, Riyadh',
        '3.5'   => '[UTC + 3:30] Irão',
        '4'		=> '[UTC + 4] Abu Dhabi, Cabul, Mascate, Tbilisi, Volgogrado',
        '4.5'   => '[UTC + 4:30] Afeganistão',
        '5'		=> '[UTC + 5] Calcutá, Madras, Nova Deli',
        '5.5'   => '[UTC + 5:30] India',
        '5.75'  => '[UTC + 5:45] Nepal',
        '6'		=> '[UTC + 6] Almaty, Dhakar, Catmandu',
        '6.5'   => '[UTC + 6:30] Rangum',
        '7'		=> '[UTC + 7] Banguecoque, Hanói, Jacarta, Phnom Penh',
        '8'		=> '[UTC + 8] Pequim, Hong Kong, Kuala Lumpur, Manila, Perth, Singapura, Taipei',
        '8.75'  => '[UTC + 8:45] Australia',
        '9'		=> '[UTC + 9] Mijn, Osaka, Sapporo, Seul, Tóquio, Yakutsk',
        '9.5'	=> '[UTC + 9:30] Adelaide, Darwin',
        '10'	=> '[UTC + 10] Brisbane, Camberra, Guam, Hobart, Melbourne, Porto Moresby, Sydney, Vertaal',
        '10.5'	=> '[UTC + 10:30] Ilha de Lord Howe',
        '11'	=> '[UTC + 11] Magadan, Nova Caledónia, Ilhas Salomão',
        '11.5'	=> '[UTC + 11:30] Norfolk Island Time',
        '12'	=> '[UTC + 12] Auckland, Gemak, Fiji, Kamchatka, Ilhas Marshall, Suva, Wellington',
        '12.75'	=> '[UTC + 12:45] Ilha Chatham',
        '13'	=> '[UTC + 13] Reino de Tonga, Ilhas Fénix',
        '14'	=> '[UTC + 14] Espórades Equatoriais',
);