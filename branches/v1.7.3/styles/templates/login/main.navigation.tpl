<header>
	<nav>
		<ul id="menu">
			<li><a href="index.php">{$LNG.menu_index}</a></li>
			<li><a href="index.php?page=board" target="board">{$LNG.forum}</a></li>
			<li><a href="index.php?page=news">{$LNG.menu_news}</a></li>
			<li><a href="index.php?page=rules">{$LNG.menu_rules}</a></li>
			<li><a href="index.php?page=battleHall">{$LNG.menu_battlehall}</a></li>
			<li><a href="index.php?page=banList">{$LNG.menu_banlist}</a></li>
			<li><a href="index.php?page=disclamer">{$LNG.menu_disclamer}</a></li>
		</ul>
	</nav>
	<nav>
		{if count($languages) > 1}
		<ul id="language">
		{foreach $languages as $langKey => $langName}
		<li><a href="?lang={$langKey}" rel="alternate" hreflang="{$langKey}" title="{$langName}"><span class="flags {$langKey}">{$langName}</span></a></li>
		{/foreach}
		</ul>
		{/if}
	</nav>
</header>