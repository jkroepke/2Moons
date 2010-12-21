{if !$getajax}{include file="public/index_header.tpl"}{/if}
<center>
  <p>&nbsp;</p>
  <p><span class="estilo3">{$welcome_to} {$servername}</span></p>
  <p align="center"><span style="text-align: left;">{$server_description}</span></p>
  <p align="center">&nbsp;</p>
  <table>
    <tr><td><ul style="list-style-type:none;">{foreach item=InfoRow from=$server_infos}<li><strong>{$InfoRow}</strong></li>{/foreach}
  </ul>
  <div align="center">
    <p class="estilo1">&nbsp;</p>
    </div></td></tr>
  </table>
  <br>
  <table style='width: 950px;'><tr><th><table id='home_login' class='box-complex box box-compact box6'><tr><td><table class='box6_box-header box-header'><tr><td class='box6_box-header-left box-header-left'>&nbsp;</td><td class='box6_box-header-center box-header-center'><div class='box6_box-title-wrapper box-title-wrapper'><div class='box6_box-title-container box-title-container'><table class='box6_box-title box-title'><tr><td class='box6_box-title-left box-title-left'>&nbsp;</td>
<td class='box6_box-title-center box-title-center'>{$login}</td>
<td class='box6_box-title-right box-title-right'>&nbsp;</td></tr></table></div></div></td><td class='box6_box-header-right box-header-right'>&nbsp;</td></tr></table></td></tr><tr><td><table class='box6_box-content box-content'><tr><td class='box6_box-content-left box-content-left'>&nbsp;</td><td class='box6_box-content-center box-content-center'><div class='box6_content'><div class='box6_box-title-pad box-title-pad'>&nbsp;</div>
  <form name="login" action="index.php" method="post">
		<table class="layout" style="width: 320px; height: 65px;">
		  <tbody>
			<tr align="center">

			  <td><span class="estilo5"><label for="universe">{$universe}</label></span></td>
			  <td><select name="universe" id="universe" style="width: 188px; position: relative; left: 4px;">
				{html_options options=$AvailableUnis selected=$UNI}
				</select>&nbsp;</td>
			</tr>
			<tr align="center">
				<td><label for="username">{$user}</label></td>
			  <td><input name="username" id="username" value="" size="27" maxlength="40" class="input-text" type="text"></td>
			</tr>
			<tr align="center">
			  <td><label for="password">{$pass}</label></td> 
			  <td><input name="password" id="password" size="27" maxlength="16" class="input-text" type="password"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input name="submit" value="{$login}" type="submit" class="input-text"><br>
				{if $fb_active}<br><br><a href="javascript:void(0);" onclick="fbLogincheck(); return false;"><img src="http://b.static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif" alt=""></a>{/if}
				<br><br><small>{$login_info}</small></td>
			</tr>
		  </tbody>
		</table>
		</form>
		<div class='box6_box-status-pad box-status-pad'>&nbsp;</div></div></td><td class='box6_box-content-right box-content-right'>&nbsp;</td></tr></table></td></tr><tr><td><table class='box6_box-footer box-footer'><tr><td class='box6_box-footer-left box-footer-left'>&nbsp;</td><td class='box6_box-footer-center box-footer-center'><div class='box6_box-status-wrapper box-status-wrapper'><div class='box6_box-status-container box-status-container'><table class='box6_box-status box-status'><tr><td class='box6_box-status-left box-status-left'>&nbsp;</td><td class='box6_box-status-center box-status-center'><div align="center"></div></td>
		<td class='box6_box-status-right box-status-right'>&nbsp;</td></tr></table></div></div></td><td class='box6_box-footer-right box-footer-right'>&nbsp;</td></tr></table></td></tr></table></th></tr></table></center><table id='intro-menu' class='box-complex box box-full default'><tr><td><table id='home_start-playing' class='box-complex box box-full default'><tr><td><table class='default_box-header box-header'><tr><td class='default_box-header-left box-header-left'>&nbsp;</td><td class='default_box-header-center box-header-center'>&nbsp;</td><td class='default_box-header-right box-header-right'>&nbsp;</td></tr></table></td></tr><tr><td><table class='default_box-content box-content'><tr><td class='default_box-content-left box-content-left'>&nbsp;</td><td class='default_box-content-center box-content-center'><div class='default_content'><table   onmouseover='buttonOver(this, "button button-important-over")' onmouseout='buttonOut(this)' class='button button-important'><tr><td class='button-left'><a onclick="ajax('?page=reg&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
		<td class='button-center'><div align="center"><a onclick="ajax('?page=reg&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">{$register_now}</a></div></td>
		<td class='button-right'><a onclick="ajax('?page=reg&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td></tr></table></div></td><td class='default_box-content-right box-content-right'>&nbsp;</td></tr></table></td></tr><tr><td><table class='default_box-footer box-footer'><tr><td class='default_box-footer-left box-footer-left'>&nbsp;</td><td class='default_box-footer-center box-footer-center'>&nbsp;</td><td class='default_box-footer-right box-footer-right'>&nbsp;</td></tr></table></td></tr></table>
		<table class='default_box-header box-header'><tr><td class='default_box-header-left box-header-left'>&nbsp;</td><td class='default_box-header-center box-header-center'>&nbsp;</td><td class='default_box-header-right box-header-right'>&nbsp;</td></tr></table></td></tr><tr><td><table class='default_box-content box-content'><tr><td class='default_box-content-left box-content-left'>&nbsp;</td><td class='default_box-content-center box-content-center'><div class='default_content'><table  class='menu'><tr class='row1'><td class='menu-item' style='width: 50%'><table   onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'><tr><td class='button-left'><a onclick="ajax('?page=lostpassword&amp;'+'getajax=1&amp;'+'lang={$lang}');">&nbsp;</a></td>
		<td class='button-center'><a onclick="ajax('?page=lostpassword&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">{$lostpassword}</a></td>
		<td class='button-right'><a onclick="ajax('?page=lostpassword&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td></tr></table></td><td class='menu-separator'><div>&nbsp;</div></td><td class='menu-item'><table  onmouseover='buttonOver(this, "button button-normal-over")' onmouseout='buttonOut(this)' class='button button-normal'><tr><td class='button-left'><a onclick="ajax('?page=screens&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td>
		<td class='button-center'><div align="center"><a onclick="ajax('?page=screens&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">{$screenshots}</a></div></td><td class='button-right'><a onclick="ajax('?page=screens&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">&nbsp;</a></td></tr></table></td></tr></table></div></td><td class='default_box-content-right box-content-right'>&nbsp;</td></tr></table></td></tr><tr><td><table class='default_box-footer box-footer'><tr><td class='default_box-footer-left box-footer-left'>&nbsp;</td><td class='default_box-footer-center box-footer-center'>&nbsp;</td><td class='default_box-footer-right box-footer-right'>&nbsp;</td></tr></table></td></tr></table>
          <center>
            <small><b><a onclick="ajax('?page=disclamer&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">{$menu_disclamer}</a><br>{$servername} powered by <a href="http://2moons.cc" name="2Moons" title="2Moons" target="_blank">2Moons</a></b></small>
          </center>
{if !$getajax}{include file="public/index_footer.tpl"}{/if}