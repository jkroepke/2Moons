{include file="adm/overall_header.tpl"}
<div id="leftmenu">
	<ul id="menu">
		<li style="background-image: url('./styles/theme/gow/img/menu-top.png');height:100px;"></li>
		<li><a href="javascript:void(0);"><span style="color:lime">{lang}mu_general{/lang}</span></a></li>
		{if allowedTo('ShowInformationPage')}<li><a href="?page=infos" target="Hauptframe">{lang}mu_game_info{/lang}</a></li>{/if}
		{if allowedTo('ShowConfigBasicPage')}<li><a href="?page=config" target="Hauptframe">{lang}mu_settings{/lang}</a></li>{/if}
		{if allowedTo('ShowConfigUniPage')}<li><a href="?page=configuni" target="Hauptframe">{lang}mu_unisettings{/lang}</a></li>{/if}
		{if allowedTo('ShowChatConfigPage')}<li><a href="?page=chat" target="Hauptframe">{lang}mu_chat{/lang}</a></li>{/if}
		{if allowedTo('ShowTeamspeakPage')}<li><a href="?page=teamspeak" target="Hauptframe">{lang}mu_ts_options{/lang}</a></li>{/if}
		{if allowedTo('ShowFacebookPage')}<li><a href="?page=facebook" target="Hauptframe">{lang}mu_fb_options{/lang}</a></li>{/if}
		{if allowedTo('ShowModulePage')}<li><a href="?page=module" target="Hauptframe">{lang}mu_module{/lang}</a></li>{/if}
		{if allowedTo('ShowStatsPage')}<li><a href="?page=statsconf" target="Hauptframe">{lang}mu_stats_options{/lang}</a></li>{/if}
		{if allowedTo('ShowUpdatePage')}<li><a href="?page=update" target="Hauptframe">{lang}mu_update{/lang}</a></li>{/if}
		{if allowedTo('ShowVertifyPage')}<li><a href="?page=vertify" target="Hauptframe">{lang}mu_vertify{/lang}</a></li>{/if}
		<li><a href="javascript:void(0);"><span style="color:lime">{lang}mu_users_settings{/lang}</span></a></li>
		{if allowedTo('ShowCreatorPage')}<li><a href="?page=create" target="Hauptframe">{lang}new_creator_title{/lang}</a></li>{/if}
		{if allowedTo('ShowAccountEditorPage')}<li><a href="?page=accounteditor" target="Hauptframe">{lang}mu_add_delete_resources{/lang}</a></li>{/if}
		{if allowedTo('ShowBanPage')}<li><a href="?page=bans" target="Hauptframe">{lang}mu_ban_options{/lang}</a></li>{/if}
		<li><a href="javascript:void(0);"><span style="color:lime">{lang}mu_observation{/lang}</span></a></li>
		{if allowedTo('ShowSearchPage')}<li><a href="?page=search&amp;search=online&amp;minimize=on" target="Hauptframe">{lang}mu_connected{/lang}</a></li>{/if}
		{if allowedTo('ShowSupportPage')}<li><a href="?page=support" target="Hauptframe">{lang}mu_support{/lang}{if $supportticks != 0} ({$supportticks}){/if}</a></li>{/if}
		{if allowedTo('ShowActivePage')}<li><a href="?page=active" target="Hauptframe">{lang}mu_vaild_users{/lang}</a></li>{/if}
		{if allowedTo('ShowSearchPage')}<li><a href="?page=search&amp;search=p_connect&amp;minimize=on" target="Hauptframe">{lang}mu_active_planets{/lang}</a></li>{/if}
		{if allowedTo('ShowFlyingFleetPage')}<li><a href="?page=fleets" target="Hauptframe">{lang}mu_flying_fleets{/lang}</a></li>{/if}
		{if allowedTo('ShowNewsPage')}<li><a href="?page=news" target="Hauptframe">{lang}mu_news{/lang}</a></li>{/if}
		{if allowedTo('ShowSearchPage')}<li><a href="?page=search&amp;search=users&amp;minimize=on" target="Hauptframe">{lang}mu_user_list{/lang}</a></li>{/if}
		{if allowedTo('ShowSearchPage')}<li><a href="?page=search&amp;search=planet&amp;minimize=on" target="Hauptframe">{lang}mu_planet_list{/lang}</a></li>{/if}
		{if allowedTo('ShowSearchPage')}<li><a href="?page=search&amp;search=moon&amp;minimize=on" target="Hauptframe">{lang}mu_moon_list{/lang}</a></li>{/if}
		{if allowedTo('ShowMessageListPage')}<li><a href="?page=messagelist" target="Hauptframe">{lang}mu_mess_list{/lang}</a></li>{/if}
		{if allowedTo('ShowAccountDataPage')}<li><a href="?page=accountdata" target="Hauptframe">{lang}mu_info_account_page{/lang}</a></li>{/if}
		{if allowedTo('ShowSearchPage')}<li><a href="?page=search" target="Hauptframe">{lang}mu_search_page{/lang}</a></li>{/if}
		{if allowedTo('ShowMultiIPPage')}<li><a href="?page=multiips" target="Hauptframe">{lang}mu_multiip_page{/lang}</a></li>{/if}
		<li><a href="javascript:void(0);"><span style="color:lime">{lang}mu_tools{/lang}</span></a></li>
		{if allowedTo('ShowLogPage')}<li><a href="?page=log" target="Hauptframe">{lang}mu_logs{/lang}</a></li>{/if}
		{if allowedTo('ShowSendMessagesPage')}<li><a href="?page=globalmessage" target="Hauptframe">{lang}mu_global_message{/lang}</a></li>{/if}
		{if allowedTo('ShowPassEncripterPage')}<li><a href="?page=password" target="Hauptframe">{lang}mu_md5_encripter{/lang}</a></li>{/if}
		{if allowedTo('ShowStatUpdatePage')}<li><a href="?page=statsupdate" target="Hauptframe" onClick=" return confirm('{lang}mu_mpu_confirmation{/lang}');">{lang}mu_manual_points_update{/lang}</a></li>{/if}
		{if allowedTo('ShowClearCachePage')}<li><a href="?page=clearcache" target="Hauptframe">{lang}mu_clear_cache{/lang}</a></li>{/if}
		<li style="background-image: url('./styles/theme/gow/img/menu-foot.png');height:30px;"></li>
	</ul>
</div>
{include file="adm/overall_footer.tpl"}