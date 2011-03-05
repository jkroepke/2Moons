{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table style="min-width:590px;width:590px;">
<tbody>
<tr><td colspan="3" class="c" style="text-align:center;">{$update}</td></tr>
{foreach item=Elementlist key=Section from=$Records}
<tr>
<th style="width:199px">{$Section}</th>
<th style="width:203px">{$player}</th>
<th style="width:172px">{$level}</th>
</tr>
{foreach item=ElementInfo key=ElementName from=$Elementlist}
<tr>
<td style="width:199px">{$ElementName}</td>
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