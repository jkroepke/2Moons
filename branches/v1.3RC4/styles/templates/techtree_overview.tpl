{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table style="min-width:569px;width:569px;">
{foreach item=TechInfo from=$TechTreeList}
{if !is_array($TechInfo)}
<tr>
	<th>{$TechInfo}</th>
	<th>{$tt_requirements}</th>
</tr>
{else}
<tr>
	<td><a href="javascript:OpenPopup('game.php?page=infos&gid={$TechInfo.id}', '', 640, 510);">{$TechInfo.name}</a></td>
	<td>
	{if $TechInfo.need}
		{foreach item=NeedLevel from=$TechInfo.need.{$TechInfo.id}}
			{if $NeedLevel.own >= $NeedLevel.count}
				<span style="color:#00ff00;">{$LNG.{$NeedLevel.id}} ({$tt_lvl}{$NeedLevel.own}/{$NeedLevel.count})</span><br>
			{else}
				<span style="color:#ff0000;">{$LNG.{$NeedLevel.id}} ({$tt_lvl}{$NeedLevel.own}/{$NeedLevel.count})</span><br>
			{/if}
		{/foreach}
	{/if}
	</td>
</tr>
{/if}
{/foreach}
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}