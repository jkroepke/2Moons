<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html lang="de">
<head>
<link rel='stylesheet' type='text/css' href='styles/css/common_2-20.css'>
<link rel='stylesheet' type='text/css' href='styles/css/jquery.loadmask.css'>
<link rel='icon' href='favicon.ico' type='image/x-icon'>
<title>{$servername}</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="content-language" content="de">
<meta http-equiv="X-UA-Compatible" content="IE=100" >
<meta name='keywords' content='astro empires, mmog, massively multiplayer, online game, free game, browser game, space strategy, galaxies, spaceships, planets, battles'>
<meta name='medium' content="mult">

<!--<meta name='description' content=''>-->

<script type="text/javascript">
IsCaptchaActive = {$game_captcha};
IsRegActive 	= {$reg_close};
lang_reg_closed	= '{$register_closed}';
cappublic		= '{$cappublic}';
</script>
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
&bull;&nbsp;<a onclick="music()" style="cursor:pointer;" id="music">Music: ON</a></td>
  </tr>
</table>
<br>
<div id="background-content">