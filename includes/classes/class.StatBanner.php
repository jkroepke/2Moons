<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

class StatBanner {

	public $path = "cache/UserBanner/";
	private $textcolor = "00FFFF";
	private $source = "styles/images/banner.png";
	
	// Function to center text in the created banner
	private function CenterTextBanner($z,$y,$zone) {
		$a = strlen($z);
		$b = imagefontwidth($y);
		$c = $a*$b;
		$d = $zone-$c;
		$e = $d/2;
		return $e;
	}

	private function DeleteOldPic($id)
	{
		return @(is_file($this->path.$id.".png")) ? unlink($this->path.$id.".png") : false;
	}

	private function BuildIMGforID($id) {
		global $game_config, $db, $lang;

		// Parameters

		$image  = imagecreatefrompng($this->source);
		$date   = date("d.m.y");
		
		// Querys
		$Query = $db->fetch_array($db->query("SELECT COUNT(a.id) AS count, a.username, b.build_points, b.fleet_points, b.defs_points, b.tech_points, b.total_points, b.total_rank, c.name, c.galaxy, c.system, c.planet FROM ".USERS." as a, ".STATPOINTS." as b, ".PLANETS." as c WHERE a.id = '".$id."' AND b.stat_type = '1' AND b.stat_code = '1' AND b.id_owner = '".$id."' AND c.id = a.id_planet;"));
		// Variables
		$b_univ   = $game_config['game_name'];
		$b_user   = utf8_decode($Query['username']);
		$b_planet = utf8_decode($Query['name']);
		$b_xyz    = "[".$Query['galaxy'].":".$Query['system'].":".$Query['planet']."]";
		$b_lvl    = "".$Query['total_rank']  ."/".$game_config['users_amount']."";
		$b_build  = "".utf8_decode($lang['st_buildings']) .": ".pretty_number($Query['build_points'])."";
		$b_fleet  = "".utf8_decode($lang['st_fleets']) .": ".pretty_number($Query['fleet_points'])."";
		$b_def    = "".utf8_decode($lang['st_defenses']) .": ".pretty_number($Query['defs_points'])."";
		$b_search = "".utf8_decode($lang['st_researh']) .": ".pretty_number($Query['tech_points'])."";
		$b_total  = "".utf8_decode($lang['st_points']) .": ".pretty_number($Query['total_points'])."";

		// Colors
		$red    = hexdec(substr($this->textcolor,0,2));
		$green  = hexdec(substr($this->textcolor,2,4));
		$blue   = hexdec(substr($this->textcolor,4,6));
		$select = imagecolorallocate($image,$red,$green,$blue);

		// Display
		// Univers name
		imagestring($image, 1, $this->CenterTextBanner($b_univ,1,653), 57, $b_univ, $select);
		// Today date
		imagestring($image, 1, $this->CenterTextBanner($date,1,653), 65, $date, $select);
		// Player name
		imagestring($image, 3, 15, 12, $b_user, $select);
		// Player b_planet
		imagestring($image, 3, 150, 12, $b_planet." ".$b_xyz, $select);
		// Player level
		imagestring($image, 10, $this->CenterTextBanner($b_lvl,10,795), 40, $b_lvl, $select);
		// Player stats
		imagestring($image, 2, 15,  30, $b_build,  $select);
		imagestring($image, 2, 15,  45, $b_fleet,  $select);
		imagestring($image, 2, 170, 30, $b_search, $select);
		imagestring($image, 2, 170, 45, $b_def,  $select);
		imagestring($image, 2, 15,  60, $b_total,  $select);

		// Creat and delete banner
		ImagePNG($image,$this->path.$id.".png");
		imagedestroy($image);
	}

	public function BuildIMGforAll() {
		global $game_config, $db, $lang;
		// Parameters

		
		$date   = date("d.m.y");

		// Querys
		$UserQuery 	= $db->query("SELECT a.id, a.username, b.build_points, b.fleet_points, b.defs_points, b.tech_points, b.total_points, b.total_rank, c.name, c.galaxy, c.system, c.planet FROM ".USERS." as a, ".STATPOINTS." as b, ".PLANETS." as c WHERE b.stat_type = '1' AND b.stat_type = '1' AND b.id_owner = a.id AND c.id = a.id_planet;");
		$MaxUser	= $db->num_rows($UserQuery);
		while($Query = $db->fetch_array($UserQuery)){
			$this->DeleteOldPic($Query['id']);
			$image  = imagecreatefrompng(ROOT_PATH.$this->source);
			// Variables
			$b_univ   = $game_config['game_name'];
			$b_user   = utf8_decode($Query['username']);
			$b_planet = utf8_decode($Query['name']);
			$b_xyz    = "[".$Query['galaxy'].":".$Query['system'].":".$Query['planet']."]";
			$b_lvl    = $Query['total_rank']."/".$MaxUser;
			$b_build  = utf8_decode($lang['st_buildings']) .": ".pretty_number($Query['build_points']);
			$b_fleet  = utf8_decode($lang['st_fleets']) .": ".pretty_number($Query['fleet_points']);
			$b_def    = utf8_decode($lang['st_defenses']) .": ".pretty_number($Query['defs_points']);
			$b_search = utf8_decode($lang['st_researh']) .": ".pretty_number($Query['tech_points']);
			$b_total  = utf8_decode($lang['st_points']) .": ".pretty_number($Query['total_points']);


			// Colors
			$red    = hexdec(substr($this->textcolor,0,2));
			$green  = hexdec(substr($this->textcolor,2,4));
			$blue   = hexdec(substr($this->textcolor,4,6));
			$select = imagecolorallocate($image,$red,$green,$blue);

			// Display
			// Univers name
			imagestring($image, 1, $this->CenterTextBanner($b_univ,1,653), 57, $b_univ, $select);
			// Today date
			imagestring($image, 1, $this->CenterTextBanner($date,1,653), 65, $date, $select);
			// Player name
			// ImageTTFText($image, 9, 0, 15, 12,$select, ROOT_PATH."/scripts/banner.ttf",$b_user);
			imagestring($image, 3, 15, 12, $b_user, $select);
			// Player b_planet
			imagestring($image, 3, 150, 12, "".$b_planet." ".$b_xyz."", $select);
			// Player level
			imagestring($image, 10, $this->CenterTextBanner($b_lvl,10,795), 40, $b_lvl, $select);
			// Player stats
			imagestring($image, 2, 15,  30, $b_build,  $select);
			imagestring($image, 2, 15,  45, $b_fleet,  $select);
			imagestring($image, 2, 170, 30, $b_search, $select);
			imagestring($image, 2, 170, 45, $b_def,  $select);
			imagestring($image, 2, 15,  60, $b_total,  $select);
			// Creat and delete banner
			ImagePNG($image,ROOT_PATH.$this->path.$Query['id'].".png");
			imagedestroy($image);
		}
	}

	public function ShowStatBanner($id) 
	{

		if(!file_exists($this->path.$id.".png")){
			$this->BuildIMGforID($id);
		}

		$bild = ImageCreateFromPNG($this->path.$id.".png");
		imagepng($bild);
		imagedestroy($bild);
	}

}
?>