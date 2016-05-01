<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

class Universe {
	private static $currentUniverse = NULL;
	private static $emulatedUniverse = NULL;
	private static $availableUniverses = array();

	/**
	 * Return the current universe id.
	 *
	 * @return int
	 */

	static public function current()
	{
		if(is_null(self::$currentUniverse))
		{
			self::$currentUniverse = self::defineCurrentUniverse();
		}

		return self::$currentUniverse;
	}

	static public function add($universe)
	{
		self::$availableUniverses[]	= $universe;
	}
	
	static public function getEmulated()
	{
		if(is_null(self::$emulatedUniverse))
		{
			$session	= Session::load();
			if(isset($session->emulatedUniverse))
			{
				self::setEmulated($session->emulatedUniverse);
			}
			else
			{
				self::setEmulated(self::current());
			}
		}
		
		return self::$emulatedUniverse;
	}
	
	static public function setEmulated($universeId)
	{
		if(!self::exists($universeId))
		{
			throw new Exception('Unknown universe ID: '.$universeId);
		}

		$session	= Session::load();
		$session->emulatedUniverse	= $universeId;
		$session->save();

		self::$emulatedUniverse	= $universeId;
		
		return true;
	}

	/**
	 * Find current universe id using cookies, get parameter or session keys.
	 *
	 * @return int
	 */

	static private function defineCurrentUniverse()
	{
		$universe = NULL;
		if(MODE === 'INSTALL' || isCommandLineInterface())
		{
			// Installer are always in the first universe.
			return ROOT_UNI;
		}
		
		if(count(self::availableUniverses()) != 1)
		{
			if(MODE == 'LOGIN')
			{
				if(isset($_COOKIE['uni']))
				{
					$universe = (int) $_COOKIE['uni'];
				}

				if(isset($_REQUEST['uni']))
				{
					$universe = (int) $_REQUEST['uni'];
				}
			}
			elseif(MODE == 'ADMIN' && isset($_SESSION['admin_uni']))
			{
				$universe = (int) $_SESSION['admin_uni'];
			}


			if(is_null($universe))
			{
				if(UNIS_WILDCAST)
				{
					$temp = explode('.', $_SERVER['HTTP_HOST']);
					$temp = substr($temp[0], 3);
					if(is_numeric($temp))
					{
						$universe = $temp;
					}
					else
					{
						$universe = ROOT_UNI;
					}
				}
				else
				{
					if(isset($_SERVER['REDIRECT_UNI'])) {
						// Apache - faster then preg_match
						$universe = $_SERVER["REDIRECT_UNI"];
					}
					elseif(isset($_SERVER['REDIRECT_REDIRECT_UNI']))
					{
						// Patch for www.top-hoster.de - Hoster
						$universe = $_SERVER["REDIRECT_REDIRECT_UNI"];
					}
					elseif(preg_match('!/uni([0-9]+)/!', HTTP_PATH, $match))
					{
						if(isset($match[1]))
						{
							$universe = $match[1];
						}
					}
					else
					{
						$universe = ROOT_UNI;
					}
				}

				if(!isset($universe) || !self::exists($universe))
				{
					HTTP::redirectToUniverse(ROOT_UNI);
				}
			}
		}
		else
		{
			if(HTTP_ROOT != HTTP_BASE)
			{
				HTTP::redirectTo(PROTOCOL.HTTP_HOST.HTTP_BASE.HTTP_FILE, true);
			}
			$universe = ROOT_UNI;
		}

		return $universe;
	}

	/**
	 * Return an array of all universe ids
	 *
	 * @return array
	 */

	static public function availableUniverses()
	{
		return self::$availableUniverses;
	}

	/**
	 * Find current universe id using cookies, get parameter or session keys.
	 *
	 * @param int universe id
	 *
	 * @return int
	 */

	static public function exists($universeId)
	{
		return in_array($universeId, self::availableUniverses());
	}
}