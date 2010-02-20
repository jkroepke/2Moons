<div id='messagebox'>
<center>
</center>
</div>
<div id='errorbox'>
<center>
</center>
</div>

<script type="text/javascript">
headerHeight = 81;
messageboxHeight = 0;
errorboxHeight = 0;

if(document.getElementById('errorbox')){
	if(document.getElementById('content')){
		errorbox = document.getElementById('errorbox');
		errorbox.style.top=parseInt(headerHeight+messagebox.offsetHeight+5)+'px';
		contentbox = document.getElementById('content');
		contentbox.style.top=parseInt(headerHeight+errorbox.offsetHeight+messagebox.offsetHeight+10)+'px';
		if (navigator.appName=='Netscape'){
			if (window.innerWidth < 1020){
				document.body.scroll='no';
			}
			contentbox.style.height = parseInt(window.innerHeight) - messagebox.offsetHeight - errorbox.offsetHeight - headerHeight - 20;
			if(document.getElementById('content')) {
				document.getElementById('content').style.width = document.body.offsetWidth;
			}
		} else {
			if (document.body.offsetWidth<1020){document.body.scroll='no';}
			contentbox.style.height = parseInt(document.body.offsetHeight) - messagebox.offsetHeight - headerHeight - errorbox.offsetHeight - 20;
			document.getElementById('resources').style.width=(document.body.offsetWidth*0.4);
		}
		for (var i = 0; i < document.links.length; ++i) {
			if (document.links[i].href.search(/.*redir\.php\?url=.*/) != -1) {
				document.links[i].target = "_blank";
			}
		}
	}
}
</script>
{cron}
{sql_num}
</body>
</html>