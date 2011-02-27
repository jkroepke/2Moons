{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table>
	<tr>
		<th>{$faq_overview}</th>
	</tr>
	{foreach key=Question item=Answer from=$FAQList}
	<tr>
		<th>{$Question}</th>
	</tr>
	<tr>
		<td class="left">
		{$Answer}
		</td>
	</tr>
	{/foreach}
</table>
<br>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}