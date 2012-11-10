{include file="overall_header.tpl"}
<div id="leftmenu">
	<ul id="menu">
		<li style="background-image: url('./styles/theme/gow/img/menu-top.png');height:100px;"></li>
		<li><a href="javascript:void(0);"><span style="color:lime">{$LNG.mu_general}</span></a></li>
		{if allowedTo('ShowInformationPage')}<li><a href="?page=infos" target="Hauptframe">{$LNG.mu_game_info}</a></li>{/if}
		{if allowedTo('ShowConfigBasicPage')}<li><a href="?page=config" target="Hauptframe">{$LNG.mu_settings}</a></li>{/if}
		{if allowedTo('ShowConfigUniPage')}<li><a href="?page=configuni" target="Hauptframe">{$LNG.mu_unisettings}</a></li>{/if}
		{if allowedTo('ShowChatConfigPage')}<li><a href="?page=chat" target="Hauptframe">{$LNG.mu_chat}</a></li>{/if}
		{if allowedTo('ShowTeamspeakPage')}<li><a href="?page=teamspeak" target="Hauptframe">{$LNG.mu_ts_options}</a></li>{/if}
		{if allowedTo('ShowFacebookPage')}<li><a href="?page=facebook" target="Hauptframe">{$LNG.mu_fb_options}</a></li>{/if}
		{if allowedTo('ShowModulePage')}<li><a href="?page=module" target="Hauptframe">{$LNG.mu_module}</a></li>{/if}
		{if allowedTo('ShowDisclamerPage')}<li><a href="?page=disclamer" target="Hauptframe">{$LNG.mu_disclamer}</a></li>{/if}
		{if allowedTo('ShowStatsPage')}<li><a href="?page=statsconf" target="Hauptframe">{$LNG.mu_stats_options}</a></li>{/if}
		{if allowedTo('ShowVertifyPage')}<li><a href="?page=vertify" target="Hauptframe">{$LNG.mu_vertify}</a></li>{/if}
		{if allowedTo('ShowCronjobPage')}<li><a href="?page=cronjob" target="Hauptframe">{$LNG.mu_cronjob}</a></li>{/if}
		<li><a href="javascript:void(0);"><span style="color:lime">{$LNG.mu_users_settings}</span></a></li>
		{if allowedTo('ShowCreatorPage')}<li><a href="?page=create" target="Hauptframe">{$LNG.new_creator_title}</a></li>{/if}
		{if allowedTo('ShowAccountEditorPage')}<li><a href="?page=accounteditor" target="Hauptframe">{$LNG.mu_add_delete_resources}</a></li>{/if}
		{if allowedTo('ShowBanPage')}<li><a href="?page=bans" target="Hauptframe">{$LNG.mu_ban_options}</a></li>{/if}
		{if allowedTo('ShowGiveawayPage')}<li><a href="?page=giveaway" target="Hauptframe">{$LNG.mu_giveaway}</a></li>{/if}
		<li><a href="javascript:void(0);"><span style="color:lime">{$LNG.mu_observation}</span></a></li>
		{if allowedTo('ShowSearchPage')}<li><a href="?page=search&amp;search=online&amp;minimize=on" target="Hauptframe">{$LNG.mu_connected}</a></li>{/if}
		{if allowedTo('ShowSupportPage')}<li><a href="?page=support" target="Hauptframe">{$LNG.mu_support}{if $supportticks != 0} ({$supportticks}){/if}</a></li>{/if}
		{if allowedTo('ShowActivePage')}<li><a href="?page=active" target="Hauptframe">{$LNG.mu_vaild_users}</a></li>{/if}
		{if allowedTo('ShowSearchPage')}<li><a href="?page=search&amp;search=p_connect&amp;minimize=on" target="Hauptframe">{$LNG.mu_active_planets}</a></li>{/if}
		{if allowedTo('ShowFlyingFleetPage')}<li><a href="?page=fleets" target="Hauptframe">{$LNG.mu_flying_fleets}</a></li>{/if}
		{if allowedTo('ShowNewsPage')}<li><a href="?page=news" target="Hauptframe">{$LNG.mu_news}</a></li>{/if}
		{if allowedTo('ShowSearchPage')}<li><a href="?page=search&amp;search=users&amp;minimize=on" target="Hauptframe">{$LNG.mu_user_list}</a></li>{/if}
		{if allowedTo('ShowSearchPage')}<li><a href="?page=search&amp;search=planet&amp;minimize=on" target="Hauptframe">{$LNG.mu_planet_list}</a></li>{/if}
		{if allowedTo('ShowSearchPage')}<li><a href="?page=search&amp;search=moon&amp;minimize=on" target="Hauptframe">{$LNG.mu_moon_list}</a></li>{/if}
		{if allowedTo('ShowMessageListPage')}<li><a href="?page=messagelist" target="Hauptframe">{$LNG.mu_mess_list}</a></li>{/if}
		{if allowedTo('ShowAccountDataPage')}<li><a href="?page=accountdata" target="Hauptframe">{$LNG.mu_info_account_page}</a></li>{/if}
		{if allowedTo('ShowSearchPage')}<li><a href="?page=search" target="Hauptframe">{$LNG.mu_search_page}</a></li>{/if}
		{if allowedTo('ShowMultiIPPage')}<li><a href="?page=multiips" target="Hauptframe">{$LNG.mu_multiip_page}</a></li>{/if}
		<li><a href="javascript:void(0);"><span style="color:lime">{$LNG.mu_tools}</span></a></li>
		{if allowedTo('ShowLogPage')}<li><a href="?page=log" target="Hauptframe">{$LNG.mu_logs}</a></li>{/if}
		{if allowedTo('ShowSendMessagesPage')}<li><a href="?page=globalmessage" target="Hauptframe">{$LNG.mu_global_message}</a></li>{/if}
		{if allowedTo('ShowPassEncripterPage')}<li><a href="?page=password" target="Hauptframe">{$LNG.mu_md5_encripter}</a></li>{/if}
		{if allowedTo('ShowStatUpdatePage')}<li><a href="?page=statsupdate" target="Hauptframe" onClick=" return confirm('{$LNG.mu_mpu_confirmation}');">{$LNG.mu_manual_points_update}</a></li>{/if}
		{if allowedTo('ShowClearCachePage')}<li><a href="?page=clearcache" target="Hauptframe">{$LNG.mu_clear_cache}</a></li>{/if}
		<li style="background-image: url('./styles/theme/gow/img/menu-foot.png');height:30px;"></li>
	</ul>
</div>
{include file="overall_footer.tpl"}