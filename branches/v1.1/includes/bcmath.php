<?php

function bcadd($Num1 ,$Num2, $Scale = 0) {
	return round($Num1 + $Num2, $Scale);
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

?>