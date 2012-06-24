{block name="title" prepend}{$LNG.fcm_info}{/block}
{block name="content"}
<table class="table519 informationTable">
	<tr>
		<th>{$LNG.fcm_info}</th>
	</tr>
	<tr>
		<td><p>{$message}</p>{if !empty($redirectButtons)}<p>{foreach $redirectButtons as $label => $url}<a href="{$url}"><button>{$label}</button></a>{/foreach}</p>{/if}</td>
	</tr>
</table>
{/block}