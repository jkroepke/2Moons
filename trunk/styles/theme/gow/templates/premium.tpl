{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table style="width:50%" align="center">
    <tr>
    	<th colspan="4">{$premium}</th>
    </tr>
    {if $premium_aktiv == 0}
        <tr>
            <td colspan="4">{$premium} {$deaktiv}</td>
        </tr>
    {else}
        <tr>
            <td colspan="4">{$premium} {$aktiv}</td>
        </tr>
    {/if}
    <tr>
        <td>{$premium_zeit}</td>
        <td colspan="3">{$premium_zeits}{$premium_deaktiv}</td>
    </tr>
    <tr>
        <td>{$ov_reflink}</td>
        <td colspan="3"><input type="text" size="65" name="reflink" value="{$user_reflink}" /></td>
    </tr>
    <tr>
        <td>{$premium_ress}</td>
        <td colspan="3"><center>{$um} <b>{$mehr_ress}% {$erweitert}</b></center></td>
    </tr>
    <tr>
    	<td>{$premium_build}</td>
    	<td colspan="3"><center>{$verringert}<b>{$weniger_build}%</b> {$niedriger}</center></td>
    </tr>
    <tr>
        <td>{$premium_defense}</td>
        <td colspan="3"><center>{$verringert}<b>{$weniger_defense}% </b>{$niedriger} </center></td>
    </tr>
    <tr>
        <td>{$premium_fleet}</td>
        <td colspan="3"><center>{$verringert}<b>{$weniger_fleet}% </b>{$niedriger} </center></td>
    </tr>
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}