</div></div>
</td></tr></table>
</div>
<script type="text/javascript">
IsCaptchaActive 	= {$game_captcha};
IsRegActive 		= {$reg_close};
lang_reg_closed		= "{$register_closed}";
cappublic			= "{$cappublic}";
fb_permissions		= "{$fb_perm}";
lang				= "{$lang}";
    (function() {
        var s = [
            "http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js",
            "scripts/soundmanager2.js",
            "scripts/jquery.loadmask.js",
            "scripts/jquery.cookie.js",
	        {if $game_captcha}
			"http://api.recaptcha.net/js/recaptcha_ajax.js",
			{/if}
			{if $ga_active}
			"http://www.google-analytics.com/ga.js",
			{/if}
            "scripts/login.js",
        ];

        var sc = "script", tp = "text/javascript", sa = "setAttribute", doc = document, ua = window.navigator.userAgent;
        for(var i=0, l=s.length; i<l; ++i) {
            if(ua.indexOf("Firefox")!==-1 || ua.indexOf("Opera")!==-1) {
                var t=doc.createElement(sc);
                t[sa]("src", s[i]);
                t[sa]("type", tp);
                doc.getElementsByTagName("head")[0].appendChild(t);
            } else {
                doc.writeln("<" + sc + " type=\"" + tp + "\" src=\"" + s[i] + "\"></" + sc + ">");
            }
        }
    })();
</script>
{if $ga_active}
<script type="text/javascript">
try{
var pageTracker = _gat._getTracker("{$ga_key}");
pageTracker._trackPageview();
} catch(err) {}</script>
{/if}
{if $fb_active}
<div id="fb-root"> </div>
<script type="text/javascript">
  window.fbAsyncInit = function() {
    FB.init({
		appId: '{$fb_key}', 
		status: true, 
		cookie: true,
        xfbml: true
	});
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>
{/if}
</body>
</html>