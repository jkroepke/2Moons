{block name="title" prepend}{$LNG.lm_messages}{/block}
{block name="content"}
<table style="width:760px;table-layout:fixed;">
	<tr>
		<th colspan="6">{$LNG.mg_overview}<span id="loading" style="display:none;"> ({$LNG.loading})</span></th>
	</tr>
		{foreach $CategoryList as $CategoryID => $CategoryRow}
		{if ($CategoryRow@iteration % 6) === 1}<tr>{/if}
		{if $CategoryRow@last && ($CategoryRow@iteration % 6) !== 0}<td>&nbsp;</td>{/if}
		<td style="word-wrap: break-word;color:{$CategoryRow.color};"><a href="#" onclick="Message.getMessages({$CategoryID});return false;" style="color:{$CategoryRow.color};">{$LNG.mg_type.{$CategoryID}}</a>
		<br><span id="unread_{$CategoryID}">{$CategoryRow.unread}</span>/<span id="total_{$CategoryID}">{$CategoryRow.total}</span>
		</td>
		{if $CategoryRow@last || ($CategoryRow@iteration % 6) === 0}</tr>{/if}
		{/foreach}
</table>
<table style="width:760px;table-layout:fixed;">
	<tr>
		<th>{$LNG.mg_game_operators}</th>
	</tr>
	{foreach $OperatorList as $OperatorName => $OperatorEmail}
	<tr>
		<td>{$OperatorName}<a href="mailto:{$OperatorEmail}" title="{$LNG.mg_write_mail_to_ops} {{$OperatorName}}"><img src="{$dpath}img/m.gif" alt=""></a></td>
	</tr>
	{/foreach}
</table>
{/block}
{block name="script" append}
{if !empty($category)}
<script>$(function() {
	Message.getMessages({$category}, {$side});
})</script>
{/if}
{/block}