<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


<html>
<head>
<title>{$servername}</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="content-language" content="de">
<meta http-equiv="X-UA-Compatible" content="IE=100" >
<meta http-equiv='expires' content=''>
<meta name='medium' content="mult">

<!--<meta name='description' content=''>-->
<meta name='keywords' content='astro empires, mmog, massively multiplayer, online game, free game, browser game, space strategy, galaxies, spaceships, planets, battles'>
<link rel='stylesheet' type='text/css' href='styles/css/common_2-20.css'>
<link rel='stylesheet' type='text/css' href='styles/css/v2/base_2-0-22.css'>
<link rel='stylesheet' type='text/css' href='styles/images/login/style.css'>
<link rel='stylesheet' type='text/css' href='styles/css/jquery.loadmask.css'>
<link rel='stylesheet' type='text/css' href='styles/css/login.css'>
<link rel='icon' href='favicon.ico' type='image/x-icon'>
<link rel='shortcut icon' href='favicon.ico' type='image/x-icon'>
<script src='scripts/common_2-19.js' type='text/javascript'></script>
<script src='scripts/jquery.js' type='text/javascript'></script>
<script src='scripts/soundmanager2.js' type='text/javascript'></script>
<script src='scripts/jquery.loadmask.js' type='text/javascript'></script>
<script src='scripts/login.js' type='text/javascript'></script>
<script type="text/javascript">
IsCaptchaActive = {$game_captcha};
IsRegActive 	= {$reg_close};
lang_reg_closed	= '{$register_closed}';
</script>
{if $game_captcha}
<script src="http://api.recaptcha.net/js/recaptcha_ajax.js" type="text/javascript"></script>
<script type="text/javascript">
function showRecaptcha(element) {ldelim}
  Recaptcha.create("{$cappublic}", 'display_captcha', {ldelim}
        theme: 'custom',
		lang: 'de',
        tabindex: '4',
        custom_theme_widget: 'display_captcha'
  {rdelim});
{rdelim}
</script>
{/if}
<!--[if lte IE 7]>
<link rel="stylesheet" type="text/css" media="screen" href="styles/css/login_ie.css">
<![endif]-->
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
                <td class='button-center'><a onclick="ajax('?getajax=1');" style="cursor:pointer;">{$menu_index}</a></td>
                <td class='button-right'><a onclick="ajax('?getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
              </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table width="87" onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
                <td class='button-left'><a href='{$forum_url}' target='_blank'>&nbsp;</a></td>
                <td class='button-center'><a href='{$forum_url}' target='_blank'>{$forum}</a></td>
                <td class='button-right'><a href='{$forum_url}' target='_blank'>&nbsp;</a></td>
              </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
			    <td class='button-left'><a onclick="ajax('?page=news&amp;'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?page=news&amp;'+'getajax=1');" style="cursor:pointer;">{$menu_news}</a></td>
                <td class='button-right'><a onclick="ajax('?page=news&amp;'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
			  </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
			    <td class='button-left'><a onclick="ajax('?page=rules&amp;'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?page=rules&amp;'+'getajax=1');" style="cursor:pointer;">{$menu_rules}</a></td>
                <td class='button-right'><a onclick="ajax('?page=rules&amp;'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
			  </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
			    <td class='button-left'><a onclick="ajax('?page=agb&amp;'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?page=agb&amp;'+'getajax=1');" style="cursor:pointer;">{$menu_agb}</a></td>
                <td class='button-right'><a onclick="ajax('?page=agb&amp;'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
			  </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
			    <td class='button-left'><a onclick="ajax('?page=pranger&amp;'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?page=pranger&amp;'+'getajax=1');" style="cursor:pointer;">{$menu_pranger}</a></td>
                <td class='button-right'><a onclick="ajax('?page=pranger&amp;'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
			  </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
			    <td class='button-left'><a onclick="ajax('?page=top100&amp;'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?page=top100&amp;'+'getajax=1');" style="cursor:pointer;">{$menu_top100}</a></td>
                <td class='button-right'><a onclick="ajax('?page=top100&amp;'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
			  </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
			    <td class='button-left'><a onclick="ajax('?page=disclamer&amp;'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?page=disclamer&amp;'+'getajax=1');" style="cursor:pointer;">{$menu_disclamer}</a></td>
                <td class='button-right'><a onclick="ajax('?page=disclamer&amp;'+'getajax=1');" style="cursor:pointer;">&nbsp;</a></td>
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