<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 2.0.$Revision$ (2012-11-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class Banner {

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
		return $GLOBALS['DATABASE']->getFirstRow("SELECT 
			u.username, u.wons, u.loos, u.draws, u.universe, 
			s.total_points, s.total_rank, 
			p.name, p.galaxy, p.system, p.planet
			FROM ".USERS." as u  
			INNER JOIN ".PLANETS." as p ON p.id = u.id_planet
			LEFT JOIN ".STATPOINTS." as s ON s.id_owner = u.id AND s.stat_type = '1'
			WHERE u.id = ".$id.";");
	}
	
	public function CreateUTF8Banner($data) {
		global $LNG, $LANG;
		
		$image  		= imagecreatefromjpeg($this->source);
		$date  			= DateUtil::formatDate($LNG['php_dateformat'], TIMESTAMP);
		
		$gameConfig		= $GLOBALS['CACHE']->get('config');
		
		$Font			= ROOT_PATH.$gameConfig['bannerFontFile'];
		
		if(!file_exists($Font)) {
			$this->BannerError('TTF Font missing!');
		}
		
		if(empty($data['total_rank'])) {
			$userRank	= 0;
		} else {
			$userRank	= $data['total_rank'];
		}
		
		if(empty($data['total_points'])) {
			$userPoints	= 0;
		} else {
			$userPoints	= $data['total_points'];
		}
		
		// Colors		
		$color	= imagecolorallocate($image, 255, 255, 225);
		$shadow = imagecolorallocate($image, 33, 33, 33);
		
		$total	= $data['wons'] + $data['loos'] + $data['draws'];
		
		$quote	= $total != 0 ? $data['wons'] / $total * 100 : 0;
		
		// Username
		imagettftext($image, 20, 0, 20, 31, $shadow, $Font, $data['username']);
		imagettftext($image, 20, 0, 20, 30, $color, $Font, $data['username']);
		
		imagettftext($image, 16, 0, 250, 31, $shadow, $Font, $gameConfig['gameName']);
		imagettftext($image, 16, 0, 250, 30, $color, $Font, $gameConfig['gameName']);
		
		imagettftext($image, 11, 0, 20, 60, $shadow, $Font, $LNG['ub_rank'].': '.$userRank);
		imagettftext($image, 11, 0, 20, 59, $color, $Font, $LNG['ub_rank'].': '.$userRank);
		
		imagettftext($image, 11, 0, 20, 81, $shadow, $Font, $LNG['ub_points'].': '.html_entity_decode(shortly_number($userPoints)));
		imagettftext($image, 11, 0, 20, 80, $color, $Font, $LNG['ub_points'].': '.html_entity_decode(shortly_number($userPoints)));
		
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
