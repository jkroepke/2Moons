{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<form id="battlesim" name="battlesim">
<input type="hidden" name="slots" id="slots" value="{$Slots + 1}">
<table style="width:80%">
<tr><th>{$lm_battlesim}</th></tr>
<tr><td class="c" style="text-align:center;">{$bs_steal} {$Metal}: <input type="text" size="10" value="{if $battleinput.0.1.1}{$battleinput.0.1.1}{else}0{/if}" name="battleinput[0][1][1]"> {$Crystal}: <input type="text" size="10" value="{if $battleinput.0.1.2}{$battleinput.0.1.2}{else}0{/if}" name="battleinput[0][1][2]"> {$Deuterium}: <input type="text" size="10" value="{if $battleinput.0.1.3}{$battleinput.0.1.3}{else}0{/if}" name="battleinput[0][1][3]"></td></tr>
<tr><td class="c"><input type="button" onClick="return add();" value="Add AKS-Slot"></td></tr>
<tr>
<td>
<div id="tabs">
<ul>
{section name=tab start=0 loop=$Slots}<li><a href="#tabs-{$smarty.section.tab.index}">AKS-Slot {$smarty.section.tab.index + 1}</a></li>{/section}
</ul>
{section name=content start=0 loop=$Slots}
<div id="tabs-{$smarty.section.content.index}">
<table>
<tr><td class="c">{$bs_techno}</td><td class="c">{$bs_atter}</td><td class="c">{$bs_deffer}</td></tr>
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
<tr><td class="c">{$bs_names}</td><td class="c">{$bs_atter}</td><td class="c">{$bs_deffer}</td></tr>
{foreach item=name key=id from=$GetFleet}
<tr>
<td>{$name}:</td><td><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.0.$id}{$battleinput.{$smarty.section.content.index}.0.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][{$id}]"></td><td><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.$id}{$battleinput.{$smarty.section.content.index}.1.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][{$id}]"></td>
</tr>
{/foreach}
</table>
</td>{if $smarty.section.content.index == 0}<td style="width:50%" class="transparent">
<table>
<tr><td class="c">{$bs_names}</td><td class="c">{$bs_atter}</td><td class="c">{$bs_deffer}</td></tr>
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