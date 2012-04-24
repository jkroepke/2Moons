{block name="title" prepend}{$LNG.mu_vertify}{/block}
{block name="content"}
<table>
	<tr>
		<th colspan="6">{$LNG.vt_head}</th>
	</tr>
	<tr>
		<td colspan="6">{$LNG.vt_info}</td>
	</tr>
	<tr>
		<td><a href="admin.php?page=vertify&amp;mode=vertify&amp;ext=php">{$LNG.vt_filephp}</a></td>
		<td><a href="admin.php?page=vertify&amp;mode=vertify&amp;ext=tpl">{$LNG.vt_filetpl}</a></td>
		<td><a href="admin.php?page=vertify&amp;mode=vertify&amp;ext=css">{$LNG.vt_filecss}</a></td>
		<td><a href="admin.php?page=vertify&amp;mode=vertify&amp;ext=js">{$LNG.vt_filejs}</a></td>
		<td><a href="admin.php?page=vertify&amp;mode=vertify&amp;ext=png|jpg|gif">{$LNG.vt_fileimg}</a></td>
		<td><a href="admin.php?page=vertify&amp;mode=vertify&amp;ext=htaccess">{$LNG.vt_filehtaccess}</a></td>
	</tr>
	<tr>
		<td colspan="6"><a href="admin.php?page=vertify&amp;mode=vertify&amp;ext=php|tpl|js|css|png|jpg|gif|htaccess">{$LNG.vt_all}</a></td>
	</tr>
</table>
{/block}