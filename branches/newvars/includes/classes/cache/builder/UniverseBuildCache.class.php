<?php

class UniverseBuildCache
{
	function buildCache()
	{
		$universeResult	= $GLOBALS['DATABASE']->query("SELECT * FROM ".UNIVERSE.";");
		$universe	= array();
		while($universeRow = $GLOBALS['DATABASE']->fetchArray($universeResult))
		{
			$universe[$universeRow['universe']] = $universeRow;
		}

		return $universe;
	}
}
