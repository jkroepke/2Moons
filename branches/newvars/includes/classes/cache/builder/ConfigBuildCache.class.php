<?php

class ConfigBuildCache
{
	function buildCache()
	{
		$configResult	= $GLOBALS['DATABASE']->query("SELECT * FROM ".CONFIG.";");
		$config	= array();
		while($configRow = $GLOBALS['DATABASE']->fetchArray($configResult))
		{
			$config[$configRow['name']]	= $configRow['value'];
		}

		return $config;
	}
}
