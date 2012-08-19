<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsModifierCompiler
 */

/**
 * 2Moons json modifier plugin
 *
 * Type:     modifier<br>
 * Name:     json<br>
 * Purpose:  convert variable to json object
 *
 * @author Jan Kröpke
 * @param array $params parameters
 * @return string with compiled code
 */

function smarty_modifiercompiler_json($params, $compiler)
{
	return 'json_encode(' . $params[0] . ')';
}

?>