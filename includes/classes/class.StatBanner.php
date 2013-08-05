<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.8.0 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

class StatBanner {

	private $source = "styles/resource/images/banner.jpg";

	public function GetData($id)
	{
		$sql = 'SELECT user.username, user.wons, user.loos, user.draws,
		stat.total_points, stat.total_rank,
		planet.name, planet.galaxy, planet.system, planet.planet, config.game_name,
		config.users_amount, config.ttf_file
		FROM %%USERS%% as user, %%STATPOINTS%% as stat, %%PLANETS%% as planet, %%CONFIG%% as config
		WHERE user.id = :userId AND stat.stat_type = :statType AND stat.id_owner = :userId
		AND planet.id = user.id_planet AND config.uni = user.universe;';

		return Database::get()->selectSingle($sql, array(
			':userId'	=> $id,
			':statType'	=> 1
		));
	}
	
	public function CreateUTF8Banner($data) {
		global $LNG;
		$image  	= imagecreatefromjpeg($this->source);

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
		{
			HTTP::sendHeader('Content-type', 'image/jpg');
		}

		imagejpeg($image);
		imagedestroy($image);
	}
	
	function BannerError($Message) {
		HTTP::sendHeader('Content-type', 'image/jpg');
		$im	 = imagecreate(450, 80);
		$text_color = imagecolorallocate($im, 233, 14, 91);
		imagestring($im, 3, 5, 5, $Message, $text_color);
		imagejpeg($im);
		imagedestroy($im);
		exit;
	}
}