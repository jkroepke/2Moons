{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
<table style="min-width:590px;width:590px;">
<tbody>
<tr><th colspan="3" style="text-align:center;">{lang}rec_last_update_on{/lang}: {$update}</th></tr>
{foreach item=Elementlist key=Section from=$Records}
<tr>
<th style="width:199px">{lang}rec_{$Section}{/lang}</th>
<th style="width:203px">{lang}rec_players{/lang}</th>
<th style="width:172px">{lang}rec_level{/lang}</th>
</tr>
{foreach item=ElementInfo key=ElementID from=$Elementlist}
<tr>
<td style="width:199px">{lang}tech.{$ElementID}{/lang}</td>
<td style="width:203px">{$ElementInfo.winner}</td>
<td style="width:172px">{$ElementInfo.count}</td>
</tr>
{/foreach}
{/foreach}
</tbody>
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}