<?php

class HTTP {
	
	static public function redirectTo($URL)
	{
		self::sendHeader('Location', HTTP_PATH.$URL);
		exit;
	}
	
	static public function sendHeader($name, $value = NULL)
	{
		header($name.(!is_null($value) ? ': '.$value : ''));
	}
	
	static public function _GP($name, $default, $multibyte = false, $highnum = false)
	{
		if(!isset($_REQUEST[$name])) {
			return $default;
		}
		
		if(is_int($default)) {
			return (int) $_REQUEST[$name];			
		}
		
		if(is_float($default)) {
			return (float) $_REQUEST[$name];			
		}
		
		if(is_string($default)) {
			$var = trim(htmlspecialchars(str_replace(array("\r\n", "\r", "\0"), array("\n", "\n", ''), $_REQUEST[$name]), ENT_QUOTES, 'UTF-8'));
			
			if (empty($var)) {
				return $default;				
			}
			
			if ($multibyte) {
				if (!preg_match('/^./u', $var)) {
					$var = '';
				}
			} else {
				$var = preg_replace('/[\x80-\xFF]/', '?', $var); // no multibyte, allow only ASCII (0-127)
			}
			
			return $var;
		}
		
		if(is_array($default)) {
			$varArray		= array();
			$requestData	= $_REQUEST[$name];
			foreach($requestData as $key => $subdefault)
			{
				if(!isset($requestData[$key])) {
					continue;
				}
				
				if(is_int($subdefault)) {
					$varArray[$key]	= (int) $requestData[$key];			
				}
				
				if(is_float($subdefault)) {
					$varArray[$key]	= (float) $requestData[$key];			
				}
				
				if(is_string($subdefault)) {
					$var = trim(htmlspecialchars(str_replace(array("\r\n", "\r", "\0"), array("\n", "\n", ''), $requestData[$key]), ENT_QUOTES, 'UTF-8'));
					
					if (empty($var)) {
						return $subdefault;				
					}
					
					if ($multibyte) {
						if (!preg_match('/^./u', $var)) {
							$var = '';
						}
					} else {
						$var = preg_replace('/[\x80-\xFF]/', '?', $var); // no multibyte, allow only ASCII (0-127)
					}
					
					$varArray[$key]	= $var;	
				}
			}
			
			return $varArray;
		}
		
		return $default;
	}
}