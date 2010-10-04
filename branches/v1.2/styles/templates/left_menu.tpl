<div id="leftmenu">
	<ul id="menu">
		<li style="background-image: url('{$dpath}img/menu-top.png');height:100px;cursor:pointer" onclick="document.location = './game.php?page=changelog';"></li>
		<li style="background-image: url('{$dpath}img/menu_wirt.png');height:30px;"></li>
		<li><a href="?page=overview">{$lm_overview}</a></li>
		<li><a href="?page=imperium">{$lm_empire}</a></li>
		<li><a href="?page=buildings&amp;mode=research">{$lm_research}</a></li>
		<li><a href="?page=buildings">{$lm_buildings}</a></li>
		<li><a href="?page=buildings&amp;mode=fleet">{$lm_shipshard}</a></li>
		<li><a href="?page=buildings&amp;mode=defense">{$lm_defenses}</a></li>
		<li><a href="?page=officier">{$lm_officiers}</a></li>
		<li><a href="?page=trader">{$lm_trader}</a></li>
		<li><a href="?page=fleet">{$lm_fleet}</a></li>
		<li><a href="?page=techtree">{$lm_technology}</a></li>
		<li><a href="?page=resources">{$lm_resources}</a></li>

		<li style="background-image: url('{$dpath}img/menu_com.png');height:30px;"></li>
		<li><a href="?page=galaxy">{$lm_galaxy}</a></li>
		<li><a href="?page=alliance">{$lm_alliance}</a></li>
		<li><a href="{$forum_url}" target="forum">{$lm_forums}</a></li>
		<li><a href="?page=statistics">{$lm_statistics}</a></li>
		<li><a href="?page=records">{$lm_records}</a></li>
		<li><a href="?page=topkb">{$lm_topkb}</a></li>
		<li><a href="?page=search">{$lm_search}</a></li>
		<li><a href="?page=chat">{$lm_chat}</a></li>
		<li><a href="?page=support">{$lm_support}</a></li>
		<li><a href="?page=faq">{$lm_faq}</a></li>
		<li><a href="?page=banned">{$lm_banned}</a></li>
		<li><a href="./?page=rules" target="forum">{$lm_rules}</a></li>
		<li><a href="?page=battlesim">{$lm_battlesim}</a></li>

		<li style="background-image: url('{$dpath}img/menu_acc.png');height:30px;"></li>
		<li><a href="?page=messages">{$lm_messages}{if $new_message > 0}<span id="newmes"> (<span id="newmesnum">{$new_message}</span>)</span>{/if}</a></li>
		<li><a href="javascript:OpenPopup('?page=notes','{$lm_notes}', 720, 300);">{$lm_notes}</a></li>
		<li><a href="?page=buddy">{$lm_buddylist}</a></li>
		<li><a href="?page=options">{$lm_options}</a></li>
		<li><a href="?page=logout">{$lm_logout}</a></li>    
		{if $authlevel > 0}
		<li><a href="./admin.php" style="color:lime">{$lm_administration} ({$smarty.const.VERSION})</a></li>
		{/if}
		<li style="background-image: url('{$dpath}img/menu-foot.png');height:30px;"></li>
	</ul>
</div>