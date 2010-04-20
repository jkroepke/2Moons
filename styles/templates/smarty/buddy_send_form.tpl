{include file="overall_header.tpl"}
<script type="text/javascript" src="scripts/cntchar.js"></script>
<script type="text/javascript">

function check(){ldelim}
	if(document.buddy.text.value == '') {ldelim}
		alert('Gebe einen Text ein!');
		return false;
	{rdelim} else {ldelim}
		$.post('game.php?page=buddy&mode=1&sm=3&u={$id}&ajax=1', $('#buddy').serialize(), function(data){ldelim}
			alert(data);
			window.close();
		{rdelim});
		return true;
	{rdelim}
{rdelim}
</script>
<form name="buddy" id="buddy">
    <table width="95%" align="center">
    <tr>
        <td class="c" colspan="2">{$bu_request_message}</td>
    </tr><tr>
        <th>{$bu_player}</th>
        <th>{$username}</th>
    </tr><tr>
        <th>{$mg_message} (<span id="cntChars">0</span> / 5000 {$mg_characters})</th>
        <th><textarea name="text" id="text" cols="40" rows="10" size="100"></textarea></th>
    </tr><tr>
        <th colspan="2"><input type="button" onClick="return check();" name="button" value="{$bu_send}">
</th>
</tr>
</table>
</form>
{include file="overall_footer.tpl"}
