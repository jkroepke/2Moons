<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsFilter
 */

/**
 * Smarty trimwhitespace outputfilter plugin
 *
 * Trim unnecessary whitespace from HTML markup.
 *
 * @author   Rodney Rehm
 * @param string                   $source input string
 * @param Smarty_Internal_Template $smarty Smarty object
 * @return string filtered output
 * @todo substr_replace() is not overloaded by mbstring.func_overload - so this function might fail!
 */
function smarty_outputfilter_rewritelink($source, Smarty_Internal_Template $smarty)
{
	return Link::rewrite($source);
}

?>