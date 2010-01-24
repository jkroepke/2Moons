{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content">
<table width="590" align="center">
<tbody>
<tr><td colspan="3" class="c" style="text-align:center;">{$update}</td></tr>
{foreach item=Elementlist key=Section from=$Records}
<tr>
<td width="199" class="c">{$Section}</td>
<td width="203" class="c">{$player}</td>
<td width="172" class="c">{$level}</td>
</tr>
{foreach item=ElementInfo key=ElementName from=$Elementlist}
<tr>
<th width="199" class="a">{$ElementName}</th>
<th width="203" class="a">{$ElementInfo.winner}</th>
<th width="172" class="a">{$ElementInfo.count}</th>
</tr>
{/foreach}
{/foreach}
</tbody>
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}