<?php

class ModuleBuildCache
{
	function buildCache()
	{
		$moduleResult	= $GLOBALS['DATABASE']->query("SELECT * FROM ".MODULE.";");
		$module	= array();
		while($moduleRow = $GLOBALS['DATABASE']->fetchArray($moduleResult))
		{
			$module[$moduleRow['moduleID']]	= $moduleRow['enable'];
		}

		return $module;
	}
}

?>