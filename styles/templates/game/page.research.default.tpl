{block name="title" prepend}{$LNG.lm_research}{/block}
{block name="content"}
{if !empty($Queue)}
<div id="buildlist" class="buildlist">
	<table style="width:760px">
		{foreach $Queue as $taskId => $task}
		{$elementId = $task.element}
		<tr>
			<td style="width:70%;vertical-align:top;" class="left">
				{if isset($ResearchList[$task.element])}
				{$CQueue = $ResearchList[$task.element]}
				{/if}
				{$task@iteration}.: 
				{if isset($CQueue) && $CQueue.maxLevel != $CQueue.level && $CQueue.buyable}
				<form action="game.php?page=research" method="post" class="build_form">
					<input type="hidden" name="mode" value="build">
					<input type="hidden" name="elementId" value="{$elementId}">
					<button type="submit" class="build_submit onlist">{$LNG.tech.{$elementId}} {$task.level}{if !empty($task.planet)} @ {$task.planet}{/if}</button>
				</form>
				{else}
				{$LNG.tech.{$elementId}} {$task.level}{if !empty($task.planet)} @ {$task.planet}{/if}
				{/if}
				{if $task@first}
				<br><br><div id="progressbar" data-time="{$task.resttime}"></div>
			</td>
			<td>
				<div id="time" data-time="{$task.time}"><br></div>
				{else}
			</td>
			<td>
				{/if}
				<form action="game.php?page=research" method="post" class="build_form">
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
{if $isLabInBuild}<table width="70%" id="infobox" style="border: 2px solid red; text-align:center;background:transparent"><tr><td>{$LNG.bd_building_lab}</td></tr></table><br><br>{/if}
<table style="width:760px">
	{foreach $ResearchList as $elementId => $elementData}
	<tr>
		<td rowspan="2" style="width:120px;">
			<a href="#" onclick="return Dialog.info({$elementId})">
				<img src="{$dpath}gebaeude/{$elementId}.gif" alt="" class="top" width="120" height="120">
			</a>
		</td>
		<th>
			<a href="#" onclick="return Dialog.info({$elementId})">{$LNG.tech.{$elementId}}</a>{if $elementData.level != 0} ({$LNG.bd_lvl} {$elementData.level}{if $elementData.maxLevel != 255}/{$elementData.maxLevel}{/if}){/if}
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
					{if $elementData.maxLevel != 0 && $elementData.maxLevel == $elementData.levelToBuild}
						<span style="color:red">{$LNG.bd_maxlevel}</span>
					{elseif $elementData.isBusy}
						<span style="color:red">{$LNG.bd_working}</span>
					{elseif !$elementData.buyable}
						<span style="color:red">{if $elementData.level == 0}{$LNG.bd_tech}{else}{$LNG.bd_tech_next_level}{$elementData.levelToBuild + 1}{/if}</span>
					{else}
						<form action="game.php?page=research" method="post" class="build_form">
							<input type="hidden" name="mode" value="build">
							<input type="hidden" name="elementId" value="{$elementId}">
							<button type="submit" class="build_submit">{if $elementData.level == 0}{$LNG.bd_tech}{else}{$LNG.bd_tech_next_level}{$elementData.levelToBuild + 1}{/if}</button>
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
					<td class="transparent right">
						{$LNG.fgf_time}
					</td>
				</tr>
				<tr>		
					<td class="transparent left" style="width:68%">
						&nbsp;
					</td>
					<td class="transparent right" style="white-space:nowrap;">
						{$elementData.elementTime|time}
					</td>
				</tr>	
			</table>
		</td>
	</tr>
	{/foreach}
</table>
{/block}
{block name="script" append}
    {if !empty($Queue)}
        <script src="scripts/game/research.js"></script>
    {/if}
{/block}