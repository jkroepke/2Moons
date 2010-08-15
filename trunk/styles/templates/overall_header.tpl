<!DOCTYPE html>

<html lang="de">
<head>
<title>{$title}</title>
{if $goto}
<meta http-equiv="refresh" content="{$gotoinsec};URL={$goto}">
{/if}
<link rel="stylesheet" type="text/css" href="./styles/css/ingame.css">
<link rel="stylesheet" type="text/css" href="{$dpath}formate.css">
<link rel="icon" href="favicon.ico">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="./scripts/jquery.metadata.js"></script>
<script type="text/javascript" src="./scripts/mbContainer.js"></script>
<script type="text/javascript" src="./scripts/overlib.js"></script>
<script type="text/javascript" src="./scripts/global.js"></script>
{foreach item=scriptname from=$scripts}
<script type="text/javascript" src="./scripts/{$scriptname}"></script>
{/foreach}
<script type="text/javascript">
ctimestamp		= {$smarty.now};
</script>
</head>
<body>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>