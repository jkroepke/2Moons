<div id='messagebox' style="text-align:center;"></div>
<div id='errorbox' style="text-align:center;"></div>
{$cron}
{$sql_num}
<script type="text/javascript">
    (function() {ldelim}
        var s = [
            "scripts/jquery.js",
            "scripts/global.js",
            "scripts/animatedcollapse.js",
			{foreach item=scriptname from=$scripts}
			"scripts/{$scriptname}",
			{/foreach}
            "scripts/overlib.js",
        ];

        var sc = "script", tp = "text/javascript", sa = "setAttribute", doc = document, ua = window.navigator.userAgent;
        for(var i=0, l=s.length; i<l; ++i) {ldelim}
            if(ua.indexOf("Firefox")!==-1 || ua.indexOf("Opera")!==-1) {
                var t=doc.createElement(sc);
                t[sa]("src", s[i]);
                t[sa]("type", tp);
                doc.getElementsByTagName("head")[0].appendChild(t);
            {rdelim} else {ldelim}
                doc.writeln("<" + sc + " type=\"" + tp + "\" src=\"" + s[i] + "\"></" + sc + ">");
            {rdelim}
        {rdelim}
    {rdelim})();
</script>
{if $js_res_multiplier}
<script type="text/javascript">
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
</script>
{/if}
</body>
</html>