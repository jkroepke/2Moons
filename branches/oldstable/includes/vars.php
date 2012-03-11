<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

$resource = array(
	1 	=> "metal_mine",
	2 	=> "crystal_mine",
	3 	=> "deuterium_sintetizer",
	4 	=> "solar_plant",
	6 	=> "university",
	12	=> "fusion_plant",
	14 	=> "robot_factory",
	15 	=> "nano_factory",
	21 	=> "hangar",
	22 	=> "metal_store",
	23 	=> "crystal_store",
	24 	=> "deuterium_store",
	31 	=> "laboratory",
	33 	=> "terraformer",
	34 	=> "ally_deposit",
	41 	=> "mondbasis",
	42 	=> "phalanx",
	43 	=> "sprungtor",
	44 	=> "silo",

	106	=> "spy_tech",
	108 => "computer_tech",
	109 => "military_tech",
	110 => "defence_tech",
	111 => "shield_tech",
	113 => "energy_tech",
	114 => "hyperspace_tech",
	115 => "combustion_tech",
	117 => "impulse_motor_tech",
	118 => "hyperspace_motor_tech",
	120 => "laser_tech",
	121 => "ionic_tech",
	122 => "buster_tech",
	123 => "intergalactic_tech",
	124 => "expedition_tech",
	131 => "metal_proc_tech",
	132 => "crystal_proc_tech",
	133 => "deuterium_proc_tech",
	199 => "graviton_tech",

	202 => "small_ship_cargo",
	203 => "big_ship_cargo",
	204 => "light_hunter",
	205 => "heavy_hunter",
	206 => "crusher",
	207 => "battle_ship",
	208 => "colonizer",
	209 => "recycler",
	210 => "spy_sonde",
	211 => "bomber_ship",
	212 => "solar_satelit",
	213 => "destructor",
	214 => "dearth_star",
	215 => "battleship",
	216 => "lune_noir",
	217 => "ev_transporter",
	218 => "star_crasher",
	219 => "giga_recykler",
	220 => "dm_ship",

	401 => "misil_launcher",
	402 => "small_laser",
	403 => "big_laser",
	404 => "gauss_canyon",
	405 => "ionic_canyon",
	406 => "buster_canyon",
	407 => "small_protection_shield",
	408 => "big_protection_shield",
	409 => "planet_protector",
	410 => "graviton_canyon",
	411 => "orbital_station",	

	502 => "interceptor_misil",
	503 => "interplanetary_misil",

	601 => "rpg_geologue",
	602 => "rpg_amiral",
	603 => "rpg_ingenieur",
	604 => "rpg_technocrate",
	605 => "rpg_constructeur",
	606 => "rpg_scientifique",
	607 => "rpg_stockeur",
	608 => "rpg_defenseur",
	609 => "rpg_bunker",
	610 => "rpg_espion",
	611 => "rpg_commandant",
	612 => "rpg_destructeur",
	613 => "rpg_general",
	614 => "rpg_raideur",
	615 => "rpg_empereur",

	700 => "dm_attack",
	701 => "dm_defensive",
	702 => "dm_buildtime",
	703 => "dm_resource",
	704 => "dm_energie",
	705 => "dm_researchtime",
	706 => "dm_fleettime",

	901 => 'metal',
	902 => 'crystal',
	903 => 'deuterium',
	911 => 'energy',
	921 => 'darkmatter',
);

$requeriments = array(
	6	=> array(  14 =>  20, 31  =>  22, 15 => 4, 108 => 12, 123 => 3),
	12	=> array(   3 =>   5, 113 =>   3),
	15	=> array(  14 =>  10, 108 =>  10),
	21	=> array(  14 =>   2),
	33	=> array(  15 =>   1, 113 =>  12),

	42	=> array(  41 =>   1),
	43	=> array(  41 =>   1, 114 =>   7),
	44	=> array(  21 =>   1),

	106 => array(  31 =>   3),
	108 => array(  31 =>   1),
	109 => array(  31 =>   4),
	110 => array( 113 =>   3,  31 =>   6),
	111 => array(  31 =>   2),
	113 => array(  31 =>   1),
	114 => array( 113 =>   5, 110 =>   5,  31 =>   7),
	115 => array( 113 =>   1,  31 =>   1),
	117 => array( 113 =>   1,  31 =>   2),
	118 => array( 114 =>   3,  31 =>   7),
	120 => array(  31 =>   1, 113 =>   2),
	121 => array(  31 =>   4, 120 =>   5, 113 =>   4),
	122 => array(  31 =>   5, 113 =>   8, 120 =>  10, 121 =>   5),
	123 => array(  31 =>  10, 108 =>   8, 114 =>   8),
	124 => array( 106 =>   3, 117 =>   3, 31 =>   3),
	131 => array(  31 =>   8, 113 =>   5),
	132 => array(  31 =>   8, 113 =>   5),
	133 => array(  31 =>   8, 113 =>   5),
	199 => array(  31 =>  12),

	202 => array(  21 =>   2, 115 =>   2),
	203 => array(  21 =>   4, 115 =>   6),
	204 => array(  21 =>   1, 115 =>   1),
	205 => array(  21 =>   3, 111 =>   2, 117 =>   2),
	206 => array(  21 =>   5, 117 =>   4, 121 =>   2),
	207 => array(  21 =>   7, 118 =>   4),
	208 => array(  21 =>   4, 117 =>   3),
	209 => array(  21 =>   4, 115 =>   6, 110 =>   2),
	210 => array(  21 =>   3, 115 =>   3, 106 =>   2),
	211 => array( 117 =>   6,  21 =>   8, 122 =>   5),
	212 => array(  21 =>   1),
	213 => array(  21 =>   9, 118 =>   6, 114 =>   5),
	214 => array(  21 =>  12, 118 =>   7, 114 =>   6, 199 =>   1),
	215 => array( 114 =>   5, 120 =>  12, 118 =>   5,  21 =>   8),
	216 => array( 106 =>  12,  21 =>  15, 109 =>  14, 110 => 14, 111 => 15, 114 => 10, 120 => 20, 199 => 3),
	217 => array( 111 =>  10,  21 =>  14, 114 =>  10, 110 => 14, 117 => 15),
	218 => array(  21 =>  18, 109 =>  20, 110 =>  20, 111 => 20, 114 => 15, 118 => 20, 120 => 25, 199 => 8),
	219 => array(  21 =>  15, 109 =>  15, 110 =>  15, 111 => 15, 118 => 8),
	220 => array(  21 =>   9, 114 =>   5, 118 =>   6),

	401 => array(  21 =>   1),
	402 => array( 113 =>   1,  21 =>   2, 120 =>   3),
	403 => array( 113 =>   3,  21 =>   4, 120 =>   6),
	404 => array(  21 =>   6, 113 =>   6, 109 =>   3, 110 =>   1),
	405 => array(  21 =>   4, 121 =>   4),
	406 => array(  21 =>   8, 122 =>   7),
	407 => array( 110 =>   2,  21 =>   1),
	408 => array( 110 =>   6,  21 =>   6),
	409 => array( 609 =>   1),
	410 => array( 199 =>   7,  21 =>  18, 109 => 20),
	411 => array( 199 =>  10, 110 =>  22, 122 =>  20, 108 => 15, 111 => 25, 113 => 20, 608 => 2, 21 => 20),
			
	
	502 => array(  44 =>   2,  21 =>   1),
	503 => array(  44 =>   4,  21 =>   1, 117 =>   1),
	
	603 => array( 601 =>   5),
	604 => array( 602 =>   5),
	605 => array( 601 =>  10, 603 =>   2),
	606 => array( 601 =>  10, 603 =>   2),
	607 => array( 605 =>   1),
	608 => array( 606 =>   1),
	609 => array( 601 =>  20, 603 =>  10, 605 =>   3, 606 =>   3, 607 =>   2, 608 =>   2),
	610 => array( 602 =>  10, 604 =>   5),
	611 => array( 602 =>  10, 604 =>   5),
	612 => array( 610 =>   1),
	613 => array( 611 =>   1),
	614 => array( 602 =>  20, 604 =>  10, 610 =>   2, 611 =>   2, 612 =>   1, 613 =>   3),
	615 => array( 614 =>   1, 609 =>   1),
);

$pricelist = array(
	// Builds
	1	=> array('cost' => array(901 => 60, 902 => 15, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1.5, 'max' => 254),
	2	=> array('cost' => array(901 => 48, 902 => 24, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1.6, 'max' => 255),
	3	=> array('cost' => array(901 => 225, 902 => 75, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1.5, 'max' => 255),
	4	=> array('cost' => array(901 => 75, 902 => 30, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1.5, 'max' => 255),
	6	=> array('cost' => array(901 => 100000000, 902 => 50000000, 903 => 25000000, 911 => 0, 921 => 0), 'factor' => 2.2, 'max' => 255),
	12 	=> array('cost' => array(901 => 900, 902 => 360, 903 => 180, 911 => 0, 921 => 0), 'factor' => 1.8, 'max' => 255),
	14 	=> array('cost' => array(901 => 400, 902 => 120, 903 => 200, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	15 	=> array('cost' => array(901 => 1000000, 902 => 500000, 903 => 100000, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	21 	=> array('cost' => array(901 => 400, 902 => 200, 903 => 100, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	22 	=> array('cost' => array(901 => 2000, 902 => 0, 903 => 0, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	23 	=> array('cost' => array(901 => 2000, 902 => 1000, 903 => 0, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	24 	=> array('cost' => array(901 => 2000, 902 => 2000, 903 => 0, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	31 	=> array('cost' => array(901 => 200, 902 => 400, 903 => 200, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	33 	=> array('cost' => array(901 => 0, 902 => 50000, 903 => 100000, 911 => 1000, 921 => 0), 'factor' =>   2, 'max' => 255),
	34 	=> array('cost' => array(901 => 20000, 902 => 40000, 903 => 0, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	41 	=> array('cost' => array(901 => 20000, 902 => 40000, 903 => 20000, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	42 	=> array('cost' => array(901 => 20000, 902 => 40000, 903 => 20000, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	43 	=> array('cost' => array(901 => 2000000, 902 => 4000000, 903 => 2000000, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	44 	=> array('cost' => array(901 => 20000, 902 => 20000, 903 => 1000, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),

	// Tech
	106 => array('cost' => array(901 => 200, 902 => 1000, 903 => 200, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	108 => array('cost' => array(901 => 0, 902 => 400, 903 => 600, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	109 => array('cost' => array(901 => 800, 902 => 200, 903 => 0, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	110 => array('cost' => array(901 => 200, 902 => 600, 903 => 0, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	111 => array('cost' => array(901 => 1000, 902 => 0, 903 => 0, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	113 => array('cost' => array(901 => 0, 902 => 800, 903 => 400, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	114 => array('cost' => array(901 => 0, 902 => 4000, 903 => 2000, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	115 => array('cost' => array(901 => 400, 902 => 0, 903 => 600, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	117 => array('cost' => array(901 => 2000, 902 => 4000, 903 => 600, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	118 => array('cost' => array(901 => 10000, 902 => 20000, 903 => 6000, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	120 => array('cost' => array(901 => 200, 902 => 100, 903 => 0, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	121 => array('cost' => array(901 => 1000, 902 => 300, 903 => 100, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	122 => array('cost' => array(901 => 2000, 902 => 4000, 903 => 1000, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	123 => array('cost' => array(901 => 240000, 902 => 400000, 903 => 160000, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	131 => array('cost' => array(901 => 750, 902 => 500, 903 => 250, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	132 => array('cost' => array(901 => 1000, 902 => 750, 903 => 500, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	133 => array('cost' => array(901 => 1250, 902 => 1000, 903 => 750, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	124 => array('cost' => array(901 => 4000, 902 => 8000, 903 => 4000, 911 => 0, 921 => 0), 'factor' =>   2, 'max' => 255),
	199 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 300000, 921 => 0), 'factor' =>   3, 'max' => 255),

	// Fleets
	202 => array('cost' => array(901 => 2000, 902 => 2000, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>     10, 'consumption2' => 20  , 'speed' =>      5000, 'speed2' =>     10000, 'capacity' =>      5000, 'tech'	=> 4),
	203 => array('cost' => array(901 => 6000, 902 => 6000, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>     50, 'consumption2' => 50  , 'speed' =>      7500, 'speed2' =>      7500, 'capacity' =>     25000, 'tech'	=> 1),
	204 => array('cost' => array(901 => 3000, 902 => 1000, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>     20, 'consumption2' => 20  , 'speed' =>     12500, 'speed2' =>     12500, 'capacity' =>        50, 'tech'	=> 1),
	205 => array('cost' => array(901 => 6000, 902 => 4000, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>     75, 'consumption2' => 75  , 'speed' =>     10000, 'speed2' =>     15000, 'capacity' =>       100, 'tech'	=> 2),
	206 => array('cost' => array(901 => 20000, 902 => 7000, 903 => 2000, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>    300, 'consumption2' => 300 , 'speed' =>     15000, 'speed2' =>     15000, 'capacity' =>       800, 'tech'	=> 2),
	207 => array('cost' => array(901 => 45000, 902 => 15000, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>    250, 'consumption2' => 250 , 'speed' =>     10000, 'speed2' =>     10000, 'capacity' =>      1500, 'tech'	=> 3),
	208 => array('cost' => array(901 => 10000, 902 => 20000, 903 => 10000, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>   1000, 'consumption2' => 1000, 'speed' =>      2500, 'speed2' =>      2500, 'capacity' =>      7500, 'tech'	=> 2),
	209 => array('cost' => array(901 => 10000, 902 => 6000, 903 => 2000, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>    300, 'consumption2' => 300 , 'speed' =>      2000, 'speed2' =>      2000, 'capacity' =>     20000, 'tech'	=> 1),
	210 => array('cost' => array(901 => 0, 902 => 1000, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>      1, 'consumption2' => 1   , 'speed' => 100000000, 'speed2' => 100000000, 'capacity' =>         5, 'tech'	=> 1),
	211 => array('cost' => array(901 => 50000, 902 => 25000, 903 => 15000, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>   1000, 'consumption2' => 1000, 'speed' =>      4000, 'speed2' =>      5000, 'capacity' =>       500, 'tech'	=> 5),
	212 => array('cost' => array(901 => 0, 902 => 2000, 903 => 500, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>      0, 'consumption2' => 0   , 'speed' =>         0, 'speed2' =>         0, 'capacity' =>         0, 'tech'	=> 0),
	213 => array('cost' => array(901 => 60000, 902 => 50000, 903 => 15000, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>   1000, 'consumption2' => 1000, 'speed' =>      5000, 'speed2' =>      5000, 'capacity' =>      2000, 'tech'	=> 3),
	214 => array('cost' => array(901 => 5000000, 902 => 4000000, 903 => 1000000, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>      1, 'consumption2' => 1   , 'speed' =>       200, 'speed2' =>       200, 'capacity' =>   1000000, 'tech'	=> 3),
	215 => array('cost' => array(901 => 30000, 902 => 40000, 903 => 15000, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>    250, 'consumption2' => 250 , 'speed' =>     10000, 'speed2' =>     10000, 'capacity' =>       750, 'tech'	=> 3),
	216 => array('cost' => array(901 => 8000000, 902 => 2000000, 903 => 1500000, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>    250, 'consumption2' => 250 , 'speed' =>       900, 'speed2' =>       900, 'capacity' =>  15000000, 'tech'	=> 3),
	217 => array('cost' => array(901 => 35000, 902 => 20000, 903 => 1500, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>     90, 'consumption2' =>     90, 'speed' =>    6000, 'speed2' =>      6000, 'capacity' => 400000000, 'tech'	=> 3),
	218 => array('cost' => array(901 => 275000000, 902 => 130000000, 903 => 60000000, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>  10000, 'consumption2' =>  10000, 'speed' =>      10, 'speed2' =>        10, 'capacity' =>  50000000, 'tech'	=> 3),
	219 => array('cost' => array(901 => 1000000, 902 => 600000, 903 => 200000, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' =>    300, 'consumption2' =>    300, 'speed' =>    7500, 'speed2' =>      7500, 'capacity' => 200000000, 'tech'	=> 3),
	220 => array('cost' => array(901 => 6000000, 902 => 7000000, 903 => 3000000, 911 => 0, 921 => 0), 'factor' => 1, 'consumption' => 100000, 'consumption2' => 100000, 'speed' =>     100, 'speed2' =>       100, 'capacity' =>   6000000, 'tech'	=> 3),

	// Defensive
	401 => array('cost' => array(901 => 2000, 902 => 0, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1 ),
	402 => array('cost' => array(901 => 1500, 902 => 500, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1 ),
	403 => array('cost' => array(901 => 6000, 902 => 2000, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1 ),
	404 => array('cost' => array(901 => 20000, 902 => 15000, 903 => 2000, 911 => 0, 921 => 0), 'factor' => 1 ),
	405 => array('cost' => array(901 => 2000, 902 => 6000, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1 ),
	406 => array('cost' => array(901 => 50000, 902 => 50000, 903 => 30000, 911 => 0, 921 => 0), 'factor' => 1 ),
	407 => array('cost' => array(901 => 10000, 902 => 10000, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1 ),
	408 => array('cost' => array(901 => 50000, 902 => 50000, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1 ),
	409 => array('cost' => array(901 => 10000000, 902 => 5000000, 903 => 2500000, 911 => 0, 921 => 0), 'factor' => 1 ),
	410 => array('cost' => array(901 => 15000000, 902 => 15000000, 903 => 0, 911 => 0, 921 => 0), 'factor' => 1 ),
	411 => array('cost' => array(901 => 5000000000, 902 => 2000000000, 903 => 500000000, 911 => 1000000, 921 => 10000), 'factor' => 1 ),         
	
	// Missils
	502 => array('cost' => array(901 => 8000, 902 => 0, 903 => 2000, 911 => 0, 921 => 0), 'factor' => 1 ),
	503 => array('cost' => array(901 => 12500, 902 => 2500, 903 => 10000, 911 => 0, 921 => 0), 'factor' => 1 ),

	// Officier
	601 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1000), 'factor' => 1, 'max' =>  20, 'info' => 0.05),
	602 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1000), 'factor' => 1, 'max' =>  20, 'info' => 0.05),
	603 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1000), 'factor' => 1, 'max' =>  10, 'info' => 0.05),
	604 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1000), 'factor' => 1, 'max' =>  10, 'info' => 0.05),
	605 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1000), 'factor' => 1, 'max' =>   3, 'info' => 0.1),
	606 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1000), 'factor' => 1, 'max' =>   3, 'info' => 0.1),
	607 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1000), 'factor' => 1, 'max' =>   2, 'info' => 0.5),
	608 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1000), 'factor' => 1, 'max' =>   2, 'info' => 0.25),
	609 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1000), 'factor' => 1, 'max' =>   1, 'info' => false),
	610 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1000), 'factor' => 1, 'max' =>   2, 'info' => 5),
	611 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1000), 'factor' => 1, 'max' =>   3, 'info' => 3),
	612 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1000), 'factor' => 1, 'max' =>   1, 'info' => false),
	613 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1000), 'factor' => 1, 'max' =>   3, 'info' => 0.10),
	614 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1000), 'factor' => 1, 'max' =>   1, 'info' => false),
	615 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1000), 'factor' => 1, 'max' =>   1, 'info' => false),

	// DM Extras
	700 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1500), 'time' => 86400, 'add' => 0.1),
	701 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1500), 'time' => 86400, 'add' => 0.1),
	702 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 750), 'time' => 86400, 'add' => 0.1),
	703 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 2500), 'time' => 86400, 'add' => 0.1),
	704 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 2000), 'time' => 86400, 'add' => 0.1),
	705 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 1250), 'time' => 86400, 'add' => 0.1),
	706 => array('cost' => array(901 => 0, 902 => 0, 903 => 0, 911 => 0, 921 => 3000), 'time' => 86400, 'add' => 0.1),
);
$CombatCaps = array(
	202 => array('shield' =>      10, 'attack' =>        5, 'sd' => array (210 =>    5, 212 =>    5)),
	203 => array('shield' =>      25, 'attack' =>        5, 'sd' => array (210 =>    5, 212 =>    5)),
	204 => array('shield' =>      10, 'attack' =>       50, 'sd' => array (210 =>    5, 212 =>    5)),
	205 => array('shield' =>      25, 'attack' =>      150, 'sd' => array (202 =>    3, 210 =>    5, 212 =>   5)),
	206 => array('shield' =>      50, 'attack' =>      400, 'sd' => array (204 =>    6, 401 =>   10, 210 =>   5, 212 =>   5)),
	207 => array('shield' =>     200, 'attack' =>     1000, 'sd' => array (210 =>    5, 212 =>    5)),
	208 => array('shield' =>     100, 'attack' =>       50, 'sd' => array (210 =>    5, 212 =>    5)),
	209 => array('shield' =>      10, 'attack' =>        1, 'sd' => array (210 =>    5, 212 =>    5)),
	210 => array('shield' =>    .001, 'attack' =>     .001, 'sd' => array ()),
	211 => array('shield' =>     500, 'attack' =>     1000, 'sd' => array (210 =>    5, 212 =>    5, 401 =>  20, 402 =>  20, 403 =>  10, 405 =>  10)),
	212 => array('shield' =>    .001, 'attack' =>     .001, 'sd' => array ()),
	213 => array('shield' =>     500, 'attack' =>     2000, 'sd' => array (210 =>    5, 212 =>    5, 215 =>   2, 402 =>  10)),
	214 => array('shield' =>   50000, 'attack' =>   200000, 'sd' => array (210 => 1250, 212 => 1250, 202 => 250, 203 => 250, 208 => 250, 209 => 250, 204 => 200, 205 => 100, 206 => 33, 207 => 30, 211 => 25, 215 => 15, 213 => 5, 401 => 200, 402 => 200, 403 => 100, 404 =>  50, 405 => 100)),
	215 => array('shield' =>     400, 'attack' =>      700, 'sd' => array (202 =>    3, 203 =>   3, 205 =>   4, 206 =>   4, 207 =>   10, 210 =>   5, 212 =>   5)),
	216 => array('shield' =>   70000, 'attack' =>   150000, 'sd' => array (210 => 1250, 212 => 1250, 202 => 250, 203 => 250, 204 => 200, 205 => 100, 206 =>  33, 207 =>  30, 208 => 250, 209 => 250, 211 =>  25, 213 =>   5, 214 =>   1, 215 =>  15, 401 => 400, 402 => 200, 403 => 100, 404 =>  50, 405 => 100)),
	217 => array('shield' =>     120, 'attack' =>       50, 'sd' => array (210 =>    5, 212 =>    5)),
	218 => array('shield' => 2000000, 'attack' => 35000000, 'sd' => array (210 => 1250, 212 => 1250, 202 => 250, 203 => 250, 204 => 200, 205 => 100, 206 =>  33, 207 =>  30, 208 => 250, 209 => 250, 211 =>  25, 213 =>   5, 215 =>  15, 401 => 400, 402 => 200, 403 => 100, 404 =>  50, 405 => 100)),
	219 => array('shield' =>    1000, 'attack' =>        1, 'sd' => array (210 =>    5, 212 =>    5)),
	220 => array('shield' =>   50000, 'attack' => 	     5, 'sd' => array (210 =>    5, 212 =>    5)),
	
	401 => array('shield' =>      20, 'attack' =>       80, 'sd' => array ()),
	402 => array('shield' =>      25, 'attack' =>      100, 'sd' => array ()),
	403 => array('shield' =>     100, 'attack' =>      250, 'sd' => array ()),
	404 => array('shield' =>     200, 'attack' =>     1100, 'sd' => array ()),
	405 => array('shield' =>     500, 'attack' =>      150, 'sd' => array ()),
	406 => array('shield' =>     300, 'attack' =>     3000, 'sd' => array ()),
	407 => array('shield' =>    2000, 'attack' =>        1, 'sd' => array ()),
	408 => array('shield' =>   10000, 'attack' =>        1, 'sd' => array ()),
	409 => array('shield' => 1000000, 'attack' =>        1, 'sd' => array ()),
	410 => array('shield' =>   80000, 'attack' =>   500000, 'sd' => array ()),
	411 => array('shield' =>2000000000, 'attack' => 400000000, 'sd' => array ()),
	
	502 => array('shield' =>     1, 'attack' =>      1, 'sd' => array ()),
	503 => array('shield' =>     1, 'attack' =>  12000,  'sd' => array ()),
);

$ProdGrid = array(
	1   => array(
		901	=> 'return (30 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);',
		902	=> 'return 0;',
		903	=> 'return 0;',
		911	=> 'return - (10 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);'
	),

	2   => array(
		901	=> 'return 0;',
		902	=> 'return (20 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);',
		903	=> 'return 0;',
		911	=> 'return - (10 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);'
	),

	3   => array(
		901	=> 'return 0;',
		902	=> 'return 0;',
		903	=> 'return (10 * $BuildLevel * pow((1.1), $BuildLevel) * (-0.002 * $BuildTemp + 1.28) * (0.1 * $BuildLevelFactor));',
		911	=> 'return - (30 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);'
	),

	4   => array(
		901	=> 'return 0;',
		902	=> 'return 0;',
		903	=> 'return 0;',
		911	=> 'return (20 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);'
	),

	12  => array(
		901	=> 'return 0;',
		902	=> 'return 0;',
		903	=> 'return - (10 * $BuildLevel * pow(1.1,$BuildLevel) * (0.1 * $BuildLevelFactor));',
		911	=> 'return (30 * $BuildLevel * pow((1.05 + $BuildEnergy * 0.01), $BuildLevel)) * (0.1 * $BuildLevelFactor);'
	),

	212 => array(
		901	=> 'return 0;',
		902	=> 'return 0;',
		903	=> 'return 0;',
		911	=> 'return ((($BuildTemp + 160) / 6) * (0.1 * $BuildLevelFactor) * $BuildLevel);'
	)
);

$reslist['allow']		= array(1 => array(1,  2,  3,  4,  6, 12, 14, 15, 21, 22, 23, 24, 31, 33, 34, 44), 3 => array(12, 14, 21, 22, 23, 24, 34, 41, 42, 43));
$reslist['build']		= array(  1,   2,   3,   4,   6,  12,  14,  15,  21,  22,  23,  24,  31,  33,  34,  44,  41,  42,  43);
$reslist['tech']		= array(106, 108, 109, 110, 111, 113, 114, 115, 117, 118, 120, 121, 122, 123, 124, 131, 132, 133, 199);
$reslist['fleet']		= array(202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220);
$reslist['defense']		= array(401, 402, 403, 404, 405, 406, 407, 408, 409, 410, 411, 502, 503 );
$reslist['officier']	= array(601, 602, 603, 604, 605, 606, 607, 608, 609, 610, 611, 612, 613, 614, 615);
$reslist['dmfunc']		= array(700, 701, 702, 703, 704, 705, 706);
$reslist['ressources']	= array(901, 902, 903, 911, 921);	# Do not edit this line.
$reslist['resstype'][1]	= array(901, 902, 903);				# Do not edit this line.
$reslist['resstype'][2]	= array(911);						# Do not edit this line.
$reslist['resstype'][3]	= array(921); 						# Do not edit this line.
$reslist['prod']		= array(  1,   2,   3,   4,  12, 212 );
$reslist['procent']		= array(100,  90,  80,  70,  60,  50,  40,  30,  20,  10,   0);
$reslist['one']			= array(407, 408, 409, 411);

?>