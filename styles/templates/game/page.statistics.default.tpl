{block name="title" prepend}{$LNG.lm_statistics}{/block}
{block name="content"}
<form name="stats" id="stats" method="post" action="">
	<table class="table519">
		<tr id="feed" style="display:none">
			<th colspan="3"><img src="./styles/resource/images/steem.png" width="16" height="16"/>&nbsp;SteemNova alliance shares and rewards</th>
		</tr>
		<tr id="feed_0" style="display:none">
			<td>
			<img id="image_0" src="https://steemit-production-imageproxy-thumbnail.s3.amazonaws.com/U5dtgsmRQQZ2YMPNxotR6Aj5RvKhrY5_1680x8400" width="120" height="80"/>
			</td>
			<td style="font-size: 12px;">
			<a id="url_0" target="_blank">
			<p id="title_0"></p>
			</a>
			<p><i class="fas fa-chevron-circle-up"></i>&nbsp;+<span id="votes_0"></span>&nbsp;&nbsp;<i class="fas fa-dollar-sign"></i>&nbsp;~<span id="pending_payout_value_0"></span></p>
			</td>
		</tr>
		<tr id="feed_margin" style="display:none; height: 4px;">
		</tr>
	</table>
	<table class="table519">
		<tr>
			<th>{$LNG.st_statistics} ({$LNG.st_updated}: {$stat_date})</th>
		</tr>
		<tr>
			<td>
				<label for="who">{$LNG.st_show}</label> <select name="who" id="who" onchange="$('#stats').submit();">{html_options options=$Selectors.who selected=$who}</select>
				<label for="type">{$LNG.st_per}</label> <select name="type" id="type" onchange="$('#stats').submit();">{html_options options=$Selectors.type selected=$type}</select>
				<label for="range">{$LNG.st_in_the_positions}</label> <select name="range" id="range" onchange="$('#stats').submit();">{html_options options=$Selectors.range selected=$range}</select>
			</td>
		</tr>
	</table>
</form>
<table class="table519">
{if $who == 1}
	{include file="shared.statistics.playerTable.tpl"}
{elseif $who == 2}
	{include file="shared.statistics.allianceTable.tpl"}
{/if}
</table>
{/block}
{block name="script" append}
    <script src="scripts/game/statistics.js"></script>
{/block}