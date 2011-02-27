{include file="adm/overall_header.tpl"}
<script type="text/javascript">
	function ajax(url) {
		$.get(url, function(data){
			alert(data);
			parent.frames['Hauptframe'].location.reload()
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
	<td><a href="javascript:ajax('./index.php?page=reg&mode=valid&lang={$UserLang}&clef={$User.cle}&admin=1','{$User.username}');">{$aktivieren}</a></td>
	<td><a href="?page=active&amp;action=delete&id={$User.id}" onclick="return confirm('{$sicher}{$User.username} {$entfernen}');"><img border="0" src="./styles/images/r1.png"></a></td>
</tr>
{/foreach}	
<tr><td colspan="8">{$insgesamt} {$smarty.foreach.User.total} {$nicht_aktivierte}</td></tr>
</table>
{include file="adm/overall_footer.tpl"}