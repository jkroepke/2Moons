{include file="overall_header.tpl"}
<table>
	<tr>
		<th colspan="4">{$LNG.vt_fail}</th>
	</tr>
	<tr>
		<td colspan="4">{$LNG.vt_info}</td>
	</tr>
	<tr>
		<td colspan="4"><div class="processbar" style="background-color: green; height: 14px;width:0;"></div><div class="info" style="margin-top: -14px;"></div></td>
	</tr>
	<tr>
		<td><span id="fileok">0</span> {$LNG.vt_fileok}</td><td><span id="filefail">0</span> {$LNG.vt_filefail}</td><td><span id="filenew">0</span> {$LNG.vt_filenew}</td><td><span id="fileerror">0</span> {$LNG.vt_fileerror}</td>
	</tr>
	<tr id="result">
		<td colspan="4" class="left"><div style="display: block; overflow-y: scroll; height: 280px;">{$LNG.vt_loadfile}</div></td>
	</tr>
</table>
{include file="overall_footer.tpl"}