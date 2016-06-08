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

class LanguageBuildCache implements BuildCache
{
	public function buildCache()
	{
		$languagePath	= ROOT_PATH.'language/';
		
		$languages	= array();
		
		/** @var $fileInfo SplFileObject */
		foreach (new DirectoryIterator($languagePath) as $fileInfo)
		{
			if(!$fileInfo->isDir() || $fileInfo->isDot()) continue;

			$Lang	= $fileInfo->getBasename();

			if(!file_exists($languagePath.$Lang.'/LANG.cfg')) continue;

			// Fixed BOM problems.
			ob_start();
			$path	 = $languagePath.$Lang.'/LANG.cfg';
			require $path;
			ob_end_clean();
			if(isset($Language['name']))
			{
				$languages[$Lang]	= $Language['name'];
			}
		}
		return $languages;
	}
}