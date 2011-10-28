{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
    <form name="stats" id="stats" method="post" action="">
        <table class="table519">
            <tr>
				<th>{lang}st_statistics{/lang}({lang}st_updated{/lang}: {$stat_date})</th>
            </tr>
            <tr>
                <td>{lang}st_show{/lang} <select name="who" onChange="$('#stats').submit();">{html_options options=$Selectors.who selected=$who}</select> {lang}st_per{/lang} <select name="type" onChange="$('#stats').submit();">{html_options options=$Selectors.type selected=$type}</select> {lang}st_in_the_positions{/lang} <select name="range" onChange="$('#stats').submit();">{html_options options=$Selectors.range selected=$range}</select></td>
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