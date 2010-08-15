{include file="overall_header.tpl"}
<table style="width:95%;">
<tr style="height:20px">
<th colspan="2">{$fl_shortcuts} (<a href="?page=shortcuts&mode=add">{$fl_shortcut_add}</a>)</th>
</tr>
{foreach name=ShortCuts key=id item=short from=$ShortCuts}
{if $smarty.foreach.ShortCuts.iteration is odd}<tr style="height:20px;">{/if}			
<td><a href="?page=shortcuts&a={$id}">{$short.name} [{$short.galaxy}:{$short.system}:{$short.planet}] {if $short.type == 1}{$fl_planet_shortcut}{elseif $short.type == 2}{$fl_debris_shortcut}{else}{$fl_moon_shortcut}{/if}</td>
{if $smarty.foreach.ShortCuts.last && $smarty.foreach.ShortCuts.total is odd && $smarty.foreach.ShortCuts.total != 1}<td>&nbsp;</td>{/if}
{if $smarty.foreach.ShortCuts.iteration is even}</tr>{/if}
{foreachelse}
<td colspan="2">{$fl_no_shortcuts}</td>
{/foreach}
<tr><th colspan="2"><a href="javascript:opener.window.location.reload();window.close();">{$fl_back}</a></th></tr></table>
{include file="overall_footer.tpl"}