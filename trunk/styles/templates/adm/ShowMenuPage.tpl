{include file="adm/overall_header.tpl"}
<div id='leftmenu'>
<div id='menu'>
<img src="./styles/images/xgp-logo.png" alt="" style="height:50px;width:100px;position:absolute;top:10px;left:48px;">
<table width="100%" cellspacing="0" cellpadding="0">
{if $CONFGame == 1}
   	<tr>
       	<td><div align="center"><a href="javascript:void(0);"><font color="lime">{$mu_general}</font></a></div></td>
   	</tr>
	<tr>
       	<td><div align="center"><a href="?page=infos" target="Hauptframe">{$mu_game_info}</a></div></td>
   	</tr>
   	<tr>
       	<td><div align="center"><a href="?page=config" target="Hauptframe">{$mu_settings}</a></div></td>
   	</tr>
	<tr>
       	<td><div align="center"><a href="?page=teamspeak" target="Hauptframe">{$mu_ts_options}</a></div></td>
   	</tr>
	<tr>
      	<td><div align="center"><a href="?page=facebook" target="Hauptframe">{$mu_fb_options}</a></div></td>
    </tr>
	<tr>
      	<td><div align="center"><a href="?page=module" target="Hauptframe">{$mu_module}</a></div></td>
   	</tr>
	<tr>
       	<td><div align="center"><a href="?page=statsconf" target="Hauptframe">{$mu_stats_options}</a></div></td>
   	</tr>
    <tr>
        <td><div align="center"><a href="?page=update" target="Hauptframe">{$mu_update}</a></div></td>
    </tr>
{/if}		
{if $EditUsers == 1}
	<tr>
		<td><img src="styles/skins/darkness/gfx/user-menu.jpg" width="110" height="40" alt=""></td>
	</tr>
	<tr>
        <td><div align="center"><a href="javascript:void(0);"><font color="lime">{$mu_users_settings}</font></a></div></td>
    </tr>
	<tr>
       	<td><div align="center"><a href="?page=create" target="Hauptframe">{$new_creator_title}</a></div></td>
   	</tr>
    <tr>
       	<td><div align="center"><a href="?page=accounteditor" target="Hauptframe">{$mu_add_delete_resources}</a></div></td>
   	</tr>
	<tr>
       	<td><div align="center"><a href="?page=bans" target="Hauptframe">{$mu_ban_options}</a></div></td>
    </tr>
{/if}
{if $Observation == 1}
	<tr>
		<td><img src="styles/skins/darkness/gfx/user-menu.jpg" width="110" height="40" alt=""></td>
	</tr>
	<tr>
     	<td><div align="center"><a href="javascript:void(0);"><font color="lime">{$mu_observation}</font></a></div></td>
   	</tr>
	<tr>
       	<td><div align="center"><a href="?page=search&amp;search=online&amp;minimize=on" target="Hauptframe">{$mu_connected}</a></div></td>
   	</tr>
	<tr>
       	<td><div align="center"><a href="?page=support" target="Hauptframe">{$mu_support}</a></div></td>
   	</tr> 
	<tr>
        <td><div align="center"><a href="?page=active" target="Hauptframe">{$mu_vaild_users}</a></div></td>
    </tr>
	<tr>
       	<td><div align="center"><a href="?page=search&amp;search=p_connect&amp;minimize=on" target="Hauptframe">{$mu_active_planets}</a></div></td>
    </tr>
    <tr>
       	<td><div align="center"><a href="?page=fleets" target="Hauptframe">{$mu_flying_fleets}</a></div></td>
    </tr>
    <tr>
       	<td><div align="center"><a href="?page=news" target="Hauptframe">{$mu_news}</a></div></td>
    </tr>
	<tr>
       	<td><div align="center"><a href="?page=search&amp;search=users&amp;minimize=on" target="Hauptframe">{$mu_user_list}</a></div></td>
    </tr>
	<tr>
       	<td><div align="center"><a href="?page=search&amp;search=planet&amp;minimize=on" target="Hauptframe">{$mu_planet_list}</a></div></td>
    </tr>
	<tr>
       	<td><div align="center"><a href="?page=search&amp;search=moon&amp;minimize=on" target="Hauptframe">{$mu_moon_list}</a></div></td>
    </tr>
	<tr>
       	<td><div align="center"><a href="?page=messagelist" target="Hauptframe">{$mu_mess_list}</a></div></td>
    </tr>
	<tr>
       	<td><div align="center"><a href="?page=accountdata" target="Hauptframe">{$mu_info_account_page}</a></div></td>
    </tr>
	<tr>
       	<td><div align="center"><a href="?page=search" target="Hauptframe">{$mu_search_page}</a></div></td>
    </tr>
{/if}	
{if $ToolsCanUse == 1}
	<tr>
		<td><img src="styles/skins/darkness/gfx/user-menu.jpg" width="110" height="40" alt=""></td>
	</tr>
   	<tr>
		<td><div align="center"><a href="javascript:void(0);"><font color="lime">{$mu_tools}</font></a></div></td>
   	</tr>
	<tr>
       	<td><div align="center"><a href="?page=globalmessage" target="Hauptframe">{$mu_global_message}</a></div></td>
   	</tr>
   	<tr>
       	<td><div align="center"><a href="?page=password" target="Hauptframe">{$mu_md5_encripter}</a></div></td>
   	</tr>
   	<tr>
      	<td><div align="center"><a href="?page=statsupdate" target="Hauptframe" onClick=" return confirm('{$mu_mpu_confirmation}');">{$mu_manual_points_update}</a></div></td>
</table>
{/if}
</div>
</div>
{include file="adm/overall_footer.tpl"}