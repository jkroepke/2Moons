{include file="overall_header.tpl"}
<center>
<h1>{$LNG.ow_title}</h1>
<table width="90%" style="border:2px {if empty($Messages)}lime{else}red{/if} solid;text-align:center;font-weight:bold;">
<tr>
    <td class="transparent">{foreach item=Message from=$Messages}
	<span style="color:red">{$Message}</span><br>
	{foreachelse}{$LNG.ow_none}{/foreach}
	</td>
</tr>
</table>
<br>
<table width="80%">
	<tr>
    	<th colspan="2">{$LNG.ow_overview}</th>
    </tr>
	<tr>
    	<td style="height:50px" colspan="2">{$LNG.ow_welcome_text}
            <!--
            <br>
            <iframe src="https://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2F2Moons%2F129282307106646&amp;width=292&amp;connections=0&amp;stream=false&amp;header=false&amp;height=62" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:62px;" allowTransparency="true"></iframe>
            -->
        </td>
    </tr>
    <tr>
        <th colspan="2">{$LNG.ow_support}</th>
    </tr>
    <tr>
        <td colspan="2"><a href="http://code.google.com/p/2moons/" target="_blank">Project Homepage</a><br>
        <a href="http://code.google.com/p/2moons/source/list" target="_blank">SVN Revision List</a><br>
		<a href="http://www.titanspace.org/" target="_blank">Offical Betauni</a><br>
		<a target="_blank" href="http://2moons.cc/" target="_blank">2moons.cc - {$LNG.ow_forum}</a></td>
    </tr>
    <!--
	<tr>
		<th style="width:50%;">{$LNG.ow_donate} - Paypal</th>
		<th style="width:50%;">{$LNG.ow_donate} - Moneybookers</th>
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
		<img src="http://www.moneybookers.com/images/logos/additional_logos/de_donatewith.gif" style="background:transparent;border:0px none;">
		<form action="https://www.moneybookers.com/app/payment.pl" target="_blank">
		<input type="hidden" name="pay_to_email" value="slaver7@gmail.com">
		<input type="hidden" name="recipient_description" value="Donation for 2Moons">
		<input type="hidden" name="return_url_target" value="1">
		<input type="hidden" name="cancel_url_target" value="1">
		<input type="hidden" name="dynamic_descriptor" value="Descriptor">
		<input type="hidden" name="language" value="DE">
		<input type="hidden" name="confirmation_note" value="Thank you for this Donation">
		<input type="hidden" name="detail1_description" value="Donation">
		<input type="hidden" name="detail1_text" value="Thank you for this donation!">
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
	-->
	<tr>
		<th colspan="2">{$LNG.ow_updates}</th>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<div id="feed"></div>
		</td>
	</tr>
    <!--
	<tr>
		<th colspan="2"><a href="https://www.facebook.com/2Moons.Game">{$LNG.ow_news}</a></th>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<div id="news"></div>
		</td>
	</tr>
    -->
    <tr>
    	<th colspan="2">{$LNG.ow_credits}</th>
    </tr>
    <tr>
    	<td colspan="2">
            <table align="center">
                <tr>
					<td class="transparent" colspan="3"><h3>{$LNG.ow_proyect_leader}</h3></td>
                </tr>
                <tr>
					<td class="transparent" colspan="3"><h3><a target="_blank" href="http://2moons.cc/user/5-jan/" style="color:red">Jan</a></h3></td>
                </tr>
			</table>
			<div style="width:100%">
				<div style="float:left;width:33%;min-width:250px;">
					<table>
						<tr>
							<td class="transparent"><p>&nbsp;</p><h3>{$LNG.ow_developers}</h3></td>
						</tr>
						<tr>
							<td class="transparent">
								<a target="_blank" href="http://2moons.cc/user/5-jan/" style="color:red">Jan</a><br>
								<a target="_blank" href="http://2moons.cc/user/2655-megger/" style="color:red">Megger</a><br>
								<a target="_blank" href="http://2moons.cc/user/88-fc92/" style="color:red">FC92</a>
							</td>
						</tr>
					</table>
				</div>
				<div style="float:left;width:33%;min-width:250px;">
					<table>
						<tr>
							<td class="transparent"><p>&nbsp;</p><h3>{$LNG.ow_translator}</h3></td>
						</tr>
						<tr>
							<td class="transparent">
								<table width="250px;">
								<tr>
									<td class="transparent">
										<a target="_blank" href="http://2moons.cc/user/100-qwatakayean/" target="_blank">QwataKayean</a>
									</td>
									<td class="transparent">
										<img src="styles/resource/images/login/flags/us.png" alt="(english)">
									</td>
								</tr>
								<tr>
									<td class="transparent">
										<a target="_blank" href="http://2moons.cc/user/100-qwatakayean/" target="_blank">QwataKayean</a>
									</td>
									<td class="transparent">
										<img src="styles/resource/images/login/flags/pt.png" alt="(portuguese)">
									</td>
								</tr>
								<tr>
									<td class="transparent">
										<a target="_blank" href="http://2moons.cc/user/98-inquisitorea/" target="_blank">InquisitorEA</a>
									</td>
									<td class="transparent">
										<img src="styles/resource/images/login/flags/ru.png" alt="(russian)">
									</td>
								</tr>
								<tr>
									<td class="transparent">
										<a target="_blank" href="http://2moons.cc/user/64-orion/">Orion</a>
									</td>
									<td class="transparent">
										<img src="styles/resource/images/login/flags/es.png" alt="(spanish)">
									</td>
								</tr>
								<tr>
									<td class="transparent">
										<a target="_blank" href="http://2moons.cc/user/3299-romansmac/">romansmac</a>
									</td>
									<td class="transparent">
										<img src="styles/resource/images/login/flags/tr.png" alt="(turkish)">
									</td>
								</tr>
								</table>
							</td>
						</tr> 
					</table>
				</div>
				<div style="float:left;width:33%;min-width:250px;">
					<table>
						<tr>
							<td class="transparent"><p>&nbsp;</p><h3>{$LNG.ow_special_thanks}</h3></td>
						</tr>
						<tr>
							<td class="transparent">
								<table width="250px;">
								<tr>
									<td class="transparent left">Ralf M.</td>
									<td class="transparent left">InquisitorEA</td>
									<td class="transparent left">lucky</td>
								</tr>
								<tr>
									<td class="transparent left">Metusalem</td>
									<td class="transparent left">Meikel</td>
									<td class="transparent left">Phil</td>
								</tr>
								<tr>
									<td class="transparent left">Schnippi</td>
									<td class="transparent left">Vobi</td>
									<td class="transparent left">Sycrog</td>
								</tr>
								<tr>
									<td class="transparent left">Raito</td>
									<td class="transparent left">Chlorel</td>
									<td class="transparent left">e-Zobar</td>
								</tr>
								<tr>
									<td class="transparent left">Flousedid</td>
									<td class="transparent left">jstar</td>
									<td class="transparent left">scrippi</td>
								</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>
        </td>
    </tr>
</table>
</center>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("feeds", "1");
google.setOnLoadCallback(initialize);
function initialize() {
	var feedControl = new google.feeds.FeedControl();
	feedControl.addFeed("https://github.com/jkroepke/2Moons/commits/master.atom", "");
	//feedControl.addFeed("http://code.google.com/feeds/p/2moons/svnchanges/basic", "");
	feedControl.draw(document.getElementById("feed"));
	var feedControl = new google.feeds.FeedControl();
	feedControl.addFeed("https://www.facebook.com/feeds/page.php?id=129282307106646&format=rss20", "");
	feedControl.draw(document.getElementById("news"));
}
</script>
{include file="overall_footer.tpl"}