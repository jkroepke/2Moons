<!DOCTYPE html>

<!--[if lt IE 7 ]> <html lang="{$lang}" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="{$lang}" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="{$lang}" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="{$lang}" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="{$lang}" class="no-js"> <!--<![endif]-->
<head>
<link rel="stylesheet" type="text/css" href="styles/css/login.css?v={$REV}">
<link rel="stylesheet" type="text/css" href="styles/css/jquery.fancybox.css?v={$REV}">
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
<title>{block name="title"} - {$servername}{/block}</title>
<meta name="generator" content="2Moons {$VERSION}">
<!-- 
	This website is powered by 2Moons {$VERSION}
	2Moons is a free Space Browsergame initially created by Jan Kröpke and licensed under GNU/GPL.
	2Moons is copyright 2009-2012 of Jan Kröpke. Extensions are copyright of their respective owners.
	Information and contribution at http://2moons.cc/
-->
<meta name="keywords" content="Weltraum Browsergame, XNova, 2Moons, Space, Private, Server, Speed">
<meta name="description" content="2Moons Browsergame powerd by http://2moons.cc/"> <!-- Noob Check :) -->
<!--[if lt IE 9]>
<script src="scripts/base/html5.js"></script>
<![endif]-->
</head>	
<body>
<div id="page">
	<header>
		<nav>
			<ul id="menu">
				<li><a href="index.php">{$LNG.menu_index}</a></li>
				<li><a href="index.php?page=board" target="board">{$LNG.forum}</a></li>
				<li><a href="index.php?page=news">{$LNG.menu_news}</a></li>
				<li><a href="index.php?page=rules">{$LNG.menu_rules}</a></li>
				<li><a href="index.php?page=battleHall">{$LNG.menu_battlehall}</a></li>
				<li><a href="index.php?page=banList">{$LNG.menu_banlist}</a></li>
				<li><a href="index.php?page=disclamer">{$LNG.menu_disclamer}</a></li>
			</ul>
		</nav>
		<nav>
			<ul id="lang">
			</ul>
		</nav>
	</header>
	<div id="content">