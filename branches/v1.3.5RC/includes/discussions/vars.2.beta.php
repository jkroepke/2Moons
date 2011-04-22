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
 * @version 1.3.5 (2011-04-22)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */
 
<?php
$ELEMENT	= array();
$ELEMENT[1]	= array();
$ELEMENT[1]['name']		= 'metal_mine';
$ELEMENT[1]['require']	= array();

$ELEMENT[1]['cost']		= array();
$ELEMENT[1]['cost'][901]	= 60;
$ELEMENT[1]['cost'][902]	= 15;
$ELEMENT[1]['cost'][903]	= 0;
$ELEMENT[1]['cost'][920]	= 0;
$ELEMENT[1]['cost'][910]	= 0;
$ELEMENT[1]['cost'][911]	= 0;

$ELEMENT[1]['prod']		= array();
$ELEMENT[1]['prod'][901]	= 'return   (30 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);';
$ELEMENT[1]['prod'][902]	= 'return   "0";';
$ELEMENT[1]['prod'][903]	= 'return   "0";';
$ELEMENT[1]['prod'][920]	= 'return 0;';
$ELEMENT[1]['prod'][910]	= 'return - (10 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);';


$ELEMENT[2]	= array();
$ELEMENT[2]['name']		= 'crystal_mine';
$ELEMENT[2]['require']	= array();

$ELEMENT[2]['cost']		= array();
$ELEMENT[2]['cost'][901]	= 48;
$ELEMENT[2]['cost'][902]	= 24;
$ELEMENT[2]['cost'][903]	= 0;
$ELEMENT[2]['cost'][920]	= 0;
$ELEMENT[2]['cost'][910]	= 0;
$ELEMENT[2]['cost'][911]	= 0;

$ELEMENT[2]['prod']		= array();
$ELEMENT[2]['prod'][901]	= 'return   "0";';
$ELEMENT[2]['prod'][902]	= 'return   (20 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);';
$ELEMENT[2]['prod'][903]	= 'return   "0";';
$ELEMENT[2]['prod'][920]	= 'return 0;';
$ELEMENT[2]['prod'][910]	= 'return - (10 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);';


$ELEMENT[3]	= array();
$ELEMENT[3]['name']		= 'deuterium_sintetizer';
$ELEMENT[3]['require']	= array();

$ELEMENT[3]['cost']		= array();
$ELEMENT[3]['cost'][901]	= 225;
$ELEMENT[3]['cost'][902]	= 75;
$ELEMENT[3]['cost'][903]	= 0;
$ELEMENT[3]['cost'][920]	= 0;
$ELEMENT[3]['cost'][910]	= 0;
$ELEMENT[3]['cost'][911]	= 0;

$ELEMENT[3]['prod']		= array();
$ELEMENT[3]['prod'][901]	= 'return   "0";';
$ELEMENT[3]['prod'][902]	= 'return   "0";';
$ELEMENT[3]['prod'][903]	= 'return   (10 * $BuildLevel * pow((1.1), $BuildLevel) * (-0.002 * $BuildTemp + 1.28) * (0.1 * $BuildLevelFactor));';
$ELEMENT[3]['prod'][920]	= 'return 0;';
$ELEMENT[3]['prod'][910]	= 'return - (30 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);';


$ELEMENT[4]	= array();
$ELEMENT[4]['name']		= 'solar_plant';
$ELEMENT[4]['require']	= array();

$ELEMENT[4]['cost']		= array();
$ELEMENT[4]['cost'][901]	= 75;
$ELEMENT[4]['cost'][902]	= 30;
$ELEMENT[4]['cost'][903]	= 0;
$ELEMENT[4]['cost'][920]	= 0;
$ELEMENT[4]['cost'][910]	= 0;
$ELEMENT[4]['cost'][911]	= 0;

$ELEMENT[4]['prod']		= array();
$ELEMENT[4]['prod'][901]	= 'return   "0";';
$ELEMENT[4]['prod'][902]	= 'return   "0";';
$ELEMENT[4]['prod'][903]	= 'return   "0";';
$ELEMENT[4]['prod'][920]	= 'return 0;';
$ELEMENT[4]['prod'][910]	= 'return   (20 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);';


$ELEMENT[6]	= array();
$ELEMENT[6]['name']		= 'university';
$ELEMENT[6]['require']	= array();
$ELEMENT[6]['require'][14]	= 20;
$ELEMENT[6]['require'][31]	= 22;
$ELEMENT[6]['require'][15]	= 4;
$ELEMENT[6]['require'][108]	= 12;
$ELEMENT[6]['require'][123]	= 3;

$ELEMENT[6]['cost']		= array();
$ELEMENT[6]['cost'][901]	= 100000000;
$ELEMENT[6]['cost'][902]	= 50000000;
$ELEMENT[6]['cost'][903]	= 25000000;
$ELEMENT[6]['cost'][920]	= 0;
$ELEMENT[6]['cost'][910]	= 0;
$ELEMENT[6]['cost'][911]	= 0;


$ELEMENT[12]	= array();
$ELEMENT[12]['name']		= 'fusion_plant';
$ELEMENT[12]['require']	= array();
$ELEMENT[12]['require'][3]	= 5;
$ELEMENT[12]['require'][113]	= 3;

$ELEMENT[12]['cost']		= array();
$ELEMENT[12]['cost'][901]	= 900;
$ELEMENT[12]['cost'][902]	= 360;
$ELEMENT[12]['cost'][903]	= 180;
$ELEMENT[12]['cost'][920]	= 0;
$ELEMENT[12]['cost'][910]	= 0;
$ELEMENT[12]['cost'][911]	= 0;

$ELEMENT[12]['prod']		= array();
$ELEMENT[12]['prod'][901]	= 'return   "0";';
$ELEMENT[12]['prod'][902]	= 'return   "0";';
$ELEMENT[12]['prod'][903]	= 'return - (10 * $BuildLevel * pow(1.1,$BuildLevel)  * (0.1 * $BuildLevelFactor));';
$ELEMENT[12]['prod'][920]	= 'return 0;';
$ELEMENT[12]['prod'][910]	= 'return   (30 * $BuildLevel * pow((1.05 + $BuildEnergy * 0.01), $BuildLevel)) * (0.1 * $BuildLevelFactor);';


$ELEMENT[14]	= array();
$ELEMENT[14]['name']		= 'robot_factory';
$ELEMENT[14]['require']	= array();

$ELEMENT[14]['cost']		= array();
$ELEMENT[14]['cost'][901]	= 400;
$ELEMENT[14]['cost'][902]	= 120;
$ELEMENT[14]['cost'][903]	= 200;
$ELEMENT[14]['cost'][920]	= 0;
$ELEMENT[14]['cost'][910]	= 0;
$ELEMENT[14]['cost'][911]	= 0;


$ELEMENT[15]	= array();
$ELEMENT[15]['name']		= 'nano_factory';
$ELEMENT[15]['require']	= array();
$ELEMENT[15]['require'][14]	= 10;
$ELEMENT[15]['require'][108]	= 10;

$ELEMENT[15]['cost']		= array();
$ELEMENT[15]['cost'][901]	= 1000000;
$ELEMENT[15]['cost'][902]	= 500000;
$ELEMENT[15]['cost'][903]	= 100000;
$ELEMENT[15]['cost'][920]	= 0;
$ELEMENT[15]['cost'][910]	= 0;
$ELEMENT[15]['cost'][911]	= 0;


$ELEMENT[21]	= array();
$ELEMENT[21]['name']		= 'hangar';
$ELEMENT[21]['require']	= array();
$ELEMENT[21]['require'][14]	= 2;

$ELEMENT[21]['cost']		= array();
$ELEMENT[21]['cost'][901]	= 400;
$ELEMENT[21]['cost'][902]	= 200;
$ELEMENT[21]['cost'][903]	= 100;
$ELEMENT[21]['cost'][920]	= 0;
$ELEMENT[21]['cost'][910]	= 0;
$ELEMENT[21]['cost'][911]	= 0;


$ELEMENT[22]	= array();
$ELEMENT[22]['name']		= 'metal_store';
$ELEMENT[22]['require']	= array();

$ELEMENT[22]['cost']		= array();
$ELEMENT[22]['cost'][901]	= 2000;
$ELEMENT[22]['cost'][902]	= 0;
$ELEMENT[22]['cost'][903]	= 0;
$ELEMENT[22]['cost'][920]	= 0;
$ELEMENT[22]['cost'][910]	= 0;
$ELEMENT[22]['cost'][911]	= 0;


$ELEMENT[23]	= array();
$ELEMENT[23]['name']		= 'crystal_store';
$ELEMENT[23]['require']	= array();

$ELEMENT[23]['cost']		= array();
$ELEMENT[23]['cost'][901]	= 2000;
$ELEMENT[23]['cost'][902]	= 1000;
$ELEMENT[23]['cost'][903]	= 0;
$ELEMENT[23]['cost'][920]	= 0;
$ELEMENT[23]['cost'][910]	= 0;
$ELEMENT[23]['cost'][911]	= 0;


$ELEMENT[24]	= array();
$ELEMENT[24]['name']		= 'deuterium_store';
$ELEMENT[24]['require']	= array();

$ELEMENT[24]['cost']		= array();
$ELEMENT[24]['cost'][901]	= 2000;
$ELEMENT[24]['cost'][902]	= 2000;
$ELEMENT[24]['cost'][903]	= 0;
$ELEMENT[24]['cost'][920]	= 0;
$ELEMENT[24]['cost'][910]	= 0;
$ELEMENT[24]['cost'][911]	= 0;


$ELEMENT[31]	= array();
$ELEMENT[31]['name']		= 'laboratory';
$ELEMENT[31]['require']	= array();

$ELEMENT[31]['cost']		= array();
$ELEMENT[31]['cost'][901]	= 200;
$ELEMENT[31]['cost'][902]	= 400;
$ELEMENT[31]['cost'][903]	= 200;
$ELEMENT[31]['cost'][920]	= 0;
$ELEMENT[31]['cost'][910]	= 0;
$ELEMENT[31]['cost'][911]	= 0;


$ELEMENT[33]	= array();
$ELEMENT[33]['name']		= 'terraformer';
$ELEMENT[33]['require']	= array();
$ELEMENT[33]['require'][15]	= 1;
$ELEMENT[33]['require'][113]	= 12;

$ELEMENT[33]['cost']		= array();
$ELEMENT[33]['cost'][901]	= 0;
$ELEMENT[33]['cost'][902]	= 50000;
$ELEMENT[33]['cost'][903]	= 100000;
$ELEMENT[33]['cost'][920]	= 0;
$ELEMENT[33]['cost'][910]	= 0;
$ELEMENT[33]['cost'][911]	= 1000;


$ELEMENT[34]	= array();
$ELEMENT[34]['name']		= 'ally_deposit';
$ELEMENT[34]['require']	= array();

$ELEMENT[34]['cost']		= array();
$ELEMENT[34]['cost'][901]	= 20000;
$ELEMENT[34]['cost'][902]	= 40000;
$ELEMENT[34]['cost'][903]	= 0;
$ELEMENT[34]['cost'][920]	= 0;
$ELEMENT[34]['cost'][910]	= 0;
$ELEMENT[34]['cost'][911]	= 0;


$ELEMENT[44]	= array();
$ELEMENT[44]['name']		= 'silo';
$ELEMENT[44]['require']	= array();
$ELEMENT[44]['require'][21]	= 1;

$ELEMENT[44]['cost']		= array();
$ELEMENT[44]['cost'][901]	= 20000;
$ELEMENT[44]['cost'][902]	= 20000;
$ELEMENT[44]['cost'][903]	= 1000;
$ELEMENT[44]['cost'][920]	= 0;
$ELEMENT[44]['cost'][910]	= 0;
$ELEMENT[44]['cost'][911]	= 0;


$ELEMENT[41]	= array();
$ELEMENT[41]['name']		= 'mondbasis';
$ELEMENT[41]['require']	= array();

$ELEMENT[41]['cost']		= array();
$ELEMENT[41]['cost'][901]	= 20000;
$ELEMENT[41]['cost'][902]	= 40000;
$ELEMENT[41]['cost'][903]	= 20000;
$ELEMENT[41]['cost'][920]	= 0;
$ELEMENT[41]['cost'][910]	= 0;
$ELEMENT[41]['cost'][911]	= 0;


$ELEMENT[42]	= array();
$ELEMENT[42]['name']		= 'phalanx';
$ELEMENT[42]['require']	= array();
$ELEMENT[42]['require'][41]	= 1;

$ELEMENT[42]['cost']		= array();
$ELEMENT[42]['cost'][901]	= 20000;
$ELEMENT[42]['cost'][902]	= 40000;
$ELEMENT[42]['cost'][903]	= 20000;
$ELEMENT[42]['cost'][920]	= 0;
$ELEMENT[42]['cost'][910]	= 0;
$ELEMENT[42]['cost'][911]	= 0;


$ELEMENT[43]	= array();
$ELEMENT[43]['name']		= 'sprungtor';
$ELEMENT[43]['require']	= array();
$ELEMENT[43]['require'][41]	= 1;
$ELEMENT[43]['require'][114]	= 7;

$ELEMENT[43]['cost']		= array();
$ELEMENT[43]['cost'][901]	= 2000000;
$ELEMENT[43]['cost'][902]	= 4000000;
$ELEMENT[43]['cost'][903]	= 2000000;
$ELEMENT[43]['cost'][920]	= 0;
$ELEMENT[43]['cost'][910]	= 0;
$ELEMENT[43]['cost'][911]	= 0;


$ELEMENT[106]	= array();
$ELEMENT[106]['name']		= 'spy_tech';
$ELEMENT[106]['max']		= 255;
$ELEMENT[106]['require']	= array();
$ELEMENT[106]['require'][31]	= 3;

$ELEMENT[106]['cost']		= array();
$ELEMENT[106]['cost'][901]	= 200;
$ELEMENT[106]['cost'][902]	= 1000;
$ELEMENT[106]['cost'][903]	= 200;
$ELEMENT[106]['cost'][920]	= 0;
$ELEMENT[106]['cost'][910]	= 0;
$ELEMENT[106]['cost'][911]	= 0;


$ELEMENT[108]	= array();
$ELEMENT[108]['name']		= 'computer_tech';
$ELEMENT[108]['max']		= 255;
$ELEMENT[108]['require']	= array();
$ELEMENT[108]['require'][31]	= 1;

$ELEMENT[108]['cost']		= array();
$ELEMENT[108]['cost'][901]	= 0;
$ELEMENT[108]['cost'][902]	= 400;
$ELEMENT[108]['cost'][903]	= 600;
$ELEMENT[108]['cost'][920]	= 0;
$ELEMENT[108]['cost'][910]	= 0;
$ELEMENT[108]['cost'][911]	= 0;


$ELEMENT[109]	= array();
$ELEMENT[109]['name']		= 'military_tech';
$ELEMENT[109]['max']		= 255;
$ELEMENT[109]['require']	= array();
$ELEMENT[109]['require'][31]	= 4;

$ELEMENT[109]['cost']		= array();
$ELEMENT[109]['cost'][901]	= 800;
$ELEMENT[109]['cost'][902]	= 200;
$ELEMENT[109]['cost'][903]	= 0;
$ELEMENT[109]['cost'][920]	= 0;
$ELEMENT[109]['cost'][910]	= 0;
$ELEMENT[109]['cost'][911]	= 0;


$ELEMENT[110]	= array();
$ELEMENT[110]['name']		= 'defence_tech';
$ELEMENT[110]['max']		= 255;
$ELEMENT[110]['require']	= array();
$ELEMENT[110]['require'][113]	= 3;
$ELEMENT[110]['require'][31]	= 6;

$ELEMENT[110]['cost']		= array();
$ELEMENT[110]['cost'][901]	= 200;
$ELEMENT[110]['cost'][902]	= 600;
$ELEMENT[110]['cost'][903]	= 0;
$ELEMENT[110]['cost'][920]	= 0;
$ELEMENT[110]['cost'][910]	= 0;
$ELEMENT[110]['cost'][911]	= 0;


$ELEMENT[111]	= array();
$ELEMENT[111]['name']		= 'shield_tech';
$ELEMENT[111]['max']		= 255;
$ELEMENT[111]['require']	= array();
$ELEMENT[111]['require'][31]	= 2;

$ELEMENT[111]['cost']		= array();
$ELEMENT[111]['cost'][901]	= 1000;
$ELEMENT[111]['cost'][902]	= 0;
$ELEMENT[111]['cost'][903]	= 0;
$ELEMENT[111]['cost'][920]	= 0;
$ELEMENT[111]['cost'][910]	= 0;
$ELEMENT[111]['cost'][911]	= 0;


$ELEMENT[113]	= array();
$ELEMENT[113]['name']		= 'energy_tech';
$ELEMENT[113]['max']		= 255;
$ELEMENT[113]['require']	= array();
$ELEMENT[113]['require'][31]	= 1;

$ELEMENT[113]['cost']		= array();
$ELEMENT[113]['cost'][901]	= 0;
$ELEMENT[113]['cost'][902]	= 800;
$ELEMENT[113]['cost'][903]	= 400;
$ELEMENT[113]['cost'][920]	= 0;
$ELEMENT[113]['cost'][910]	= 0;
$ELEMENT[113]['cost'][911]	= 0;


$ELEMENT[114]	= array();
$ELEMENT[114]['name']		= 'hyperspace_tech';
$ELEMENT[114]['max']		= 255;
$ELEMENT[114]['require']	= array();
$ELEMENT[114]['require'][113]	= 5;
$ELEMENT[114]['require'][110]	= 5;
$ELEMENT[114]['require'][31]	= 7;

$ELEMENT[114]['cost']		= array();
$ELEMENT[114]['cost'][901]	= 0;
$ELEMENT[114]['cost'][902]	= 4000;
$ELEMENT[114]['cost'][903]	= 2000;
$ELEMENT[114]['cost'][920]	= 0;
$ELEMENT[114]['cost'][910]	= 0;
$ELEMENT[114]['cost'][911]	= 0;


$ELEMENT[115]	= array();
$ELEMENT[115]['name']		= 'combustion_tech';
$ELEMENT[115]['max']		= 255;
$ELEMENT[115]['require']	= array();
$ELEMENT[115]['require'][113]	= 1;
$ELEMENT[115]['require'][31]	= 1;

$ELEMENT[115]['cost']		= array();
$ELEMENT[115]['cost'][901]	= 400;
$ELEMENT[115]['cost'][902]	= 0;
$ELEMENT[115]['cost'][903]	= 600;
$ELEMENT[115]['cost'][920]	= 0;
$ELEMENT[115]['cost'][910]	= 0;
$ELEMENT[115]['cost'][911]	= 0;


$ELEMENT[117]	= array();
$ELEMENT[117]['name']		= 'impulse_motor_tech';
$ELEMENT[117]['max']		= 255;
$ELEMENT[117]['require']	= array();
$ELEMENT[117]['require'][113]	= 1;
$ELEMENT[117]['require'][31]	= 2;

$ELEMENT[117]['cost']		= array();
$ELEMENT[117]['cost'][901]	= 2000;
$ELEMENT[117]['cost'][902]	= 4000;
$ELEMENT[117]['cost'][903]	= 600;
$ELEMENT[117]['cost'][920]	= 0;
$ELEMENT[117]['cost'][910]	= 0;
$ELEMENT[117]['cost'][911]	= 0;


$ELEMENT[118]	= array();
$ELEMENT[118]['name']		= 'hyperspace_motor_tech';
$ELEMENT[118]['max']		= 255;
$ELEMENT[118]['require']	= array();
$ELEMENT[118]['require'][114]	= 3;
$ELEMENT[118]['require'][31]	= 7;

$ELEMENT[118]['cost']		= array();
$ELEMENT[118]['cost'][901]	= 10000;
$ELEMENT[118]['cost'][902]	= 20000;
$ELEMENT[118]['cost'][903]	= 6000;
$ELEMENT[118]['cost'][920]	= 0;
$ELEMENT[118]['cost'][910]	= 0;
$ELEMENT[118]['cost'][911]	= 0;


$ELEMENT[120]	= array();
$ELEMENT[120]['name']		= 'laser_tech';
$ELEMENT[120]['max']		= 255;
$ELEMENT[120]['require']	= array();
$ELEMENT[120]['require'][31]	= 1;
$ELEMENT[120]['require'][113]	= 2;

$ELEMENT[120]['cost']		= array();
$ELEMENT[120]['cost'][901]	= 200;
$ELEMENT[120]['cost'][902]	= 100;
$ELEMENT[120]['cost'][903]	= 0;
$ELEMENT[120]['cost'][920]	= 0;
$ELEMENT[120]['cost'][910]	= 0;
$ELEMENT[120]['cost'][911]	= 0;


$ELEMENT[121]	= array();
$ELEMENT[121]['name']		= 'ionic_tech';
$ELEMENT[121]['max']		= 255;
$ELEMENT[121]['require']	= array();
$ELEMENT[121]['require'][31]	= 4;
$ELEMENT[121]['require'][120]	= 5;
$ELEMENT[121]['require'][113]	= 4;

$ELEMENT[121]['cost']		= array();
$ELEMENT[121]['cost'][901]	= 1000;
$ELEMENT[121]['cost'][902]	= 300;
$ELEMENT[121]['cost'][903]	= 100;
$ELEMENT[121]['cost'][920]	= 0;
$ELEMENT[121]['cost'][910]	= 0;
$ELEMENT[121]['cost'][911]	= 0;


$ELEMENT[122]	= array();
$ELEMENT[122]['name']		= 'buster_tech';
$ELEMENT[122]['max']		= 255;
$ELEMENT[122]['require']	= array();
$ELEMENT[122]['require'][31]	= 5;
$ELEMENT[122]['require'][113]	= 8;
$ELEMENT[122]['require'][120]	= 10;
$ELEMENT[122]['require'][121]	= 5;

$ELEMENT[122]['cost']		= array();
$ELEMENT[122]['cost'][901]	= 2000;
$ELEMENT[122]['cost'][902]	= 4000;
$ELEMENT[122]['cost'][903]	= 1000;
$ELEMENT[122]['cost'][920]	= 0;
$ELEMENT[122]['cost'][910]	= 0;
$ELEMENT[122]['cost'][911]	= 0;


$ELEMENT[123]	= array();
$ELEMENT[123]['name']		= 'intergalactic_tech';
$ELEMENT[123]['max']		= 255;
$ELEMENT[123]['require']	= array();
$ELEMENT[123]['require'][31]	= 10;
$ELEMENT[123]['require'][108]	= 8;
$ELEMENT[123]['require'][114]	= 8;

$ELEMENT[123]['cost']		= array();
$ELEMENT[123]['cost'][901]	= 240000;
$ELEMENT[123]['cost'][902]	= 400000;
$ELEMENT[123]['cost'][903]	= 160000;
$ELEMENT[123]['cost'][920]	= 0;
$ELEMENT[123]['cost'][910]	= 0;
$ELEMENT[123]['cost'][911]	= 0;


$ELEMENT[124]	= array();
$ELEMENT[124]['name']		= 'expedition_tech';
$ELEMENT[124]['max']		= 255;
$ELEMENT[124]['require']	= array();
$ELEMENT[124]['require'][106]	= 3;
$ELEMENT[124]['require'][117]	= 3;
$ELEMENT[124]['require'][31]	= 3;

$ELEMENT[124]['cost']		= array();
$ELEMENT[124]['cost'][901]	= 4000;
$ELEMENT[124]['cost'][902]	= 8000;
$ELEMENT[124]['cost'][903]	= 4000;
$ELEMENT[124]['cost'][920]	= 0;
$ELEMENT[124]['cost'][910]	= 0;
$ELEMENT[124]['cost'][911]	= 0;


$ELEMENT[131]	= array();
$ELEMENT[131]['name']		= 'metal_proc_tech';
$ELEMENT[131]['max']		= 255;
$ELEMENT[131]['require']	= array();
$ELEMENT[131]['require'][31]	= 8;
$ELEMENT[131]['require'][113]	= 5;

$ELEMENT[131]['cost']		= array();
$ELEMENT[131]['cost'][901]	= 750;
$ELEMENT[131]['cost'][902]	= 500;
$ELEMENT[131]['cost'][903]	= 250;
$ELEMENT[131]['cost'][920]	= 0;
$ELEMENT[131]['cost'][910]	= 0;
$ELEMENT[131]['cost'][911]	= 0;


$ELEMENT[132]	= array();
$ELEMENT[132]['name']		= 'crystal_proc_tech';
$ELEMENT[132]['max']		= 255;
$ELEMENT[132]['require']	= array();
$ELEMENT[132]['require'][31]	= 8;
$ELEMENT[132]['require'][113]	= 5;

$ELEMENT[132]['cost']		= array();
$ELEMENT[132]['cost'][901]	= 1000;
$ELEMENT[132]['cost'][902]	= 750;
$ELEMENT[132]['cost'][903]	= 500;
$ELEMENT[132]['cost'][920]	= 0;
$ELEMENT[132]['cost'][910]	= 0;
$ELEMENT[132]['cost'][911]	= 0;


$ELEMENT[133]	= array();
$ELEMENT[133]['name']		= 'deuterium_proc_tech';
$ELEMENT[133]['max']		= 255;
$ELEMENT[133]['require']	= array();
$ELEMENT[133]['require'][31]	= 8;
$ELEMENT[133]['require'][113]	= 5;

$ELEMENT[133]['cost']		= array();
$ELEMENT[133]['cost'][901]	= 1250;
$ELEMENT[133]['cost'][902]	= 1000;
$ELEMENT[133]['cost'][903]	= 750;
$ELEMENT[133]['cost'][920]	= 0;
$ELEMENT[133]['cost'][910]	= 0;
$ELEMENT[133]['cost'][911]	= 0;


$ELEMENT[199]	= array();
$ELEMENT[199]['name']		= 'graviton_tech';
$ELEMENT[199]['max']		= 255;
$ELEMENT[199]['require']	= array();
$ELEMENT[199]['require'][31]	= 12;

$ELEMENT[199]['cost']		= array();
$ELEMENT[199]['cost'][901]	= 0;
$ELEMENT[199]['cost'][902]	= 0;
$ELEMENT[199]['cost'][903]	= 0;
$ELEMENT[199]['cost'][920]	= 0;
$ELEMENT[199]['cost'][910]	= 0;
$ELEMENT[199]['cost'][911]	= 300000;


$ELEMENT[202]	= array();
$ELEMENT[202]['name']		= 'small_ship_cargo';
$ELEMENT[202]['require']	= array();
$ELEMENT[202]['require'][21]	= 2;
$ELEMENT[202]['require'][115]	= 2;

$ELEMENT[202]['cost']		= array();
$ELEMENT[202]['cost'][901]	= 2000;
$ELEMENT[202]['cost'][902]	= 2000;
$ELEMENT[202]['cost'][903]	= 0;
$ELEMENT[202]['cost'][920]	= 0;
$ELEMENT[202]['cost'][910]	= 0;
$ELEMENT[202]['cost'][911]	= 0;

$ELEMENT[202]['info']		= array();
$ELEMENT[202]['info']['metal']			= 2000;
$ELEMENT[202]['info']['crystal']		= 2000;
$ELEMENT[202]['info']['deuterium']		= 0;
$ELEMENT[202]['info']['energy_max']		= 0;
$ELEMENT[202]['info']['darkmatter']		= 0;
$ELEMENT[202]['info']['factor']			= 1;
$ELEMENT[202]['info']['consumption']	= 10;
$ELEMENT[202]['info']['consumption2']	= 20;
$ELEMENT[202]['info']['speed']			= 5000;
$ELEMENT[202]['info']['speed2']			= 10000;
$ELEMENT[202]['info']['capacity']		= 5000;
$ELEMENT[202]['info']['tech']			= 4;

$ELEMENT[202]['combat']		= array();
$ELEMENT[202]['combat']['shield']	= 10;
$ELEMENT[202]['combat']['attack']	= 5;
$ELEMENT[202]['combat']['sd']		= array();
$ELEMENT[202]['combat']['sd'][210]	= 5;
$ELEMENT[202]['combat']['sd'][212]	= 5;



$ELEMENT[203]	= array();
$ELEMENT[203]['name']		= 'big_ship_cargo';
$ELEMENT[203]['require']	= array();
$ELEMENT[203]['require'][21]	= 4;
$ELEMENT[203]['require'][115]	= 6;

$ELEMENT[203]['cost']		= array();
$ELEMENT[203]['cost'][901]	= 6000;
$ELEMENT[203]['cost'][902]	= 6000;
$ELEMENT[203]['cost'][903]	= 0;
$ELEMENT[203]['cost'][920]	= 0;
$ELEMENT[203]['cost'][910]	= 0;
$ELEMENT[203]['cost'][911]	= 0;

$ELEMENT[203]['info']		= array();
$ELEMENT[203]['info']['metal']			= 6000;
$ELEMENT[203]['info']['crystal']		= 6000;
$ELEMENT[203]['info']['deuterium']		= 0;
$ELEMENT[203]['info']['energy_max']		= 0;
$ELEMENT[203]['info']['darkmatter']		= 0;
$ELEMENT[203]['info']['factor']			= 1;
$ELEMENT[203]['info']['consumption']	= 50;
$ELEMENT[203]['info']['consumption2']	= 50;
$ELEMENT[203]['info']['speed']			= 7500;
$ELEMENT[203]['info']['speed2']			= 7500;
$ELEMENT[203]['info']['capacity']		= 25000;
$ELEMENT[203]['info']['tech']			= 1;

$ELEMENT[203]['combat']		= array();
$ELEMENT[203]['combat']['shield']	= 25;
$ELEMENT[203]['combat']['attack']	= 5;
$ELEMENT[203]['combat']['sd']		= array();
$ELEMENT[203]['combat']['sd'][210]	= 5;
$ELEMENT[203]['combat']['sd'][212]	= 5;



$ELEMENT[204]	= array();
$ELEMENT[204]['name']		= 'light_hunter';
$ELEMENT[204]['require']	= array();
$ELEMENT[204]['require'][21]	= 1;
$ELEMENT[204]['require'][115]	= 1;

$ELEMENT[204]['cost']		= array();
$ELEMENT[204]['cost'][901]	= 3000;
$ELEMENT[204]['cost'][902]	= 1000;
$ELEMENT[204]['cost'][903]	= 0;
$ELEMENT[204]['cost'][920]	= 0;
$ELEMENT[204]['cost'][910]	= 0;
$ELEMENT[204]['cost'][911]	= 0;

$ELEMENT[204]['info']		= array();
$ELEMENT[204]['info']['metal']			= 3000;
$ELEMENT[204]['info']['crystal']		= 1000;
$ELEMENT[204]['info']['deuterium']		= 0;
$ELEMENT[204]['info']['energy_max']		= 0;
$ELEMENT[204]['info']['darkmatter']		= 0;
$ELEMENT[204]['info']['factor']			= 1;
$ELEMENT[204]['info']['consumption']	= 20;
$ELEMENT[204]['info']['consumption2']	= 20;
$ELEMENT[204]['info']['speed']			= 12500;
$ELEMENT[204]['info']['speed2']			= 12500;
$ELEMENT[204]['info']['capacity']		= 50;
$ELEMENT[204]['info']['tech']			= 1;

$ELEMENT[204]['combat']		= array();
$ELEMENT[204]['combat']['shield']	= 10;
$ELEMENT[204]['combat']['attack']	= 50;
$ELEMENT[204]['combat']['sd']		= array();
$ELEMENT[204]['combat']['sd'][210]	= 5;
$ELEMENT[204]['combat']['sd'][212]	= 5;



$ELEMENT[205]	= array();
$ELEMENT[205]['name']		= 'heavy_hunter';
$ELEMENT[205]['require']	= array();
$ELEMENT[205]['require'][21]	= 3;
$ELEMENT[205]['require'][111]	= 2;
$ELEMENT[205]['require'][117]	= 2;

$ELEMENT[205]['cost']		= array();
$ELEMENT[205]['cost'][901]	= 6000;
$ELEMENT[205]['cost'][902]	= 4000;
$ELEMENT[205]['cost'][903]	= 0;
$ELEMENT[205]['cost'][920]	= 0;
$ELEMENT[205]['cost'][910]	= 0;
$ELEMENT[205]['cost'][911]	= 0;

$ELEMENT[205]['info']		= array();
$ELEMENT[205]['info']['metal']			= 6000;
$ELEMENT[205]['info']['crystal']		= 4000;
$ELEMENT[205]['info']['deuterium']		= 0;
$ELEMENT[205]['info']['energy_max']		= 0;
$ELEMENT[205]['info']['darkmatter']		= 0;
$ELEMENT[205]['info']['factor']			= 1;
$ELEMENT[205]['info']['consumption']	= 75;
$ELEMENT[205]['info']['consumption2']	= 75;
$ELEMENT[205]['info']['speed']			= 10000;
$ELEMENT[205]['info']['speed2']			= 15000;
$ELEMENT[205]['info']['capacity']		= 100;
$ELEMENT[205]['info']['tech']			= 2;

$ELEMENT[205]['combat']		= array();
$ELEMENT[205]['combat']['shield']	= 25;
$ELEMENT[205]['combat']['attack']	= 150;
$ELEMENT[205]['combat']['sd']		= array();
$ELEMENT[205]['combat']['sd'][202]	= 3;
$ELEMENT[205]['combat']['sd'][210]	= 5;
$ELEMENT[205]['combat']['sd'][212]	= 5;



$ELEMENT[206]	= array();
$ELEMENT[206]['name']		= 'crusher';
$ELEMENT[206]['require']	= array();
$ELEMENT[206]['require'][21]	= 5;
$ELEMENT[206]['require'][117]	= 4;
$ELEMENT[206]['require'][121]	= 2;

$ELEMENT[206]['cost']		= array();
$ELEMENT[206]['cost'][901]	= 20000;
$ELEMENT[206]['cost'][902]	= 7000;
$ELEMENT[206]['cost'][903]	= 2000;
$ELEMENT[206]['cost'][920]	= 0;
$ELEMENT[206]['cost'][910]	= 0;
$ELEMENT[206]['cost'][911]	= 0;

$ELEMENT[206]['info']		= array();
$ELEMENT[206]['info']['metal']			= 20000;
$ELEMENT[206]['info']['crystal']		= 7000;
$ELEMENT[206]['info']['deuterium']		= 2000;
$ELEMENT[206]['info']['energy_max']		= 0;
$ELEMENT[206]['info']['darkmatter']		= 0;
$ELEMENT[206]['info']['factor']			= 1;
$ELEMENT[206]['info']['consumption']	= 300;
$ELEMENT[206]['info']['consumption2']	= 300;
$ELEMENT[206]['info']['speed']			= 15000;
$ELEMENT[206]['info']['speed2']			= 15000;
$ELEMENT[206]['info']['capacity']		= 800;
$ELEMENT[206]['info']['tech']			= 2;

$ELEMENT[206]['combat']		= array();
$ELEMENT[206]['combat']['shield']	= 50;
$ELEMENT[206]['combat']['attack']	= 400;
$ELEMENT[206]['combat']['sd']		= array();
$ELEMENT[206]['combat']['sd'][204]	= 6;
$ELEMENT[206]['combat']['sd'][401]	= 10;
$ELEMENT[206]['combat']['sd'][210]	= 5;
$ELEMENT[206]['combat']['sd'][212]	= 5;



$ELEMENT[207]	= array();
$ELEMENT[207]['name']		= 'battle_ship';
$ELEMENT[207]['require']	= array();
$ELEMENT[207]['require'][21]	= 7;
$ELEMENT[207]['require'][118]	= 4;

$ELEMENT[207]['cost']		= array();
$ELEMENT[207]['cost'][901]	= 45000;
$ELEMENT[207]['cost'][902]	= 15000;
$ELEMENT[207]['cost'][903]	= 0;
$ELEMENT[207]['cost'][920]	= 0;
$ELEMENT[207]['cost'][910]	= 0;
$ELEMENT[207]['cost'][911]	= 0;

$ELEMENT[207]['info']		= array();
$ELEMENT[207]['info']['metal']			= 45000;
$ELEMENT[207]['info']['crystal']		= 15000;
$ELEMENT[207]['info']['deuterium']		= 0;
$ELEMENT[207]['info']['energy_max']		= 0;
$ELEMENT[207]['info']['darkmatter']		= 0;
$ELEMENT[207]['info']['factor']			= 1;
$ELEMENT[207]['info']['consumption']	= 250;
$ELEMENT[207]['info']['consumption2']	= 250;
$ELEMENT[207]['info']['speed']			= 10000;
$ELEMENT[207]['info']['speed2']			= 10000;
$ELEMENT[207]['info']['capacity']		= 1500;
$ELEMENT[207]['info']['tech']			= 3;

$ELEMENT[207]['combat']		= array();
$ELEMENT[207]['combat']['shield']	= 200;
$ELEMENT[207]['combat']['attack']	= 1000;
$ELEMENT[207]['combat']['sd']		= array();
$ELEMENT[207]['combat']['sd'][210]	= 5;
$ELEMENT[207]['combat']['sd'][212]	= 5;



$ELEMENT[208]	= array();
$ELEMENT[208]['name']		= 'colonizer';
$ELEMENT[208]['require']	= array();
$ELEMENT[208]['require'][21]	= 4;
$ELEMENT[208]['require'][117]	= 3;

$ELEMENT[208]['cost']		= array();
$ELEMENT[208]['cost'][901]	= 10000;
$ELEMENT[208]['cost'][902]	= 20000;
$ELEMENT[208]['cost'][903]	= 10000;
$ELEMENT[208]['cost'][920]	= 0;
$ELEMENT[208]['cost'][910]	= 0;
$ELEMENT[208]['cost'][911]	= 0;

$ELEMENT[208]['info']		= array();
$ELEMENT[208]['info']['metal']			= 10000;
$ELEMENT[208]['info']['crystal']		= 20000;
$ELEMENT[208]['info']['deuterium']		= 10000;
$ELEMENT[208]['info']['energy_max']		= 0;
$ELEMENT[208]['info']['darkmatter']		= 0;
$ELEMENT[208]['info']['factor']			= 1;
$ELEMENT[208]['info']['consumption']	= 1000;
$ELEMENT[208]['info']['consumption2']	= 1000;
$ELEMENT[208]['info']['speed']			= 2500;
$ELEMENT[208]['info']['speed2']			= 2500;
$ELEMENT[208]['info']['capacity']		= 7500;
$ELEMENT[208]['info']['tech']			= 2;

$ELEMENT[208]['combat']		= array();
$ELEMENT[208]['combat']['shield']	= 100;
$ELEMENT[208]['combat']['attack']	= 50;
$ELEMENT[208]['combat']['sd']		= array();
$ELEMENT[208]['combat']['sd'][210]	= 5;
$ELEMENT[208]['combat']['sd'][212]	= 5;



$ELEMENT[209]	= array();
$ELEMENT[209]['name']		= 'recycler';
$ELEMENT[209]['require']	= array();
$ELEMENT[209]['require'][21]	= 4;
$ELEMENT[209]['require'][115]	= 6;
$ELEMENT[209]['require'][110]	= 2;

$ELEMENT[209]['cost']		= array();
$ELEMENT[209]['cost'][901]	= 10000;
$ELEMENT[209]['cost'][902]	= 6000;
$ELEMENT[209]['cost'][903]	= 2000;
$ELEMENT[209]['cost'][920]	= 0;
$ELEMENT[209]['cost'][910]	= 0;
$ELEMENT[209]['cost'][911]	= 0;

$ELEMENT[209]['info']		= array();
$ELEMENT[209]['info']['metal']			= 10000;
$ELEMENT[209]['info']['crystal']		= 6000;
$ELEMENT[209]['info']['deuterium']		= 2000;
$ELEMENT[209]['info']['energy_max']		= 0;
$ELEMENT[209]['info']['darkmatter']		= 0;
$ELEMENT[209]['info']['factor']			= 1;
$ELEMENT[209]['info']['consumption']	= 300;
$ELEMENT[209]['info']['consumption2']	= 300;
$ELEMENT[209]['info']['speed']			= 2000;
$ELEMENT[209]['info']['speed2']			= 2000;
$ELEMENT[209]['info']['capacity']		= 20000;
$ELEMENT[209]['info']['tech']			= 1;

$ELEMENT[209]['combat']		= array();
$ELEMENT[209]['combat']['shield']	= 10;
$ELEMENT[209]['combat']['attack']	= 1;
$ELEMENT[209]['combat']['sd']		= array();
$ELEMENT[209]['combat']['sd'][210]	= 5;
$ELEMENT[209]['combat']['sd'][212]	= 5;



$ELEMENT[210]	= array();
$ELEMENT[210]['name']		= 'spy_sonde';
$ELEMENT[210]['require']	= array();
$ELEMENT[210]['require'][21]	= 3;
$ELEMENT[210]['require'][115]	= 3;
$ELEMENT[210]['require'][106]	= 2;

$ELEMENT[210]['cost']		= array();
$ELEMENT[210]['cost'][901]	= 0;
$ELEMENT[210]['cost'][902]	= 1000;
$ELEMENT[210]['cost'][903]	= 0;
$ELEMENT[210]['cost'][920]	= 0;
$ELEMENT[210]['cost'][910]	= 0;
$ELEMENT[210]['cost'][911]	= 0;

$ELEMENT[210]['info']		= array();
$ELEMENT[210]['info']['metal']			= 0;
$ELEMENT[210]['info']['crystal']		= 1000;
$ELEMENT[210]['info']['deuterium']		= 0;
$ELEMENT[210]['info']['energy_max']		= 0;
$ELEMENT[210]['info']['darkmatter']		= 0;
$ELEMENT[210]['info']['factor']			= 1;
$ELEMENT[210]['info']['consumption']	= 1;
$ELEMENT[210]['info']['consumption2']	= 1;
$ELEMENT[210]['info']['speed']			= 100000000;
$ELEMENT[210]['info']['speed2']			= 100000000;
$ELEMENT[210]['info']['capacity']		= 5;
$ELEMENT[210]['info']['tech']			= 1;

$ELEMENT[210]['combat']		= array();
$ELEMENT[210]['combat']['shield']	= 0.001;
$ELEMENT[210]['combat']['attack']	= 0.001;
$ELEMENT[210]['combat']['sd']		= array();



$ELEMENT[211]	= array();
$ELEMENT[211]['name']		= 'bomber_ship';
$ELEMENT[211]['require']	= array();
$ELEMENT[211]['require'][117]	= 6;
$ELEMENT[211]['require'][21]	= 8;
$ELEMENT[211]['require'][122]	= 5;

$ELEMENT[211]['cost']		= array();
$ELEMENT[211]['cost'][901]	= 50000;
$ELEMENT[211]['cost'][902]	= 25000;
$ELEMENT[211]['cost'][903]	= 15000;
$ELEMENT[211]['cost'][920]	= 0;
$ELEMENT[211]['cost'][910]	= 0;
$ELEMENT[211]['cost'][911]	= 0;

$ELEMENT[211]['info']		= array();
$ELEMENT[211]['info']['metal']			= 50000;
$ELEMENT[211]['info']['crystal']		= 25000;
$ELEMENT[211]['info']['deuterium']		= 15000;
$ELEMENT[211]['info']['energy_max']		= 0;
$ELEMENT[211]['info']['darkmatter']		= 0;
$ELEMENT[211]['info']['factor']			= 1;
$ELEMENT[211]['info']['consumption']	= 1000;
$ELEMENT[211]['info']['consumption2']	= 1000;
$ELEMENT[211]['info']['speed']			= 4000;
$ELEMENT[211]['info']['speed2']			= 5000;
$ELEMENT[211]['info']['capacity']		= 500;
$ELEMENT[211]['info']['tech']			= 5;

$ELEMENT[211]['combat']		= array();
$ELEMENT[211]['combat']['shield']	= 500;
$ELEMENT[211]['combat']['attack']	= 1000;
$ELEMENT[211]['combat']['sd']		= array();
$ELEMENT[211]['combat']['sd'][210]	= 5;
$ELEMENT[211]['combat']['sd'][212]	= 5;
$ELEMENT[211]['combat']['sd'][401]	= 20;
$ELEMENT[211]['combat']['sd'][402]	= 20;
$ELEMENT[211]['combat']['sd'][403]	= 10;
$ELEMENT[211]['combat']['sd'][405]	= 10;



$ELEMENT[212]	= array();
$ELEMENT[212]['name']		= 'solar_satelit';
$ELEMENT[212]['require']	= array();
$ELEMENT[212]['require'][21]	= 1;

$ELEMENT[212]['cost']		= array();
$ELEMENT[212]['cost'][901]	= 0;
$ELEMENT[212]['cost'][902]	= 2000;
$ELEMENT[212]['cost'][903]	= 500;
$ELEMENT[212]['cost'][920]	= 0;
$ELEMENT[212]['cost'][910]	= 0;
$ELEMENT[212]['cost'][911]	= 0;

$ELEMENT[212]['info']		= array();
$ELEMENT[212]['info']['metal']			= 0;
$ELEMENT[212]['info']['crystal']		= 2000;
$ELEMENT[212]['info']['deuterium']		= 500;
$ELEMENT[212]['info']['energy_max']		= 0;
$ELEMENT[212]['info']['darkmatter']		= 0;
$ELEMENT[212]['info']['factor']			= 1;
$ELEMENT[212]['info']['consumption']	= 0;
$ELEMENT[212]['info']['consumption2']	= 0;
$ELEMENT[212]['info']['speed']			= 0;
$ELEMENT[212]['info']['speed2']			= 0;
$ELEMENT[212]['info']['capacity']		= 0;
$ELEMENT[212]['info']['tech']			= 0;

$ELEMENT[212]['combat']		= array();
$ELEMENT[212]['combat']['shield']	= 0.001;
$ELEMENT[212]['combat']['attack']	= 0.001;
$ELEMENT[212]['combat']['sd']		= array();


$ELEMENT[212]['prod']		= array();
$ELEMENT[212]['prod'][901]	= 'return   "0";';
$ELEMENT[212]['prod'][902]	= 'return   "0";';
$ELEMENT[212]['prod'][903]	= 'return   "0";';
$ELEMENT[212]['prod'][920]	= 'return 0;';
$ELEMENT[212]['prod'][910]	= 'return  ((($BuildTemp + 160) / 6) * (0.1 * $BuildLevelFactor) * $BuildLevel);';


$ELEMENT[213]	= array();
$ELEMENT[213]['name']		= 'destructor';
$ELEMENT[213]['require']	= array();
$ELEMENT[213]['require'][21]	= 9;
$ELEMENT[213]['require'][118]	= 6;
$ELEMENT[213]['require'][114]	= 5;

$ELEMENT[213]['cost']		= array();
$ELEMENT[213]['cost'][901]	= 60000;
$ELEMENT[213]['cost'][902]	= 50000;
$ELEMENT[213]['cost'][903]	= 15000;
$ELEMENT[213]['cost'][920]	= 0;
$ELEMENT[213]['cost'][910]	= 0;
$ELEMENT[213]['cost'][911]	= 0;

$ELEMENT[213]['info']		= array();
$ELEMENT[213]['info']['metal']			= 60000;
$ELEMENT[213]['info']['crystal']		= 50000;
$ELEMENT[213]['info']['deuterium']		= 15000;
$ELEMENT[213]['info']['energy_max']		= 0;
$ELEMENT[213]['info']['darkmatter']		= 0;
$ELEMENT[213]['info']['factor']			= 1;
$ELEMENT[213]['info']['consumption']	= 1000;
$ELEMENT[213]['info']['consumption2']	= 1000;
$ELEMENT[213]['info']['speed']			= 5000;
$ELEMENT[213]['info']['speed2']			= 5000;
$ELEMENT[213]['info']['capacity']		= 2000;
$ELEMENT[213]['info']['tech']			= 3;

$ELEMENT[213]['combat']		= array();
$ELEMENT[213]['combat']['shield']	= 500;
$ELEMENT[213]['combat']['attack']	= 2000;
$ELEMENT[213]['combat']['sd']		= array();
$ELEMENT[213]['combat']['sd'][210]	= 5;
$ELEMENT[213]['combat']['sd'][212]	= 5;
$ELEMENT[213]['combat']['sd'][215]	= 2;
$ELEMENT[213]['combat']['sd'][223]	= 20;
$ELEMENT[213]['combat']['sd'][402]	= 10;



$ELEMENT[214]	= array();
$ELEMENT[214]['name']		= 'dearth_star';
$ELEMENT[214]['require']	= array();
$ELEMENT[214]['require'][21]	= 12;
$ELEMENT[214]['require'][118]	= 7;
$ELEMENT[214]['require'][114]	= 6;
$ELEMENT[214]['require'][199]	= 1;

$ELEMENT[214]['cost']		= array();
$ELEMENT[214]['cost'][901]	= 5000000;
$ELEMENT[214]['cost'][902]	= 4000000;
$ELEMENT[214]['cost'][903]	= 1000000;
$ELEMENT[214]['cost'][920]	= 0;
$ELEMENT[214]['cost'][910]	= 0;
$ELEMENT[214]['cost'][911]	= 0;

$ELEMENT[214]['info']		= array();
$ELEMENT[214]['info']['metal']			= 5000000;
$ELEMENT[214]['info']['crystal']		= 4000000;
$ELEMENT[214]['info']['deuterium']		= 1000000;
$ELEMENT[214]['info']['energy_max']		= 0;
$ELEMENT[214]['info']['darkmatter']		= 0;
$ELEMENT[214]['info']['factor']			= 1;
$ELEMENT[214]['info']['consumption']	= 1;
$ELEMENT[214]['info']['consumption2']	= 1;
$ELEMENT[214]['info']['speed']			= 200;
$ELEMENT[214]['info']['speed2']			= 200;
$ELEMENT[214]['info']['capacity']		= 1000000;
$ELEMENT[214]['info']['tech']			= 3;

$ELEMENT[214]['combat']		= array();
$ELEMENT[214]['combat']['shield']	= 50000;
$ELEMENT[214]['combat']['attack']	= 200000;
$ELEMENT[214]['combat']['sd']		= array();
$ELEMENT[214]['combat']['sd'][210]	= 1250;
$ELEMENT[214]['combat']['sd'][212]	= 1250;
$ELEMENT[214]['combat']['sd'][202]	= 250;
$ELEMENT[214]['combat']['sd'][203]	= 250;
$ELEMENT[214]['combat']['sd'][208]	= 250;
$ELEMENT[214]['combat']['sd'][209]	= 250;
$ELEMENT[214]['combat']['sd'][204]	= 200;
$ELEMENT[214]['combat']['sd'][205]	= 100;
$ELEMENT[214]['combat']['sd'][206]	= 33;
$ELEMENT[214]['combat']['sd'][207]	= 30;
$ELEMENT[214]['combat']['sd'][211]	= 25;
$ELEMENT[214]['combat']['sd'][215]	= 15;
$ELEMENT[214]['combat']['sd'][213]	= 5;
$ELEMENT[214]['combat']['sd'][223]	= 20;
$ELEMENT[214]['combat']['sd'][224]	= 20;
$ELEMENT[214]['combat']['sd'][225]	= 25;
$ELEMENT[214]['combat']['sd'][226]	= 5;
$ELEMENT[214]['combat']['sd'][227]	= 30;
$ELEMENT[214]['combat']['sd'][228]	= 25;
$ELEMENT[214]['combat']['sd'][401]	= 200;
$ELEMENT[214]['combat']['sd'][402]	= 200;
$ELEMENT[214]['combat']['sd'][403]	= 100;
$ELEMENT[214]['combat']['sd'][404]	= 50;
$ELEMENT[214]['combat']['sd'][405]	= 100;



$ELEMENT[215]	= array();
$ELEMENT[215]['name']		= 'battleship';
$ELEMENT[215]['require']	= array();
$ELEMENT[215]['require'][114]	= 5;
$ELEMENT[215]['require'][120]	= 12;
$ELEMENT[215]['require'][118]	= 5;
$ELEMENT[215]['require'][21]	= 8;

$ELEMENT[215]['cost']		= array();
$ELEMENT[215]['cost'][901]	= 30000;
$ELEMENT[215]['cost'][902]	= 40000;
$ELEMENT[215]['cost'][903]	= 15000;
$ELEMENT[215]['cost'][920]	= 0;
$ELEMENT[215]['cost'][910]	= 0;
$ELEMENT[215]['cost'][911]	= 0;

$ELEMENT[215]['info']		= array();
$ELEMENT[215]['info']['metal']			= 30000;
$ELEMENT[215]['info']['crystal']		= 40000;
$ELEMENT[215]['info']['deuterium']		= 15000;
$ELEMENT[215]['info']['energy_max']		= 0;
$ELEMENT[215]['info']['darkmatter']		= 0;
$ELEMENT[215]['info']['factor']			= 1;
$ELEMENT[215]['info']['consumption']	= 250;
$ELEMENT[215]['info']['consumption2']	= 250;
$ELEMENT[215]['info']['speed']			= 10000;
$ELEMENT[215]['info']['speed2']			= 10000;
$ELEMENT[215]['info']['capacity']		= 750;
$ELEMENT[215]['info']['tech']			= 3;

$ELEMENT[215]['combat']		= array();
$ELEMENT[215]['combat']['shield']	= 400;
$ELEMENT[215]['combat']['attack']	= 700;
$ELEMENT[215]['combat']['sd']		= array();
$ELEMENT[215]['combat']['sd'][202]	= 3;
$ELEMENT[215]['combat']['sd'][203]	= 3;
$ELEMENT[215]['combat']['sd'][205]	= 4;
$ELEMENT[215]['combat']['sd'][206]	= 4;
$ELEMENT[215]['combat']['sd'][207]	= 10;
$ELEMENT[215]['combat']['sd'][210]	= 5;
$ELEMENT[215]['combat']['sd'][212]	= 5;
$ELEMENT[215]['combat']['sd'][223]	= 15;



$ELEMENT[216]	= array();
$ELEMENT[216]['name']		= 'lune_noir';
$ELEMENT[216]['require']	= array();
$ELEMENT[216]['require'][106]	= 12;
$ELEMENT[216]['require'][21]	= 15;
$ELEMENT[216]['require'][109]	= 14;
$ELEMENT[216]['require'][110]	= 14;
$ELEMENT[216]['require'][111]	= 15;
$ELEMENT[216]['require'][114]	= 10;
$ELEMENT[216]['require'][120]	= 20;
$ELEMENT[216]['require'][199]	= 3;

$ELEMENT[216]['cost']		= array();
$ELEMENT[216]['cost'][901]	= 8000000;
$ELEMENT[216]['cost'][902]	= 2000000;
$ELEMENT[216]['cost'][903]	= 1500000;
$ELEMENT[216]['cost'][920]	= 0;
$ELEMENT[216]['cost'][910]	= 0;
$ELEMENT[216]['cost'][911]	= 0;

$ELEMENT[216]['info']		= array();
$ELEMENT[216]['info']['metal']			= 8000000;
$ELEMENT[216]['info']['crystal']		= 2000000;
$ELEMENT[216]['info']['deuterium']		= 1500000;
$ELEMENT[216]['info']['energy_max']		= 0;
$ELEMENT[216]['info']['darkmatter']		= 0;
$ELEMENT[216]['info']['factor']			= 1;
$ELEMENT[216]['info']['consumption']	= 250;
$ELEMENT[216]['info']['consumption2']	= 250;
$ELEMENT[216]['info']['speed']			= 900;
$ELEMENT[216]['info']['speed2']			= 900;
$ELEMENT[216]['info']['capacity']		= 15000000;
$ELEMENT[216]['info']['tech']			= 3;

$ELEMENT[216]['combat']		= array();
$ELEMENT[216]['combat']['shield']	= 70000;
$ELEMENT[216]['combat']['attack']	= 150000;
$ELEMENT[216]['combat']['sd']		= array();
$ELEMENT[216]['combat']['sd'][210]	= 1250;
$ELEMENT[216]['combat']['sd'][212]	= 1250;
$ELEMENT[216]['combat']['sd'][202]	= 250;
$ELEMENT[216]['combat']['sd'][203]	= 250;
$ELEMENT[216]['combat']['sd'][204]	= 200;
$ELEMENT[216]['combat']['sd'][205]	= 100;
$ELEMENT[216]['combat']['sd'][206]	= 33;
$ELEMENT[216]['combat']['sd'][207]	= 30;
$ELEMENT[216]['combat']['sd'][208]	= 250;
$ELEMENT[216]['combat']['sd'][209]	= 250;
$ELEMENT[216]['combat']['sd'][211]	= 25;
$ELEMENT[216]['combat']['sd'][213]	= 5;
$ELEMENT[216]['combat']['sd'][214]	= 1;
$ELEMENT[216]['combat']['sd'][215]	= 15;
$ELEMENT[216]['combat']['sd'][223]	= 30;
$ELEMENT[216]['combat']['sd'][224]	= 30;
$ELEMENT[216]['combat']['sd'][225]	= 35;
$ELEMENT[216]['combat']['sd'][226]	= 10;
$ELEMENT[216]['combat']['sd'][227]	= 40;
$ELEMENT[216]['combat']['sd'][228]	= 35;
$ELEMENT[216]['combat']['sd'][401]	= 400;
$ELEMENT[216]['combat']['sd'][402]	= 200;
$ELEMENT[216]['combat']['sd'][403]	= 100;
$ELEMENT[216]['combat']['sd'][404]	= 50;
$ELEMENT[216]['combat']['sd'][405]	= 100;



$ELEMENT[217]	= array();
$ELEMENT[217]['name']		= 'ev_transporter';
$ELEMENT[217]['require']	= array();
$ELEMENT[217]['require'][111]	= 10;
$ELEMENT[217]['require'][21]	= 14;
$ELEMENT[217]['require'][114]	= 10;
$ELEMENT[217]['require'][110]	= 14;
$ELEMENT[217]['require'][117]	= 15;

$ELEMENT[217]['cost']		= array();
$ELEMENT[217]['cost'][901]	= 35000;
$ELEMENT[217]['cost'][902]	= 20000;
$ELEMENT[217]['cost'][903]	= 1500;
$ELEMENT[217]['cost'][920]	= 0;
$ELEMENT[217]['cost'][910]	= 0;
$ELEMENT[217]['cost'][911]	= 0;

$ELEMENT[217]['info']		= array();
$ELEMENT[217]['info']['metal']			= 35000;
$ELEMENT[217]['info']['crystal']		= 20000;
$ELEMENT[217]['info']['deuterium']		= 1500;
$ELEMENT[217]['info']['energy_max']		= 0;
$ELEMENT[217]['info']['darkmatter']		= 0;
$ELEMENT[217]['info']['factor']			= 1;
$ELEMENT[217]['info']['consumption']	= 90;
$ELEMENT[217]['info']['consumption2']	= 90;
$ELEMENT[217]['info']['speed']			= 6000;
$ELEMENT[217]['info']['speed2']			= 6000;
$ELEMENT[217]['info']['capacity']		= 400000000;
$ELEMENT[217]['info']['tech']			= 3;

$ELEMENT[217]['combat']		= array();
$ELEMENT[217]['combat']['shield']	= 120;
$ELEMENT[217]['combat']['attack']	= 50;
$ELEMENT[217]['combat']['sd']		= array();
$ELEMENT[217]['combat']['sd'][210]	= 5;
$ELEMENT[217]['combat']['sd'][212]	= 5;



$ELEMENT[218]	= array();
$ELEMENT[218]['name']		= 'star_crasher';
$ELEMENT[218]['require']	= array();
$ELEMENT[218]['require'][21]	= 18;
$ELEMENT[218]['require'][109]	= 20;
$ELEMENT[218]['require'][110]	= 20;
$ELEMENT[218]['require'][111]	= 20;
$ELEMENT[218]['require'][114]	= 15;
$ELEMENT[218]['require'][118]	= 20;
$ELEMENT[218]['require'][120]	= 25;
$ELEMENT[218]['require'][199]	= 8;

$ELEMENT[218]['cost']		= array();
$ELEMENT[218]['cost'][901]	= 275000000;
$ELEMENT[218]['cost'][902]	= 130000000;
$ELEMENT[218]['cost'][903]	= 60000000;
$ELEMENT[218]['cost'][920]	= 0;
$ELEMENT[218]['cost'][910]	= 0;
$ELEMENT[218]['cost'][911]	= 0;

$ELEMENT[218]['info']		= array();
$ELEMENT[218]['info']['metal']			= 275000000;
$ELEMENT[218]['info']['crystal']		= 130000000;
$ELEMENT[218]['info']['deuterium']		= 60000000;
$ELEMENT[218]['info']['energy_max']		= 0;
$ELEMENT[218]['info']['darkmatter']		= 0;
$ELEMENT[218]['info']['factor']			= 1;
$ELEMENT[218]['info']['consumption']	= 10000;
$ELEMENT[218]['info']['consumption2']	= 10000;
$ELEMENT[218]['info']['speed']			= 10;
$ELEMENT[218]['info']['speed2']			= 10;
$ELEMENT[218]['info']['capacity']		= 50000000;
$ELEMENT[218]['info']['tech']			= 3;

$ELEMENT[218]['combat']		= array();
$ELEMENT[218]['combat']['shield']	= 2000000;
$ELEMENT[218]['combat']['attack']	= 35000000;
$ELEMENT[218]['combat']['sd']		= array();
$ELEMENT[218]['combat']['sd'][210]	= 1250;
$ELEMENT[218]['combat']['sd'][212]	= 1250;
$ELEMENT[218]['combat']['sd'][202]	= 250;
$ELEMENT[218]['combat']['sd'][203]	= 250;
$ELEMENT[218]['combat']['sd'][204]	= 200;
$ELEMENT[218]['combat']['sd'][205]	= 100;
$ELEMENT[218]['combat']['sd'][206]	= 33;
$ELEMENT[218]['combat']['sd'][207]	= 30;
$ELEMENT[218]['combat']['sd'][208]	= 250;
$ELEMENT[218]['combat']['sd'][209]	= 250;
$ELEMENT[218]['combat']['sd'][211]	= 25;
$ELEMENT[218]['combat']['sd'][213]	= 5;
$ELEMENT[218]['combat']['sd'][223]	= 50;
$ELEMENT[218]['combat']['sd'][224]	= 50;
$ELEMENT[218]['combat']['sd'][225]	= 55;
$ELEMENT[218]['combat']['sd'][226]	= 30;
$ELEMENT[218]['combat']['sd'][227]	= 60;
$ELEMENT[218]['combat']['sd'][228]	= 55;
$ELEMENT[218]['combat']['sd'][215]	= 15;
$ELEMENT[218]['combat']['sd'][401]	= 400;
$ELEMENT[218]['combat']['sd'][402]	= 200;
$ELEMENT[218]['combat']['sd'][403]	= 100;
$ELEMENT[218]['combat']['sd'][404]	= 50;
$ELEMENT[218]['combat']['sd'][405]	= 100;



$ELEMENT[219]	= array();
$ELEMENT[219]['name']		= 'giga_recykler';
$ELEMENT[219]['require']	= array();
$ELEMENT[219]['require'][21]	= 15;
$ELEMENT[219]['require'][109]	= 15;
$ELEMENT[219]['require'][110]	= 15;
$ELEMENT[219]['require'][111]	= 15;
$ELEMENT[219]['require'][118]	= 8;

$ELEMENT[219]['cost']		= array();
$ELEMENT[219]['cost'][901]	= 1000000;
$ELEMENT[219]['cost'][902]	= 600000;
$ELEMENT[219]['cost'][903]	= 200000;
$ELEMENT[219]['cost'][920]	= 0;
$ELEMENT[219]['cost'][910]	= 0;
$ELEMENT[219]['cost'][911]	= 0;

$ELEMENT[219]['info']		= array();
$ELEMENT[219]['info']['metal']			= 1000000;
$ELEMENT[219]['info']['crystal']		= 600000;
$ELEMENT[219]['info']['deuterium']		= 200000;
$ELEMENT[219]['info']['energy_max']		= 0;
$ELEMENT[219]['info']['darkmatter']		= 0;
$ELEMENT[219]['info']['factor']			= 1;
$ELEMENT[219]['info']['consumption']	= 300;
$ELEMENT[219]['info']['consumption2']	= 300;
$ELEMENT[219]['info']['speed']			= 7500;
$ELEMENT[219]['info']['speed2']			= 7500;
$ELEMENT[219]['info']['capacity']		= 200000000;
$ELEMENT[219]['info']['tech']			= 3;

$ELEMENT[219]['combat']		= array();
$ELEMENT[219]['combat']['shield']	= 1000;
$ELEMENT[219]['combat']['attack']	= 1;
$ELEMENT[219]['combat']['sd']		= array();
$ELEMENT[219]['combat']['sd'][210]	= 5;
$ELEMENT[219]['combat']['sd'][212]	= 5;



$ELEMENT[220]	= array();
$ELEMENT[220]['name']		= 'dm_ship';
$ELEMENT[220]['require']	= array();
$ELEMENT[220]['require'][21]	= 9;
$ELEMENT[220]['require'][114]	= 5;
$ELEMENT[220]['require'][118]	= 6;

$ELEMENT[220]['cost']		= array();
$ELEMENT[220]['cost'][901]	= 6000000;
$ELEMENT[220]['cost'][902]	= 7000000;
$ELEMENT[220]['cost'][903]	= 3000000;
$ELEMENT[220]['cost'][920]	= 0;
$ELEMENT[220]['cost'][910]	= 0;
$ELEMENT[220]['cost'][911]	= 0;

$ELEMENT[220]['info']		= array();
$ELEMENT[220]['info']['metal']			= 6000000;
$ELEMENT[220]['info']['crystal']		= 7000000;
$ELEMENT[220]['info']['deuterium']		= 3000000;
$ELEMENT[220]['info']['energy_max']		= 0;
$ELEMENT[220]['info']['darkmatter']		= 0;
$ELEMENT[220]['info']['factor']			= 1;
$ELEMENT[220]['info']['consumption']	= 100000;
$ELEMENT[220]['info']['consumption2']	= 100000;
$ELEMENT[220]['info']['speed']			= 100;
$ELEMENT[220]['info']['speed2']			= 100;
$ELEMENT[220]['info']['capacity']		= 6000000;
$ELEMENT[220]['info']['tech']			= 3;

$ELEMENT[220]['combat']		= array();
$ELEMENT[220]['combat']['shield']	= 50000;
$ELEMENT[220]['combat']['attack']	= 5;
$ELEMENT[220]['combat']['sd']		= array();
$ELEMENT[220]['combat']['sd'][210]	= 5;
$ELEMENT[220]['combat']['sd'][212]	= 5;



$ELEMENT[401]	= array();
$ELEMENT[401]['name']		= 'misil_launcher';
$ELEMENT[401]['require']	= array();
$ELEMENT[401]['require'][21]	= 1;

$ELEMENT[401]['cost']		= array();
$ELEMENT[401]['cost'][901]	= 2000;
$ELEMENT[401]['cost'][902]	= 0;
$ELEMENT[401]['cost'][903]	= 0;
$ELEMENT[401]['cost'][920]	= 0;
$ELEMENT[401]['cost'][910]	= 0;
$ELEMENT[401]['cost'][911]	= 0;

$ELEMENT[401]['info']		= array();
$ELEMENT[401]['info']['metal']		= 2000;
$ELEMENT[401]['info']['crystal']	= 0;
$ELEMENT[401]['info']['deuterium']	= 0;
$ELEMENT[401]['info']['energy_max']	= 0;
$ELEMENT[401]['info']['darkmatter']	= 0;
$ELEMENT[401]['info']['factor']		= 1;

$ELEMENT[401]['combat']		= array();
$ELEMENT[401]['combat']['shield']	= 20;
$ELEMENT[401]['combat']['attack']	= 80;
$ELEMENT[401]['combat']['sd']		= array();



$ELEMENT[402]	= array();
$ELEMENT[402]['name']		= 'small_laser';
$ELEMENT[402]['require']	= array();
$ELEMENT[402]['require'][113]	= 1;
$ELEMENT[402]['require'][21]	= 2;
$ELEMENT[402]['require'][120]	= 3;

$ELEMENT[402]['cost']		= array();
$ELEMENT[402]['cost'][901]	= 1500;
$ELEMENT[402]['cost'][902]	= 500;
$ELEMENT[402]['cost'][903]	= 0;
$ELEMENT[402]['cost'][920]	= 0;
$ELEMENT[402]['cost'][910]	= 0;
$ELEMENT[402]['cost'][911]	= 0;

$ELEMENT[402]['info']		= array();
$ELEMENT[402]['info']['metal']		= 1500;
$ELEMENT[402]['info']['crystal']	= 500;
$ELEMENT[402]['info']['deuterium']	= 0;
$ELEMENT[402]['info']['energy_max']	= 0;
$ELEMENT[402]['info']['darkmatter']	= 0;
$ELEMENT[402]['info']['factor']		= 1;

$ELEMENT[402]['combat']		= array();
$ELEMENT[402]['combat']['shield']	= 25;
$ELEMENT[402]['combat']['attack']	= 100;
$ELEMENT[402]['combat']['sd']		= array();



$ELEMENT[403]	= array();
$ELEMENT[403]['name']		= 'big_laser';
$ELEMENT[403]['require']	= array();
$ELEMENT[403]['require'][113]	= 3;
$ELEMENT[403]['require'][21]	= 4;
$ELEMENT[403]['require'][120]	= 6;

$ELEMENT[403]['cost']		= array();
$ELEMENT[403]['cost'][901]	= 6000;
$ELEMENT[403]['cost'][902]	= 2000;
$ELEMENT[403]['cost'][903]	= 0;
$ELEMENT[403]['cost'][920]	= 0;
$ELEMENT[403]['cost'][910]	= 0;
$ELEMENT[403]['cost'][911]	= 0;

$ELEMENT[403]['info']		= array();
$ELEMENT[403]['info']['metal']		= 6000;
$ELEMENT[403]['info']['crystal']	= 2000;
$ELEMENT[403]['info']['deuterium']	= 0;
$ELEMENT[403]['info']['energy_max']	= 0;
$ELEMENT[403]['info']['darkmatter']	= 0;
$ELEMENT[403]['info']['factor']		= 1;

$ELEMENT[403]['combat']		= array();
$ELEMENT[403]['combat']['shield']	= 100;
$ELEMENT[403]['combat']['attack']	= 250;
$ELEMENT[403]['combat']['sd']		= array();



$ELEMENT[404]	= array();
$ELEMENT[404]['name']		= 'gauss_canyon';
$ELEMENT[404]['require']	= array();
$ELEMENT[404]['require'][21]	= 6;
$ELEMENT[404]['require'][113]	= 6;
$ELEMENT[404]['require'][109]	= 3;
$ELEMENT[404]['require'][110]	= 1;

$ELEMENT[404]['cost']		= array();
$ELEMENT[404]['cost'][901]	= 20000;
$ELEMENT[404]['cost'][902]	= 15000;
$ELEMENT[404]['cost'][903]	= 2000;
$ELEMENT[404]['cost'][920]	= 0;
$ELEMENT[404]['cost'][910]	= 0;
$ELEMENT[404]['cost'][911]	= 0;

$ELEMENT[404]['info']		= array();
$ELEMENT[404]['info']['metal']		= 20000;
$ELEMENT[404]['info']['crystal']	= 15000;
$ELEMENT[404]['info']['deuterium']	= 2000;
$ELEMENT[404]['info']['energy_max']	= 0;
$ELEMENT[404]['info']['darkmatter']	= 0;
$ELEMENT[404]['info']['factor']		= 1;

$ELEMENT[404]['combat']		= array();
$ELEMENT[404]['combat']['shield']	= 200;
$ELEMENT[404]['combat']['attack']	= 1100;
$ELEMENT[404]['combat']['sd']		= array();



$ELEMENT[405]	= array();
$ELEMENT[405]['name']		= 'ionic_canyon';
$ELEMENT[405]['require']	= array();
$ELEMENT[405]['require'][21]	= 4;
$ELEMENT[405]['require'][121]	= 4;

$ELEMENT[405]['cost']		= array();
$ELEMENT[405]['cost'][901]	= 2000;
$ELEMENT[405]['cost'][902]	= 6000;
$ELEMENT[405]['cost'][903]	= 0;
$ELEMENT[405]['cost'][920]	= 0;
$ELEMENT[405]['cost'][910]	= 0;
$ELEMENT[405]['cost'][911]	= 0;

$ELEMENT[405]['info']		= array();
$ELEMENT[405]['info']['metal']		= 2000;
$ELEMENT[405]['info']['crystal']	= 6000;
$ELEMENT[405]['info']['deuterium']	= 0;
$ELEMENT[405]['info']['energy_max']	= 0;
$ELEMENT[405]['info']['darkmatter']	= 0;
$ELEMENT[405]['info']['factor']		= 1;

$ELEMENT[405]['combat']		= array();
$ELEMENT[405]['combat']['shield']	= 500;
$ELEMENT[405]['combat']['attack']	= 150;
$ELEMENT[405]['combat']['sd']		= array();



$ELEMENT[406]	= array();
$ELEMENT[406]['name']		= 'buster_canyon';
$ELEMENT[406]['require']	= array();
$ELEMENT[406]['require'][21]	= 8;
$ELEMENT[406]['require'][122]	= 7;

$ELEMENT[406]['cost']		= array();
$ELEMENT[406]['cost'][901]	= 50000;
$ELEMENT[406]['cost'][902]	= 50000;
$ELEMENT[406]['cost'][903]	= 30000;
$ELEMENT[406]['cost'][920]	= 0;
$ELEMENT[406]['cost'][910]	= 0;
$ELEMENT[406]['cost'][911]	= 0;

$ELEMENT[406]['info']		= array();
$ELEMENT[406]['info']['metal']		= 50000;
$ELEMENT[406]['info']['crystal']	= 50000;
$ELEMENT[406]['info']['deuterium']	= 30000;
$ELEMENT[406]['info']['energy_max']	= 0;
$ELEMENT[406]['info']['darkmatter']	= 0;
$ELEMENT[406]['info']['factor']		= 1;

$ELEMENT[406]['combat']		= array();
$ELEMENT[406]['combat']['shield']	= 300;
$ELEMENT[406]['combat']['attack']	= 3000;
$ELEMENT[406]['combat']['sd']		= array();



$ELEMENT[407]	= array();
$ELEMENT[407]['name']		= 'small_protection_shield';
$ELEMENT[407]['require']	= array();
$ELEMENT[407]['require'][110]	= 2;
$ELEMENT[407]['require'][21]	= 1;

$ELEMENT[407]['cost']		= array();
$ELEMENT[407]['cost'][901]	= 10000;
$ELEMENT[407]['cost'][902]	= 10000;
$ELEMENT[407]['cost'][903]	= 0;
$ELEMENT[407]['cost'][920]	= 0;
$ELEMENT[407]['cost'][910]	= 0;
$ELEMENT[407]['cost'][911]	= 0;

$ELEMENT[407]['info']		= array();
$ELEMENT[407]['info']['metal']		= 10000;
$ELEMENT[407]['info']['crystal']	= 10000;
$ELEMENT[407]['info']['deuterium']	= 0;
$ELEMENT[407]['info']['energy_max']	= 0;
$ELEMENT[407]['info']['darkmatter']	= 0;
$ELEMENT[407]['info']['factor']		= 1;

$ELEMENT[407]['combat']		= array();
$ELEMENT[407]['combat']['shield']	= 2000;
$ELEMENT[407]['combat']['attack']	= 1;
$ELEMENT[407]['combat']['sd']		= array();



$ELEMENT[408]	= array();
$ELEMENT[408]['name']		= 'big_protection_shield';
$ELEMENT[408]['require']	= array();
$ELEMENT[408]['require'][110]	= 6;
$ELEMENT[408]['require'][21]	= 6;

$ELEMENT[408]['cost']		= array();
$ELEMENT[408]['cost'][901]	= 50000;
$ELEMENT[408]['cost'][902]	= 50000;
$ELEMENT[408]['cost'][903]	= 0;
$ELEMENT[408]['cost'][920]	= 0;
$ELEMENT[408]['cost'][910]	= 0;
$ELEMENT[408]['cost'][911]	= 0;

$ELEMENT[408]['info']		= array();
$ELEMENT[408]['info']['metal']		= 50000;
$ELEMENT[408]['info']['crystal']	= 50000;
$ELEMENT[408]['info']['deuterium']	= 0;
$ELEMENT[408]['info']['energy_max']	= 0;
$ELEMENT[408]['info']['darkmatter']	= 0;
$ELEMENT[408]['info']['factor']		= 1;

$ELEMENT[408]['combat']		= array();
$ELEMENT[408]['combat']['shield']	= 10000;
$ELEMENT[408]['combat']['attack']	= 1;
$ELEMENT[408]['combat']['sd']		= array();



$ELEMENT[409]	= array();
$ELEMENT[409]['name']		= 'planet_protector';
$ELEMENT[409]['require']	= array();
$ELEMENT[409]['require'][609]	= 1;

$ELEMENT[409]['cost']		= array();
$ELEMENT[409]['cost'][901]	= 10000000;
$ELEMENT[409]['cost'][902]	= 5000000;
$ELEMENT[409]['cost'][903]	= 2500000;
$ELEMENT[409]['cost'][920]	= 0;
$ELEMENT[409]['cost'][910]	= 0;
$ELEMENT[409]['cost'][911]	= 0;

$ELEMENT[409]['info']		= array();
$ELEMENT[409]['info']['metal']		= 10000000;
$ELEMENT[409]['info']['crystal']	= 5000000;
$ELEMENT[409]['info']['deuterium']	= 2500000;
$ELEMENT[409]['info']['energy_max']	= 0;
$ELEMENT[409]['info']['darkmatter']	= 0;
$ELEMENT[409]['info']['factor']		= 1;

$ELEMENT[409]['combat']		= array();
$ELEMENT[409]['combat']['shield']	= 1000000;
$ELEMENT[409]['combat']['attack']	= 1;
$ELEMENT[409]['combat']['sd']		= array();



$ELEMENT[410]	= array();
$ELEMENT[410]['name']		= 'graviton_canyon';
$ELEMENT[410]['require']	= array();
$ELEMENT[410]['require'][199]	= 7;
$ELEMENT[410]['require'][21]	= 18;
$ELEMENT[410]['require'][109]	= 20;

$ELEMENT[410]['cost']		= array();
$ELEMENT[410]['cost'][901]	= 15000000;
$ELEMENT[410]['cost'][902]	= 15000000;
$ELEMENT[410]['cost'][903]	= 0;
$ELEMENT[410]['cost'][920]	= 0;
$ELEMENT[410]['cost'][910]	= 0;
$ELEMENT[410]['cost'][911]	= 0;

$ELEMENT[410]['info']		= array();
$ELEMENT[410]['info']['metal']		= 15000000;
$ELEMENT[410]['info']['crystal']	= 15000000;
$ELEMENT[410]['info']['deuterium']	= 0;
$ELEMENT[410]['info']['energy_max']	= 0;
$ELEMENT[410]['info']['darkmatter']	= 0;
$ELEMENT[410]['info']['factor']		= 1;

$ELEMENT[410]['combat']		= array();
$ELEMENT[410]['combat']['shield']	= 80000;
$ELEMENT[410]['combat']['attack']	= 500000;
$ELEMENT[410]['combat']['sd']		= array();



$ELEMENT[411]	= array();
$ELEMENT[411]['name']		= 'orbital_station';
$ELEMENT[411]['require']	= array();
$ELEMENT[411]['require'][199]	= 10;
$ELEMENT[411]['require'][110]	= 22;
$ELEMENT[411]['require'][122]	= 20;
$ELEMENT[411]['require'][108]	= 15;
$ELEMENT[411]['require'][111]	= 25;
$ELEMENT[411]['require'][113]	= 20;
$ELEMENT[411]['require'][608]	= 2;
$ELEMENT[411]['require'][21]	= 20;

$ELEMENT[411]['cost']		= array();
$ELEMENT[411]['cost'][901]	= 705032704;
$ELEMENT[411]['cost'][902]	= 2000000000;
$ELEMENT[411]['cost'][903]	= 500000000;
$ELEMENT[411]['cost'][920]	= 10000;
$ELEMENT[411]['cost'][910]	= 0;
$ELEMENT[411]['cost'][911]	= 1000000;

$ELEMENT[411]['info']		= array();
$ELEMENT[411]['info']['metal']		= 5000000000;
$ELEMENT[411]['info']['crystal']	= 2000000000;
$ELEMENT[411]['info']['deuterium']	= 500000000;
$ELEMENT[411]['info']['energy_max']	= 1000000;
$ELEMENT[411]['info']['darkmatter']	= 10000;
$ELEMENT[411]['info']['factor']		= 1;

$ELEMENT[411]['combat']		= array();
$ELEMENT[411]['combat']['shield']	= 2000000000;
$ELEMENT[411]['combat']['attack']	= 400000000;
$ELEMENT[411]['combat']['sd']		= array();



$ELEMENT[502]	= array();
$ELEMENT[502]['name']		= 'interceptor_misil';
$ELEMENT[502]['require']	= array();
$ELEMENT[502]['require'][44]	= 2;
$ELEMENT[502]['require'][21]	= 1;

$ELEMENT[502]['cost']		= array();
$ELEMENT[502]['cost'][901]	= 8000;
$ELEMENT[502]['cost'][902]	= 0;
$ELEMENT[502]['cost'][903]	= 2000;
$ELEMENT[502]['cost'][920]	= 0;
$ELEMENT[502]['cost'][910]	= 0;
$ELEMENT[502]['cost'][911]	= 0;

$ELEMENT[502]['info']		= array();
$ELEMENT[502]['info']['metal']		= 8000;
$ELEMENT[502]['info']['crystal']	= 0;
$ELEMENT[502]['info']['deuterium']	= 2000;
$ELEMENT[502]['info']['energy_max']	= 0;
$ELEMENT[502]['info']['darkmatter']	= 0;
$ELEMENT[502]['info']['factor']		= 1;

$ELEMENT[502]['combat']		= array();
$ELEMENT[502]['combat']['shield']	= 1;
$ELEMENT[502]['combat']['attack']	= 1;
$ELEMENT[502]['combat']['sd']		= array();



$ELEMENT[503]	= array();
$ELEMENT[503]['name']		= 'interplanetary_misil';
$ELEMENT[503]['require']	= array();
$ELEMENT[503]['require'][44]	= 4;
$ELEMENT[503]['require'][21]	= 1;
$ELEMENT[503]['require'][117]	= 1;

$ELEMENT[503]['cost']		= array();
$ELEMENT[503]['cost'][901]	= 12500;
$ELEMENT[503]['cost'][902]	= 2500;
$ELEMENT[503]['cost'][903]	= 10000;
$ELEMENT[503]['cost'][920]	= 0;
$ELEMENT[503]['cost'][910]	= 0;
$ELEMENT[503]['cost'][911]	= 0;

$ELEMENT[503]['info']		= array();
$ELEMENT[503]['info']['metal']		= 12500;
$ELEMENT[503]['info']['crystal']	= 2500;
$ELEMENT[503]['info']['deuterium']	= 10000;
$ELEMENT[503]['info']['energy_max']	= 0;
$ELEMENT[503]['info']['darkmatter']	= 0;
$ELEMENT[503]['info']['factor']		= 1;

$ELEMENT[503]['combat']		= array();
$ELEMENT[503]['combat']['shield']	= 1;
$ELEMENT[503]['combat']['attack']	= 12000;
$ELEMENT[503]['combat']['sd']		= array();



$ELEMENT[601]	= array();
$ELEMENT[601]['name']		= 'rpg_geologue';
$ELEMENT[601]['max']		= 20;
$ELEMENT[601]['require']	= array();

$ELEMENT[601]['cost']		= array();
$ELEMENT[601]['cost'][920]	= 1000;

$ELEMENT[601]['bonus']		= 0.05;

$ELEMENT[602]	= array();
$ELEMENT[602]['name']		= 'rpg_amiral';
$ELEMENT[602]['max']		= 20;
$ELEMENT[602]['require']	= array();

$ELEMENT[602]['cost']		= array();
$ELEMENT[602]['cost'][920]	= 1000;

$ELEMENT[602]['bonus']		= 0.05;

$ELEMENT[603]	= array();
$ELEMENT[603]['name']		= 'rpg_ingenieur';
$ELEMENT[603]['max']		= 10;
$ELEMENT[603]['require']	= array();
$ELEMENT[603]['require'][601]	= 5;

$ELEMENT[603]['cost']		= array();
$ELEMENT[603]['cost'][920]	= 1000;

$ELEMENT[603]['bonus']		= 0.05;

$ELEMENT[604]	= array();
$ELEMENT[604]['name']		= 'rpg_technocrate';
$ELEMENT[604]['max']		= 10;
$ELEMENT[604]['require']	= array();
$ELEMENT[604]['require'][602]	= 5;

$ELEMENT[604]['cost']		= array();
$ELEMENT[604]['cost'][920]	= 1000;

$ELEMENT[604]['bonus']		= 0.05;

$ELEMENT[605]	= array();
$ELEMENT[605]['name']		= 'rpg_constructeur';
$ELEMENT[605]['max']		= 3;
$ELEMENT[605]['require']	= array();
$ELEMENT[605]['require'][601]	= 10;
$ELEMENT[605]['require'][603]	= 2;

$ELEMENT[605]['cost']		= array();
$ELEMENT[605]['cost'][920]	= 1000;

$ELEMENT[605]['bonus']		= 0.1;

$ELEMENT[606]	= array();
$ELEMENT[606]['name']		= 'rpg_scientifique';
$ELEMENT[606]['max']		= 3;
$ELEMENT[606]['require']	= array();
$ELEMENT[606]['require'][601]	= 10;
$ELEMENT[606]['require'][603]	= 2;

$ELEMENT[606]['cost']		= array();
$ELEMENT[606]['cost'][920]	= 1000;

$ELEMENT[606]['bonus']		= 0.1;

$ELEMENT[607]	= array();
$ELEMENT[607]['name']		= 'rpg_stockeur';
$ELEMENT[607]['max']		= 2;
$ELEMENT[607]['require']	= array();
$ELEMENT[607]['require'][605]	= 1;

$ELEMENT[607]['cost']		= array();
$ELEMENT[607]['cost'][920]	= 1000;

$ELEMENT[607]['bonus']		= 0.5;

$ELEMENT[608]	= array();
$ELEMENT[608]['name']		= 'rpg_defenseur';
$ELEMENT[608]['max']		= 2;
$ELEMENT[608]['require']	= array();
$ELEMENT[608]['require'][606]	= 1;

$ELEMENT[608]['cost']		= array();
$ELEMENT[608]['cost'][920]	= 1000;

$ELEMENT[608]['bonus']		= 0.25;

$ELEMENT[609]	= array();
$ELEMENT[609]['name']		= 'rpg_bunker';
$ELEMENT[609]['max']		= 1;
$ELEMENT[609]['require']	= array();
$ELEMENT[609]['require'][601]	= 20;
$ELEMENT[609]['require'][603]	= 10;
$ELEMENT[609]['require'][605]	= 3;
$ELEMENT[609]['require'][606]	= 3;
$ELEMENT[609]['require'][607]	= 2;
$ELEMENT[609]['require'][608]	= 2;

$ELEMENT[609]['cost']		= array();
$ELEMENT[609]['cost'][920]	= 1000;

$ELEMENT[609]['bonus']		= '';

$ELEMENT[610]	= array();
$ELEMENT[610]['name']		= 'rpg_espion';
$ELEMENT[610]['max']		= 2;
$ELEMENT[610]['require']	= array();
$ELEMENT[610]['require'][602]	= 10;
$ELEMENT[610]['require'][604]	= 5;

$ELEMENT[610]['cost']		= array();
$ELEMENT[610]['cost'][920]	= 1000;

$ELEMENT[610]['bonus']		= 5;

$ELEMENT[611]	= array();
$ELEMENT[611]['name']		= 'rpg_commandant';
$ELEMENT[611]['max']		= 3;
$ELEMENT[611]['require']	= array();
$ELEMENT[611]['require'][602]	= 10;
$ELEMENT[611]['require'][604]	= 5;

$ELEMENT[611]['cost']		= array();
$ELEMENT[611]['cost'][920]	= 1000;

$ELEMENT[611]['bonus']		= 3;

$ELEMENT[612]	= array();
$ELEMENT[612]['name']		= 'rpg_destructeur';
$ELEMENT[612]['max']		= 1;
$ELEMENT[612]['require']	= array();
$ELEMENT[612]['require'][610]	= 1;

$ELEMENT[612]['cost']		= array();
$ELEMENT[612]['cost'][920]	= 1000;

$ELEMENT[612]['bonus']		= '';

$ELEMENT[613]	= array();
$ELEMENT[613]['name']		= 'rpg_general';
$ELEMENT[613]['max']		= 3;
$ELEMENT[613]['require']	= array();
$ELEMENT[613]['require'][611]	= 1;

$ELEMENT[613]['cost']		= array();
$ELEMENT[613]['cost'][920]	= 1000;

$ELEMENT[613]['bonus']		= 0.1;

$ELEMENT[614]	= array();
$ELEMENT[614]['name']		= 'rpg_raideur';
$ELEMENT[614]['max']		= 1;
$ELEMENT[614]['require']	= array();
$ELEMENT[614]['require'][602]	= 20;
$ELEMENT[614]['require'][604]	= 10;
$ELEMENT[614]['require'][610]	= 2;
$ELEMENT[614]['require'][611]	= 2;
$ELEMENT[614]['require'][612]	= 1;
$ELEMENT[614]['require'][613]	= 3;

$ELEMENT[614]['cost']		= array();
$ELEMENT[614]['cost'][920]	= 1000;

$ELEMENT[614]['bonus']		= '';

$ELEMENT[615]	= array();
$ELEMENT[615]['name']		= 'rpg_empereur';
$ELEMENT[615]['max']		= 1;
$ELEMENT[615]['require']	= array();
$ELEMENT[615]['require'][614]	= 1;
$ELEMENT[615]['require'][609]	= 1;

$ELEMENT[615]['cost']		= array();
$ELEMENT[615]['cost'][920]	= 1000;

$ELEMENT[615]['bonus']		= '';

$ELEMENT[700]	= array();
$ELEMENT[700]['name']		= 'dm_attack';
$ELEMENT[700]['require']	= array();

$ELEMENT[700]['cost']		= array();
$ELEMENT[700]['cost'][920]	= 1000;

$ELEMENT[700]['bonus']		= array();
$ELEMENT[700]['bonus']['time']		= 24;
$ELEMENT[700]['bonus']['darkmatter']	= 1500;
$ELEMENT[700]['bonus']['add']		= 0.1;


$ELEMENT[701]	= array();
$ELEMENT[701]['name']		= 'dm_defensive';
$ELEMENT[701]['require']	= array();

$ELEMENT[701]['cost']		= array();
$ELEMENT[701]['cost'][920]	= 1000;

$ELEMENT[701]['bonus']		= array();
$ELEMENT[701]['bonus']['time']		= 24;
$ELEMENT[701]['bonus']['darkmatter']	= 1500;
$ELEMENT[701]['bonus']['add']		= 0.1;


$ELEMENT[702]	= array();
$ELEMENT[702]['name']		= 'dm_buildtime';
$ELEMENT[702]['require']	= array();

$ELEMENT[702]['cost']		= array();
$ELEMENT[702]['cost'][920]	= 1000;

$ELEMENT[702]['bonus']		= array();
$ELEMENT[702]['bonus']['time']		= 24;
$ELEMENT[702]['bonus']['darkmatter']	= 750;
$ELEMENT[702]['bonus']['add']		= 0.1;


$ELEMENT[703]	= array();
$ELEMENT[703]['name']		= 'dm_resource';
$ELEMENT[703]['require']	= array();

$ELEMENT[703]['cost']		= array();
$ELEMENT[703]['cost'][920]	= 1000;

$ELEMENT[703]['bonus']		= array();
$ELEMENT[703]['bonus']['time']		= 24;
$ELEMENT[703]['bonus']['darkmatter']	= 2500;
$ELEMENT[703]['bonus']['add']		= 0.1;


$ELEMENT[704]	= array();
$ELEMENT[704]['name']		= 'dm_energie';
$ELEMENT[704]['require']	= array();

$ELEMENT[704]['cost']		= array();
$ELEMENT[704]['cost'][920]	= 1000;

$ELEMENT[704]['bonus']		= array();
$ELEMENT[704]['bonus']['time']		= 24;
$ELEMENT[704]['bonus']['darkmatter']	= 2000;
$ELEMENT[704]['bonus']['add']		= 0.1;


$ELEMENT[705]	= array();
$ELEMENT[705]['name']		= 'dm_researchtime';
$ELEMENT[705]['require']	= array();

$ELEMENT[705]['cost']		= array();
$ELEMENT[705]['cost'][920]	= 1000;

$ELEMENT[705]['bonus']		= array();
$ELEMENT[705]['bonus']['time']		= 24;
$ELEMENT[705]['bonus']['darkmatter']	= 1250;
$ELEMENT[705]['bonus']['add']		= 0.1;


$ELEMENT[706]	= array();
$ELEMENT[706]['name']		= 'dm_fleettime';
$ELEMENT[706]['require']	= array();

$ELEMENT[706]['cost']		= array();
$ELEMENT[706]['cost'][920]	= 1000;

$ELEMENT[706]['bonus']		= array();
$ELEMENT[706]['bonus']['time']		= 24;
$ELEMENT[706]['bonus']['darkmatter']	= 3000;
$ELEMENT[706]['bonus']['add']		= 0.1;


$reslist				= array('allow' => array());
$reslist['allow'][1]    = array(1, 2, 3, 4, 6, 12, 14, 15, 21, 22, 23, 24, 31, 33, 34, 44);
$reslist['allow'][3]	= array(12, 14, 21, 22, 23, 24, 34, 41, 42, 43);
$reslist['build']		= array(1, 2, 3, 4, 6, 12, 14, 15, 21, 22, 23, 24, 31, 33, 34, 44, 41, 42, 43);
$reslist['tech']		= array(106, 108, 109, 110, 111, 113, 114, 115, 117, 118, 120, 121, 122, 123, 124, 131, 132, 133, 199);
$reslist['fleet']		= array(202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220);
$reslist['defense']		= array(401, 402, 403, 404, 405, 406, 407, 408, 409, 410, 411, 502, 503);
$reslist['officier']	= array(601, 602, 603, 604, 605, 606, 607, 608, 609, 610, 611, 612, 613, 614, 615);
$reslist['dmfunc']		= array(700, 701, 702, 703, 704, 705, 706);
$reslist['resource']	= array(901, 902, 903, 910, 920, 921);
$reslist['prod']		= array(1, 2, 3, 4, 12, 212);
$reslist['procent']		= array(100, 90, 80, 70, 60, 50, 40, 30, 20, 10, 0);

?>