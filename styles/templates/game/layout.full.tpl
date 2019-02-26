{include file="main.header.tpl" bodyclass="full"}

<div class="wrapper">

	<top>
		<div class="fixed">
		</div>
	</top>

	<logo>
		<div class="fixed">
			<a href="https://github.com/steemnova/steemnova/commits/master" target="copy"><img src="styles/resource/images/meta.png" /></a>
		</div>
	</logo>
	
	<header>
		<div class="fixed">
			{include file="main.topnav.tpl"}
		</div>
	</header>

	<input type="checkbox" id="toggle-menu" role="button">
	<menu>
		<div class="fixed">
			{include file="main.navigation.tpl"}
		</div>
	</menu>
	
	<content>
		{if $hasAdminAccess}
		<div class="globalWarning">
		{$LNG.admin_access_1} <a id="drop-admin">{$LNG.admin_access_link}</a>{$LNG.admin_access_2}
		</div>
		{/if}
		{if $closed}
		<div class="infobox">{$LNG.ov_closed}</div>
		{elseif $delete}
		<div class="infobox">{$delete}</div>
		{elseif $vacation}
		<div class="infobox">{$LNG.tn_vacation_mode} {$vacation}</div>
		{/if}
		
		{block name="content"}{/block}
		<table class="hack"></table>
	</content>

	<footer>
		{foreach $cronjobs as $cronjob}<img src="cronjob.php?cronjobID={$cronjob}" alt="">{/foreach}
		
		{include file="main.footer.tpl" nocache}
	</footer>
</div>

</body>
</html>