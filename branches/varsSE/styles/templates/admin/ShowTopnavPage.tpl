{include file="overall_header.tpl"}
<br><div style="font-size:22px;font-weight:bolder;font-variant:small-caps;text-align:center;width:100%;">{$adm_cp_title}</div><br>
<div align="right">
{if $authlevel == $smarty.const.AUTH_ADM}
<select id="universe">
{html_options options=$AvailableUnis selected=$UNI}
</select>
{/if}
<a href="admin.php?page=overview" target="Hauptframe" class="topn">&nbsp;{$adm_cp_index}&nbsp;</a>
{if $authlevel == $smarty.const.AUTH_ADM}
<a href="?page=universe&amp;sid={$sid}" target="Hauptframe" class="topn">&nbsp;{$mu_universe}&nbsp;</a>
<a href="?page=rights&amp;mode=rights&amp;sid={$sid}" target="Hauptframe" class="topn">&nbsp;{$mu_moderation_page}&nbsp;</a>
<a href="?page=rights&amp;mode=users&amp;sid={$sid}" target="Hauptframe" class="topn">&nbsp;{$ad_authlevel_title}&nbsp;</a>
{/if}
{if $id == 1}
<a href="?page=reset&amp;sid={$sid}" target="Hauptframe" class="topn">&nbsp;{$re_reset_universe}&nbsp;</a>
{/if}
<a href="javascript:top.location.href='game.php';" target="_top" class="out">&nbsp;{$adm_cp_logout}&nbsp;</a>
</div>
<script>
$(function() {
	$('#universe').on('change', function(e) {
		parent.frames['Hauptframe'].location.href = parent.frames['Hauptframe'].location.href+'&uni='+$(this).val();
		parent.frames['rightFrame'].location.reload();
	});
});
</script>
{include file="overall_footer.tpl"}