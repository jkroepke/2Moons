<div id='messagebox' style="text-align:center;"></div>
<div id='errorbox' style="text-align:center;"></div>
{$cron}
{$sql_num}
{if $metal_max}
<script type="text/javascript">
met			= parseInt($("#current_metal").text().replace(/\{$thousands_sep}/g,""));
cry			= parseInt($("#current_crystal").text().replace(/\{$thousands_sep}/g,""));
deu 		= parseInt($("#current_deuterium").text().replace(/\{$thousands_sep}/g,""));
met_max 	= {$js_metal_max};
cry_max 	= {$js_crystal_max};
deu_max 	= {$js_deuterium_max};
met_hr		= {$js_metal_hr};
cry_hr		= {$js_crystal_hr};
deu_hr		= {$js_deuterium_hr};

update();
</script>
{/if}
{if $ga_active}
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '{$ga_key}']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
{/if}
</body>
</html>