{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <table>
        <tbody>
            <tr>
                <th colspan="{$colspan}">{$iv_imperium_title}</th>
            </tr>
            <tr>
                <td style="width:{100/$colspan}%;">{$iv_planet}</td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
				<td style="width:{100/$colspan}%;"><a href="game.php?page=overview&amp;cp={$PlanetsInfoRow.InfoList.id}&amp;re=0"><img width="80" height="80" border="0" src="{$dpath}planeten/small/s_{$PlanetsInfoRow.InfoList.image}.jpg" alt="{$PlanetsInfoRow.InfoList.name}"></a></td>
				{/foreach}
            </tr>
            <tr>
				<td>{$iv_name}</td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<td>{$PlanetsInfoRow.InfoList.name}</td>
				{/foreach}
            </tr>
            <tr>
				<td>{$iv_coords}</td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$PlanetsInfoRow.InfoList.galaxy}&amp;system={$PlanetsInfoRow.InfoList.system}">[{$PlanetsInfoRow.InfoList.galaxy}:{$PlanetsInfoRow.InfoList.system}:{$PlanetsInfoRow.InfoList.planet}]</a></td>
				{/foreach}
            </tr>
            <tr>
				<td>{$iv_fields}</td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<td>{$PlanetsInfoRow.InfoList.field_current}/{$PlanetsInfoRow.InfoList.field_max}</td>
				{/foreach}
			</tr>
            <tr>
				<th colspan="{$colspan}">{$iv_resources}</th>
            </tr>
            <tr>
				<td>{$Metal}</td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<td>{$PlanetsInfoRow.InfoList.metal}</td>
				{/foreach}
			</tr>
            <tr>
				<td>{$Crystal}</td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<td>{$PlanetsInfoRow.InfoList.crystal}</td>
				{/foreach}
			</tr>
            <tr>
				<td>{$Deuterium}</td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<td>{$PlanetsInfoRow.InfoList.deuterium}</td>
				{/foreach}
			</tr>
            <tr>
				<td>{$Energy}</td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<td>{$PlanetsInfoRow.InfoList.energy_used}/{$PlanetsInfoRow.InfoList.energy_max}</td>
				{/foreach}
            </tr>
			<tr>
                <th colspan="{$colspan}">{$iv_buildings}</th>
            </tr>
				{foreach item=Builds from=$build}
					<tr>
					<td>{$tech.$Builds}</td>
					{foreach item=PlanetsInfoRow from=$PlanetsList}
						<td>{$PlanetsInfoRow.BuildsList.$Builds}</td>
					{/foreach}
					</tr>
				{/foreach}
			<tr>
                <th colspan="{$colspan}">{$iv_technology}</th>
			</tr>
				{foreach item=Researchs from=$research}
					<tr>
					<td>{$tech.$Researchs}</td>
					{foreach item=PlanetsInfoRow from=$PlanetsList}
						<td>{$ResearchList.$Researchs}</td>
					{/foreach}
					</tr>
				{/foreach}
            <tr>
                <th colspan="{$colspan}">{$iv_ships}</th>
            </tr>
				{foreach item=Fleets from=$fleet}
					<tr>
					<td>{$tech.$Fleets}</td>
					{foreach item=PlanetsInfoRow from=$PlanetsList}
						<td>{$PlanetsInfoRow.FleetsList.$Fleets}</td>
					{/foreach}
					</tr>
				{/foreach}
            <tr>
                <th colspan="{$colspan}">{$iv_defenses}</th>
            </tr>
				{foreach item=Defenses from=$defense}
					<tr>
					<td>{$tech.$Defenses}</td>
					{foreach item=PlanetsInfoRow from=$PlanetsList}
						<td>{$PlanetsInfoRow.DefensesList.$Defenses}</td>
					{/foreach}
					</tr>
				{/foreach}
        </tbody>
    </table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}