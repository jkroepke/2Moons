<?php

require('vars.php');


$ELEMENT	= array();


foreach(array_merge($reslist['build'], $reslist['tech'], $reslist['fleet'], $reslist['defense'], $reslist['officier'], $reslist['dmfunc']) as $ID) {
	$ELEMENT[$ID]	= array();
	$ELEMENT[$ID]['name']	= $resource[$ID];
	
	if(isset($pricelist[$ID]['max']))
		$ELEMENT[$ID]['max']		= $pricelist[$ID]['max'];
		
	if(isset($requeriments[$ID]))
		$ELEMENT[$ID]['require']	= $requeriments[$ID];
	else
		$ELEMENT[$ID]['require']	= array();
	
	$ELEMENT[$ID]['cost']		= array();
	if(!isset($OfficerInfo[$ID]) && !isset($ExtraDM[$ID])) {
		$ELEMENT[$ID]['cost'][901]	= (int) $pricelist[$ID]['metal'];
		$ELEMENT[$ID]['cost'][902]	= (int) $pricelist[$ID]['crystal'];
		$ELEMENT[$ID]['cost'][903]	= (int) $pricelist[$ID]['deuterium'];
		$ELEMENT[$ID]['cost'][920]	= (int) $pricelist[$ID]['darkmatter'];
		$ELEMENT[$ID]['cost'][910]	= 0;
		$ELEMENT[$ID]['cost'][911]	= (int) $pricelist[$ID]['energy_max'];
	} else {
		$ELEMENT[$ID]['cost'][920]	= 1000;
	}
	if(in_array($ID, array_merge($reslist['fleet'], $reslist['defense']))) {
		$ELEMENT[$ID]['info']	= array_diff($pricelist[$ID], array('metal', 'crystal', 'deuterium', 'energy_max', 'darkmatter', 'factor', 'max'));
	}
	if(isset($CombatCaps[$ID]))
		$ELEMENT[$ID]['combat']	= $CombatCaps[$ID];
	if(isset($ExtraDM[$ID]))
		$ELEMENT[$ID]['bonus']	= $ExtraDM[$ID];
	if(isset($OfficerInfo[$ID]))
		$ELEMENT[$ID]['bonus']	= $OfficerInfo[$ID]['info'];
	if(isset($ProdGrid[$ID])) {
		$ELEMENT[$ID]['prod']		= array();
		$ELEMENT[$ID]['prod'][901]	= $ProdGrid[$ID]['formule']['metal'];
		$ELEMENT[$ID]['prod'][902]	= $ProdGrid[$ID]['formule']['crystal'];
		$ELEMENT[$ID]['prod'][903]	= $ProdGrid[$ID]['formule']['deuterium'];
		$ELEMENT[$ID]['prod'][920]	= 'return 0;';
		$ELEMENT[$ID]['prod'][910]	= $ProdGrid[$ID]['formule']['energy'];
	}
}
define("NL", "\r\n");
define("TAB", "\t");
header('Content-type: text/plain');
function printArray($Array, $Var) {
	echo 'array();',NL;
	if(empty($Array)) {
		return;
	}
	$MaxKey	= 0;
	foreach($Array as $Key => $Value) {
		$MaxKey	= max(ceil((strlen($Key) + (is_numeric($Key) ? 0 : 2)) / 4), $MaxKey);
	}
	
	foreach($Array as $Key => $Value) {
		echo $Var,'[',(is_numeric($Key) ? $Key : "'".$Key."'"),']',TAB,str_repeat(TAB, $MaxKey - ceil((strlen($Key) + (is_numeric($Key) ? 0 : 2)) / 4)),'= ';
		if(is_array($Value)) {
			echo printArray($Value, $Var.'['.(is_numeric($Key) ? $Key : "'".$Key."'").']');
		} elseif(is_numeric($Value)) {
			echo $Value,';';
		} else {
			echo "'",$Value,"';";
		}
		echo NL;
	}
}
echo '<?php',NL,'$ELEMENT	= ';
printArray($ELEMENT, '$ELEMENT');


?>