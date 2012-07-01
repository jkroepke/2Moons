{block name="title" prepend}{$LNG.write_message}{/block}
{block name="content"}
<form name="message" method="post" action="game.php?page=messages&mode=send">
<input type="hidden" name="userID" value="{$userID}">
<input type="hidden" name="parentID" value="{$parentID}">
	<table style="width:95%;">
		<tr>
			<th colspan="2">{$LNG.mg_send_new}</th>
		</tr>
		<tr>
			<td style="width:30%"><label for="owner">{$LNG.mg_send_to}</label></td>
			<td style="width:70%"><input type="text" id="owner" size="40" value="{$owner.username} [{$owner.galaxy}:{$owner.system}:{$owner.planet}]" readonly></td>
		</tr>
		<tr>
			<td style="width:30%"><label for="subject">{$LNG.mg_subject}</label></td>
			<td style="width:70%"><input type="text" name="subject" id="subject" size="40" maxlength="255" value="{$subject}"></td>
		</tr>
		<tr>
			<td style="width:30%"><label for="text">{$LNG.mg_message}</label></td>
			<td style="width:70%"><textarea name="text" id="text" cols="40" rows="10" style="margin:10px 0;"></textarea></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="{$LNG.mg_send}"></td>
		</tr>
	</table>
</form>
{/block}
{block name="script" append}
<script type="text/javascript" src="scripts/base/tinymce/tiny_mce_gzip.js"></script>
<script type="text/javascript">
$(function() {
	tinyMCE_GZ.init({
		plugins : 'bbcode,fullscreen"',
		themes : 'advanced',
		languages : 'en',
		disk_cache : true,
		debug : false
	}, function() {
		tinyMCE.init({
			script_url : 'scripts/base/tinymce/tiny_mce.js',
			theme : "advanced",
			mode : "textareas",
			plugins : "bbcode,fullscreen",
			theme_advanced_buttons1 : "bold,italic,underline,undo,redo,link,unlink,image,forecolor,styleselect,removeformat,cleanup,code,fullscreen",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_toolbar_location : "bottom",
			theme_advanced_toolbar_align : "center",
			theme_advanced_styles : "Code=codeStyle;Quote=quoteStyle",
			content_css : "{$dpath}formate.css",
			entity_encoding : "raw",
			add_unload_trigger : false,
			remove_linebreaks : false,
			fullscreen_new_window : false,
			fullscreen_settings : {
				theme_advanced_path_location : "top"
			}
		});
	});
});
</script>
{/block}