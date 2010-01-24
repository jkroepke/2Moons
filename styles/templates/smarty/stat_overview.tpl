{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content">
    <form name="stats" method="post" action="">
        <table width="519" align="center">
            <tr>
               <td colspan="6" class="c">{$st_statistics}({$st_updated}: {$stat_date})</td>
            </tr>
            <tr>
                <th colspan="6" class="c">{$st_show} <select name="who" onChange="javascript:document.stats.submit()">{html_options options=$Selectors.who selected=$who}</select> {$st_per} <select name="type" onChange="javascript:document.stats.submit()">{html_options options=$Selectors.type selected=$type}</select> {$st_in_the_positions} <select name="range" onChange="javascript:document.stats.submit()">{html_options options=$Selectors.range selected=$range}</select></th>
            </tr>
        </table>
    </form>
    <table width="519" align="center">
	{if $who == 1}
		{include file="stat_playertable.tpl"}
 	{elseif $who == 2}
		{include file="stat_alliancetable.tpl"}
	{/if}
	</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}