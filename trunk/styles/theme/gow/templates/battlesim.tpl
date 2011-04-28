{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
<form id="battlesim" name="battlesim">
<input type="hidden" name="slots" id="slots" value="{$Slots + 1}">
<table style="width:80%">
<tr><th>{$lm_battlesim}</th></tr>
<tr><td>{$bs_steal} {$Metal}: <input type="text" size="10" value="{if $battleinput.0.1.1}{$battleinput.0.1.1}{else}0{/if}" name="battleinput[0][1][1]"> {$Crystal}: <input type="text" size="10" value="{if $battleinput.0.1.2}{$battleinput.0.1.2}{else}0{/if}" name="battleinput[0][1][2]"> {$Deuterium}: <input type="text" size="10" value="{if $battleinput.0.1.3}{$battleinput.0.1.3}{else}0{/if}" name="battleinput[0][1][3]"></td></tr>
<tr><td class="left"><input type="button" onClick="return add();" value="{$bs_add_acs_slot}"></td></tr>
<tr>
<td class="transparent" style="padding:0;">
<div id="tabs">
<ul>
{section name=tab start=0 loop=$Slots}<li><a href="#tabs-{$smarty.section.tab.index}">{$bs_acs_slot} {$smarty.section.tab.index + 1}</a></li>{/section}
</ul>
{section name=content start=0 loop=$Slots}
<div id="tabs-{$smarty.section.content.index}">
<table>
<tr><th>{$bs_techno}</td><th>{$bs_atter}</th><th>{$bs_deffer}</th></tr>
<tr>
<td>{$attack_tech}:</td><td><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.0.109}{$battleinput.{$smarty.section.content.index}.0.109}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][109]"></td><td><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.109}{$battleinput.{$smarty.section.content.index}.1.109}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][109]"></td>
</tr>
<tr>
<td>{$shield_tech}:</td><td><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.0.110}{$battleinput.{$smarty.section.content.index}.0.110}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][110]"></td><td><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.110}{$battleinput.{$smarty.section.content.index}.1.110}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][110]"></td>
</tr>
<tr>
<td>{$tank_tech}:</td><td><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.0.111}{$battleinput.{$smarty.section.content.index}.0.111}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][111]"></td><td><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.111}{$battleinput.{$smarty.section.content.index}.1.111}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][111]"></td>
</tr>
</table>
<br>
<table>
<tr><td class="transparent">
<table>
<tbody>
<tr><th>{$bs_names}</th><th>{$bs_atter}</th><th>{$bs_deffer}</th></tr>
{foreach item=name key=id from=$GetFleet}
<tr>
<td>{$name}:</td><td><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.0.$id}{$battleinput.{$smarty.section.content.index}.0.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][{$id}]"></td><td><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.$id}{$battleinput.{$smarty.section.content.index}.1.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][{$id}]"></td>
</tr>
{/foreach}
</table>
</td>{if $smarty.section.content.index == 0}<td style="width:50%" class="transparent">
<table>
<tr><th>{$bs_names}</td><th>{$bs_atter}</th><th>{$bs_deffer}</th></tr>
{foreach item=name key=id from=$GetDef}
<tr>
<td>{$name}:</td><td>-</td><td><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.$id}{$battleinput.{$smarty.section.content.index}.1.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][{$id}]"></td>
</tr>
{/foreach}
</tbody>
</table>
</td>{/if}</tr></table>
</div>
{/section}
</div>
</td>
</tr>
<tr id="submit">
<td><input type="button" onClick="return check();" value="{$bs_send}">&nbsp;<input type="reset" value="{$bs_cancel}"></td>
</tr>
<tr id="wait" style="display:none;">
<td style="height:20px">{$bs_wait}</td>
</tr>
</table>
<br>
<br>
</form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}