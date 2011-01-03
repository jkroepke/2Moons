{include file="adm/overall_header.tpl"}
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript" src="http://update.xnova.de/donate.js"></script>
<script type="text/javascript" src="./scripts/buildlist.js"></script>
<script type="text/javascript">
google.load("feeds", "1");
</script>
<center>
<h1>{$ow_title}</h1>
<table width="90%" style="border:2px {if empty($Messages)}lime{else}red{/if} solid;text-align:center;font-weight:bold;">
<tr>
    <td>{foreach item=Message from=$Messages}
	<span style="color:red"><b>{$Message}</b></span><br><br>
	{foreachelse}{$ow_none}{/foreach}
	</td>
</tr>
</table>
<br>
<table width="80%">
	<tr>
    	<th colspan="2">{$ow_overview}</th>
    </tr>
	<tr>
    	<td style="height:50px" colspan="2">{$ow_welcome_text}<br><iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2F2Moons%2F129282307106646&amp;width=292&amp;connections=0&amp;stream=false&amp;header=false&amp;height=62" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:62px;" allowTransparency="true"></iframe></td>
    </tr>
    <tr>
        <th colspan="2">{$ow_support}</th>
    </tr>
    <tr>
        <td colspan="2"><a href="http://o.gl/7eu8" target="_blank">Project Homepage</a><br>
        <a href="http://code.google.com/p/2moons/source/list" target="_blank">SVN Revision List</a><br>
		<a href="http://www.titanspace.org/" target="_blank">Offical Betauni</a><br>
		<a href="http://www.xnova.de/" target="_blank">xnova.de - {$ow_forum}</a></td>
    </tr> 
	<tr>
		<th style="width:50%;">Donate - Paypal</th>
		<th style="width:50%;">Donate - Moneybookers</th>
	</tr>
	<tr>
		<td colspan="2">
			<div id="progressbar"></div>
			<script type="text/javascript">
			$(function() {
				$("#progressbar").progressbar({
					value: Math.min(donate_{$date},donate_max) / donate_max * 100
				});
			});
			document.write("Goal: "+donate_max+"&euro; &bull; tde Month Amount: "+donate_{$date}+"&euro; ("+donate_{$date} / donate_max * 100+"%)");
			</script>
		</td>
	</tr>
	<tr>
		<td align="center" style="height:110px;">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="CM6PQFUATN7MS">
		<input type="image" src="https://www.paypal.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen - mit PayPal." style="background:transparent;border:0px none;">
		</form>
		</td>
		<td align="center">
		<img src="http://www.moneybookers.com/images/logos/additional_logos/de_donatewitd.gif" style="background:transparent;border:0px none;">
		<form action="https://www.moneybookers.com/app/payment.pl" target="_blank">
		<input type="hidden" name="pay_to_email" value="slaver7@gmail.com">
		<input type="hidden" name="recipient_description" value="Donation for 2Moons">
		<input type="hidden" name="return_url_target" value="1">
		<input type="hidden" name="cancel_url_target" value="1">
		<input type="hidden" name="dynamic_descriptor" value="Descriptor">
		<input type="hidden" name="language" value="DE">
		<input type="hidden" name="confirmation_note" value="tdank you for tdis Donation">
		<input type="hidden" name="detail1_description" value="Donation">
		<input type="hidden" name="detail1_text" value="tdank you for tdis donation!">
		<input type="hidden" name="rec_period" value="1">
		<input type="hidden" name="rec_grace_period" value="1">
		<input type="hidden" name="rec_cycle" value="day">
		<input type="hidden" name="submit_id" value="Submit">
		<input type="text" name="amount" value="0.00">
		<select name="currency">
			<option value="EUR">EUR</option>
			<option value="USD">USD</option>
		</select><br>
		<input type="submit" name="Pay" value="Pay">
		</form>
		</td>
	</tr>
	<tr>
		<th colspan="2">Newest Updates</th>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<div id="feed"></div>
			<script type="text/javascript">
			      function initialize() {
					var feedControl = new google.feeds.FeedControl();
					feedControl.addFeed("http://code.google.com/feeds/p/2moons/svnchanges/basic", "");
					feedControl.draw(document.getElementById("feed"));
				  }
				  google.setOnLoadCallback(initialize);

			</script>
		</td>
	</tr>  
    <tr>
    	<th colspan="2">{$ow_credits}</th>
    </tr>
    <tr>
    	<td colspan="2">
            <table width="475" align="center" style="text-align:center;">
                <tr>
					<td class="transparent"><h3>{$ow_proyect_leader}</h3></td>
                </tr>
                <tr>
					<td class="transparent"><h3><span style="color:red">Slaver</span></h3></td>
                </tr>
                <tr>
					<td class="transparent"><h3>Team</h3></td>
                </tr>
                <tr>
					<td class="transparent"><span style="color:orange">stealtd1 - Entwickler/Moderator<br>Robbyn - Entwickler/Moderator<br>Lyon - Moderator<br>Freak1992 - Moderator</span></td>
                </tr>
		        <tr>
					<td class="transparent"><h3>{$ow_translator}</h3></td>
                </tr>
                <tr>
					<td class="transparent">languar (english)<br>ssAAss (russian)<br>InquisitorEA (russian)<br>MiguelR(english &amp; portuguese)<br>Naykee (portuguese)<br>ZideN (spanish)<br>hanhot (chinese)<br>cyceron (polnisch)</td>
                </tr> 
                <tr>
					<td class="transparent"><h3>{$ow_special_tdanks}</h3></td>
                </tr>
                <tr>
					<td class="transparent">lucky<br>Metusalem<br>Meikel<br>Phil<br>Schnippi<br>Inforcer<br>Vobi<br>Onko<br>Sycrog<br>Raito<br>Chlorel<br>e-Zobar<br>Flousedid<br>Allen Spielern im <a href="http://www.titanspace.org" target="blank">Betauni</a> ...<br>... sowie der Community auf xnova-reloaded.eu</td>
                </tr>    
            </table>
        </td>
    </tr>
</table>
</center>
<script type="text/javascript">
$(document).ready(function(){
	$('.UIStory_Message').css("color","#CCCCCC");
});
</script>
{include file="adm/overall_footer.tpl"}