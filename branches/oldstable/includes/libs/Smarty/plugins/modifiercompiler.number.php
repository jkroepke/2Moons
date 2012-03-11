<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsModifierCompiler
 */

/**
 * Smarty lower modifier plugin
 *
 * Type:     modifier<br>
 * Name:     lower<br>
 * Purpose:  convert string to lowercase
 *
 * @link http://www.smarty.net/manual/en/language.modifier.lower.php lower (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com>
 * @author Uwe Tews
 * @param array $params parameters
 * @return string with compiled code
 */

function smarty_modifiercompiler_number($params, $compiler)
{
	return 'pretty_number(' . $params[0] . ')';
}

?>