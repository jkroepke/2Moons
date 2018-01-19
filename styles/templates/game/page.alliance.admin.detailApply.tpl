{block name="title" prepend}{$LNG.lm_alliance}{/block}
{block name="content"}
	<table class="table519">
	<tr>
		<th colspan="4">{$LNG.al_request_from} {$apply_time}</th>
	</tr>
	<tr>
		<td colspan="2">{$LNG.pl_name}</td>
		<td colspan="2">{$applyDetail.username}</td>
	</tr>
	<tr>
		<td colspan="2">>{$LNG.pl_homeplanet}</td>
		<td colspan="2">{$applyDetail.name} <a href="#" onclick="parent.location = 'game.php?page=galaxy&galaxy={$applyDetail.galaxy}&system={$applyDetail.system}';return false;">[{$applyDetail.coordinates}]</a></td>
	</tr>
	<tr>
		<td colspan="2">{$LNG.al_request_register_time}</td>
		<td colspan="2">{$register_time}</td>
	</tr>
	<tr>
		<td colspan="2">{$LNG.al_request_last_onlinetime}</td>
		<td colspan="2">{$onlinetime}</td>
	</tr>
	<tr>
		<th colspan="2" style="text-align:center;">&nbsp;</th>
		<th colspan="1" style="text-align:center;">{$LNG.pl_points}</th>
		<th colspan="1" style="text-align:center;">{$LNG.pl_range}</th>
	</tr>
	<tr>
		<td colspan="2">{$LNG.pl_tech}</td>
		<td colspan="1">{$applyDetail.tech_points}</td>
		<td colspan="1">{$applyDetail.tech_rank}</td>
	</tr>
	<tr>
		<td colspan="2">{$LNG.pl_builds}</td>
		<td colspan="1">{$applyDetail.build_points}</td>
		<td colspan="1">{$applyDetail.build_rank}</td>
	</tr>
	<tr>
		<td colspan="2">{$LNG.pl_def}</td>
		<td colspan="1">{$applyDetail.defs_points}</td>
		<td colspan="1">{$applyDetail.defs_rank}</td>
	</tr>
	<tr>
		<td colspan="2">{$LNG.pl_fleet}</td>
		<td colspan="1">{$applyDetail.fleet_points}</td>
		<td colspan="1">{$applyDetail.fleet_rank}</td>
	</tr>
	<tr>
		<td colspan="2">{$LNG.pl_total}</td>
		<td colspan="1">{$applyDetail.total_points}</td>
		<td colspan="1">{$applyDetail.total_rank}</td>
	</tr>
		<tr>
		<th colspan="4">{$LNG.pl_fightstats}</th>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
		<td colspan="1">{$LNG.pl_fights}</td>
		<td colspan="1">{$LNG.pl_fprocent}</td>
	</tr>
	<tr>
		<td colspan="2">{$LNG.pl_fightwon}</td>
		<td colspan="1">{$applyDetail.wons}</td>
		<td colspan="1">{$applyDetail.wons_percentage} %</td>
	</tr>
	<tr>
		<td colspan="2">{$LNG.pl_fightdraw}</td>
		<td colspan="1">{$applyDetail.draws}</td>
		<td colspan="1">{$applyDetail.draws_percentage} %</td>
	</tr>
	<tr>
		<td colspan="2">{$LNG.pl_fightlose}</td>
		<td colspan="1">{$applyDetail.loos}</td>
		<td colspan="1">{$applyDetail.loos_percentage} %</td>
	</tr>
	<tr>
		<td colspan="2">{$LNG.pl_totalfight}</td>
		<td colspan="1">{$applyDetail.total_fights}</td>
		<td colspan="1">100 %</td>
	</tr>
	<tr>
		<td colspan="2">{$LNG.pl_unitsshot}</td>
		<td colspan="2">{$applyDetail.desunits}</td>
	</tr>
	<tr>
		<td colspan="2">{$LNG.pl_unitslose}</td>
		<td colspan="2">{$applyDetail.lostunits}</td>
	</tr>
	<tr>
		<td colspan="2">{$LNG.pl_dermetal}</td>
		<td colspan="2">{$applyDetail.kbmetal}</td>
	</tr>
	<tr>
		<td colspan="2">{$LNG.pl_dercrystal}</td>
		<td colspan="2">{$applyDetail.kbcrystal}</td>
	</tr>
	{if !empty($applyDetail.text)}
	<tr>
		<th colspan="4">{$LNG.al_message}</th>
	</tr>
	<tr>
		<td colspan="4">{$applyDetail.text}</td>
	</tr>
	{/if}
	</table>
<br>
<form action="game.php?page=alliance&amp;mode=admin&amp;action=sendAnswerToApply&amp;id={$applyDetail.applyID}" method="post">
<table class="table519">
	<tr>
		<th colspan="4"><label for="message">{$LNG.al_reply_to_request}</label></th>
	</tr>
	<tr>
		<td colspan="4"><textarea name="text" cols="40" rows="10" class="tinymce" id="message"></textarea></td>
	</tr>
	<tr>
		<td colspan="4"><button type="submit" name="answer" value="yes">{$LNG.al_acept_request}</button> <button type="submit" name="answer" value="no">{$LNG.al_decline_request}</button></td>
	</tr>
	</table>
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