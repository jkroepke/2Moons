{block name="title" prepend}{$LNG.lm_alliance}{/block}
{block name="content"}
<form action="game.php?page=alliance&amp;mode=apply&amp;id={$allyid}" method="post">
<table class="table569">
	<tr>
		<th colspan="2">{$al_write_request}</th>
	</tr>
	<tr>
		<td width="40%"><label for="message">{$LNG.al_message}</label></td>
		<td><textarea name="text" cols="40" rows="20" class="tinymce" id="message">{$applytext}</textarea></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="{$LNG.al_applyform_send}"></td>
	</tr>
</table>
</form>
{/block}
{block name="script" append}
<script type="text/javascript" src="scripts/base/tinymce/tiny_mce_gzip.js"></script>
<script type="text/javascript">
$(function() {
	tinyMCE_GZ.init({
		plugins : 'bbcode,fullscreen',
		themes : 'advanced',
		languages : '{$lang}',
		disk_cache : true,
		debug : false
	}, function() {
		tinyMCE.init({
			script_url : 'scripts/base/tinymce/tiny_mce.js',
			theme : "advanced",
			mode : "textareas",
			plugins : "bbcode,fullscreen",
			theme_advanced_buttons1 : "bold,italic,underline,undo,redo,link,unlink,image,forecolor,removeformat,cleanup,code,fullscreen",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_toolbar_location : "top",
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