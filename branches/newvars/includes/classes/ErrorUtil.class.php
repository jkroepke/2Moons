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

class ErrorUtil 
{
	static function exceptionHandler($exception) 
	{
		global $gameConfig;
		if(!headers_sent()) {
			if (!class_exists('HTTP', false)) {
				require_once(ROOT_PATH . 'includes/classes/HTTP.class.php');
			}
			
			HTTP::sendHeader('HTTP/1.1 503 Service Unavailable');
		}
		
		if(method_exists($exception, 'getSeverity')) {
			$errno	= $exception->getSeverity();
		} else {
			$errno	= E_ERROR;
		}
		
		$errorType = array(
			E_ERROR				=> 'ERROR',
			E_WARNING			=> 'WARNING',
			E_PARSE				=> 'PARSING ERROR',
			E_NOTICE			=> 'NOTICE',
			E_CORE_ERROR		=> 'CORE ERROR',
			E_CORE_WARNING   	=> 'CORE WARNING',
			E_COMPILE_ERROR		=> 'COMPILE ERROR',
			E_COMPILE_WARNING	=> 'COMPILE WARNING',
			E_USER_ERROR		=> 'USER ERROR',
			E_USER_WARNING		=> 'USER WARNING',
			E_USER_NOTICE		=> 'USER NOTICE',
			E_STRICT			=> 'STRICT NOTICE',
			E_RECOVERABLE_ERROR	=> 'RECOVERABLE ERROR'
		);
		
		$VERSION	= isset($CONF['VERSION']) ? $CONF['VERSION'] : 'UNKNOWN';
		$DIR		= MODE == 'INSTALL' ? '..' : '.';
		echo '<!DOCTYPE html>
	<!--[if lt IE 7 ]> <html lang="de" class="no-js ie6"> <![endif]-->
	<!--[if IE 7 ]>    <html lang="de" class="no-js ie7"> <![endif]-->
	<!--[if IE 8 ]>    <html lang="de" class="no-js ie8"> <![endif]-->
	<!--[if IE 9 ]>    <html lang="de" class="no-js ie9"> <![endif]-->
	<!--[if (gt IE 9)|!(IE)]><!--> <html lang="de" class="no-js"> <!--<![endif]-->
	<head>
		<title>'.(isset($gameConfig['gameName']) ? $gameConfig['gameName'].' - ' : '').$errorType[$errno].'</title>
		<meta name="generator" content="2Moons '.$VERSION.'">
		<!-- 
			This website is powered by 2Moons '.$VERSION.'
			2Moons is a free Space Browsergame initially created by Jan and licensed under GNU/GPL.
			2Moons is copyright 2009-2012 of Jan. Extensions are copyright of their respective owners.
			Information and contribution at http://2moons.cc/
		-->
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="'.$DIR.'/styles/css/boilerplate.css?v='.$VERSION.'">
		<link rel="stylesheet" type="text/css" href="'.$DIR.'/styles/css/ingame.css?v='.$VERSION.'">
		<link rel="stylesheet" type="text/css" href="'.$DIR.'/styles/theme/gow/formate.css?v='.$VERSION.'">
		<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
		<script type="text/javascript">
		var ServerTimezoneOffset = -3600;
		var serverTime 	= new Date(2012, 2, 12, 14, 43, 36);
		var startTime	= serverTime.getTime();
		var localTime 	= serverTime;
		var localTS 	= startTime;
		var Gamename	= document.title;
		var Ready		= "Fertig";
		var Skin		= "'.$DIR.'/styles/theme/gow/";
		var Lang		= "de";
		var head_info	= "Information";
		var auth		= 3;
		var days 		= ["So","Mo","Di","Mi","Do","Fr","Sa"] 
		var months 		= ["Jan","Feb","Mar","Apr","Mai","Jun","Jul","Aug","Sep","Okt","Nov","Dez"] ;
		var tdformat	= "[M] [D] [d] [H]:[i]:[s]";
		var queryString	= "";

		setInterval(function() {
			serverTime.setSeconds(serverTime.getSeconds()+1);
		}, 1000);
		</script>
		<script type="text/javascript" src="'.$DIR.'/scripts/base/jquery.js?v=2123"></script>
		<script type="text/javascript" src="'.$DIR.'/scripts/base/jquery.ui.js?v=2123"></script>
		<script type="text/javascript" src="'.$DIR.'/scripts/base/jquery.cookie.js?v=2123"></script>
		<script type="text/javascript" src="'.$DIR.'/scripts/base/jquery.fancybox.js?v=2123"></script>
		<script type="text/javascript" src="'.$DIR.'/scripts/base/jquery.validationEngine.js?v=2123"></script>
		<script type="text/javascript" src="'.$DIR.'/scripts/base/tooltip.js?v=2123"></script>
		<script type="text/javascript" src="'.$DIR.'/scripts/game/base.js?v=2123"></script>
	</head>
	<body id="overview" class="full">
	<table width="960">
		<tr>
			<th>'.$errorType[$errno].'</th>
		</tr>
		<tr>
			<td class="left">
				<b>Message: </b>'.$exception->getMessage().'<br>
				<b>File: </b>'.$exception->getFile().'<br>
				<b>Line: </b>'.$exception->getLine().'<br>
				<b>URL: </b>'.PROTOCOL.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].(!empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING']: '').'<br>
				<b>PHP-Version: </b>'.PHP_VERSION.'<br>
				<b>PHP-API: </b>'.php_sapi_name().'<br>
				<b>MySQL-Cleint-Version: </b>'.mysqli_get_client_info().'<br>
				<b>2Moons Version: </b>'.(isset($gameConfig['version']) ? $gameConfig['version'] : file_get_contents(ROOT_PATH.'install/VERSION').' (INSTALL-VERSION)').'<br>
				<b>Debug Backtrace:</b><br>'.makebr(str_replace($_SERVER['DOCUMENT_ROOT'], '.', htmlspecialchars($exception->getTraceAsString()))).'
			</td>
		</tr>
	</table>
	</body>
	</html>';
		if($errno === 0) {
			ini_set('display_errors', 0);
			trigger_error("Exception: ".str_replace("<br>", "\r\n", $errstr)."\r\n\r\n".str_replace($_SERVER['DOCUMENT_ROOT'], '.', $exception->getTraceAsString()), E_USER_ERROR);
		}
		exit;
	}

	static function errorHandler($errno, $errstr, $errfile, $errline)
	{
		if (!($errno & error_reporting())) {
			return;
		}
		
		throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
	}
}