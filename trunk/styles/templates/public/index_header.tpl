<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


<html>
<head>
<title>{servername}</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="content-language" content="de">
<meta http-equiv='expires' content=''>
<meta name='medium' content="mult">

<meta name='description' content='Astro Empires. Highly addictive space strategy game in real-time.'>
<meta name='keywords' content='astro empires, mmog, massively multiplayer, online game, free game, browser game, space strategy, galaxies, spaceships, planets, battles'>
<link rel='stylesheet' type='text/css' href='styles/css/common_2-20.css'>
<link rel='stylesheet' type='text/css' href='styles/css/v2/base_2-0-22.css'>
<link rel='stylesheet' type='text/css' href='styles/images/login/style.css'>
<link rel='stylesheet' type='text/css' href='styles/css/jquery.loadmask.css'>
<link rel='icon' href='favicon.ico' type='image/x-icon'>
<link rel='shortcut icon' href='favicon.ico' type='image/x-icon'>
<script src='scripts/common_2-19.js' type='text/javascript'></script>
<script src='scripts/jquery.js' type='text/javascript'></script>
<script src='scripts/soundmanager2.js' type='text/javascript'></script>
<script src='scripts/jquery.loadmask.js' type='text/javascript'></script>
{jscap}
<script type='text/javascript'>
soundManager.flashVersion = 9;
soundManager.url = 'scripts';
soundManager.debugMode = false;
soundManager.useHighPerformance = true;
soundManager.defaultOptions.volume = 33;
soundManager.onload = function() {
  var loginbgm = soundManager.createSound({
    id: 'aSound',
    url: 'scripts/bgm_login.mp3',
    volume: 50
  });
	loginbgm.play();
}

function music() {
	var loginbgm = soundManager.getSoundById('aSound');
	var idmusic = document.getElementById('music');
	if(idmusic.innerHTML != "Music: ON")
	{
		loginbgm.play();
		idmusic.innerHTML = "Music: ON";
	}
	else
	{
		loginbgm.stop();
		idmusic.innerHTML = "Music: OFF";
	}
}

function ajax(url){
	if(url == '?page=reg&getajax=1'){
		if({game_close} == 1){
			alert('Registration geschlossen!');  
		} else {
			$.get(url, function(data){
				document.getElementById('background-content').innerHTML = data;
				if({game_captcha} == 1){
					showRecaptcha("display_captcha","red");
				}
			});
		}
	} else {
		$.get(url, function(data){
			document.getElementById('background-content').innerHTML = data;
		});
	}
}

$(document).ready(function(){
	$("#background-content").ajaxStart(function () {
		$("#body").mask("Loading...");
	});
				
	$("#background-content").ajaxStop(function () {
		$("#body").unmask();
	});
});

 
</script>
<style type='text/css'>
#intro-logo { text-align: center; margin: 0px auto; margin-top: 5px; margin-bottom: 5px;} 
#background-content { width: 100%; margin: 0px auto; margin-bottom: 22px; min-width: none; max-width: none; }
#intro-menu {width: 350px;}
.Estilo5 {color: #FF0000}
.Estilo5 {color: #FF0000}
html, body, .body{height:100%;width:100%;}
</style>
<!--[if lte IE 7]>
<style type='text/css'>
#home_logo{filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='styles/images/server-logos/logo-alpha.png');width: 502px; height: 80px;} 
#home_logo img { display: none; }
#background-container {border: 0px none;}</style>
<![endif]-->
<script type="text/javascript">
var lastType = "";
function changeAction(type) {
    if (document.formular.Uni.value == '') {
        alert('Wählen Sie ein Universum aus!');
		return false;
    } else {
        if(type == "login" && lastType == "") {
            var url = document.formular.Uni.value;
            document.formular.action = url;
        } else {
            var url = document.formular.Uni.value + "index.php?page=reg";
            document.formular.action = url;
            document.formular.submit();
        }
		return true;
    }
}
</script>

<style type="text/css">
.Estilo1 {
        color: #FF0000;
        font-weight: bold;
}
.Estilo3 {color: #FF0000; font-weight: bold; font-size: 18px; }
.Estilo4 {color: #00FF00}
.at300bs.at15t_expanded, .at300bs.at15t_compact {
background:none!important;
margin-right:4px;
position:relative;
left:500px;
}
.at300bs {
background:none !important;
display:block;
height:auto !important;
line-height:16px !important;
overflow:hidden;
width:16px;
}

</style>
</head>
<body>
<div id="body" class="body">
<table id='background-container'><tr><td class='background-footer page_home planet_blue' id='background-outer'><div id='background-inner' class='background-header page_home'>
<table id='top-header-offline'>
  <tr>
    <td class='menu_container'><table class='box-simple box box-compact'>
      <tr>
        <td class='box-left'>&nbsp;</td>
        <td class='box-center box_content'><table id='top-header-offline_menu' class='menu'>
          <tr class='row1'>
            <td class='menu-item'>&nbsp;</td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
                <td class='button-left'><a onclick="ajax('?getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?getajax=1');" style="cursor:pointer;">IndeX</a></td>
                <td class='button-right'><a onclick="ajax('?getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
              </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table width="87" onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
                <td class='button-left'><a href='{forum_url}' target='_blank'>&nbsp;</a></td>
                <td class='button-center'><a href='{forum_url}' target='_blank'>{forum}</a></td>
                <td class='button-right'><a href='{forum_url}' target='_blank'>&nbsp;</a></td>
              </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
			    <td class='button-left'><a onclick="ajax('?page=news&'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?page=news&'+'getajax=1');" style="cursor:pointer;">News</a></td>
                <td class='button-right'><a onclick="ajax('?page=news&'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
			  </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
			    <td class='button-left'><a onclick="ajax('?page=rules&'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?page=rules&'+'getajax=1');" style="cursor:pointer;">Regeln</a></td>
                <td class='button-right'><a onclick="ajax('?page=rules&'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
			  </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
			    <td class='button-left'><a onclick="ajax('?page=agb&'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?page=agb&'+'getajax=1');" style="cursor:pointer;">AGB</a></td>
                <td class='button-right'><a onclick="ajax('?page=agb&'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
			  </tr>
            </table></td>
          </tr>
        </table></td>
        <td class='box-right'>&nbsp;</td>
      </tr>
    </table></td>
	<td class='languages_container'>
<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4b3aa16f657a67e8" class="addthis_button_compact">Share</a>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4b3aa16f657a67e8"></script>
&bull;&nbsp;<a onclick="music()" style="cursor:pointer;" id="music">Music: ON</a></td>
  </tr>
</table>
<br>
<div id="background-content">