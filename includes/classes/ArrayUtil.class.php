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