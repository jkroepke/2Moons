{block name="title" prepend}{$LNG.lm_buildings}{/block}
{block name="content"}
{if !empty($Queue)}
<div id="buildlist" class="buildlist">
	<table style="width:760px">
		{foreach $Queue as $List}
		{$elementId = $List.element}
		<tr>
			<td style="width:70%;vertical-align:top;" class="left">
				{$List@iteration}.: 
				{if $RoomIsOk && $CanBuildElement && $BuildInfoList[$elementId].buyable}
				<form class="build_form" action="game.php?page=buildings" method="post">
					<input type="hidden" name="mode" value="build">
					<input type="hidden" name="building" value="{$elementId}">
					<button type="submit" class="build_submit onlist">{$LNG.tech.{$elementId}} {$List.level}{if $List.destroy} {$LNG.bd_dismantle}{/if}</button>
				</form>
				{else}{$LNG.tech.{$elementId}} {$List.level} {if $List.destroy}{$LNG.bd_dismantle}{/if}{/if}
				{if $List@first}
				<br><br><div id="progressbar" data-time="{$List.resttime}"></div>
			</td>
			<td>
				<div id="time" data-time="{$List.time}"><br></div>
				{else}
			</td>
			<td>
				{/if}
				<form action="game.php?page=buildings" method="post" class="build_form">
					<input type="hidden" name="mode" value="cancel">
					<input type="hidden" name="taskId" value="{$List@key}">
					<button type="submit" class="build_submit onlist">{$LNG.bd_cancel}</button>
				</form>
				<br><span style="color:lime" data-time="{$List.endtime}" class="timer">{$List.display}</span>
			</td>
		</tr>
	{/foreach}
	</table>
</div>
{/if}
<table style="width:760px">
	{foreach $BuildInfoList as $elementId => $elementData}
	<tr>
		<td rowspan="2" style="width:120px;">
			<a href="#" onclick="return Dialog.info({$elementId})">
				<img src="{$dpath}gebaeude/{$elementId}.gif" alt="{$LNG.tech.{$elementId}}" width="120" height="120">
			</a>
		</td>
		<th>
			<a href="#" onclick="return Dialog.info({$elementId})">{$LNG.tech.{$elementId}}</a>{if $elementData.level > 0} ({$LNG.bd_lvl} {$elementData.level}{if $elementData.maxLevel != 255}/{$elementData.maxLevel}{/if}){/if}
		</th>
	</tr>
	<tr>
		<td>
			<table style="width:100%">
				<tr>
					<td class="transparent left" style="width:90%;padding:10px;"><p>{$LNG.shortDescription.{$elementId}}</p>
					<p>{foreach $elementData.costResources as $RessID => $RessAmount}
					{$LNG.tech.{$RessID}}: <b><span style="color:{if $elementData.costOverflow[$RessID] == 0}lime{else}red{/if}">{$RessAmount|number}</span></b>
					{/foreach}</p></td>
					<td class="transparent" style="vertical-align:middle;width:100px">
					{if $elementData.maxLevel == $elementData.levelToBuild}
						<span style="color:red">{$LNG.bd_maxlevel}</span>
					{elseif ($isBusy.research && ($elementId == 6 || $elementId == 31)) || ($isBusy.shipyard && ($elementId == 15 || $elementId == 21))}
						<span style="color:red">{$LNG.bd_working}</span>
					{else}
						{if $RoomIsOk}
							{if $CanBuildElement && $elementData.buyable}
							<form action="game.php?page=buildings" method="post" class="build_form">
								<input type="hidden" name="mode" value="build">
								<input type="hidden" name="elementId" value="{$elementId}">
								<button type="submit" class="build_submit">{if $elementData.level == 0}{$LNG.bd_build}{else}{$LNG.bd_build_next_level}{$elementData.levelToBuild + 1}{/if}</button>
							</form>
							{else}
							<span style="color:red">{if $elementData.level == 0}{$LNG.bd_build}{else}{$LNG.bd_build_next_level}{$elementData.levelToBuild + 1}{/if}</span>
							{/if}
						{else}
						<span style="color:red">{$LNG.bd_no_more_fields}</span>
						{/if}
					{/if}
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="margin-bottom:10px;">  
			<table style="width:100%">
				<tr>
					<td class="transparent left">
						{$LNG.bd_remaining}<br>
						{foreach $elementData.costOverflow as $ResType => $ResCount}
						{$LNG.tech.{$ResType}}: <span style="font-weight:700">{$ResCount|number}</span><br>
						{/foreach}
						<br>
					</td>
				</tr>
				<tr>		
					<td class="transparent left" style="width:68%">
						{if !empty($elementData.infoEnergy)}
							{$LNG.bd_next_level}<br>
							{$elementData.infoEnergy}<br>
						{/if}
						{if $elementData.level > 0}
							{if $elementId == 43}<a href="#" onclick="return Dialog.info({$elementId})">{$LNG.bd_jump_gate_action}</a>{/if}
							{if ($elementId == 44 && !$HaveMissiles) ||  $elementId != 44}<br><a class="tooltip_sticky" data-tooltip-content="
								{* Start Destruction Popup *}
								<table style='width:300px'>
									<tr>
										<th colspan='2'>{$LNG.bd_price_for_destroy} {$LNG.tech.{$elementId}} {$elementData.level}</th>
									</tr>
									{foreach $elementData.destroyResources as $ResType => $ResCount}
									<tr>
										<td>{$LNG.tech.{$ResType}}</td>
										<td><span style='color:{if $elementData.destroyOverflow[$RessID] == 0}lime{else}red{/if}'>{$ResCount|number}</span></td>
									</tr>
									{/foreach}
									<tr>
										<td>{$LNG.bd_destroy_time}</td>
										<td>{$elementData.destroyTime|time}</td>
									</tr>
									<tr>
										<td colspan='2'>
											<form action='game.php?page=buildings' method='post' class='build_form'>
												<input type='hidden' name='mode' value='destroy'>
												<input type='hidden' name='elementId' value='{$elementId}'>
												<button type='submit' class='build_submit onlist'>{$LNG.bd_dismantle}</button>
											</form>
										</td>
									</tr>
								</table>
								{* End Destruction Popup *}
								">{$LNG.bd_dismantle}</a>{/if}
						{else}
							&nbsp;
						{/if}
					</td>
					<td class="transparent right" style="white-space:nowrap;">
						{$LNG.fgf_time}:<br>{$elementData.elementTime|time}
					</td>
				</tr>	
			</table>
		</td>
	</tr>
	{/foreach}
</table>
{/block}