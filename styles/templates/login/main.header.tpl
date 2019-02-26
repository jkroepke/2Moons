<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="{$lang}" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="{$lang}" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="{$lang}" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="{$lang}" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="{$lang}" class="no-js"> <!--<![endif]-->
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="styles/theme/nova/formate.css?v={$REV}">
	<link rel="stylesheet" type="text/css" href="styles/resource/css/login/main.css?v={$REV}">
	<link rel="stylesheet" type="text/css" href="styles/resource/css/base/jquery.fancybox.css?v={$REV}">
	<link rel="stylesheet" type="text/css" href="styles/resource/css/login/icon-font/style.css?v={$REV}">
	<link rel="stylesheet" type="text/css" href="styles/resource/css/login/steemconnect_button.css?v={$REV}">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600" type="text/css">
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
	<title>{block name="title"} - {$gameName}{/block}</title>
	<meta name="keywords" content="SteemNova, Steem, Browsergame, MMOSG, MMOG, Strategy, XNova, 2Moons, Space">
	<meta name="description" content="Massively Multiplayer Online Strategy Game (MMOSG) for Steemians. Space Browsergame with competition between Alliances for Steem cryptocurrency. Free-to-play, win-to-pay style.">
	<!-- open graph protocol -->
	<meta property="og:title" content="SteemNova">
	<meta property="og:type" content="website">
	<meta property="og:description" content="Massively Multiplayer Online Strategy Game (MMOSG) for Steemians. Space Browsergame with competition between Alliances for Steem cryptocurrency. Free-to-play, win-to-pay style.">
	<meta property="og:image" content="https://steemnova.intinte.org/styles/resource/images/meta.png">
	<!--[if lt IE 9]>
	<script src="scripts/base/html5.js"></script>
	<![endif]-->
	<script src="scripts/base/jquery.js?v={$REV}"></script>
	<script src="scripts/base/jquery.cookie.js?v={$REV}"></script>
	<script src="scripts/base/jquery.fancybox.js?v={$REV}"></script>
	<script src="scripts/login/main.js"></script>
	<script>{if isset($code)}var loginError = {$code|json};{/if}</script>
	{block name="script"}{/block}	
</head>
<body id="{$smarty.get.page|htmlspecialchars|default:'overview'}" class="{$bodyclass}">
	<div id="page">
