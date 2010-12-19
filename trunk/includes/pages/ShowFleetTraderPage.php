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

function ShowFleetTraderPage()
{
	global $USER, $PLANET, $LNG, $CONF, $pricelist, $resource;
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$CONF['allowed_trade_ships']	= explode(',', $CONF['allowed_trade_ships']);
	$ID								= request_var('id', 0);
	if(!empty($ID) && in_array($ID, $CONF['allowed_trade_ships'])) {
		$Count						= min(request_var('count', '0'), $PLANET[$resource[$ID]]);
		$PLANET['metal']			= bcmul($Count, $pricelist[$ID]['metal']);
		$PLANET['crystal']			= bcmul($Count, $pricelist[$ID]['crystal']);
		$PLANET['deuterium']		= bcmul($Count, $pricelist[$ID]['deuterium']);
		$USER['darkmatter']			= bcmul($Count, $pricelist[$ID]['darkmatter']);
		$PlanetRess->Builded[$ID]	= bcadd(bcmul('-1', $Count), $PlanetRess->Builded[$ID]);
	}
	
	$PlanetRess->SavePlanetToDB();

	$template	= new template();
	$template->page_header();
	$template->page_topnav();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_footer();

	$template->assign_vars(array(	
		'allowed_trade_ships'		=> $CONF['allowed_trade_ships'],
	));
	
	$template->show("fleettrader_overview.tpl");
}
?>