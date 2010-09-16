<!DOCTYPE html>

<html lang="{$lang}">
<head>
<title>{$title}</title>
{if $goto}
<meta http-equiv="refresh" content="{$gotoinsec};URL={$goto}">
{/if}
<meta http-equiv="content-language" content="{$lang}">
<meta name="robots" content="index, follow">
<link rel="stylesheet" type="text/css" href="{$cd}styles/css/ingame.css">
<link rel="stylesheet" type="text/css" href="{$cd}{$dpath}formate.css">
<link rel="icon" href="favicon.ico">
</head>
<body>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<div id="fadeBox" class="fadeBox" style="display:none;"><div><span id="fadeBoxStyle" class="success"></span><p id="fadeBoxContent"></p><br class="clearfloat" /></div></div>