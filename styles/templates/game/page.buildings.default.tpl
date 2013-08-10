{block name="title" prepend}{$LNG.lm_buildings}{/block}
{block name="content"}
{if !empty($Queue)}
<div id="buildlist" class="buildlist">
	<table style="width:760px">
		{foreach $Queue as $taskId => $task}
		{$elementId = $task.element}
		<tr>
			<td style="width:70%;vertical-align:top;" class="left">
				{$task@iteration}.: 
				{if !$isPlanetFull && $BuildInfoList[$elementId].buyable}
				<form class="build_form" action="game.php?page=buildings" method="post">
					<input type="hidden" name="mode" value="build">
					<input type="hidden" name="elementId" value="{$elementId}">
					<button type="submit" class="build_submit onlist">{$LNG.tech.{$elementId}} {$task.level}{if $task.destroy} {$LNG.bd_dismantle}{/if}</button>
				</form>
				{else}{$LNG.tech.{$elementId}} {$task.level} {if $task.destroy}{$LNG.bd_dismantle}{/if}{/if}
				{if $task@first}
				<br><br><div id="progressbar" data-time="{$task.resttime}"></div>
			</td>
			<td>
				<div id="time" data-time="{$task.time}"><br></div>
				{else}
			</td>
			<td>
				{/if}
				<form action="game.php?page=buildings" method="post" class="build_form">
					<input type="hidden" name="mode" value="cancel">
					<input type="hidden" name="taskId" value="{$taskId}">
					<button type="submit" class="build_submit onlist">{$LNG.bd_cancel}</button>
				</form>
				<br><span style="color:lime" data-time="{$task.endtime}" class="timer">{$task.display}</span>
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
					<p>{foreach $elementData.costResources as $resourceId => $value}
					{$LNG.tech.{$resourceId}}: <b><span style="color:{if $elementData.costOverflow[$resourceId] == 0}lime{else}red{/if}">{$value|number}</span></b>
					{/foreach}</p></td>
					<td class="transparent" style="vertical-align:middle;width:100px">
					{if $isPlanetFull}
						<span style="color:red">{$LNG.bd_no_more_fields}</span>
					{elseif $elementData.maxLevel != 0 && $elementData.maxLevel == $elementData.levelToBuild}
						<span style="color:red">{$LNG.bd_maxlevel}</span>
					{elseif $elementData.isBusy}
						<span style="color:red">{$LNG.bd_working}</span>
					{elseif !$elementData.buyable}
						<span style="color:red">{if $elementData.level == 0}{$LNG.bd_build}{else}{$LNG.bd_build_next_level}{$elementData.levelToBuild + 1}{/if}</span>
					{else}
						<form action="game.php?page=buildings" method="post" class="build_form">
							<input type="hidden" name="mode" value="build">
							<input type="hidden" name="elementId" value="{$elementId}">
							<button type="submit" class="build_submit">{if $elementData.level == 0}{$LNG.bd_build}{else}{$LNG.bd_build_next_level}{$elementData.levelToBuild + 1}{/if}</button>
						</form>
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
										<td><span style='color:{if $elementData.destroyOverflow[$resourceId] == 0}lime{else}red{/if}'>{$ResCount|number}</span></td>
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