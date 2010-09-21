{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table class="table569">
<tbody>
<tr>
    <th colspan="4">{$tkb_top}</th>
</tr><tr>
    <td colspan="4">
        {$tkb_gratz}
    </td>
</tr><tr>
    <td>{$tkb_platz}</td>
	<td>{$tkb_owners}</td>
    <td>{$tkb_datum}</td>
	<td>{$tkb_units}</td>
</tr>
{foreach item=RowInfo key=RowNR from=$TopKBList}
<tr>
    <td>{$RowNR + 1}</td>
    <td><a href="game.php?page=topkb&amp;action=showkb&amp;rid={$RowInfo.rid}" onclick="OpenPopup('game.php?page=topkb&mode=showkb&rid={$RowInfo.rid}', 'raport', screen.width, screen.height);return false;">
	{if $RowInfo.result == "a"}
	<span style="color:#00FF00">{$RowInfo.attacker}</span> VS <span style="color:#FF0000">{$RowInfo.defender}</span>
	{elseif $RowInfo.result == "r"}
	<span style="color:#FF0000">{$RowInfo.attacker}</span> VS <span style="color:#00FF00">{$RowInfo.defender}</span>
	{else}
	{$RowInfo.attacker} VS {$RowInfo.defender}
	{/if}
	</a></td>
    <td>{$RowInfo.time}</td>
	<td>{$RowInfo.units}</td>
</tr>
{/foreach}
<tr>
<td colspan="4">{$tkb_legende}<span style="color:#00FF00">{$tkb_gewinner}</span><span style="color:#FF0000">{$tkb_verlierer}</span></td></tr>
</tbody>
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}