{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
	{if $ExtraDMList}
    <table width="80%" align="center">
    <tr>
        <td class="c" colspan="3">{$of_dm_trade}</td>
    </tr>
	{foreach item=ExtraDMInfo from=$ExtraDMList}
		<tr>
			<th class="l" rowspan="2" width="120">
				<img border="0" src="{$dpath}gebaeude/{$ExtraDMInfo.id}.gif" alt="{$ExtraDMInfo.name}" align="top" width="120" height="120">
			</th>
			<td class="c" style="color:#FFFFFF;">
				<img src="./styles/images/transparent.gif" alt="" width="0" height="0">&nbsp;{$ExtraDMInfo.name}
			</td>
		</tr>
		<tr>
			<td colspan="1" class="l">
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td style="text-align:left;width:10px"><img src="./styles/images/transparent.gif" alt="" style="width:10px;height:100px"></td>
							<td style="text-align:left;width:90%">{$ExtraDMInfo.desc}<br><br>{$Darkmatter}: {if $ExtraDMInfo.isok}<font color="lime">{$ExtraDMInfo.price}</font>{else}<font color="#FF0000">{$ExtraDMInfo.price}</font>{/if} {$in_dest_durati}: <font color="lime">{$ExtraDMInfo.time}</font></td>
							<td style="text-align:center;vertical-align:middle;width:100px;color:#FFFFFF">
							{if $ExtraDMInfo.active > 0}
							<script type="text/javascript">
							getsectime('time_{$ExtraDMInfo.id}', {$ExtraDMInfo.active});
							</script>
							{$of_still}<br>
							<div id="time_{$ExtraDMInfo.id}" class="z">-</div>
							{$of_active}{if $ExtraDMInfo.isok}
							<br>
							<a href="?page=officier&amp;extra={$ExtraDMInfo.id}&amp;action=send">{$of_update}</a>{/if}
							{else}{if $ExtraDMInfo.isok}
							<a href="?page=officier&amp;extra={$ExtraDMInfo.id}&amp;action=send"><font color="#00FF00">{$of_recruit}</font></a>{else}<font color="#FF0000">{$of_recruit}</font>{/if}{/if}
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2"><img src="./styles/images/transparent.gif" alt="" width="1" height="10"></td>
		</tr>
	{/foreach}
    </table>
	<br><br>
	{/if}
    <table width="80%" align="center">
    <tr>
        <td class="c" colspan="3">{$of_available_points} {$user_darkmatter} {$of_darkmatter}</td>
    </tr>
	{foreach item=OfficierInfo from=$OfficierList}
		<tr>
			<th class="l" rowspan="2" width="120">
				<a href="javascript:info({$OfficierInfo.id});">
					<img border="0" src="styles/images/officiers/{$OfficierInfo.id}.jpg" alt="{$OfficierInfo.name}" align="top" width="120" height="120">
				</a>
			</th>
			<td class="c">
				<img src="./styles/images/transparent.gif" alt="" width="0" height="0">&nbsp;<a href="javascript:info({$OfficierInfo.id});">{$OfficierInfo.name}</a> ({$of_lvl} {$OfficierInfo.level})
			</td>
		</tr>
		<tr>
			<td colspan="1" class="l">
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td style="text-align:left;width:10px"><img src="./styles/images/transparent.gif" alt="" width="0" height="100"></td>
							<td style="text-align:left;width:90%">{$OfficierInfo.desc}</td>
							<td style="text-align:center;vertical-align:middle;width:100px">
							{if $OfficierInfo.Result == 1}
								{if $user_darkmatter >= 1}
									<a href="?page=officier&amp;offi={$OfficierInfo.id}&amp;action=send"><font color="#00ff00">{$of_recruit}</font></a>
								{else}<font color="red">{$of_recruit}</font>{/if}
							{else}<font color="red">{$of_max_lvl}</font>{/if}
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2"><img src="./styles/images/transparent.gif" alt="" width="1" height="10"></td>
		</tr>
	{/foreach}
    </table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}