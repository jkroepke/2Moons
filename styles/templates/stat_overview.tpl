{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <form name="stats" id="stats" method="post" action="">
        <table class="table519">
            <tr>
				<th>{$st_statistics}({$st_updated}: {$stat_date})</th>
            </tr>
            <tr>
                <td>{$st_show} <select name="who" onChange="$('#stats').submit();">{html_options options=$Selectors.who selected=$who}</select> {$st_per} <select name="type" onChange="$('#stats').submit();">{html_options options=$Selectors.type selected=$type}</select> {$st_in_the_positions} <select name="range" onChange="$('#stats').submit();">{html_options options=$Selectors.range selected=$range}</select></td>
            </tr>
        </table>
    </form>
    <table class="table519">
	{if $who == 1}
		{include file="stat_playertable.tpl"}
 	{elseif $who == 2}
		{include file="stat_alliancetable.tpl"}
	{/if}
	</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}