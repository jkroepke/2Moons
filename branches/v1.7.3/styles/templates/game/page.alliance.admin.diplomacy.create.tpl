{block name="title" prepend}{$LNG.lm_alliance}{/block}
{block name="content"}
<form name="message" id="message">
	<table style="width:95%">
	<tr>
		<th colspan="2">{$LNG.al_circular_send_ciruclar}</th>
	</tr>
	<tr>
		<td>{$LNG.al_diplo_ally}</td>
		<td>{html_options name="ally_id" values=$IdList output=$AllyList}</td>
	</tr>
	<tr>
		<td>{$LNG.al_diplo_level_des}</td>
		<td>{html_options name="level" values=range(1,6) output=$LNG.al_diplo_level selected=$diploMode}</td>
	</tr>
	<tr>
		<td>{$LNG.al_diplo_text}<br>(<span id="cntChars">0</span> / 5000 {$LNG.al_characters})</td>
		<td>
			<textarea name="text" cols="60" rows="10" onkeyup="$('#cntChars').text($(this).val().length);"></textarea>
		</td>
	</tr>
	<tr>
		<th colspan="2" style="text-align:center;">
		<input type="reset" value="{$LNG.al_circular_reset}">
		<input type="button" onclick="return check();" value="{$LNG.al_circular_send_submit}">
		</th>
	</tr>
	</table>
</form>
{/block}
{block name="script" append}
<script type="text/javascript">
function check(){
	if(document.message.text.value == '') {
		alert('{$LNG.mg_empty_text}');
		return false;
	} else {
		$.getJSON('game.php?page=alliance&mode=admin&action=diplomacyCreateProcessor&ajax=1&'+$('#message').serialize(), function(data) {
			alert(data.message);
			if(!data.error) {
				parent.location.reload();
			}
		});
		return true;
	}
}

$(function() {	
	$('#name').autocomplete({
		source: "game.php?page=search&mode=autocomplete&type=allyname",
		minLength: 0,
		select: function(event, ui) {
			$(event.target).val(ui.item.label.replace(/<\/?b>/gim, ''));
			return false;
		}
	});
});
</script>
{/block}