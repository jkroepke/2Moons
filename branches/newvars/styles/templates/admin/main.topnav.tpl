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
		{if $userID == 1}
		<a href="admin.php?page=reset" class="topn">{$LNG.tn_reset}</a>
		{/if}
		<a href="game.php" class="out">{$LNG.adm_cp_logout}</a>
	</div>
</div>