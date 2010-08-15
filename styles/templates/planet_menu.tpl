<div id="menu2" {if $is_pmenu == 0}style="display:none;"{/if}>
{foreach key=PlanetID item=PlanetInfo from=$PlanetMenu}
	<table>
		<tr>
			<td {if $PlanetID != $current_pid}class="transparent"{else} style="width:100px;"{/if}>
			<a href="{$PlanetInfo.url}" title="{$PlanetInfo.name}">
				<img src="{$dpath}planeten/small/s_{$PlanetInfo.image}.jpg" height="35" width="35" alt="{$PlanetInfo.name}">
				<br>
				{if $PlanetID == $current_pid}
				<span style="color:#FFFF00;" class="planetname">{$PlanetInfo.name}</span>
				<br><span style="color:#FE9A2E;">[{$PlanetInfo.galaxy}:{$PlanetInfo.system}:{$PlanetInfo.planet}]</span>
				{else}
				{if $PlanetInfo.ptype == 3}<span style="color:#CCCCCC">{else}<span style="color:#2E9AFE">{/if}{$PlanetInfo.name}</span>
				<br><span style="color:#58FA58;">[{$PlanetInfo.galaxy}:{$PlanetInfo.system}:{$PlanetInfo.planet}]</span>
				{/if}
				{if $PlanetInfo.Buildtime}
				<br><span id="time_{$PlanetID}">{$PlanetInfo.Buildtime}</span>
				<script type="text/javascript">var si_{$PlanetID} = window.setInterval('pretty_time_update("time_{$PlanetID}");', 1000);</script>
				{/if}
			</a>
			</td>
		</tr>
	</table>
{/foreach}
</div>
<div style="text-align:right;font-weight:bold;position:absolute;top:3px;right:3px;"><a href="#" onclick="$('#menu2:visible').hide('blind', {}, 500);$('#menu2:hidden').show('blind', {}, 500);">[X] {$show_planetmenu}</a></div>