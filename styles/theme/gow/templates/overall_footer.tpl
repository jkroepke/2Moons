{$cron}
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