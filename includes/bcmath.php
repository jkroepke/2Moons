<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
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
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.6 (2011-11-17)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */
 
function bcadd($Num1, $Num2, $Scale = 0) {
	if(!preg_match("/^\+?(\d+)(\.\d+)?$/",$Num1,$Tmp1) || !preg_match("/^\+?(\d+)(\.\d+)?$/",$Num2,$Tmp2)) return('0');

	$Output	= array();

	$Dec1	= isset($Tmp1[2]) ? rtrim(substr($Tmp1[2], 1), '0'):'';
	$Dec2	= isset($Tmp2[2]) ? rtrim(substr($Tmp2[2], 1), '0'):'';

	$DLen	= max(strlen($Dec1), strlen($Dec2));

	if($Scale==null) $Scale = $DLen;

	$Num1	= strrev(ltrim($Tmp1[1], '0').str_pad($Dec1, $DLen, '0'));
	$Num2	= strrev(ltrim($Tmp2[1], '0').str_pad($Dec2, $DLen, '0'));

	$MLen	= max(strlen($Num1), strlen($Num2));

	$Num1	= str_pad($Num1, $MLen, '0');
	$Num2	= str_pad($Num2, $MLen, '0');

	for($i=0;$i<$MLen;$i++) {
		$Sum = ((int)$Num1{$i} + (int)$Num2{$i});
		if(isset($Output[$i])) $Sum += $Output[$i];
			$Output[$i] = $Sum % 10;
		
		if($Sum > 9)
			$Output[$i+1]=1;
	}

	$Output=strrev(implode($Output));

	$Decimal	= str_pad(substr($Output, -$DLen, $Scale), $Scale, '0');
	$Output		= ($MLen-$DLen<1) ? '0' : substr($Output,0,-$DLen);
	$Output		.= ($Scale>0) ? ".".$Decimal : '';
	return $Output; 
}

function bcsub($Num1 ,$Num2, $Scale = 0) {
	return round($Num1 - $Num2, $Scale);
}

function bcmul($Num1 ,$Num2, $Scale = 0) {
	return round($Num1 * $Num2, $Scale);
}

function bcdiv($Num1 ,$Num2, $Scale = 0) {
	return round($Num1 / $Num2, $Scale);
}

function bcpow($Num1 ,$Num2, $Scale = 0) {
	return round(pow($Num1, $Num2), $Scale);
}

function bccomp($Num1, $Num2, $Scale = 0) {
	if(!preg_match("/^\+?(\d+)(\.\d+)?$/", $Num1, $Tmp1) || !preg_match("/^\+?(\d+)(\.\d+)?$/", $Num2, $Tmp2)) return('0');

	$Num1	= ltrim($Tmp1[1],'0');
	$Num2	= ltrim($Tmp2[1],'0');

	if(strlen($Num1) > strlen($Num2)) return(1);
	if(strlen($Num1) < strlen($Num2)) return(-1);

	$Dec1	= isset($Tmp1[2]) ? rtrim(substr($Tmp1[2],1),'0') : '';
	$Dec2	= isset($Tmp2[2]) ? rtrim(substr($Tmp2[2],1),'0') : '';

	if($Scale != null) {
		$Dec1	= substr($Dec1,0,$Scale);
		$Dec2	= substr($Dec2,0,$Scale);
	}

	$DLen = max(strlen($Dec1), strlen($Dec2));

	$Num1 .= str_pad($Dec1, $DLen, '0');
	$Num2 .= str_pad($Dec2, $DLen, '0');

	for($i=0; $i<strlen($Num1); $i++) {
		if((int)$Num1{$i} > (int)$Num2{$i}) return 1 ;
		if((int)$Num1{$i} < (int)$Num2{$i}) return -1 ;
	}

	return 0;
}
?>