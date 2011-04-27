{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
    <form action="" method="post">
    <table width="50%" align="center">
    <tbody>
    <tr>
        <th colspan="5">{$Production_of_resources_in_the_planet}</th>
    </tr><tr style="height:22px">
        <td>&nbsp;</td>
        <td style="width:10%">{$Metal}</td>
        <td style="width:10%">{$Crystal}</td>
        <td style="width:10%">{$Deuterium}</td>
        <td style="width:10%">{$Energy}</td>
    </tr><tr style="height: 22px">
        <td>{$rs_basic_income}</td>
        <td>{$metal_basic_income}</td>
        <td>{$crystal_basic_income}</td>
        <td>{$deuterium_basic_income}</td>
        <td>{$energy_basic_income}</td>
    </tr>
    {foreach item=CurrPlanetInfo from=$CurrPlanetList}
	<tr style="height:22px">
		<td>{$CurrPlanetInfo.type} ({$CurrPlanetInfo.level} {$CurrPlanetInfo.level_type})</td>
		<td style="color:#ffffff">{$CurrPlanetInfo.metal_type}</td>
		<td style="color:#ffffff">{$CurrPlanetInfo.crystal_type}</td>
		<td style="color:#ffffff">{$CurrPlanetInfo.deuterium_type}</td>
		<td style="color:#ffffff">{$CurrPlanetInfo.energy_type}</td>
		<td style="width:5%;">
			{html_options name=$CurrPlanetInfo.name options=$option selected=$CurrPlanetInfo.optionsel}
		</td>
	</tr>
    {/foreach}
    <tr style="height:22px">
        <td>{$rs_ress_bonus}</td>
        <td>{$bonus_metal}</td>
        <td>{$bonus_crystal}</td>
        <td>{$bonus_deuterium}</td>
        <td>{$bonus_energy}</td>
        <td><input name="action" value="{$rs_calculate}" type="submit"></td>
    </tr><tr style="height:22px">
        <td>{$rs_storage_capacity}</td>
        <td>{$metalmax}</td>
        <td>{$crystalmax}</td>
        <td>{$deuteriummax}</td>
        <td>-</td>
    </tr><tr style="height:22px">
        <td>{$rs_sum}:</td>
        <td>{$metal_total}</td>
        <td>{$crystal_total}</td>
        <td>{$deuterium_total}</td>
        <td>{$energy_total}</td>
    </tr>
    <tr style="height:22px">
        <td>{$rs_daily}</td>
        <td>{$daily_metal}</td>
        <td>{$daily_crystal}</td>
        <td>{$daily_deuterium}</td>
        <td>{$energy_total}</td>
    </tr style="height:22px">
    <tr>
        <td>{$rs_weekly}</td>
        <td>{$weekly_metal}</td>
        <td>{$weekly_crystal}</td>
        <td>{$weekly_deuterium}</td>
        <td>{$energy_total}</td>
    </tr>
    </tbody>
    </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}