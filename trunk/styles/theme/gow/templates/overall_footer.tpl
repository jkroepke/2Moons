{$cron}
<script type="text/javascript">
var serverTime = new Date({$date.0}, {$date.1 - 1}, {$date.2}, {$date.3}, {$date.4}, {$date.5});
var localTime = new Date();
localTS = localTime.getTime();
var ServerTimezoneOffset = {$date.6} + localTime.getTimezoneOffset()*60;
var Gamename	= document.title;
var Ready		= "{$ready}";
var Skin		= "{$dpath}";
var Lang		= "{$lang}";
var head_info	= "{$fcm_info}";
var auth		= {$authlevel};
var days 		= {$js_days};
var months 		= {$js_month};
</script>
<script type="text/javascript" src="{$cd}scripts/jQuery.js?v={$REV}"></script>
<script type="text/javascript" src="{$cd}scripts/base.js?v={$REV}"></script>
{foreach item=scriptname from=$scripts}
<script type="text/javascript" src="{$cd}scripts/{$scriptname}.js?v={$REV}"></script>
{/foreach}
<script type="text/javascript">
var timerHandler = new TimerHandler();
{if $topnav}
var resourceTickerMetal = {
    available: {$metal},
    limit: [0, {$js_metal_max}],
    production: {$js_metal_hr},
    valueElem: "current_metal"
};
var resourceTickerCrystal = {
    available: {$crystal},
    limit: [0, {$js_crystal_max}],
    production: {$js_crystal_hr},
    valueElem: "current_crystal"
};
var resourceTickerDeuterium = {
    available: {$deuterium},
    limit: [0, {$js_deuterium_max}],
    production: {$js_deuterium_hr},
    valueElem: "current_deuterium"
};
initRessource();

var vacation = {$vmode};
if (!vacation) {
	new resourceTicker(resourceTickerMetal);
	new resourceTicker(resourceTickerCrystal);
	new resourceTicker(resourceTickerDeuterium);
} 
{/if}
</script>
<script type="text/javascript">
function UhrzeitAnzeigen()
{
    var Sekunden = serverTime.getSeconds();
    serverTime.setSeconds(Sekunden+1);
    if(document.getElementById("servertime"))
		document.getElementById("servertime").innerHTML = getFormatedDate(serverTime.getTime(), '[M] [D] [d] [H]:[i]:[s]');
}
UhrzeitAnzeigen();
setInterval("UhrzeitAnzeigen()", 1000);
</script>
<script type="text/javascript">
{$execscript}
</script>
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
{if $debug == 1}
<script type="text/javascript">
onerror = handleErr;
</script>
{/if}
</body>
</html>