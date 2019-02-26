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

class BuildFunctions
{

    static $bonusList	= array(
        'Attack',
        'Defensive',
        'Shield',
        'BuildTime',
        'ResearchTime',
        'ShipTime',
        'DefensiveTime',
        'Resource',
        'Energy',
        'ResourceStorage',
        'ShipStorage',
        'FlyTime',
        'FleetSlots',
        'Planets',
        'SpyPower',
        'Expedition',
        'GateCoolTime',
        'MoreFound',
    );

    public static function getBonusList()
    {
        return self::$bonusList;
    }

    public static function getRestPrice($USER, $PLANET, $Element, $elementPrice = NULL)
    {
        global $resource;

        if(!isset($elementPrice)) {
            $elementPrice	= self::getElementPrice($USER, $PLANET, $Element);
        }

        $overflow	= array();

        foreach ($elementPrice as $resType => $resPrice) {
            $available			= isset($PLANET[$resource[$resType]]) ? $PLANET[$resource[$resType]] : $USER[$resource[$resType]];
            $overflow[$resType] = max($resPrice - floor($available), 0);
        }

        return $overflow;
    }

    public static function getElementPrice($USER, $PLANET, $Element, $forDestroy = false, $forLevel = NULL) {
        global $pricelist, $resource, $reslist;

        if (in_array($Element, $reslist['fleet']) || in_array($Element, $reslist['defense']) || in_array($Element, $reslist['missile'])) {
            $elementLevel = $forLevel;
        } elseif (isset($forLevel)) {
            $elementLevel = $forLevel;
        } elseif (isset($PLANET[$resource[$Element]])) {
            $elementLevel = $PLANET[$resource[$Element]];
        } elseif (isset($USER[$resource[$Element]])) {
            $elementLevel = $USER[$resource[$Element]];
        } else {
            return array();
        }

        $price	= array();
        foreach ($reslist['ressources'] as $resType)
        {
            if (!isset($pricelist[$Element]['cost'][$resType])) {
                continue;
            }
            $ressourceAmount	= $pricelist[$Element]['cost'][$resType];

            if ($ressourceAmount == 0) {
                continue;
            }

            $price[$resType]	= $ressourceAmount;

            if(isset($pricelist[$Element]['factor']) && $pricelist[$Element]['factor'] != 0 && $pricelist[$Element]['factor'] != 1) {
                $price[$resType]	*= pow($pricelist[$Element]['factor'], $elementLevel - 1);
            }

            if($forLevel && (in_array($Element, $reslist['fleet']) || in_array($Element, $reslist['defense']) || in_array($Element, $reslist['missile']))) {
                $price[$resType]	*= $elementLevel;
            }

            if($forDestroy === true) {
                $price[$resType]	/= 2;
            }
        }

        return $price;
    }

    public static function isTechnologieAccessible($USER, $PLANET, $Element)
    {
        global $requeriments, $resource;

        if(!isset($requeriments[$Element]))
            return true;

        foreach($requeriments[$Element] as $ReqElement => $EleLevel)
        {
            if (
                (isset($USER[$resource[$ReqElement]]) && $USER[$resource[$ReqElement]] < $EleLevel) ||
                (isset($PLANET[$resource[$ReqElement]]) && $PLANET[$resource[$ReqElement]] < $EleLevel)
            ) {
                return false;
            }
        }
        return true;
    }

    public static function getBuildingTime($USER, $PLANET, $Element, $elementPrice = NULL, $forDestroy = false, $forLevel = NULL)
    {
        global $resource, $reslist, $requeriments;

        $config	= Config::get($USER['universe']);

        $time   = 0;

        if(!isset($elementPrice)) {
            $elementPrice	= self::getElementPrice($USER, $PLANET, $Element, $forDestroy, $forLevel);
        }

        $elementCost	= 0;

        if(isset($elementPrice[901])) {
            $elementCost	+= $elementPrice[901];
        }

        if(isset($elementPrice[902])) {
            $elementCost	+= $elementPrice[902];
        }

        if	   (in_array($Element, $reslist['build'])) {
            $time	= $elementCost / ($config->game_speed * (1 + $PLANET[$resource[14]])) * pow(0.5, $PLANET[$resource[15]]) * (1 + $USER['factor']['BuildTime']);
        } elseif (in_array($Element, $reslist['fleet'])) {
            $time	= $elementCost / ($config->game_speed * (1 + $PLANET[$resource[21]])) * pow(0.5, $PLANET[$resource[15]]) * (1 + $USER['factor']['ShipTime']);
        } elseif (in_array($Element, $reslist['defense'])) {
            $time	= $elementCost / ($config->game_speed * (1 + $PLANET[$resource[21]])) * pow(0.5, $PLANET[$resource[15]]) * (1 + $USER['factor']['DefensiveTime']);
	} elseif (in_array($Element, $reslist['missile'])) {
            $time	= $elementCost / ($config->game_speed * (1 + $PLANET[$resource[21]])) * pow(0.5, $PLANET[$resource[15]]) * (1 + $USER['factor']['DefensiveTime']);
        } elseif (in_array($Element, $reslist['tech'])) {
            if(is_numeric($PLANET[$resource[31].'_inter']))
            {
                $Level	= $PLANET[$resource[31]];
            } else {
                $Level = 0;
                foreach($PLANET[$resource[31].'_inter'] as $Levels)
                {
                    if(!isset($requeriments[$Element][31]) || $Levels >= $requeriments[$Element][31])
                        $Level += $Levels;
                }
            }

            $time	= $elementCost / (1000 * (1 + $Level)) / ($config->game_speed / 2500) * pow(1 - $config->factor_university / 100, $PLANET[$resource[6]]) * (1 + $USER['factor']['ResearchTime']);
        }

        if($forDestroy) {
            $time	= floor($time * 1300);
        } else {
            $time	= floor($time * 3600);
        }

        return max($time, $config->min_build_time);
    }

    public static function isElementBuyable($USER, $PLANET, $Element, $elementPrice = NULL, $forDestroy = false, $forLevel = NULL)
    {
        $rest	= self::getRestPrice($USER, $PLANET, $Element, $elementPrice, $forDestroy, $forLevel);
        return count(array_filter($rest)) === 0;
    }

    public static function getMaxConstructibleElements($USER, $PLANET, $Element, $elementPrice = NULL)
    {
        global $resource, $reslist;

        if(!isset($elementPrice)) {
            $elementPrice	= self::getElementPrice($USER, $PLANET, $Element);
        }

        $maxElement	= array();

        foreach($elementPrice as $resourceID => $price)
        {
            if(isset($PLANET[$resource[$resourceID]]))
            {
                $maxElement[]	= floor($PLANET[$resource[$resourceID]] / $price);
            }
            elseif(isset($USER[$resource[$resourceID]]))
            {
                $maxElement[]	= floor($USER[$resource[$resourceID]] / $price);
            }
            else
            {
                throw new Exception("Unknown Ressource ".$resourceID." at element ".$Element.".");
            }
        }

        if(in_array($Element, $reslist['one'])) {
            $maxElement[]	= 1;
        }

        return min($maxElement);
    }

    public static function getMaxConstructibleRockets($USER, $PLANET, $Missiles = NULL)
    {
        global $resource, $reslist;

        if(!isset($Missiles))
        {
            $Missiles	= array();

            foreach($reslist['missile'] as $elementID)
            {
                $Missiles[$elementID]	= $PLANET[$resource[$elementID]];
            }
        }

        $BuildArray  	  	= !empty($PLANET['b_hangar_id']) ? unserialize($PLANET['b_hangar_id']) : array();
        $MaxMissiles   		= $PLANET[$resource[44]] * 10 * max(Config::get()->silo_factor, 1);

        foreach($BuildArray as $ElementArray) {
            if(isset($Missiles[$ElementArray[0]]))
                $Missiles[$ElementArray[0]] += $ElementArray[1];
        }

        $ActuMissiles  = $Missiles[502] + (2 * $Missiles[503]);
        $MissilesSpace = max(0, $MaxMissiles - $ActuMissiles);

        return array(
            502	=> $MissilesSpace,
            503	=> floor($MissilesSpace / 2),
        );
    }

    public static function getAvalibleBonus($Element)
    {
        global $pricelist;

        $elementBonus	= array();

        foreach(self::$bonusList as $bonus)
        {
            $temp	= (float) $pricelist[$Element]['bonus'][$bonus][0];
            if(empty($temp))
            {
                continue;
            }

            $elementBonus[$bonus]	= $pricelist[$Element]['bonus'][$bonus];
        }

        return $elementBonus;
    }
}
