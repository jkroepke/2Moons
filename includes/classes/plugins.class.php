<?php
/**
 * This is a plugin class for all kind of php programms.
 * With this plugin system you are able to load 3rd
 * party plugins in any place of your source code.
 *
 * @author:  Martin Lantzsch <martin@linux-doku.de>
 * @website: http://linux-doku.de
 * @licence: GPL
 * @version: 0.1
 */

class plugins {
	/**
	 * All hooks with plugins
	 */
	private static $plugins = array();

	/**
	 * Start plugin system and define config params
	 *
	 * @param  string  $folder  location of the plugin classes (must have a ending / )
	 */
	public static function start($folder) {
		// check if the plugin folder exists
		if(file_exists($folder))
		{
			// sart to scan this folder
			$pluginFiles = scandir($folder);
			
	
			// run trough all these files
			foreach($pluginFiles as $name)
			{
				// get file infos
				$pluginInfos = pathinfo($folder.$name);
				
				// check if file is a PHP file
				
				if(array_key_exists('extension', $pluginInfos))
				{
					if($pluginInfos['extension'] == 'php' || $pluginInfos['extension'] == 'php5')
					{
						// call the plugin system and load it
						self::load($folder.$name, $pluginInfos['filename']);
						// TIPP: if you want you can extend the code here, the
						//       returns the plugin object
					}		
				}			
			}
			return true;
		} else {
			return false;
		}
		// loading plugins done!
	}

	/**
	 * Load plugin class from given file
	 *
	 * @param  string  $file        folder of the plugin (with ending / )
	 * @param  string  $pluginName  filename of the plugin
	 * @return object
	 */
	public static function load($file, $pluginName) {
		// include plugin file
		include($file);
		// make an object
		$plugin = new $pluginName;
		// get methods as hooks
		$hooks = get_class_methods($plugin);
		// go through all hooks
		foreach($hooks as $hookName)
		{
			// load only hooks without underscore as first char
			if($hookName{0} != '_')
			{
				// put to plugins array
				self::$plugins[$hookName][] = $pluginName;
			}
		}
		// done, return object
		return $plugin;
	}

	/**
	 * Call a hook, if you want with params
	 *
	 * @param  string  $hook  name of the hook
	 * @param  array   $params params as array
	 */
	public static function call($hook, $params=false) {
		// look if hooks existing
		if(array_key_exists($hook, self::$plugins))
                {
        		// go throug all plugins
            		foreach(self::$plugins[$hook] as $name)
            		{
            			// check if params are given
            			if(!is_array($params))
                		{
                			// call plugin without params
                    			call_user_func(array($name, $hook));
                		} else {
                			// call plugin with params
                    			call_user_func_array(array($name, $hook), $params);
            			}
            		}
        	}
	}
}
