<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */

class BBCode
{
	static public function parse($sText)
	{
	    $config = parse_ini_file('BBCodeParser2.ini', true);
	    $options = $config['HTML_BBCodeParser2'];

	    $parser = new HTML_BBCodeParser2($options);
	    $parser->setText($sText);
	    $parser->parse();
	    return $parser->getParsed();
	}
}
