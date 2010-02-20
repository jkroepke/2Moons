<tr>
    <th width="30">16</th>
    <th colspan="7">
    <a href="game.php?page=fleet&galaxy={galaxy}&amp;system={system}&amp;planet=16&amp;planettype=1&amp;target_mission=15">{gl_out_space}</a>
    </th>
</tr>
<tr>
    <td class=c colspan="6">( {planetcount} )</td>
    <td class=c colspan="2">
        <a href="#" style="cursor: pointer;" onmouseover='return overlib("<table width=240><tr><td class=c colspan=2>{gl_legend}</td></tr><tr><td width=220>{gl_strong_player}</td><td><span class=strong>{gl_s}</span></td></tr><tr><td width=220>{gl_week_player}</td><td><span class=noob>{gl_w}</span></td></tr><tr><td width=220>{gl_vacation}</td><td><span class=vacation>{gl_v}</span></td></tr><tr><td width=220>{gl_banned}</td><td><span class=banned>{gl_b}</span></td></tr><tr><td width=220>{gl_inactive_seven}</td><td><span class=inactive>{gl_i}</span></td></tr><tr><td width=220>{gl_inactive_twentyeight}</td><td><span class=longinactive>{gl_I}</span></td></tr></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -150, OFFSETY, -150 );' onmouseout='return nd();'>{gl_legend}</a> 
    </td>
</tr>
<tr>
    <td class=c colspan="3"><span id="missiles">{currentmip}</span> {gl_avaible_missiles}</td>
    <td class=c colspan="3"><span id="slots">{maxfleetcount}</span>/{fleetmax} {gl_fleets}</td>
    <td class=c colspan="2">
		<span id="recyclers">{recyclers}</span> {gl_avaible_recyclers}<br>
		<span id="probes">{spyprobes}</span> {gl_avaible_spyprobes}</td>
</tr>
<tr style="display: none;" id="fleetstatusrow">
    <th class=c colspan="8">
		<table style="font-weight: bold" width="100%" id="fleetstatustable">
			<!-- will be filled with content later on while processing ajax replys -->
		</table>
	</th>
</tr>