{include file="overall_header.tpl"}
<script type="text/javascript">
	function ajax(url) {
		$.get(url, function(data){
			Dialog.alert(data, function(){
				parent.frames['Hauptframe'].location.reload()			
			});
		});
	}
</script>
<table width="450">
<tr>
	<th colspan="7">{$nicht_aktivierte_u}</th>
</tr>
<tr>
	<td>{$id}</td>
	<td>{$username}</td>
	<td>{$datum}</td>
	<td>{$email}</td>
	<td>{$ip}</td>
	<td>{$aktivieren}</td>
	<td>{$del}</td>
</tr>
{foreach name=User item=User from=$Users}
<tr>
	<td>{$User.id}</td>
	<td>{$User.name}</td>
	<td><nobr>{$User.date}</nobr></td>
	<td>{$User.email}</td>
	<td>{$User.ip}</td>
	<td><a href="javascript:ajax('./index.php?&uni={$uni}&page=reg&action=valid&clef={$User.cle}&admin=1');">{$aktivieren}</a></td>
	<td><a href="?page=active&amp;action=delete&id={$User.id}" onclick="return confirm('{$sicher}{$User.username} {$entfernen}');"><img border="0" src="./styles/images/alliance/CLOSE.png" width="16" height="16"></a></td>
</tr>
{/foreach}	
<tr><td colspan="8">{$insgesamt} {$smarty.foreach.User.total} {$nicht_aktivierte}</td></tr>
</table>
{include file="overall_footer.tpl"}