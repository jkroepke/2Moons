{include file="adm/overall_header.tpl"}
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
    </tr>
	<tr>
    	<th style="height:50px"><div align="justify">{$ow_welcome_text}</div></th>
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
		<td class="c">Spenden</td>
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
{include file="adm/overall_footer.tpl"}