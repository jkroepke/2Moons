<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

if(!defined('INSIDE')) die('Hacking attempt!');

function ShowTechTreePage()
{
	global $resource, $requeriments, $LNG, $reslist, $USER, $PLANET;
	
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource()->SavePlanetToDB();
	
	$template	= new template();
	
	$template->page_header();
	$template->page_topnav();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_footer();
	$RequeriList = array();
	foreach($LNG['tech'] as $Element => $ElementName)
	{
		if(in_array($Element, $reslist['dmfunc'])) continue;
		
		if(!isset($resource[$Element]))
			$TechTreeList[]	= $ElementName;
		else
		{
			if(isset($requeriments[$Element]))
			{
				foreach($requeriments[$Element] as $RegID => $RedCount)
				{
					$RequeriList[$Element][]	= array('id' => $RegID, 'count' => $RedCount, 'own' => (isset($PLANET[$resource[$RegID]])) ? $PLANET[$resource[$RegID]] : $USER[$resource[$RegID]]);
				}
			}
			$TechTreeList[]	= array(
				'id' 	=> $Element,
				'name'	=> $ElementName,
				'need'	=> $RequeriList,
			);
		}
	}
	
	$template->assign_vars(array(
		'TechTreeList'		=> $TechTreeList,
		'tt_requirements'	=> $LNG['tt_requirements'],
		'lang'				=> $LNG['tech'],
		'tt_lvl'			=> $LNG['tt_lvl'],
	));

	$template->show("techtree_overview.tpl");
}
?>