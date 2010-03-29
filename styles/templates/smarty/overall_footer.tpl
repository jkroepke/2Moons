<div id='messagebox' style="text-align:center;"></div>
<div id='errorbox' style="text-align:center;"></div>
{$cron}
{$sql_num}
{if $metal_max}
<script type="text/javascript">
$(document).ready(function() {
	met		= parseInt($("#current_metal").text().replace(/\./g,""));
	cry		= parseInt($("#current_crystal").text().replace(/\./g,""));
	deu 		= parseInt($("#current_deuterium").text().replace(/\./g,""));
	met_max 	= {$js_metal_max};
	cry_max 	= {$js_crystal_max};
	deu_max 	= {$js_deuterium_max};
	met_hr		= {$js_metal_hr};
	cry_hr		= {$js_crystal_hr};
	deu_hr		= {$js_deuterium_hr};

	update();
});
</script>
{/if}
</body>
</html>