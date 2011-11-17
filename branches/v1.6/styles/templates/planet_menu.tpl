</div>
<div id="planet_menu">
	<div id="planet_menu_header"><a href="javascript:ShowPlanetMenu()" id="planet_menu_link">[X] {lang}show_planetmenu{/lang}</a></div>
	<div id="planet_menu_content"{if $is_pmenu == 0} style="display:none;"{/if}>
		<ul>
			{foreach key=PlanetID item=PlanetInfo from=$PlanetMenu}
			<li>
				<a href="{$PlanetInfo.url}" title="{$PlanetInfo.name}">
					<img src="{$dpath}planeten/small/s_{$PlanetInfo.image}.jpg" alt="{$PlanetInfo.name}">
					<br>
					{if $PlanetID == $current_pid}
					<span style="color:#FFFF00;" class="planetname">{$PlanetInfo.name}</span>
					<br><span style="color:#FE9A2E;">[{$PlanetInfo.galaxy}:{$PlanetInfo.system}:{$PlanetInfo.planet}]</span>
					{else}
					{if $PlanetInfo.ptype == 3}<span style="color:#CCCCCC">{else}<span style="color:#2E9AFE">{/if}{$PlanetInfo.name}</span>
					<br><span style="color:#58FA58;">[{$PlanetInfo.galaxy}:{$PlanetInfo.system}:{$PlanetInfo.planet}]</span>
					{/if}
					<br><span id="planet_{$PlanetID}"></span>
				</a>
			</li>
			{/foreach}
		</ul>
	</div>
</div>
<script type="text/javascript">
planetmenu	= {$Scripttime};
initPlanetMenu();
</script>