<div id='messagebox' style="text-align:center;"></div>
<div id='errorbox' style="text-align:center;"></div>
{$cron}
{$sql_num}

<script type="text/javascript" src="scripts/jquery.js" defer></script>
<script type="text/javascript" src="scripts/global.js" defer></script>
<script type="text/javascript" src="scripts/animatedcollapse.js" defer></script>
<script type="text/javascript" src="scripts/overlib.js" defer></script>
{foreach item=scriptname from=$scripts}
<script type="text/javascript" src="scripts/{$scriptname}" defer></script>
{/foreach}
{if $js_res_multiplier}
<script type="text/javascript">
$(document).ready(function() {
	met		= parseInt($("#current_metal").text().replace(/\./g,""));
	cry		= parseInt($("#current_crystal").text().replace(/\./g,""));
	deu 		= parseInt($("#current_deuterium").text().replace(/\./g,""));
	met_max 	= "{$metal_max}".replace(/\./g,"");
	cry_max 	= "{$crystal_max}".replace(/\./g,"");
	deu_max 	= "{$deuterium_max}".replace(/\./g,"");
	met_hr		= {$js_metal_hr};
	cry_hr		= {$js_crystal_hr};
	deu_hr		= {$js_deuterium_hr};
	res_factor	= {$js_res_multiplier};

	update();
});
</script>
{/if}
</body>
</html>