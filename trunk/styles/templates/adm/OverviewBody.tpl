{include file="adm/overall_header.tpl"}
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("feeds", "1");
</script>
<center>
<h1>{$ow_title}</h1>
<table width="90%" style="border:2px {if empty($Messages)}lime{else}red{/if} solid;text-align:center;font-weight:bold;">
<tr>
    <td>{foreach item=Message from=$Messages}
	<font color="red"><b>{$Message}</b></font><br><br>
	{foreachelse}{$ow_none}{/foreach}
	</td>
</tr>
</table>
<br>
<table width="80%">
	<tr>
    	<td class="c">{$ow_overview}</td>
		<td class="c">Facebook</td>
    </tr>
	<tr>
    	<th style="height:50px"><div align="justify">{$ow_welcome_text}</div></th>
		<th style="width:292px" align="center" rowspan="9">
			<iframe id="fb_iframe" src="http://www.facebook.com/plugins/likebox.php?id=129282307106646&amp;width=292&amp;connections=10&amp;stream=true&amp;header=true&amp;height=587" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:587px; background-color: #FFF" allowTransparency="true"></iframe>
		</th>
    </tr>
    <tr>
        <td class="c">{$ow_support}</td>
    </tr>
    <tr>
        <th><a href="http://code.google.com/p/2moons/source/list" target="_blank">SVN Revision List</a><br>
		<a href="http://www.titanspace.org/" target="_blank">Offical Betauni</a><br>
		<a href="http://www.xnova-reloaded.de/" target="_blank">xnova-reloaded.de - {$ow_forum}</a></th>
    </tr> 
	<tr>
		<td class="c">Newest Updates</td>
	</tr>
	<tr>
		<th align="center">
			<div id="feed"></div>
			<script type="text/javascript">
			      function initialize() {
					var feedControl = new google.feeds.FeedControl();
					feedControl.addFeed("http://code.google.com/feeds/p/2moons/svnchanges/basic", "");
					feedControl.draw(document.getElementById("feed"));
				  }
				  google.setOnLoadCallback(initialize);

			</script>
		</th>
	</tr>  
    <tr>
    	<td class="c">{$ow_credits}</td>
    </tr>
    <tr>
    	<th>
            <table width="475" align="center" style="text-align:center;">
                <tr>
					<td><h3>{$ow_proyect_leader}</h3></td>
                </tr>
                <tr>
					<td><h3><font color="red">Slaver</font></h3></td>
                </tr>
                <tr>
					<td><h3>Team</h3></td>
                </tr>
                <tr>
					<td>Inforcer - Language<br>neox301291 - GFX</td>
                </tr>
		        <tr>
					<td><h3>{$ow_translator}</h3></td>
                </tr>
                <tr>
					<td>languar (english)<br>ssAAss (russian)<br>InquisitorEA (russian)<br>morgado (portuguese)<br>ZideN (spanish)</td>
                </tr> 
                <tr>
					<td><h3>{$ow_special_thanks}</h3></td>
                </tr>
                <tr>
					<td>lucky<br>Metusalem<br>Meikel<br>Phil<br>Schnippi<br>Vobi<br>Onko<br>Sycrog<br>Raito<br>Chlorel<br>e-Zobar<br>Flousedid<br>Allen Spielern im <a href="http://www.titanspace.org" target="blank">Betauni</a> ...<br>... sowie der Community auf xnova-reloaded.eu</td>
                </tr>    
            </table>
        </th>
    </tr>
	<tr>
		<td class="c">Donate - Paypal</td>
	</tr>
	<tr>
		<th align="center">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="CM6PQFUATN7MS">
		<input type="image" src="https://www.paypal.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen - mit PayPal." style="background:transparent;border:0px none;">
		<img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">
		</form>
		</th>
	</tr>
</table>
</center>
<script type="text/javascript">
$(document).ready(function(){
	$('.UIStory_Message').css("color","#CCCCCC");

});
</script>
{include file="adm/overall_footer.tpl"}