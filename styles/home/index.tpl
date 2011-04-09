<!DOCTYPE html>

<html lang="{$lang}">
<head>
<link rel="stylesheet" type="text/css" href="styles/css/login.css?v={$REV}">
<link rel="icon" href="favicon.ico">
<title>{block name="title"} - {$servername}{/block}</title>
<meta name="generator" content="2Moons {$VERSION}">
<!-- 
	This website is powered by 2Moons {$VERSION}
	2Moons is a free Space Browsergame initially created by Slaver and licensed under GNU/GPL.
	2Moons is copyright 2009-2011 of Slaver. Extensions are copyright of their respective owners.
	Information and contribution at http://2moons.cc/
-->
<meta name="keywords" content="Browsergame, XNova, 2Moons, Slaver, Space, Weltraum, Private, Server, Speed">
<meta name="medium" content="mult">
<meta http-equiv="X-UA-Compatible" content="IE=8">
<meta name="description" content="2Moons Browsergame powerd by Slaver"> <!-- Noob Check ;) -->
<!--[if lt IE 9]>
<script src="scripts/html5.js"></script>
<![endif]-->
</head>	
<body>
<div id="page">
	<header>
		<nav>
			<ul id="menu">
				<li><a href="index.php">{$menu_index}</a></li>
				<li><a href="{$forum_url}" target="board">{$forum}</a></li>
				<li><a href="index.php?page=news">{$menu_news}</a></li>
				<li><a href="index.php?page=rules">{$menu_rules}</a></li>
				<li><a href="index.php?page=agb">{$menu_agb}</a></li>
				<li><a href="index.php?page=top100">{$menu_top100}</a></li>
				<li><a href="index.php?page=pranger">{$menu_pranger}</a></li>
				<li><a href="index.php?page=disclamer">{$menu_disclamer}</a></li>
			</ul>
		</nav>
		<nav>
			<ul id="lang">
			</ul>
		</nav>
	</header>
	<div id="content">{if $contentbox === true}
		<section>
			<table class="box-out">
				<tr class="box-out-header">
					<td class="box-out-header-left"></td>
					<td class="box-out-header-center"></td>
					<td class="box-out-header-right"></td>
				</tr>
				<tr class="box-out-content">
					<td class="box-out-content-left"></td>
					<td class="box-out-content-center">
						<table class="box-inner">
							<tr class="box-inner-header">
								<td class="box-inner-header-left"></td>
								<td class="box-inner-header-center"><h1>{block name=title}{/block}</h1></td>
								<td class="box-inner-header-right"></td>
							</tr>
							<tr class="box-inner-content">
								<td class="box-inner-content-left"></td>
								<td class="box-inner-content-center">{/if}
									{block name=content} {/block}
								{if $contentbox === true}</td>
								<td class="box-inner-content-right"></td>
							</tr>
							<tr class="box-inner-footer">
								<td class="box-inner-footer-left"></td>
								<td class="box-inner-footer-center"></td>
								<td class="box-inner-footer-right"></td>
							</tr>
						</table>					
					</td>
					<td class="box-out-content-right"></td>
				</tr>
				<tr class="box-out-footer">
					<td class="box-out-footer-left"></td>
					<td class="box-out-footer-center"></td>
					<td class="box-out-footer-right"></td>
				</tr>
				<tr class="box-out-footer">
					<td class="box-out-footer-left"></td>
					<td class="box-out-footer-center"></td>
					<td class="box-out-footer-right"></td>
				</tr>
			</table>
		</section>
	{/if}</div>
	<footer>
		<a href="index.php?page=disclamer">{$menu_disclamer}</a><br>{$servername} powered by <a href="http://2moons.cc" title="2Moons" target="copy">2Moons</a>
	</footer>
</div>
<div id="dialog" style="display:none;"></div>
<script type="text/javascript" src="scripts/jQuery.js?v={$REV}"></script>
<script type="text/javascript" src="scripts/login.js?v={$REV}"></script>
<script type="text/javascript">
var CONF			= {
	RegClosedUnis	: {$RegClosedUnis},
	IsCaptchaActive : {$game_captcha},
	ref_active		: {$ref_active},
	cappublic		: "{$cappublic}",
	FBActive		: {$fb_active},
	FBKey			: "{$fb_key}",
	Lang			: {$langs},
	MultiUniverse	: $('#universe').children().length !== 1 ? true : false,
	uni				: {$UNI},
	avaLangs		: new Array(),
	lang			: "{$lang}",
};
var LANG			= {
	register		: "{$register_now}",
	login			: "{$login}",
	uni_closed		: "{$uni_closed}",
};
$(document).ready(init);
{if $code}
alert("{$code}");
{/if}
</script>
{if $fb_active}
<div id="fb-root"></div>
<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
window.fbAsyncInit = FBinit;
(function() {
	var e = document.createElement('script'); e.async = true;
	e.src = document.location.protocol +
	  '//connect.facebook.net/en_US/all.js';
	document.getElementById('fb-root').appendChild(e);
}());
</script>
{/if}
{if $game_captcha}
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
{/if}
{if $ga_active}
<script type="text/javascript" src="http://www.google-analytics.com/ga.js"></script>
<script type="text/javascript">
try{
var pageTracker = _gat._getTracker("{$ga_key}");
pageTracker._trackPageview();
} catch(err) {}</script>
{/if}
</body>
</html>