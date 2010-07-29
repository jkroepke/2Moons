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
	<td class="c" colspan="7">Nicht aktivierte User</td>
</tr>
<tr>
	<th>ID</th>
	<th>Username</th>
	<th>Datum</th>
	<th>E-Mail</th>
	<th>IP</th>
	<th>Akitvieren</th>
	<th>Del</th>
</tr>
{foreach name=User item=User from=$Users}
<tr>
<th>{$User.id}</th>
<th>{$User.username}</th>
	<th><nobr>{$User.date}</nobr></th>
	<th>{$User.email}</th>
	<th>{$User.ip}</th>
	<th><a href="javascript:ajax('./index.php?page=reg&mode=valid&id={$User.password}clef={$User.cle}&admin=1&getajax=1','{$User.username}');">Aktivieren</a></th>
	<th><a href="?page=active&amp;action=delete&id={$User.id}" onclick="return confirm('Bist du sicher, dass du den User {$User.username} entfernen willst?');"><img border="0" src="./styles/images/r1.png"></a></th>
</tr>
{/foreach}	
<tr><th colspan="8">Insgesamt {$smarty.foreach.User.total} nicht aktivierte User vorhanden.</th></tr>
</table>
{include file="adm/overall_footer.tpl"}