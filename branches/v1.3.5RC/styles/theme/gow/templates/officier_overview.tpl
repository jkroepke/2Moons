{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
	{if $ExtraDMList}
    <table>	
	    <tr>
			<th colspan="2">{$of_dm_trade}</th>
		</tr>
		{foreach item=ExtraDMInfo from=$ExtraDMList}
		<tr>
			<td rowspan="2" style="width:120px;">
				<a href="#" onclick="return Dialog.info({$ExtraDMInfo.id});">
					<img src="{$dpath}gebaeude/{$ExtraDMInfo.id}.gif" alt="{$ExtraDMInfo.name}" width="120" height="120">
				</a>
			</td>
			<th>
				<a href="#" onclick="return Dialog.info({$ExtraDMInfo.id});">{$ExtraDMInfo.name}</a>
			</th>
		</tr>
		<tr>
			<td>
				<table style="width:100%">
					<tbody>
						<tr>
							<td class="transparent left" style="width:90%;padding:10px;">{$ExtraDMInfo.desc}<br><br>{$Darkmatter}: {if $ExtraDMInfo.isok}<span style="color:lime">{$ExtraDMInfo.price}</span>{else}<span style="color:#FF0000">{$ExtraDMInfo.price}</span>{/if} {$in_dest_durati}: <span style="color:lime">{$ExtraDMInfo.time}</span></td>
							<td class="transparent" style="vertical-align:middle;width:100px">
							{if $ExtraDMInfo.active > 0}
							{$of_still}<br>
							<div id="time_{$ExtraDMInfo.id}" class="z">-</div>
							{$of_active}{if $ExtraDMInfo.isok}
							<br>
							<a href="?page=officier&amp;extra={$ExtraDMInfo.id}&amp;action=send">{$of_update}</a>{/if}
							{else}{if $ExtraDMInfo.isok}
							<a href="?page=officier&amp;extra={$ExtraDMInfo.id}&amp;action=send"><span style="color:#00FF00">{$of_recruit}</span></a>{else}<span style="color:#FF0000">{$of_recruit}</span>{/if}{/if}
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		{/foreach}
    </table>
	<br><br>
	{/if}
	{if $OfficierList}
	<table>	
		<tr>
			<th colspan="2">{$of_available_points} {$user_darkmatter} {$of_darkmatter}</th>
		</tr>
		{foreach item=OfficierInfo from=$OfficierList}
		<tr>
			<td rowspan="2" style="width:120px;">
				<a href="#" onclick="return Dialog.info({$OfficierInfo.id})">
					<img src="{$dpath}gebaeude/{$OfficierInfo.id}.jpg" alt="{$OfficierInfo.name}" width="120" height="120">
				</a>
			</td>
			<th>
				<a href="#" onclick="return Dialog.info({$OfficierInfo.id})">{$OfficierInfo.name}</a> ({$of_lvl} {$OfficierInfo.level})
			</th>
		</tr>
		<tr>
			<td>
				<table style="width:100%">
					<tbody>
						<tr>
							<td class="transparent left" style="width:90%;padding:0px 10px 10px 10px;">{$OfficierInfo.desc}<br><br>{$OfficierInfo.price}</td>
							<td class="transparent" style="vertical-align:middle;width:100px">
							{if $OfficierInfo.Result == 1}
								{if $OfficierInfo.isbuyable}
									<a href="?page=officier&amp;offi={$OfficierInfo.id}&amp;action=send"><span style="color:#00ff00">{$of_recruit}</span></a>
								{else}<span style="color:red">{$of_recruit}</span>{/if}
							{else}<span style="color:red">{$of_max_lvl}</span>{/if}
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		{/foreach}
    </table>
	{/if}
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}