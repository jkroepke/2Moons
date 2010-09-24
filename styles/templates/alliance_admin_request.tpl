{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<script type="text/javascript">
function infodiv(i){
$('.request:visible').slideUp(500);
$('#'+i).slideDown(500);
}
</script>
<div id="content" class="content">
    <table class="table519">
        <tr>
          <th colspan="2">{$al_request_list}</th>
		</tr>
		<tr>
          <td colspan="2">{$requestcount}</td>
        </tr>
        <tr>
          <th><a href="?page=alliance&amp;mode=admin&amp;edit=requests&amp;show=0&amp;sort=1">{$al_candidate}</a></th>
          <th><a href="?page=alliance&amp;mode=admin&amp;edit=requests&amp;show=0&amp;sort=0">{$al_request_date}</a></th>
        </tr>
        {foreach item=RequestRow from=$RequestList}
		<tr><td><a href="javascript:infodiv('request_{$RequestRow.id}');">{$RequestRow.username}</a></td><td><a href="javascript:infodiv('request_{$RequestRow.id}');">{$RequestRow.time}</a></td></tr>
		{foreachelse}
		<tr><td colspan="2">{$al_no_requests}</td></tr>
		{/foreach}
        <tr>
          <th colspan="2"><a href="?page=alliance">{$al_back}</a></th>
        </tr>
    </table>
	{foreach item=RequestRow from=$RequestList}
	<div class="request" id="request_{$RequestRow.id}" style="display:none;">
	<form action="?page=alliance&amp;mode=admin&amp;edit=requests&amp;action=send&amp;id={$RequestRow.id}" method="POST">
    <table class="table519">
	<tr>
		<th colspan="2">{$al_request_from_user} {$RequestRow.username}</th>
	</tr>
	<tr>
		<td colspan="2">{$RequestRow.text}</td>
	</tr>
	<tr>
		<th colspan="2">{$al_reply_to_request}</th>
	</tr>
	<tr>
		<td><span id="cntChars">0</span> / 500 {$al_characters}</td>
		<td><textarea name="text" cols="40" rows="10" onkeyup="$('#cntChars').text($(this).val().length);"></textarea></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" name="action" value="{$al_acept_request}"> <input type="submit" name="action" value="{$al_decline_request}"></td>
	</tr>
	</table>
	</form>
	</div>
	{/foreach}
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}