{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table width="80%" align="center">
<tbody>
<tr><td class="c">{$faq_overview}</td></tr>
{foreach key=Question item=Answer from=$FAQList}
<tr>
<td class="b"><span style="font-weight:bold;">{$Question}</span>
<br>
<br>
{$Answer}
</td>
</tr>
{/foreach}
</tbody>
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}