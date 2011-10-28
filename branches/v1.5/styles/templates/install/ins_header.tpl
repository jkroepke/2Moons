<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="de">
<head>
<link rel="stylesheet" type="text/css" href="../styles/css/ingame.css">
<link rel="stylesheet" type="text/css" href="../styles/theme/gow/formate.css">
<link rel="stylesheet" type="text/css" href="../styles/css/admin.css">
<style type="text/css">
body{
	padding-top: 20px;
    height: auto;
}
</style>
<link rel="icon" href="./favicon.ico">
<title>{$title}</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="X-UA-Compatible" content="IE=100">
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
{if $goto}
<meta http-equiv="refresh" content="{$gotoinsec};URL={$goto}">
{/if}
<script type="text/javascript" src="../scripts/jQuery.js"></script>
<script type="text/javascript" src="../scripts/install.js"></script>
</head>
<body>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<table width="700">
<tr>
	<th colspan="3">{$menu_install}</th>
</tr>