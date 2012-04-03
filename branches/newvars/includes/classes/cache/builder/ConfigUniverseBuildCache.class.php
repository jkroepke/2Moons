<?php

class ConfigUniverseBuildCache
{
	function buildCache()
	{
		$configResult	= $GLOBALS['DATABASE']->query("SELECT * FROM ".UNIVERSE_CONFIG.";");
		$config	= array();
		while($configRow = $GLOBALS['DATABASE']->fetchArray($configResult))
		{
			$config[$configRow['universe']][$configRow['name']]	= $configRow['value'];
		}

		return $config;
	}
}
