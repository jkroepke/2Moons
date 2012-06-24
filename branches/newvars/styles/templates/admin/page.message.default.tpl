{block name="title" prepend}{$LNG.mu_messages}{/block}
{block name="content"}
<table id="filterTable">
	<tr>
		<th colspan="4">{$LNG.ml_title}</th>
	</tr>
	<tr>
		<td style="width:15%"><label for="filterId">{$LNG.ml_filter_id}</label></td>
		<td style="width:35%"><input type="text" id="filterId" name="filter[id]"></td>
		<td style="width:15%"><label for="filterTime">{$LNG.ml_filter_time}</label></td>
		<td style="width:35%"><input type="text" id="filterTime" class="datepicker" name="filter[time]"></td>
	</tr>
	<tr>
		<td style="width:15%"><label for="filterSender">{$LNG.ml_filter_sender}</label></td>
		<td style="width:35%"><input type="text" id="filterSender" pattern="[0-9]*" class="autocompleteUser" name="filter[sender]"></td>
		<td style="width:15%"><label for="filterOwner">{$LNG.ml_filter_owner}</label></td>
		<td style="width:35%"><input type="text" id="filterOwner" pattern="[0-9]*" class="autocompleteUser" name="filter[owner]"></td>
	</tr>
	<tr>
		<td style="width:15%"><label for="filterType">{$LNG.ml_filter_type}</label></td>
		<td style="width:35%"><select id="filterType" name="filter[sender]"><option value="">-</option>{html_options values=$categoryTypes output=$LNG.mg_type}</select></td>
		<td style="width:15%"><label for="filterSubject">{$LNG.ml_filter_subject}</label></td>
		<td style="width:35%"><input type="text" id="filterSubject" name="filter[subject]"></td>
	</tr>
	<tr>
		<td colspan="4"><button id="executeFilter">{$LNG.common_submit}</button></td>
	</tr>
</table>
<table id="messageTable" class="tablesorter">
	<thead>
		<tr>
			<th style="width:5%">{$LNG.ml_table_head_id}</th>
			<th style="width:20%">{$LNG.ml_table_head_sender}</th>
			<th style="width:20%">{$LNG.ml_table_head_owner}</th>
			<th style="width:20%">{$LNG.ml_table_head_time}</th>
			<th style="width:30%">{$LNG.ml_table_head_subject}</th>
			<th style="width:5%">&nbsp;</th>
		</tr>
		<tr>
			<td colspan="6">
				<div class="floatleft left">{$LNG.ml_table_show}:&nbsp;[<a href="javascript:setCount(10)">10</a>]&nbsp;[<a href="javascript:setCount(25)">25</a>]&nbsp;[<a href="javascript:setCount(50)">50</a>]&nbsp;[<a href="javascript:setCount(100)">100</a>]&nbsp;[<a href="javascript:setCount(0)">&infin;</a>]</div>
				<div class="floatright right">{$LNG.ml_table_side}:&nbsp;{if $maxSite > 1}<a href="#" class="pageLink" data-page="1">&laquo;&laquo;</a>&nbsp;{/if}{if $site > 1}<a href="#" class="pageLink" data-page="{$site - 1}">&laquo;</a>&nbsp;{/if}{for $page=1 to $maxSite}<a href="#" class="pageLink" data-page="{$page}">{if $site == $page}<b>[{$page}]</b>{else}[{$page}]{/if}</a>{if $page != $maxSite}&nbsp;{/if}{/for}{if $site < $maxSite}&nbsp;<a href="#" class="pageLink" data-page="{$site + 1}">&raquo;</a>{/if}{if $maxSite > 1}&nbsp;<a href="#" class="pageLink" data-page="{$maxPage}">&raquo;&raquo;</a>{/if}
				</div>
			</td>
		</tr>
	</thead>
	<tbody>
		{foreach $messageList as $messageId => $messageRow}
		<tr>
			<td>{$messageId}</td>
			<td>{$messageRow.sender}</td>
			<td>{$messageRow.owner}</td>
			<td>{$messageRow.date}</td>
			<td>{$messageRow.subject}</td>
			<td><a href="#" class="deleteButton" data-message="{$messageId}" title="{$LNG.ml_delete}"><img alt="" src="styles/images/false.png"><a></td>
		</tr>
		{/foreach}
	</tbody>
</table>
{/block}
{block name="script" append}
{/block}