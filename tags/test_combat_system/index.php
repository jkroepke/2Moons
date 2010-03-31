<?php

require 'BattleEngine.php';
	$pricelist = array(
		  1 => array ( 'metal' =>      60, 'crystal' =>      15, 'deuterium' =>       0, 'energy' =>    0, 'darkmatter' =>  0, 'factor' => 3/2),
		  2 => array ( 'metal' =>      48, 'crystal' =>      24, 'deuterium' =>       0, 'energy' =>    0, 'darkmatter' =>  0, 'factor' => 1.6),
		  3 => array ( 'metal' =>     225, 'crystal' =>      75, 'deuterium' =>       0, 'energy' =>    0, 'darkmatter' =>  0, 'factor' => 3/2),
		  4 => array ( 'metal' =>      75, 'crystal' =>      30, 'deuterium' =>       0, 'energy' =>    0, 'darkmatter' =>  0, 'factor' => 3/2),
		 12 => array ( 'metal' =>     900, 'crystal' =>     360, 'deuterium' =>     180, 'energy' =>    0, 'darkmatter' =>  0, 'factor' => 1.8),
		 14 => array ( 'metal' =>     400, 'crystal' =>     120, 'deuterium' =>     200, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2),
		 15 => array ( 'metal' => 1000000, 'crystal' =>  500000, 'deuterium' =>  100000, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2),
		 21 => array ( 'metal' =>     400, 'crystal' =>     200, 'deuterium' =>     100, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2),
		 22 => array ( 'metal' =>    2000, 'crystal' =>       0, 'deuterium' =>       0, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2),
		 23 => array ( 'metal' =>    2000, 'crystal' =>    1000, 'deuterium' =>       0, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2),
		 24 => array ( 'metal' =>    2000, 'crystal' =>    2000, 'deuterium' =>       0, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2),
		 31 => array ( 'metal' =>     200, 'crystal' =>     400, 'deuterium' =>     200, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2),
		 33 => array ( 'metal' =>       0, 'crystal' =>   50000, 'deuterium' =>  100000, 'energy_max' => 1000, 'darkmatter' => 0, 'factor' =>   2),
		 34 => array ( 'metal' =>   20000, 'crystal' =>   40000, 'deuterium' =>       0, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2),
		 41 => array ( 'metal' =>   20000, 'crystal' =>   40000, 'deuterium' =>   20000, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2),
		 42 => array ( 'metal' =>   20000, 'crystal' =>   40000, 'deuterium' =>   20000, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2),
		 43 => array ( 'metal' => 2000000, 'crystal' => 4000000, 'deuterium' => 2000000, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2),
		 44 => array ( 'metal' =>   20000, 'crystal' =>   20000, 'deuterium' =>    1000, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2),

		106 => array ( 'metal' =>     200, 'crystal' =>    1000, 'deuterium' =>     200, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		108 => array ( 'metal' =>       0, 'crystal' =>     400, 'deuterium' =>     600, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		109 => array ( 'metal' =>     800, 'crystal' =>     200, 'deuterium' =>       0, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		110 => array ( 'metal' =>     200, 'crystal' =>     600, 'deuterium' =>       0, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		111 => array ( 'metal' =>    1000, 'crystal' =>       0, 'deuterium' =>       0, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		113 => array ( 'metal' =>       0, 'crystal' =>     800, 'deuterium' =>     400, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		114 => array ( 'metal' =>       0, 'crystal' =>    4000, 'deuterium' =>    2000, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		115 => array ( 'metal' =>     400, 'crystal' =>       0, 'deuterium' =>     600, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		117 => array ( 'metal' =>    2000, 'crystal' =>    4000, 'deuterium' =>    600,  'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		118 => array ( 'metal' =>   10000, 'crystal' =>   20000, 'deuterium' =>    6000, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		120 => array ( 'metal' =>     200, 'crystal' =>     100, 'deuterium' =>       0, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		121 => array ( 'metal' =>    1000, 'crystal' =>     300, 'deuterium' =>     100, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		122 => array ( 'metal' =>    2000, 'crystal' =>    4000, 'deuterium' =>    1000, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		123 => array ( 'metal' =>  240000, 'crystal' =>  400000, 'deuterium' =>  160000, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		124 => array ( 'metal' =>    4000, 'crystal' =>    8000, 'deuterium' =>    4000, 'energy' =>    0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		199 => array ( 'metal' =>       0, 'crystal' =>       0, 'deuterium' =>       0, 'energy_max' => 300000, 'darkmatter' =>  0, 'factor' =>   3, 'max' => 255),

		202 => array ( 'metal' =>      2000, 'crystal' =>      2000, 'deuterium' =>        0, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>     10, 'consumption2' => 20  , 'speed' =>      5000, 'speed2' =>     10000, 'capacity' =>      5000),
		203 => array ( 'metal' =>      6000, 'crystal' =>      6000, 'deuterium' =>        0, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>     50, 'consumption2' => 50  , 'speed' =>      7500, 'speed2' =>      7500, 'capacity' =>     25000),
		204 => array ( 'metal' =>      3000, 'crystal' =>      1000, 'deuterium' =>        0, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>     20, 'consumption2' => 20  , 'speed' =>     12500, 'speed2' =>     12500, 'capacity' =>        50),
		205 => array ( 'metal' =>      6000, 'crystal' =>      4000, 'deuterium' =>        0, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>     75, 'consumption2' => 75  , 'speed' =>     10000, 'speed2' =>     15000, 'capacity' =>       100),
		206 => array ( 'metal' =>     20000, 'crystal' =>      7000, 'deuterium' =>     2000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>    300, 'consumption2' => 300 , 'speed' =>     15000, 'speed2' =>     15000, 'capacity' =>       800),
		207 => array ( 'metal' =>     45000, 'crystal' =>     15000, 'deuterium' =>        0, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>    250, 'consumption2' => 250 , 'speed' =>     10000, 'speed2' =>     10000, 'capacity' =>      1500),
		208 => array ( 'metal' =>     10000, 'crystal' =>     20000, 'deuterium' =>    10000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>   1000, 'consumption2' => 1000, 'speed' =>      2500, 'speed2' =>      2500, 'capacity' =>      7500),
		209 => array ( 'metal' =>     10000, 'crystal' =>      6000, 'deuterium' =>     2000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>    300, 'consumption2' => 300 , 'speed' =>      2000, 'speed2' =>      2000, 'capacity' =>     20000),
		210 => array ( 'metal' =>         0, 'crystal' =>      1000, 'deuterium' =>        0, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>      1, 'consumption2' => 1   , 'speed' => 100000000, 'speed2' => 100000000, 'capacity' =>         5),
		211 => array ( 'metal' =>     50000, 'crystal' =>     25000, 'deuterium' =>    15000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>   1000, 'consumption2' => 1000, 'speed' =>      4000, 'speed2' =>      5000, 'capacity' =>       500),
		212 => array ( 'metal' =>         0, 'crystal' =>      2000, 'deuterium' =>      500, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>      0, 'consumption2' => 0   , 'speed' =>         0, 'speed2' =>         0, 'capacity' =>         0),
		213 => array ( 'metal' =>     60000, 'crystal' =>     50000, 'deuterium' =>    15000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>   1000, 'consumption2' => 1000, 'speed' =>      5000, 'speed2' =>      5000, 'capacity' =>      2000),
		214 => array ( 'metal' =>   5000000, 'crystal' =>   4000000, 'deuterium' =>  1000000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>      1, 'consumption2' => 1   , 'speed' =>       200, 'speed2' =>       200, 'capacity' =>   1000000),
		215 => array ( 'metal' =>     30000, 'crystal' =>     40000, 'deuterium' =>    15000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>    250, 'consumption2' => 250 , 'speed' =>     10000, 'speed2' =>     10000, 'capacity' =>       750),
        216 => array ( 'metal' =>   8000000, 'crystal' =>   2000000, 'deuterium' =>  1500000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>    250, 'consumption2' => 250 , 'speed' =>       900, 'speed2' =>       900, 'capacity' =>  15000000),
		217 => array ( 'metal' =>     35000, 'crystal' =>     20000, 'deuterium' =>     1500, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>     90, 'consumption2' =>     90, 'speed' =>    6000, 'speed2' =>      6000, 'capacity' => 400000000),
        218 => array ( 'metal' => 275000000, 'crystal' => 130000000, 'deuterium' => 60000000, 'energy' => 0, 'darkmatter' =>  1000, 'factor' => 1, 'consumption' =>  10000, 'consumption2' =>  10000, 'speed' =>      10, 'speed2' =>        10, 'capacity' =>  50000000),
        219 => array ( 'metal' =>   1000000, 'crystal' =>    600000, 'deuterium' =>   200000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>    300, 'consumption2' =>    300, 'speed' =>    7500, 'speed2' =>      7500, 'capacity' => 200000000),
        220 => array ( 'metal' =>   6000000, 'crystal' =>   7000000, 'deuterium' =>  3000000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' => 100000, 'consumption2' => 100000, 'speed' =>     100, 'speed2' =>       100, 'capacity' =>   6000000),
        221 => array ( 'metal' =>  50000000, 'crystal' =>  37500000, 'deuterium' => 40000000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' => 100000, 'consumption2' => 100000, 'speed' =>      50, 'speed2' =>        50, 'capacity' => 200000000),
        222 => array ( 'metal' => 250000000, 'crystal' => 120000000, 'deuterium' => 30000000, 'energy' => 0, 'darkmatter' =>  10000, 'factor' => 1, 'consumption' =>  25000, 'consumption2' =>  25000, 'speed' =>     150, 'speed2' =>       150, 'capacity' =>  45000000),
	
		401 => array ( 'metal' =>       2000, 'crystal' =>          0, 'deuterium' =>         0, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		402 => array ( 'metal' =>       1500, 'crystal' =>        500, 'deuterium' =>         0, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		403 => array ( 'metal' =>       6000, 'crystal' =>       2000, 'deuterium' =>         0, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		404 => array ( 'metal' =>      20000, 'crystal' =>      15000, 'deuterium' =>      2000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		405 => array ( 'metal' =>       2000, 'crystal' =>       6000, 'deuterium' =>         0, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		406 => array ( 'metal' =>      50000, 'crystal' =>      50000, 'deuterium' =>     30000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		407 => array ( 'metal' =>      10000, 'crystal' =>      10000, 'deuterium' =>         0, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		408 => array ( 'metal' =>      50000, 'crystal' =>      50000, 'deuterium' =>         0, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
        409 => array ( 'metal' =>   10000000, 'crystal' =>    5000000, 'deuterium' =>   2500000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		410 => array ( 'metal' =>   15000000, 'crystal' =>   15000000, 'deuterium' =>         0, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		411 => array ( 'metal' => 5000000000, 'crystal' => 2000000000, 'deuterium' => 500000000, 'energy' => 1000000, 'darkmatter' =>  10000, 'factor' => 1 ),         
		
		502 => array ( 'metal' =>   8000, 'crystal' =>    0, 'deuterium' =>       2000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		503 => array ( 'metal' =>  12500, 'crystal' =>    2500, 'deuterium' =>   10000, 'energy' => 0, 'darkmatter' =>  0, 'factor' => 1 ),

		601 => array ( 'max' =>  20),
		602 => array ( 'max' =>  20),
		603 => array ( 'max' =>  10),
		604 => array ( 'max' =>  10),
		605 => array ( 'max' =>   3),
		606 => array ( 'max' =>   3),
		607 => array ( 'max' =>   2),
		608 => array ( 'max' =>   2),
		609 => array ( 'max' =>   1),
		610 => array ( 'max' =>   2),
		611 => array ( 'max' =>   3),
		612 => array ( 'max' =>   1),
		613 => array ( 'max' =>   3),
		614 => array ( 'max' =>   1),
		615 => array ( 'max' =>   1),
	);

	$CombatCaps = array(
		202 => array ( 'shield' =>      10, 'attack' =>        5, 'sd' => array (210 =>    5, 212 =>    5)),
		203 => array ( 'shield' =>      25, 'attack' =>        5, 'sd' => array (210 =>    5, 212 =>    5)),
		204 => array ( 'shield' =>      10, 'attack' =>       50, 'sd' => array (210 =>    5, 212 =>    5)),
		205 => array ( 'shield' =>      25, 'attack' =>      150, 'sd' => array (202 =>    3, 210 =>    5, 212 =>   5)),
		206 => array ( 'shield' =>      50, 'attack' =>      400, 'sd' => array (204 =>    6, 401 =>   10, 210 =>   5, 212 =>   5)),
		207 => array ( 'shield' =>     200, 'attack' =>     1000, 'sd' => array (210 =>    5, 212 =>    5)),
		208 => array ( 'shield' =>     100, 'attack' =>       50, 'sd' => array (210 =>    5, 212 =>    5)),
		209 => array ( 'shield' =>      10, 'attack' =>        1, 'sd' => array (210 =>    5, 212 =>    5)),
		210 => array ( 'shield' =>    .001, 'attack' =>     .001, 'sd' => array ()),
		211 => array ( 'shield' =>     500, 'attack' =>     1000, 'sd' => array (210 =>    5, 212 =>    5, 401 =>  20, 402 =>  20, 403 =>  10, 405 =>  10)),
		212 => array ( 'shield' =>    .001, 'attack' =>     .001, 'sd' => array ()),
		213 => array ( 'shield' =>     500, 'attack' =>     2000, 'sd' => array (210 =>    5, 212 =>    5, 215 =>   2, 402 =>  10)),
		214 => array ( 'shield' =>   50000, 'attack' =>   200000, 'sd' => array (210 => 1250, 212 => 1250, 202 => 250, 203 => 250, 208 => 250, 209 => 250, 204 => 200, 205 => 100, 206 => 33, 207 => 30, 211 => 25, 215 => 15, 213 => 5, 401 => 200, 402 => 200, 403 => 100, 404 =>  50, 405 => 100)),
		215 => array ( 'shield' =>     400, 'attack' =>      700, 'sd' => array (202 =>    3, 203 =>   3, 205 =>   4, 206 =>   4, 207 =>   10, 210 =>    5, 212 =>   5)),
        216 => array ( 'shield' =>   70000, 'attack' =>   150000, 'sd' => array (210 => 1250, 212 => 1250, 202 => 250, 203 => 250, 204 => 200, 205 => 100, 206 =>  33, 207 =>  30, 208 => 250, 209 => 250, 211 =>  25, 213 =>   5, 214 =>   1, 215 =>  15, 222 => 2, 401 => 400, 402 => 200, 403 => 100, 404 =>  50, 405 => 100, 406 =>   1, 407 =>   1, 408 =>   1 , 413 =>   15 , 414 =>   5)),
		217 => array ( 'shield' =>     120, 'attack' =>       50, 'sd' => array (202 =>    1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   0, 208 =>   1, 209 =>   1, 210 => 5, 211 =>   1, 212 => 5, 213 =>   1, 214 =>   1, 215 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1 )),
        218 => array ( 'shield' => 2000000, 'attack' => 35000000, 'sd' => array (210 => 1250, 212 => 1250, 202 => 250, 203 => 250, 204 => 200, 205 => 100, 206 =>  33, 207 =>  30, 208 => 250, 209 => 250, 211 =>  25, 213 =>   5, 214 =>   1, 215 =>  15, 401 => 400, 402 => 200, 403 => 100, 404 =>  50, 405 => 100, 406 =>   1, 407 =>   1, 408 =>   1 , 413 =>   55 , 414 =>   15)),
        219 => array ( 'shield' =>    1000, 'attack' =>        1, 'sd' => array (202 =>    1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1 )),
        220 => array ( 'shield' =>   50000, 'attack' => 	   5, 'sd' => array (202 =>    1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1 )),
        221 => array ( 'shield' => 5000000, 'attack' =>  8000000, 'sd' => array (202 =>  250, 203 => 250, 204 => 200, 205 => 100, 206 =>  60, 207 =>  50, 208 => 250, 209 => 250, 210 => 1250, 211 =>  50, 212 => 1250, 213 =>   15, 214 =>   3, 215 =>  30, 216 => 2, 217 => 30, 401 => 300, 402 => 300, 403 => 150, 404 =>  50, 405 => 150, 406 =>   1, 407 =>   1, 408 =>   1  )),
        222 => array ( 'shield' => 1750000, 'attack' => 30000000, 'sd' => array (202 =>  235, 203 => 235, 204 => 190, 205 =>  95, 206 =>  55, 207 =>  40, 208 => 240, 209 => 245, 210 => 1230, 211 =>   1, 212 => 1230, 213 =>   10, 214 =>   1, 215 =>  20, 216 => 2, 217 => 20, 401 => 285, 402 => 285, 403 => 140, 404 =>  45, 405 => 140, 406 =>   1, 407 =>   1, 408 =>   1  )),

		401 => array ( 'shield' =>      20, 'attack' =>      80, 'sd' => array (202 =>   0, 203 =>   0, 204 =>   0, 205 =>   0, 206 =>   0, 207 =>   0, 208 =>   0, 209 =>   0, 210 =>    5, 211 =>   0, 212 =>    0, 213 =>   0, 214 =>   0, 215 =>   0, 216 =>   0) ),
		402 => array ( 'shield' =>      25, 'attack' =>     100, 'sd' => array (202 =>   0, 203 =>   0, 204 =>   0, 205 =>   0, 206 =>   0, 207 =>   0, 208 =>   0, 209 =>   0, 210 =>    5, 211 =>   0, 212 =>    0, 213 =>   0, 214 =>   0, 215 =>   0, 216 =>   0) ),
		403 => array ( 'shield' =>     100, 'attack' =>     250, 'sd' => array (202 =>   0, 203 =>   0, 204 =>   0, 205 =>   0, 206 =>   0, 207 =>   0, 208 =>   0, 209 =>   0, 210 =>    5, 211 =>   0, 212 =>    0, 213 =>   0, 214 =>   0, 215 =>   0, 216 =>   0) ),
		404 => array ( 'shield' =>     200, 'attack' =>    1100, 'sd' => array (202 =>   0, 203 =>   0, 204 =>   0, 205 =>   0, 206 =>   0, 207 =>   0, 208 =>   0, 209 =>   0, 210 =>    5, 211 =>   0, 212 =>    0, 213 =>   0, 214 =>   0, 215 =>   0, 216 =>   0) ),
		405 => array ( 'shield' =>     500, 'attack' =>     150, 'sd' => array (202 =>   0, 203 =>   0, 204 =>   0, 205 =>   0, 206 =>   0, 207 =>   0, 208 =>   0, 209 =>   0, 210 =>    5, 211 =>   0, 212 =>    0, 213 =>   0, 214 =>   0, 215 =>   0, 216 =>   0) ),
		406 => array ( 'shield' =>     300, 'attack' =>    3000, 'sd' => array (202 =>   0, 203 =>   0, 204 =>   0, 205 =>   0, 206 =>   0, 207 =>   0, 208 =>   0, 209 =>   0, 210 =>    5, 211 =>   0, 212 =>    0, 213 =>   0, 214 =>   0, 215 =>   0, 216 =>   0) ),
		407 => array ( 'shield' =>    2000, 'attack' =>       1, 'sd' => array (202 =>   0, 203 =>   0, 204 =>   0, 205 =>   0, 206 =>   0, 207 =>   0, 208 =>   0, 209 =>   0, 210 =>    5, 211 =>   0, 212 =>    0, 213 =>   0, 214 =>   0, 215 =>   0, 216 =>   0) ),
		408 => array ( 'shield' =>   10000, 'attack' =>       1, 'sd' => array (202 =>   0, 203 =>   0, 204 =>   0, 205 =>   0, 206 =>   0, 207 =>   0, 208 =>   0, 209 =>   0, 210 =>    5, 211 =>   0, 212 =>    0, 213 =>   0, 214 =>   0, 215 =>   0, 216 =>   0) ),
		409 => array ( 'shield' => 1000000, 'attack' =>       1, 'sd' => array (202 =>   0, 203 =>   0, 204 =>   0, 205 =>   0, 206 =>   0, 207 =>   0, 208 =>   0, 209 =>   0, 210 =>    5, 211 =>   0, 212 =>    0, 213 =>   0, 214 =>   0, 215 =>   0, 216 =>   0) ),
		410 => array ( 'shield' =>   80000, 'attack' =>  500000, 'sd' => array (202 =>   0, 203 =>   0, 204 =>   0, 205 =>   0, 206 =>   0, 207 =>   0, 208 =>   0, 209 =>   0, 210 =>    5, 211 =>   0, 212 =>    0, 213 =>   0, 214 =>   0, 215 =>   0, 216 =>   0) ),
		411 => array ( 'shield' =>2000000000, 'attack' => 400000000, 'sd' => array (202 =>   0, 203 =>   0, 204 =>   0, 205 =>   0, 206 =>   0, 207 =>   0, 208 =>   0, 209 =>   0, 210 =>    5, 211 =>   0, 212 =>    0, 213 =>   0, 214 =>   0, 215 =>   0, 216 =>   0) ),
		
		502 => array ( 'shield' =>     1, 'attack' =>      1, 'sd' => array (202 =>   0, 203 =>   0, 204 =>   0, 205 =>   0, 206 =>   0, 207 =>   0, 208 =>   0, 209 =>   0, 210 =>    5, 211 =>   0, 212 =>    0, 213 =>   0, 214 =>   0, 215 =>   0, 216 =>   0)),
		503 => array ( 'shield' =>     1, 'attack' =>  12000, 'sd' => array (202 =>   0, 203 =>   0, 204 =>   0, 205 =>   0, 206 =>   0, 207 =>   0, 208 =>   0, 209 =>   0, 210 =>    5, 211 =>   0, 212 =>    0, 213 =>   0, 214 =>   0, 215 =>   0, 216 =>   0)),
	);
$reslist['defense']  = array ( 401, 402, 403, 404, 405, 406, 407, 408, 409, 410, 411, 502, 503 );
		
$Attack = array(
array(23, array('military_tech' => 0, 'defence_tech' => 0, 'shield_tech' => 0), array('rpg_amiral' => 0), array(
202 => 100000,
)),
);

$Defend = array(
array(57, array('military_tech' => 0, 'defence_tech' => 0, 'shield_tech' => 0), array('rpg_amiral' => 0), array(
214	=> 100,
)),
);

$Starttime	= microtime(true);
$Battle		= new BattleEngine($Attack, $Defend);
$BattleInfo	= $Battle->Battle();

$Endtime	= microtime(true) - $Starttime;

echo "Time :".$Endtime;
echo "<br><br><br>";
foreach($BattleInfo["battleinfo"] as $Round => $RoundInfo)
{
	echo "<br>\nRound ".$Round.": <br>\n<br>\n";
	echo "Attacker <br>\n";
	if(isset($RoundInfo['attacker'][0]))
	{
		foreach($RoundInfo['attacker'][0] as $ID => $Info) {
			echo "Ship ".$ID." - Count: ".$Info["count"]." Attack: ".$Info["attack"]." Shield: ".$Info["shield"]. " Integrity: ".$Info["integrity"]."<br>\n";
		}
	} else {
		echo "<br>\nDestroyed<br>\n";
	}
	echo "<br>\nDefender <br>\n";
	if(isset($RoundInfo['defender'][0]))
	{
		foreach($RoundInfo['defender'][0] as $ID => $Info) {
			echo "Ship ".$ID." - Count: ".$Info["count"]." Attack: ".$Info["attack"]." Shield: ".$Info["shield"]. " Integrity: ".$Info["integrity"]."<br>\n";
		}
	} else {
		echo "<br>\nDestroyed<br>\n";
	}
	if(isset($RoundInfo['attacker']['total']['attack']))
	{
		echo "<br>\n<br>\n";
		echo "Attacker Attack: ".$RoundInfo['attacker']['total']['attack']." - Attack Counts: ".$RoundInfo['attacker']['total']['count']." - Defender Defend ".$RoundInfo['defender']['total']['defend']."<br>\n";
		echo "Defender Attack: ".$RoundInfo['defender']['total']['attack']." - Attack Counts: ".$RoundInfo['defender']['total']['count']." - Attacker Defend ".$RoundInfo['attacker']['total']['defend']."<br>\n";
	}
}

echo "<br>\n<br>\n";
echo "Attacker UnitsLost: ".$BattleInfo['lost'][0]." - Defender Lost ".$BattleInfo['lost'][1]."<br>\n";
echo "Derbis Metall: ".$BattleInfo['derbis']['metal']." - Crystal: ".$BattleInfo['derbis']['crystal']."<br>\n";
echo "<br>\n<br>\n";
echo "Battle Result: ".$BattleInfo['result']."";
?>