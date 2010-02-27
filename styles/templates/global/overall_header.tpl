<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="content-language" content="de">
<meta http-equiv="X-UA-Compatible" content="IE=100" >
{meta}
<title>{title}</title>
<link rel="shortcut icon" href="./favicon.ico">
<link rel="stylesheet" type="text/css" href="{dpath}formate.css">
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/animatedcollapse.js"></script>
<script type="text/javascript" src="scripts/overlib.js"></script>
<script type="text/javascript">
var galaxy = window;
var ns4up = (document.layers) ? 1 : 0;
var ie4up = (document.all) ? 1 : 0;
var xsize = screen.width;
var ysize = screen.height;
var breite=720;
var hoehe=300;
var xpos=(xsize-breite)/2;
var ypos=(ysize-hoehe)/2;
function f(target_url, win_name) {
var new_win = window.open(target_url, win_name, "scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width="+breite+",height="+hoehe+",screenX="+xpos+",screenY="+ypos+",top="+ypos+",left="+xpos);
new_win.focus();
}
function playercard(target_url) {
var playercard = window.open(target_url, "playercard", "scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width=640,height=510,screenX="+((xsize-640)/2)+",screenY="+((ysize-510)/2)+",top="+((ysize-510)/2)+",left="+((xsize-640)/2));
playercard.focus();
}

function blockError(){return true;} 
window.onerror = blockError; 
</script>
</head>
<body>