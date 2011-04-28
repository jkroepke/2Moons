<nav>
	<ul id="menu">
		<li style="background-image: url('{$dpath}img/menu-top.png');height:100px;cursor:pointer" onclick="document.location = './game.php?page=changelog';"></li>
		<li style="background-image: url('{$dpath}img/menu_wirt.png');height:30px;"></li>
		<li><a href="?page=overview">{$lm_overview}</a></li>
		{if !CheckModule(15)}<li><a href="?page=imperium">{$lm_empire}</a></li>{/if}
		{if !CheckModule(3)}<li><a href="?page=buildings&amp;mode=research">{$lm_research}</a></li>{/if}
		{if !CheckModule(2)}<li><a href="?page=buildings">{$lm_buildings}</a></li>{/if}
		{if !CheckModule(4)}<li><a href="?page=buildings&amp;mode=fleet">{$lm_shipshard}</a></li>{/if}
		{if !CheckModule(5)}<li><a href="?page=buildings&amp;mode=defense">{$lm_defenses}</a></li>{/if}
		{if !CheckModule(18) && !CheckModule(8)}<li><a href="?page=officier">{$lm_officiers}</a></li>{/if}
		{if !CheckModule(13)}<li><a href="?page=trader">{$lm_trader}</a></li>{/if}
		{if !CheckModule(38)}<li><a href="?page=fleettrader">{$lm_fleettrader}</a></li>{/if}
		{if !CheckModule(9)}<li><a href="?page=fleet">{$lm_fleet}</a></li>{/if}
		{if !CheckModule(28)}<li><a href="?page=techtree">{$lm_technology}</a></li>{/if}
		{if !CheckModule(23)}<li><a href="?page=resources">{$lm_resources}</a></li>{/if}

		<li style="background-image: url('{$dpath}img/menu_com.png');height:30px;"></li>
		{if !CheckModule(11)}<li><a href="?page=galaxy">{$lm_galaxy}</a></li>{/if}
		{if !CheckModule(0)}<li><a href="?page=alliance">{$lm_alliance}</a></li>{/if}
		{if !empty($forum_url)}<li><a href="{$forum_url}" target="forum">{$lm_forums}</a></li>{/if}
		{if !CheckModule(25)}<li><a href="?page=statistics">{$lm_statistics}</a></li>{/if}
		{if !CheckModule(22)}<li><a href="?page=records">{$lm_records}</a></li>{/if}
		{if !CheckModule(12)}<li><a href="?page=topkb">{$lm_topkb}</a></li>{/if}
		{if !CheckModule(26)}<li><a href="?page=search">{$lm_search}</a></li>{/if}
		{if !CheckModule(7)}<li><a href="?page=chat">{$lm_chat}</a></li>{/if}
		{if !CheckModule(27)}<li><a href="?page=support">{$lm_support}</a></li>{/if}
		<li><a href="?page=faq">{$lm_faq}</a></li>
		{if !CheckModule(21)}<li><a href="?page=banned">{$lm_banned}</a></li>{/if}
		<li><a href="./?page=rules" target="forum">{$lm_rules}</a></li>
		{if !CheckModule(39)}<li><a href="?page=battlesim">{$lm_battlesim}</a></li>{/if}

		<li style="background-image: url('{$dpath}img/menu_acc.png');height:30px;"></li>
		{if !CheckModule(16)}<li><a href="?page=messages">{$lm_messages}{if $new_message > 0}<span id="newmes"> (<span id="newmesnum">{$new_message}</span>)</span>{/if}</a></li>{/if}
		{if !CheckModule(17)}<li><a href="javascript:OpenPopup('?page=notes','{$lm_notes}', 720, 300);">{$lm_notes}</a></li>{/if}
		{if !CheckModule(6)}<li><a href="?page=buddy">{$lm_buddylist}</a></li>{/if}
		<li><a href="?page=options">{$lm_options}</a></li>
		<li><a href="?page=logout">{$lm_logout}</a></li>
		{if $authlevel > 0}<li><a href="./admin.php" style="color:lime">{$lm_administration} ({$VERSION})</a></li>{/if}
		<li style="background-image: url('{$dpath}img/menu-foot.png');height:30px;"></li>
	</ul>
</nav>