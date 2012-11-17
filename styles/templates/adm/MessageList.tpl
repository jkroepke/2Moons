{include file="overall_header.tpl"}
<form action="admin.php?page=messagelist" method="post" id="form">
<input type="hidden" name="side" value="{$page}" id="side">
	<p>
	<table width="90%">   
		<tr>
            <th colspan="5">{$LNG.ml_message_list}</th>
        </tr>
		<tr>
            <td style="width:15%">{$LNG.ml_type}</td>
            <td style="width:35%">{html_options options=$categories selected=$type name="type"}</td>
            <td style="width:15%">{$LNG.ml_date_range}</td>
            <td style="width:17.5%"><input value="{$dateStart.day|default:''}" type="text" id="dateStartDay" name="dateStart[day]" style="width:25px" maxlength="2" placeholder="dd">.<input value="{$dateStart.month|default:''}" type="text" id="dateStartMonth" name="dateStart[month]" style="width:25px" maxlength="2" placeholder="mm">.<input value="{$dateStart.year|default:''}" type="text" id="dateStartYear" name="dateStart[year]" style="width:35px" maxlength="4" placeholder="yyyy"></td>
			<td style="width:17.5%"><input value="{$dateEnd.day|default:''}" type="text" id="dateEndDay" name="dateEnd[day]" style="width:25px" maxlength="2" placeholder="dd">.<input value="{$dateEnd.month|default:''}" type="text" id="dateEndMonth" name="dateEnd[month]" style="width:25px" maxlength="2" placeholder="mm">.<input value="{$dateEnd.year|default:''}" type="text" id="dateEndYear" name="dateEnd[year]" style="width:35px" maxlength="4" placeholder="yyyy"></td>
        </tr>
		<tr>
            <td style="width:15%"><label for="sender">{$LNG.ml_sender}</label></td>
            <td style="width:35%"><input type="text" id="sender" name="sender" value="{$sender}" length="11"></td>
            <td style="width:15%"><label for="receiver">{$LNG.ml_receiver}</label></td>
            <td style="width:35%" colspan="2"><input type="text" id="receiver" name="receiver" value="{$receiver}" length="11"></td>
        </tr>
        <tr>
			<th colspan="5" class="center">
				<input type="submit" value="{$LNG.ml_type_submit}">
			</th>
        </tr>
	</table>
</p>
<p>
	<table width="90%">  	
		<tr>
			<th colspan="{if $Selected == 100}7{else}6{/if}">{$LNG.ml_message_list}</th>
		</tr>
		<tr style="height: 20px;">
			<td class="right" colspan="{if $Selected == 100}7{else}6{/if}">{$LNG.mg_page}: {if $page != 1}<a href="#" onclick="gotoPage({$page - 1});return false;">&laquo;</a>&nbsp;{/if}{for $site=1 to $maxPage}<a href="#" onclick="gotoPage({$site});return false;">{if $site == $page}<b>[{$site}]</b>{else}[{$site}]{/if}</a>{if $site != $maxPage}&nbsp;{/if}{/for}{if $page != $maxPage}&nbsp;<a href="#" onclick="gotoPage({$page + 1});return false;">&raquo;</a>{/if}</td>
		</tr>
		<tr>
			<th style="width:3%;"><input title="{$ml_select_all_messages}" type="checkbox" onClick="checkedAll(select_all);"></th>
			<th style="width:4%">{$LNG.ml_id}</th>
			{if $Selected == 100}<th>{$LNG.ml_type}</th>{/if}
			<th>{$LNG.ml_sender}</th>
			<th style="width:15%">{$LNG.ml_date}</th>
			<th>{$LNG.ml_receiver}</th>
			<th>{$LNG.ml_subject}</th>
        </tr>
        {foreach $messageList as $messageID => $messageRow}
		<tr>
			<td><input type="checkbox" name="messageID[{$messageID}]" value="1"></td>
			<td><a href="javascript:$('#contentID{$messageID}').toggle()">{$messageID}</a></td>
			{if $Selected == 100}<td><a href="javascript:$('#contentID{$messageID}').toggle()">{$LNG.mg_type[$messageRow.type]}</a></td>{/if}
			<td><a href="javascript:$('#contentID{$messageID}').toggle()">{$messageRow.sender}</a></td>
			<td><a href="javascript:$('#contentID{$messageID}').toggle()">{$messageRow.time}</a></td>
			<td><a href="javascript:$('#contentID{$messageID}').toggle()">{$messageRow.receiver}</a></td>
			<td><a href="javascript:$('#contentID{$messageID}').toggle()">{$messageRow.subject}</a></td>
		</tr>
		<tr id="contentID{$messageID}" style="display:none;">
			<td class="left" colspan="{if $Selected == 100}7{else}6{/if}" style="padding:5px 8px;">{$messageRow.text}</td>
		</tr>
		{/foreach}
    </table>
</p>
</form>
<script>
function gotoPage(page) {
	$('#side').val(page);
	$('form').submit();
}

$(function() {
	$('#sender, #receiver').autocomplete({
		'source': 'admin.php?page=autocomplete',
	});
});
</script>
{include file="overall_footer.tpl"}