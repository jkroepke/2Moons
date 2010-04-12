<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html lang="de">
<head>
<link rel='stylesheet' type='text/css' href='styles/css/jquery.loadmask.css'>
<link rel='stylesheet' type='text/css' href='styles/css/common_2-20.css'>
<link rel="icon" href="data:image/ico;base64,AAABAAEAEBAAAAEAGABoAwAAFgAAACgAAAAQAAAAIAAAAAEAGAAAAAAAAAAAAEgAAABIAAAAAAAAAAAAAADu8fDg5OOnp6WFhYGgn53v8Njy8rjx8qnz98Lq7KDVzmDBqDG2jyeseiKTXxaDUBDv8PDv8fHx8vPm5+mQjolraFrn57Dy9LH0+NHo6qbPxFq4mimugCOgaxuHVBF5Sg/t8fPv8vLx8vLx8/Pz9O+QjoJWVEfv8df1+Nbn6JrQxVa5nC+qfCWYZhmDUxF1ShDt8e/v8u3x8uPw89fs7cLj4rlBPjJ6eG/5/eLw9azg2W/HrkWrgiiWZRuCVBZ0TRXt8dXu8dvw8sfw8qrv8Kbc252VlHEdGRCNjHK3uYTb2YHYyGS8nECmeS2PYiF5Uxru8LTv8MXw8bHw8Iv19arf36izsH8XEwqEf1atqG98eEmOhk/HtGTCnkuoezOJXyPv8rnu8cPv8LPy8o/4+sL2+c7m46knIhQ+OCLJu3bax32ckFxoYECplFW8k0Sbby3y98ry9drx887y8Jjx7aLu7Knf25skHxRTTDNMQy/Er3PXv364omdUTDudgUmlejXm65/t88Lx9cbr5ovj1Xbj1YG9tHkfGxM5MydCOyvFrnbRtnnJqmxeVUZnW0aeejnOzlfe4n7m6ZDf1m/awmTfx3d5bk0oJB19c1LYxIjTvoGvmmt2a1VVT0Z4Yz+NbjXBtEXOyVfW02TXyWPZvWy/p205NCo+OS+jlGuKfV5vZU9iWUdmWUGGbUKJbDp5Wy27oUjDsVDLvl3TwWi7pGVQSDg6Ni52aUqFdlGNelGUfU6agEqRdEGCZjZwVSpnSyO/oFTMs1/DsWWHelBJQzg9OTKRfVTNr2zFomCvjVCWeUGFaTV3WyxpTyRiSCJiRSBbTzRYUDhEPjM/OzRPRziSfVCylVyti1KpgUWYbzd/XiprUCBgRhxdRBxhRSBiQyFLQzBXTjlrYEOLd0qpkFShhk6UdUOIZzWEXit8VSBrShlZPhVWOxNeQRliQh1cPBypik28mVa5l1Ofg0eSdz+EaTZ0VylmSR1gQhVgPxJcPBFZOhNbPRZbPRhWORdRNRcAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA">
<title>{$servername}</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="content-language" content="de">
<meta http-equiv="X-UA-Compatible" content="IE=100">
<meta name='keywords' content='astro empires, mmog, massively multiplayer, online game, free game, browser game, space strategy, galaxies, spaceships, planets, battles'>
<meta name='medium' content="mult">
<!--<meta name='description' content=''>-->
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
	<td class='languages_container'><a href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4b3aa16f657a67e8" class="addthis_button_compact">Share</a>&nbsp;&bull;&nbsp;<a onclick="music()" style="cursor:pointer;" id="music">Music: ON</a></td>
  </tr>
</table>
<br>
<div id="background-content">