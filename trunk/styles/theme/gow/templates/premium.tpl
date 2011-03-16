{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table style="width:50%">
    <tr>
    	<th colspan="4">{$premiums}</th>
    </tr>
        <tr>
            <td colspan="4">{$premium}</td>
        </tr>
    <tr>
        <td>{$premium_zeit}</td>
        <td colspan="3">{$premium_aktiv}</td>
    </tr>
    <tr>
        <td>{$ov_reflink}</td>
        <td colspan="3"><input type="text" size="65" name="reflink" value="{$user_reflink}" /></td>
    </tr>
    <tr>
        <td>{$premium_ress}</td>
        <td colspan="3">{$mehr_ress}</b></td>
    </tr>
    <tr>
    	<td>{$premium_build}</td>
    	<td colspan="3">{$bauzeit_building}</td>
    </tr>
    <tr>
        <td>{$premium_defense}</td>
        <td colspan="3">{$bauzeit_defense} </td>
    </tr>
    <tr>
        <td>{$premium_fleet}</td>
        <td colspan="3">{$bauzeit_fleet} </td>
    </tr>
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}