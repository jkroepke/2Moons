<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html lang="de">
<head>
<link rel="stylesheet" type="text/css" href="{$dpath}formate.css">
<link rel="stylesheet" type="text/css" href="styles/css/jquery.ui.css">
<link rel="shortcut icon" href="./favicon.ico">
<title>{$title}</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="X-UA-Compatible" content="IE=100">
{if $goto}
<meta http-equiv="refresh" content="{$gotoinsec};URL={$goto}">
{/if}
<script type="text/javascript" src="parser.php?js[]=jquery.js&amp;js[]=jquery.ui.js&amp;js[]=overlib.js&amp;js[]=global.js{foreach item=scriptname from=$scripts}&amp;js[]={$scriptname}{/foreach}"></script>
</head>
<body>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>