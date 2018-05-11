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


class ShowImperiumPage extends AbstractGamePage
{
	public static $requireModule = MODULE_IMPERIUM;

	function __construct() 
	{
		parent::__construct();
	}

	function show()
	{
		global $USER, $PLANET, $resource, $reslist;

        $db = Database::get();
		
		$order = $USER['planet_sort_order'] == 1 ? 'DESC' : 'ASC';
		
		$sql = "SELECT * FROM %%PLANETS%% WHERE id_owner = :userID AND destruyed = '0' ORDER BY ";

		switch($USER['planet_sort'])
		{
			case 2:
				$sql .= 'name '.$order;
				break;
			case 1:
				$sql .= 'galaxy '.$order.', system '.$order.', planet '.$order.', planet_type '.$order;
				break;
			default:
				$sql .= 'id '.$order;
				break;
		}

        $PlanetsRAW = $db->select($sql, array(
            ':userID'   => $USER['id']
        ));

        $PLANETS	= array();
		
		$PlanetRess	= new ResourceUpdate();
		
		foreach ($PlanetsRAW as $CPLANET)
		{
            list($USER, $CPLANET)	= $PlanetRess->CalcResource($USER, $CPLANET, true);
			
			$PLANETS[]	= $CPLANET;
			unset($CPLANET);
		}

        $planetList	= array();

		foreach($PLANETS as $Planet)
		{
			$planetList['name'][$Planet['id']]					= $Planet['name'];
			$planetList['image'][$Planet['id']]					= $Planet['image'];
			
			$planetList['coords'][$Planet['id']]['galaxy']		= $Planet['galaxy'];
			$planetList['coords'][$Planet['id']]['system']		= $Planet['system'];
			$planetList['coords'][$Planet['id']]['planet']		= $Planet['planet'];
			
			$planetList['field'][$Planet['id']]['current']		= $Planet['field_current'];
			$planetList['field'][$Planet['id']]['max']			= CalculateMaxPlanetFields($Planet);
			
			$planetList['energy_used'][$Planet['id']]			= $Planet['energy'] + $Planet['energy_used'];

           
			$planetList['resource'][901][$Planet['id']]			= $Planet['metal'];
			$planetList['resource'][902][$Planet['id']]			= $Planet['crystal'];
			$planetList['resource'][903][$Planet['id']]			= $Planet['deuterium'];
			$planetList['resource'][911][$Planet['id']]			= $Planet['energy'];
			
			foreach($reslist['build'] as $elementID) {
				$planetList['build'][$elementID][$Planet['id']]	= $Planet[$resource[$elementID]];
			}
			
			foreach($reslist['fleet'] as $elementID) {
				$planetList['fleet'][$elementID][$Planet['id']]	= $Planet[$resource[$elementID]];
			}
			
			foreach($reslist['defense'] as $elementID) {
				$planetList['defense'][$elementID][$Planet['id']]	= $Planet[$resource[$elementID]];
			}
			
			$planetList['missiles'][502][$Planet['id']]         = $Planet[$resource[502]];
            		$planetList['missiles'][503][$Planet['id']]         = $Planet[$resource[503]];
		}

		foreach($reslist['tech'] as $elementID){
			$planetList['tech'][$elementID]	= $USER[$resource[$elementID]];
		}
		
		$this->assign(array(
			'colspan'		=> count($PLANETS) + 2,
			'planetList'	=> $planetList,
		));

		$this->display('page.empire.default.tpl');
	}
}
