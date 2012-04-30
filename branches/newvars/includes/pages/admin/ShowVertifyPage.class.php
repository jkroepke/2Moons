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
 * @version 1.7.0 (2012-05-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class ShowVertifyPage extends AbstractPage
{
	function __construct() 
	{
		parent::__construct();
	}
	
	function show()
	{
		$this->render('page.vertify.default.tpl');
	}
	
	function vertify()
	{
		$this->loadscript('vertify.js');
		$this->render('page.vertify.vertify.tpl');
	}
	
	function compareFile()
	{
		global $gameConfig;
		$file	 	= HTTP::_GP('file', '');
		
		$REV		= explode('.', $gameConfig['version']);
		$REV		= $REV[2];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_URL, 'http://2moons.googlecode.com/svn-history/r'.$REV.'/branches/newvars/'.$file);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, '2Moons Update API');
		curl_setopt($ch, CURLOPT_CRLF, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$FILE		= curl_exec($ch);
		
		$SVNHASH	= crc32(preg_replace(array('/(\r\n)|(\r)/', '/(\\/\\*[\\d\\D]*?\\*\\/)/', '/\$I'.'d[^\$]+\$/'), array("\n", '', ''), $FILE));
		
		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) == 404)
		{
			$this->sendJSON(4);
		}
		
		if(curl_errno($ch))
		{
			$this->sendJSON(3);
		}
		
		curl_close($ch);
		$FILE2		= file_get_contents(ROOT_PATH.$file);
		$LOCALHASH	= crc32(preg_replace(array('/(\r\n)|(\r)/', '/(\\/\\*[\\d\\D]*?\\*\\/)/', '/\$I'.'d[^\$]+\$/'), array("\n", '', ''), $FILE2));
		
		if($SVNHASH == $LOCALHASH)
		{
			$this->sendJSON(1);
		}
		else
		{
			$this->sendJSON(2);
		}
	}
	
	function getFileList()
	{
		$EXT	= HTTP::_GP('ext', '');
		$EXT	= str_replace('\\|', '|', preg_quote($EXT));
		
		$Files		= array();
		foreach(new RegexIterator(new DirectoryIterator(ROOT_PATH.'/'), '/^.+\.('.$EXT.')$/i', RecursiveRegexIterator::GET_MATCH) as $File)
		{
			$Files[]	= str_replace(array('\\', ROOT_PATH), '', $File[0]);
		}
		
		foreach(array('includes', 'install', 'language', 'scripts', 'styles') as $dir)
		{		
			foreach(new RegexIterator(new RecursiveIteratorIterator(new RecursiveDirectoryIterator(ROOT_PATH.'/'.$dir.'/')), '/^.+\.('.$EXT.')$/i', RecursiveRegexIterator::GET_MATCH) as $File)
			{
				$Files[]	= str_replace(array('\\', ROOT_PATH.'/'), array('/', ''), $File[0]);
			}
		}
		
		$this->sendJSON($Files);
	}
}