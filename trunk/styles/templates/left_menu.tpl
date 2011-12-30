<div id="leftmenu">
	<ul id="menu">
		<li class="menu-head"><a href="?page=changelog">Changelog</a></li>
		<li class="menucat1-head"></li>
		<li><a href="?page=overview">{lang}lm_overview{/lang}</a></li>
		{if isModulAvalible($smarty.const.MODUL_IMPERIUM)}<li><a href="?page=imperium">{lang}lm_empire{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_RESEARCH)}<li><a href="?page=buildings&amp;mode=research">{lang}lm_research{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_BUILDING)}<li><a href="?page=buildings">{lang}lm_buildings{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_SHIPYARD_FLEET)}<li><a href="?page=buildings&amp;mode=fleet">{lang}lm_shipshard{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_SHIPYARD_DEFENSIVE)}<li><a href="?page=buildings&amp;mode=defense">{lang}lm_defenses{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_OFFICIER) || isModulAvalible($smarty.const.MODUL_DMEXTRAS)}<li><a href="?page=officier">{lang}lm_officiers{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_TRADER)}<li><a href="?page=trader">{lang}lm_trader{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_FLEET_TRADER)}<li><a href="?page=fleettrader">{lang}lm_fleettrader{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_TRADER)}<li><a href="?page=fleet">{lang}lm_fleet{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_TECHTREE)}<li><a href="?page=techtree">{lang}lm_technology{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_RESSOURCE_LIST)}<li><a href="?page=resources">{lang}lm_resources{/lang}</a></li>{/if}
		<li class="menucat2-head"></li>
		{if isModulAvalible($smarty.const.MODUL_GALAXY)}<li><a href="?page=galaxy">{lang}lm_galaxy{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_ALLIANCE)}<li><a href="?page=alliance">{lang}lm_alliance{/lang}</a></li>{/if}
		{if !empty($forum_url)}<li><a href="{$forum_url}" target="forum">{lang}lm_forums{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_STATISTICS)}<li><a href="?page=statistics">{lang}lm_statistics{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_RECORDS)}<li><a href="?page=records">{lang}lm_records{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_BATTLEHALL)}<li><a href="?page=topkb">{lang}lm_topkb{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_SEARCH)}<li><a href="?page=search">{lang}lm_search{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_CHAT)}<li><a href="?page=chat">{lang}lm_chat{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_SUPPORT)}<li><a href="?page=support">{lang}lm_support{/lang}</a></li>{/if}
		<li><a href="?page=faq">{lang}lm_faq{/lang}</a></li>
		{if isModulAvalible($smarty.const.MODUL_BANLIST)}<li><a href="?page=banned">{lang}lm_banned{/lang}</a></li>{/if}
		<li><a href="./?page=rules" target="rules">{lang}lm_rules{/lang}</a></li>
		{if isModulAvalible($smarty.const.MODUL_SIMULATOR)}<li><a href="?page=battlesim">{lang}lm_battlesim{/lang}</a></li>{/if}

		<li class="menucat3-head"></li>
		{if isModulAvalible($smarty.const.MODUL_MESSAGES)}<li><a href="?page=messages">{lang}lm_messages{/lang}{if $new_message > 0}<span id="newmes"> (<span id="newmesnum">{$new_message}</span>)</span>{/if}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_NOTICE)}<li><a href="javascript:OpenPopup('?page=notes','{lang}lm_notes{/lang}', 720, 300);">{lang}lm_notes{/lang}</a></li>{/if}
		{if isModulAvalible($smarty.const.MODUL_BUDDYLIST)}<li><a href="?page=buddy">{lang}lm_buddylist{/lang}</a></li>{/if}
		<li><a href="?page=options">{lang}lm_options{/lang}</a></li>
		<li><a href="?page=logout">{lang}lm_logout{/lang}</a></li>
		{if $authlevel > 0}<li><a href="./admin.php" style="color:lime">{lang}lm_administration{/lang} ({$VERSION})</a></li>{/if}
		<li class="menu-footer"></li>
	</ul>
</div>