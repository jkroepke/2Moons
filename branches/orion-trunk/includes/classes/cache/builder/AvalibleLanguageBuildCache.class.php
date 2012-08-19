<?php

class AvalibleLanguageBuildCache {

	function buildCache()
	{
		$Langs		= glob(LANGUAGE_PATH.'*.xml');
		$Languages	= array();
		foreach($Langs as $Lang) {
			$Lang				= basename($Lang,'.xml');
			$Languages[$Lang]	= $Lang;
		}
		
		return $Languages;
	}
}