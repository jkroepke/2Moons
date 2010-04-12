<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html lang="de">
<head>
<link rel="stylesheet" type="text/css" href="{$dpath}formate.css">
<link rel="stylesheet" type="text/css" href="styles/css/jquery.ui.css">
<link rel="icon" href="data:image/ico;base64,AAABAAEAEBAAAAEAGABoAwAAFgAAACgAAAAQAAAAIAAAAAEAGAAAAAAAAAAAAEgAAABIAAAAAAAAAAAAAADu8fDg5OOnp6WFhYGgn53v8Njy8rjx8qnz98Lq7KDVzmDBqDG2jyeseiKTXxaDUBDv8PDv8fHx8vPm5+mQjolraFrn57Dy9LH0+NHo6qbPxFq4mimugCOgaxuHVBF5Sg/t8fPv8vLx8vLx8/Pz9O+QjoJWVEfv8df1+Nbn6JrQxVa5nC+qfCWYZhmDUxF1ShDt8e/v8u3x8uPw89fs7cLj4rlBPjJ6eG/5/eLw9azg2W/HrkWrgiiWZRuCVBZ0TRXt8dXu8dvw8sfw8qrv8Kbc252VlHEdGRCNjHK3uYTb2YHYyGS8nECmeS2PYiF5Uxru8LTv8MXw8bHw8Iv19arf36izsH8XEwqEf1atqG98eEmOhk/HtGTCnkuoezOJXyPv8rnu8cPv8LPy8o/4+sL2+c7m46knIhQ+OCLJu3bax32ckFxoYECplFW8k0Sbby3y98ry9drx887y8Jjx7aLu7Knf25skHxRTTDNMQy/Er3PXv364omdUTDudgUmlejXm65/t88Lx9cbr5ovj1Xbj1YG9tHkfGxM5MydCOyvFrnbRtnnJqmxeVUZnW0aeejnOzlfe4n7m6ZDf1m/awmTfx3d5bk0oJB19c1LYxIjTvoGvmmt2a1VVT0Z4Yz+NbjXBtEXOyVfW02TXyWPZvWy/p205NCo+OS+jlGuKfV5vZU9iWUdmWUGGbUKJbDp5Wy27oUjDsVDLvl3TwWi7pGVQSDg6Ni52aUqFdlGNelGUfU6agEqRdEGCZjZwVSpnSyO/oFTMs1/DsWWHelBJQzg9OTKRfVTNr2zFomCvjVCWeUGFaTV3WyxpTyRiSCJiRSBbTzRYUDhEPjM/OzRPRziSfVCylVyti1KpgUWYbzd/XiprUCBgRhxdRBxhRSBiQyFLQzBXTjlrYEOLd0qpkFShhk6UdUOIZzWEXit8VSBrShlZPhVWOxNeQRliQh1cPBypik28mVa5l1Ofg0eSdz+EaTZ0VylmSR1gQhVgPxJcPBFZOhNbPRZbPRhWORdRNRcAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA">
<title>{$title}</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="X-UA-Compatible" content="IE=100">
{if $goto}
<meta http-equiv="refresh" content="{$gotoinsec};URL={$goto}">
{/if}
<script type="text/javascript">
thousands_sep	= '{$thousands_sep}';
</script>
<script type="text/javascript" src="./scripts/jquery.js"></script>
<script type="text/javascript" src="./scripts/jquery.ui.js"></script>
<script type="text/javascript" src="./scripts/overlib.js"></script>
<script type="text/javascript" src="./scripts/global.js"></script>
{foreach item=scriptname from=$scripts}<script type="text/javascript" src="./scripts/{$scriptname}"></script>{/foreach}
</head>
<body>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>