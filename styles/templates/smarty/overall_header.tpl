<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="content-language" content="de">
{if $goto}
<meta http-equiv="refresh" content="{$gotoinsec};URL={$goto}">
{/if}
<title>{$title}</title>
<link rel="shortcut icon" href="./favicon.ico">
<link rel="stylesheet" type="text/css" href="styles/css/default.css">
<link rel="stylesheet" type="text/css" href="styles/css/formate.css">
<link rel="stylesheet" type="text/css" href="{$dpath}formate.css">
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/animatedcollapse.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
{foreach item=scriptname from=$scripts}
<script type="text/javascript" src="scripts/{$scriptname}"></script>
{/foreach}
</head>
<body>
{popup_init src="scripts/overlib.js"}