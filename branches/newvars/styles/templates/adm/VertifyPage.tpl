{include file="overall_header.tpl"}
<table>
	<tr>
		<th colspan="6">{$LNG.vt_head}</th>
	</tr>
	<tr>
		<td colspan="6">{$LNG.vt_info}</td>
	</tr>
	<tr>
		<td><a href="admin.php?page=vertify&amp;action=vertify&amp;ext=php">{$LNG.vt_filephp}</a></td>
		<td><a href="admin.php?page=vertify&amp;action=vertify&amp;ext=tpl">{$LNG.vt_filetpl}</a></td>
		<td><a href="admin.php?page=vertify&amp;action=vertify&amp;ext=css">{$LNG.vt_filecss}</a></td>
		<td><a href="admin.php?page=vertify&amp;action=vertify&amp;ext=js">{$LNG.vt_filejs}</a></td>
		<td><a href="admin.php?page=vertify&amp;action=vertify&amp;ext=png|jpg|gif">{$LNG.vt_fileimg}</a></td>
		<td><a href="admin.php?page=vertify&amp;action=vertify&amp;ext=htaccess">{$LNG.vt_filehtaccess}</a></td>
	</tr>
	<tr>
		<td colspan="6"><a href="admin.php?page=vertify&amp;action=vertify&amp;ext=php|tpl|js|css|png|jpg|gif|htaccess">{$LNG.vt_all}</a></td>
	</tr>
</table>
{include file="overall_footer.tpl"}