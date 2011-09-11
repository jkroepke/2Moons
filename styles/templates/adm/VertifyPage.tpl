{include file="adm/overall_header.tpl"}
<table>
	<tr>
		<th colspan="2">{lang}vt_fail{/lang}</th>
	</tr>
	<tr>
		<td colspan="2">{lang}vt_info{/lang}</td>
	</tr>
	<tr>
		<th>{lang}vt_file{/lang}</th><th>{lang}vt_hash{/lang}</th>
	</tr>
	{foreach $Fail as $File => $Hash}
	<tr>
		<td>
		<a href="http://2moons.googlecode.com/svn-history/r{$Patchlevel}/trunk/{$File}">{$File}</a></td><td>{$Hash}</td>
	</tr>
	{/foreach}
</table>
{include file="adm/overall_footer.tpl"}