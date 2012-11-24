<?php

class Browser
{
	private $sessionKey;
	public $ch;
	
	function __construct($url = NULL)
	{
		$this->ch = curl_init($url);
		$this->reset();
		#curl_setopt($this->ch, CURLOPT_HTTP200ALIASES, array(503)); // Execeptions
	}
	
	function reset()
	{
		curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_HEADER, false);
		curl_setopt($this->ch, CURLOPT_COOKIEFILE, 'cookie.txt');
		curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		$this->setMethod('GET');
		$this->setPostData(array());
		$this->setUrl('index.php');
	}
	
	function setCurlOpt($key, $value)
	{
		curl_setopt($this->ch, $key, $value);
		return $this;
	}
	
	function setFollowLocation($value)
	{
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, $value);
		return $this;
	}
	
	function setMethod($method)
	{
		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method);
		return $this;
	}
	
	function setPostData($postData)
	{
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($postData));
		return $this;
	}
	
	function setUrl($url)
	{
		curl_setopt($this->ch, CURLOPT_URL, TEST_SERVER.$url);
		return $this;
	}
	
	function execute()
	{
		return curl_exec($this->ch);
	}
	
	function getInfo()
	{
		return curl_getinfo($this->ch);
	}
		
	function getHttpCode()
	{
		return curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
	}
	
	function close()
	{
		curl_close($this->ch);
		return true;
	}
}