<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */
 
class ShowQuestionsPage extends AbstractGamePage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show()
	{
		global $LNG;
		
		$LNG->includeData(array('FAQ'));
		
		$this->display('page.questions.default.tpl');
	}
	
	function single()
	{
		global $LNG;
		
		$LNG->includeData(array('FAQ'));
		
		$categoryID	= HTTP::_GP('categoryID', 0);
		$questionID	= HTTP::_GP('questionID', 0);
		
		if(!isset($LNG['questions'][$categoryID][$questionID])) {
			HTTP::redirectTo('game.php?page=questions');
		}
		
		$this->assign(array(
			'questionRow'	=> $LNG['questions'][$categoryID][$questionID],
		));
		$this->display('page.questions.single.tpl');
	}
}