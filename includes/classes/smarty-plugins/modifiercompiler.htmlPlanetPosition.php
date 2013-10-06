<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsModifierCompiler
 */

/**
 * 2Moons time modifier plugin
 *
 * Type:     modifier<br>
 * Name:     time<br>
 * Purpose:  convert string to lowercase
 *
 * @author Jan Kröpke
 * @param array $params parameters
 * @return string with compiled code
 */

function smarty_modifiercompiler_htmlPlanetPosition($params, $compiler)
{
	return BuildPlanetAdressLink($params[0]);
}