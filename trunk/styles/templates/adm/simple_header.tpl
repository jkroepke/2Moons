<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="content-language" content="de">
<title>{title}</title>
<link rel="shortcut icon" href="./../favicon.ico">
<link rel="stylesheet" type="text/css" href="./../styles/css/admin.css"> 
<script type="text/javascript" src="./../scripts/overlib.js"></script>
<script type="text/javascript" src="./../scripts/jquery.js"></script>
<script type="text/javascript">
var xsize 	= screen.width;
var ysize 	= screen.height;
var breite	= 720;
var hoehe	= 300;
var xpos	= (xsize-breite) / 2;
var ypos	= (ysize-hoehe) / 2;


function useropen(target_url) {
	var userlist = window.open("UserListPage.php?action=edit&id="+ target_url, "info", "scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width=850,height=600,screenX="+((xsize-600)/2)+",screenY="+((ysize-850)/2)+",top="+((ysize-600)/2)+",left="+((xsize-850)/2));
	userlist.focus();
}

function openEdit(id, type) {
	var editlist = window.open("QuickEditor.php?edit="+type+"&id="+id, "edit", "scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width=850,height=600,screenX="+((xsize-600)/2)+",screenY="+((ysize-850)/2)+",top="+((ysize-600)/2)+",left="+((xsize-850)/2));
	editlist.focus();
}
</script> 
{meta}
</head>
<body>