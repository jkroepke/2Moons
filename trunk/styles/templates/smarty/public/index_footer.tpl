</div></div>
</td></tr></table>
</div>
<script type="text/javascript">
IsCaptchaActive = {$game_captcha};
IsRegActive 	= {$reg_close};
lang_reg_closed	= '{$register_closed}';
cappublic		= '{$cappublic}';

    (function() {
        var s = [
            "http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js",
            "scripts/gzip/soundmanager2.jgz",
            "scripts/gzip/jquery.loadmask.jgz",
            "http://browser-update.org/update.js",
            "scripts/gzip/login.jgz",
            {if $game_captcha}
			"http://api.recaptcha.net/js/recaptcha_ajax.js"
			{/if}
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
</body>
</html>