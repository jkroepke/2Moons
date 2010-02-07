<div id="header_top">
<center>
<table class="header" align="center">
<tr class="header">
<td class="header" style="width: 150px;">
<table class="header">
<tr class="header">
<td class="header" style="width: 50px;"><img src="{$dpath}planeten/small/s_{$image}.jpg" height="50" width="50" alt="Planetenbild"></td> 
<td class="header">	  
<select size="1" onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
{html_options values=$SelectorVaules output=$SelectorNames selected=$current_panet}
</select>
</td>
</tr>
</table></td>
<td class="header">   <table class="header" id='resources' border="0" cellspacing="0" cellpadding="0">

	    <tr class="header">
	    
		     <td align="center" width="85" class="header">
		      <img border="0" src="{$dpath}images/metall.gif" width="42" height="22" alt="{$Metal}">
		     </td>
		     
		     <td align="center" width="85" class="header">
		      <img border="0" src="{$dpath}images/kristall.gif" width="42" height="22" alt="{$Crystal}">
		     </td>
		     
		     <td align="center" width="85" class="header">
		      <img border="0" src="{$dpath}images/deuterium.gif" width="42" height="22" alt="{$Deuterium}">
		     </td>
	     		     
		     <td align="center" width="85" class="header">
		      <img border="0" src="{$dpath}images/darkmatter.gif" width="42" height="22" alt="{$Darkmatter}">
		     </td>	     
	        		     
		     <td align="center" width="85" class="header">
		      <img border="0" src="{$dpath}images/energie.gif" width="42" height="22" alt="{$Energy}">
		     </td>
	    </tr>
        
        <tr class="header">
            <td align="center" class="header" width="85"><b><font color="#FFFF00">{$Metal}</font></b></td>
            <td align="center" class="header" width="85"><b><font color="#FFFF00">{$Crystal}</font></b></td>
            <td align="center" class="header" width="85"><b><font color="#FFFF00">{$Deuterium}</font></b></td>
            <td align="center" class="header" width="85"><b><font color="#FFFF00">{$Darkmatter}</font></b></td>    
            <td align="center" class="header" width="85"><b><font color="#FFFF00">{$Energy}</font></b></td>
        </tr>
        <tr class="header">
            <td align="center" class="header" width="90" id="current_metal">{$metal}</td>
            <td align="center" class="header" width="90" id="current_crystal">{$crystal}</td>
            <td align="center" class="header" width="90" id="current_deuterium">{$deuterium}</td>
            <td align="center" class="header" width="90">{$darkmatter}</td>
            <td align="center" class="header" width="90">{$energy}</td>
        </tr>
        <tr class="header">
            <td align="center" class="header" width="90"><font color="#00FF00">{$metal_max}</font></td>
            <td align="center" class="header" width="90"><font color="#00FF00">{$crystal_max}</font></td>
            <td align="center" class="header" width="90"><font color="#00FF00">{$deuterium_max}</font></td>
            <td align="center" class="header" width="90"></td>
            <td align="center" class="header" width="90"></td>
        </tr>
 </table></td>
</tr>
</table>
{if $delete}
<table width="70%" id="infobox" style="border: 3px solid red; text-align:center;"><tr><td>{$tn_delete_mode} {$delete}</td></tr></table>
{elseif $vacation}
<table width="70%" id="infobox" style="border: 3px solid red; text-align:center;"><tr><td>{$tn_vacation_mode} {$vacation}</td></tr></table>
{/if}
</center>
</div>
<script type="text/javascript" src="scripts/topnav.js"></script>
<script type="text/javascript">
met			= parseInt($("#current_metal").text().replace(/\./g,""));
cry			= parseInt($("#current_crystal").text().replace(/\./g,""));
deu 		= parseInt($("#current_deuterium").text().replace(/\./g,""));
met_max 	= "{$metal_max}".replace(/\./g,"");
cry_max 	= "{$crystal_max}".replace(/\./g,"");
deu_max 	= "{$deuterium_max}".replace(/\./g,"");
met_hr		= {$js_metal_hr};
cry_hr		= {$js_crystal_hr};
deu_hr		= {$js_deuterium_hr};
res_factor	= {$js_res_multiplier};

update();
</script>