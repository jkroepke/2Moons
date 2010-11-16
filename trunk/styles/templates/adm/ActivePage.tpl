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
	<td class="c" colspan="7">{$nicht_aktivierte_u}</td>
</tr>
<tr>
	<th>{$id}</th>
	<th>{$username}</th>
	<th>{$datum}</th>
	<th>{$email}</th>
	<th>{$ip}</th>
	<th>{$aktivieren}</th>
	<th>{$del}</th>
</tr>
{foreach name=User item=User from=$Users}
<tr>
	<th>{$User.id}</th>
	<th>{$User.name}</th>
	<th><nobr>{$User.date}</nobr></th>
	<th>{$User.email}</th>
	<th>{$User.ip}</th>
	<th><a href="javascript:ajax('./index.php?page=reg&mode=valid&lang={$UserLang}&clef={$User.cle}&admin=1','{$User.username}');">{$aktivieren}</a></th>
	<th><a href="?page=active&amp;action=delete&id={$User.id}" onclick="return confirm('{$sicher}{$User.username} {$entfernen}');"><img border="0" src="./styles/images/r1.png"></a></th>
</tr>
{/foreach}	
<tr><th colspan="8">{$insgesamt} {$smarty.foreach.User.total} {$nicht_aktivierte}</th></tr>
</table>
{include file="adm/overall_footer.tpl"}