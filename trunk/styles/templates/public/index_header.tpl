<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html lang="{$lang}" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<link rel="stylesheet" type="text/css" href="styles/css/login.css">
<link rel="stylesheet" type="text/css" href="styles/css/login_bg.css">
<link rel="icon" href="favicon.ico">
<title>{$servername}</title>
<meta name="keywords" content="Browsergame, Clone, XNova, 2Moons">
<meta name="medium" content="mult">
<meta name="description" content='2Moons Browsergame powerd by Slaver'> <!-- Noob Check ;) -->
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
                <td class='button-left'><a onclick="ajax('?getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">{$menu_index}</a></td>
                <td class='button-right'><a onclick="ajax('?getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
              </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
                <td class='button-left'><a href='{$forum_url}' target='_blank'>&nbsp;</a></td>
                <td class='button-center'><a href='{$forum_url}' target='_blank'>{$forum}</a></td>
                <td class='button-right'><a href='{$forum_url}' target='_blank'>&nbsp;</a></td>
              </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
			    <td class='button-left'><a onclick="ajax('?page=news&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?page=news&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">{$menu_news}</a></td>
                <td class='button-right'><a onclick="ajax('?page=news&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
			  </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
			    <td class='button-left'><a onclick="ajax('?page=rules&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?page=rules&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">{$menu_rules}</a></td>
                <td class='button-right'><a onclick="ajax('?page=rules&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
			  </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
			    <td class='button-left'><a onclick="ajax('?page=agb&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?page=agb&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">{$menu_agb}</a></td>
                <td class='button-right'><a onclick="ajax('?page=agb&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
			  </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
			    <td class='button-left'><a onclick="ajax('?page=pranger&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?page=pranger&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">{$menu_pranger}</a></td>
                <td class='button-right'><a onclick="ajax('?page=pranger&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
			  </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
			    <td class='button-left'><a onclick="ajax('?page=top100&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?page=top100&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">{$menu_top100}</a></td>
                <td class='button-right'><a onclick="ajax('?page=top100&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
			  </tr>
            </table></td>
            <td class='menu-separator'><div>&nbsp;</div></td>
            <td class='menu-item'><table onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'>
              <tr>
			    <td class='button-left'><a onclick="ajax('?page=disclamer&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
                <td class='button-center'><a onclick="ajax('?page=disclamer&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">{$menu_disclamer}</a></td>
                <td class='button-right'><a onclick="ajax('?page=disclamer&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
			  </tr>
            </table></td>
          </tr>
        </table></td>
        <td class='box-right'>&nbsp;</td>
      </tr>
    </table></td>
	<td class='languages_container'>
	<a href="?lang=de"><img src="./styles/images/login/de.png" alt="" width="16" height="11"></a>
	<a href="?lang=en"><img src="./styles/images/login/en.png" alt="" width="16" height="11"></a>
	<a href="?lang=pt"><img src="./styles/images/login/pt.png" alt="" width="16" height="11"></a>
	<a href="?lang=ru"><img src="./styles/images/login/ru.png" alt="" width="16" height="11"></a>
	<a href="?lang=cn"><img src="./styles/images/login/cn.png" alt="" width="16" height="11"></a>
	{if $bgm_active}&nbsp;&bull;&nbsp;<a onclick="music()" style="cursor:pointer;" id="music">{$music_off}</a></td>{/if}
  </tr>
</table>
<br>
<div id="background-content">