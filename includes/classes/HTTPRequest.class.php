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

class HTTPRequest
{
	private $url		= NULL;
	private $content	= NULL;
	private $ch			= NULL;

	public function __construct($url = NULL)
	{
		$this->url = $url;
	}

	public function send()
	{
		if(function_exists("curl_init"))
		{
			$this->ch	= curl_init($this->url);
			curl_setopt($this->ch, CURLOPT_HTTPGET, true);
			curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($this->ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; 2Moons/".Config::get()->VERSION."; +http://2moons.cc)");
			curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
				"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
				"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.3",
				"Accept-Language: de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4",
			));
			
			$this->content	= curl_exec($this->ch);
			curl_close($this->ch);
		}
	}
	
	public function getResponse()
	{
		$this->send();
		return $this->content;
	}
}