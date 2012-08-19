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

	private $source = "styles/images/banner.jpg";
	
	// Function to center text in the created banner
	private function CenterTextBanner($X, $String, $Font, $Size) {
		
		$boxSize	= imagettfbbox($Size, 0, $Font, $String);
		
		$minX 		= min(array($boxSize[0], $boxSize[2], $boxSize[4], $boxSize[6])); 
		$maxX 		= max(array($boxSize[0], $boxSize[2], $boxSize[4], $boxSize[6])); 
		
		$boxWidth	= $maxX - $minX;
		return $X - ($boxWidth * 0.7);
	}

	public function GetData($id)
	{
		return $GLOBALS['DATABASE']->uniquequery("SELECT a.username, a.wons, a.loos, a.draws, b.total_points, b.total_rank, c.name, c.galaxy, c.system, c.planet, d.game_name, d.users_amount, d.ttf_file FROM ".USERS." as a, ".STATPOINTS." as b, ".PLANETS." as c ,".CONFIG." as d WHERE a.id = '".$id."' AND b.stat_type = '1' AND b.id_owner = '".$id."' AND c.id = a.id_planet AND d.uni = a.universe;");
	}
	
	public function CreateUTF8Banner($data) {
		global $LNG, $LANG;
		$image  	= imagecreatefromjpeg($this->source);
		$date  		= _date($LNG['php_dateformat'], TIMESTAMP);

		$Font		= $data['ttf_file'];
		if(!file_exists($Font))
			$this->BannerError('TTF Font missing!');
			
		// Colors		
		$color	= imagecolorallocate($image, 255, 255, 225);
		$shadow = imagecolorallocate($image, 33, 33, 33);
		
		$total	= $data['wons'] + $data['loos'] + $data['draws'];
		
		$quote	= $total != 0 ? $data['wons'] / $total * 100 : 0;
		
		// Username
		imagettftext($image, 20, 0, 20, 31, $shadow, $Font, $data['username']);
		imagettftext($image, 20, 0, 20, 30, $color, $Font, $data['username']);
		
		imagettftext($image, 16, 0, 250, 31, $shadow, $Font, $data['game_name']);
		imagettftext($image, 16, 0, 250, 30, $color, $Font, $data['game_name']);
		
		imagettftext($image, 11, 0, 20, 60, $shadow, $Font, $LNG['ub_rank'].': '.$data['total_rank']);
		imagettftext($image, 11, 0, 20, 59, $color, $Font, $LNG['ub_rank'].': '.$data['total_rank']);
		
		imagettftext($image, 11, 0, 20, 81, $shadow, $Font, $LNG['ub_points'].': '.html_entity_decode(shortly_number($data['total_points'])));
		imagettftext($image, 11, 0, 20, 80, $color, $Font, $LNG['ub_points'].': '.html_entity_decode(shortly_number($data['total_points'])));
		
		imagettftext($image, 11, 0, 250, 60, $shadow, $Font, $LNG['ub_fights'].': '.html_entity_decode(shortly_number($total, 0)));
		imagettftext($image, 11, 0, 250, 59, $color, $Font, $LNG['ub_fights'].': '.html_entity_decode(shortly_number($total, 0)));
		
		imagettftext($image, 11, 0, 250, 81, $shadow, $Font, $LNG['ub_quote'].': '.html_entity_decode(shortly_number($quote, 2)).'%');
		imagettftext($image, 11, 0, 250, 80, $color, $Font, $LNG['ub_quote'].': '.html_entity_decode(shortly_number($quote, 2)).'%');
				
		if(!isset($_GET['debug']))
			HTTP::sendHeader('Content-type', 'image/jpg');
			
		ImageJPEG($image);
		imagedestroy($image);
	}
	
	function BannerError($Message) {
		HTTP::sendHeader('Content-type', 'image/jpg');
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