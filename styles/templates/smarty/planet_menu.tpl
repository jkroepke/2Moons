<div id="menu2">
<center>
{foreach key=PlanetID item=PlanetInfo from=$PlanetMenu}
	<table cellspacing="3" width="120">
	<tr>
	{if $PlanetID == $current_pid}<th>{else}<td>{/if}
	<div align="center">
	<a href="{$PlanetInfo.url}" title="{$PlanetInfo.name}">
	<img src="{$dpath}planeten/small/s_{$PlanetInfo.image}.jpg" border="0" height="35" width="35" alt="{$PlanetInfo.name}">
	<br>
	{if $PlanetID == $current_pid}
	<font color="#FFFF00">{$PlanetInfo.name}</font>
	<font color="#FE9A2E"><br>[{$PlanetInfo.galaxy}:{$PlanetInfo.system}:{$PlanetInfo.planet}]</font>
	{else}
	{if $PlanetInfo.ptype == 3}<font color="#CCCCCC">{else}<font color="#2E9AFE">{/if}{$PlanetInfo.name}</font>
	<font color="#58FA58"><br>[{$PlanetInfo.galaxy}:{$PlanetInfo.system}:{$PlanetInfo.planet}]</font>
	{/if}
	{if $PlanetInfo.Buildtime}
		<br><span id="time_{$PlanetID}">{$PlanetInfo.Buildtime}</span>
		<script type="text/javascript">var si_{$PlanetID} = window.setInterval('pretty_time_update("time_{$PlanetID}");', 1000);</script>
	{/if}
	</a>
	</div>
	{if $PlanetID == $current_pid}</th>{else}</td>{/if}
	</tr>
	</table>
{/foreach}
</center>
</div>