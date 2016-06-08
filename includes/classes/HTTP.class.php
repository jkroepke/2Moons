<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */

class HTTP {
	
	static public function redirectTo($URL, $external = false)
	{
		if($external)
		{
			self::sendHeader('Location', $URL);
		}
		else
		{
			self::sendHeader('Location', HTTP_PATH.$URL);
		}
		exit;
	}

	static public function sendHeader($name, $value = NULL)
	{
		header($name.(!is_null($value) ? ': '.$value : ''));
	}

	static public function redirectToUniverse($universe)
	{
		HTTP::redirectTo(PROTOCOL.HTTP_HOST.HTTP_BASE."uni".$universe."/".HTTP_FILE, true);
	}

	static public function sendCookie($name, $value = "", $toTime = NULL)
	{
		setcookie($name, $value, $toTime);
	}
	
	static public function _GP($name, $default, $multibyte = false, $highnum = false)
	{
		if(!isset($_REQUEST[$name]))
		{
			return $default;
		}

		if(is_float($default) || $highnum)
		{
			return (float) $_REQUEST[$name];
		}
		
		if(is_int($default))
		{
			return (int) $_REQUEST[$name];			
		}

		if(is_string($default))
		{
			return self::_quote($_REQUEST[$name], $multibyte);
		}
		
		if(is_array($default))
		{
			return self::_quoteArray($_REQUEST[$name], $multibyte);
		}
		
		return $default;
	}

	private static function _quoteArray($var, $multibyte)
	{
		$data	= array();
		foreach($var as $key => $value)
		{
			if(is_array($value))
			{
				$data[$key]	= self::_quoteArray($value, $multibyte);
			}
			else
			{
				$data[$key]	= self::_quote($value, $multibyte);
			}
		}

		return $data;
	}

	private static function _quote($var, $multibyte)
	{
		$var	= str_replace(array("\r\n", "\r", "\0"), array("\n", "\n", ''), $var);
		$var	= htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
		$var	= trim($var);

		if ($multibyte) {
			if (!preg_match('/^./u', $var))
			{
				$var = '';
			}
		}
		else
		{
			$var = preg_replace('/[\x80-\xFF]/', '?', $var); // no multibyte, allow only ASCII (0-127)
		}

		return $var;
	}
}