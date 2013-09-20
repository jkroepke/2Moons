{include file="overall_header.tpl"}
<script type="text/javascript">
	function activeUser(validationID, validationKey) {
		$.getJSON('index.php?page=vertify&mode=json&i='+validationID+'&k='+validationKey, function(data){
			alert(data);
			parent.frames['Hauptframe'].location.reload();
		});
		return false;
	}
</script>
<table width="450">
<tr>
	<th colspan="7">{$LNG.ap_nicht_aktivierte_user}</th>
</tr>
<tr>
	<td>{$LNG.ap_id}</td>
	<td>{$LNG.ap_username}</td>
	<td>{$LNG.ap_datum}</td>
	<td>{$LNG.ap_email}</td>
	<td>{$LNG.ap_ip}</td>
	<td>{$LNG.ap_status}</td>
	<td>{$LNG.ap_del}</td>
</tr>
{foreach name=User item=User from=$Users}
<tr>
	<td>{$User.id}</td>
	<td>{$User.name}</td>
	<td><nobr>{$User.date}</nobr></td>
	<td>{$User.email}</td>
	<td>{$User.ip}</td>
	<td><a href="#" onclick="return activeUser({$User.id},'{$User.validationKey}');">{$LNG.ap_aktivieren}</a></td>
	<td><a href="?page=active&amp;action=delete&id={$User.id}" onclick="return confirm('{$LNG.ap_sicher}{$User.username} {$LNG.ap_entfernen}');"><img border="0" src="./styles/resource/images/alliance/CLOSE.png" width="16" height="16"></a></td>
</tr>
{/foreach}	
<tr><td colspan="8">{$LNG.ap_insgesamt} {count($Users)} {$LNG.ap_nicht_aktivierte}</td></tr>
</table>
{include file="overall_footer.tpl"}