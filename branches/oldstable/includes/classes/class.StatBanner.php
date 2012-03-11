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

class StatBanner {

	private $textcolor = "FFFFFF";
	private $source = "styles/images/banner.jpg";
	
	// Function to center text in the created banner
	private function CenterTextBanner($z,$y,$zone) {
		$a = strlen($z);
		$b = imagefontwidth($y);
		$c = $a*$b;
		$d = $zone-$c;
		$e = $d/2;
		return $e;
	}

	public function GetData($id)
	{
		global $db;
		return $db->uniquequery("SELECT a.username, b.build_points, b.fleet_points, b.defs_points, b.tech_points, b.total_points, b.total_rank, c.name, c.galaxy, c.system, c.planet, d.game_name, d.users_amount, d.ttf_file FROM ".USERS." as a, ".STATPOINTS." as b, ".PLANETS." as c ,".CONFIG." as d WHERE a.id = '".$id."' AND b.stat_type = '1' AND b.id_owner = '".$id."' AND c.id = a.id_planet AND d.uni = a.universe;");
	}
	
	public function CreateUTF8Banner($Query) {
		global $LNG, $LANG;
		$image  	= imagecreatefromjpeg($this->source);
		$date  		= date($LNG['php_dateformat'], TIMESTAMP);

		$Font		= $Query['ttf_file'];
		if(!file_exists($Font))
			$this->BannerError('TTF Font missing!');
			
		// Variables
		$b_univ   = $Query['game_name'];
		$b_user   = $Query['username'];
		$b_planet = $Query['name'];
		$b_xyz    = "[".$Query['galaxy'].":".$Query['system'].":".$Query['planet']."]";
		$b_lvl    = $Query['total_rank']  ."/".$Query['users_amount'];
		$b_build  = $LNG['ub_buildings'] .": ".shortly_number($Query['build_points']);
		$b_fleet  = $LNG['ub_fleets'] .": ".shortly_number($Query['fleet_points']);
		$b_def    = $LNG['ub_defenses'] .": ".shortly_number($Query['defs_points']);
		$b_search = $LNG['ub_researh'] .": ".shortly_number($Query['tech_points']);
		$b_total  = $LNG['ub_points'] .": ".shortly_number($Query['total_points']);


		// Colors
		$red    = hexdec(substr($this->textcolor,0,2));
		$green  = hexdec(substr($this->textcolor,2,2));
		$blue   = hexdec(substr($this->textcolor,4,2));
		$select = imagecolorallocate($image,$red,$green,$blue);

		// Display
        // Univers name
        imagettftext($image, 7, 0, $this->CenterTextBanner($b_univ, 1, 630), 65, $select, $Font, $b_univ);
        // Today date
        imagettftext($image, 7, 0, $this->CenterTextBanner($date, 1, 630), 75, $select, $Font, $date);
        // Player name
        imagettftext($image, 10, 0, 15, 18, $select, $Font, $b_user);
        // Player b_planet
        imagettftext($image, 10, 0, 150, 18, $select, $Font, $b_planet." ".$b_xyz);
        // Player level
        imagettftext($image, 14, 0, $this->CenterTextBanner($b_lvl,10,795), 46, $select, $Font, $b_lvl);
        // Player stats
        imagettftext($image, 10, 0, 15,  36, $select, $Font, $b_build);
        imagettftext($image, 10, 0, 15,  51, $select, $Font, $b_fleet);
        imagettftext($image, 10, 0, 230, 36, $select, $Font, $b_search);
        imagettftext($image, 10, 0, 230, 51, $select, $Font, $b_def);
        imagettftext($image, 10, 0, 15,  66, $select, $Font, $b_total);
				
		if(!isset($_GET['debug']))
			header("Content-type: image/jpg");
			
		ImageJPEG($image);
		imagedestroy($image);
	}
	
	function BannerError($Message) {
		header("Content-type: image/jpg");
		$im	 = ImageCreate(450, 80);
		$background_color = ImageColorAllocate ($im, 255, 255, 255);
		$text_color = ImageColorAllocate($im, 233, 14, 91);
		ImageString ($im, 3, 5, 5, $Message, $text_color);
		ImageJPEG($im);
		imagedestroy($im);
		exit;
	}
}
?>