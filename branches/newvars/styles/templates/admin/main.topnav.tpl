<div id="page">
	<div id="header">
		<h1>{$LNG.adm_cp_title}</h1>
		<div align="right">
		{if $authlevel == $smarty.const.AUTH_ADM}
		<select id="universe" onchange="top.location = 'admin.php?uni='+$(this).val();">
			{html_options options=$AvailableUnis selected=$UNI}
		</select>
		{/if}
		<a href="admin.php" class="topn">{$LNG.adm_cp_index}</a>
		{if $authlevel == $smarty.const.AUTH_ADM}
		<a href="admin.php?page=universe&amp;sid={$SID}" class="topn">{$LNG.mu_universe}</a>
		<a href="admin.php?page=rights&amp;mode=rights&amp;sid={$SID}" class="topn">{$LNG.mu_moderation_page}</a>
		<a href="admin.php?page=rights&amp;mode=users&amp;sid={$SID}" class="topn">{$LNG.ad_authlevel_title}</a>
		{/if}
		{if $userID == 1}
		<a href="admin.php?page=reset&amp;sid={$SID}" class="topn">{$LNG.re_reset_universe}</a>
		{/if}
		<a href="game.php" class="out">{$LNG.adm_cp_logout}</a>
	</div>
</div>