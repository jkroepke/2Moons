{include file="adm/overall_header.tpl"}
<div id='leftmenu'>
<div id='menu'>
<img src="./styles/images/xgp-logo.png" alt="" style="height:50px;width:100px;position:absolute;top:10px;left:48px;">
<table width="100%" cellspacing="0" cellpadding="0">
   	<tr>
       	<td><div align="center"><a href="javascript:void(0);"><font color="lime">{$mu_general}</font></a></div></td>
   	</tr>
{if $rights.ShowInformationPage}
	<tr>
       	<td><div align="center"><a href="?page=infos" target="Hauptframe">{$mu_game_info}</a></div></td>
   	</tr>
{/if}
{if $rights.ShowConfigPage}
   	<tr>
       	<td><div align="center"><a href="?page=config" target="Hauptframe">{$mu_settings}</a></div></td>
   	</tr>
{/if}
{if $rights.ShowTeamspeakPage}
	<tr>
       	<td><div align="center"><a href="?page=teamspeak" target="Hauptframe">{$mu_ts_options}</a></div></td>
   	</tr>
{/if}
{if $rights.ShowFacebookPage}
	<tr>
      	<td><div align="center"><a href="?page=facebook" target="Hauptframe">{$mu_fb_options}</a></div></td>
    </tr>
{/if}
{if $rights.ShowModulePage}
	<tr>
      	<td><div align="center"><a href="?page=module" target="Hauptframe">{$mu_module}</a></div></td>
   	</tr>
	<tr>
{/if}
{if $rights.ShowStatsPage}
       	<td><div align="center"><a href="?page=statsconf" target="Hauptframe">{$mu_stats_options}</a></div></td>
   	</tr>
    <tr>
{/if}
{if $rights.ShowUpdatePage}
        <td><div align="center"><a href="?page=update" target="Hauptframe">{$mu_update}</a></div></td>
    </tr>
{/if}
{if $rights.ShowModVersionPage}
    <tr>
        <td><div align="center"><a href="?page=mods" target="Hauptframe">{$mu_mod_update}</a></div></td>
    </tr>
{/if}
	<tr>
		<td><img src="styles/skins/darkness/gfx/user-menu.jpg" width="110" height="40" alt=""></td>
	</tr>
	<tr>
        <td><div align="center"><a href="javascript:void(0);"><font color="lime">{$mu_users_settings}</font></a></div></td>
    </tr>
{if $rights.ShowCreatorPage}
	<tr>
       	<td><div align="center"><a href="?page=create" target="Hauptframe">{$new_creator_title}</a></div></td>
   	</tr>
{/if}
{if $rights.ShowAccountEditorPage}
    <tr>
       	<td><div align="center"><a href="?page=accounteditor" target="Hauptframe">{$mu_add_delete_resources}</a></div></td>
   	</tr>
{/if}
{if $rights.ShowBanPage}
	<tr>
       	<td><div align="center"><a href="?page=bans" target="Hauptframe">{$mu_ban_options}</a></div></td>
    </tr>
{/if}
	<tr>
		<td><img src="styles/skins/darkness/gfx/user-menu.jpg" width="110" height="40" alt=""></td>
	</tr>
	<tr>
     	<td><div align="center"><a href="javascript:void(0);"><font color="lime">{$mu_observation}</font></a></div></td>
   	</tr>
{if $rights.ShowSearchPage}
	<tr>
       	<td><div align="center"><a href="?page=search&amp;search=online&amp;minimize=on" target="Hauptframe">{$mu_connected}</a></div></td>
   	</tr>
{/if}
{if $rights.ShowSupportPage}
	<tr>
       	<td><div align="center"><a href="?page=support" target="Hauptframe">{$mu_support}</a></div></td>
   	</tr>
{/if}
{if $rights.ShowActivePage}
	<tr>
        <td><div align="center"><a href="?page=active" target="Hauptframe">{$mu_vaild_users}</a></div></td>
    </tr>
{/if}
{if $rights.ShowSearchPage}
	<tr>
       	<td><div align="center"><a href="?page=search&amp;search=p_connect&amp;minimize=on" target="Hauptframe">{$mu_active_planets}</a></div></td>
    </tr>
{/if}
{if $rights.ShowFlyingFleetPage}
    <tr>
       	<td><div align="center"><a href="?page=fleets" target="Hauptframe">{$mu_flying_fleets}</a></div></td>
    </tr>
{/if}
{if $rights.ShowNewsPage}
    <tr>
       	<td><div align="center"><a href="?page=news" target="Hauptframe">{$mu_news}</a></div></td>
    </tr>
{/if}
{if $rights.ShowSearchPage}
	<tr>
       	<td><div align="center"><a href="?page=search&amp;search=users&amp;minimize=on" target="Hauptframe">{$mu_user_list}</a></div></td>
    </tr>
{/if}
{if $rights.ShowSearchPage}
	<tr>
       	<td><div align="center"><a href="?page=search&amp;search=planet&amp;minimize=on" target="Hauptframe">{$mu_planet_list}</a></div></td>
    </tr>
{/if}
{if $rights.ShowSearchPage}
	<tr>
       	<td><div align="center"><a href="?page=search&amp;search=moon&amp;minimize=on" target="Hauptframe">{$mu_moon_list}</a></div></td>
    </tr>
{/if}
{if $rights.ShowMessageListPage}
	<tr>
       	<td><div align="center"><a href="?page=messagelist" target="Hauptframe">{$mu_mess_list}</a></div></td>
    </tr>
{/if}
{if $rights.ShowAccountDataPage}
	<tr>
       	<td><div align="center"><a href="?page=accountdata" target="Hauptframe">{$mu_info_account_page}</a></div></td>
    </tr>
{/if}
{if $rights.ShowSearchPage}
	<tr>
       	<td><div align="center"><a href="?page=search" target="Hauptframe">{$mu_search_page}</a></div></td>
    </tr>
{/if}	
	<tr>
		<td><img src="styles/skins/darkness/gfx/user-menu.jpg" width="110" height="40" alt=""></td>
	</tr>
   	<tr>
		<td><div align="center"><a href="javascript:void(0);"><font color="lime">{$mu_tools}</font></a></div></td>
   	</tr>
{if $rights.ShowSendMessagesPage}
	<tr>
       	<td><div align="center"><a href="?page=globalmessage" target="Hauptframe">{$mu_global_message}</a></div></td>
   	</tr>
{/if}
{if $rights.ShowPassEncripterPage}
   	<tr>
       	<td><div align="center"><a href="?page=password" target="Hauptframe">{$mu_md5_encripter}</a></div></td>
   	</tr>
{/if}
{if $rights.ShowStatUpdatePage}
   	<tr>
      	<td><div align="center"><a href="?page=statsupdate" target="Hauptframe" onClick=" return confirm('{$mu_mpu_confirmation}');">{$mu_manual_points_update}</a></div></td>
	</tr>
{/if}
</table>
</div>
</div>
{include file="adm/overall_footer.tpl"}