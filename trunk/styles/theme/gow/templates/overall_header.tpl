<!DOCTYPE html>

<html lang="{$lang}">
<head>
<title>{$title} - {$uni_name}</title>
{if $goto}
<meta http-equiv="refresh" content="{$gotoinsec};URL={$goto}">
{/if}
<meta http-equiv="content-language" content="{$lang}">
<link rel="stylesheet" type="text/css" href="./styles/css/ingame.css">
<link rel="stylesheet" type="text/css" href="./styles/css/jquery.css">
<link rel="stylesheet" type="text/css" href="{$dpath}formate.css">
<link rel="icon" href="favicon.ico">
</head>
<body>
<div id="tooltip" class="tip"></div>
<div id="fadeBox" class="fadeBox" style="display:none;"><div><span id="fadeBoxStyle" class="success"></span><p id="fadeBoxContent"></p><br class="clearfloat" /></div></div>