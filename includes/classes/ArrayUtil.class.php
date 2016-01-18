<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @licence MIT
 * @version 2.0 (2012-11-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class ArrayUtil
{
	static public function combineArrayWithSingleElement($keys, $var)
	{
		if(empty($keys))
		{
			return array();
		}
		return array_combine($keys, array_fill(0, count($keys), $var));
	}

	static public function combineArrayWithKeyElements($keys, $var)
	{
		$temp	= array();
		foreach($keys as $key)
		{
			if(isset($var[$key]))
			{
				$temp[$key]	= $var[$key];
			}
			else
			{
				$temp[$key]	= $key;
			}
		}
		
		return $temp;
	}
	
	// http://www.php.net/manual/en/function.array-key-exists.php#81659
	static public function arrayKeyExistsRecursive($needle, $haystack)
	{
		$result = array_key_exists($needle, $haystack);
		
		if ($result)
		{
			return $result;
		}
		
		foreach ($haystack as $v)
		{
			if (is_array($v))
			{
				$result = self::arrayKeyExistsRecursive($needle, $v);
			}
			
			if ($result)
			{
				return $result;
			}
		}
		
		return $result;
	}
}