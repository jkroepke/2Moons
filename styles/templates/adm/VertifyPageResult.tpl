{include file="adm/overall_header.tpl"}
<table>
	<tr>
		<th colspan="4">{lang}vt_fail{/lang}</th>
	</tr>
	<tr>
		<td colspan="4">{lang}vt_info{/lang}</td>
	</tr>
	<tr>
		<td colspan="4"><div class="processbar" style="background-color: green; height: 14px;width:0;"></div><div class="info" style="margin-top: -14px;"></div></td>
	</tr>
	<tr>
		<td><span id="fileok">0</span> {lang}vt_fileok{/lang}</td><td><span id="filefail">0</span> {lang}vt_filefail{/lang}</td><td><span id="filenew">0</span> {lang}vt_filenew{/lang}</td><td><span id="fileerror">0</span> {lang}vt_fileerror{/lang}</td>
	</tr>
	<tr id="result">
		<td colspan="4"><div style="display: block; overflow-y: scroll; height: 280px;">{lang}vt_loadfile{/lang}</div></td>
	</tr>
</table>
{include file="adm/overall_footer.tpl"}