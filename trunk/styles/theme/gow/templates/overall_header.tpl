<!DOCTYPE html>

<html lang="{$lang}">
<head>
<title>{$title} - {$uni_name}</title>
{if $goto}
<meta http-equiv="refresh" content="{$gotoinsec};URL={$goto}">
{/if}
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="./styles/css/ingame.css">
<link rel="stylesheet" type="text/css" href="./styles/css/jquery.css">
<link rel="stylesheet" type="text/css" href="{$dpath}formate.css">
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
<script type="text/javascript">
var serverTime 	= new Date({$date.0}, {$date.1 - 1}, {$date.2}, {$date.3}, {$date.4}, {$date.5});
var startTime	= serverTime.getTime();
var localTime 	= new Date();
localTS = localTime.getTime();
var ServerTimezoneOffset = {$date.6} + localTime.getTimezoneOffset()*60;
var Gamename	= document.title;
var Ready		= "{$ready}";
var Skin		= "{$dpath}";
var Lang		= "{$lang}";
var head_info	= "{$fcm_info}";
var auth		= {$authlevel};
var days 		= {$js_days};
var months 		= {$js_month};
</script>
<script type="text/javascript" src="{$cd}scripts/jQuery.js?v={$REV}"></script>
<script type="text/javascript" src="{$cd}scripts/base.js?v={$REV}"></script>
{foreach item=scriptname from=$scripts}
<script type="text/javascript" src="{$cd}scripts/{$scriptname}.js?v={$REV}"></script>
{/foreach}
<script type="text/javascript">
setInterval(function() {
	serverTime.setSeconds(serverTime.getSeconds()+1);
}, 1000);
</script>
</head>
<body>
<div id="tooltip" class="tip"></div>