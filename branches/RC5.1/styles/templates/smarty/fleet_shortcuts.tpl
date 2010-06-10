{include file="overall_header.tpl"}
<table border="0" cellpadding="0" cellspacing="1" width="519" align="center">
<tr height="20">
<td class="c" colspan="2">{$fl_shortcuts} (<a href="?page=shortcuts&mode=add">{$fl_shortcut_add}</a>)</td>
</tr>
{foreach name=ShortCuts key=id item=short from=$ShortCuts}
{if $smarty.foreach.ShortCuts.iteration is odd}<tr style="height:20px;">{/if}			
<th><a href="?page=shortcuts&a={$id}">{$short.name} [{$short.galaxy}:{$short.system}:{$short.planet}] {if $short.type == 1}{$fl_planet_shortcut}{elseif $short.type == 2}{$fl_debris_shortcut}{else}{$fl_moon_shortcut}{/if}
{if $smarty.foreach.ShortCuts.last && $smarty.foreach.ShortCuts.total is odd && $smarty.foreach.ShortCuts.total != 1}<th>&nbsp;</th>{/if}
{if $smarty.foreach.ShortCuts.iteration is even}</tr>{/if}
{foreachelse}
<th colspan="2">{$fl_no_shortcuts}</th>
{/foreach}
<tr><td class="c" colspan="2"><a href="javascript:opener.window.location.reload();window.close();">{$fl_back}</a></td></tr></tr></table>
{include file="overall_footer.tpl"}