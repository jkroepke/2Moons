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

class Language implements ArrayAccess {
    private $container = array();
    private $language = array();
    static private $allLanguages = array();
	
	static function getAllowedLangs($OnlyKey = true)
	{
		if(empty(self::$allLanguages))
		{
			$cache	= Cache::get();
			$cache->add('language', 'LanguageBuildCache');
			self::$allLanguages = $cache->getData('language');
		}
		
		if($OnlyKey)
		{
			return array_keys(self::$allLanguages);
		}
		else
		{
			return self::$allLanguages;
		}
	}
	
	public function getUserAgentLanguage()
	{
   		if (isset($_REQUEST['lang']) && in_array($_REQUEST['lang'], self::getAllowedLangs()))
		{
			HTTP::sendCookie('lang', $_REQUEST['lang'], 2147483647);
			$this->setLanguage($_REQUEST['lang']);
			return true;
		}
		
   		if ((MODE === 'LOGIN' || MODE === 'INSTALL') && isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], self::getAllowedLangs()))
		{
			$this->setLanguage($_COOKIE['lang']);
			return true;
		}
		
	    if (empty($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{
            return false;
        }

        $accepted_languages = preg_split('/,\s*/', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

        $language = $this->getLanguage();

        foreach ($accepted_languages as $accepted_language)
		{
			$isValid = preg_match('!^([a-z]{1,8}(?:-[a-z]{1,8})*)(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$!i', $accepted_language, $matches);

			if ($isValid !== 1)
			{
				continue;
			}

            list($code)	= explode('-', strtolower($matches[1]));

			if(in_array($code, self::getAllowedLangs()))
			{
				$language	= $code;
				break;
			}
        }
		
		HTTP::sendCookie('lang', $language, 2147483647);
		$this->setLanguage($language);

		return $language;
	}
	
    public function __construct($language = NULL)
	{
		$this->setLanguage($language);
    }
	
    public function setLanguage($language)
	{
		if(!is_null($language) && in_array($language, self::getAllowedLangs()))
		{
			$this->language = $language;
		}
		elseif(MODE !== 'INSTALL')
		{
			$this->language	= Config::get()->lang;
		}
		else
		{
			$this->language	= DEFAULT_LANG;
		}
    }
	
    public function addData($data) {
		$this->container = array_replace_recursive($this->container, $data);
    }
	
	public function getLanguage()
	{
		return $this->language;
	}
	
	public function getTemplate($templateName)
	{
		if(file_exists('language/'.$this->getLanguage().'/templates/'.$templateName.'.txt'))
		{
			return file_get_contents('language/'.$this->getLanguage().'/templates/'.$templateName.'.txt');
		}
		else
		{
			return '### Template "'.$templateName.'" on language "'.$this->getLanguage().'" not found! ###';
		}
	}
	
	public function includeData($files)
	{
		// Fixed BOM problems.
		ob_start();
		$LNG	= array();

		$path	= 'language/'.$this->getLanguage().'/';

        foreach($files as $file) {
			$filePath	= $path.$file.'.php';
			if(file_exists($filePath))
			{
				require $filePath;
			}
		}

		$filePath	= $path.'CUSTOM.php';
		require $filePath;
		ob_end_clean();

		$this->addData($LNG);
	}
	
	/** ArrayAccess Functions **/
	
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }
	
    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }
	
    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }
	
    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : $offset;
    }
}