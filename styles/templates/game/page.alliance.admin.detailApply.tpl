{block name="title" prepend}{$LNG.lm_alliance}{/block}
{block name="content"}
<form action="game.php?page=alliance&amp;mode=admin&amp;action=sendAnswerToApply&amp;id={$applyDetail.applyID}" method="post">
	<table class="table519">
	<tr>
		<th>{$LNG.al_request_from_user} {$applyDetail.username}</th>
	</tr>
	<tr>
		<td>{if !empty($applyDetail.text)}{$applyDetail.text}{else}{$LNG.al_default_request_text}{/if}</td>
	</tr>
	<tr>
		<th>{$LNG.al_reply_to_request}</th>
	</tr>
	<tr>
		<td><textarea name="text" cols="40" rows="10" class="tinymce"></textarea></td>
	</tr>
	<tr>
		<td><button type="submit" name="answer" value="yes">{$LNG.al_acept_request}</button> <button type="submit" name="answer" value="no">{$LNG.al_decline_request}</button></td>
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