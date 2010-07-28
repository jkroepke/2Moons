{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<script src="scripts/cntchar.js" type="text/javascript"></script>
<script type="text/javascript">
function infodiv(i){
$('.request:visible').hide('blind', {}, 500);
$('#'+i).show('blind', {}, 500);
}
</script>
<div id="content" class="content">
    <table width="519" align="center">
        <tr>
          <td class="c" colspan="2">{$al_request_list}</td>
		</tr>
		<tr>
          <th colspan="2">{$requestcount}</th>
        </tr>
        <tr>
          <td class="c"><a href="?page=alliance&amp;mode=admin&amp;edit=requests&amp;show=0&amp;sort=1">{$al_candidate}</a></td>
          <td class="c"><a href="?page=alliance&amp;mode=admin&amp;edit=requests&amp;show=0&amp;sort=0">{$al_request_date}</a></td>
        </tr>
        {foreach item=RequestRow from=$RequestList}
		<tr><th><a href="javascript:infodiv('request_{$RequestRow.id}');">{$RequestRow.username}</a></th><th><a href="javascript:infodiv('request_{$RequestRow.id}');">{$RequestRow.time}</a></th></tr>
		{foreachelse}
		<tr><th colspan="2">{$al_no_requests}</th></tr>
		{/foreach}
        <tr>
          <td class="c" colspan="2"><a href="?page=alliance">{$al_back}</a></td>
        </tr>
    </table>
	{foreach item=RequestRow from=$RequestList}
	<div class="request" id="request_{$RequestRow.id}" style="display:none;">
	<form action="?page=alliance&amp;mode=admin&amp;edit=requests&amp;action=send&amp;id={$RequestRow.id}" method="POST">
	<table width="519" align="center">
	<tr>
		<td class="c" colspan="2">{$al_request_from_user} {$RequestRow.username}</td>
	</tr>
	<tr>
		<th colspan="2">{$RequestRow.text}</th>
	</tr>
   <tr>
	 <td class="c" colspan="2">{$al_reply_to_request}</td>
   </tr>
   <tr>
	 <th><span id="cntChars">0</span> / 500 {$al_characters}</th>
	 <th><textarea name="text" cols="40" rows="10" onkeyup="javascript:cntchar(500)"></textarea></th>
   </tr>
   <tr>
	 <th colspan="2"><input type="submit" name="action" value="{$al_acept_request}"> <input type="submit" name="action" value="{$al_decline_request}"></th>
   </tr>
	</table>
	</form>
	</div>
	{/foreach}
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}