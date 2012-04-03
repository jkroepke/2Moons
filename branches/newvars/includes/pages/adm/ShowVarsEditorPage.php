<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.5 (2011-05-04)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowVarsEditorPage()
{
	global $LNG;
	
	$Mode		= HTTP::_GP('action', '');
	$ElementID	= HTTP::_GP('id', 0);
	switch($Mode){
		case 'sort':
			SortElemets();
		break;
		case 'send':
			SaveElement($ElementID);
		break;
		case 'add':
			AddElement($ElementID);
		break;
		case 'del':
			DelElement($ElementID);
		break;
		case 'edit':
			EditElement($ElementID);
		break;
		default:			
			$ClassID	= HTTP::_GP('class', 0);

			$CLASS	= $CLASSES;
			$VARS	= array();
			$GLOBALS['DATABASE']->db("SELECT * FROM ".VARS.";");
			foreach($CLASS as $ID => $ELEMENTS) {
				foreach($ELEMENTS as $EID) {
					switch($ID) {
						case 900:
							$VARS[$ID][$EID]	= array(
								'name' 		=> $LNG['tech'][$EID], 
								'db_name' 	=> $ELEMENT[$EID]['name'],
							);
						break;
						case 800:
							$VARS[$ID][$EID]	= array(
								'name' 		=> $LNG['tech'][$EID], 
							);
						break;
						default:
							$VARS[$ID][$EID]	= array(
								'name' 		=> $LNG['tech'][$EID], 
								'db_name' 	=> $ELEMENT[$EID]['name'],
								'cost'		=> array_map('pretty_number', $ELEMENT[$EID]['cost'])
							);
						break;
					}
				}
			}
			
			$template	= new template();
			$template->assign_vars(array(
				'VARS'			=> $VARS,
				'RESS'			=> $CLASSES[900],
			));
			
			$template->show('VarsEditor.tpl');
		break;
	}
}

function SortElemets() {
	global $CLASSES, $ELEMENTS, $PROP;

	$CLASSES[0]		= array_map('intval', $_REQUEST['sort'][0]);
	$CLASSES[100]	= array_map('intval', $_REQUEST['sort'][1]);
	$CLASSES[200]	= array_map('intval', $_REQUEST['sort'][2]);
	$CLASSES[400]	= array_map('intval', $_REQUEST['sort'][3]);
	$CLASSES[600]	= array_map('intval', $_REQUEST['sort'][4]);
	$CLASSES[700]	= array_map('intval', $_REQUEST['sort'][5]);
	$CLASSES[800]	= array_map('intval', $_REQUEST['sort'][6]);
	$CLASSES[900]	= array_map('intval', $_REQUEST['sort'][7]);
	$TEMP			= $PROP;
	$PROP			= array(
		'build'		=> array(1 => array(), 3 => array()),
		'prod'		=> array(),
		'one'		=> array(),
		'storage'	=> array(),
		'debris'	=> array(),
		'trans'		=> array(),
		'steal'		=> array(),
		'type'		=> array(1 => array(), 2 => array(), 3 => array()),
	);
	foreach($CLASSES as $DATA) {
		foreach($DATA as $ID) {
			if(in_array($ID, $TEMP['build'][1]))
				$PROP['build'][1][]	= $ID;
			if(in_array($ID, $TEMP['build'][3]))
				$PROP['build'][3][]	= $ID;
			if(in_array($ID, $TEMP['prod']))
				$PROP['prod'][]	= $ID;
			if(in_array($ID, $TEMP['one']))
				$PROP['one'][]	= $ID;
			if(in_array($ID, $TEMP['storage']))
				$PROP['storage'][]	= $ID;
			if(in_array($ID, $TEMP['debris']))
				$PROP['debris'][]	= $ID;
			if(in_array($ID, $TEMP['trans']))
				$PROP['trans'][]	= $ID;
			if(in_array($ID, $TEMP['steal']))
				$PROP['steal'][]	= $ID;
			if(in_array($ID, $TEMP['type'][1]))
				$PROP['type'][1][]	= $ID;
			if(in_array($ID, $TEMP['type'][2]))
				$PROP['type'][2][]	= $ID;
			if(in_array($ID, $TEMP['type'][3]))
				$PROP['type'][3][]	= $ID;
		}
	}

	SaveToFile();
}

function AddElement($ElementID) {
	global $ELEMENT, $CLASSES, $LNG, $PROP;
	
	$NameList		= array();
	$ElementList	= array();
	$Names			= array_diff_key($CLASSES, array(700 => array(), 900 => array(), 1000 => array(), 1100 => array()));

	foreach($Names as $CID => $IDs) {
		$NameList[$LNG['tech'][$CID]]	= array();
		$ElementList[$CID]				= array();
		foreach($IDs as $ID) {
			$NameList[$LNG['tech'][$CID]][$ID]	= $LNG['tech'][$ID];
			$ElementList[$CID][$ID]				= $LNG['tech'][$ID];
		}
	}
	
	$LANGS	= array();
	
	foreach(Language::getAllowedLangs(false) as $LangKey => $LangName) {
		$LANGS[$LangKey]	= array(
			'lang'			=> $LangName,
			'name'			=> '',
			'name_rc'		=> '',
			'short_desc'	=> '',
			'long_desc'		=> '',
		);
	}
	$INFO	= array (
		'name' => '',
		'require' => 
		array (),
		'exclusiv' => 
		array (),
		'cost' => array_combine($CLASSES[900], array_fill(0, count($CLASSES[900]), 0)),
		'factor' => 1,
		'info' => 
		array (
			'metal' => 0,
			'crystal' => 0,
			'deuterium' => 0,
			'energy_max' => 0,
			'darkmatter' => 0,
			'factor' => 0,
			'consumption' => 0,
			'consumption2' => 0,
			'speed' => 0,
			'speed2' => 0,
			'capacity' => 0,
			'tech' => 1,
		),
		'combat' => array(
			'shield' => 0,
			'attack' =>0,
			'sd' => array(),
		),
		'class' => $ElementID,
		'allow' => 1,
		'tech' => 0,
	);
	
	$template	= new template();
	$template->assign_vars(array(
		'ID'				=> $ElementID,
		'ELEMENT'			=> $ELEMENT,
		'ALLOW'				=> $PROP,
		'INFO'				=> $INFO,
		'LNG'				=> $LNG['tech'],
		'CLASSES'			=> $CLASSES,
		'LANGS'				=> $LANGS,
		'NameList'			=> $NameList,
		'ElementList'		=> $ElementList,
		'ShipList'			=> array(0 => '', $LNG['tech'][200] => $NameList[$LNG['tech'][200]], $LNG['tech'][400] => $NameList[$LNG['tech'][400]]),
		've_res_mode'		=> $LNG['ve_res_mode'],
		've_bonus_mode'		=> $LNG['ve_bonus_mode'],
		've_allow_bulid'	=> $LNG['ve_allow_bulid'],
		've_spec_bulid'		=> $LNG['ve_spec_bulid'],
		'RAND'				=> uniqid(),
	));
	$template->show('VarsEditorEdit.tpl');
	
}

function EditElement($ElementID) {
	global $ELEMENT, $CLASSES, $LNG, $PROP;
	
	$NameList		= array();
	$ElementList	= array();
	$Names			= array_diff_key($CLASSES, array(700 => array(), 900 => array(), 1000 => array(), 1100 => array()));
	
	foreach($Names as $CID => $IDs) {
		$NameList[$LNG['tech'][$CID]]	= array();
		$ElementList[$CID]				= array();
		foreach($IDs as $ID) {
			$NameList[$LNG['tech'][$CID]][$ID]	= $LNG['tech'][$ID];
			$ElementList[$CID][$ID]				= $LNG['tech'][$ID];
		}
	}
	
	$_LNG	= $LNG;
	$LANGS	= array();
	
	foreach(Language::getAllowedLangs(false) as $LangKey => $LangName) {
		$LNG	= array();
		include(ROOT_PATH.'language/'.$LangKey.'/TECH.php');
		include(ROOT_PATH.'language/'.$LangKey.'/CUSTOM.php');
		if($ELEMENT[$ElementID]['class'] === 900) {
			$LANGS[$LangKey]	= array(
				'lang'			=> $LangName,
				'name'			=> isset($LNG['tech'][$ElementID]) ? $LNG['tech'][$ElementID] : '',
			);		
		} else {
			$LANGS[$LangKey]	= array(
				'lang'			=> $LangName,
				'name'			=> isset($LNG['tech'][$ElementID]) ? $LNG['tech'][$ElementID] : '',
				'name_rc'		=> isset($LNG['tech_rc'][$ElementID]) ? $LNG['tech_rc'][$ElementID] : '',
				'short_desc'	=> isset($LNG['res']['descriptions'][$ElementID]) ? $LNG['res']['descriptions'][$ElementID] : '',
				'long_desc'		=> isset($LNG['info'][$ElementID]['description']) ? $LNG['info'][$ElementID]['description'] : '',
			);
		}
	}
	
	$LNG	= $_LNG;
	$ELEMENT[$ElementID]['allow']	= 0;
	if(in_array($ElementID, $PROP['build'][1]))
		$ELEMENT[$ElementID]['allow']	+= 1;
		
	if(in_array($ElementID, $PROP['build'][3]))
		$ELEMENT[$ElementID]['allow']	+= 2;
		
	$template	= new template();
	$template->assign_vars(array(
		'ID'				=> $ElementID,
		'ELEMENT'			=> $ELEMENT,
		'ALLOW'				=> $PROP,
		'INFO'				=> $ELEMENT[$ElementID],
		'LNG'				=> $LNG['tech'],
		'CLASSES'			=> $CLASSES,
		'LANGS'				=> $LANGS,
		'NameList'			=> $NameList,
		'ElementList'		=> $ElementList,
		'ShipList'			=> array(0 => '', $LNG['tech'][200] => $NameList[$LNG['tech'][200]], $LNG['tech'][400] => $NameList[$LNG['tech'][400]]),
		've_res_mode'		=> $LNG['ve_res_mode'],
		've_bonus_mode'		=> $LNG['ve_bonus_mode'],
		've_allow_bulid'	=> $LNG['ve_allow_bulid'],
		've_spec_bulid'		=> $LNG['ve_spec_bulid'],
		'RAND'				=> uniqid(),
	));
	$template->show('VarsEditorEdit.tpl');
	
}

function SaveElement($ElementID) {
	global $ELEMENT, $CLASSES, $PROP, $db, $LNG;	
	if(empty($ElementID))
		exit;
		
	if(isset($CLASSES[$ElementID])) {
		$CLASS								= $ElementID;
		$ElementID							= max($CLASSES[$CLASS]) + 1;
		$ELEMENT[$ElementID]				= array();
		$ELEMENT[$ElementID]['class']		= $CLASS;
		
		if($CLASS !== 800 && $CLASS !== 1000 && $CLASS !== 1100) {
			$ELEMENT[$ElementID]['name']		= HTTP::_GP('name', '');
			if(!preg_match('/[a-z_]/', $ELEMENT[$ElementID]['name']))
				exit;
		}
		
		if($CLASS !== 700 && $CLASS !== 800 && $CLASS !== 900 && $CLASS !== 1100) {
			$ELEMENT[$ElementID]['require']		= array();
			$ELEMENT[$ElementID]['exclusiv']	= array();
		}
		
		$CLASSES[$CLASS][]					= $ElementID;
		
		switch($CLASS) {
			case 0:
				$ELEMENT[$ElementID]['max']	= HTTP::_GP('max', 0);
				$db->query("ALTER TABLE ".PLANETS." ADD `".$ELEMENT[$ElementID]['name']."` tinyint(3) unsigned NOT NULL DEFAULT '0';");
			break;
			case 100:
				$ELEMENT[$ElementID]['max']	= HTTP::_GP('max', 0);
				$db->query("ALTER TABLE ".USERS." ADD `".$ELEMENT[$ElementID]['name']."` tinyint(3) unsigned NOT NULL DEFAULT '0';");
			break;
			case 200:
				$db->query("ALTER TABLE ".PLANETS." ADD `".$ELEMENT[$ElementID]['name']."` bigint(11) unsigned NOT NULL DEFAULT '0';");
			break;
			case 400:
				$ELEMENT[$ElementID]['max']	= HTTP::_GP('max', 0);
				$db->query("ALTER TABLE ".PLANETS." ADD `".$ELEMENT[$ElementID]['name']."` bigint(11) unsigned NOT NULL DEFAULT '0';");
			break;
			case 600:
				$ELEMENT[$ElementID]['max']	= HTTP::_GP('max', 0);
				$db->query("ALTER TABLE ".USERS." ADD `".$ELEMENT[$ElementID]['name']."` tinyint(3) unsigned NOT NULL DEFAULT '0';");
			break;
			case 700:
				$db->query("ALTER TABLE ".USERS." ADD `".$ELEMENT[$ElementID]['name']."` int(11) unsigned NOT NULL DEFAULT '0';");
			break;
			case 900:
				$TYPE							= HTTP::_GP('type', 0);
				$ELEMENT[$ElementID]['type']	= $TYPE;		
				$PROP['type'][$TYPE][]			= $ElementID;
				
				switch($ELEMENT[$ElementID]['type']) {
					case 1:
						$db->query("ALTER TABLE ".PLANETS." ADD `".$ELEMENT[$ElementID]['name']."` double(50,0) unsigned NOT NULL DEFAULT '0';");
						$db->query("ALTER TABLE ".PLANETS." ADD `".$ELEMENT[$ElementID]['name']."_perhour` decimal(10,0) unsigned NOT NULL DEFAULT '0';");
					break;
					case 2:
						$db->query("ALTER TABLE ".USERS." ADD `".$ELEMENT[$ElementID]['name']."` double(50,0) unsigned NOT NULL DEFAULT '0';");
						$db->query("ALTER TABLE ".USERS." ADD `".$ELEMENT[$ElementID]['name']."_perhour` decimal(10,0) unsigned NOT NULL DEFAULT '0';");
						$db->query("ALTER TABLE ".USERS." ADD `".$ELEMENT[$ElementID]['name']."_max` bigint(20) unsigned NOT NULL DEFAULT '0';");
						$db->query("ALTER TABLE ".PLANETS." ADD `".$ELEMENT[$ElementID]['name']."_perhour` decimal(10,0) unsigned NOT NULL DEFAULT '0';");
					break;
					case 3:
						$db->query("ALTER TABLE ".PLANETS." ADD `".$ELEMENT[$ElementID]['name']."` double(50,0) unsigned NOT NULL DEFAULT '0';");
					break;
				}
				
				$db->query("ALTER TABLE ".PLANETS." ADD `".$ELEMENT[$ElementID]['name']."_max` bigint(20) unsigned NOT NULL DEFAULT '0';");
				
				foreach($ELEMENT as $EID => $DATA) {
					if(isset($ELEMENT[$EID]['cost']))
						$ELEMENT[$EID]['cost'][$ElementID]	= 0;
					if(isset($ELEMENT[$EID]['prod']))
						$ELEMENT[$EID]['prod'][$ElementID]	= 'return 0;';
					if(isset($ELEMENT[$EID]['storage']))
						$ELEMENT[$EID]['storage'][$ElementID]	= 'return 0;';
				}
			break;
		}
	}
	
	
	if($ELEMENT[$ElementID]['class'] !== 800 && $ELEMENT[$ElementID]['class'] !== 900 && $ELEMENT[$ElementID]['class'] !== 1000 && $ELEMENT[$ElementID]['class'] !== 1100) {
		$ELEMENT[$ElementID]['cost']	= array();
		foreach($CLASSES[900] as $ID) {
			$ELEMENT[$ElementID]['cost'][$ID]	= HTTP::_GP($ELEMENT[$ID]['name'], 0.0);
		}
	}
	
	if($ELEMENT[$ElementID]['class'] === 1100) {
		$TechID							= HTTP::_GP('tech', 0);
		$ELEMENT[$ElementID]['tech']	= in_array($TechID, $CLASSES[100]) ? $TechID : min($CLASSES[100]);
	}
	
	$Factor	= HTTP::_GP('factor', 0.0);
	if(!empty($Factor))
		$ELEMENT[$ElementID]['factor']	= $Factor;
	
	if(isset($ELEMENT[$ElementID]['max']))
		$ELEMENT[$ElementID]['max']	= HTTP::_GP('max', 0);
		
	if(!isset($ELEMENT[$ElementID]['class'])) {
		foreach($CLASSES as $CAT => $DATA) {
			if(in_array($ElementID, $DATA))
				break;
		}
		$ELEMENT[$ElementID]['class']	= $CAT;
	}
	
	if(!empty($_REQUEST['require'])) {
		$ELEMENT[$ElementID]['require']	= array();
		foreach($_REQUEST['require'] as $DATA) {
			if($DATA[0] == 0)
				continue;
				
			if($ELEMENT[$DATA[0]]['class'] !== 700 && $ELEMENT[$DATA[0]]['class'] !== 900)
				$ELEMENT[$ElementID]['require'][(int) $DATA[0]]	= abs((int) $DATA[1]);
		}
	}
	
	if(!empty($_REQUEST['exclusiv'])) {
		$ELEMENT[$ElementID]['exclusiv']	= array();
		foreach($_REQUEST['exclusiv'] as $DATA) {
			if($DATA[0] == 0)
				continue;
				
			if($ELEMENT[$DATA[0]]['class'] !== 700 && $ELEMENT[$DATA[0]]['class'] !== 900)
				$ELEMENT[$ElementID]['exclusiv'][(int) $DATA[0]]	= abs((int) $DATA[1]);
		}
	}
	
	if($ELEMENT[$ElementID]['class'] === 200 || $ELEMENT[$ElementID]['class'] === 400) {
		$ELEMENT[$ElementID]['combat']['attack']	= HTTP::_GP('attack', 0);
		$ELEMENT[$ElementID]['combat']['shield']	= HTTP::_GP('attack', 0);
		foreach($_REQUEST['rf'] as $DATA)
			$ELEMENT[$ElementID]['combat']['sd'][(int) $DATA[0]]	= abs((int) $DATA[1]);
	
	}
	
	if($ELEMENT[$ElementID]['class'] === 400) {
		$MISSLE	= HTTP::_GP('missile', 0);
	
		if($MISSLE == 0 && in_array($ElementID, $PROP['missile'])) {
			unset($PROP['missile'][array_search($ElementID, $PROP['missile'])]);
			$PROP['missile']	= array_values($PROP['missile']);
		}
			
		if($MISSLE == 1 && !in_array($ElementID, $PROP['missile'])){
			$PROP['missile'][]	= $ElementID;
		}
	}
	
	
	$prod		= HTTP::_GP('prod_active', 0);
	$storage	= HTTP::_GP('storage_active', 0);
	
	if(!$ELEMENT[$ElementID]['class'] === 100 && !$ELEMENT[$ElementID]['class'] === 900) {
		if($prod == 1) {
			if(!in_array($ElementID, $PROP['prod'])) {
				$PROP['prod'][]	= $ElementID;
				$db->query("ALTER TABLE ".PLANETS." ADD `".$ELEMENT[$ElementID]['name']."_porcent` enum('0','1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '10';");
			}
			foreach($CLASSES[900] as $ID) {
				$PROD	= $_REQUEST['prod'][$ELEMENT[$ID]['name']];
				if(preg_match("/^[0-9\(\)*\+-\/\., |pow|floor|sqrt|\\\$BuildLevel|\\\$BuildTemp|\\\$BuildEnergy]+$/", $PROD) === 1)
					$ELEMENT[$ElementID]['prod'][$ID]	= 'return '.$PROD.';';
				else
					$ELEMENT[$ElementID]['prod'][$ID]	= 'return 0;';
			}			
		} else {
			if(in_array($ElementID, $PROP['prod'])) {
				unset($PROP['prod'][array_search($ElementID, $PROP['prod'])]);
				$PROP['prod']	= array_values($PROP['prod']);
				$db->query("ALTER TABLE ".PLANETS." DROP `".$ELEMENT[$ElementID]['name']."_porcent`;");
			}
			if(isset($ELEMENT[$ElementID]['prod'])) {
				unset($ELEMENT[$ElementID]['prod']);
			}
		}
		if($storage == 1) {
			if(!in_array($ElementID, $PROP['storage'])) {
				$PROP['storage'][]	= $ElementID;
			}
			foreach($CLASSES[900] as $ID) {
				$STORAGE	= $_REQUEST['storage'][$ELEMENT[$ID]['name']];
				if(preg_match("/^[0-9\(\)*\+-\/\., |pow|floor|sqrt|\\\$BuildLevel|\\\$BuildTemp|\\\$BuildEnergy]+$/", $STORAGE) === 1)
					$ELEMENT[$ElementID]['storage'][$ID]	= 'return '.$STORAGE.';';
				else
					$ELEMENT[$ElementID]['storage'][$ID]	= 'return 0;';
			}			
		} else {
			if(in_array($ElementID, $PROP['storage'])) {
				unset($PROP['storage'][array_search($ElementID, $PROP['storage'])]);
				$PROP['storage']	= array_values($PROP['storage']);
			}
			if(isset($ELEMENT[$ElementID]['storage'])) {
				unset($ELEMENT[$ElementID]['storage']);
			}
		}
	}
	
	if($ELEMENT[$ElementID]['class'] === 900) {
		if($ELEMENT[$ElementID]['type'] == 3) {
			$STEAL		= 0;
			$DEBRIS		= 0;
			$TRANS		= 0;
		} elseif($ELEMENT[$ElementID]['type'] == 2) {
			$STEAL		= HTTP::_GP('steal', 1);
			$DEBRIS		= HTTP::_GP('debris', 1);
			$TRANS		= 0;
		} else {
			$STEAL		= HTTP::_GP('steal', 1);
			$DEBRIS		= HTTP::_GP('debris', 1);
			$TRANS		= HTTP::_GP('trans', 1);
		}
		
		if($TRANS == 0) {
			$STEAL 		= 0;
			$DEBRIS 	= 0;
		}
		
		if($ELEMENT[$ElementID]['debris'] != $DEBRIS) {
			if($DEBRIS == 1) {
				$db->query("ALTER TABLE ".PLANETS." ADD `der_".$ELEMENT[$ElementID]['name']."` double(50,0) unsigned NOT NULL DEFAULT '0';");
				$db->query("ALTER TABLE ".USERS." ADD `kb".$ELEMENT[$ElementID]['name']."` double(50,0) unsigned NOT NULL DEFAULT '0';");
			} elseif($DEBRIS == 0) {
				$db->query("ALTER TABLE ".PLANETS." DROP `der_".$ELEMENT[$ElementID]['name']."`;");
				$db->query("ALTER TABLE ".USERS." DROP `kb".$ELEMENT[$ElementID]['name']."`;");
			}
		}
		
		if($ELEMENT[$ElementID]['trans'] != $TRANS) {
			if($TRANS == 1)
				$db->query("ALTER TABLE ".FLEETS." ADD `fleet_resource_".$ELEMENT[$ElementID]['name']."` double(50,0) unsigned NOT NULL DEFAULT '0';");
			elseif($TRANS == 0)
				$db->query("ALTER TABLE ".FLEETS." DROP `fleet_resource_".$ELEMENT[$ElementID]['name']."`;");
		}
		
		if($DEBRIS == 0 && in_array($ElementID, $PROP['debris'])) {
			unset($PROP['debris'][array_search($ElementID, $PROP['debris'])]);
			$PROP['debris']	= array_values($PROP['debris']);
		}
		 	
		if($DEBRIS == 1 && !in_array($ElementID, $PROP['debris'])){
			$PROP['debris'][]	= $ElementID;
		}
		
		if($TRANS == 0 && in_array($ElementID, $PROP['trans'])) {
			unset($PROP['trans'][array_search($ElementID, $PROP['trans'])]);
			$PROP['trans']	= array_values($PROP['trans']);
		}
			
		if($TRANS == 1 && !in_array($ElementID, $PROP['trans'])){
			$PROP['trans'][]	= $ElementID;
		}
		
		if($STEAL == 0 && in_array($ElementID, $PROP['steal'])) {
			unset($PROP['steal'][array_search($ElementID, $PROP['steal'])]);
			$PROP['steal']	= array_values($PROP['steal']);
		}
			
		if($STEAL == 1 && !in_array($ElementID, $PROP['steal'])){
			$PROP['steal'][]	= $ElementID;
		}
		
		$ELEMENT[$ElementID]['steal'] 	= $STEAL;
		$ELEMENT[$ElementID]['debris']	= $DEBRIS;
		$ELEMENT[$ElementID]['trans']	= $TRANS;
		$ELEMENT[$ElementID]['basic']	= HTTP::_GP('basic', 0);
		$ELEMENT[$ElementID]['start']	= HTTP::_GP('start', 0);
	}
	
	if ($ELEMENT[$ElementID]['class'] === 600 || $ELEMENT[$ElementID]['class'] === 700) {
		$ELEMENT[$ElementID]['bonus']	= array();
		foreach(range(1, 11) as $BID) {
			if(!isset($_REQUEST['bonustype'][$BID]) || $_REQUEST['bonustype'][$BID] != 1)
				continue;
				
			$ELEMENT[$ElementID]['bonus'][$BID]		= abs($_REQUEST['bonusval'][$BID]);
		}
	} elseif(isset($ELEMENT[$ElementID]['bonus'])) {
		$ELEMENT[$ElementID]['bonus']	= HTTP::_GP('bonus', 0.0);
	}
	
	if ($ELEMENT[$ElementID]['class'] === 0)
	{	
		if(in_array($ElementID, $PROP['build'][1])) {
			unset($PROP['build'][1][array_search($ElementID, $PROP['build'][1])]);
			$PROP['build'][1]	= array_values($PROP['build'][1]);
		}	
		
		if(in_array($ElementID, $PROP['build'][3])) {
			unset($PROP['build'][3][array_search($ElementID, $PROP['build'][3])]);
			$PROP['build'][3]	= array_values($PROP['build'][3]);
		}
		
		switch(HTTP::_GP('allow', 0)) {
			case 1:
				if(!in_array($ElementID, $PROP['build'][1]))
					$PROP['build'][1][]	= $ElementID;
			break;
			case 2:
				if(!in_array($ElementID, $PROP['build'][3]))
					$PROP['build'][3][]	= $ElementID;
			break;
			case 3:
				if(!in_array($ElementID, $PROP['build'][1]))
					$PROP['build'][1][]	= $ElementID;
					
				if(!in_array($ElementID, $PROP['build'][3]))
					$PROP['build'][3][]	= $ElementID;
			break;
		}
		$TEMP	= $PROP['build'];
		$PROP['build']	= array(1 => array(), 3 => array());
		foreach($CLASSES[0] as $EID) {
			if(in_array($EID, $TEMP[1]))
				$PROP['build'][1][]	= $EID;
				
			if(in_array($EID, $TEMP[3]))
				$PROP['build'][3][]	= $EID;
		}
	}
	
	if ($ELEMENT[$ElementID]['class'] === 1000) {
		$ListEID	= HTTP::_GP('list', 0);
		$ELEMENT[$ElementID]['list']	= $ListEID;
		$Builds	= $ELEMENT[$ElementID]['elements'];
		
		foreach($Builds as $EID)
			$ELEMENT[$EID]['list']	= $ListEID;
	}
	
	if ($ELEMENT[$ElementID]['class'] !== 1000 && $ELEMENT[$ElementID]['class'] !== 1100) {
		$_LNG	= $LNG;
		foreach(Language::getAllowedLangs() as $LangKey) {
			$LNG	= array();
			include(ROOT_PATH.'language/'.$LangKey.'/TECH.php');
			include(ROOT_PATH.'language/'.$LangKey.'/CUSTOM.php');
			if(!empty($_REQUEST['lang'][$LangKey]['name']) && $_REQUEST['lang'][$LangKey]['name'] != $LNG['tech'][$ElementID]) {
				file_put_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php', str_replace("\r\n\r\n", "\r\n", preg_replace("/\\\$LNG\['tech'\]\[".$ElementID."\].*;/", '', file_get_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php'))));
				file_put_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php', "\r\n".'$LNG[\'tech\']['.$ElementID.'] = \''.((string) $_REQUEST['lang'][$LangKey]['name']).'\';', FILE_APPEND);
			}
			if($ELEMENT[$ElementID]['class'] !== 800 && $ELEMENT[$ElementID]['class'] !== 900) {
				if($ELEMENT[$ElementID]['class'] === 200 || $ELEMENT[$ElementID]['class'] === 400) {
					if(!empty($_REQUEST['lang'][$LangKey]['name_rc']) && $_REQUEST['lang'][$LangKey]['name_rc'] != $LNG['tech_rc'][$ElementID]) {
						file_put_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php', str_replace("\r\n\r\n", "\r\n", preg_replace("/\\\$LNG\['tech_rc'\]\[".$ElementID."\].*;/", '', file_get_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php'))));
						file_put_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php', "\r\n".'$LNG[\'tech_rc\']['.$ElementID.'] = \''.((string) $_REQUEST['lang'][$LangKey]['name_rc']).'\';', FILE_APPEND);
					}
					if(!empty($_REQUEST['lang'][$LangKey]['short_desc']) && $_REQUEST['lang'][$LangKey]['short_desc'] != $LNG['res']['descriptions'][$ElementID]) {
						file_put_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php', str_replace("\r\n\r\n", "\r\n", preg_replace("/\\\$LNG\['res'\]\['descriptions'\]\[".$ElementID."\].*;/", '', file_get_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php'))));
						file_put_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php', "\r\n".'$LNG[\'res\'][\'descriptions\']['.$ElementID.'] = \''.((string) $_REQUEST['lang'][$LangKey]['short_desc']).'\';', FILE_APPEND);
					}
					if(!empty($_REQUEST['lang'][$LangKey]['long_desc']) && $_REQUEST['lang'][$LangKey]['long_desc'] != $LNG['info'][$ElementID]['description']) {
						file_put_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php', str_replace("\r\n\r\n", "\r\n", preg_replace("/\\\$LNG\['info'\]\[".$ElementID."\]\['name'\].*;/", '', file_get_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php'))));
						file_put_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php', "\r\n".'$LNG[\'info\']['.$ElementID.'][\'description\'] = \''.((string) $_REQUEST['lang'][$LangKey]['long_desc']).'\';', FILE_APPEND);
					}
				}
			}
		}
		$LNG	= $_LNG;
	}
	SaveToFile();
}

function DelElement($ElementID) {
	global $ELEMENT, $CLASSES, $PROP, $db;
	
	foreach($CLASSES as $ID => $CLASS) {
		if(in_array($ElementID, $CLASS)) {
			unset($CLASSES[$ID][array_search($ElementID, $CLASSES[$ID])]);
			$CLASSES[$ID]	= array_values($CLASSES[$ID]);
			break;
		}	
	}
	switch($CLASS) {
		case 0:
			$db->query("ALTER TABLE ".PLANETS." DROP `".$ELEMENT[$ElementID]['name']."`;");
		break;
		case 100:
		case 600:
			$db->query("ALTER TABLE ".USERS." DROP `".$ELEMENT[$ElementID]['name']."`;");
		break;
		case 200:
		case 400:
			$db->query("ALTER TABLE ".PLANETS." DROP `".$ELEMENT[$ElementID]['name']."`;");
		break;
		case 600:
		case 700:
			$db->query("ALTER TABLE ".USERS." DROP `".$ELEMENT[$ElementID]['name']."`;");
		break;
		case 900:
			switch($ELEMENT[$ElementID]['type']) {
				case 1:
					$db->query("ALTER TABLE ".PLANETS." DROP `".$ELEMENT[$ElementID]['name']."`;");
					$db->query("ALTER TABLE ".PLANETS." DROP `".$ELEMENT[$ElementID]['name']."_perhour`;");
				break;
				case 2:
					$db->query("ALTER TABLE ".USERS." DROP `".$ELEMENT[$ElementID]['name']."`;");
					$db->query("ALTER TABLE ".USERS." DROP `".$ELEMENT[$ElementID]['name']."_perhour`;");
					$db->query("ALTER TABLE ".USERS." DROP `".$ELEMENT[$ElementID]['name']."_max`;");
					$db->query("ALTER TABLE ".PLANETS." DROP `".$ELEMENT[$ElementID]['name']."_perhour`;");
				break;
				case 3:
					$db->query("ALTER TABLE ".PLANETS." DROP `".$ELEMENT[$ElementID]['name']."`;");
				break;
			}
			
			$db->query("ALTER TABLE ".PLANETS." DROP `".$ELEMENT[$ElementID]['name']."_max`;");
			
			foreach($ELEMENT as $EID => $DATA) {
				if(isset($ELEMENT[$EID]['cost']))
					$ELEMENT[$EID]['cost'][$ElementID]	= 0;
				if(isset($ELEMENT[$EID]['prod']))
					$ELEMENT[$EID]['prod'][$ElementID]	= 'return 0;';
				if(isset($ELEMENT[$EID]['storage']))
					$ELEMENT[$EID]['storage'][$ElementID]	= 'return 0;';
			}
			if($ELEMENT[$ElementID]['debris'] == 1) {
				$db->query("ALTER TABLE ".PLANETS." DROP `der_".$ELEMENT[$ElementID]['name']."`;");
				$db->query("ALTER TABLE ".USERS." DROP `kb".$ELEMENT[$ElementID]['name']."`;");
			}
			
			if($ELEMENT[$ElementID]['trans'] == 1) {
				$db->query("ALTER TABLE ".FLEETS." DROP `fleet_resource_".$ELEMENT[$ElementID]['name']."`;");
			}
		break;
	}	
	
	if(in_array($ElementID, $PROP['prod'])) {
		unset($PROP['prod'][array_search($ElementID, $PROP['prod'])]);
		$PROP['prod']	= array_values($PROP['prod']);
		$db->query("ALTER TABLE ".PLANETS." DROP `".$ELEMENT[$ElementID]['name']."_porcent`;");
	}
	
	if(in_array($ElementID, $PROP['steal'])) {
		unset($PROP['steal'][array_search($ElementID, $PROP['steal'])]);
		$PROP['steal']	= array_values($PROP['steal']);
	}
	
	if(in_array($ElementID, $PROP['trans'])) {
		unset($PROP['trans'][array_search($ElementID, $PROP['trans'])]);
		$PROP['trans']	= array_values($PROP['trans']);
	}
	
	if(in_array($ElementID, $PROP['debris'])) {
		unset($PROP['debris'][array_search($ElementID, $PROP['debris'])]);
		$PROP['debris']	= array_values($PROP['debris']);
	}
		 
	if(in_array($ElementID, $PROP['missile'])) {
		unset($PROP['missile'][array_search($ElementID, $PROP['missile'])]);
		$PROP['missile']	= array_values($PROP['missile']);
	}	

	if(in_array($ElementID, $PROP['build'][1])) {
		unset($PROP['build'][1][array_search($ElementID, $PROP['build'][1])]);
		$PROP['build'][1]	= array_values($PROP['build'][1]);
	}	
	
	if(in_array($ElementID, $PROP['build'][3])) {
		unset($PROP['build'][3][array_search($ElementID, $PROP['build'][3])]);
		$PROP['build'][3]	= array_values($PROP['build'][3]);
	}
	
	foreach(Language::getAllowedLangs() as $LangKey) {
		file_put_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php', str_replace("\r\n\r\n", "\r\n", preg_replace("/\\\$LNG\['tech'\]\[".$ElementID."\].*;/", '', file_get_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php'))));
		file_put_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php', str_replace("\r\n\r\n", "\r\n", preg_replace("/\\\$LNG\['tech_rc'\]\[".$ElementID."\].*;/", '', file_get_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php'))));
		file_put_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php', str_replace("\r\n\r\n", "\r\n", preg_replace("/\\\$LNG\['res'\]\['descriptions'\]\[".$ElementID."\].*;/", '', file_get_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php'))));
		file_put_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php', str_replace("\r\n\r\n", "\r\n", preg_replace("/\\\$LNG\['info'\]\[".$ElementID."\]\['name'\].*;/", '', file_get_contents(ROOT_PATH.'/language/'.$LangKey.'/CUSTOM.php'))));
	}
	$CLASS	= $ELEMENT[$ElementID]['class'];
	unset($ELEMENT[$ElementID]);
	SaveToFile($CLASS);
}

function ConvertToConst($ID) {
	global $ELEMENT;
	return "\r\ndefine('".strtoupper(str_replace('_', '', $ELEMENT[$ID]['name']))."',\t".$ID.");";
}

function SaveToFile($MES = '') {
	global $ELEMENT, $CLASSES, $PROP, $LNG;
	$FILE	= "<?php\r\n".
	"\$ELEMENT = ".var_export($ELEMENT, true).";\r\n".
	"\$CLASSES = ".var_export($CLASSES, true).";\r\n".
	"\$PROP		= ".var_export($PROP, true).";\r\n";
	
/* 	$IDs	= array_keys($ELEMENT);
	foreach($IDs as $ID) {
		$FILE	.= ConvertToConst($ID);
	} */
	
	$FILE	.= "\r\n?>";
	copy(ROOT_PATH.'includes/vars.php', ROOT_PATH.'includes/vars/'.date('y-m-d' ,TIMESTAMP).'_vars.php');
	file_put_contents(ROOT_PATH.'includes/vars.php', str_replace('  ', "\t", $FILE));
	if(!empty($MES))
		exit($MES);
	else
		exit($LNG['ge_saved']);
}

?>